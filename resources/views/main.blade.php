<div class="row sinPadd sinMargen" ng-controller="controllerEncuestas">
    <div class="col-xs-12 col-sm-3 col-lg-4">

    </div>
    <div class="col-xs-12 col-sm-6 col-lg-4" style="padding-bottom: 20px;">
        <form id="dataEncuestado">
            <label for="selectEncuest">Encuesta</label>
            <select class="form-control" id="selectEncuest" required="required">
                <option value="{{encuesta.id}}" ng-repeat="encuesta in listaDeEncuestas">{{encuesta.nombre}}</option>
            </select>
            <br>
            <label for="selectSector">Sector</label>
            <select class="form-control" id="selectSector" required="required" ng-model="selectSector" ng-change="cargarEncargado()">
                <option ng-select="selectSector == sector.id" value="{{sector.id}}" ng-repeat="sector in listaDeSectores">{{sector.nombre}}</option>
            </select>
            <p class="sinMargen"><i>Responsable: <b>{{responsable}}</b></i></p>
            <br>
            <label for="selectPuesto">Puesto</label>
            <select class="form-control" id="selectPuesto" required="required">
                <option value="{{puesto.id}}" ng-repeat="puesto in listaDePuestos">{{puesto.nombre}}</option>
            </select>
            <br>
            <label for="selectAntiguedad">Antigüedad</label>
            <select class="form-control" id="selectAntiguedad" required="required">
                <option value="{{antiguedad.id}}" ng-repeat="antiguedad in listaDeAntiguedad">{{antiguedad.rango}}</option>
            </select>
            <br>
            <label for="txtEdad">Edad</label>
            <input type="number" class="form-control" id="txtEdad" required="required">
            <br>
            <label for="selectFormacion">Formacion</label>
            <select class="form-control" id="selectFormacion" required="required">
                <option value="{{estudio.id}}" ng-repeat="estudio in listaDeEstudios">{{estudio.nivel}}</option>
            </select>

            <input type="submit" class="btn btn-success" value="COMENZAR" style="width: 100%; margin-top: 20px;">
        </form>
    </div>
    <div class="col-xs-12 col-sm-3 col-lg-4">

    </div>
</div>

<script>
    app = angular.module('App', []).controller('controllerEncuestas', function($scope,$http)
    {
        $scope.listaDeEncuestas = [];
        $scope.listaDeSectores = [];
        $scope.listaDeAntiguedad = [];
        $scope.listaDeEstudios = [];
        $scope.listaDePuestos = [];
        $scope.listaDeSubSectores = [];
        $scope.responsable = "";
        $scope.cargarEncargado = function()
        {
            angular.forEach($scope.listaDeSectores, function (task, index) {
                if ($scope.listaDeSectores[index].id == $('#selectSector').val())
                {
                    $scope.responsable = $scope.listaDeSectores[index].responsable;
                }
            });
        };

        $http.post('{HOME}funcion/listar').success(function(data)
        {
            $scope.listaDeEncuestas = data;
        });
        $http.post('{HOME}funcion/getSectores').success(function(data)
        {
            $scope.listaDeSectores = data;
            $scope.selectSector = $scope.listaDeSectores[0].id;
            $scope.responsable = $scope.listaDeSectores[0].responsable;

        });
        $http.post('{HOME}funcion/getAntiguedad').success(function(data)
        {
            $scope.listaDeAntiguedad = data;

        });
        $http.post('{HOME}funcion/getEstudios').success(function(data)
        {
            $scope.listaDeEstudios = data;

        });
        $http.post('{HOME}funcion/getPuestos').success(function(data)
        {
            $scope.listaDePuestos = data;

        });

    });

    $("#dataEncuestado").submit(
            function()
            {
                location.href="{HOME}mostrar/encuesta/"+$("#selectEncuest").val()+"-"+$("#selectSector").val()+"-"+$("#txtEdad").val()+"-"+$("#selectAntiguedad").val()+"-"+$("#selectFormacion").val()+"-"+$("#selectPuesto").val();
                return false;
            }
    );

    $('input').keypress(function (e)
    {
        if(e.which == 13) {
            e.preventDefault();
            $()
            return false;
        }
    });

</script>

