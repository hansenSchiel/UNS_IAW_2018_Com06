(function (angular,APP){
	var grupoSelect = null;
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

	APP.controllers.NuevoTorneoController = APP.modules.torneo.controller('NuevoTorneoController',
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

			$http({method : 'GET',url : '/api/equipos', headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
	            .success(function(data, status) {
	                $scope.equipos = data;
	                $($scope.torneo.grupos).each(function(i,e){
	                	$(e.equipos).each(function(j,t){
	                		$scope.equipos = jQuery.grep($scope.equipos, function(value) {
							  	return value._id != t._id;
							});
	                	})
	                })
	             })
	            .error(function(data, status) {
	                alert("Error");
            	})

            $scope.registerTorneo = function(num){
            	$scope.torneo.creando=num;
				var body = JSON.stringify($scope.torneo);
	        	$http({method : 'POST',url : '/api/torneos/register',data:body})
	            .success(function(data, status) {
	                $scope.torneo.inicio = new Date($scope.torneo.inicio);
	                $scope.torneo.fin = new Date($scope.torneo.fin);
	                window.location.replace("/torneos/register");
	             })
	            .error(function(data, status) {
	                alert("Error");
	            })
            }

            $scope.addEquipo = function(equipo){
            	if (!grupoSelect)return;
            	if(!grupoSelect.equipos){
            		grupoSelect.equipos = [];
            	}
            	grupoSelect.equipos.push(equipo);
            	$scope.equipos = jQuery.grep($scope.equipos, function(value) {
				  return value != equipo;
				});
				var body = JSON.stringify($scope.torneo);
				$http({method : 'POST',url : '/api/torneos/register',data:body})
	            .success(function(data, status) {
	             })
	            .error(function(data, status) {
	                alert("Error");
	            })
            }
            $scope.selectGrupo = function(grupo){
        		grupoSelect = grupo;
            }
		}
	);
})(angular,APP);