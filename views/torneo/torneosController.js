(function (angular,APP){
	
	APP.controllers.TorneosController = APP.modules.torneo.controller('TorneosController',
		function($scope,$http){
			$http({method : 'GET',url : '/api/torneos', headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
            .success(function(data, status) {
                $scope.torneos = data;
             })
            .error(function(data, status) {
                alert("Error");
            })
		}
	);	
	APP.controllers.TorneoController = APP.modules.torneo.controller('TorneoController',
		function($scope,$http){
			console.log($scope);
			$http({method : 'GET',url : '/api'+window.location.pathname, headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
            .success(function(data, status) {
                $scope.torneo = data;
             })
            .error(function(data, status) {
                alert("Error");
            })
		}
	);

})(angular,APP);