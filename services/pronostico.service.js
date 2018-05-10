// Config
var conf = require('config.json');
var _ = require('lodash');
var jwt = require('jsonwebtoken');
var bcrypt = require('bcryptjs');
var Q = require('q');

// BD
//var mongo = require('mongoskin');
//var db = mongo.db(config.connectionString, { native_parser: true });

var url = 'mongodb://' + conf.dbAuthusername + ':' + conf.dbAuthpassword + '@' + conf.databaseUrl;
var db  = require('mongoskin').db(url + '/' + conf.databaseName, {
    auto_reconnect : true,
    safe           : true
});


db.bind('pronosticos');

// Services
var service = {};
service.getAll = getAll;
service.getById = getById;
service.create = create;
service.delete = _delete;

// Exports
module.exports = service;

function getAll(user) {
	var deferred = Q.defer();
	db.pronosticos.find({user:user}).toArray(function (err, pronosticos) {
		if (err) deferred.reject(err.name + ': ' + err.message);
		// return pronosticos (without hashed passwords)
		pronosticos = _.map(pronosticos, function (movie) {
			return _.omit(movie, 'hash');
		});
		deferred.resolve(pronosticos);
	});
	return deferred.promise;
}

function getById(_id) {
	var deferred = Q.defer();
	db.pronosticos.findById(_id, function (err, movie) {
		if (err) deferred.reject(err.name + ': ' + err.message);
		if (movie) {
			// return movie (without hashed password)
			deferred.resolve(_.omit(movie, 'hash'));
		} else {
			// movie not found
			deferred.resolve();
		}
	});
	return deferred.promise;
}

function create(pronostico) {
	var deferred = Q.defer();
	// validation
	db.pronosticos.findOne(
		{ fecha: pronostico.fecha,user:pronostico.user },
		function (err, movie) {
			if (err) deferred.reject(err.name + ': ' + err.message);
			if (movie) {
					// title already exists
					deferred.reject('El pronostico ya se realizó');
			} else {
					createPronostico();
				}
		}
	);

	function createPronostico() {
		db.pronosticos.insert(
		pronostico,
		function (err, doc) {
			if (err) deferred.reject(err.title + ': ' + err.message);
			deferred.resolve();
		});
	}
	return deferred.promise;
}

/**
 * Function to delete movie from the DB
 */
function _delete(_id) {
	var deferred = Q.defer();
	db.pronosticos.remove(
		{ _id: mongo.helper.toObjectID(_id) },
		function (err) {
			if (err) deferred.reject(err.title + ': ' + err.message);
			deferred.resolve();
		});
	return deferred.promise;
}