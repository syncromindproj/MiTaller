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
                <li><a href="#">E-taller</a></li>
                <li class="active">Listado de Registros</li>
            </ol>
        </section>

        <!-- Delete Modal -->
        <div class="modal modal-danger fade" id="modal_delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Eliminar Registro?</h4>
              </div>
              <div class="modal-body">
                <p>¿Desea eliminar el registro?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_elimina" data-placa="" data-value="" class="btn btn-outline">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Modal -->

        <!-- Div Listado Fotos -->
        <div id="md_listadofotos" class="modal" tabindex="-1" role="dialog">
            <!-- Delete Fotos Modal -->
            <div class="modal modal-danger fade" id="modal_delete_fotos">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">¿Eliminar Registro?</h4>
                    </div>
                    <div class="modal-body">
                        <p>¿Desea eliminar el registro?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn_elimina_foto" data-src="" data-value="" class="btn btn-outline">Eliminar</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End Delete Fotos Modal -->

            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><span id="modal_title_fotos"></span></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="fotos_tabla" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Fecha</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                    </table>         
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
        <!-- Fin Listado Fotos -->


        <!-- Div Nuevas Fotos -->
        <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos">E-taller Registro de Fotos</span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body extrab">
                        <form id="fileupload" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="txt_placa">Nro. Placa</label>
                                <select required class="form-control" id="txt_placa" name="txt_placa" ></select>
                            </div>
                            <div class="col-md-4">
                                <label for="txt_fecha">Fecha</label>
                                <input required type="text" class="form-control" id="txt_fecha" name="txt_fecha" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- The file upload form used as target for the file upload widget -->
                                    <!--form id="fileupload" method="POST" enctype="multipart/form-data"-->
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
                            </div>
                        </div>
                            
                </div>
            </div>
        </div>
        <!-- End Div Nuevas Fotos -->


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

                            <table id="etaller_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Placa</th>
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

