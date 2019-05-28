<?PHP require 'views/header.php'; ?>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?PHP echo $this->title ; ?>
                <small><?PHP echo $this->subtitle ; ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">E-taller</a></li>
                <li class="active">Listado de Registros</li>
            </ol>
        </section>

         <!-- Main content -->
         <section class="content container-fluid">
            <!--------------------------
            | Your Page Content Here |
            -------------------------->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                        <h3 class="box-title"><?PHP echo $this->subtitle ; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="confirm_data" class="alert alert-success alert-dismissible" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                <span id="mensaje_confirmacion_data"></span>
                            </div>

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<!-- ChartJS -->
<script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
<script src='<?PHP echo constant('URL'); ?>views/dist/js/pages/dashboard2.js'></script>
<script>
    'use strict';
  window.chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
  };

    var lineChartData = {};
    var datos_rimac = {};
    var datasets = [];
        
    $(document).ready(function(){
        GetDatosAnuales('2019', 'RIMAC', window.chartColors.red, 0);
        GetDatosAnuales('2019', 'PACIFICO', window.chartColors.blue, 0);
        GetDatosAnuales('2019', 'MAPFRE', window.chartColors.orange, 0);
        GetDatosAnuales('2019', 'LA POSITIVA', window.chartColors.purple, 0);
        GetDatosAnuales('2019', 'HDI SEGUROS', window.chartColors.green, 0);
        GetDatosAnuales('2019', 'PARTICULAR', window.chartColors.grey, 1);
    });
    //
    function AgregaDataset(final){
        if(final==1){
            lineChartData = {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: datasets
            };
            console.log(datasets);
            CreaGrafico();
        }
    }

    function GetDatosAnuales(anio, aseguradora, color, final){
        var info = {};
        var resultados = [];
            
        info["anio"]        = anio;
        info["aseguradora"] = aseguradora;
        var myJsonString    = JSON.stringify(info);

        $.ajax({
            type: "POST",
                url: "<?PHP echo constant('URL'); ?>reporte_anual/GetDatosAnuales", 
                async: false,
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    info = JSON.parse(result);
                    for (var i in info) {
                        resultados.push(info[i].cantidad);
                    }
                    var dataset = {
                        label: aseguradora,
                        borderColor: color,
                        backgroundColor: color,
                        fill: false,
                        data: resultados,
                        yAxisID: 'y-axis-1',
                    };
                    datasets.push(dataset);
                    AgregaDataset(final);
                    
                },
                error:function(result){
                    console.log(result);
                }
        });
    }

</script>