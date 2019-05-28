<?PHP
class Reporte_anualController extends Controller
{
    function __construct(){
        parent::__construct();
    }

    function render(){
        $this->view->title = "Reporte Anual";
        $this->view->subtitle = "Reporte Anual";
        $this->view->render('reporte_anual/index');
    }

    function GetDatosAnuales()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $info = $this->model->GetDatosAnuales($datos);
        echo json_encode($info);
    }
}
?>