(function (angular,APP){
	
	APP.controllers.TorneosController = APP.modules.torneo.controller('TorneosController',
		function($scope,$http){
			var torneos = [{"hola":"aaa"},{"hola":"bbb"}];
			$http({method : 'GET',url : '/api/torneos', headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
            .success(function(data, status) {
                $scope.torneos = data;
             })
            .error(function(data, status) {
                alert("Error");
            })
		}
);

})(angular,APP);