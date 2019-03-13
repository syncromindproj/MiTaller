<ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVEGACIÓN</li>
    <!-- Optionally, you can add icons to the links -->
    <?PHP
        if(isset($_SESSION['tipo']) && $_SESSION['tipo'] != 'CLI'){
    ?>
    <li><a href="<?PHP echo constant('URL'); ?>panel"><i class="fa fa-tachometer"></i> <span>Panel de Administración</span></a></li>
    <li><a href="<?PHP echo constant('URL'); ?>placa"><i class="fa fa-link"></i> <span>Placas</span></a></li>
    <li><a href="<?PHP echo constant('URL'); ?>etaller"><i class="fa fa-link"></i> <span>E-taller</span></a></li>
    <?PHP }elseif($_SESSION['tipo'] == 'CLI'){ ?>
        <li><a href="<?PHP echo constant('URL'); ?>etaller_cliente"><i class="fa fa-link"></i> <span>E-taller</span></a></li>
    <?PHP } ?>
</ul>