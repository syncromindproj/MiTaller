<?PHP
class SiniestroModel extends Model{
    function __construct(){
        parent::__construct();
    }

    function ListaSiniestros($nroplaca){
        $items = [];
        
        try{
            $query = $this->db->connect()->prepare("
            SELECT s.idsiniestro, s.nrosiniestro,  DATE_FORMAT(s.fecha_siniestro, '%d/%m/%Y') as fecha_siniestro, s.aseguradora, (case when s.estado = 0 then 'INACTIVO' WHEN s.estado = 1 THEN 'ACTIVO' END) as estado
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

    function RegistraSiniestro($datos){
        try{
            $time               = $datos['fecha_siniestro'];
            $date               = str_replace('/', '-', $time);
            $fecha_siniestro    = date("Y-m-d", strtotime($date));
            $nrosiniestro       = $datos['nrosiniestro'];
            $idsiniestro        = "";
        
            $query = $this->db->connect()->prepare('call inserta_siniestro (:fecha_siniestro, :nrosiniestro, :aseguradora, :nroplaca)');
            $query->execute([
                'fecha_siniestro'   => $fecha_siniestro,
                'nrosiniestro'      => $nrosiniestro,
                'aseguradora'       => $datos['aseguradora'],
                'nroplaca'          => $datos['nroplaca']
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
                    mkdir($folder."/PRESUPUESTOS", 0777, true);
                    mkdir($folder."/CARTAS_DE_APROBACION", 0777, true);
                    mkdir($folder."/INVENTARIOS", 0777, true);
                    mkdir($folder."/FRANQUICIAS", 0777, true);
                    mkdir($folder."/ETALLER", 0777, true);
                    
                    mkdir($folder."/FOTOS/SINIESTRO", 0777, true);
                    mkdir($folder."/FOTOS/REPUESTOS", 0777, true);
                    mkdir($folder."/FOTOS/INSPECCION", 0777, true);

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
}
?>