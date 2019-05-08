<?PHP
class SiniestroController extends Controller
{
    function __construct(){
        parent::__construct();
        //$this->$siniestros = [];
    }

    public function ListaSiniestros()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->ListaSiniestros($datos["nroplaca"]);
        echo json_encode($siniestros);
    }

    public function RegistraSiniestro()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->RegistraSiniestro($datos);
        echo $siniestros;
    }

    public function ZipSiniestro()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $idsiniestro = $datos['idsiniestro'];
        
        //$rootPath = realpath(".")."\\views\\uploads\\".$idsiniestro;
        $rootPath = realpath(".")."/views/uploads/".$idsiniestro;
        $zip = new ZipArchive();
        $zip->open('views/uploads/'.$idsiniestro.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        $archivo = 'views/uploads/'.$idsiniestro.'.zip';
        $estado = "0";
        if (file_exists($archivo)) {
            $estado = "1";
        }

        $info = '{"file": "'.$archivo.'", "estado": "'.$estado.'"}';
        echo json_encode($info);
    }

    public function EliminaSiniestro()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->EliminaSiniestro($datos["idsiniestro"]);
        echo json_encode($siniestros);
        
    }

    public function ActualizaObservacion()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $siniestros = $this->model->ActualizaObservacion($datos);
        echo json_encode($siniestros);
    }

    public function InsertaInventario()
    {   
        $datos = array();
        $datos['idsiniestro'] = $_POST['txt_inv_siniestro'];
        $datos['fecha'] = $_POST['txt_inv_ingreso'];
        $datos['hora'] = $_POST['txt_inv_hora'];

        $datos['placa'] = $_POST['txt_inv_placa'];
        $datos['marca'] = $_POST['txt_inv_marca'];
        $datos['modelo'] = $_POST['txt_inv_modelo'];
        $datos['piloto'] = $_POST['txt_inv_piloto'];
        $datos['telefono'] = $_POST['txt_inv_telefono'];
        $datos['celular'] = $_POST['txt_inv_celular'];
        $datos['correo'] = $_POST['txt_inv_correo'];

        $datos['recepcionista'] = $_POST['txt_inv_recepcionista'];
        $datos['servicio'] = $_POST['txt_inv_servicio'];
        $datos['observacion'] = $_POST['txt_inv_observacion'];
        $datos['kilometraje'] = $_POST['txt_inv_kilometraje'];
        //$datos['queda_taller'] = $_POST['txt_inv_queda'];
        $datos['tarjeta_propiedad_estado'] = $_POST['sl_inv_tarjpropiedad'];
        $datos['tarjeta_propiedad_obs'] = $_POST['txt_inv_tarjpropiedad'];
        $datos['antenas_estado'] = $_POST['sl_inv_antenas'];
        $datos['antenas_obs'] = $_POST['txt_inv_antenas'];
        $datos['soat_estado'] = $_POST['sl_inv_soat'];
        $datos['soat_obs'] = $_POST['txt_inv_soat'];
        $datos['vasos_rueda_estado'] = $_POST['sl_inv_vasosrueda'];
        $datos['vasos_rueda_obs'] = $_POST['txt_inv_vasosrueda'];
        $datos['llave_encendido_estado'] = $_POST['sl_inv_llaveencendido'];
        $datos['llave_encendido_obs'] = $_POST['txt_inv_llaveencendido'];
        $datos['brazos_plumillas_estado'] = $_POST['sl_inv_brazosplumillas'];
        $datos['brazos_plumillas_obs'] = $_POST['txt_inv_brazosplumillas'];
        $datos['encendedor_estado'] = $_POST['sl_inv_encendedor'];
        $datos['encendedor_obs'] = $_POST['txt_inv_encendedor'];
        $datos['direccionales_estado'] = $_POST['sl_inv_direccionales'];
        $datos['direccionales_obs'] = $_POST['txt_inv_direccionales'];
        $datos['aire_acondicionado_estado'] = $_POST['sl_inv_aireacondicionado'];
        $datos['aire_acondicionado_obs'] = $_POST['txt_inv_aireacondicionado'];
        $datos['llantas_estado'] = $_POST['sl_inv_llantas'];
        $datos['llantas_obs'] = $_POST['txt_inv_llantas'];
        $datos['cenicero_estado'] = $_POST['sl_inv_cenicero'];
        $datos['cenicero_obs'] = $_POST['txt_inv_cenicero'];
        $datos['aros_estado'] = $_POST['sl_inv_aros'];
        $datos['aros_obs'] = $_POST['txt_inv_aros'];
        $datos['claxon_estado'] = $_POST['sl_inv_claxon'];
        $datos['claxon_obs'] = $_POST['txt_inv_claxon'];
        $datos['faros_delanteros_estado'] = $_POST['sl_inv_farosdelanteros'];
        $datos['faros_delanteros_obs'] = $_POST['txt_inv_farosdelanteros'];
        $datos['luz_salon_estado'] = $_POST['sl_inv_luzsalon'];
        $datos['luz_salon_obs'] = $_POST['txt_inv_luzsalon'];
        $datos['faros_posteriores_estado'] = $_POST['sl_inv_farosposteriores'];
        $datos['faros_posteriores_obs'] = $_POST['txt_inv_farosposteriores'];
        $datos['parlantes_estado'] = $_POST['sl_inv_parlantes'];
        $datos['parlantes_obs'] = $_POST['txt_inv_parlantes'];
        $datos['emblemas_estado'] = $_POST['sl_inv_emblemas'];
        $datos['emblemas_obs'] = $_POST['txt_inv_emblemas'];
        $datos['correas_seguridad_estado'] = $_POST['sl_inv_correasseguridad'];
        $datos['correas_seguridad_obs'] = $_POST['txt_inv_correasseguridad'];
        $datos['escarpines_estado'] = $_POST['sl_inv_escarpines'];
        $datos['escarpines_obs'] = $_POST['txt_inv_escarpines'];
        $datos['control_alarma_estado'] = $_POST['sl_inv_controlalarma'];
        $datos['control_alarma_obs'] = $_POST['txt_inv_controlalarma'];
        $datos['tapa_gasolina_estado'] = $_POST['sl_inv_tapagasolina'];
        $datos['tapa_gasolina_obs'] = $_POST['txt_inv_tapagasolina'];
        $datos['asientos_estado'] = $_POST['sl_inv_asientos'];
        $datos['asientos_obs'] = $_POST['txt_inv_asientos'];
        $datos['llanta_repuesto_estado'] = $_POST['sl_inv_llantarepuesto'];
        $datos['llanta_repuesto_obs'] = $_POST['txt_inv_llantarepuesto'];
        $datos['pisos_estado'] = $_POST['sl_inv_pisos'];
        $datos['pisos_obs'] = $_POST['txt_inv_pisos'];
        $datos['gata_palanca_estado'] = $_POST['sl_inv_gatapalanca'];
        $datos['gata_palanca_obs'] = $_POST['txt_inv_gatapalanca'];
        $datos['espejo_interior_estado'] = $_POST['sl_inv_espejointerior'];
        $datos['espejo_interior_obs'] = $_POST['txt_inv_espejointerior'];
        $datos['manijas_perillas_estado'] = $_POST['sl_inv_manijas'];
        $datos['manijas_perillas_obs'] = $_POST['txt_inv_manijas'];
        $datos['espejo_exterior_estado'] = $_POST['sl_inv_espejoexterior'];
        $datos['espejo_exterior_obs'] = $_POST['txt_inv_espejoexterior'];
        $datos['llave_ruedas_estado'] = $_POST['sl_inv_llaveruedas'];
        $datos['llave_ruedas_obs'] = $_POST['txt_inv_llaveruedas'];
        $datos['libro_servicio_estado'] = $_POST['sl_inv_libroservicio'];
        $datos['libro_servicio_obs'] = $_POST['txt_inv_libroservicio'];
        $datos['tapa_aceite_estado'] = $_POST['sl_inv_tapaaceite'];
        $datos['tapa_aceite_obs'] = $_POST['txt_inv_tapaaceite'];
        $datos['juego_herramientas_estado'] = $_POST['sl_inv_juegoherramientas'];
        $datos['juego_herramientas_obs'] = $_POST['txt_inv_juegoherramientas'];
        $datos['tapa_liquido_freno_estado'] = $_POST['sl_inv_tapaliquido'];
        $datos['tapa_liquido_freno_obs'] = $_POST['txt_inv_tapaliquido'];
        $datos['juego_seguros_aros_estado'] = $_POST['sl_inv_juegoseguroaros'];
        $datos['juego_seguros_aros_obs'] = $_POST['txt_inv_juegoseguroaros'];
        $datos['tapa_liquido_embrague_estado'] = $_POST['sl_inv_tapaliquidoembrague'];
        $datos['tapa_liquido_embrague_obs'] = $_POST['txt_inv_tapaliquidoembrague'];
        $datos['juego_seguro_vasos_estado'] = $_POST['sl_inv_juegosegurovasos'];
        $datos['juego_seguro_vasos_obs'] = $_POST['txt_inv_juegosegurovasos'];
        $datos['tapa_radiador_estado'] = $_POST['sl_inv_taparadiador'];
        $datos['tapa_radiador_obs'] = $_POST['txt_inv_taparadiador'];
        $datos['varilla_aceite_estado'] = $_POST['sl_inv_varillaaceite'];
        $datos['varilla_aceite_obs'] = $_POST['txt_inv_varillaaceite'];
        $datos['radio_cd_estado'] = $_POST['sl_inv_radiocd'];
        $datos['radio_cd_obs'] = $_POST['txt_inv_radiocd'];
        $datos['tapices_alfombras_estado'] = $_POST['sl_inv_tapicesalfombras'];
        $datos['tapices_alfombras_obs'] = $_POST['txt_inv_tapicesalfombras'];
        $datos['injec_agua_parabrisas_estado'] = $_POST['sl_inv_injecagua'];
        $datos['injec_agua_parabrisas_obs'] = $_POST['txt_inv_injecagua'];
        $datos['parabrisas_estado'] = $_POST['sl_inv_parabrisas'];
        $datos['parabrisas_obs'] = $_POST['txt_inv_parabrisas'];
        $datos['trabagas_estado'] = $_POST['sl_inv_trabagas'];
        $datos['trabagas_obs'] = $_POST['txt_inv_trabagas'];
        $datos['lunas_puertas_estado'] = $_POST['sl_inv_lunaspuertas'];
        $datos['lunas_puertas_obs'] = $_POST['txt_inv_lunaspuertas'];
        $datos['mascara_estado'] = $_POST['sl_inv_mascara'];
        $datos['mascara_obs'] = $_POST['txt_inv_mascara'];
        $datos['copas_vasos_estado'] = $_POST['sl_inv_copasvasos'];
        $datos['copas_vasos_obs'] = $_POST['txt_inv_copasvasos'];
        $datos['seguro_ruedas_estado'] = $_POST['sl_inv_seguroruedas'];
        $datos['seguro_ruedas_obs'] = $_POST['txt_inv_seguroruedas'];
        $datos['chapa_puertas_estado'] = $_POST['sl_inv_chapapuertas'];
        $datos['chapa_puertas_obs'] = $_POST['txt_inv_chapapuertas'];
        $datos['rev_ocular_motor_estado'] = $_POST['sl_inv_revocular'];
        $datos['rev_ocular_motor_obs'] = $_POST['txt_inv_revocular'];
        $datos['alarma_estado'] = $_POST['sl_inv_alarma'];
        $datos['alarma_obs'] = $_POST['txt_inv_alarma'];
        $datos['caja_CD_estado'] = $_POST['sl_inv_cajacd'];
        $datos['caja_CD_obs'] = $_POST['txt_inv_cajacd'];
        $datos['otros_estado'] = $_POST['sl_inv_otros'];
        $datos['otros_obs'] = $_POST['txt_inv_otros'];
        //$datos = json_decode($datos, true);
        $inventario = $this->model->InsertaInventario($datos);
        echo json_encode($inventario);
    }

    public function GetObservacion()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $observaciones = $this->model->GetObservacion($datos["idsiniestro"]);
        echo json_encode($observaciones);
    }

    function InfoPanel()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $numero = $this->model->InfoPanel($datos['tipo']);
        echo json_encode($numero);
    }
    
    function ListaEstadosInventario()
    {
        $datos = $this->model->ListaEstadosInventario();
        echo json_encode($datos);
    }
}
?>