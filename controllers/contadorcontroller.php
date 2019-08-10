<?PHP
class ContadorController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Contador";
        $this->view->subtitle = "Contador";
        $this->view->render('contador/index');
    }
}
?>