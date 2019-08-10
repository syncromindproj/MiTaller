<?PHP
class Documentos_ContabilidadController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Documentos de Contabilidad";
        $this->view->subtitle = "Documentos de Contabilidad";
        $this->view->render("documentos_contabilidad/index");
    }
}
?>