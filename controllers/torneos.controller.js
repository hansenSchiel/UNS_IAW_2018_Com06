// Config
var config = require('config.json');
var express = require('express');
var router = express.Router();
var torneoService = require('services/torneo.service');

var passport = require('passport');

// routes
router.get('/', getAll);
router.get('/register', register);
router.get('/:id', getCurrent);
router.delete('/:_id', _delete);

// Export
module.exports = router;

/**
 * Function to get all torneos
 */
function getAll(req, res) {
	res.render("torneo/torneos.ejs",{"user":req.user,"page":"torneo"});
}

/**
 * Function to get current torneo
 */
function getCurrent(req, res) {
	res.render("torneo/torneo.ejs",{"user":req.user,"page":"torneo"});
}

/**
 * Function to get add torneo
 */
function register(req, res) {
	var torneo = torneoService.getCreando()
	.then(function (torneo) {
		if (torneo){
			if(torneo.creando==0){
				res.render("torneo/nuevoTorneo.ejs",{"user":req.user,"page":"torneo"});
			}
			if(torneo.creando==1){
				res.render("torneo/nuevoTorneo2.ejs",{"user":req.user,"page":"torneo"});
			}
			if(torneo.creando==2){
				res.render("torneo/nuevoTorneo3.ejs",{"user":req.user,"page":"torneo"});
			}
			if(torneo.creando==3){
				res.render("torneo/nuevoTorneo3.ejs",{"user":req.user,"page":"torneo"});
			}
		}else{
			res.render("torneo/nuevoTorneo.ejs",{"user":req.user,"page":"torneo"});
		}
		})
	.catch(function (err) {
		res.render("torneo/nuevoTorneo.ejs",{"user":req.user,"page":"torneo"});
	});
}

/**
 * Function to delete a torneo
 */
function _delete(req, res) {
	torneoService.delete(req.params._id)
		.then(function () {
			res.sendStatus(200);
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}