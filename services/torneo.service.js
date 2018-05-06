// Config
var config = require('config.json');
var _ = require('lodash');
var jwt = require('jsonwebtoken');
var bcrypt = require('bcryptjs');
var Q = require('q');
var ObjectId = require('mongodb').ObjectID;

// BD
var mongo = require('mongoskin');
var db = mongo.db(config.connectionString, { native_parser: true });
db.bind('torneos');

// Services
var service = {};
service.getAll = getAll;
service.getById = getById;
service.create = create;
service.getCreando = getCreando;
service.delete = _delete;

// Exports
module.exports = service;

/**
 * Function to get all torneos from the DB
 */
function getAll() {
	var deferred = Q.defer();
	db.torneos.find().toArray(function (err, torneos) {
		if (err) deferred.reject(err.name + ': ' + err.message);
		// return torneos (without hashed passwords)
		torneos = _.map(torneos, function (torneo) {
			return _.omit(torneo, 'hash');
		});
		deferred.resolve(torneos);
	});
	return deferred.promise;
}

/**
 * Function to get at torneo from the DB
 */
function getById(_id) {
	var deferred = Q.defer();
	db.torneos.findById(_id, function (err, torneo) {
		if (err) deferred.reject(err.name + ': ' + err.message);
		if (torneo) {
			// return torneo (without hashed password)
			deferred.resolve(_.omit(torneo, 'hash'));
		} else {
			// torneo not found
			deferred.resolve();
		}
	});
	return deferred.promise;
}

/**
 * Function to get at torneo from the DB
 */
function getCreando() {
	var deferred = Q.defer();
	db.torneos.findOne({creando:true}, function (err, torneo) {
		if (err) deferred.reject(err.name + ': ' + err.message);
		if (torneo) {
			deferred.resolve(torneo);
		} else {
			deferred.resolve();
		}
	});
	return deferred.promise;
}
/**
 * Function to get add torneo to DB
 */
function create(torneoParam) {
	var deferred = Q.defer();
	// validation
	torneoParam._id
	db.torneos.findById(
		torneoParam._id,
		function (err, torneo) {
			if (err) deferred.reject(err.name + ': ' + err.message);
			if (torneo) {
					updatetorneo();
			} else {
					createtorneo();
				}
		}
	);

	function createtorneo() {
		db.torneos.insert(
			torneoParam,
			function (err, doc) {
				if (err) deferred.reject(err.title + ': ' + err.message);
				deferred.resolve();
		});
	}

	function updatetorneo() {
		var idT = torneoParam._id;
		delete torneoParam._id;
		db.torneos.update({_id: ObjectId(idT)},
			{$set:torneoParam},{},
			function (err, doc) {
				if (err) deferred.reject(err.title + ': ' + err.message);
				deferred.resolve();
		});
	}
	return deferred.promise;
}

/**
 * Function to delete torneo from the DB
 */
function _delete(_id) {
	var deferred = Q.defer();
	db.torneos.remove(
		{ _id: mongo.helper.toObjectID(_id) },
		function (err) {
			if (err) deferred.reject(err.title + ': ' + err.message);
			deferred.resolve();
		});
	return deferred.promise;
}