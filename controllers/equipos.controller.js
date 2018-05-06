// Config
var config = require('config.json');
var express = require('express');
var router = express.Router();
var equiposervice = require('services/equipo.service');

// routes
router.get('/', getAll);
router.post('/register', register);
router.get('/:id', getCurrent);
router.delete('/:_id', _delete);

// Export
module.exports = router;

/**
 * Function to get all equipos
 */
function getAll(req, res) {
	res.render("equipo/equipos.ejs",{"page":"equipo"});
}

/**
 * Function to get current equipo
 */
function getCurrent(req, res) {
	equiposervice.getById(req.params.id)
		.then(function (equipo) {
			if (equipo) {
				res.send(equipo);
			} else {
					res.sendStatus(404);
			}
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}

/**
 * Function to get add equipo
 */
function register(req, res) {
	equiposervice.create(req.body)
		.then(function () {
			res.sendStatus(200);
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}

/**
 * Function to delete a equipo
 */
function _delete(req, res) {
	equiposervice.delete(req.params._id)
		.then(function () {
			res.sendStatus(200);
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}