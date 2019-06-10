<?PHP
class ReportediarioModel extends Model
{
    function __construct(){
        parent::__construct();
    }

    function ListaSiniestrosFiltro($aseguradora, $fecha_inicial, $fecha_final)
    {
        $items = [];
        try{
            $sql = "SELECT 
            DATE_FORMAT(s.fecha_siniestro, '%d/%m/%Y') as fecha_siniestro,
            p.nroplaca,
            p.marca,
            p.modelo,
            p.color,
            p.anio,
            p.nombres,
            p.apellidos,
            s.aseguradora
            FROM siniestro s
            left join placa_siniestro ps
            on s.idsiniestro = ps.idsiniestro
            left join placa p
            on p.nroplaca = ps.nroplaca
            where s.aseguradora like '%".$aseguradora."%'
            and s.fecha_siniestro between '".$fecha_inicial."' and '".$fecha_final."'
            order by s.fecha_siniestro desc";
            
            $query = $this->db->connect()->prepare($sql);
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
}
?>