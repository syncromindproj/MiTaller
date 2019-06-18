<?PHP
require('fpdf/fpdf.php');
class SiniestroModel extends Model{
    function __construct(){
        parent::__construct();
    }

    function ListaSiniestros($nroplaca){
        $items = [];
        
        try{
            $query = $this->db->connect()->prepare("
            SELECT s.idsiniestro, s.nrosiniestro, DATE_FORMAT(s.fecha_siniestro, '%d/%m/%Y') as fecha_siniestro, s.aseguradora, (case when s.estado = 0 then 'INACTIVO' WHEN s.estado = 1 THEN 'ACTIVO' END) as estado, descripcion, COALESCE(i.idinventario, '') as idinventario, ps.nroplaca
FROM siniestro s 
left join placa_siniestro ps on s.idsiniestro = ps.idsiniestro 
left join inventario i on i.idsiniestro = ps.idsiniestro
WHERE s.estado = 1 and ps.nroplaca = :nroplaca
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

    function GetTotales($datos){
        $items = [];
        
        try{
            $query = $this->db->connect()->prepare("
            SELECT total_horas, total_panos, total_cotizacion
            FROM siniestro
            WHERE idsiniestro = :idsiniestro");
            $query->execute([
                'idsiniestro'  => $datos['idsiniestro']
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

    function ListaEstadosInventario()
    {
        $items = [];
        
        try{
            $query = $this->db->connect()->prepare("select * from estado_inventario order by descripcion asc");
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

    function GetObservacion($idsiniestro){
        $items = [];
        try{
            $query = $this->db->connect()->prepare("select *  from siniestro where idsiniestro = :idsiniestro");
            $query->execute([
                'idsiniestro'  => $idsiniestro
            ]);

            while($row =  $query->fetch()){
                $items[] = $row;
            }

            if(count($items) == 0){
                $items = "";
            }

            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    function InfoPanel($tipo)
    {
        $numero = 0;

        try{
            switch($tipo){
                case "clientes_prioritarios":
                    $query = $this->db->connect()->prepare("SELECT count(*) as numero FROM placa WHERE estado = 1 and esprioritario=1");
                    $query->execute();
                    while($row =  $query->fetch()){
                        $numero = $row['numero'];
                    }
                    break;

                case "prioritarios":
                    $query = $this->db->connect()->prepare("SELECT count(*) as numero FROM siniestro WHERE estado = 1 and esprioritario=1");
                    $query->execute();
                    while($row =  $query->fetch()){
                        $numero = $row['numero'];
                    }
                    break;

                case "siniestros":
                    $query = $this->db->connect()->prepare("SELECT count(*) as numero FROM siniestro WHERE estado = 1");
                    $query->execute();
                    while($row =  $query->fetch()){
                        $numero = $row['numero'];
                    }
                    break;

                case "vehiculos":
                    $query = $this->db->connect()->prepare("SELECT count(*) as numero FROM placa WHERE estado = 1");
                    $query->execute();
                    while($row =  $query->fetch()){
                        $numero = $row['numero'];
                    }
                    break;
            }
            

            return $numero;
        }catch(PDOException $e){
            return $numero;
        }
    }



    function RegistraSiniestro($datos){
        try{
            $time               = $datos['fecha_siniestro'];
            $date               = str_replace('/', '-', $time);
            $fecha_siniestro    = date("Y-m-d", strtotime($date));
            $nrosiniestro       = $datos['nrosiniestro'];
            $observaciones      = $datos['observaciones'];
            $esprioritario      = $datos['esprioritario'];
            $idsiniestro        = "";
        
            $query = $this->db->connect()->prepare('call inserta_siniestro (:fecha_siniestro, :nrosiniestro, :aseguradora, :nroplaca, :observaciones, :esprioritario)');
            $query->execute([
                'fecha_siniestro'   => $fecha_siniestro,
                'nrosiniestro'      => $nrosiniestro,
                'aseguradora'       => $datos['aseguradora'],
                'nroplaca'          => $datos['nroplaca'],
                'observaciones'     => $observaciones,
                'esprioritario'     => $esprioritario
            ]);

            $query2 = $this->db->connect()->prepare('update placa set ultimo_siniestro = :fecha_siniestro where nroplaca = :nroplaca;');
            $query2->execute([
                'fecha_siniestro'   => $fecha_siniestro,
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
                    mkdir($folder."/FOTOS/FOTOS_TERMINADO", 0777, true);
                    mkdir($folder."/FOTOS/FOTOS_TABLERO", 0777, true);
                    mkdir($folder."/FOTOS/FOTOS_INTERIOR", 0777, true);

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

    function EliminaSiniestro($idsiniestro, $nroplaca)
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

            //Actualiza Fecha Ultimo Siniestro
            $sql = "select p.*, DATE_FORMAT(p.fecha_registro, '%Y-%m-%d') as nueva_fecha from placa p where estado=1 and p.nroplaca='".$nroplaca."'";
            //echo("id: ".$nroplaca);die;

            foreach ($this->db->connect()->query($sql) as $row) {
                $placa = $row['nroplaca'];
                //echo("id: ".$placa);die;
                $sql = "select s.fecha_siniestro from siniestro s inner join placa_siniestro ps on ps.idsiniestro = s.idsiniestro where ps.nroplaca='".$nroplaca."' order by s.fecha_siniestro desc limit 1";
                $query = $this->db->connect()->query($sql);
                $results = $query->fetchall();
            
                if(count($results) > 0){
                    foreach ($this->db->connect()->query($sql) as $row2) {
                        $fecha_siniestro = $row2['fecha_siniestro'];
                        $sql = "update placa set ultimo_siniestro='".$fecha_siniestro."' where nroplaca='".$placa."'";
                        $this->db->connect()->query($sql);
                    }
                }else{
                    $fecha_siniestro = $row['nueva_fecha'];
                    $sql = "update placa set ultimo_siniestro='".$fecha_siniestro."' where nroplaca='".$placa."'";
                    $this->db->connect()->query($sql);
                }
            }


            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    function ActualizaObservacion($datos)
    {
        try{
            $idsiniestro        = $datos['idsiniestro'];
            $descripcion        = $datos['descripcion'];
            
            $query = $this->db->connect()->prepare('update siniestro set descripcion = :descripcion where idsiniestro = :idsiniestro');
            $query->execute([
                'descripcion'       => $descripcion,
                'idsiniestro'       => $idsiniestro
            ]);

            return "Actualizado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    function ActualizaTotales($datos)
    {
        try{
            $idsiniestro            = $datos['idsiniestro'];
            $total_horas            = $datos['total_horas'];
            $total_panos            = $datos['total_panos'];
            $total_cotizacion       = $datos['total_cotizacion'];
            
            $query = $this->db->connect()->prepare('update siniestro set total_horas = :total_horas, 
            total_panos = :total_panos, total_cotizacion = :total_cotizacion where idsiniestro = :idsiniestro');
            $query->execute([
                'total_horas'       => $total_horas,
                'total_panos'       => $total_panos,
                'total_cotizacion'  => $total_cotizacion,
                'idsiniestro'       => $idsiniestro
            ]);

            return "Actualizado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    function InsertaInventario($datos)
    {
        try{
            $path                       = 'views/uploads/firmas/';

            $firma                      = $datos['firma'];
            $parts                      = explode(',', $firma);  
            $data                       = $parts[1];  
            $data                       = str_replace(' ', '+', $data);
            $data                       = base64_decode($data);  
            
            $fp                         = fopen($path.$datos['idsiniestro'].'_firma.png', 'w');  
            fwrite($fp, $data);  
            fclose($fp); 
            
            $idsiniestro                = $datos['idsiniestro'];
            $fecha                      = $datos['fecha'];
            $hora                       = $datos['hora'];
            $recepcionista              = strtoupper($datos['recepcionista']);

            $placa                      = strtoupper($datos['placa']);
            $marca                      = strtoupper($datos['marca']);
            $modelo                     = strtoupper($datos['modelo']);
            $piloto                     = strtoupper($datos['piloto']);
            $telefono                   = $datos['telefono'];
            $celular                    = $datos['celular'];
            $correo                     = strtoupper($datos['correo']);

            $servicio                   = strtoupper($datos['servicio']);
            $observacion                = strtoupper($datos['observacion']);
            $kilometraje                = $datos['kilometraje'];
            $queda_taller               =$datos['queda_taller'];
            $tarjeta_propiedad_estado   =$datos['tarjeta_propiedad_estado'];
            $tarjeta_propiedad_obs      =$datos['tarjeta_propiedad_obs'];
            $antenas_estado             =$datos['antenas_estado'];
            $antenas_obs                =$datos['antenas_obs'];
            $soat_estado                =$datos['soat_estado'];
            $soat_obs                   =$datos['soat_obs'];
            $vasos_rueda_estado         =$datos['vasos_rueda_estado'];
            $vasos_rueda_obs            =$datos['vasos_rueda_obs'];
            $llave_encendido_estado     =$datos['llave_encendido_estado'];
            $llave_encendido_obs        =$datos['llave_encendido_obs'];
            $brazos_plumillas_estado    =$datos['brazos_plumillas_estado'];
            $brazos_plumillas_obs       =$datos['brazos_plumillas_obs'];
            $encendedor_estado          =$datos['encendedor_estado'];
            $encendedor_obs             =$datos['encendedor_obs'];
            $direccionales_estado       =$datos['direccionales_estado'];
            $direccionales_obs          =$datos['direccionales_obs'];
            $aire_acondicionado_estado  =$datos['aire_acondicionado_estado'];
            $aire_acondicionado_obs     =$datos['aire_acondicionado_obs'];
            $llantas_estado             =$datos['llantas_estado'];
            $llantas_obs                =$datos['llantas_obs'];
            $cenicero_estado            =$datos['cenicero_estado'];
            $cenicero_obs               =$datos['cenicero_obs'];
            $aros_estado                =$datos['aros_estado'];
            $aros_obs                   =$datos['aros_obs'];
            $claxon_estado              =$datos['claxon_estado'];
            $claxon_obs                 =$datos['claxon_obs'];
            $faros_delanteros_estado    =$datos['faros_delanteros_estado'];
            $faros_delanteros_obs       =$datos['faros_delanteros_obs'];
            $luz_salon_estado           =$datos['luz_salon_estado'];
            $luz_salon_obs              =$datos['luz_salon_obs'];
            $faros_posteriores_estado   =$datos['faros_posteriores_estado'];
            $faros_posteriores_obs      =$datos['faros_posteriores_obs'];
            $parlantes_estado           =$datos['parlantes_estado'];
            $parlantes_obs              =$datos['parlantes_obs'];
            $emblemas_estado            =$datos['emblemas_estado'];
            $emblemas_obs               =$datos['emblemas_obs'];
            $correas_seguridad_estado   =$datos['correas_seguridad_estado'];
            $correas_seguridad_obs      =$datos['correas_seguridad_obs'];
            $escarpines_estado          =$datos['escarpines_estado'];
            $escarpines_obs             =$datos['escarpines_obs'];
            $control_alarma_estado      =$datos['control_alarma_estado'];
            $control_alarma_obs         =$datos['control_alarma_obs'];
            $tapa_gasolina_estado       =$datos['tapa_gasolina_estado'];
            $tapa_gasolina_obs          =$datos['tapa_gasolina_obs'];
            $asientos_estado            =$datos['asientos_estado'];
            $asientos_obs               =$datos['asientos_obs'];
            $llanta_repuesto_estado     =$datos['llanta_repuesto_estado'];
            $llanta_repuesto_obs        =$datos['llanta_repuesto_obs'];
            $pisos_estado               =$datos['pisos_estado'];
            $pisos_obs                  =$datos['pisos_obs'];
            $gata_palanca_estado        =$datos['gata_palanca_estado'];
            $gata_palanca_obs           =$datos['gata_palanca_obs'];
            $espejo_interior_estado     =$datos['espejo_interior_estado'];
            $espejo_interior_obs        =$datos['espejo_interior_obs'];
            $manijas_perillas_estado    =$datos['manijas_perillas_estado'];
            $manijas_perillas_obs       =$datos['manijas_perillas_obs'];
            $espejo_exterior_estado     =$datos['espejo_exterior_estado'];
            $espejo_exterior_obs        =$datos['espejo_exterior_obs'];
            $llave_ruedas_estado        =$datos['llave_ruedas_estado'];
            $llave_ruedas_obs           =$datos['llave_ruedas_obs'];
            $libro_servicio_estado      =$datos['libro_servicio_estado'];
            $libro_servicio_obs         =$datos['libro_servicio_obs'];
            $tapa_aceite_estado         =$datos['tapa_aceite_estado'];
            $tapa_aceite_obs            =$datos['tapa_aceite_obs'];
            $juego_herramientas_estado  =$datos['juego_herramientas_estado'];
            $juego_herramientas_obs     =$datos['juego_herramientas_obs'];
            $tapa_liquido_freno_estado  =$datos['tapa_liquido_freno_estado'];
            $tapa_liquido_freno_obs     =$datos['tapa_liquido_freno_obs'];
            $juego_seguros_aros_estado  =$datos['juego_seguros_aros_estado'];
            $juego_seguros_aros_obs     =$datos['juego_seguros_aros_obs'];
            $tapa_liquido_embrague_estado=$datos['tapa_liquido_embrague_estado'];
            $tapa_liquido_embrague_obs  =$datos['tapa_liquido_embrague_obs'];
            $juego_seguro_vasos_estado  =$datos['juego_seguro_vasos_estado'];
            $juego_seguro_vasos_obs     =$datos['juego_seguro_vasos_obs'];
            $tapa_radiador_estado       =$datos['tapa_radiador_estado'];
            $tapa_radiador_obs          =$datos['tapa_radiador_obs'];
            $varilla_aceite_estado      =$datos['varilla_aceite_estado'];
            $varilla_aceite_obs         =$datos['varilla_aceite_obs'];
            $radio_cd_estado            =$datos['radio_cd_estado'];
            $radio_cd_obs               =$datos['radio_cd_obs'];
            $tapices_alfombras_estado   =$datos['tapices_alfombras_estado'];
            $tapices_alfombras_obs      =$datos['tapices_alfombras_obs'];
            $injec_agua_parabrisas_estado   =$datos['injec_agua_parabrisas_estado'];
            $injec_agua_parabrisas_obs  =$datos['injec_agua_parabrisas_obs'];
            $parabrisas_estado          =$datos['parabrisas_estado'];
            $parabrisas_obs             =$datos['parabrisas_obs'];
            $trabagas_estado            =$datos['trabagas_estado'];
            $trabagas_obs               =$datos['trabagas_obs'];
            $lunas_puertas_estado       =$datos['lunas_puertas_estado'];
            $lunas_puertas_obs          =$datos['lunas_puertas_obs'];
            $mascara_estado             =$datos['mascara_estado'];
            $mascara_obs                =$datos['mascara_obs'];
            $copas_vasos_estado         =$datos['copas_vasos_estado'];
            $copas_vasos_obs            =$datos['copas_vasos_obs'];
            $seguro_ruedas_estado       =$datos['seguro_ruedas_estado'];
            $seguro_ruedas_obs          =$datos['seguro_ruedas_obs'];
            $chapa_puertas_estado       =$datos['chapa_puertas_estado'];
            $chapa_puertas_obs          =$datos['chapa_puertas_obs'];
            $rev_ocular_motor_estado    =$datos['rev_ocular_motor_estado'];
            $rev_ocular_motor_obs       =$datos['rev_ocular_motor_obs'];
            $alarma_estado              =$datos['alarma_estado'];
            $alarma_obs                 =$datos['alarma_obs'];
            $caja_CD_estado             =$datos['caja_CD_estado'];
            $caja_CD_obs                =$datos['caja_CD_obs'];
            $otros_estado               =$datos['otros_estado'];
            $otros_obs                  =$datos['otros_obs'];
            
            $sql = "INSERT INTO inventario(
                `idsiniestro`,
                `fecha`,
                `hora`,
                `recepcionista`,
                `servicio`,
                `observacion`,
                `kilometraje`,
                `queda_taller`,
                `tarjeta_propiedad_estado`,
                `tarjeta_propiedad_obs`,
                `antenas_estado`,
                `antenas_obs`,
                `soat_estado`,
                `soat_obs`,
                `vasos_rueda_estado`,
                `vasos_rueda_obs`,
                `llave_encendido_estado`,
                `llave_encendido_obs`,
                `brazos_plumillas_estado`,
                `brazos_plumillas_obs`,
                `encendedor_estado`,
                `encendedor_obs`,
                `direccionales_estado`,
                `direccionales_obs`,
                `aire_acondicionado_estado`,
                `aire_acondicionado_obs`,
                `llantas_estado`,
                `llantas_obs`,
                `cenicero_estado`,
                `cenicero_obs`,
                `aros_estado`,
                `aros_obs`,
                `claxon_estado`,
                `claxon_obs`,
                `faros_delanteros_estado`,
                `faros_delanteros_obs`,
                `luz_salon_estado`,
                `luz_salon_obs`,
                `faros_posteriores_estado`,
                `faros_posteriores_obs`,
                `Parlantes_estado`,
                `Parlantes_obs`,
                `emblemas_estado`,
                `emblemas_obs`,
                `correas_seguridad_estado`,
                `correas_seguridad_obs`,
                `escarpines_estado`,
                `escarpines_obs`,
                `control_alarma_estado`,
                `control_alarma_obs`,
                `tapa_gasolina_estado`,
                `tapa_gasolina_obs`,
                `asientos_estado`,
                `asientos_obs`,
                `llanta_repuesto_estado`,
                `llanta_repuesto_obs`,
                `pisos_estado`,
                `pisos_obs`,
                `gata_palanca_estado`,
                `gata_palanca_obs`,
                `espejo_interior_estado`,
                `espejo_interior_obs`,
                `manijas_perillas_estado`,
                `manijas_perillas_obs`,
                `espejo_exterior_estado`,
                `espejo_exterior_obs`,
                `llave_ruedas_estado`,
                `llave_ruedas_obs`,
                `libro_servicio_estado`,
                `libro_servicio_obs`,
                `tapa_aceite_estado`,
                `tapa_aceite_obs`,
                `juego_herramientas_estado`,
                `juego_herramientas_obs`,
                `tapa_liquido_freno_estado`,
                `tapa_liquido_freno_obs`,
                `juego_seguros_aros_estado`,
                `juego_seguros_aros_obs`,
                `tapa_liquido_embrague_estado`,
                `tapa_liquido_embrague_obs`,
                `juego_seguro_vasos_estado`,
                `juego_seguro_vasos_obs`,
                `tapa_radiador_estado`,
                `tapa_radiador_obs`,
                `varilla_aceite_estado`,
                `varilla_aceite_obs`,
                `radio_cd_estado`,
                `radio_cd_obs`,
                `tapices_alfombras_estado`,
                `tapices_alfombras_obs`,
                `injec_agua_parabrisas_estado`,
                `injec_agua_parabrisas_obs`,
                `parabrisas_estado`,
                `parabrisas_obs`,
                `trabagas_estado`,
                `trabagas_obs`,
                `lunas_puertas_estado`,
                `lunas_puertas_obs`,
                `mascara_estado`,
                `mascara_obs`,
                `copas_vasos_estado`,
                `copas_vasos_obs`,
                `seguro_ruedas_estado`,
                `seguro_ruedas_obs`,
                `chapa_puertas_estado`,
                `chapa_puertas_obs`,
                `rev_ocular_motor_estado`,
                `rev_ocular_motor_obs`,
                `alarma_estado`,
                `alarma_obs`,
                `caja_CD_estado`,
                `caja_CD_obs`,
                `otros_estado`,
                `otros_obs`,
                `firma`)
        VALUES(
                :idsiniestro,
                :fecha,
                :hora,
                :recepcionista,
                :servicio,
                :observacion,
                :kilometraje,
                :queda_taller,
                :tarjeta_propiedad_estado,
                :tarjeta_propiedad_obs,
                :antenas_estado,
                :antenas_obs,
                :soat_estado,
                :soat_obs,
                :vasos_rueda_estado,
                :vasos_rueda_obs,
                :llave_encendido_estado,
                :llave_encendido_obs,
                :brazos_plumillas_estado,
                :brazos_plumillas_obs,
                :encendedor_estado,
                :encendedor_obs,
                :direccionales_estado,
                :direccionales_obs,
                :aire_acondicionado_estado,
                :aire_acondicionado_obs,
                :llantas_estado,
                :llantas_obs,
                :cenicero_estado,
                :cenicero_obs,
                :aros_estado,
                :aros_obs,
                :claxon_estado,
                :claxon_obs,
                :faros_delanteros_estado,
                :faros_delanteros_obs,
                :luz_salon_estado,
                :luz_salon_obs,
                :faros_posteriores_estado,
                :faros_posteriores_obs,
                :parlantes_estado,
                :parlantes_obs,
                :emblemas_estado,
                :emblemas_obs,
                :correas_seguridad_estado,
                :correas_seguridad_obs,
                :escarpines_estado,
                :escarpines_obs,
                :control_alarma_estado,
                :control_alarma_obs,
                :tapa_gasolina_estado,
                :tapa_gasolina_obs,
                :asientos_estado,
                :asientos_obs,
                :llanta_repuesto_estado,
                :llanta_repuesto_obs,
                :pisos_estado,
                :pisos_obs,
                :gata_palanca_estado,
                :gata_palanca_obs,
                :espejo_interior_estado,
                :espejo_interior_obs,
                :manijas_perillas_estado,
                :manijas_perillas_obs,
                :espejo_exterior_estado,
                :espejo_exterior_obs,
                :llave_ruedas_estado,
                :llave_ruedas_obs,
                :libro_servicio_estado,
                :libro_servicio_obs,
                :tapa_aceite_estado,
                :tapa_aceite_obs,
                :juego_herramientas_estado,
                :juego_herramientas_obs,
                :tapa_liquido_freno_estado,
                :tapa_liquido_freno_obs,
                :juego_seguros_aros_estado,
                :juego_seguros_aros_obs,
                :tapa_liquido_embrague_estado,
                :tapa_liquido_embrague_obs,
                :juego_seguro_vasos_estado,
                :juego_seguro_vasos_obs,
                :tapa_radiador_estado,
                :tapa_radiador_obs,
                :varilla_aceite_estado,
                :varilla_aceite_obs,
                :radio_cd_estado,
                :radio_cd_obs,
                :tapices_alfombras_estado,
                :tapices_alfombras_obs,
                :injec_agua_parabrisas_estado,
                :injec_agua_parabrisas_obs,
                :parabrisas_estado,
                :parabrisas_obs,
                :trabagas_estado,
                :trabagas_obs,
                :lunas_puertas_estado,
                :lunas_puertas_obs,
                :mascara_estado,
                :mascara_obs,
                :copas_vasos_estado,
                :copas_vasos_obs,
                :seguro_ruedas_estado,
                :seguro_ruedas_obs,
                :chapa_puertas_estado,
                :chapa_puertas_obs,
                :rev_ocular_motor_estado,
                :rev_ocular_motor_obs,
                :alarma_estado,
                :alarma_obs,
                :caja_CD_estado,
                :caja_CD_obs,
                :otros_estado,
                :otros_obs,
                :firma
        );";
            $query = $this->db->connect()->prepare($sql);
            $query->execute([
                'idsiniestro'           => $idsiniestro,
                'fecha'           => $fecha,
                'hora'           => $hora,
                'recepcionista'         => $recepcionista,
                'servicio'              => $servicio,
                'observacion'=>$observacion,
                'kilometraje'=>$kilometraje,
                'queda_taller'=>$queda_taller,
                'tarjeta_propiedad_estado'=>$tarjeta_propiedad_estado,
                'tarjeta_propiedad_obs'=>$tarjeta_propiedad_obs,
                'antenas_estado'=>$antenas_estado,
                'antenas_obs'=>$antenas_obs,
                'soat_estado'=>$soat_estado,
                'soat_obs'=>$soat_obs,
                'vasos_rueda_estado'=>$vasos_rueda_estado,
                'vasos_rueda_obs'=>$vasos_rueda_obs,
                'llave_encendido_estado'=>$llave_encendido_estado,
                'llave_encendido_obs'=>$llave_encendido_obs,
                'brazos_plumillas_estado'=>$brazos_plumillas_estado,
                'brazos_plumillas_obs'=>$brazos_plumillas_obs,
                'encendedor_estado'=>$encendedor_estado,
                'encendedor_obs'=>$encendedor_obs,
                'direccionales_estado'=>$direccionales_estado,
                'direccionales_obs'=>$direccionales_obs,
                'aire_acondicionado_estado'=>$aire_acondicionado_estado,
                'aire_acondicionado_obs'=>$aire_acondicionado_obs,
                'llantas_estado'=>$llantas_estado,
                'llantas_obs'=>$llantas_obs,
                'cenicero_estado'=>$cenicero_estado,
                'cenicero_obs'=>$cenicero_obs,
                'aros_estado'=>$aros_estado,
                'aros_obs'=>$aros_obs,
                'claxon_estado'=>$claxon_estado,
                'claxon_obs'=>$claxon_obs,
                'faros_delanteros_estado'=>$faros_delanteros_estado,
                'faros_delanteros_obs'=>$faros_delanteros_obs,
                'luz_salon_estado'=>$luz_salon_estado,
                'luz_salon_obs'=>$luz_salon_obs,
                'faros_posteriores_estado'=>$faros_posteriores_estado,
                'faros_posteriores_obs'=>$faros_posteriores_obs,
                'parlantes_estado'=>$parlantes_estado,
                'parlantes_obs'=>$parlantes_obs,
                'emblemas_estado'=>$emblemas_estado,
                'emblemas_obs'=>$emblemas_obs,
                'correas_seguridad_estado'=>$correas_seguridad_estado,
                'correas_seguridad_obs'=>$correas_seguridad_obs,
                'escarpines_estado'=>$escarpines_estado,
                'escarpines_obs'=>$escarpines_obs,
                'control_alarma_estado'=>$control_alarma_estado,
                'control_alarma_obs'=>$control_alarma_obs,
                'tapa_gasolina_estado'=>$tapa_gasolina_estado,
                'tapa_gasolina_obs'=>$tapa_gasolina_obs,
                'asientos_estado'=>$asientos_estado,
                'asientos_obs'=>$asientos_obs,
                'llanta_repuesto_estado'=>$llanta_repuesto_estado,
                'llanta_repuesto_obs'=>$llanta_repuesto_obs,
                'pisos_estado'=>$pisos_estado,
                'pisos_obs'=>$pisos_obs,
                'gata_palanca_estado'=>$gata_palanca_estado,
                'gata_palanca_obs'=>$gata_palanca_obs,
                'espejo_interior_estado'=>$espejo_interior_estado,
                'espejo_interior_obs'=>$espejo_interior_obs,
                'manijas_perillas_estado'=>$manijas_perillas_estado,
                'manijas_perillas_obs'=>$manijas_perillas_obs,
                'espejo_exterior_estado'=>$espejo_exterior_estado,
                'espejo_exterior_obs'=>$espejo_exterior_obs,
                'llave_ruedas_estado'=>$llave_ruedas_estado,
                'llave_ruedas_obs'=>$llave_ruedas_obs,
                'libro_servicio_estado'=>$libro_servicio_estado,
                'libro_servicio_obs'=>$libro_servicio_obs,
                'tapa_aceite_estado'=>$tapa_aceite_estado,
                'tapa_aceite_obs'=>$tapa_aceite_obs,
                'juego_herramientas_estado'=>$juego_herramientas_estado,
                'juego_herramientas_obs'=>$juego_herramientas_obs,
                'tapa_liquido_freno_estado'=>$tapa_liquido_freno_estado,
                'tapa_liquido_freno_obs'=>$tapa_liquido_freno_obs,
                'juego_seguros_aros_estado'=>$juego_seguros_aros_estado,
                'juego_seguros_aros_obs'=>$juego_seguros_aros_obs,
                'tapa_liquido_embrague_estado'=>$tapa_liquido_embrague_estado,
                'tapa_liquido_embrague_obs'=>$tapa_liquido_embrague_obs,
                'juego_seguro_vasos_estado'=>$juego_seguro_vasos_estado,
                'juego_seguro_vasos_obs'=>$juego_seguro_vasos_obs,
                'tapa_radiador_estado'=>$tapa_radiador_estado,
                'tapa_radiador_obs'=>$tapa_radiador_obs,
                'varilla_aceite_estado'=>$varilla_aceite_estado,
                'varilla_aceite_obs'=>$varilla_aceite_obs,
                'radio_cd_estado'=>$radio_cd_estado,
                'radio_cd_obs'=>$radio_cd_obs,
                'tapices_alfombras_estado'=>$tapices_alfombras_estado,
                'tapices_alfombras_obs'=>$tapices_alfombras_obs,
                'injec_agua_parabrisas_estado'=>$injec_agua_parabrisas_estado,
                'injec_agua_parabrisas_obs'=>$injec_agua_parabrisas_obs,
                'parabrisas_estado'=>$parabrisas_estado,
                'parabrisas_obs'=>$parabrisas_obs,
                'trabagas_estado'=>$trabagas_estado,
                'trabagas_obs'=>$trabagas_obs,
                'lunas_puertas_estado'=>$lunas_puertas_estado,
                'lunas_puertas_obs'=>$lunas_puertas_obs,
                'mascara_estado'=>$mascara_estado,
                'mascara_obs'=>$mascara_obs,
                'copas_vasos_estado'=>$copas_vasos_estado,
                'copas_vasos_obs'=>$copas_vasos_obs,
                'seguro_ruedas_estado'=>$seguro_ruedas_estado,
                'seguro_ruedas_obs'=>$seguro_ruedas_obs,
                'chapa_puertas_estado'=>$chapa_puertas_estado,
                'chapa_puertas_obs'=>$chapa_puertas_obs,
                'rev_ocular_motor_estado'=>$rev_ocular_motor_estado,
                'rev_ocular_motor_obs'=>$rev_ocular_motor_obs,
                'alarma_estado'=>$alarma_estado,
                'alarma_obs'=>$alarma_obs,
                'caja_CD_estado'=>$caja_CD_estado,
                'caja_CD_obs'=>$caja_CD_obs,
                'otros_estado'=>$otros_estado,
                'otros_obs'=>$otros_obs,
                'firma'=> $path.$datos['idsiniestro'].'_firma.png'
            ]);

            $pdf = new FPDF();
            $pdf->SetFont('Arial','',7);
            $pdf->AddPage();
            $height_cel = 5;
            $border = 0;
            $pdf->setFillColor(230,230,230);
            $pdf->Image('http://penaranda.info/mitaller/views/public/img/logo.jpg',3,3,-200);
            $pdf->Ln(5);
            $pdf->Cell(40,$height_cel,"RECEPCIONISTA:", $border, 0, 'R');
            $pdf->Cell(60,$height_cel,utf8_decode($recepcionista), $border, 0, 'L', true);
            $pdf->Cell(30,$height_cel,"PLACA:", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,utf8_decode($placa), $border, 0, 'L', true);
            $pdf->Cell(20,$height_cel,"MARCA:", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,utf8_decode($marca), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"MODELO:", $border, 0, 'R');
            $pdf->Cell(60,$height_cel,utf8_decode($modelo), $border, 0, 'L', true);
            $pdf->Cell(30,$height_cel,"INGRESO:", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,utf8_decode($fecha), $border, 0, 'L', true);
            $pdf->Cell(20,$height_cel,"HORA:", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,utf8_decode($hora), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"PILOTO:", $border, 0, 'R');
            $pdf->Cell(150,$height_cel,utf8_decode($piloto), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"CORREO:", $border, 0, 'R');
            $pdf->Cell(60,$height_cel,utf8_decode($correo), $border, 0, 'L', true);
            $pdf->Cell(30,$height_cel,utf8_decode("TELÉFONO:"), $border, 0, 'R');
            $pdf->Cell(20,$height_cel,utf8_decode($telefono), $border, 0, 'L', true);
            $pdf->Cell(20,$height_cel,"CELULAR:", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,utf8_decode($celular), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"SERVICIO:", $border, 0, 'R');
            $pdf->Cell(150,$height_cel,utf8_decode($servicio), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,utf8_decode("OBSERVACIÓN:"), $border, 0, 'R');
            $pdf->Cell(150,$height_cel,utf8_decode($observacion), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"KILOMETRAJE:", $border, 0, 'R');
            $pdf->Cell(30,$height_cel,utf8_decode($kilometraje), $border, 0, 'L', true);
            $pdf->Cell(40,$height_cel,utf8_decode("¿QUEDA TALLER?"), $border, 0, 'R');
            $pdf->Cell(30,$height_cel,utf8_decode($queda_taller), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(40,$height_cel,"TARJETA DE PROPIEDAD", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($tarjeta_propiedad_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tarjeta_propiedad_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"ANTENAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($antenas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($antenas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"SOAT", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($soat_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($soat_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"VASOS DE RUEDA", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($vasos_rueda_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($vasos_rueda_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"LLAVE DE ENCENDIDO", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($llave_encendido_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($llave_encendido_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"BRAZOS Y PLUMILLAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($brazos_plumillas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($brazos_plumillas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"ENCENDEDOR", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($encendedor_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($encendedor_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"DIRECCIONALES", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($direccionales_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($direccionales_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"AIRE ACONDICIONADO", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($aire_acondicionado_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($aire_acondicionado_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"LLANTAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($llantas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($llantas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"CENICERO", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($cenicero_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($cenicero_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"AROS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($aros_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($aros_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,utf8_decode("CLAXÓN"), $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($claxon_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($claxon_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"FAROS DELANTEROS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($faros_delanteros_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($faros_delanteros_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,utf8_decode("LUZ DE SALÓN"), $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($luz_salon_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($luz_salon_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"FAROS POSTERIORES", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($faros_posteriores_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($faros_posteriores_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"PARLANTES", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($parlantes_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($parlantes_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"EMBLEMAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($emblemas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($emblemas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"CORREAS DE SEGURIDAD", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($correas_seguridad_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($correas_seguridad_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"ESCARPINES", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($escarpines_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($escarpines_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"CONTROL DE ALARMA", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($control_alarma_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($control_alarma_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"TAPA DE GASOLINA INT. EXT.", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($tapa_gasolina_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tapa_gasolina_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"ASIENTOS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($asientos_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($asientos_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"LLANTA DE REPUESTO", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($llanta_repuesto_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($llanta_repuesto_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"PISOS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($pisos_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($pisos_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"GATA Y PALANCA", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($gata_palanca_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($gata_palanca_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"ESPEJO INTERIOR", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($espejo_interior_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($espejo_interior_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"MANIJAS Y PERILLAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($manijas_perillas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($manijas_perillas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"ESPEJO EXTERIOR", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($espejo_exterior_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($espejo_exterior_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"LLAVE DE RUEDAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($llave_ruedas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($llave_ruedas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"LIBRO DE SERVICIO", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($libro_servicio_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($libro_servicio_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"TAPA ACEITE", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($tapa_aceite_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tapa_aceite_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"JUEGO DE HERRAMIENTAS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($juego_herramientas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($juego_herramientas_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,utf8_decode("TAPA LÍQUIDO DE FRENO"), $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($tapa_liquido_freno_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tapa_liquido_freno_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"JUEGO SEGUROS DE AROS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($juego_seguros_aros_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($juego_seguros_aros_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,utf8_decode("TAPA LÍQUIDO DE EMBRAGUE"), $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($tapa_liquido_embrague_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tapa_liquido_embrague_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"JUEGO SEGUROS DE VASOS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($juego_seguro_vasos_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($juego_seguro_vasos_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"TAPA DE RADIADOR", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($tapa_radiador_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tapa_radiador_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"TAPA ACEITE", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($tapa_aceite_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tapa_aceite_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"VARILLA DE ACEITE", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($varilla_aceite_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($varilla_aceite_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"RADIO - CD", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($radio_cd_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($radio_cd_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"TAPICES Y ALFOMBRAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($tapices_alfombras_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($tapices_alfombras_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"INJEC. DE AGUA PARABRISAS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($injec_agua_parabrisas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($injec_agua_parabrisas_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"PARABRISAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($parabrisas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($parabrisas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"TRABAGAS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($trabagas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($trabagas_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"LUNAS DE PUERTAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($lunas_puertas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($lunas_puertas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"MASCARA", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($mascara_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($mascara_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"COPAS Y VASOS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($copas_vasos_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($copas_vasos_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"SEGURO DE RUEDAS", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($seguro_ruedas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($seguro_ruedas_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"CHAPA DE PUERTAS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($chapa_puertas_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($chapa_puertas_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"REV. OCULAR MOTOR", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($rev_ocular_motor_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($rev_ocular_motor_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"ALARMA", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($alarma_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($alarma_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(40,$height_cel,"CAJA CD", $border, 0, 'R');
            $pdf->Cell(20,$height_cel,$this->getEstado($caja_CD_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($caja_CD_obs), $border, 0, 'L', true);
            $pdf->Cell(3,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(40,$height_cel,"OTROS", $border, 0, 'L');
            $pdf->Cell(20,$height_cel,$this->getEstado($otros_estado), $border, 0, 'L', true);
            $pdf->Cell(1,$height_cel,"", $border, 0, 'R');
            $pdf->Cell(32,$height_cel,utf8_decode($otros_obs), $border, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->Cell(190,2,utf8_decode("Doy conformidad a lo declarado en este documento, asimismo, autorizo al Taller a circular mi vehículo fuera de su local para las pruebas necesarias"), $border, 0, 'C', false);
            $pdf->Ln(5);
            $pdf->Image($path.$datos['idsiniestro'].'_firma.png', 90, null, -380);
            $pdf->Ln(1);
            $pdf->Cell(190,2,utf8_decode("FIRMA DEL CLIENTE"), $border, 0, 'C', false);
            

            $to = "marketing@penaranda.info, ".$correo; 
            $from = "marketing@penaranda.info"; 
            $subject = "Registro de inventario"; 
            $message = "<p>En este correo podrá encontrar el registro de inventario en formato PDF.</p>";

            $separator = md5(time());

            $eol = PHP_EOL;

            $filename = "views/uploads/inventario/registro-". $idsiniestro .".pdf";

            //$pdfdoc = $pdf->Output("", "S");
            $pdfdoc = $pdf->Output($filename, "F");
            $pdfdoc = $pdf->Output("", "S");
            $attachment = chunk_split(base64_encode($pdfdoc));

            $headers  = "From: ".$from.$eol;
            //$headers .= "CC: ".$correo_postulante.",".$mail_apoderado.$eol;
            $headers .= "MIME-Version: 1.0".$eol; 
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

            $body = "--".$separator.$eol;
            $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
            $body .= "Registro de Inventario - Peñaranda Planchado y Pintura .".$eol;
            //$body .= "La audición se llevará a cabo en el Centro Naval (Av. San Luis Cdra. 24 S/N - San Borja. .".$eol;

            $body .= "--".$separator.$eol;
            $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
            $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
            $body .= $message.$eol;

            $body .= "--".$separator.$eol;
            $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
            $body .= "Content-Transfer-Encoding: base64".$eol;
            $body .= "Content-Disposition: attachment".$eol.$eol;
            $body .= $attachment.$eol;
            $body .= "--".$separator."--";

            mail($to, $subject, $body, $headers);

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    function getEstado($id)
    {
        $str = "";
        switch($id){
            case "1":
                $str = "OPERATIVO";
                break;
            case "2":
                $str = "AVERIADO";
                break;
            case "3":
                $str = "FALTA";
                break;
            case "4":
                $str = "NO FUNCIONA";
                break;
        }

        return $str;
    }
}
?>