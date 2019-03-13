<?PHP
class Etaller_clienteModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function GetEtaller($placa)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT idetaller, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha_str, fecha, count(*) as total FROM etaller WHERE nroplaca = :placa GROUP by fecha desc");

            $query->execute([
                'placa'     => $placa
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

    function GetEtallerDetalle($placa, $fecha)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT * from etaller WHERE nroplaca = :placa and fecha = :fecha");

            $query->execute([
                'placa'     => $placa,
                'fecha'     => $fecha
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