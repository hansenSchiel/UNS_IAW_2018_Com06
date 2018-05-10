require('rootpath')();
var express = require('express');
var app = express();
var cors = require('cors');
var bodyParser = require('body-parser');
var expressJwt = require('express-jwt');
var config = require('config.json');
var path    = require("path");
var methodOverride = require('method-override')
var cookieParser = require('cookie-parser');
var session = require('express-session');


var mongoose = require('mongoose');
var passport = require('passport');
require('./models/user');
require('./passport')(passport);


app.use(cors());

mongoose.connect('mongodb://hansen:hansen@ds119650.mlab.com:19650/iaw', 
  function(err, res) {
    if(err) throw err;
});


app.use(express.static(path.join(__dirname, 'views')));


app.use(cookieParser('abcdefg'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(bodyParser());
app.use(session({
    secret: 'abcdefg',
    resave: true,
    saveUninitialized: false
}));
app.use(passport.initialize());
app.use(passport.session());


app.use(methodOverride('X-HTTP-Method-Override'))

// Configuración de Express


app.set('view engine', 'ejs');
app.set('views', __dirname + '/views');
// routes
app.use('/torneos', require('./controllers/torneos.controller'));
app.use('/api/torneos', require('./controllers/api/api.torneos.controller'));


app.use('/equipos', require('./controllers/equipos.controller'));
app.use('/api/equipos', require('./controllers/api/api.equipos.controller'));


app.use('/pronosticos', require('./controllers/pronostico.controller'));
app.use('/api/pronosticos', require('./controllers/api/api.pronostico.controller'));



app.use('/readme', require('./controllers/readme.controller'));

app.get('/logout', function(req, res) {
  req.logout();
  res.redirect('/');
});
app.get('/auth/twitter', passport.authenticate('twitter'));
app.get('/auth/twitter/callback', passport.authenticate('twitter',
  { successRedirect: '/', 
    failureRedirect: '/login' }));



// /torneso como default
app.get('/', function (req, res) {
    return res.redirect('/torneos');
});

// start server
var port = process.env.NODE_ENV === 'production' ? 80 : 3000;
var server = app.listen(port, function () {
});