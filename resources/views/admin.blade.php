<div class="row">
    <div class="col-lg-12">
        <h1>
            <img src="{{asset('images/logo.png')}}" style="width: 100px">imple - Panel de Administración
        </h1>
    </div>
</div>
<div class="row padd0 colorCeleste">
    <div class="col-lg-12">
        <h3>
            1 - CREACION DE ENTIDADES
        </h3>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-3">
        <b>ENTIDADES LEIDAS:</b>
        <br>
        <ul>
        {Entidades}
        </ul>
    </div>
    <div class="col-xs-9">
        <div class="row">
            {atribEntidades}
        </div>
    </div>
</div>
<div class="row padd0 colorCeleste">
    <div class="col-lg-12">
        <h3>
            2 - CREACION RELACION ENTRE ENTIDADES
        </h3>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="classLeft">Class Left</label>
                    <select class="form-control" id="classLeft">
                        {classForRelation}
                    </select>
                    <label for="classLeftAttrib">Attrib</label>
                    <select class="form-control" id="classLeftAttrib">
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <label for="relation">Relation</label>
                <select class="form-control" id="relation">
                    <option value="1">1 - 1</option>
                    <option value="*">1 - *</option>
                </select>
                <label for="btnCreateRelation">Generar</label>
                <button type='button' class='btn btn-success' id="btnCreateRelation" style='width:100%;' onclick="generarRelationClass();">=</button>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="classRight">Class Right</label>
                    <select class="form-control" id="classRight">
                        {classForRelation}
                    </select>
                    <label for="classRightAttrib">Attrib</label>
                    <select class="form-control" id="classRightAttrib">
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center" id="respuestaRelacion"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<br>
<div class="row padd0 colorCeleste">
    <div class="col-lg-12">
        <h3>
            3 - CREACION DE SJS
        </h3>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="classLeft">Class</label>
            <select class="form-control" id="JSClass">
                {classForRelation}
            </select>
        </div>
    </div>
    <div class="col-lg-1">
        <label for="btnCreateJS">Generar</label>
        <button type='button' class='btn btn-success' id="btnCreateJS" style='width:100%;' onclick="generarJSClass();">JS</button>
    </div>
    <div class="col-lg-4" style="padding-top: 30px;">
        <span id="respuestaJS"></span>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<br>
<div class="row padd0 colorCeleste">
    <div class="col-lg-12">
        <h3>
            4 - CREACION DE VISTAS
        </h3>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="classLeft">Class</label>
            <select class="form-control" id="viewClass">
                {classForRelation}
            </select>
        </div>
    </div>
    <div class="col-lg-1">
        <label for="btnCreateJS">Generar</label>
        <button type='button' class='btn btn-success' id="btnCreateView" style='width:100%;' onclick="generarView();">View</button>
    </div>
    <div class="col-lg-4" style="padding-top: 30px;">
        <span id="respuestaView"></span>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<br>
<div class="row padd0 colorCeleste">
    <div class="col-lg-12">
        <h3>
            5 - DISFRUTA DE LA MEJOR EXPERIENCIA EN PROGRAMACION WEB
        </h3>
    </div>
</div>
<br>
<br>

<style>
    ul
    {
        padding-left: 20px;
    }
    ul li
    {
        list-style:none;
    }
    .padd0
    {
        padding: 0px;
    }
    .colorCeleste
    {
        background-color: #d9edf7;
    }
</style>
