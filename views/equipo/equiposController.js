(function (angular,APP){
	
	APP.controllers.equiposController = APP.modules.equipo.controller('EquipoController',
		function($scope,$http){
			$http({method : 'GET',url : '/api/equipos', headers: { 'X-Parse-Application-Id':'XXXXXXXXXXXXX', 'X-Parse-REST-API-Key':'YYYYYYYYYYYYY'}})
            .success(function(data, status) {
                $scope.equipos = data;
             })
            .error(function(data, status) {
                alert("Error");
            })

            $scope.addEquipo = function(){
                var body = JSON.stringify($scope.equipo);
                console.log($scope.equipo);
                $http({method : 'POST',url : '/api/equipos/register',data:body})
                .success(function(data, status) {
                    window.location.replace("/equipos");
                 })
                .error(function(data, status) {
                    alert("Error");
                })
            }
		}
);

})(angular,APP);