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
            SELECT p.nroplaca, p.marca, p.modelo, p.color, p.anio, p.dni, p.nombres, p.apellidos, (CASE WHEN COUNT(ps.nroplaca)=0 then 'NO REGISTRA SINIESTROS' WHEN COUNT(ps.nroplaca)>0 THEN (CONCAT(COUNT(ps.nroplaca),  ' SINIESTROS')) END)  as nrosiniestros, DATE_FORMAT(p.fecha_registro, '%d/%m/%Y') as fecha_registro
            FROM placa p
            left join placa_siniestro ps
            on p.nroplaca = ps.nroplaca
            left join siniestro s
            on ps.idsiniestro = s.idsiniestro
            WHERE p.estado = 1 GROUP BY p.nroplaca
            order by p.fecha_registro desc");

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
            $query = $this->db->connect()->prepare('insert into placa (nroplaca, marca, modelo, dni, nombres, apellidos, color, anio, celular, correo)
            values (:nroplaca, :marca, :modelo, :dni, :nombres, :apellidos, :color, :anio, :celular, :correo)');
            $query->execute([
                'nroplaca'  => $datos['nroplaca'],
                'marca'     => $datos['marca'],
                'modelo'    => $datos['modelo'],
                'dni'       => $datos['dni'],
                'nombres'   => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'color'     => $datos['color'],
                'anio'      => $datos['anio'],
                'celular'   => $datos['celular'],
                'correo'    => $datos['correo']
            ]);
            return "Placa Insertada";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function ActualizaPlaca($datos){
        $query = $this->db->connect()->prepare('update placa set marca = :marca, modelo = :modelo, dni = :dni, nombres = :nombres, apellidos = :apellidos, color = :color, anio = :anio, celular = :celular, correo = :correo where nroplaca=:nroplaca');
        $query->execute([
            'nroplaca'  => $datos['nroplaca'],
            'marca'     => $datos['marca'],
            'modelo'    => $datos['modelo'],
            'dni'       => $datos['dni'],
            'nombres'   => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'color'     => $datos['color'],
            'anio'      => $datos['anio'],
            'celular'   => $datos['celular'],
            'correo'    => $datos['correo']
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
                $item->color        = $row['color'];
                $item->anio         = $row['anio'];
                $item->dni          = $row['dni'];
                $item->nombres      = $row['nombres'];
                $item->apellidos    = $row['apellidos'];
                $item->estado       = $row['estado'];
                $item->celular      = $row['celular'];
                $item->correo       = $row['correo'];
            }
            
            return $item;
        }catch(PDOException $e){
            return null;
        }
    }
}
?>