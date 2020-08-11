<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Savedata extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('filter_model');
        $this->load->model('data_model');
        $this->load->model('savedata_model');
        $this->load->model('function_model');
        $this->load->model('Secure_model');
        $this->load->library('ImageUploader');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->library('prestamo');
    }

    function index() {
        redirect(base_url());
    }

    function general() {
        $home = $_SERVER['DOCUMENT_ROOT'] . '/';
        return $home;
    }

    //Luis Flores - Datasoft
    function saveMarca(){
        $nombre = $this->input->post('nombre');
        $visible = $this->input->post('visible');
        $data_marca = array('nombre' => $nombre,
                            'visible' => $visible);
        $this->savedata_model->guardar('cq_marca', $data_marca);
        $this->session->set_flashdata('msg', 'Marca guardada con exito.');
        redirect(base_url().'index.php/car/marcas');
    }

    //Luis Flores - Datasoft
    function updateMarca(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $visible = $this->input->post('visible');
        $data_marca = array('nombre' => $nombre,
                            'visible' => $visible);
        $this->db->where('id_marca', $id);
        $this->db->update('cq_marca', $data_marca);
        $this->session->set_flashdata('msg', 'Marca modificada con exito.');
        redirect(base_url().'index.php/car/marcas');
    }

    //Luis Flores - Datasoft
    function deleteMarca($id){
        $this->db->delete('cq_marca', array('id_marca' => $id));
        redirect(base_url().'index.php/car/marcas');
    }
 
    //Luis Flores - Datasoft
    function saveModelo(){
        $nombre = $this->input->post('nombre');
        $marca = $this->input->post('marca');
        $data_modelo = array('nombre' => $nombre,
                            'marca' => $marca);
        $this->savedata_model->guardar('cq_modelo', $data_modelo);
        $this->session->set_flashdata('msg', 'Modelo guardado con exito.');
        redirect(base_url().'index.php/car/modelos');
    }

    //Luis Flores - Datasoft
    function updateModelo(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $marca = $this->input->post('marca');
        $data_modelo = array('nombre' => $nombre,
                            'marca' => $marca);
        $this->db->where('id_modelo', $id);
        $this->db->update('cq_modelo', $data_modelo);
        $this->session->set_flashdata('msg', 'Modelo modificado con exito.');
        redirect(base_url().'index.php/car/modelos');
    }

    //Luis Flores - Datasoft
    function deleteModelo($id){
        $this->db->delete('cq_modelo', array('id_modelo' => $id));
        redirect(base_url().'index.php/car/modelos');
    }

    //Luis Flores - Datasoft
    function savePlanCompra(){
        $tasa = $this->input->post('tasa');
        $plazo = $this->input->post('plazo');
        $prima = $this->input->post('prima');
        $recargo = $this->input->post('recargo');
        $fechai = $this->input->post('inicial');
        $fechaf = $this->input->post('final');

        $pais= $this->session->userdata('pais');

        $data_modelo = array('fecha_inicial' => $fechai,
                            'fecha_final' => $fechaf,
                            'plazo' => $plazo,
                            'tasa_anual' => $tasa,
                            'prima' => $prima,
                            'pais' => $pais,
                            'recargo' => $recargo);
                            
        $this->savedata_model->guardar('cq_planes_compra', $data_modelo);
        $this->session->set_flashdata('msg', 'Plan compra agregado con exito.');
        redirect(base_url().'index.php/car/planes/compra');
    }

    //Luis Flores - Datasoft
    function updatePlanCompra(){
        $id = $this->input->post('id');
        $tasa = $this->input->post('tasa');
        $plazo = $this->input->post('plazo');
        $prima = $this->input->post('prima');
        $recargo = $this->input->post('recargo');
        $fechai = $this->input->post('inicial');
        $fechaf = $this->input->post('final');

        $pais= $this->session->userdata('pais');

        $data_modelo = array('fecha_inicial' => $fechai,
                            'fecha_final' => $fechaf,
                            'plazo' => $plazo,
                            'tasa_anual' => $tasa,
                            'prima' => $prima,
                            'pais' => $pais,
                            'recargo' => $recargo);
        $this->db->where('id', $id);
                            
        $this->db->update('cq_planes_compra', $data_modelo);
        $this->session->set_flashdata('msg', 'Plan compra modificado con exito.');
        redirect(base_url().'index.php/car/planes/compra');
    }

    function savePlanRenting(){
        $tasa = $this->input->post('tasa');
        $plazo = $this->input->post('plazo');
        $fechai = $this->input->post('inicial');
        $fechaf = $this->input->post('final');
        $pais= $this->session->userdata('pais');

        $data_modelo = array('fecha_inicial' => $fechai,
                            'fecha_final' => $fechaf,
                            'plazo' => $plazo,
                            'tasa_anual' => $tasa,
                            'pais' => $pais);
                            
        $this->savedata_model->guardar('cq_planes_renting', $data_modelo);
        $this->session->set_flashdata('msg', 'Plan renting agregado con exito.');
        redirect(base_url().'index.php/car/planes/renting');
    }

    //Luis Flores - Datasoft
    function updatePlanRenting(){
        $id = $this->input->post('id');
        $tasa = $this->input->post('tasa');
        $plazo = $this->input->post('plazo');
        $fechai = $this->input->post('inicial');
        $fechaf = $this->input->post('final');

        $pais= $this->session->userdata('pais');

        $data_modelo = array('fecha_inicial' => $fechai,
                            'fecha_final' => $fechaf,
                            'plazo' => $plazo,
                            'tasa_anual' => $tasa,
                            'pais' => $pais);
        $this->db->where('id', $id);
                            
        $this->db->update('cq_planes_renting', $data_modelo);
        $this->session->set_flashdata('msg', 'Plan Renting modificado con exito.');
        redirect(base_url().'index.php/car/planes/renting');
    }

    //Luis Flores - Datasoft
    function saveCarInPendiente(){
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $tipo_vehiculo = $this->input->post('tipo_vehiculo');
        $pais = $this->session->userdata('pais');
        $user_id = $this->session->userdata('user_id');
        $estado = "inactivo";

        $data_car = array(
            'marca' => $marca,
            'modelo' => $modelo,
            'tipo_vehiculo' => $tipo_vehiculo,
            'pais' => $pais,
            'estado' => $estado,
            'ingreso_user' => $user_id
        );
        if($this->upload->do_upload('imagen1')){
            $car_save_id = $this->savedata_model->guardar('cq_automovil', $data_car);
            $image_upload = $this->upload->data();

            $config['image_library'] = 'gd2';
            $config['source_image'] = './imagenes/cars/'.$image_upload['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width']         = 554;
            $config['height']       = 370;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $data_image = array(
                'codigo_vehiculo' => $car_save_id,
                'imagen_path' => $image_upload['file_name']
            );

            $this->savedata_model->save_image($data_image);
            $this->session->set_flashdata('msg', 'Automóvil creado con exito.');     
        }else{
            $this->session->set_flashdata('msg', 'Ha ocurrido un error al guardar la imagen. Vuelva a intentarlo.');
        }    
        redirect(base_url() . 'index.php/car/addauto');
    }

    function saveCarPrecio(){
        $id_auto = $this->input->post('id_automovil');
        $id_renting = $this->input->post('id_renting');
        $id_compra = $this->input->post('id_compra');

        //Datos Compra || SIEMPRE APLICA ||
        $prima_c = $this->input->post('prima_c');
        $tasa_c = $this->input->post('tasa_c');
        $plazo_c = $this->input->post('plazo_c');
        $recargo_c = $this->input->post('recargo_c');
        $compra = $this->input->post('compra');
        $precio_c = $this->input->post('precio_c');
        //Default
        $plazo_r = "";
        $tasa_r = "";
        $precior = "";
        $residual_r = "";
        $mantenimiento_r = "";
        $porcen_admi_r = "";
        $cargo_admi_r = "";
        $renting_mensual = "";
        $renting_diario = "";
        $aplica_r = "no";
        //Datos Renting || SI APLICA ||
        if($this->input->post('aplicarenting')){
            $tasa_r = $this->input->post('tasa_r');
            $plazo_r = $this->input->post('plazo_r');
            $residual_r = $this->input->post('residual');
            $mantenimiento_r = $this->input->post('mantenimiento');
            $tipo_administrativo_r = $this->input->post('tipo_administrativo');
            $precior = $this->input->post('precio_r');
            $cargo_admi_r = $this->input->post('administrativo');
            $porcen_admi_r = "";
            if($tipo_administrativo_r == "porcentaje"){
                $porcen_admi_r = $this->input->post('administrativo');
                $cargo_admi_r = $cargo_admi_r * ($porcen_admi_r/100);
            }
            $renting_mensual = $this->input->post('renting');
            $renting_diario = number_format($renting_mensual/30, 2);
            $aplica_r = "si";
        }
        //INSERTANDO PRECIO RENTING
        $data_renting = array(
            'plazo' => $plazo_r,
            'tasa_anual' => $tasa_r,
            'valor_vehiculo' => $precior,
            'valor_residual' => $residual_r,
            'cargo_mantenimiento_mensual' => $mantenimiento_r,
            'tipo_administrativo' => $tipo_administrativo_r,
            'porcentaje_administrativo_mensual' => $porcen_admi_r,
            'cargo_administrativo_mensual' => $cargo_admi_r,
            'cuota_mensual' => $renting_mensual,
            'cuota_diaria' => $renting_diario,
            'aplica' => $aplica_r
        );
        $id_gen_renting = $this->savedata_model->update('renting_auto', $data_renting);
        //INSERTANDO LOS PRECIOS COMPRA
        $data_compra = array(
            'valor_vehiculo' => $precio_c,
            'prima' => $prima_c,
            'cuota_mensual' => $compra,
            'tasa' => $tasa_c,
            'plazo' => $plazo_c,
            'recargo' => $recargo_c
        );
        $id_gen_cuota = $this->savedata_model->guardar('compra_auto', $data_compra);
        $this->db->where('id_renting', $id_renting);
        $this->db->update('renting_auto', $data_renting);//Actualizan renting
        $this->db->where('id_compra', $id_compra);
        $this->db->update('compra_auto', $data_compra);//actualizando Compra
        $data_car = array(
            'renting' => $id_gen_renting,
            'compra' => $id_gen_cuota,
            'estato' => "completado"
        );
        $this->savedata_model->guardar('cq_automovil', $data_car);
        $this->session->set_flashdata('msg', 'Valores de venta agregados exitosamente.');
        redirect(base_url() . 'index.php/car/lista-pendientes');
    }
    //----------------------------------------------------------------
    //Luis Flores - Datasoft
    function savecar($action){
        $pais = $this->session->userdata('pais');
        $user_id = $this->session->userdata('user_id');

        if($pais == 1){
            date_default_timezone_set('America/El_Salvador');
        }elseif($pais == 2){
            date_default_timezone_set('America/Costa_Rica');
        }elseif($pais == 3){
            date_default_timezone_set('America/Honduras');
        }

        //Datos de auto para ingresar en cq_automoviles
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $tipo_vehiculo = $this->input->post('tipo_vehiculo');
        $visible = $this->input->post('visible');

        $data_car = array(
            'marca' => $marca,
            'modelo' => $modelo,
            'tipo_vehiculo' => $tipo_vehiculo,
            'pais' => $pais,
            'estado' => 'completado',
            'visible' => $visible,
            'ingreso_user' => $user_id
        );
        $car_save_id = $this->savedata_model->guardar('cq_automovil', $data_car);       
        
        //Datos Compra
        $prima_c = $this->input->post('prima_c');
        $tasa_c = $this->input->post('tasa_c');
        $plazo_c = $this->input->post('plazo_c');
        $recargo_c = $this->input->post('recargo_c');
        $compra = $this->input->post('compra');
        $precio_c = $this->input->post('precio_c');
        $especial_c = $this->filter_model->esCompraEspecial($tasa_c, $plazo_c, $prima_c, $recargo_c);
        
        $data_compra = array(
            'id_automovil' => $car_save_id,
            'valor_vehiculo' => $precio_c,
            'prima' => $prima_c,
            'cuota_mensual' => $compra,
            'tasa' => $tasa_c,
            'plazo' => $plazo_c,
            'recargo' => $recargo_c,
            'especial' => $especial_c
        );
        $this->savedata_model->guardar('compra_auto', $data_compra);

        //Datos Renting
        if($this->input->post('aplicarenting')){//Si aplica se rellenan datos
            $tasa_r = $this->input->post('tasa_r');
            $plazo_r = $this->input->post('plazo_r');
            $residual_r = $this->input->post('residual');
            $mantenimiento_r = $this->input->post('mantenimiento');
            $tipo_administrativo_r = $this->input->post('tipo_administrativo');
            $precior = $this->input->post('precio_r');
            $cargo_admi_r = $this->input->post('administrativo');

            $porcen_admi_r = null;
            if($tipo_administrativo_r == "porcentaje")
            {
                $porcen_admi_r = $this->input->post('administrativo');
                $cargo_admi_r = $precior * ($porcen_admi_r/100);
            }
            $renting_mensual = $this->input->post('renting');
            $renting_diario = number_format($renting_mensual/30, 2);
            $especial_r = $this->filter_model->esRentingEspecial($tasa_r, $plazo_r);

            $data_renting = array(
                'plazo' => $plazo_r,
                'tasa_anual' => $tasa_r,
                'id_automovil' => $car_save_id,
                'valor_vehiculo' => $precior,
                'valor_residual' => $residual_r,
                'cargo_mantenimiento_mensual' => $mantenimiento_r,
                'tipo_administrativo' => $tipo_administrativo_r,
                'porcentaje_administrativo_mensual' => $porcen_admi_r,
                'cargo_administrativo_mensual' => $cargo_admi_r,
                'cuota_mensual' => $renting_mensual,
                'cuota_diaria' => $renting_diario,
                'especial' => $especial_r,
                'aplica' => "si"
            );
        }else{
            $data_renting = array(
                'id_automovil' => $car_save_id,
                'aplica' => "no"
            );
        }
        $this->savedata_model->guardar('renting_auto', $data_renting);

        //Configuracion de imagen.
        $config['upload_path']          = './imagenes/cars/';
        $config['allowed_types']        = 'jpg|png';
        $config['encrypt_name']         = TRUE;
        $this->load->library('upload', $config);
  
        if($this->upload->do_upload('imagen1')){

            $image_upload = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = './imagenes/cars/'.$image_upload['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width']         = 554;
            $config['height']       = 370;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $data_image = array(
                'codigo_vehiculo' => $car_save_id,
                'imagen_path' => $image_upload['file_name']
            );
            $this->savedata_model->save_image($data_image);
            
        }else{
            echo $this->upload->display_errors();
        }

        $this->session->set_flashdata('msg', 'Automóvil creado con exito.');
        redirect(base_url() . 'index.php/car/add/');
    }

    function updateCar(){
        $id_automovil = $this->input->post('id_automovil');
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $tipo_vehiculo = $this->input->post('tipo_vehiculo');
        $visible = $this->input->post('visible');
        $data_car_edit = array(
            'marca' => $marca,
            'modelo' => $modelo,
            'tipo_vehiculo' => $tipo_vehiculo,
            'estado' => 'completado',
            'visible' => $visible
        );
        $this->db->where('id_automovil', $id_automovil);
        $this->db->update('cq_automovil', $data_car_edit);

        if($this->input->post('aplicarenting')){//Si aplica se rellenan datos
            $tasa_r = $this->input->post('tasa_r');
            $plazo_r = $this->input->post('plazo_r');
            $residual_r = $this->input->post('residual');
            $mantenimiento_r = $this->input->post('mantenimiento');
            $tipo_administrativo_r = $this->input->post('tipo_administrativo');
            $precior = $this->input->post('precio_r');
            $cargo_admi_r = $this->input->post('administrativo');

            $porcen_admi_r = null;
            if($tipo_administrativo_r == "porcentaje"){
                $porcen_admi_r = $this->input->post('administrativo');
                $cargo_admi_r = $precior * ($porcen_admi_r/100);
            }
            $renting_mensual = $this->input->post('renting');
            $renting_diario = number_format($renting_mensual/30, 2);
            
            $especial_r = $this->filter_model->esRentingEspecial($tasa_r, $plazo_r);

            $data_renting = array(
                'plazo' => $plazo_r,
                'tasa_anual' => $tasa_r,
                'valor_vehiculo' => $precior,
                'valor_residual' => $residual_r,
                'cargo_mantenimiento_mensual' => $mantenimiento_r,
                'tipo_administrativo' => $tipo_administrativo_r,
                'porcentaje_administrativo_mensual' => $porcen_admi_r,
                'cargo_administrativo_mensual' => $cargo_admi_r,
                'cuota_mensual' => $renting_mensual,
                'cuota_diaria' => $renting_diario,
                'especial' => $especial_r,
                'aplica' => "si"
            );
        }else{
            $data_renting = array(
                'plazo' => null,
                'tasa_anual' => null,
                'valor_vehiculo' => null,
                'valor_residual' => null,
                'cargo_mantenimiento_mensual' => null,
                'tipo_administrativo' => "",
                'porcentaje_administrativo_mensual' => null,
                'cargo_administrativo_mensual' => null,
                'cuota_mensual' => null,
                'cuota_diaria' => null,
                'especial' => "",
                'aplica' => "no"
            );
        }
        $this->db->where('id_automovil', $id_automovil);
        $this->db->update('renting_auto', $data_renting);

        //Datos Compra
        $prima_c = $this->input->post('prima_c');
        $tasa_c = $this->input->post('tasa_c');
        $plazo_c = $this->input->post('plazo_c');
        $recargo_c = $this->input->post('recargo_c');
        $compra = $this->input->post('compra');
        $precio_c = $this->input->post('precio_c');
        $especial_c = $this->filter_model->esCompraEspecial($tasa_c, $plazo_c, $prima_c, $recargo_c);

        $data_compra = array(
            'valor_vehiculo' => $precio_c,
            'prima' => $prima_c,
            'cuota_mensual' => $compra,
            'tasa' => $tasa_c,
            'plazo' => $plazo_c,
            'recargo' => $recargo_c,
            'especial' => $especial_c
        );
        $this->db->where('id_automovil', $id_automovil);
        $this->db->update('compra_auto', $data_compra);

        //Configuracion de imagen.
        $config['upload_path']          = './imagenes/cars/';
        $config['allowed_types']        = 'jpg|png';
        $config['encrypt_name']         = TRUE;
        $this->load->library('upload', $config);

        if($this->upload->do_upload('imagen1')){
            $image_upload = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = './imagenes/cars/'.$image_upload['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width']         = 554;
            $config['height']       = 370;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $data_image = array(
                'codigo_vehiculo' => $id_automovil,
                'imagen_path' => $image_upload['file_name']
            );
            $this->db->where('codigo_vehiculo', $id_automovil);
            $this->db->delete("imagenes");//borrando la imagen antigua

            $this->savedata_model->save_image($data_image);//guardando nueva
        }
        $this->session->set_flashdata('msg', 'Automóvil modificado con exito.');
        redirect(base_url() . 'index.php/car/estado/completado/');
    }

    function deleteCar($auto){
        $this->db->where('id_automovil', $auto);
        $this->db->delete("renting_auto");//borrando datos renting

        $this->db->where('id_automovil', $auto);
        $this->db->delete("compra_auto");//borrando datos compra

        $this->db->where('codigo_vehiculo', $auto);
        $this->db->delete("imagenes");//borrando la imagen antigua
    
        $this->db->where('id_automovil', $auto);
        $this->db->delete("cq_automovil");//borrando el automovil

        $path = $this->filter_model->getPathImg($auto);
        unlink("../../imagenes/cars/".$path."");
        $this->session->set_flashdata('msg', 'Automóvil eliminado con exito.');
        redirect(base_url() . 'index.php/car');
    }

    function updateCompraDefault(){
        $id = $this->input->post('id_c');
        $tasa = $this->input->post('tasa_c');
        $plazo = $this->input->post('plazo_c');
        $prima = $this->input->post('prima_c');
        $recargo = $this->input->post('recargo_c');

        $auto_cuotas = $this->data_model->getAllCompraAuto();
         
        foreach($auto_cuotas as $ca){

            if($ca['especial'] == "no"){
                $valor_financiar = $ca['valor_vehiculo'] - (($prima/100)*$ca['valor_vehiculo']);
                if(empty($recargo)){
                    $recargo=0;
                }
                $recargo_cal = ($recargo/100) * $ca['valor_vehiculo'];

                $prestamo = new Prestamo(10);
                $prestamo->setCapital($valor_financiar);
                $prestamo->setTasaInteres($tasa / 100 / 12);
                $prestamo->setRecargo($recargo_cal);
                $cuota = $prestamo->calcCuota($plazo);
        
                $cuota_con_iva = number_format((float) ($cuota * 1.13), 2, '.', '');

                $data_new_cuota = array(
                    'prima' => $prima,
                    'cuota_mensual' => $cuota_con_iva,
                    'tasa' => $tasa,
                    'plazo' => $plazo,
                    'recargo' => $recargo,
                    'especial' => 'no'
                );
                $this->savedata_model->actualizar(array('id_automovil' => $ca['id_automovil']), "compra_auto", $data_new_cuota);
            }
        }
        $data_compra = array(
            'tasa_anual' => $tasa,
            'plazo' => $plazo,
            'prima' => $prima,
            'recargo' => $recargo
        );
        $this->savedata_model->actualizar(array('id' => $id), "cq_planes_compra", $data_compra);

        $this->session->set_flashdata('msg', 'Datos de cuotas para compra actualizados exitosamente.');
        redirect(base_url() . 'index.php/car/precios/');
    }

    function updateRentingDefault(){
        $id = $this->input->post('id_r');
        $tasa = $this->input->post('tasa_r');
        $plazo = $this->input->post('plazo_r');

        $auto_rentings = $this->data_model->getAllRentingAuto();
        foreach($auto_rentings as $ren){
            if($ren['especial'] == "no"){
                $valor_res = $ren['valor_residual'];
                $valor_veh = $ren['valor_vehiculo'];
                $int_anual =  $tasa;
                $nper = $plazo;
                $i_men = ($int_anual / 100)/12;

                $renting = 0;
                $renting = ($valor_veh-(($valor_res/pow((1+$i_men),$nper))))/((1-(1/pow((1+$i_men),$nper)))/($i_men));
                
                $mante_mensual = $ren['cargo_mantenimiento_mensual']/$nper;
                $adminis = $ren['cargo_administrativo_mensual'];
                $rentingconIva = ($renting + $mante_mensual + $adminis) * 1.13;
                $rentingconIva = number_format((float) $rentingconIva, 2, '.', '');
                $ren_diario = $rentingconIva/30;
                $data_new_renting = array(
                    'plazo' => $plazo,
                    'tasa_anual' => $tasa,
                    'cuota_mensual' => $rentingconIva,
                    'cuota_diaria' => $ren_diario,
                    'especial' => 'no'
                );
                $this->savedata_model->actualizar(array('id_automovil' => $ren['id_automovil']), "renting_auto", $data_new_renting);
            }
        }

        $data_renting = array(
            'tasa_anual' => $tasa,
            'plazo' => $plazo
        );
        $this->savedata_model->actualizar(array('id' => $id), "cq_planes_renting", $data_renting);
        $this->session->set_flashdata('msg', 'Datos de cuotas renting actualizados exitosamente.');
        redirect(base_url() . 'index.php/car/precios/');
    }

    function saveUser() {//del formulario de registro del site

        //datos desde el formulario
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $email = $this->input->post('email');
        $marca_favorita = $this->input->post('marca_favorita');
        $modelo_favorito = $this->input->post('modelo');
        $profesion = $this->input->post('profesion');
        $pais = $this->input->post('pais');
        $telefono = $this->input->post('telefono');

        //re-verificamos si el user existe
        $exi = $this->Secure_model->checkEmail($email);
        if ($exi == TRUE) {
            redirect(base_url() . 'index.php/site/aviso/2');
        }
        //se enviara a usuario
        //$temp_clave       = "hola";
        $temp_clave = $this->Secure_model->generateClave($nombres);
        $clave = md5(utf8_encode($temp_clave));
        $tipo_usuario = '2';
        $estado = md5($email);
        $datos = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'pais' => $pais,
            'clave' => $clave,
            'tipo_usuario' => $tipo_usuario,
            'estado' => $estado,
            'primium' => '0',
            'fecha_registro' => date('Y-m-d'),
        );
        //$this->session->set_userdata('temp_data',$datos);
        // GUARDAMOS QUE ACABAMOS DE CREAR Y OBTENEMOS EL ULTIMO ID
        $last_id = $this->savedata_model->guardar('cq_usuario', $datos);
        //Guardamos numero de telefono
        $dato_tel = array(
            //'id_telefono' => '',
            'id_usuario' => $last_id,
            'telefono' => $telefono,
            'codigo_pais' => $pais
        );

        $this->savedata_model->guardar('cq_telefonos', $dato_tel);

        // EVIAMOS NOTIFICACION DE CORREO
        $nombre = $nombres . " " . $apellidos;

        $datos = array('tipo' => 'registro',
            'to' => $email,
            'clave' => $temp_clave,
            'nombre' => $nombre);


        if ($this->function_model->enviarMail($datos)) {

            redirect(base_url() . 'index.php/site/aviso/1');
        } else {
            redirect(base_url() . 'index.php/site/aviso/3');
        }
    }

    function crearUser() {

        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $email = $this->input->post('email');
        $pais = $this->input->post('pais');
        $tipo_usuario = $this->input->post('tipo_usuario');
        $estado = $this->input->post('estado');
        $tel1 = $this->input->post("telefono1");
        $tel2 = $this->input->post("telefono2");
        $pass = $this->input->post('pass1');
            
        $datos = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'pais' => $pais,
            'clave' => md5($pass),
            'tipo_usuario' => $tipo_usuario,
            'estado' => $estado
        );
        $last_id = $this->savedata_model->Guardar('cq_usuario', $datos);

        //Guardamos en base los datos de telefonos
        for ($i = 1; $i <= 2; $i++) {

            if ($this->input->post('telefono' . $i)) {
                $dato_tel = array(
                    'id_usuario' => $last_id,
                    'telefono' => $this->input->post('telefono' . $i),
                    'codigo_pais' => $this->input->post('pais')
                );

                $this->savedata_model->guardar('cq_telefonos', $dato_tel);
            }
        }
        $this->session->set_flashdata('msg', 'Usuario creado con exito.');
        redirect(base_url() . 'index.php/user/lista');
    }

    //Luis Flores - Datasoft
    function updateUser() {
        $id_user = $this->input->post('id_usuario');
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $email = $this->input->post('email');
        $pais = $this->input->post('pais');
        $tipo_usuario = $this->input->post('tipo_usuario');
        $estado = $this->input->post('estado');

        $datos = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'pais' => $pais,
            'tipo_usuario' => $tipo_usuario,
            'estado' => $estado
        );
        
        $this->savedata_model->actualizar(array('id_usuario' => $id_user), 'cq_usuario', $datos);

        $this->Secure_model->eliminarTelefonos($id_user);
               
        if ($this->input->post('telefono1')) {//si existe
            $telefono = $this->input->post('telefono1');
            $dato_tel = array(
                'id_usuario' => $id_user,
                'telefono' => $telefono,
                'codigo_pais' => $pais
            );
            $this->savedata_model->guardar('cq_telefonos', $dato_tel);
        }

        if ($this->input->post('telefono2')) {//si existe
            $telefono = $this->input->post('telefono2');
            $dato_tel = array(
                'id_usuario' => $id_user,
                'telefono' => $telefono,
                'codigo_pais' => $pais
            );
            $this->savedata_model->guardar('cq_telefonos', $dato_tel);
        }
        
        $split = explode(' ', $nombres);
        $user_name = $split[0];
        $split = explode(' ', $apellidos);
        $user_name .= ' ' . $split[0];

        $this->session->set_userdata("user_name", $user_name);
        $this->session->set_flashdata('msg', 'Usuario modificado con exito.');
        redirect(base_url() ."index.php/user/modificar/".$id_user);
    }

    function updatePass() {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $pass = $this->input->post('pass1');
            $oldpass = $this->input->post('oldpass');
            $datos_pas = array('clave' => md5($pass));

            if ($this->input->post('oldpass')) {
                if ($this->session->userdata('user_clab') == md5($oldpass)) {
                    $this->savedata_model->updateData('id_usuario', $this->session->userdata('user_id'), 'cq_usuario', $datos_pas);
                    redirect(base_url() . 'index.php/site/aviso/13');
                } else {
                    redirect(base_url() . 'index.php/site/aviso/12');
                }
            } else {
                $this->savedata_model->updateData('id_usuario', $this->input->post('id_usuario'), 'cq_usuario', $datos_pas);
                redirect(base_url() . 'index.php/user/modificar/' . $this->input->post('id_usuario'));
            }
        }
    }

    function saveAdvert() {
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            $home = $this->general();
            //code
            //datos desde el formulario
            $nombre = $this->input->post('nombre');
            $seccion = $this->input->post('seccion');
            $tipo = $this->input->post('tipo');
            $posicion = $this->input->post('posicion');
            $estado = $this->input->post('estado');
            $inicio = $this->input->post('inicio');
            $fin = $this->input->post('fin');
            $link = $this->input->post('link');
            date_default_timezone_set('America/El_Salvador');
            $datos = array(
                'id_banner' => '',
                'nombre' => $nombre,
                'posicion' => $posicion,
                'banner' => '',
                'creacion' => date('Y-m-d 00:00:00'),
                'hits' => '0',
                'clicks' => '0',
                'estado' => $estado,
                'fecha_publicacion' => $inicio,
                'fecha_expiracion' => $fin,
                'creado_por' => $this->session->userdata('user_id'),
                'modificado_por' => $this->session->userdata('user_id'),
                'link' => $link,
                'seccion' => $seccion,
                'tipo' => $tipo,
                'pais' => $this->session->userdata('pais')
            );
            $id_banner = $this->savedata_model->Guardar('cq_banner', $datos);
            //Guardamos imagenes
            $nombre_img = $this->input->post('nombre_img');
            for ($i = 1; $i <= 4; $i++) {//son cuatro y las buscamos con un for
                if ($_FILES["archivo" . $i]['name'] != "") {
                    $vector = substr(md5($id_banner), 0, 8) . '-' . $_FILES["archivo" . $i]['name'];
                    $destino_vector = $home . 'public/banners/' . $vector;
                    if (move_uploaded_file($_FILES["archivo" . $i]['tmp_name'], $destino_vector)) {
                        echo 'ok';
                    } else {
                        echo 'fallo';
                    }
                    $datos_img_banner = array(
                        'id_imagen' => '',
                        'imagen' => $vector,
                        'id_banner' => $id_banner,
                        'orden' => $i,
                        'alt_text' => $nombre_img[$i - 1]
                    );
                    $this->savedata_model->Guardar('cq_imagen_x_banner', $datos_img_banner);
                }
            }
            redirect(base_url() . 'index.php/site/aviso/17');
        }//fin if user
    }

}
//fin clase =(