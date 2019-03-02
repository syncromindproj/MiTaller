<?php
class UsuarioModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function Login($usuario, $clave)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            idusuario,
            usuario,
            nombres
            FROM usuario
            WHERE usuario = :usuario
            AND clave = :clave
            and estado = 1");
            $query->execute([
                'usuario'  => $usuario,
                'clave'  => MD5($clave)
            ]);
            
            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "error_datos";
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }
}
?>