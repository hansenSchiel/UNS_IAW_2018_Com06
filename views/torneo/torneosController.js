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
			$http({method : 'GET',url : '/api'+window.location.pathname, headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
            .success(function(data, status) {
                $scope.torneo = data;
             })
            .error(function(data, status) {
                alert("Error");
            })
		}
	);

	APP.controllers.TorneoController = APP.modules.torneo.controller('NuevoTorneoController',
		function($scope,$http){
			$scope.torneo = {}
			$scope.torneo.cantGrupos="4";
			$http({method : 'GET',url : '/api/torneos/register', headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
	            .success(function(data, status) {
	                $scope.torneo = data;
	                $scope.torneo.inicio = new Date($scope.torneo.inicio);
	                $scope.torneo.fin = new Date($scope.torneo.fin);
	             })
	            .error(function(data, status) {
	                alert("Error");
            })




            $scope.registerTorneo = function(){
            	$scope.torneo.creando=true;
				var body = JSON.stringify($scope.torneo);
	        	$http({method : 'POST',url : '/api/torneos/register',data:body})
	            .success(function(data, status) {
	                //$scope.torneo = data;
	                $scope.torneo.inicio = new Date($scope.torneo.inicio);
	                $scope.torneo.fin = new Date($scope.torneo.fin);
	             })
	            .error(function(data, status) {
	                alert(data);
	            })
            }
		}
	);
})(angular,APP);