<script>
    var etaller = "";
    var fotos = "";
    $(document).ready(function() {
        //$.fn.dataTable.moment('DD/MM/YYYY');
        $('#txt_fecha').datepicker({
			maxViewMode: 2,
			language: "es"
		});

        $('#txt_fecha').on('changeDate', function(ev){
			$(this).datepicker('hide');
        });
        
        etaller = $('#etaller_tabla').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>etaller/GetEtaller",
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
			"columnDefs":[
                {
                    "targets":0,
                    "data":"nroplaca",
                    "width":"15%"
                },
                {
                    "targets":1,
                    "data":"total",
                    "width":"15%"
                },
                {
                    "targets":2,
                    "data":"idetaller",
                    "render": function(url, type, full){
                        var id          = "'" + full[0] + "'";
                        var nroplaca    = "'" + full[1] + "'";
                        return '<button onclick="muestra_fotos('+ nroplaca +');" title="Ver siniestros" class="btn btn-warning"><i class="fa fa-search"></i></button> <button onclick="alert_elimina('+ id +', '+ nroplaca +');" title="Eliminar placa" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                        return false;
                    },
                    "width":"15%"
                }
            ],
			"dom": 'Bfrtip',
			"buttons": [
				{
                    text: 'Nuevo',
					action: function ( e, dt, node, config ) {
                        $("#md_nuevo").modal();        
                        $("#txt_placa").empty();
                        $("#txt_placa").append('<option value="" selected="selected">Seleccione una placa</option>');
        
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "<?PHP echo constant('URL'); ?>etaller/ListadoPlacas", 
                            success: function(result){
                                console.log(result.data);
                                $.each(result.data, function(i,v){
                                    var placa = v.nroplaca;
                                    $("#txt_placa").append('<option value="' + placa +'">'+ placa +'</option>');
                                });
                                
                            },
                            error:function(result){
                                console.log("error"+result);
                            }
                        });

                        $('#fileupload').fileupload({
                            url: '<?PHP echo constant('URL'); ?>etaller/Subir'
                            
                        });

                        $('#fileupload').bind('fileuploadsubmit', function (e, data) {
                            var inputs = data.context.find(':input');
                            var placa = $("#txt_placa").val();
                            var fecha = $("#txt_fecha").val();
                            if (inputs.filter(function () {
                                    return !this.value && $(this).prop('required');
                                }).first().focus().length) {
                                data.context.find('button').prop('disabled', false);
                                return false;
                            }
                            var datos = inputs.serializeArray();
                            data.formData = { 
                                'placa': placa, 
                                'fecha' : fecha
                            }
                        });

                        $('#fileupload').bind('fileuploaddone', function (e, data) {
                            $('#md_nuevo').modal('hide');
                            $("#mensaje_confirmacion_data").html("Se han registrado las fotos.");
                            $("#confirm_data").show().delay(2000).fadeOut();
                            etaller.ajax.reload();
                        });
					}
                }
			]
        } );
        
        $("#btn_elimina").click(function(){
            var id = $("#btn_elimina").attr("data-value");
            var placa = $("#btn_elimina").attr("data-placa");
            var info = {};
            info["id"]      = id;
            info["placa"]   = placa;
            var myJsonString            = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>etaller/EliminaFotosPlaca", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#modal_delete').modal('hide');
                    etaller.ajax.reload();
                },
                error:function(result){
                    console.log("error"+result);
                }
            });
        });

        $("#btn_elimina_foto").click(function(){
            var id              = $("#btn_elimina_foto").attr("data-value");
            var ruta            = $("#btn_elimina_foto").attr("data-src");
            var info            = {};
            info["id"]          = id;
            info["ruta"]        = ruta;
            var myJsonString    = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>etaller/EliminaFoto", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#modal_delete_fotos').modal('hide');
                    $(".modal").css("overflow", "scroll");
                    fotos.ajax.reload();
                    etaller.ajax.reload();
                },
                error:function(result){
                    console.log("error"+result);
                }
            });
        });
        
    });

    function alert_elimina(id, nroplaca){
        $("#modal_delete").modal();
        $("#btn_elimina").attr("data-value", id);
        $("#btn_elimina").attr("data-placa", nroplaca);
        
    }

    function muestra_fotos(placa)
    {
        $("#md_listadofotos").modal();
        $("#modal_title_fotos").html("Listado de fotos: " + placa);
        var info = {};
        info["placa"]    = placa;
        var myJsonString    = JSON.stringify(info);

        fotos = $('#fotos_tabla').DataTable( {
            "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>etaller/ListadoFotos",
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
            "ordering": false,
            "bLengthChange": false,
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
                    "data":"archivo",
                    "render": function(url, type, full){
                        var extension = full['archivo'].split(".");
                        var length = (extension.length) - 1;
                        if(extension[length] == "jpg" || extension[length] == "png" || extension[length] == "gif"){
                            return '<a target="_blank" href="<?PHP echo constant('URL'); ?>/'+full['archivo']+'"><img width="200" src="<?PHP echo constant('URL'); ?>'+full['archivo']+'"/></a>';
                        }
                        
                        if(extension[length] == "pdf"){
                            return '<a target="_blank" href="<?PHP echo constant('URL'); ?>/'+full['archivo']+'"><img width="200" src="<?PHP echo constant('URL'); ?>/views/public/img/pdf-icon-200.png"/></a>';
                        }
                        return false;
                    },
                    "width":"15%"
                },
                {
                    "targets":1,
                    "data":"fecha_str",
                    "width":"15%"
                },
                {
                    "targets":2,
                    "data":"idetaller",
                    "render": function(url, type, full){
                        var id          = "'" + full[0] + "'";
                        var ruta        = "'" + full['archivo'] + "'";
                        return '<button onclick="alert_elimina_foto('+ id +', '+ruta+');" title="Eliminar placa" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                        return false;
                    },
                    "width":"15%"
                }
            ]
        } );
    }

    function alert_elimina_foto(id, ruta)
    {
        $("#modal_delete_fotos").modal();
        $("#btn_elimina_foto").attr("data-value", id);
        $("#btn_elimina_foto").attr("data-src", ruta);
    }
</script>