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
            .error(function(data, status){
                alert("Error");
            })

            $scope.getEquipos = function(){
            	if($scope.torneo == undefined)return 0;
            	toR = [];
            	$($scope.torneo.grupos).each(function(i,grupo){
            		$(grupo.equipos).each(function(i,equipo){
            			toR.push(equipo);
            		});
        		});
        		return toR;
            }
            $scope.getProximaFecha = function(){
            	if($scope.torneo == undefined)return 0;
            	$($scope.torneo.fechas).each(function(i,fecha){
            		if(fecha === null){

            		}else{
	            		if($scope.proximaFecha == null && new Date()<new Date(fecha.dia)){
	            			$scope.proximaFecha = fecha;
	            			$scope.proximaFecha.nombre = i;
	            		}
	            		if($scope.ultimaFecha !== undefined && new Date($scope.ultimaFecha.dia)<new Date(fecha.dia)){
	            			$scope.proximaFecha = fecha;
	            			$scope.proximaFecha.nombre = i;
	            		}
            		}
        		});
        		$scope.proximaFecha.fin = new Date(new Date($scope.proximaFecha.dia)-1000*60*60*24);
        		$scope.proximaFecha.inicio = new Date(new Date($scope.proximaFecha.dia)-1000*60*60*24*30);
            }
            $scope.getUltimaFecha = function(){
            	if($scope.torneo == undefined)return 0;
            	$($scope.torneo.fechas).each(function(i,fecha){
            		if(fecha === null){

            		}else{
	            		if($scope.ultimaFecha == undefined && new Date()>new Date(fecha.dia)){
	            			$scope.ultimaFecha = fecha;
	            			$scope.ultimaFecha.nombre = i;
	            		}
	            		if($scope.ultimaFecha != undefined && new Date($scope.ultimaFecha.dia)>new Date(fecha.dia)){
	            			$scope.ultimaFecha = fecha;
	            			$scope.ultimaFecha.nombre = i;
	            		}
            		}
        		});
        		$scope.ultimaFecha.fin = new Date(new Date($scope.ultimaFecha.dia)-1000*60*60*24);
        		$scope.ultimaFecha.inicio = new Date(new Date($scope.ultimaFecha.dia)-1000*60*60*24*30);
            }
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
	        		$($scope.torneo.encuentros).each(function(i,encu){
        				encu.dia = new Date(encu.dia.split('T')[0]);
	        		})
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
            	console.log($scope.torneo);
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