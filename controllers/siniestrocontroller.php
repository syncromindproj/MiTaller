<?PHP
class SiniestroController extends Controller
{
    function __construct(){
        parent::__construct();
        //$this->$siniestros = [];
    }

    public function ListaSiniestros()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->ListaSiniestros($datos["nroplaca"]);
        echo json_encode($siniestros);
    }

    public function RegistraSiniestro()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->RegistraSiniestro($datos);
        echo $siniestros;
    }

    public function ZipSiniestro()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idsiniestro = $datos['idsiniestro'];
        
        //$rootPath = realpath(".")."\\views\\uploads\\".$idsiniestro;
        $rootPath = realpath(".")."/views/uploads/".$idsiniestro;
        $zip = new ZipArchive();
        $zip->open('views/uploads/'.$idsiniestro.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        $archivo = 'views/uploads/'.$idsiniestro.'.zip';
        $estado = "0";
        if (file_exists($archivo)) {
            $estado = "1";
        }

        $info = '{"file": "'.$archivo.'", "estado": "'.$estado.'"}';
        echo json_encode($info);
    }

    public function EliminaSiniestro()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->EliminaSiniestro($datos["idsiniestro"]);
        echo json_encode($fotos);
        
    }
    
}
?>