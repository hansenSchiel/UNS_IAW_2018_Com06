// Config
var config = require('config.json');
var express = require('express');
var router = express.Router();
var pronosticoservice = require('services/pronostico.service');


// routes
router.get('/', getAll);
router.post('/register', register);
router.get('/:id', getCurrent);
router.delete('/:_id', _delete);

// Export
module.exports = router;

/**
 * Function to get all pronosticos
 */
function getAll(req, res) {
	pronosticoservice.getAll(req.user)
		.then(function (pronosticos) {
			res.send(pronosticos);
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}

/**
 * Function to get current pronostico
 */
function getCurrent(req, res) {
	pronosticoservice.getById(req.params.id)
		.then(function (pronostico) {
			if (pronostico) {
				res.send(pronostico);
			} else {
					res.sendStatus(404);
			}
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}

/**
 * Function to get add pronostico
 */
function register(req, res) {
	var pronostico = {fecha:req.body.fecha,torneo:req.body.torneo,user:req.user};
	pronostico.resultados = [];
	pronostico.fecha.encuentros.forEach(function(encuentro){
		pronostico.resultados.push({ganador:"L",encuentro:encuentro});
	});
	pronosticoservice.create(pronostico)
		.then(function () {
			res.sendStatus(200);
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}

/**
 * Function to delete a pronostico
 */
function _delete(req, res) {
	pronosticoservice.delete(req.params._id)
		.then(function () {
			res.sendStatus(200);
		})
		.catch(function (err) {
			res.status(400).send(err);
		});
}