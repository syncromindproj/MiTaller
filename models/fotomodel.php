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
            f.descripcion,
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

    function InsertaFoto($idtipofoto, $idsiniestro, $archivo, $descripcion)
    {
        try{
            $query = $this->db->connect()->prepare('insert into foto (idtipofoto, idsiniestro, ruta, descripcion)
            values (:idtipofoto, :idsiniestro, :ruta, :descripcion)');
            $query->execute([
                'idtipofoto'    => $idtipofoto,
                'idsiniestro'   => $idsiniestro,
                'ruta'          => $archivo,
                'descripcion'   => $descripcion
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

    public function GetFotosPorMarca()
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT distinct(p.marca) as marca, count(f.ruta) as cantidad
            FROM placa p
            inner join placa_siniestro ps
            on p.nroplaca = ps.nroplaca
            inner join siniestro s
            on s.idsiniestro = ps.idsiniestro
            inner join foto f
            on f.idsiniestro = s.idsiniestro
            inner join tipo_foto tf
            on tf.idtipofoto = f.idtipofoto
            where (tf.idtipofoto = 8 or tf.idtipofoto = 16)
            group by p.marca
            order by p.marca asc");
            $query->execute();

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

    public function GetRutasPorMarca($marca, $tipo)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT f.ruta
            FROM placa p
            inner join placa_siniestro ps
            on p.nroplaca = ps.nroplaca
            inner join siniestro s
            on s.idsiniestro = ps.idsiniestro
            inner join foto f
            on f.idsiniestro = s.idsiniestro
            inner join tipo_foto tf
            on tf.idtipofoto = f.idtipofoto
            where tf.idtipofoto = :tipo 
            and marca = :marca");
            $query->execute([
                "marca" => $marca,
                "tipo"  => $tipo
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
}
?>