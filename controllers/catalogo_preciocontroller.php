<?PHP
class Catalogo_PrecioController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Catálogo de Precios";
        $this->view->subtitle = "Catálogo de Precios";
        $this->view->render('catalogo_precio/index');
    }
}
?>