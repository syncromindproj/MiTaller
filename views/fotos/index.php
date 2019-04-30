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

        <!-- Div Listado Fotos -->
        <div id="md_listadofotos" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title_fotos"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li id="tab_siniestros" class="active"><a href="#siniestros" data-toggle="tab">Siniestros</a></li>
                                    <li id="tab_reparados"><a href="#reparados" data-toggle="tab">Reparados</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="siniestros">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="siniestros_tabla" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                        </tr>
                                                    </thead>
                                                </table>         
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="reparados">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="reparados_tabla" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Foto</th>
                                                        </tr>
                                                    </thead>
                                                </table>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
        <!-- Fin Listado Fotos -->

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

                            <table id="marcas_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Marca</th>
                                        <th>Núm. Fotos</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

<script>
    var marcas = "";
    var siniestros = "";
    var reparados = "";

    $(document).ready(function() {
        marcas = $('#marcas_tabla').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>foto/GetFotosPorMarca",
			"responsive":true,
			"scrollX":        false,
			"scrollCollapse": true,
            "bLengthChange": false,
            "pageLength": 50,
            "ordering": false,
            "bDestroy": true,
			"fixedColumns":   {
				"leftColumns": 2
			},
			"language":{
				"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"columnDefs":[
                {
                    "targets":0,
                    "data":"marca",
                    "width":"15%"
                },
                {
                    "targets":1,
                    "data":"cantidad",
                    "width":"15%"
                },
                {
                    "targets":2,
                    "data":"marca",
                    "width":"20%",
                    "data":"idetaller",
                    "render": function(url, type, full){
                        var marca = "'" + full[0] + "'";
                        return '<button onclick="ver_fotos('+ marca +');" title="Ver información" class="btn btn-warning"><i class="fa fa-search"></i></button>';
                        return false;
                    }
                }
            ]
        } );

        
    });

    function ver_fotos(marca)
    {
        $("#md_listadofotos").modal();
        $("#modal_title_fotos").html("Fotos - " + marca);
        crearDatatable(marca, 'siniestros_tabla', 8);
        crearDatatable(marca, 'reparados_tabla', 16);
    }

    function crearDatatable(marca, tabla, tipo)
    {
        var info = {};
        info["marca"]       = marca;
        info["tipo"]        = tipo;
        var myJsonString    = JSON.stringify(info);

        marcas = $('#' + tabla).DataTable( {
		    "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>foto/GetRutasPorMarca",
                "data": {
                    "datos": myJsonString
                },
                "error": function (jqXHR, textStatus, errorThrown) {
                    console.log("sss");
                }
            },
			"responsive":true,
			"scrollX":        false,
			"scrollCollapse": true,
            "bLengthChange": false,
            "pageLength": 50,
            "ordering": false,
            "bDestroy": true,
			"fixedColumns":   {
				"leftColumns": 2
			},
			"language":{
				"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"columnDefs":[
                {
                    "targets":0,
                    "data":"ruta",
                    "width":"20%",
                    "render": function(url, type, full){
                        var ruta =  full[0];
                        return '<a target="_blank" href="<?PHP echo constant('URL'); ?>/'+ ruta +'"><img width="200" src="<?PHP echo constant('URL'); ?>'+ ruta +'"/></a>';
                        return false;
                    }
                }
            ]
        } );
    }
</script>