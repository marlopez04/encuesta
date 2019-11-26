
  <div class="card-gen">
    <div class="div-gen-title">
      <p class="nav-link-submenu active">Bienvenido</p>
    </div>
      <?php $selpais = $con->query("SELECT idRepresentante, nomRepr FROM representante ORDER BY nomRepr ASC"); ?>
      <div class="col-12 col-lg-5 row mx-auto">
        <label for="represt" class="label-input col-lg-4 pr-0">Elige un Representante:</label>
        <div class="col-lg-8 pr-0">
          <select class="form-control custom-select selectmancx" name="represt" id="represt">
            <option value="" disabled selected></option>
            <?php while ($fpais = $selpais->fetch_assoc()) { ?>
              <option value="<?php echo $fpais['idRepresentante'];?>"><?php echo $fpais['nomRepr'];?></option>
            <?php } $selpais->close(); ?>
          </select>
        </div>
      </div>

      <div class="col-12 col-lg-11 mx-auto row">
        <canvas id="bar-chart-grouped" class="col-12 col-md-10 mx-auto" height="400px"></canvas>
        <canvas id="myChart" class="col-12 col-md-10 mx-auto" height="400px"></canvas>
      </div>
  </div>

<script>
// AL SELECCIONAR UN DISTRIBUIDOR PONER LOS NRO DE ART DE ESE DISTRIBUIDOR
$('#represt').on('change', function(){
  var id = $('#represt').val();
  var datasetsp = "";
  traerest(id,2019,function(resp){
    //nombre del label
    var labuno = resp.split(",")[0];
    //valor del campo
    var varuno = [resp.split(",")[1],resp.split(",")[2],resp.split(",")[3],resp.split(",")[4]
  ,resp.split(",")[5],resp.split(",")[6],resp.split(",")[7],resp.split(",")[8],resp.split(",")[9]
  ,resp.split(",")[10],resp.split(",")[11],resp.split(",")[12]];
    var labdos = resp.split(",")[13];

    
    var vardos = [resp.split(",")[14],resp.split(",")[15],resp.split(",")[16],resp.split(",")[17]
  ,resp.split(",")[18],resp.split(",")[19],resp.split(",")[20],resp.split(",")[21],resp.split(",")[22]
  ,resp.split(",")[23],resp.split(",")[24],resp.split(",")[25]];
    var labtres = resp.split(",")[26];
    var vartres = [resp.split(",")[27],resp.split(",")[28],resp.split(",")[29],resp.split(",")[30]
  ,resp.split(",")[31],resp.split(",")[32],resp.split(",")[33],resp.split(",")[34],resp.split(",")[35]
  ,resp.split(",")[36],resp.split(",")[37],resp.split(",")[38]];
    if (labdos != null) {
      if (labtres != null) {
        graficar.data.datasets = [
          {
            label: labuno,
            data: varuno,
            //backgroundColor: 'green',
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            //borderColor: '#777',
            hoverBorderWidth:1,
            hoverBorderColor: '#000'
          },
          {
            label: labdos,
            data: vardos,
            //backgroundColor: 'green',
            backgroundColor: 'rgba(255, 206, 86, 0.8)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1,
            //borderColor: '#777',
            hoverBorderWidth:1,
            hoverBorderColor: '#000'
          },
          {
            label: labtres,
            data: vartres,
            //backgroundColor: 'green',
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            //borderColor: '#777',
            hoverBorderWidth:1,
            hoverBorderColor: '#000'
          }
        ];
        graficar.update();
      }else {
        graficar.data.datasets = [
          {
            label: labuno,
            data: varuno,
            //backgroundColor: 'green',
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            //borderColor: '#777',
            hoverBorderWidth:1,
            hoverBorderColor: '#000'
          },
          {
            label: labdos,
            data: vardos,
            //backgroundColor: 'green',
            backgroundColor: 'rgba(255, 206, 86, 0.8)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1,
            //borderColor: '#777',
            hoverBorderWidth:1,
            hoverBorderColor: '#000'
          }
        ];
        graficar.update();
      }
    }else{
      graficar.data.datasets = [
        {
          label: labuno,
          data: varuno,
          //backgroundColor: 'green',
          backgroundColor: 'rgba(54, 162, 235, 0.8)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          //borderColor: '#777',
          hoverBorderWidth:1,
          hoverBorderColor: '#000'
        }
      ];
      graficar.update();
    }
  });
});

function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}
function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}

var graficar = new Chart(document.getElementById("bar-chart-grouped"), {
  type: 'bar', //bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data: {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    datasets: [
    ]
  },
  options: {
    title:{
      display:true,
      text: 'Importe sin iva de una marca de un vendedor por mes y año',
      fontFamily: 'Helvetica',
      fontSize: 25,
      fontStyle:'normal',
      padding:20,
      lineHeight: 1.2
    },
    layout:{
      padding:{
        left:0,
        right:0,
        bottom:0,
        top:0
      }
    },
    tooltips:{
      enabled:true
    }
  }
});

var ctx = document.getElementById('myChart');

//Global options
//Chart.defaults.global.defaultFontFamily = 'Lato';
Chart.defaults.global.defaultFontSize = 16;
Chart.defaults.global.defaultFontColor = '#000';

var myChart = new Chart(ctx, {
  type: 'pie', //bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data: {
    labels: ['2018', '2019'],
    datasets: [
      {
        label: ['2018', '2019'],
        data: [2621395.98, 2033732.50],
        //backgroundColor: 'green',
        backgroundColor: [
          'rgba(75, 192, 192, 0.7)',
          'rgba(255, 99, 132, 0.7)'
        ],
        borderColor: [
          'rgba(75, 192, 192, 1)',
          'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1,
        //borderColor: '#777',
        hoverBorderWidth:1,
        hoverBorderColor: '#000'
      }
    ]},
  options: {
    title:{
      display:true,
      text: 'Comparación Anual',
      fontFamily: 'Helvetica',
      fontSize: 25,
      fontStyle:'normal',
      padding:20,
      lineHeight: 1.2
    },
    legend:{
      display:true,
      position:'right',
      labels:{
        fontColor:'#777'
      }
    },
    layout:{
      padding:{
        left:0,
        right:0,
        bottom:0,
        top:0
      }
    },
    tooltips:{
      enabled:true
    }
  }
});
// DECLARO LAS VARIABLES PARA TRAER LOS DATOS
//var labuno = '2017';
//var labdos = '2018';
//var labtres = '2019';
//var varuno = [95877, 54810, 188988, 28991, 35201, 209909,22192,284429,30264,249124,146645,85224];
//var vardos = [15977,365962,160351,163233,79452,38737,230415,225899,109436,64157,273849,4059];
//var vartres = [30452,72778,21904];


function traerest(asd1,asd2, my_callback){
  resp = "hola";
  $.post("../importeXmes.php", {
    idmarca: asd1,
    anio: asd2
  }, function(resp){
    my_callback(resp);;
  });
  return resp;
}
</script>
</body>
</html>
