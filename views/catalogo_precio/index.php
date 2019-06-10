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

                            <table id="catalogo_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Placa</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Total Horas</th>
                                        <th>Total Paños</th>
                                        <th>Total Cotización</th>
                                        <th>Fecha Siniestro</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Delete Modal -->
        <div class="modal modal-danger fade" id="modal-delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Eliminar Registro?</h4>
              </div>
              <div class="modal-body">
                <p>Desea eliminar la placa: <span id="sp_grupo"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_elimina" data-value="" class="btn btn-outline">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Modal -->

        <!-- Div Ver Documentos -->
        <div id="md_verdocumentos" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title_documentos"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="confirm_documentos" class="alert alert-success alert-dismissible" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                        <span id="mensaje_confirmacion_documento"></span>
                    </div>

                    <form id="frm_alumno" method="POST">
                        <div class="form-row">
                            <div class="col-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li id="tab_generales" class="active"><a href="#generales" data-toggle="tab">Datos Generales</a></li>
                                        <li id="tab_fotos"><a href="#fotos" data-toggle="tab">Fotos</a></li>
                                        <li id="tab_repuestos"><a href="#repuestos" data-toggle="tab">Repuestos</a></li>
                                        <li id="tab_presupuestos"><a href="#presupuesto" data-toggle="tab">Mano de Obra</a></li>
                                        <li id="tab_cartas"><a href="#carta" data-toggle="tab">Carta de Conformidad</a></li>
                                        <li id="tab_inventarios"><a href="#inventarios" data-toggle="tab">Inventarios</a></li>
                                        <li id="tab_franquicias"><a href="#franquicias" data-toggle="tab">Franquicias</a></li>
										<li id="tab_otrosdocs"><a href="#otros_documentos" data-toggle="tab">Otros Documentos</a></li>
										<li id="tab_etaller"><a href="#etaller" data-toggle="tab">eTaller</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="generales">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="generales_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Descripcion</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="fotos">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                            <li id="tab_fotos_siniestros" class="active"><a href="#fotos_siniestros" data-toggle="tab">Siniestro</a></li>
                                                            <li id="tab_fotos_repuestos"><a href="#fotos_repuestos" data-toggle="tab">M/O & RPTOS</a></li>
                                                            <li id="tab_fotos_inspeccion"><a href="#fotos_inspeccion" data-toggle="tab">Inspección</a></li>
                                                            <li id="tab_fotos_terminados"><a href="#fotos_terminados" data-toggle="tab">Vehículo terminado</a></li>
                                                            <li id="tab_fotos_tablero"><a href="#fotos_tablero" data-toggle="tab">Tablero del Vehículo</a></li>
                                                            <li id="tab_fotos_interior"><a href="#fotos_interior" data-toggle="tab">Interior del Vehículo</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="fotos_siniestros">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_siniestros_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>                                                
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="tab-pane" id="fotos_repuestos">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_repuestos_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>                                                
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="tab-pane" id="fotos_inspeccion">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_inspeccion_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>                                                
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane" id="fotos_terminados">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_terminado_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>                                                
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane" id="fotos_tablero">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_tablero_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>                                                
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane" id="fotos_interior">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_interior_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
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
                                        <div class="tab-pane" id="repuestos">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                            <li id="tab_fotos_credito" class="active"><a href="#fotos_credito" data-toggle="tab">Notas de crédito</a></li>
                                                            <li id="tab_fotos_guia"><a href="#fotos_guia" data-toggle="tab">Guía de remisión</a></li>
															<li id="tab_fotos_proveedores"><a href="#fotos_proveedores" data-toggle="tab">Proveedores</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="fotos_credito">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_credito_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>                                                
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="fotos_guia">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="fotos_guia_tabla" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>                                                
                                                                </div>
                                                            </div>
															<div class="tab-pane" id="fotos_proveedores">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="proveedores_table" class="table table-striped table-bordered" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Imagen</th>
                                                                                    <th>Descripcion</th>
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
                                        <div class="tab-pane" id="presupuesto">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="presupuestos_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Descripcion</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="carta">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="cartas_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Descripcion</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="inventarios">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="inventarios_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Descripcion</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="franquicias">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="franquicias_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Descripcion</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
										<div class="tab-pane" id="otros_documentos">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="otrosdocs_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Descripcion</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
										<div class="tab-pane" id="etaller">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="etaller_table" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Imagen</th>
                                                                <th>Descripcion</th>
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
                    
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- Fin Div Ver Documentos -->
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

