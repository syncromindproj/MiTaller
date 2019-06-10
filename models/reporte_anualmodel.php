<?PHP
class Reporte_anualModel extends Model
{
    function __construct(){
        parent::__construct();
    }

    function GetDatosAnuales($datos)
    {
        try{
            $anio           = $datos['anio'];
            $aseguradora    = $datos['aseguradora'];

            $sql = "SELECT 
            count(s.aseguradora) as cantidad
            FROM (
            SELECT '1' AS MONTH, 1 as ord
            union
            SELECT '2' AS MONTH, 2 as ord
            union
            SELECT '3' AS MONTH, 3 as ord
            union
            SELECT '4' AS MONTH, 4 as ord
            union
            SELECT '5' AS MONTH, 5 as ord
            union
            SELECT '6' AS MONTH, 6 as ord
            union
            SELECT '7' AS MONTH, 7 as ord
            union
            SELECT '8' AS MONTH, 8 as ord
            union
            SELECT '9' AS MONTH, 9 as ord
            union
            SELECT '10' AS MONTH, 10 as ord
            union
            SELECT '11' AS MONTH, 11 as ord
            union
            SELECT '12' AS MONTH, 12 as ord
            ) AS m 
            LEFT outer JOIN siniestro s ON m.month = month(s.fecha_siniestro) and s.estado=1 and year(s.fecha_siniestro)=:anio and s.aseguradora=:aseguradora 
            group by s.aseguradora, m.month
            order by m.ord asc
            ";
            $query = $this->db->connect()->prepare($sql);
            $query->execute([
                'anio'          => $anio,
                'aseguradora'   => $aseguradora
            ]);
            
            while($row =  $query->fetch()){
                $r['cantidad'] = $row['cantidad'];
                $items[] = $r;
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
}
?>