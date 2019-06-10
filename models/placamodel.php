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
            SELECT p.nroplaca, p.marca, p.modelo, p.color, p.anio, p.dni, p.nombres, p.apellidos, (CASE WHEN COUNT(ps.nroplaca)=0 then 'NO REGISTRA SINIESTROS' WHEN COUNT(ps.nroplaca)>0 THEN (CONCAT(COUNT(ps.nroplaca),  ' SINIESTROS')) END)  as nrosiniestros, DATE_FORMAT(p.fecha_registro, '%d/%m/%Y') as fecha_registro, (CASE WHEN p.esprioritario=0 then 'NO' else 'SI' end) as esprioritario
            FROM placa p
            left join placa_siniestro ps
            on p.nroplaca = ps.nroplaca
            left join siniestro s
            on ps.idsiniestro = s.idsiniestro
            WHERE p.estado = 1 GROUP BY p.nroplaca
            order by p.ultimo_siniestro desc");

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

    public function getCatalogo(){
        $items = [];
        try{
            $query = $this->db->connect()->query("
            SELECT s.idsiniestro, p.nroplaca, p.marca, p.modelo, p.color, p.anio, p.dni, p.nombres, 
            p.apellidos, 
            DATE_FORMAT(s.fecha_siniestro, '%d/%m/%Y') as fecha_siniestro_lbl, 
            s.total_horas, s.total_panos, s.total_cotizacion
            FROM placa p
            left join placa_siniestro ps
            on p.nroplaca = ps.nroplaca
            left join siniestro s
            on ps.idsiniestro = s.idsiniestro
            WHERE p.estado = 1 
            order by s.fecha_siniestro desc");

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
            $query = $this->db->connect()->prepare('insert into placa (nroplaca, marca, modelo, dni, nombres, apellidos, color, anio, celular, correo, esprioritario, ultimo_siniestro)
            values (:nroplaca, :marca, :modelo, :dni, :nombres, :apellidos, :color, :anio, :celular, :correo, :esprioritario, :ultimo_siniestro)');
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
                'correo'    => $datos['correo'],
                'esprioritario' => $datos['esclienteprioritario'],
                'ultimo_siniestro' => date("Y-m-d")
            ]);

            $query2 = $this->db->connect()->prepare('insert into usuario (idtipo, nombres, apellidos, usuario, clave)
            values (:idtipo, :nombres, :apellidos, :usuario, :clave)');
            $query2->execute([
                'idtipo'        => 'CLI',
                'nombres'       => $datos['nombres'],
                'apellidos'     => $datos['apellidos'],
                'usuario'       => $datos['nroplaca'],
                'clave'         => md5($datos['dni'])
            ]);

            return "Placa Insertada";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    public function ActualizaPlaca($datos){
        $query = $this->db->connect()->prepare('update placa set marca = :marca, modelo = :modelo, dni = :dni, nombres = :nombres, apellidos = :apellidos, color = :color, anio = :anio, celular = :celular, correo = :correo, esprioritario = :esprioritario where nroplaca=:nroplaca');
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
            'correo'    => $datos['correo'],
            'esprioritario' => $datos['esclienteprioritario']
        ]);
    }

    public function EliminaPlaca($datos){
        $query = $this->db->connect()->prepare('delete from placa where nroplaca=:nroplaca');
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
                $item->esprioritario       = $row['esprioritario'];
            }
            
            return $item;
        }catch(PDOException $e){
            return null;
        }
    }
}
?>