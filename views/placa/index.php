<?PHP require 'views/header.php'; ?>
<link href='<?PHP echo constant('URL'); ?>views/public/css/bootstrap-datepicker.min.css' rel='stylesheet' />
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload-ui-noscript.css"></noscript>

<style>
.modal-dialog{
    overflow-y: initial !important
}
.extrab{
    height: 450px;
    overflow-y: auto;
}
#frm_inventario input{
    height:25px;
}
#frm_inventario select{
    height:25px;
    padding:0;
}
#frm_inventario label{
    font-size:12px;
    font-weight:500;
}

.espacio_top{
    margin-top:10px;
}
</style>

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
        <li><a href="#">Placas</a></li>
        <li class="active">Registro de Placa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       
    <div id="confirm_grupo" class="alert alert-success alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Confirmación</h4>
        <span id="mensaje_confirmacion"></span>
    </div>

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
                    <table id="placas" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Siniestros</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                    </table>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Modal Observaciones -->
        <div class="modal fade" id="modal_observaciones">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Observaciones</h4>
              </div>
              <div class="modal-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active" id="tab_observaciones_cliente_ver"><a href="#obscliente_ver" data-toggle="tab">Observaciones Cliente</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="obscliente_ver">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <textarea id="observaciones_cliente_div">

                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" id="btn_actualizar_observacion" data-value="" class="btn btn-default" data-dismiss="modal">Actualizar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- End Modal Observaciones -->

        <!-- Modal Iventario -->
        <div class="modal fade" id="modal_inventario">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Registro de Inventario</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frm_inventario" method="POST">
                            <input type="hidden" id="txt_inv_siniestro" name="txt_inv_siniestro">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_recepcionista">RECEPCIONISTA</label>    
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_recepcionista" name="txt_inv_recepcionista" placeholder="RECEPCIONISTA">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_placa">PLACA</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_placa" name="txt_inv_placa" placeholder="PLACA">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_marca">MARCA</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_marca" name="txt_inv_marca" placeholder="MARCA">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_modelo">MODELO</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_modelo" name="txt_inv_modelo" placeholder="MODELO">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_ingreso">INGRESO</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_ingreso" name="txt_inv_ingreso" placeholder="INGRESO">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_hora">HORA</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_hora" name="txt_inv_hora" placeholder="HORA">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label for="txt_inv_piloto">PILOTO</label>
                                        </div>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control" id="txt_inv_piloto" name="txt_inv_piloto" placeholder="PILOTO">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_correo">CORREO</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_correo" name="txt_inv_correo" placeholder="CORREO">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_telefono">TELÉFONO</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_telefono" name="txt_inv_telefono" placeholder="TELÉFONO">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_celular">CELULAR</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="txt_inv_celular" name="txt_inv_celular" placeholder="CELULAR">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label for="txt_inv_servicio">SERVICIO</label>
                                        </div>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control form-control-sm" id="txt_inv_servicio" name="txt_inv_servicio" placeholder="SERVICIO">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label for="txt_inv_observacion">OBS.</label>
                                        </div>
                                        <div class="col-md-11">
                                            <textarea class="form-control" id="txt_inv_observacion" name="txt_inv_observacion" placeholder="OBSERVACIÓN"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="txt_inv_kilometraje">KILOMETRAJE</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm" id="txt_inv_kilometraje" name="txt_inv_kilometraje" placeholder="KILOMETRAJE">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="sl_queda">¿Queda en taller?</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select id="sl_queda" name="sl_queda" class="form-control">
                                                <option value="">SELECCIONAR</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li id="tab_interior" class="active"><a href="#interior" data-toggle="tab">Interior Vehículo</a></li>
                                            <li id="tab_exterior"><a href="#exterior" data-toggle="tab">Exterior Vehículo</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="interior">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_tarjpropiedad">TARJETA DE PROPIEDAD</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_tarjpropiedad" name="sl_inv_tarjpropiedad"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_tarjpropiedad" name="txt_inv_tarjpropiedad" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_soat">SOAT</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_soat" name="sl_inv_soat"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_soat" name="txt_inv_soat" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_llaveencendido">LLAVE DE ENCENDIDO</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_llaveencendido" name="sl_inv_llaveencendido"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_llaveencendido" name="txt_inv_llaveencendido" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_encendedor">ENCENDEDOR</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_encendedor" name="sl_inv_encendedor"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_encendedor" name="txt_inv_encendedor" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_aireacondicionado">AIRE ACONDICIONADO</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_aireacondicionado" name="sl_inv_aireacondicionado"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_aireacondicionado" name="txt_inv_aireacondicionado" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_cenicero">CENICERO</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_cenicero" name="sl_inv_cenicero"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_cenicero" name="txt_inv_cenicero" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_claxon">CLAXÓN</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_claxon" name="sl_inv_claxon"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_claxon" name="txt_inv_claxon" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_luzsalon">LUZ DE SALÓN</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_luzsalon" name="sl_inv_luzsalon"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_luzsalon" name="txt_inv_luzsalon" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_parlantes">PARLANTES</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_parlantes" name="sl_inv_parlantes"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_parlantes" name="txt_inv_parlantes" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_correasseguridad">CORREAS DE SEGURIDAD</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_correasseguridad" name="sl_inv_correasseguridad"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_correasseguridad" name="txt_inv_correasseguridad" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_controlalarma">CONTROL DE ALARMA</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_controlalarma" name="sl_inv_controlalarma"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_controlalarma" name="txt_inv_controlalarma" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_asientos">ASIENTOS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_asientos" name="sl_inv_asientos"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_asientos" name="txt_inv_asientos" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_pisos">PISOS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_pisos" name="sl_inv_pisos"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_pisos" name="txt_inv_pisos" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_espejointerior">ESPEJO INTERIOR</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_espejointerior" name="sl_inv_espejointerior"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_espejointerior" name="txt_inv_espejointerior" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_libroservicio">LIBRO DE SERVICIO</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_libroservicio" name="sl_inv_libroservicio"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_libroservicio" name="txt_inv_libroservicio" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_juegoherramientas">JUEGO DE HERRAMIENTAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_juegoherramientas" name="sl_inv_juegoherramientas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_juegoherramientas" name="txt_inv_juegoherramientas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_juegoseguroaros">JUEGO SEGUROS DE AROS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_juegoseguroaros" name="sl_inv_juegoseguroaros"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_juegoseguroaros" name="txt_inv_juegoseguroaros" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_juegosegurovasos">JUEGO SEGURO DE VASOS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_juegosegurovasos" name="sl_inv_juegosegurovasos"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_juegosegurovasos" name="txt_inv_juegosegurovasos" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_radiocd">RADIO - CD</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_radiocd" name="sl_inv_radiocd"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_radiocd" name="txt_inv_radiocd" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_injecagua">INJEC. DE AGUA PARABRISAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_injecagua" name="sl_inv_injecagua"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_injecagua" name="txt_inv_injecagua" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_trabagas">TRABAGAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_trabagas" name="sl_inv_trabagas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_trabagas" name="txt_inv_trabagas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_mascara">MASCARA</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_mascara" name="sl_inv_mascara"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_mascara" name="txt_inv_mascara" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_seguroruedas">SEGURO DE RUEDAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_seguroruedas" name="sl_inv_seguroruedas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_seguroruedas" name="txt_inv_seguroruedas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_revocular">REV. OCULAR MOTOR</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_revocular" name="sl_inv_revocular"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_revocular" name="txt_inv_revocular" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_cajacd">CAJA CD</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_cajacd" name="sl_inv_cajacd"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_cajacd" name="txt_inv_cajacd" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="exterior">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_antenas">ANTENAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_antenas" name="sl_inv_antenas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_antenas" name="txt_inv_antenas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_espejoexterior">ESPEJO EXTERIOR</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_espejoexterior" name="sl_inv_espejoexterior"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_espejoexterior" name="txt_inv_espejoexterior" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_vasosrueda">VASOS DE RUEDA</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_vasosrueda" name="sl_inv_vasosrueda"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_vasosrueda" name="txt_inv_vasosrueda" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_brazosplumillas">BRAZOS Y PLUMILLAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_brazosplumillas" name="sl_inv_brazosplumillas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_brazosplumillas" name="txt_inv_brazosplumillas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_direccionales">DIRECCIONALES</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_direccionales" name="sl_inv_direccionales"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_direccionales" name="txt_inv_direccionales" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_llantas">LLANTAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_llantas" name="sl_inv_llantas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_llantas" name="txt_inv_llantas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_aros">AROS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_aros" name="sl_inv_aros"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_aros" name="txt_inv_aros" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_farosdelanteros">FAROS DELANTEROS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_farosdelanteros" name="sl_inv_farosdelanteros"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_farosdelanteros" name="txt_inv_farosdelanteros" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_farosposteriores">FAROS POSTERIORES</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_farosposteriores" name="sl_inv_farosposteriores"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_farosposteriores" name="txt_inv_farosposteriores" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_emblemas">EMBLEMAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_emblemas" name="sl_inv_emblemas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_emblemas" name="txt_inv_emblemas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_escarpines">ESCARPINES</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_escarpines" name="sl_inv_escarpines"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_escarpines" name="txt_inv_escarpines" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_tapagasolina">TAPA DE GASOLINA INT. EXT.</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_tapagasolina" name="sl_inv_tapagasolina"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_tapagasolina" name="txt_inv_tapagasolina" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_llantarepuesto">LLANTA DE REPUESTO</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_llantarepuesto" name="sl_inv_llantarepuesto"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_llantarepuesto" name="txt_inv_llantarepuesto" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_gatapalanca">GATA Y PALANCA</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_gatapalanca" name="sl_inv_gatapalanca"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_gatapalanca" name="txt_inv_gatapalanca" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_manijas">MANIJAS Y PERILLAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_manijas" name="sl_inv_manijas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_manijas" name="txt_inv_manijas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_llaveruedas">LLAVE DE RUEDAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_llaveruedas" name="sl_inv_llaveruedas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_llaveruedas" name="txt_inv_llaveruedas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_tapaaceite">TAPA ACEITE</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_tapaaceite" name="sl_inv_tapaaceite"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_tapaaceite" name="txt_inv_tapaaceite" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_tapaliquido">TAPA LÍQUIDO DE FRENO</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_tapaliquido" name="sl_inv_tapaliquido"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_tapaliquido" name="txt_inv_tapaliquido" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_tapaliquidoembrague">TAPA LÍQUIDO DE EMBRAGUE</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_tapaliquidoembrague" name="sl_inv_tapaliquidoembrague"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_tapaliquidoembrague" name="txt_inv_tapaliquidoembrague" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_taparadiador">TAPA DE RADIADOR</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_taparadiador" name="sl_inv_taparadiador"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_taparadiador" name="txt_inv_taparadiador" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_varillaaceite">VARILLA DE ACEITE</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_varillaaceite" name="sl_inv_varillaaceite"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_varillaaceite" name="txt_inv_varillaaceite" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_tapicesalfombras">TAPICES Y ALFOMBRAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_tapicesalfombras" name="sl_inv_tapicesalfombras"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_tapicesalfombras" name="txt_inv_tapicesalfombras" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_parabrisas">PARABRISAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_parabrisas" name="sl_inv_parabrisas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_parabrisas" name="txt_inv_parabrisas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_lunaspuertas">LUNAS DE PUERTAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_lunaspuertas" name="sl_inv_lunaspuertas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_lunaspuertas" name="txt_inv_lunaspuertas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_copasvasos">COPAS Y VASOS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_copasvasos" name="sl_inv_copasvasos"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_copasvasos" name="txt_inv_copasvasos" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_chapapuertas">CHAPA DE PUERTAS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_chapapuertas" name="sl_inv_chapapuertas"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_chapapuertas" name="txt_inv_chapapuertas" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_alarma">ALARMA</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_alarma" name="sl_inv_alarma"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_alarma" name="txt_inv_alarma" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row espacio_top">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label for="txt_inv_otros">OTROS</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="sl_inv_otros" name="sl_inv_otros"></select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" id="txt_inv_otros" name="txt_inv_otros" placeholder="OBSERVACIONES">
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_registro_inventario" data-value="" class="btn btn-default" data-dismiss="modal">Registrar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
                </form>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- End Modal Inventario -->

        <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_placa" data-value="" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="text-decoration:underline;">Datos Vehículo</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group" id="grupo_placa">
                                <label for="txt_placa">Nro. Placa</label>
                                <input required type="text" class="form-control" id="txt_placa" name="txt_placa" placeholder="Número de placa">
                                <span class="help-block" id="placa_error" style="display:none;">La placa ya existe</span>
                            </div>
                            <div class="col-md-4">
                                <label for="txt_marca">Marca</label>
                                <input required type="text" class="form-control" id="txt_marca" name="txt_marca" placeholder="Marca">
                            </div>
                            <div class="col-md-4">
                                <label for="txt_modelo">Modelo</label>
                                <input required type="text" class="form-control" id="txt_modelo" name="txt_modelo" placeholder="Modelo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="txt_color">Color</label>
                                <input type="text" class="form-control" id="txt_color" name="txt_color" placeholder="Color">
                            </div>
                            <div class="col-md-4">
                                <label for="txt_anio">Año</label>
                                <input type="text" class="form-control" id="txt_anio" name="txt_anio" placeholder="Año">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="text-decoration:underline;">Datos Propietario</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="txt_dni">DNI</label>
                                <input required type="text" class="form-control" id="txt_dni" name="txt_dni" placeholder="DNI">
                            </div>
                            <div class="col-md-4">
                                <label for="txt_nombres">Nombres</label>
                                <input required type="text" class="form-control" id="txt_nombres" name="txt_nombres" placeholder="Nombres">
                            </div>
                            <div class="col-md-4">
                                <label for="txt_apellidos">Apellidos</label>
                                <input required type="text" class="form-control" id="txt_apellidos" name="txt_apellidos" placeholder="Apellidos">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="txt_celular">Celular</label>
                                <input type="text" class="form-control" id="txt_celular" name="txt_celular" placeholder="Celular">
                            </div>
                            <div class="col-md-4">
                                <label for="txt_correo">Correo</label>
                                <input type="email" class="form-control" id="txt_correo" name="txt_correo" placeholder="Correo">
                            </div>
                        </div>
                        <div class="row" style="padding-top:15px;">
                            <div class="col-md-4">
                                <label>
                                    <input id="chk_cliente_prioritario" type="checkbox"> Prioritario
                                </label>
                            </div>                        
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary">Registrar</button>
                </div>
                </form>
                </div>
            </div>
        </div>

        <!-- Div Nuevo Siniestro -->
        <div id="md_nuevosiniestro" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title_siniestro"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_siniestro_nuevo" method="POST">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li id="tab_datosgenerales" class="active"><a href="#generales_siniestro" data-toggle="tab">Datos Generales</a></li>
                                <li id="tab_observaciones_cliente"><a href="#obscliente" data-toggle="tab">Observaciones Cliente</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="generales_siniestro">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="txt_fecha">Fecha</label>
                                            <input required type="text" class="form-control" id="txt_fecha" name="txt_fecha" placeholder="Fecha">
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="txt_nrosiniestro">Número de Siniestro</label>
                                            <input type="text" class="form-control" id="txt_nrosiniestro" name="txt_nrosiniestro" placeholder="Número de siniestro">
                                            
                                        </div>

                                        <div class="col-md-4">
                                            <label for="txt_aseguradora">Aseguradora</label>
                                            <select required class="form-control" id="txt_aseguradora" name="txt_aseguradora" placeholder="Marca">
                                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                                <option value="RIMAC">RIMAC</option>
                                                <option value="PACIFICO">PACIFICO</option>
                                                <option value="MAPFRE">MAPFRE</option>
                                                <option value="LA POSITIVA">LA POSITIVA</option>
                                                <option value="HDI SEGUROS">HDI SEGUROS</option>
                                                <option value="PARTICULAR">PARTICULAR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input id="chk_prioritario" type="checkbox"> Prioritario
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="obscliente">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="txt_observaciones" name="txt_observaciones" rows="10" cols="80">
                                                        
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" data-value="" id="btn_registrar_siniestro" name="btn_enviar" class="btn btn-primary">Registrar</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- Fin Nuevo Siniestro -->

        <!-- Div Ver Siniestros -->
        <div id="md_siniestros" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Ver siniestros de la placa: <span id="modal_title_siniestro_ver"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_siniestro" method="POST">
                        <table id="table_siniestros" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nro siniestro</th>
                                    <th>Observaciones</th>
                                    <th>Inventario</th>
                                    <th>Aseguradora</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                </div>
                <div class="modal-footer">
                    
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Div Siniestros -->

        <!-- Div Nuevas Fotos -->
        <div id="md_fotos" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos"></span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body extrab">
                        <!--div class="container"-->
                            <!-- The file upload form used as target for the file upload widget -->
                            <form id="fileupload" action="https://jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                <div class="row fileupload-buttonbar">
                                    <div class="col-lg-7">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Agregar archivos...</span>
                                            <input type="file" name="files[]" multiple>
                                        </span>
                                        <button type="submit" class="btn btn-primary start">
                                            <i class="glyphicon glyphicon-upload"></i>
                                            <span>Empezar la carga</span>
                                        </button>
                                        <button type="reset" class="btn btn-warning cancel">
                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                            <span>Cancelar la subida</span>
                                        </button>
                                        <!-- The global file processing state -->
                                        <span class="fileupload-process"></span>
                                    </div>
                                    <!-- The global progress state -->
                                    <div class="col-lg-5 fileupload-progress fade">
                                        <!-- The global progress bar -->
                                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                        </div>
                                        <!-- The extended global progress state -->
                                        <div class="progress-extended">&nbsp;</div>
                                    </div>
                                </div>
                                <!-- The table listing the files available for upload/download -->
                                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                            </form>
                        </div>
                        <!-- The blueimp Gallery widget -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                            <div class="slides"></div>
                            <h3 class="title"></h3>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                            <a class="play-pause"></a>
                            <ol class="indicator"></ol>
                        </div>
                        <!-- The template to display files available for upload -->
                        <script id="template-upload" type="text/x-tmpl">
                        {% for (var i=0, file; file=o.files[i]; i++) { %}
                            <tr class="template-upload fade">
                                <td>
                                    <span class="preview"></span>
                                </td>
                                <td>
                                    <p class="name">{%=file.name%}</p>
                                    <strong class="error text-danger"></strong>
                                </td>
                                <td>
                                    <p class="size">Processing...</p>
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                                </td>
                                <td>
                                    {% if (!i && !o.options.autoUpload) { %}
                                        <button class="btn btn-primary start" disabled>
                                            <i class="glyphicon glyphicon-upload"></i>
                                            <span>Iniciar</span>
                                        </button>
                                    {% } %}
                                    {% if (!i) { %}
                                        <button class="btn btn-warning cancel">
                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                            <span>Cancelar</span>
                                        </button>
                                    {% } %}
                                </td>
                            </tr>
                        {% } %}
                        </script>
                        <!-- The template to display files available for download -->
                        <script id="template-download" type="text/x-tmpl">
                        
                        </script>
                    <!--/div-->
                </div>
            </div>
        </div>
        <!-- End Div Nuevas Fotos -->

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
                                                                <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                                    <th>Opciones</th>
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
                                                                <th>Opciones</th>
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
                                                                <th>Opciones</th>
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
                                                                <th>Opciones</th>
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
                                                                <th>Opciones</th>
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
                                                                <th>Opciones</th>
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
                                                                <th>Opciones</th>
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

        <!-- Delete Siniestro -->
        <div class="modal modal-danger fade" id="modal-delete-siniestro">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Eliminar Registro?</h4>
              </div>
              <div class="modal-body">
                <p>Desea eliminar el siniestro?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" data-value="" placa-value="" id="btn_elimina_siniestro" onclick="elimina_siniestro();" class="btn btn-outline">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Siniestro Modal -->

        <!-- No Zip Modal -->
        <div class="modal modal-danger fade" id="modal-zip">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Error</h4>
              </div>
              <div class="modal-body">
                <p>EL SINIESTRO AÚN NO TIENE DOCUMENTOS REGISTRADOS</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_zip" data-dismiss="modal" class="btn btn-outline">Aceptar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End No Zip Modal -->

        <!-- Delete Foto -->
        <div class="modal modal-danger fade" id="modal-delete-foto">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Eliminar Registro?</h4>
              </div>
              <div class="modal-body">
                <p>¿Desea eliminar la foto?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" data-value="" id="btn_elimina_foto" class="btn btn-outline" onclick="elimina_foto()">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Foto -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datepicker.min.js'></script>
