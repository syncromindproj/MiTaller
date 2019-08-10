<?PHP require 'views/header.php'; ?>
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/jquery.fileupload-ui-noscript.css"></noscript>

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

                            <div id="confirm_documentos" class="alert alert-success alert-dismissible" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                <span id="mensaje_confirmacion_documento"></span>
                            </div>

                            <table id="documentos_table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Descripcion</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

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
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

<script>
    $(document).ready(function() {
        documentos = CrearDatatable("documentos_table");
    });

    function CrearDatatable(tabla){
        var info = {};
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
                            return '<a target="_blank" href="<?PHP echo constant('URL'); ?>/'+full[1]+'"><img width="50" src="<?PHP echo constant('URL'); ?>'+full[1]+'"/></a>';
                        }
                        
                        if(extension[1] == "pdf"){
                            return '<a target="_blank" href="<?PHP echo constant('URL'); ?>/'+full[1]+'"><img width="50" src="<?PHP echo constant('URL'); ?>/views/public/img/pdf-icon-200.png"/></a>';
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
                    "data":"iddocumento_contable",
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
                "url": "<?PHP echo constant('URL'); ?>foto/ListaDocumentosContables",
                
            },
            "language":{
                "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "columns":[
                {"data":"ruta"},
                {"data":"descripcion"},
                {"data":"iddocumento_contable"}
            ],
            "dom": 'Bfrtip',
            "buttons": [
                {
                    text: 'Nuevo',
                    action: function ( e, dt, node, config ) {
                        opcion = "nuevo";
                        $('#md_fotos').modal();
                        
                        $("#modal_title_fotos").html("Agregar Documentos");
                        $("#btn_enviar").text("Guardar");
                        
                        $('#fileupload').fileupload({
                            url: '<?PHP echo constant('URL'); ?>foto/SubirDocumento',
                            disableImageResize: /Android(?!.*Chrome)|Opera/
                            .test(window.navigator && navigator.userAgent),
                            imageMaxWidth: 950,
                            imageCrop: false, // Force cropped images
                            
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
                            data.formData = { 
                                'txt_comentario' : datos[0].value.toUpperCase()
                            }
                        });

                        $('#fileupload').bind('fileuploaddone', function (e, data) {
                            console.log("terminado");
                            $('#md_fotos').modal('hide');
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

    function refresh_tables()
    {
        documentos.ajax.reload();	
    }

    function show_elimina_foto(valor){
        $("#modal-delete-foto").modal();
        $("#btn_elimina_foto").attr("data-value", valor);
    }

    function elimina_foto(val)
    {
        var idfoto = $("#btn_elimina_foto").attr('data-value');
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>foto/EliminaDocumento", 
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
</script>