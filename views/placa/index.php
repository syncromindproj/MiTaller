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
a
<style>
.modal-dialog{
    overflow-y: initial !important
}
.extrab{
    height: 450px;
    overflow-y: auto;
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
                                <th>Nro Placa</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Siniestros</th>
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
                            <li id="tab_observaciones_siniestro_ver"><a href="#obssiniestro_ver" data-toggle="tab">Observaciones del Siniestro</a></li>
                            <li id="tab_observaciones_trabajos_ver"><a href="#obstrabajos_ver" data-toggle="tab">Trabajos Adicionales</a></li>
                            <li id="tab_observaciones_ocurrencias_ver"><a href="#obsocurrencias_ver" data-toggle="tab">Ocurrencias</a></li>
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
                            <div class="tab-pane" id="obssiniestro_ver">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <textarea id="observaciones_siniestros_div">

                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="obstrabajos_ver">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <textarea id="observaciones_trabajos_div">

                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="obsocurrencias_ver">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <textarea id="observaciones_ocurrencias_div">

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
                    <form id="frm_placa" method="POST">
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
                                <input required type="text" class="form-control" id="txt_color" name="txt_color" placeholder="Color">
                            </div>
                            <div class="col-md-4">
                                <label for="txt_anio">Año</label>
                                <input required type="text" class="form-control" id="txt_anio" name="txt_anio" placeholder="Año">
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
                                <input required type="text" class="form-control" id="txt_celular" name="txt_celular" placeholder="Celular">
                            </div>
                            <div class="col-md-4">
                                <label for="txt_correo">Correo</label>
                                <input required type="email" class="form-control" id="txt_correo" name="txt_correo" placeholder="Correo">
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
                                <li id="tab_observaciones_siniestro"><a href="#obssiniestro" data-toggle="tab">Observaciones del Siniestro</a></li>
                                <li id="tab_observaciones_trabajos"><a href="#obstrabajos" data-toggle="tab">Trabajos Adicionales</a></li>
                                <li id="tab_observaciones_ocurrencias"><a href="#obsocurrencias" data-toggle="tab">Ocurrencias</a></li>
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
                                            </select>
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
                                <div class="tab-pane" id="obssiniestro">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="txt_observaciones_siniestro" name="txt_observaciones_siniestro" rows="10" cols="80">
                                                        
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="obstrabajos">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="txt_observaciones_trabajos" name="txt_observaciones_trabajos" rows="10" cols="80">
                                                        
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="obsocurrencias">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="txt_observaciones_ocurrencias" name="txt_observaciones_ocurrencias" rows="10" cols="80">
                                                        
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
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
                                    <input name="txt_comentario[]" placeholder="Comentario"></input>
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
                                        <li id="tab_presupuestos"><a href="#presupuesto" data-toggle="tab">Presupuesto</a></li>
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
                                                            <li id="tab_fotos_repuestos"><a href="#fotos_repuestos" data-toggle="tab">Repuestos</a></li>
                                                            <li id="tab_fotos_inspeccion"><a href="#fotos_inspeccion" data-toggle="tab">Inspección</a></li>
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
                <button type="button" id="btn_elimina" class="btn btn-outline">Eliminar</button>
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
                <button type="button" data-value="" id="btn_elimina_siniestro" onclick="elimina_siniestro();" class="btn btn-outline">Eliminar</button>
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
        CKEDITOR.replace('observaciones_siniestros_div', options_editor);
        CKEDITOR.replace('observaciones_trabajos_div', options_editor);
        CKEDITOR.replace('observaciones_ocurrencias_div', options_editor);
        
        CKEDITOR.replace('txt_observaciones_siniestro', options_editor);
        CKEDITOR.replace('txt_observaciones_trabajos', options_editor);
        CKEDITOR.replace('txt_observaciones_ocurrencias', options_editor);

        $('#txt_fecha').datepicker({
			maxViewMode: 2,
			language: "es"
		});

        $('#txt_fecha').on('changeDate', function(ev){
			$(this).datepicker('hide');
		});

		placas = $('#placas').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>placa/getPlacas",
			"responsive":true,
			"scrollX":        false,
			"scrollCollapse": true,
            "bDestroy": true,
			"fixedColumns":   {
				"leftColumns": 2
			},
			"language":{
				"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"columns":[
				{"data":"nroplaca", "width":"10%"},
                {"data":"marca"},
                {"data":"modelo"},
                {"data":"dni"},
                {"data":"nombres"},
                {"data":"apellidos"},
				{"data":"nrosiniestros"},
				{
                    data: null,
                    className: "centerd",
                    defaultContent: '<button title="Editar placa" class="edit btn btn-primary"><i class="fa fa-pencil"></i></button> <button title="Ver siniestros" class="siniestro btn btn-warning"><i class="fa fa-search"></i></button> <button title="Eliminar placa" class="delete btn btn-danger"><i class="fa fa-trash"></i></button>'
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
                        $("#modal_title").html("Nueva Placa");
                        $("#btn_enviar").text("Guardar");
                        $("#txt_placa").val("");
                        $("#txt_placa").focus();
                        $("#txt_marca").val("");
                        $("#txt_modelo").val("");
                        $("#txt_dni").val("");
                        $("#txt_nombres").val("");
                        $("#txt_apellidos").val("");
                        $("#placa_error").css("display", "none");
                        $("#grupo_placa").removeClass("has-error");
                        $("#txt_placa").removeAttr("disabled");
					}
                }
			]
		} );

        
		$("#frm_siniestro_nuevo").submit(function(event){
            event.preventDefault();
            var fecha           = $("#txt_fecha").val();
            var aseguradora     = $("#txt_aseguradora").val();
            var nro_siniestro   = $("#txt_nrosiniestro").val();
            var observaciones   = CKEDITOR.instances["txt_observaciones"].getData();
            var obssiniestro    = CKEDITOR.instances["txt_observaciones_siniestro"].getData();
            var obstrabajos     = CKEDITOR.instances["txt_observaciones_trabajos"].getData();
            var obsocurrencias  = CKEDITOR.instances["txt_observaciones_ocurrencias"].getData();
            var info = {};
            
            info["fecha_siniestro"]     = fecha;
            info["aseguradora"]         = aseguradora;
            info["nroplaca"]            = nroplaca;
            info["nrosiniestro"]        = nro_siniestro.toUpperCase();
            info["observaciones"]       = observaciones;
            info["obs_siniestro"]       = obssiniestro;
            info["obs_adicionales"]     = obstrabajos;
            info["obs_ocurrencias"]     = obsocurrencias;
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
                        muestra_siniestros(nroplaca);
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
            var myJsonString    = JSON.stringify(info);
            
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

        $('#placas tbody').on( 'click', 'button', function () {
            var data = placas.row( $(this).parents('tr') ).data();
            nroplaca = data['nroplaca'];
            var descripcion = data['descripcion'];
            
            var option = $(this)[0].classList[0];
            if(option == "edit"){
                opcion = "editar";
                $('#md_nuevo').modal();
                $("#modal_title").html("Actualizar Placa");
                $("#btn_enviar").text("Actualizar");
                $("#txt_placa").attr("disabled", "disabled");
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
                        console.log(nroplaca);
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }

            if(option == "delete"){
                $('#modal-delete').modal();
                $('#sp_grupo').html(nroplaca);
            }

            if(option == "siniestro"){
                muestra_siniestros(nroplaca);
            }
        });
       
        $("#btn_elimina").click(function(){
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
            info["obs_siniestros"]      = CKEDITOR.instances["observaciones_siniestros_div"].getData();
            info["obs_trabajos"]        = CKEDITOR.instances["observaciones_trabajos_div"].getData();
            info["obs_ocurrencias"]     = CKEDITOR.instances["observaciones_ocurrencias_div"].getData();
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
        
    } );

    function muestra_siniestros(nroplaca){
        $('#md_siniestros').modal();
        $("#modal_title_siniestro_ver").html(nroplaca);
        $("#btn_enviar_siniestro").text("Actualizar");
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
                    "width":"15%"
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
                    "width":"15%"
                },
                {
                    "targets":3,
                    "data":"aseguradora",
                    "width":"15%"
                },
                {
                    "targets":4,
                    "data":"estado",
                    "width":"15%"
                },
                {
                    "targets":5,
                    "data":"idsiniestro",
                    "render": function(url, type, full){
                        console.log(url);
                        return '<button title="Ver documentos" type="button" onclick="show_muestra_documentos('+ full[0] +');" class="btn btn-warning"><i class="fa fa-file"></i></button> <button title="Eliminar siniestro" type="button" onclick="alerta_elimina_siniestro('+ full[0] +');" class="btn btn-danger"><i class="fa fa-trash"></i></button> <button title="Descargar documentos" type="button" onclick="descarga_siniestro('+ full[0] +');" class="btn btn-success"><i class="fa fa-download"></i></button>'
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
                        $('#md_siniestros').modal('hide');
                        $('#md_nuevosiniestro').modal();
                        $("#modal_title_siniestro").html("Nuevo Siniestro");
                        $("#btn_enviar").text("Guardar");
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

    function alerta_elimina_siniestro(idsiniestro){
        $('#modal-delete-siniestro').modal();
        $('#btn_elimina_siniestro').attr("data-value", idsiniestro);
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
                            url: 'foto/Subir',
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
                                'idtipofoto' : tipo,
                                'txt_comentario' : datos[0].value.toUpperCase()
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
        console.log(idsiniestro);
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>siniestro/EliminaSiniestro", 
            data:{
                datos: '{"idsiniestro": ' + idsiniestro + '}'
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
                CKEDITOR.instances.observaciones_siniestros_div.setData(datos[0].obs_siniestro);
                CKEDITOR.instances.observaciones_trabajos_div.setData(datos[0].obs_adicionales);
                CKEDITOR.instances.observaciones_ocurrencias_div.setData(datos[0].obs_ocurrencias);
                $('#md_siniestros').modal('hide');
                $('#btn_actualizar_observacion').attr("data-value", idsiniestro);        
            },
            error:function(result){
                console.log("error"+result);
            }
        });
    }

    $('#modal_observaciones').on('hidden.bs.modal', function () {
        $("#modal_observaciones").modal('hide');
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