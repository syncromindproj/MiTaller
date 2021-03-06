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
        <li class="active">Panel de Administración</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <!-- Small boxes (Stat box) -->
        <div id="div_prioritarios" style="display:none;" class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                    <h3 id="h_clientes_prioritarios"></h3>

                    <p>Clientes con alta prioridad</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-alert"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                    <h3 id="h_prioritarios"></h3>

                    <p>Siniestros con alta prioridad</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-alert"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div id="div_siniestros" style="display:none;" class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3 id="h_siniestros"></h3>

                    <p>Total de siniestros</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-checkmark"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div id="div_vehiculos" style="display:none;" class="small-box bg-yellow">
                    <div class="inner">
                    <h3 id="h_vehiculos"></h3>

                    <p>Total de vehículos registrados</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-clipboard"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <!--div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div-->
            
        </div>
    </section>
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<script>
    $(document).ready(function() {
        GetInfoPanel("prioritarios", "h_prioritarios");
        GetInfoPanel("siniestros", "h_siniestros");
        GetInfoPanel("vehiculos", "h_vehiculos");
        GetInfoPanel("clientes_prioritarios", "h_clientes_prioritarios");
    });

    function GetInfoPanel(tipo, div){
        var info        = {};
        info["tipo"]    = tipo;
        var myJsonString  = JSON.stringify(info);
        
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>siniestro/InfoPanel", 
            data:{
                datos: myJsonString
            },
            success: function(result){
                var numero = JSON.parse(result);
                $("#" + div).html(numero);   
                $("#div_" + tipo).css("display", "block");   
            },
            error:function(result){
                console.log(result);
            },
            complete: function() {
                setInterval(GetInfoPanel(tipo, div), 5000); 
            }
        });
    }
</script>