<div class="row  sinPadd sinMargen conteinerCarrusel" ng-controller="controllerEnc">
    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <!-- Indicators -->
        <ol class="carousel-indicators carousel-indicators-numbers">
            <li data-target="#myCarousel" id="nitem-0" class="active">1</li>
            <li data-target="#myCarousel" id="">cantidad</li>
            <br>
            <br>
            <li><button class="btn btn-success" style="width: 100px; margin-left: -35px; cursor: pointer;" ng-click="guardar()">FINALIZAR</button></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item pregunta active" ng-repeat="pregunta in listaDePreguntas" ng-if="$index < 1">
                <p>contenido de la pregunta</p>
                <span >
                    <input type="radio" value="hola" name="" ng-click=""  id="">
                    <label >muestra pregunta</label>
                </span>
                <textarea class="form-control" style="height: 150px"> para la pregunta abierta</textarea>
            </div>
            <div class="item pregunta" ng-repeat="pregunta in listaDePreguntas" ng-if="$index > 0">
                <p>pregunta contenido</p>
                <span >
                    <input type="radio" value="opcion" name="">
                    <label > pregunta lista de opciones</label>
                </span>
                <textarea class="form-control" style="height: 150px">Si la respuesta es abierta</textarea>
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control prev" href="" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control next" href="" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<div class="modal fade" id="popup">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color: #245269">Lea Atentamente</h4>
            </div>
            <div class="modal-body">
                <div id="mensajeModal">
                    <ul>
                        <li style="margin-bottom: 7px;">
                            El propósito de esta encuesta es encontrar áreas de oportunidad que nos permitan mejorar
                            el clima de trabajo en la organización.
                        </li>
                        <li style="margin-bottom: 7px;">
                            Recuerda que las respuestas son opiniones basadas en TÚ experiencia de trabajo, por lo tanto no hay respuestas correctas ni incorrectas.
                        </li>
                        <li style="margin-bottom: 7px;">
                            Lee cuidadosamente cada uno de los enunciados y marca la respuesta que mejor describa tu opinión.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

