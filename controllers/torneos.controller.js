// Config
var config = require('config.json');
var express = require('express');
var router = express.Router();
var torneoService = require('services/torneo.service');


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
	res.render("torneo/torneos.ejs",{"page":"torneo"});
}

/**
 * Function to get current torneo
 */
function getCurrent(req, res) {
	res.render("torneo/torneo.ejs",{"page":"torneo"});
}

/**
 * Function to get add torneo
 */
function register(req, res) {
	res.render("torneo/nuevoTorneo.ejs",{"page":"torneo"});
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