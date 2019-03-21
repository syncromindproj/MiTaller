<?PHP
class SiniestroModel extends Model{
    function __construct(){
        parent::__construct();
    }

    function ListaSiniestros($nroplaca){
        $items = [];
        
        try{
            $query = $this->db->connect()->prepare("
            SELECT s.idsiniestro, s.nrosiniestro,  DATE_FORMAT(s.fecha_siniestro, '%d/%m/%Y') as fecha_siniestro, s.aseguradora, (case when s.estado = 0 then 'INACTIVO' WHEN s.estado = 1 THEN 'ACTIVO' END) as estado, descripcion
FROM siniestro s 
left join placa_siniestro ps
on s.idsiniestro = ps.idsiniestro
WHERE s.estado = 1
and ps.nroplaca = :nroplaca
order by DATE_FORMAT(s.fecha_siniestro, '%Y/%m/%d') desc");
            $query->execute([
                'nroplaca'  => $nroplaca
            ]);

            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    function GetObservacion($idsiniestro){
        $items = [];
        try{
            $query = $this->db->connect()->prepare("select *  from siniestro where idsiniestro = :idsiniestro");
            $query->execute([
                'idsiniestro'  => $idsiniestro
            ]);

            while($row =  $query->fetch()){
                $items[] = $row;
            }

            if(count($items) == 0){
                $items = "";
            }

            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    function InfoPanel($tipo)
    {
        $numero = 0;

        try{
            switch($tipo){
                case "prioritarios":
                    $query = $this->db->connect()->prepare("SELECT count(*) as numero FROM siniestro WHERE estado = 1 and esprioritario=1");
                    $query->execute();
                    while($row =  $query->fetch()){
                        $numero = $row['numero'];
                    }
                    break;

                case "siniestros":
                    $query = $this->db->connect()->prepare("SELECT count(*) as numero FROM siniestro WHERE estado = 1");
                    $query->execute();
                    while($row =  $query->fetch()){
                        $numero = $row['numero'];
                    }
                    break;

                case "vehiculos":
                    $query = $this->db->connect()->prepare("SELECT count(*) as numero FROM placa WHERE estado = 1");
                    $query->execute();
                    while($row =  $query->fetch()){
                        $numero = $row['numero'];
                    }
                    break;
            }
            

            return $numero;
        }catch(PDOException $e){
            return $numero;
        }
    }



    function RegistraSiniestro($datos){
        try{
            $time               = $datos['fecha_siniestro'];
            $date               = str_replace('/', '-', $time);
            $fecha_siniestro    = date("Y-m-d", strtotime($date));
            $nrosiniestro       = $datos['nrosiniestro'];
            $observaciones      = $datos['observaciones'];
            $esprioritario      = $datos['esprioritario'];
            $idsiniestro        = "";
        
            $query = $this->db->connect()->prepare('call inserta_siniestro (:fecha_siniestro, :nrosiniestro, :aseguradora, :nroplaca, :observaciones, :esprioritario)');
            $query->execute([
                'fecha_siniestro'   => $fecha_siniestro,
                'nrosiniestro'      => $nrosiniestro,
                'aseguradora'       => $datos['aseguradora'],
                'nroplaca'          => $datos['nroplaca'],
                'observaciones'     => $observaciones,
                'esprioritario'     => $esprioritario
            ]);

            while($row =  $query->fetch()){
                $idsiniestro     = $row['lid'];
            }

            if($idsiniestro != ""){
                $folder = "views/uploads/".$idsiniestro;
                
                if(!mkdir($folder, 0777, true)) {
                    die('Fallo al crear las carpetas...');
                }else{
                    mkdir($folder."/DOCUMENTOS_GENERALES", 0777, true);
                    mkdir($folder."/FOTOS", 0777, true);
                    mkdir($folder."/REPUESTOS", 0777, true);
                    mkdir($folder."/MANO_OBRA", 0777, true);
                    mkdir($folder."/CARTAS_DE_APROBACION", 0777, true);
                    mkdir($folder."/INVENTARIOS", 0777, true);
                    mkdir($folder."/FRANQUICIAS", 0777, true);
                    mkdir($folder."/ETALLER", 0777, true);
                    
                    mkdir($folder."/FOTOS/SINIESTRO", 0777, true);
                    mkdir($folder."/FOTOS/REPUESTOS", 0777, true);
                    mkdir($folder."/FOTOS/INSPECCION", 0777, true);
                    mkdir($folder."/FOTOS/FOTOS_TERMINADO", 0777, true);

                    mkdir($folder."/REPUESTOS/NOTAS_CREDITO", 0777, true);
                    mkdir($folder."/REPUESTOS/GUIAS_REMISION", 0777, true);
                    
                    mkdir($folder."/REPUESTOS/PROVEEDORES", 0777, true);
                    
                    mkdir($folder."/OTROS_DOCUMENTOS", 0777, true);
                }
            }
            //echo $idsiniestro;die;
            return $idsiniestro;
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaSiniestro($idsiniestro)
    {
        try{
            $query = $this->db->connect()->prepare('delete from siniestro where idsiniestro = :idsiniestro');
            $query->execute([
                'idsiniestro'   => $idsiniestro
            ]);

            $query = $this->db->connect()->prepare('delete from placa_siniestro where idsiniestro = :idsiniestro');
            $query->execute([
                'idsiniestro'   => $idsiniestro
            ]);

            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    function ActualizaObservacion($datos)
    {
        try{
            $idsiniestro        = $datos['idsiniestro'];
            $descripcion        = $datos['descripcion'];
            
            $query = $this->db->connect()->prepare('update siniestro set descripcion = :descripcion where idsiniestro = :idsiniestro');
            $query->execute([
                'descripcion'       => $descripcion,
                'idsiniestro'       => $idsiniestro
            ]);

            return "Actualizado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }
}
?>