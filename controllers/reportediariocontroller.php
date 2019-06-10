<?PHP
class ReportediarioController extends Controller{
    function __construct(){
        parent::__construct();
    }

    function render(){
        $this->view->title = "Reporte Diario";
        $this->view->subtitle = "Ingreso de Vehículos";
        $this->view->render('reportediario/index');
    }

    function ListaSiniestrosFiltro()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->ListaSiniestrosFiltro($datos['aseguradora'], $datos['fecha_inicial'], $datos['fecha_final']);
        echo json_encode($siniestros);
    }
}
?>