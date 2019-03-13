<?PHP
class Etaller_clienteController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->etaller = [];
    }

    function render(){
        //$placas = $this->model->get();
        //$this->view->placas = $placas;
        $this->view->title = "E-taller";
        $this->view->subtitle = "E-taller";
        $this->view->render('etaller_cliente/index');
    }

    function detalle(){
        $fecha      = $_POST["txt1"];
        $placa      = $_POST["txt2"];
        $etaller    = $this->model->GetEtallerDetalle($placa, $fecha);
        $time       = $fecha;
        $date       = str_replace('/', '-', $time);
        $fecha_str  = date("d-m-Y", strtotime($date));
        
        $this->view->etaller = $etaller;
        $this->view->title = "E-taller";
        $this->view->subtitle = "E-taller - " . $fecha_str;
        $this->view->render('etaller_cliente/detalle');
        
    }

    public function GetEtaller()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $etaller = $this->model->GetEtaller($datos['placa']);
        echo(json_encode($etaller));
    }

    function GetEtallerDetalle($placa, $fecha)
    {
        $etaller = $this->model->GetEtallerDetalle($placa, $fecha);
        echo(json_encode($etaller));
    }
}

?>