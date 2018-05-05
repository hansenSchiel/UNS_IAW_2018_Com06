require('rootpath')();
var express = require('express');
var app = express();
var cors = require('cors');
var bodyParser = require('body-parser');
var expressJwt = require('express-jwt');
var config = require('config.json');
var path    = require("path");

app.use(cors());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());



app.use(express.static(path.join(__dirname, 'views')));

app.set('view engine', 'ejs');
app.set('views', __dirname + '/views');
// routes
app.use('/torneos', require('./controllers/torneos.controller'));
//app.use('/equipos', require('./controllers/equipos.controller'));


// /torneso como default
app.get('/', function (req, res) {
    return res.redirect('/torneos');
});
// start server
var port = process.env.NODE_ENV === 'production' ? 80 : 4000;
var server = app.listen(port, function () {
});