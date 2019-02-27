<?PHP
class FotoModel extends Model
{
    function __construct(){
        parent::__construct();
    }

    function ListaFotos($idsiniestro, $tipo){
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            f.idfoto,
            f.ruta,
            f.estado
            FROM foto f
            WHERE f.idsiniestro=:idsiniestro
            AND f.idtipofoto = :tipo");
            $query->execute([
                'idsiniestro'  => $idsiniestro,
                'tipo'  => $tipo
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

    function InsertaFoto($idtipofoto, $idsiniestro, $archivo)
    {
        try{
            $query = $this->db->connect()->prepare('insert into foto (idtipofoto, idsiniestro, ruta)
            values (:idtipofoto, :idsiniestro, :ruta)');
            $query->execute([
                'idtipofoto'    => $idtipofoto,
                'idsiniestro'   => $idsiniestro,
                'ruta'          => $archivo
            ]);
            return "Foto Insertada";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaFoto($idfoto)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('select ruta from foto where idfoto = :idfoto');
            $query->execute([
                'idfoto'   => $idfoto
            ]);

            while($row =  $query->fetch()){
                $archivo = $row['ruta'];
            }

            $query = $this->db->connect()->prepare('delete from foto where idfoto = :idfoto');
            $query->execute([
                'idfoto'   => $idfoto
            ]);

            if (file_exists($archivo)) {
                unlink($archivo);
            }

            return $archivo;    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }
}
?>