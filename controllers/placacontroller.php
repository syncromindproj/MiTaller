<?PHP
class PlacaController extends Controller
{
    function __construct(){
        parent::__construct();
        $this->placas = [];
    }

    function render(){
        $placas = $this->model->get();
        $this->view->placas = $placas;
        $this->view->title = "Placas";
        $this->view->subtitle = "Listado de Placas";
        $this->view->render('placa/index');
    }

    public function getPlacas()
    {
        $placas = $this->model->get();
        echo(json_encode($placas));
    }

    public function getCatalogo()
    {
        $placas = $this->model->getCatalogo();
        echo(json_encode($placas));
    }

    public function GuardarPlaca()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $placas = $this->model->InsertaPlaca($datos);
        echo $placas;
    }

    public function VerPlaca()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $nroplaca = $datos['nroplaca'];
        $placa = $this->model->getByPlaca($nroplaca);
        echo json_encode($placa);
    }

    public function ActualizaPlaca()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $placas = $this->model->ActualizaPlaca($datos);
        echo "Placa Actualizada";
    }

    public function EliminaPlaca()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $placas = $this->model->EliminaPlaca($datos);
        echo "Placa Eliminada";
    }
}
?>