<?PHP
class EtallerController extends Controller
{
    function __construct(){
        parent::__construct();
    }

    function render(){
        //$placas = $this->model->get();
        //$this->view->placas = $placas;
        $this->view->title = "E-taller";
        $this->view->subtitle = "E-taller";
        $this->view->render('etaller/index');
    }

    public function GetEtaller()
    {
        $etaller = $this->model->GetEtaller();
        echo(json_encode($etaller));
    }

    public function ListadoFotos()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $etaller = $this->model->ListadoFotos($datos['placa']);
        echo(json_encode($etaller));
    }

    public function Subir()
    {
        $img            = $_FILES["files"]["name"][0];
        $tmp            = $_FILES["files"]["tmp_name"][0];
        $errorimg       = $_FILES["files"]["error"][0];
        $placa          = strtoupper($_REQUEST['placa']);
        $fecha          = $_REQUEST['fecha'];

        $path = 'views/uploads/etaller/'.$placa;
        $estado = "0";

        if (file_exists($path)) {
            $estado = "1";
        }

        $rand = rand(10000, 99999);
        if($estado == "0"){
            mkdir($path, 0777, true);
            $path .= "/" . $rand . "_" . strtolower($img);
        }else{
            $path .= "/" . $rand . "_" . strtolower($img);
        }

        if(move_uploaded_file($tmp,$path)) 
        {
            $etaller = $this->model->InsertaFoto($placa, $fecha, $path);
            echo(json_encode($etaller));
        }
        
    }

    public function EliminaFotosPlaca()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $resultado = $this->model->EliminaFotosPlaca($datos);
        echo $resultado;
    }

    public function EliminaFoto()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $resultado = $this->model->EliminaFoto($datos);
        echo $resultado;
    }

    public function ListadoPlacas()
    {
        $resultado = $this->model->ListadoPlacas();
        echo(json_encode($resultado));
    }
}
?>