<script src='<?PHP echo constant('URL'); ?>views/public/js/bootstrap-datepicker.es.min.js'></script>

<!-- Uploader -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script-->
<!-- blueimp Gallery script -->
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/jquery.fileupload-ui.js"></script>
<!-- CK Editor -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/ckeditor/ckeditor.js"></script>
<!-- End Uploader -->


<script>
    var siniestros = "";
    var placas = "";
    
    $(document).ready(function() {
        var placa = "";
        var opcion = "";

        var options_editor = {
            toolbarGroups: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'forms', groups: [ 'forms' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                '/',
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'about', groups: [ 'about' ] }
            ],
            removeButtons: 'Source,Save,Templates,NewPage,Preview,Print,Undo,Redo,Find,Replace,SelectAll,Scayt,Flash,Image,Link,Unlink,Anchor,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Form,Radio,Checkbox,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Subscript,Superscript,CreateDiv,Blockquote,BidiLtr,BidiRtl,Language,About,PasteFromWord,PasteText,Paste,Copy,Cut'
        };

        CKEDITOR.replace('txt_observaciones', options_editor);
        CKEDITOR.replace('observaciones_cliente_div', options_editor);
        
        $('#txt_fecha').datepicker({
			maxViewMode: 2,
			language: "es"
		});

        $('#txt_fecha').on('changeDate', function(ev){
			$(this).datepicker('hide');
		});

        $('#placas thead th').each( function () {
            var title = $(this).text();
            if(title == "Estado"){
                var select = "<select style='width:70px;' class='form-control'><option value=''>Estado</option><option value='SI'>SI</option><option value='NO'>NO</option></select>";
                $(this).html( select );
            }
            
        } );

		placas = $('#placas').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>placa/getPlacas",
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
                {"data":"marca", "width":"10%"},
                {"data":"modelo", "width":"10%"},
                {"data":"dni"},
                {"data":"nombres"},
                {"data":"apellidos"},
				{"data":"nrosiniestros"},
				{"data":"fecha_registro"},
                {"data":"esprioritario", "width":"4%"},
			],
            "columnDefs":[
                {
                    "targets":9,
                    "data":"descripcion",
                    "render": function(url, type, full){
                        var nroplaca = "'" + full[0] + "'";
                        var marca = "'" + full[1] + "'";
                        var modelo = "'" + full[2] + "'";
                        return '<button onclick="editar_placa('+ nroplaca +');" title="Editar placa" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button onclick="muestra_siniestros('+ nroplaca +','+ marca +','+ modelo +');" title="Ver siniestros" class="btn btn-warning"><i class="fa fa-search"></i></button> <button onclick="alert_elimina('+ nroplaca +');" title="Eliminar placa" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
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
                },
                {
                    text: 'Nuevo',
					action: function ( e, dt, node, config ) {
                        opcion = "nuevo";
                        $('#md_nuevo').modal();
                        $('#frm_placa').attr("data-value", "nuevo");
                        $("#modal_title").html("Nueva Placa");
                        $("#btn_enviar").text("Guardar");
                        $("#txt_placa").val("");
                        $("#txt_placa").focus();
                        $("#txt_marca").val("");
                        $("#txt_modelo").val("");
                        $("#txt_dni").val("");
                        $("#txt_nombres").val("");
                        $("#txt_apellidos").val("");
                        $("#txt_celular").val("");
                        $("#txt_correo").val("");
                        $("#txt_color").val("");
                        $("#txt_anio").val("");
                        $("#chk_cliente_prioritario").prop('checked', false);
                        $("#placa_error").css("display", "none");
                        $("#grupo_placa").removeClass("has-error");
                        $("#txt_placa").removeAttr("disabled");
					}
                }
			]
		} );

        placas.columns().every( function () {
            var that = this;
            $( 'select', this.header() ).on( ' change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

    	$("#frm_siniestro_nuevo").submit(function(event){
            event.preventDefault();
            var nroplaca        = $("#btn_registrar_siniestro").attr("data-value");
            var fecha           = $("#txt_fecha").val();
            var aseguradora     = $("#txt_aseguradora").val();
            var nro_siniestro   = $("#txt_nrosiniestro").val();
            var esprioritario   = 0;
            if ($('#chk_prioritario').is(":checked"))
            {
                esprioritario = 1;
            }
            var observaciones   = CKEDITOR.instances["txt_observaciones"].getData();
            var info = {};
            
            info["fecha_siniestro"]     = fecha;
            info["aseguradora"]         = aseguradora;
            info["nroplaca"]            = nroplaca;
            info["nrosiniestro"]        = nro_siniestro.toUpperCase();
            info["observaciones"]       = observaciones;
            info["esprioritario"]       = esprioritario;
            var myJsonString            = JSON.stringify(info);
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>siniestro/RegistraSiniestro", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    if(result == '23000'){
                        $("#placa_error").show();
                        $("#grupo_placa").addClass("has-error");
                        $("#txt_placa").focus();
                    }else{
                        $('#md_nuevosiniestro').modal('hide');
                        muestra_siniestros(nroplaca, "", "");
                        placas.ajax.reload();	
                    }
                },
                error:function(result){
                    console.log(result);
                }
            });
            
        });

		$("#frm_placa").submit(function(event){
            event.preventDefault();
            var nroplaca    = $("#txt_placa").val();
            var marca       = $("#txt_marca").val();
            var modelo      = $("#txt_modelo").val();
            var color       = $("#txt_color").val();
            var anio        = $("#txt_anio").val();
            var dni         = $("#txt_dni").val();
            var nombres     = $("#txt_nombres").val();
            var apellidos   = $("#txt_apellidos").val();
            var celular     = $("#txt_celular").val();
            var correo      = $("#txt_correo").val();
            var esclienteprioritario   = 0;
            if ($('#chk_cliente_prioritario').is(":checked"))
            {
                esclienteprioritario = 1;
            }
            var info = {};
            
            info["nroplaca"]    = nroplaca.toUpperCase();
            info["marca"]       = marca.toUpperCase();
            info["modelo"]      = modelo.toUpperCase();
            info["color"]       = color.toUpperCase();
            info["anio"]        = anio;
            info["dni"]         = dni.toUpperCase();
            info["nombres"]     = nombres.toUpperCase();
            info["apellidos"]   = apellidos.toUpperCase();
            info["celular"]     = celular;
            info["correo"]      = correo;
            info["esclienteprioritario"]      = esclienteprioritario;
            var myJsonString    = JSON.stringify(info);
            var opcion          = $("#frm_placa").attr("data-value");
            
            if(opcion == "nuevo"){
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>placa/GuardarPlaca", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        if(result == '23000'){
                            $("#placa_error").show();
                            $("#grupo_placa").addClass("has-error");
                            $("#txt_placa").focus();
                        }else{
                            $('#md_nuevo').modal('hide');
                            placas.ajax.reload();	
                            $("#mensaje_confirmacion").html("Se ha registrado el nuevo grupo.");
                            $("#confirm_grupo").show().delay(2000).fadeOut();
                        }
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }

            if(opcion == "editar"){
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>placa/ActualizaPlaca", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        $('#md_nuevo').modal('hide');
                        placas.ajax.reload();	
                        $("#mensaje_confirmacion").html("Se ha actualizado la información de la placa.");
                        $("#confirm_grupo").show().delay(2000).fadeOut();
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }
            
        });
       
        $("#btn_elimina").click(function(){
            var nroplaca = $("#btn_elimina").attr("data-value");
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>placa/EliminaPlaca", 
                data:{
                    datos: '{"nroplaca": "' + nroplaca + '"}'
                },
                success: function(result){
                    console.log(result);
                    $('#modal-delete').modal('hide');
                    placas.ajax.reload();	
                    $("#mensaje_confirmacion").html(result);
                    $("#confirm_grupo").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });
        });

        $('#md_siniestros').on('hidden.bs.modal', function () {
            console.log("cierra siniestros");
        });

        $('#md_verdocumentos').on('hidden.bs.modal', function () {
            //fotos
            console.log("cerrar fotos");
            
        });

        $('#md_nuevosiniestro').on('hidden.bs.modal', function () {
            $('#md_siniestros').modal();
        });
        
        $("#btn_actualizar_observacion").click(function(){
            var info = {};
            info["idsiniestro"]         = $("#btn_actualizar_observacion").attr("data-value");
            info["descripcion"]         = CKEDITOR.instances["observaciones_cliente_div"].getData();
            var myJsonString            = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>siniestro/ActualizaObservacion", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#modal-delete-siniestro').modal('hide');
                    siniestros.ajax.reload();
                    placas.ajax.reload();
                },
                error:function(result){
                    console.log("error"+result);
                }
            });
        });

        $("#btn_registro_inventario").click(function(){
            var dataString = $("#frm_inventario").serialize();
            console.log('Datos serializados: '+dataString);
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>siniestro/InsertaInventario", 
                data: dataString,
                success: function(data) {
                    console.log(data);
                    siniestros.ajax.reload();
                    $('#md_siniestros').modal();
                    $("#modal_inventario").modal('hide');
                }
            });
            return false;
        });
        
    } );

    function muestra_siniestros(nroplaca, marca, modelo){
        $('#md_siniestros').modal();
        $("#modal_title_siniestro_ver").html(nroplaca);
        $("#btn_enviar_siniestro").text("Actualizar");
        $("#txt_inv_placa").val(nroplaca);
        $("#txt_inv_marca").val(marca);
        $("#txt_inv_modelo").val(modelo);

        var info = {};
        info["nroplaca"]    = nroplaca;
        var myJsonString    = JSON.stringify(info);
        
        siniestros = $('#table_siniestros').DataTable( {
            "responsive":true,
            "scrollX":        false,
            "scrollCollapse": true,
            "bDestroy": true,
            "ordering": false,
            "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>siniestro/ListaSiniestros",
                "data": {
                    "datos": myJsonString
                },
                "error": function (jqXHR, textStatus, errorThrown) {
                    console.log("sss");
                }
            },
            "columnDefs":[
                {
                    "targets":0,
                    "data":"fecha_siniestro",
                    "width":"10%"
                },
                {
                    "targets":1,
                    "data":"nrosiniestro",
                    "width":"15%"
                },
                {
                    "targets":2,
                    "data":"descripcion",
                    "render": function(url, type, full){
                        if(full[5] != ""){
                            return '<a href="javascript:ver_observacion('+ full[0] +');">Ver observación</a>'
                        }else{
                            return '<a href="javascript:ver_observacion('+ full[0] +');">Registrar observación</a>'
                        }
                        
                        return false;
                    },
                    "width":"10%"
                },
                {
                    "targets":3,
                    "data":"idinventario",
                    "render": function(url, type, full){
                        if(full[6] != ""){
                            return '<a href="javascript:ver_inventario_pdf('+ full[0] +');">Ver inventario</a>'
                        }else{
                            return '<a href="javascript:ver_inventario('+ full[0] +');">Registrar inventario</a>'
                        }
                        
                        return false;
                    },
                    "width":"10%"
                },
                {
                    "targets":4,
                    "data":"aseguradora",
                    "width":"15%"
                },
                {
                    "targets":5,
                    "data":"estado",
                    "width":"10%"
                },
                {
                    "targets":6,
                    "data":"idsiniestro",
                    "render": function(url, type, full){
                        console.log(url);
                        var nroplaca = "'" + full[7] + "'";
                        return '<button title="Ver documentos" type="button" onclick="show_muestra_documentos('+ full[0] +');" class="btn btn-warning"><i class="fa fa-file"></i></button> <button title="Eliminar siniestro" type="button" onclick="alerta_elimina_siniestro('+ full[0] +', '+ nroplaca +');" class="btn btn-danger"><i class="fa fa-trash"></i></button> <button title="Descargar documentos" type="button" onclick="descarga_siniestro('+ full[0] +');" class="btn btn-success"><i class="fa fa-download"></i></button>'
                        return false;
                    },
                    "width":"40%"
                }
            ],
            "language":{
                "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                {
                    text: 'Nuevo',
                    action: function ( e, dt, node, config ) {
                        opcion = "nuevo";
                        $("#tab_datosgenerales").addClass("active");
                        $("#tab_observaciones_cliente").removeClass("active");
                        $("#generales_siniestro").addClass("active");
                        $("#obscliente").removeClass("active");
                        $("#chk_prioritario").prop('checked', false);
                        $('#md_siniestros').modal('hide');
                        $('#md_nuevosiniestro').modal();
                        $("#modal_title_siniestro").html("Nuevo Siniestro");
                        $("#btn_enviar").text("Guardar");
                        $("#btn_registrar_siniestro").attr("data-value", nroplaca);
                        $("#txt_fecha").val("");
                        $("#txt_aseguradora").val("");
                        $("#txt_nrosiniestro").val("");
                        CKEDITOR.instances.txt_observaciones.setData("");
                    }
                }
            ]
        } );
    }

    function descarga_siniestro(idsiniestro){
        console.log("descarga");
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>siniestro/ZipSiniestro", 
            data:{
                datos: '{"idsiniestro": ' + idsiniestro + '}'
            },
            dataType : 'json',
            success: function(result){
                var datos = JSON.parse(result);
                if(datos.estado == 1){
                    window.location = datos.file;
                }else{
                    $("#modal-zip").modal();
                }
            },
            error:function(result){
                console.log(result);
            }
        });
    }

    function alerta_elimina_siniestro(idsiniestro, nroplaca){
        $('#modal-delete-siniestro').modal();
        $('#btn_elimina_siniestro').attr("data-value", idsiniestro);
        $('#btn_elimina_siniestro').attr("placa-value", nroplaca);
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
                },
                {
                    "targets":2,
                    "data":"idfoto",
                    "render": function(url, type, full){
                        console.log(url);
                        return '<button type="button" onclick="show_elimina_foto('+ full[0] +');" class="delete btn btn-danger"><i class="fa fa-trash"></i></button>'
                        return false;
                    },
                    "width":"20%"
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
                {"data":"idfoto"}
            ],
            "dom": 'Bfrtip',
            "buttons": [
                {
                    text: 'Nuevo',
                    action: function ( e, dt, node, config ) {
                        opcion = "nuevo";
                        $('#md_fotos').modal();
                        $('#md_verdocumentos').modal('hide');
                        
                        $("#modal_title_fotos").html("Agregar Fotos");
                        $("#btn_enviar").text("Guardar");
                        
                        $('#fileupload').fileupload({
                            url: '<?PHP echo constant('URL'); ?>foto/Subir',
                            formData: { 
                                'idsiniestro': idsiniestro, 
                                'idtipofoto' : tipo
                            }
                            
                        });

                        $('#fileupload').bind('fileuploadsubmit', function (e, data) {
                            var inputs = data.context.find(':input');
                            if (inputs.filter(function () {
                                    return !this.value && $(this).prop('required');
                                }).first().focus().length) {
                                data.context.find('button').prop('disabled', false);
                                return false;
                            }
                            var datos = inputs.serializeArray();
                            //data.formData = inputs.serializeArray();
                            data.formData = { 
                                'idsiniestro': idsiniestro, 
                                'idtipofoto' : tipo
                            }
                        });

                        $('#fileupload').bind('fileuploaddone', function (e, data) {
                            $('#md_fotos').modal('hide');
                            $('#md_verdocumentos').modal();
                            $("#mensaje_confirmacion_documento").html("Se han registrado los documentos.");
                            $("#confirm_documentos").show().delay(2000).fadeOut();
                            refresh_tables();
                        });
                    }
                }
            ]
        } );

        return tabla;
    }  

    function show_elimina_foto(valor){
        $("#modal-delete-foto").modal();
        $("#btn_elimina_foto").attr("data-value", valor);
    }

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

    function elimina_foto(val)
    {
        var idfoto = $("#btn_elimina_foto").attr('data-value');
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>foto/EliminaFoto", 
            data:{
                datos: '{"idfoto": ' + idfoto + '}'
            },
            success: function(result){
                console.log(result);
                $('#modal-delete-foto').modal('hide');
                refresh_tables();
            },
            error:function(result){
                console.log("error"+result);
            }
        });
    }

    function refresh_tables()
    {
        presupuestos.ajax.reload();	
        cartas.ajax.reload();	
        generales.ajax.reload();	
        etaller.ajax.reload();
        fotos_inspeccion.ajax.reload();
        fotos_repuestos.ajax.reload();
        fotos_siniestro.ajax.reload();
        fotos_terminado.ajax.reload();
        fotos_tablero.ajax.reload();
        fotos_interior.ajax.reload();
        fotos_credito.ajax.reload();
        fotos_guia.ajax.reload();
        inventarios.ajax.reload();
        franquicias.ajax.reload();
		proveedores.ajax.reload();
		otrosdocs.ajax.reload();
    }

    function elimina_siniestro()
    {
        var idsiniestro = $("#btn_elimina_siniestro").attr('data-value');
        var placa = $("#btn_elimina_siniestro").attr('placa-value');
        console.log(placa);
        console.log(idsiniestro);
        var info = {};
        info["idsiniestro"]    = idsiniestro;
        info["nroplaca"]       = placa;
        var myJsonString    = JSON.stringify(info);

        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>siniestro/EliminaSiniestro", 
            data:{
                datos: myJsonString
            },
            success: function(result){
                console.log(result);
                $('#modal-delete-siniestro').modal('hide');
                siniestros.ajax.reload();
                placas.ajax.reload();
            },
            error:function(result){
                console.log("error"+result);
            }
        });
        $("#modal-delete-siniestro").modal('hide');

    }

    function limpiar_selects_inventario()
    {
        $('#sl_inv_tarjpropiedad').empty();
        $('#sl_inv_soat').empty();
        $('#sl_inv_llaveencendido').empty();
        $('#sl_inv_encendedor').empty();
        $('#sl_inv_aireacondicionado').empty();
        $('#sl_inv_cenicero').empty();
        $('#sl_inv_claxon').empty();
        $('#sl_inv_luzsalon').empty();
        $('#sl_inv_parlantes').empty();
        $('#sl_inv_correasseguridad').empty();
        $('#sl_inv_controlalarma').empty();
        $('#sl_inv_asientos').empty();
        $('#sl_inv_pisos').empty();
        $('#sl_inv_espejointerior').empty();
        $('#sl_inv_libroservicio').empty();
        $('#sl_inv_juegoherramientas').empty();
        $('#sl_inv_juegoseguroaros').empty();
        $('#sl_inv_juegosegurovasos').empty();
        $('#sl_inv_radiocd').empty();
        $('#sl_inv_injecagua').empty();
        $('#sl_inv_trabagas').empty();
        $('#sl_inv_mascara').empty();
        $('#sl_inv_seguroruedas').empty();
        $('#sl_inv_revocular').empty();
        $('#sl_inv_cajacd').empty();

        $('#sl_inv_antenas').empty();
        $('#sl_inv_espejoexterior').empty();
        $('#sl_inv_vasosrueda').empty();
        $('#sl_inv_brazosplumillas').empty();
        $('#sl_inv_direccionales').empty();
        $('#sl_inv_llantas').empty();
        $('#sl_inv_aros').empty();
        $('#sl_inv_farosdelanteros').empty();
        $('#sl_inv_farosposteriores').empty();
        $('#sl_inv_emblemas').empty();
        $('#sl_inv_escarpines').empty();
        $('#sl_inv_tapagasolina').empty();
        $('#sl_inv_llantarepuesto').empty();
        $('#sl_inv_gatapalanca').empty();
        $('#sl_inv_manijas').empty();
        $('#sl_inv_llaveruedas').empty();
        $('#sl_inv_tapaaceite').empty();
        $('#sl_inv_tapaliquido').empty();
        $('#sl_inv_tapaliquidoembrague').empty();
        $('#sl_inv_taparadiador').empty();
        $('#sl_inv_varillaaceite').empty();
        $('#sl_inv_tapicesalfombras').empty();
        $('#sl_inv_parabrisas').empty();
        $('#sl_inv_lunaspuertas').empty();
        $('#sl_inv_copasvasos').empty();
        $('#sl_inv_chapapuertas').empty();
        $('#sl_inv_alarma').empty();
        $('#sl_inv_otros').empty();
    }

    function ver_inventario_pdf(idsiniestro)
    {
        window.open("<?PHP echo constant('URL'); ?>/views/uploads/inventario/registro-" + idsiniestro + ".pdf");
    }

    function ver_inventario(idsiniestro)
    {
        limpiar_selects_inventario();
        $('#md_siniestros').modal('hide');
        $("#modal_inventario").modal();
        $("#txt_inv_siniestro").val(idsiniestro);
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>siniestro/ListaEstadosInventario", 
            success: function(result){
                var datos = JSON.parse(result);
                var default_value = "<option value=''>SELECCIONAR</option>";
                $('#sl_inv_tarjpropiedad').append(default_value);
                $('#sl_inv_soat').append(default_value);
                $('#sl_inv_llaveencendido').append(default_value);
                $('#sl_inv_encendedor').append(default_value);
                $('#sl_inv_aireacondicionado').append(default_value);
                $('#sl_inv_cenicero').append(default_value);
                $('#sl_inv_claxon').append(default_value);
                $('#sl_inv_luzsalon').append(default_value);
                $('#sl_inv_parlantes').append(default_value);
                $('#sl_inv_correasseguridad').append(default_value);
                $('#sl_inv_controlalarma').append(default_value);
                $('#sl_inv_asientos').append(default_value);
                $('#sl_inv_pisos').append(default_value);
                $('#sl_inv_espejointerior').append(default_value);
                $('#sl_inv_libroservicio').append(default_value);
                $('#sl_inv_juegoherramientas').append(default_value);
                $('#sl_inv_juegoseguroaros').append(default_value);
                $('#sl_inv_juegosegurovasos').append(default_value);
                $('#sl_inv_radiocd').append(default_value);
                $('#sl_inv_injecagua').append(default_value);
                $('#sl_inv_trabagas').append(default_value);
                $('#sl_inv_mascara').append(default_value);
                $('#sl_inv_seguroruedas').append(default_value);
                $('#sl_inv_revocular').append(default_value);
                $('#sl_inv_cajacd').append(default_value);

                $('#sl_inv_antenas').append(default_value);
                $('#sl_inv_espejoexterior').append(default_value);
                $('#sl_inv_vasosrueda').append(default_value);
                $('#sl_inv_brazosplumillas').append(default_value);
                $('#sl_inv_direccionales').append(default_value);
                $('#sl_inv_llantas').append(default_value);
                $('#sl_inv_aros').append(default_value);
                $('#sl_inv_farosdelanteros').append(default_value);
                $('#sl_inv_farosposteriores').append(default_value);
                $('#sl_inv_emblemas').append(default_value);
                $('#sl_inv_escarpines').append(default_value);
                $('#sl_inv_tapagasolina').append(default_value);
                $('#sl_inv_llantarepuesto').append(default_value);
                $('#sl_inv_gatapalanca').append(default_value);
                $('#sl_inv_manijas').append(default_value);
                $('#sl_inv_llaveruedas').append(default_value);
                $('#sl_inv_tapaaceite').append(default_value);
                $('#sl_inv_tapaliquido').append(default_value);
                $('#sl_inv_tapaliquidoembrague').append(default_value);
                $('#sl_inv_taparadiador').append(default_value);
                $('#sl_inv_varillaaceite').append(default_value);
                $('#sl_inv_tapicesalfombras').append(default_value);
                $('#sl_inv_parabrisas').append(default_value);
                $('#sl_inv_lunaspuertas').append(default_value);
                $('#sl_inv_copasvasos').append(default_value);
                $('#sl_inv_chapapuertas').append(default_value);
                $('#sl_inv_alarma').append(default_value);
                $('#sl_inv_otros').append(default_value);

                for(var x=0;x < datos.data.length;x++){
                    var valor = "<option value='"+ datos.data[x].idestadoinventario +"'>"+ datos.data[x].descripcion +"</option>";
                    $('#sl_inv_tarjpropiedad').append(valor);
                    $('#sl_inv_soat').append(valor);
                    $('#sl_inv_llaveencendido').append(valor);
                    $('#sl_inv_encendedor').append(valor);
                    $('#sl_inv_aireacondicionado').append(valor);
                    $('#sl_inv_cenicero').append(valor);
                    $('#sl_inv_claxon').append(valor);
                    $('#sl_inv_luzsalon').append(valor);
                    $('#sl_inv_parlantes').append(valor);
                    $('#sl_inv_correasseguridad').append(valor);
                    $('#sl_inv_controlalarma').append(valor);
                    $('#sl_inv_asientos').append(valor);
                    $('#sl_inv_pisos').append(valor);
                    $('#sl_inv_espejointerior').append(valor);
                    $('#sl_inv_libroservicio').append(valor);
                    $('#sl_inv_juegoherramientas').append(valor);
                    $('#sl_inv_juegoseguroaros').append(valor);
                    $('#sl_inv_juegosegurovasos').append(valor);
                    $('#sl_inv_radiocd').append(valor);
                    $('#sl_inv_injecagua').append(valor);
                    $('#sl_inv_trabagas').append(valor);
                    $('#sl_inv_mascara').append(valor);
                    $('#sl_inv_seguroruedas').append(valor);
                    $('#sl_inv_revocular').append(valor);
                    $('#sl_inv_cajacd').append(valor);

                    $('#sl_inv_antenas').append(valor);
                    $('#sl_inv_espejoexterior').append(valor);
                    $('#sl_inv_vasosrueda').append(valor);
                    $('#sl_inv_brazosplumillas').append(valor);
                    $('#sl_inv_direccionales').append(valor);
                    $('#sl_inv_llantas').append(valor);
                    $('#sl_inv_aros').append(valor);
                    $('#sl_inv_farosdelanteros').append(valor);
                    $('#sl_inv_farosposteriores').append(valor);
                    $('#sl_inv_emblemas').append(valor);
                    $('#sl_inv_escarpines').append(valor);
                    $('#sl_inv_tapagasolina').append(valor);
                    $('#sl_inv_llantarepuesto').append(valor);
                    $('#sl_inv_gatapalanca').append(valor);
                    $('#sl_inv_manijas').append(valor);
                    $('#sl_inv_llaveruedas').append(valor);
                    $('#sl_inv_tapaaceite').append(valor);
                    $('#sl_inv_tapaliquido').append(valor);
                    $('#sl_inv_tapaliquidoembrague').append(valor);
                    $('#sl_inv_taparadiador').append(valor);
                    $('#sl_inv_varillaaceite').append(valor);
                    $('#sl_inv_tapicesalfombras').append(valor);
                    $('#sl_inv_parabrisas').append(valor);
                    $('#sl_inv_lunaspuertas').append(valor);
                    $('#sl_inv_copasvasos').append(valor);
                    $('#sl_inv_chapapuertas').append(valor);
                    $('#sl_inv_alarma').append(valor);
                    $('#sl_inv_otros').append(valor);

                    $("#txt_inv_recepcionista").val('<?PHP echo($_SESSION['usuario']); ?>');
                    $("#txt_inv_ingreso").val('<?PHP echo(date("d/m/Y")); ?>');
                    $("#txt_inv_hora").val('<?php echo gmdate("H:i", (time() + (-5*3600)) ); ?>');
                }
            },
            error:function(result){
                console.log("error"+result);
            }
        });
    }

    function ver_observacion(idsiniestro)
    {
        $("#modal_observaciones").modal();
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>siniestro/GetObservacion", 
            data:{
                datos: '{"idsiniestro": ' + idsiniestro + '}'
            },
            success: function(result){
                var datos = JSON.parse(result);
                console.log(datos);
                CKEDITOR.instances.observaciones_cliente_div.setData(datos[0].descripcion);
                $('#md_siniestros').modal('hide');
                $('#btn_actualizar_observacion').attr("data-value", idsiniestro);        
            },
            error:function(result){
                console.log("error"+result);
            }
        });
    }

    function alert_elimina(nroplaca)
    {
        $('#modal-delete').modal();
        $('#sp_grupo').html(nroplaca);
        $("#btn_elimina").attr("data-value", nroplaca);
    }

    function editar_placa(nroplaca)
    {
        $('#md_nuevo').modal();
        $("#modal_title").html("Actualizar Placa");
        $("#btn_enviar").text("Actualizar");
        $("#txt_placa").attr("disabled", "disabled");
        $("#frm_placa").attr("data-value", "editar");
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>placa/VerPlaca", 
            data:{
                datos: '{"nroplaca": "' + nroplaca + '"}'
            },
            success: function(result){
                var datos = jQuery.parseJSON(result);
                $("#txt_placa").val(datos.nroplaca);
                $("#txt_marca").val(datos.marca);
                $("#txt_modelo").val(datos.modelo);
                $("#txt_color").val(datos.color);
                $("#txt_anio").val(datos.anio);
                $("#txt_dni").val(datos.dni);
                $("#txt_nombres").val(datos.nombres);
                $("#txt_apellidos").val(datos.apellidos);
                $("#txt_correo").val(datos.correo);
                $("#txt_celular").val(datos.celular);
                if(datos.esprioritario == "1"){
                    $("#chk_cliente_prioritario").prop('checked', true);
                }else{
                    $("#chk_cliente_prioritario").prop('checked', false);
                }
                console.log(nroplaca);
            },
            error:function(result){
                console.log(result);
            }
        });
    }

    $('#modal_observaciones').on('hidden.bs.modal', function () {
        $("#modal_observaciones").modal('hide');
        $('#md_siniestros').modal();
        $('body').css("padding-right", "0px");
    });

    $('#modal_inventario').on('hidden.bs.modal', function () {
        $("#modal_inventario").modal('hide');
        $('#md_siniestros').modal();
        $('body').css("padding-right", "0px");
    });
    
</script>
<!-- The main application script -->
<script src="<?PHP echo constant('URL'); ?>views/public/js/main.js"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
     </body>
</html>