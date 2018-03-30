var jsonDB;

$( document ).ready(function() {
	getJson();
	console.log(jsonDB);
});


function getJson(){
$.getJSON( "https://api.myjson.com/bins/gmy6n", function( data ) {
	jsonDB = data;
	console.log(jsonDB);
});
}

function refreshTemplates(){
	console.log(jsonDB);
}