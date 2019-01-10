var app = angular.module('scotchApp', ['ngRoute','ngResource','ngStorage']);

app.directive('hcChart', function () {
    return {
        restrict: 'E',
        template: '<div></div>',
        scope: {
            options: '='
        },
        link: function (scope, element) {
            Highcharts.chart(element[0], scope.options);
        }
    };
})

app.directive('hcPieChart', function () {
    return {
        restrict: 'E',
        template: '<div></div>',
        scope: {
            title: '@',
            data: '='
        },
        link: function (scope, element) {
            Highcharts.chart(element[0], {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: scope.title
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    data: scope.data
                }]
            });
        }
    };
})

// configure our routes
app.config(function($routeProvider) {
    $routeProvider
        // route page initial
        .when('/', {
            templateUrl : 'data/inicio/index.html',
            // controller  : 'mainController',
            activetab: 'inicio'
        })
        // route empresa
        .when('/empresa', {
            templateUrl : 'data/empresa/index.html',
            controller  : 'empresaController',
            activetab: 'empresa'
        })

        // route cargos
        .when('/cargos', {
            templateUrl : 'data/cargos/index.html',
            controller  : 'cargosController',
            activetab: 'cargos'
        })
        // route servicios
        .when('/servicios', {
            templateUrl : 'data/servicios/index.html',
            controller  : 'serviciosController',
            activetab: 'servicios'
        })
        // route clientes
        .when('/clientes', {
            templateUrl : 'data/clientes/index.html',
            controller  : 'clientesController',
            activetab: 'clientes'
        })
        // route empleados
        .when('/empleados', {
            templateUrl : 'data/empleados/index.html',
            controller  : 'empleadosController',
            activetab: 'empleados'
        })
        // route winchas
        .when('/winchas', {
            templateUrl : 'data/winchas/index.html',
            controller  : 'winchasController',
            activetab: 'winchas'
        })
        // route disponibles
        .when('/disponibles', {
            templateUrl : 'data/disponibles/index.html',
            controller  : 'disponiblesController',
            activetab: 'disponibles'
        })
        // route login
        .when('/login', {
            templateUrl : 'data/login/index.html',
            controller  : 'loginController',
        })
        // route perfil
        .when('/perfil', {
            templateUrl : 'data/perfil/index.html',
            controller  : 'perfilController',
            activetab: 'perfil'
        })
        // route usuarios
        .when('/usuarios', {
            templateUrl : 'data/usuarios/index.html',
            controller  : 'usuariosController',
            activetab: 'usuarios'
        })
        // route privilegios
        .when('/privilegios', {
            templateUrl : 'data/privilegios/index.html',
            controller  : 'privilegiosController',
            activetab: 'privilegios'
        })
        // route cuenta
        .when('/cuenta', {
            templateUrl : 'data/cuenta/index.html',
            controller  : 'cuentaController',
            activetab: 'cuenta'
        })
});

/*app.factory('Auth', function($location) {
    var user;
    return {
        setUser : function(aUser) {
            user = aUser;
        },
        isLoggedIn : function() {
            var ruta = $location.path();
            var ruta = ruta.replace("/","");
            var accesos = JSON.parse(Lockr.get('users'));
                accesos.push('inicio');
                accesos.push('');

            var a = accesos.lastIndexOf(ruta);
            if (a < 0) {
                return false;    
            } else {
                return true;
            }
        }
    }
});*/


//app.run(['$rootScope', '$location', 'Auth', function ($rootScope, $location, Auth) {
//    $rootScope.$on('$routeChangeStart', function (event) {
//        var rutablock = $location.path();
//        if (!Auth.isLoggedIn()) {
//            event.preventDefault();
//            swal({
//                title: "Lo sentimos acceso denegado",
//                type: "warning",
//            });
//        } else { }
//    });
//}]);

// consumir servicios sri
//app.factory('loaddatosSRI', function($resource) {
//    return $resource("http://186.4.167.12/appserviciosnext/public/index.php/getDatos/:id", {
//        id: "@id"
//    });
//});
// fin

    