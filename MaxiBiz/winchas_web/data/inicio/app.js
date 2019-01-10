app.controller('mainController', function ($scope, $route, $timeout) {
	$scope.$route = $route;

	jQuery(function($) {

        // funcion notificaciones
        function notificaciones() {
            $.ajax({
                type: "POST",
                url: "data/inicio/app.php",
                data: {cargar_notificaciones:'cargar_notificaciones'},
                async: false,
                success: function(data) {
                    $scope.notificaciones_general = data;
                    $scope.notificaciones = data;             
                }
            });
        }
        // fin

        // funcion llamados
        function llamados() {
            $.ajax({
                type: "POST",
                url: "data/inicio/app.php",
                data: {cargar_llamados:'cargar_llamados'},
                dataType: 'json',
                async: false,
                success: function(data) {
                    $scope.datos = data;              
                }
            });
        }
        // fin

        // funcion informacion
        function informacion() {
            $.ajax({
                type: "POST",
                url: "data/inicio/app.php",
                data: {cargar_informacion:'cargar_informacion'},
                dataType: 'json',
                async: false,
                success: function(data) {
                    $scope.usuario = data.usuario;
                    $scope.conexion = data.fecha_creacion;               
                }
            });
        }
        // fin

        $scope.abrir_modal = function(id) {
            $("#myModalMapa").modal('show');
            var rendererOptions = { draggable: true };
            directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

            var divmapa = document.getElementById('map_canvas');

            var config = {
                zoom: 18,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false
            };

            map = new google.maps.Map(divmapa, config);

            $.ajax({
                type: "POST",
                url: "data/inicio/app.php",
                data: {cargar_llamados_id:'cargar_llamados_id',id: id},
                dataType: 'json',
                async: false,
                success: function(data) {
                    console.log(data);
                    $scope.nombres = data.nombres;
                    $scope.apellidos = data.apellidos;
                    $scope.servicio = data.servicio;
                    $scope.fecha = data.fecha; 

                    var latitud = data.latitud;
                    var longitud = data.longitud;

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                        var pos = new google.maps.LatLng(longitud, latitud);

                        var image = 'dist/images/marker.png';
                        if (typeof(marker) != "undefined") marker.setMap(null);
                            var objConfigMarker = {
                                position: pos,
                                map: map,
                                icon: image,
                                animation: google.maps.Animation.DROP,
                                // draggable: true,
                                title: "Posición Actual"
                            }

                            marker = new google.maps.Marker(objConfigMarker);
                            map.setCenter(pos);

                            google.maps.event.addListener(marker, 'click', function() {
                                console.log('')
                            });
                        });
                    }            
                }
            });
        }

        // incio funciones
        notificaciones();
        llamados();
        informacion();
        // fin
	});	
});