<script>
    var placas = "";
    $(document).ready(function(){
        placas = $('#catalogo_tabla').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>placa/getCatalogo",
			"responsive":true,
			"scrollX":        false,
			"scrollCollapse": true,
            "ordering": false,
            "bDestroy": true,
			"fixedColumns":   {
				"leftColumns": 2
			},
			"language":{
				"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"columns":[
				{"data":"nroplaca", "width":"6%"},
                {"data":"marca", "width":"15%"},
                {"data":"modelo", "width":"15%"},
                {"data":"total_horas", "width":"15%"},
                {"data":"total_panos", "width":"15%"},
                {"data":"total_cotizacion", "width":"15%"},
                {"data":"fecha_siniestro_lbl", "width":"15%"},
			],
            "columnDefs":[
                {
                    "targets":7,
                    "render": function(url, type, full){
                        var idsiniestro = full['idsiniestro'];
                        return '<button onclick="show_muestra_documentos('+ idsiniestro +');" title="Ver documentos" class="btn btn-warning"><i class="fa fa-search"></i></button>';
                        return false;
                    },
                    "width":"15%"
                }
            ],
			"dom": 'Bfrtip',
			"buttons": [
				{
					"extend": "pdfHtml5",
					"orientation": "landscape",
					"pageSize": "LEGAL"
                }
			]
		} );
    });

    function show_muestra_documentos(idsiniestro){
        $('#md_verdocumentos').modal();

        $("#tab_generales").addClass("active");
        $("#tab_fotos").removeClass("active");
        $("#tab_repuestos").removeClass("active");
        $("#tab_presupuestos").removeClass("active");
        $("#tab_cartas").removeClass("active");
        $("#tab_etaller").removeClass("active");
		$("#tab_otrosdocs").removeClass("active");

        $("#generales").addClass("active");
        $("#fotos").removeClass("active");
        $("#repuestos").removeClass("active");
        $("#presupuesto").removeClass("active");
        $("#carta").removeClass("active");
        $("#etaller").removeClass("active");

        $("#modal_title_documentos").html("Ver Documentos");
        
        generales               = CrearDatatable(idsiniestro, 5, "generales_table");
        //FOTOS
        fotos_inspeccion        = CrearDatatable(idsiniestro, 9, "fotos_inspeccion_tabla");
        fotos_repuestos         = CrearDatatable(idsiniestro, 7, "fotos_repuestos_tabla");
        fotos_siniestro         = CrearDatatable(idsiniestro, 8, "fotos_siniestros_tabla");
        fotos_terminado         = CrearDatatable(idsiniestro, 16, "fotos_terminado_tabla");
        fotos_tablero           = CrearDatatable(idsiniestro, 17, "fotos_tablero_tabla");
        fotos_interior          = CrearDatatable(idsiniestro, 18, "fotos_interior_tabla");
        //END FOTOS

        //REPUESTOS
        fotos_credito           = CrearDatatable(idsiniestro, 10, "fotos_credito_tabla");
        fotos_guia              = CrearDatatable(idsiniestro, 11, "fotos_guia_tabla");
        //END REPUESTOS

        presupuestos            = CrearDatatable(idsiniestro, 3, "presupuestos_table");
        cartas                  = CrearDatatable(idsiniestro, 4, "cartas_table");
        inventarios             = CrearDatatable(idsiniestro, 12, "inventarios_table");
        franquicias             = CrearDatatable(idsiniestro, 13, "franquicias_table");
        etaller                 = CrearDatatable(idsiniestro, 6, "etaller_table");
		otrosdocs				= CrearDatatable(idsiniestro, 15, "otrosdocs_table");

        proveedores             = CrearDatatable(idsiniestro, 14, "proveedores_table");
    }

    function CrearDatatable(idsiniestro, tipo, tabla){
        var info = {};
        info["idsiniestro"]    = idsiniestro;
        info["tipo"]           = tipo;
        var myJsonString    = JSON.stringify(info);
        console.log(tabla);

        var tabla = $('#' + tabla).DataTable( {
            "responsive":true,
            "scrollCollapse": true,
            "searching": true,
            "bDestroy": true,
            "ordering": false,
            "columnDefs":[
                {
                    "targets":0,
                    "data":"url",
                    "render": function(url, type, full){
                        console.log(full['ruta']);
                        var extension = full['ruta'].split(".");
                        if(extension[1] == "jpg" || extension[1] == "png" || extension[1] == "gif"){
                            return '<a target="_blank" href="<?PHP echo constant('URL'); ?>/'+full[1]+'"><img width="200" src="<?PHP echo constant('URL'); ?>'+full[1]+'"/></a>';
                        }
                        
                        if(extension[1] == "pdf"){
                            return '<a target="_blank" href="<?PHP echo constant('URL'); ?>/'+full[1]+'"><img width="200" src="<?PHP echo constant('URL'); ?>/views/public/img/pdf-icon-200.png"/></a>';
                        }
                        return false;
                    },
                    "width":"40%"
                },
                {
                    "targets":1,
                    "data":"descripcion",
                    "width":"40%"
                }
            ],
            "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>foto/ListaFotos",
                "data": {
                    "datos": myJsonString
                }
            },
            "language":{
                "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "columns":[
                {"data":"ruta"},
                {"data":"descripcion"},
            ],
            "dom": 'Bfrtip',
            "buttons": [
                
            ]
        } );

        return tabla;
    }  
    
</script>