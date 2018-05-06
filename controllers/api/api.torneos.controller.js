// Config
var config = require('config.json');
var express = require('express');
var router = express.Router();
var torneoService = require('services/torneo.service');


// routes
router.get('/', getAll);
router.get('/register', getCreando);
router.post('/register', register);
router.get('/:id', getCurrent);
router.delete('/:_id', _delete);

// Export
module.exports = router;

/**
 * Function to get all torneos
 */
function getAll(req, res) {
	torneoService.getAll()
		.then(function (torneos) {
			res.send(torneos);
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}

/**
 * Function to get current torneo
 */
function getCurrent(req, res) {
	torneoService.getById(req.params.id)
		.then(function (torneo) {
			if (torneo) {
				res.send(torneo);
			} else {
					res.sendStatus(404);
			}
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}

/**
 * Function to get current torneo
 */
function getCreando(req, res) {
	torneoService.getCreando()
		.then(function (torneo) {
			if (torneo) {
				res.send(torneo);
			} else {
				res.send({});
			}
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}
/**
 * Function to get add torneo
 */
function register(req, res) {
	torneoService.create(req.body)
		.then(function (torneo) {
			torneoService.getCreando()
			.then(function(torneo){
				res.status(200).send(torneo);
			});
		})
		.catch(function (err) {
			res.status(400).send(err);
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