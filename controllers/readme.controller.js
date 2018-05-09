// Config
var config = require('config.json');
var express = require('express');
var router = express.Router();

// routes
router.get('/', getAll);

// Export
module.exports = router;


function getAll(req, res) {
	res.render("readme.ejs",{"user":req.user,"page":"equipo"});
}