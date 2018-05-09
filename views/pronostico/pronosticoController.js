(function (angular,APP){
	var grupoSelect = null;
	APP.controllers.pronosticosController = APP.modules.pronostico.controller('PronosticosController',
		function($scope,$http){
			$http({method : 'GET',url : '/api/pronosticos', headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
            .success(function(data, status) {
                $scope.pronosticos = data;
             })
            .error(function(data, status) {
                alert("Error");
            })
		}
	);	
})(angular,APP);