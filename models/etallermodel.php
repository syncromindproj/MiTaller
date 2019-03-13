<?PHP
class EtallerModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function GetEtaller()
    {
        $items = [];
        try{
            $query = $this->db->connect()->query("
            SELECT idetaller, nroplaca, count(*) as total
            FROM etaller 
            WHERE estado=1
            GROUP by nroplaca");

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

    function InsertaFoto($placa, $fecha, $archivo)
    {
        try{
            $date             = str_replace('/', '-', $fecha);
            $fecha_etaller    = date("Y-m-d", strtotime($date));

            $query = $this->db->connect()->prepare('insert into etaller (fecha, nroplaca, archivo)
            values (:fecha, :nroplaca, :archivo)');
            $query->execute([
                'fecha'     => $fecha_etaller,
                'nroplaca'  => $placa,
                'archivo'   => $archivo
            ]);
            return "Foto Insertada";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function EliminaFotosPlaca($datos)
    {
        try{
            $query = $this->db->connect()->prepare('delete from etaller where nroplaca = :placa');
            $query->execute([
                'placa'   => $datos['placa']
            ]);

            $dirname = 'views/uploads/etaller/'.$datos['placa'];
            if (is_dir($dirname))
                $dir_handle = opendir($dirname);
            if (!$dir_handle)
                return false;
            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname."/".$file))
                        unlink($dirname."/".$file);
                    else
                        delete_directory($dirname.'/'.$file);
                }
            }
            closedir($dir_handle);
            rmdir($dirname);

            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    public function ListadoFotos($placa)
    {
        try{
            //$query = $this->db->connect()->prepare("select idetaller, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha, nroplaca, archivo from etaller where nroplaca = :placa order by fecha desc");
            $query = $this->db->connect()->prepare("select idetaller, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha_str, fecha, nroplaca, archivo from etaller where nroplaca = :placa order by fecha desc");
            $query->execute([
                'placa'   => $placa
            ]);
            
            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;

        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function ListadoPlacas()
    {
        try{
            $query = $this->db->connect()->prepare("SELECT nroplaca FROM placa where estado = 1 order by nroplaca asc");
            $query->execute();
            
            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;

        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function EliminaFoto($datos)
    {
        try{
            $query = $this->db->connect()->prepare('delete from etaller where idetaller = :id');
            $query->execute([
                'id'   => $datos['id']
            ]);

            $dirname = $datos['ruta'];
            unlink($dirname);
            
            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

}
?>