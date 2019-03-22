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

        $path   = 'views/uploads/etaller/'.$placa;
        $marca  = constant('URL') . 'views/public/img/marca.png';
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

        //$img_tmpname=$_FILES['image']['tmp_name'];
        $num = substr( md5( rand( 10000,99999 ) ),0,9);    
        $new_name = $path.$num.".jpg";
        $image = $num.".jpg";
        
        //if(move_uploaded_file($tmp,$path)) 
        if(move_uploaded_file($tmp,$new_name)) 
        {
            $image          = imagecreatefromjpeg( $new_name );
            $logoImage      = imagecreatefrompng( $marca );

            $stamp_new = imagecreatetruecolor(450,150);
            imagealphablending($stamp_new, false);
            imagesavealpha($stamp_new, true);
            imagecopyresampled($stamp_new, $logoImage, 0, 0, 0, 0, 450, 150, imagesx($logoImage),imagesy($logoImage));
            
            //imagealphablending( $logoImage, true );

            $imageWidth     = imagesx($image);
            $imageHeight    = imagesy($image); 
            $logoWidth      = imagesx($stamp_new);
            $logoHeight     = imagesy($stamp_new);
            //$logoWidth      = imagesx($logoImage);
            //$logoHeight     = imagesy($logoImage);

            imagecopy(
              $image,
              //$logoImage,
              $stamp_new,
              $imageWidth-$logoWidth, $imageHeight-$logoHeight,
              0, 0,
              $logoWidth, $logoHeight);

            // Set type of image and send the output
            //header("Content-type: image/png");
            //imagepng( $image );/*display image with watermark */
            @imagepng( $image, $new_name );/* save image with watermark */

            // Release memory
            imagedestroy( $image );
            imagedestroy( $logoImage );
            

            //$etaller = $this->model->InsertaFoto($placa, $fecha, $path);
            $etaller = $this->model->InsertaFoto($placa, $fecha, $new_name);
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