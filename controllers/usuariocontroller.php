<?php
class UsuarioController extends Controller
{
    function __construct(){
        parent::__construct();
    }

    public function Login()
    {
        session_start();
        $offset=5*60*60; 
        $dia = gmdate('D', time());
        $hora = gmdate('H:i', time() - $offset);
        
        //$hora_inicio = strtotime("08:00");
        $hora_inicio = strtotime("01:00");
        $hora_inicio = date('H:i', $hora_inicio);

        $hora_final_lv = strtotime("17:30");
        $hora_final_lv = date('H:i', $hora_final_lv);
        $hora_final_s = strtotime("13:00");
        $hora_final_s = date('H:i', $hora_final_s);

        $valido = 0;
        $usuarios = [];

        if($dia == "Mon" || $dia == "Tue" || $dia == "Wed" || $dia == "Thu" || $dia == "Fri"){
            if($hora >= $hora_inicio && $hora <= $hora_final_lv){
                $valido = 1;
            }
        }

        if($dia == "Sat"){
            if($hora >= $hora_inicio && $hora <= $hora_final_s){
                $valido = 1;
            }
        }

        if($valido==1){
            $datos = $_REQUEST['datos'];
            $datos  = json_decode($datos, true);
            $usuarios = $this->model->Login($datos["usuario"], $datos["clave"]);
            if($usuarios['data'] != "error_datos" && count($usuarios['data'])>0 && $usuarios['data'][0]['nombres'] != null){
                $_SESSION['nombres'] = $usuarios['data'][0]['nombres'];
            }
        }else{
            $usuarios['data'] = "error_dias";
        }
        echo json_encode($usuarios);        
    }

    public function CerrarSesion()
    {
        session_start();
        session_destroy();
    }
} 
?>