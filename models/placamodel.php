<?PHP
include_once 'models/placa.php';

class PlacaModel extends Model
{
    public function __construct(){
        parent::__construct();
    }

    public function get(){
        $items = [];
        try{
            $query = $this->db->connect()->query("
            SELECT p.nroplaca, p.marca, p.modelo, p.dni, p.nombres, p.apellidos, (CASE WHEN COUNT(ps.nroplaca)=0 then 'NO REGISTRA SINIESTROS' WHEN COUNT(ps.nroplaca)>0 THEN (CONCAT(COUNT(ps.nroplaca),  ' SINIESTROS')) END)  as nrosiniestros
            FROM placa p
            left join placa_siniestro ps
            on p.nroplaca = ps.nroplaca
            WHERE p.estado = 1 GROUP BY p.nroplaca");

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

    public function InsertaPlaca($datos){
        try{
            $query = $this->db->connect()->prepare('insert into placa (nroplaca, marca, modelo, dni, nombres, apellidos)
            values (:nroplaca, :marca, :modelo, :dni, :nombres, :apellidos)');
            $query->execute([
                'nroplaca'  => $datos['nroplaca'],
                'marca'     => $datos['marca'],
                'modelo'    => $datos['modelo'],
                'dni'       => $datos['dni'],
                'nombres'   => $datos['nombres'],
                'apellidos' => $datos['apellidos']
            ]);
            return "Placa Insertada";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function ActualizaPlaca($datos){
        $query = $this->db->connect()->prepare('update placa set marca = :marca, modelo = :modelo, dni = :dni, nombres = :nombres, apellidos = :apellidos where nroplaca=:nroplaca');
        $query->execute([
            'nroplaca'  => $datos['nroplaca'],
            'marca'     => $datos['marca'],
            'modelo'    => $datos['modelo'],
            'dni'       => $datos['dni'],
            'nombres'   => $datos['nombres'],
            'apellidos' => $datos['apellidos']
        ]);
    }

    public function EliminaPlaca($datos){
        $query = $this->db->connect()->prepare('update placa set estado = 0 where nroplaca=:nroplaca');
        $query->execute([
            'nroplaca'  => $datos['nroplaca']
        ]);
    }

    public function getByPlaca($id){
        $item = new Placa();

        $query = $this->db->connect()->prepare("select * from placa where nroplaca = :nroplaca");
        try{
            $query->execute([
                'nroplaca' => $id
            ]);
            while($row =  $query->fetch()){
                $item->nroplaca     = $row['nroplaca'];
                $item->marca        = $row['marca'];
                $item->modelo       = $row['modelo'];
                $item->dni          = $row['dni'];
                $item->nombres      = $row['nombres'];
                $item->apellidos    = $row['apellidos'];
                $item->estado       = $row['estado'];
            }
            
            return $item;
        }catch(PDOException $e){
            return null;
        }
    }
}
?>