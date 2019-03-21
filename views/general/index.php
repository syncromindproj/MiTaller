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