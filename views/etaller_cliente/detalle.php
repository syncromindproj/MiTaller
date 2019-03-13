<?PHP require 'views/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
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
                            <input type="hidden" id="txt_cliente" value="<?PHP echo($_SESSION['usuario']); ?>" />
                                <?PHP 
                                    $cont = 0;
                                    $row = $this->etaller['data'];
                                    for($x=0;$x<count($row);$x++){
                                        if($cont==0){
                                            echo("<div class='row'>");
                                        }

                                        if($cont < 4){
                                            echo("<div class='col-md-3'><a href='".constant('URL').$row[$x]['archivo']."' data-toggle='lightbox' data-gallery='galeria-fotos'><img class='img-responsive' src='".constant('URL').$row[$x]['archivo']."' /></a></div>");
                                        }else{
                                            echo("</div>");
                                            echo("<div class='row'>");
                                            $cont = 0;
                                        }
                                        $cont++;
                                    }
                                ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js.map"></script>
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>