<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * +-----------------------------------------+
 * |              WEB-INFORMATICA            |
 * |-----------------------------------------|
 * | @subject : Sistema de Venta             |
 * | @owner   : Credi Q                      |
 * |                                         |
 * | @author  : Web-Informatica              |
 * | @package : cqventa                      |
 * | @copy    : Web-Informatica              |
 * +-----------------------------------------+
 * http://web-informatica.com

 * */
class Solicitud_save extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('data_model');
        $this->load->model('function_model');
        $this->load->model('Savedata_model');
        $this->load->helper('cookie');
        $this->load->library('Session');
    }

    function index() {
        redirect(base_url());
    }

    function general() {
        //Categorias (Tipos de Vehiculo)
        $data['categories'] = $this->data_model->getCategories();
        //Publicidad
        $data['banners'] = $this->data_model->getBanners();

        $data['bannersPosition'] = $this->data_model->Banners();

        $data['paises'] = $this->data_model->getPaises();
        $data['moneda'] = $this->session->userdata('moneda');

        return $data;
    }

    function credito_natural($paso) {



        if ($paso == 1) {

            if ($this->session->userdata('user_id')) {
                $id_usuario = $this->session->userdata('user_id');
            } else {
                $id_usuario = NULL;
            }
            $tipo_solicitud = $this->input->post('tipo_solicitud');

            /*MODIFICADO POR GGONZALEZ 21/05/2015 -  INI*/
            $pais= $this->session->userdata('pais');

             if ($pais == 1){
            date_default_timezone_set('America/El_Salvador');
            }

            elseif ($pais == 2){

            date_default_timezone_set('America/Costa_Rica');
            }

            elseif ($pais == 3){
             date_default_timezone_set('America/Honduras');
            }

            /*MODIFICADO POR GGONZALEZ 21/05/2015 -  FIN*/
            $fecha = date("d-m-Y");
            $datos_generales = array('fecha' => $fecha,
                'id_usuario' => $id_usuario,
                'producto' => $this->input->post('producto'),
                'valor_de_compra' => $this->input->post('valor_de_compra'),
                'valor_de_prima' => $this->input->post('valor_de_prima'),
                'canje' => $this->input->post('canje'),
                'valor_a_financiar' => $this->input->post('valor_a_financiar'),
                'plazo' => $this->input->post('plazo'),
                'prima' => $this->input->post('prima'),
                'tasa' => $this->input->post('tasa'),
                'garantia' => $this->input->post('garantia'),
                'nueva' => $this->input->post('nueva'),
                'usada' => $this->input->post('usada'),
                'marca' => $this->input->post('marca'),
                'modelo' => $this->input->post('modelo'),
                'asesor_de_ventas' => $this->input->post('asesor_de_ventas'),
                'fecha_sugerida_de_pago' => $this->input->post('fecha_sugerida_de_pago'),
                'tipo_solicitud' => $tipo_solicitud,
                'estado' => 'editando'
            );
            $id_solicitud = $this->session->userdata('id_solicitud');
            if ($id_solicitud == "") {
                $id_solicitud = $this->Savedata_model->guardar('cq_sol_solicitud', $datos_generales);
                $this->session->set_userdata('id_solicitud', $id_solicitud);
            }

            $this->session->set_userdata('datos_generales', $datos_generales);
            $this->session->set_userdata('paso1', 'ok');

            redirect(base_url() . 'index.php/solicitud/credito_natural/2');
        } elseif ($paso == 2) {
            if ($this->session->userdata('paso1') == 'ok') {
                //guardamos datos paso2

                $solicitante = array();

                $id_solicitud = $this->session->userdata('id_solicitud');

                $tipo_solicitud = $this->input->post('tipo_solicitud');

                $solicitante = array('id' => '',
                    'id_solicitud' => $id_solicitud,
                    'tipo_cliente' => $this->input->post('tipo_cliente'),
                    'nombre' => $this->input->post('nombre'),
                    'sexo' => $this->input->post('sexo'),
                    'nacionalidad' => $this->input->post('nacionalidad'),
                    'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
                    'estado_familiar' => $this->input->post('estado_familiar'),
                    'dui' => $this->input->post('dui'),
                    'nit' => $this->input->post('nit'),
                    'n_carnet_residente' => $this->input->post('n_carnet_residente'),
                    'profesion' => $this->input->post('profesion'),
                    'direccion_particular' => $this->input->post('direccion_particular'),
                    'bo_colonia' => $this->input->post('bo_colonia'),
                    'municipio' => $this->input->post('municipio'),
                    'departamento' => $this->input->post('departamento'),
                    'telefono' => $this->input->post('telefono'),
                    'celular' => $this->input->post('celular'),
                    'email' => $this->input->post('email'),
                    'tipo_vivienda' => $this->input->post('tipo_vivienda'),
                    'pago_mensual' => $this->input->post('pago_mensual'),
                    'tiempo_de_residir' => $this->input->post('tiempo_de_residir'),
                    'zona_residencial' => $this->input->post('zona_residencial'),
                    'posee' => $this->input->post('posee'),
                    'financiada_en' => $this->input->post('financiada_en'),
                    'saldo' => $this->input->post('saldo'),
                    'cuota_actual' => $this->input->post('cuota_actual'),
                    'enviar_correspondencia' => $this->input->post('enviar_correspondencia'),
                    'n_dependientes' => $this->input->post('n_dependientes'),
                    'n_hijos' => $this->input->post('n_hijos')
                );


                $laboral = array('id_solicitud' => $id_solicitud,
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante',
                    'lugar' => $this->input->post('lab_lugar'),
                    'fecha_ingreso' => $this->input->post('lab_fecha_ingreso'),
                    'direccion' => $this->input->post('lab_direccion'),
                    'cargo' => $this->input->post('lab_cargo'),
                    'jefe_inmediato' => $this->input->post('lab_jefe_inmediato'),
                    'telefono' => $this->input->post('lab_telefono'),
                    'salario' => $this->input->post('lab_salario'),
                    'otros_ingresos' => $this->input->post('lab_otros_ingresos'),
                    'origen_otros_ingresos' => $this->input->post('lab_origen_otros_ingresos'),
                    'gastos' => $this->input->post('lab_gastos'),
                    'anterior' => $this->input->post('lab_anterior'),
                    'anterior_tel' => $this->input->post('lab_anterior_tel'),
                    'anterior_desde' => $this->input->post('lab_anterior_desde'),
                    'anterior_hasta' => $this->input->post('lab_anterior_hasta'),
                    'anterior_ingresos' => $this->input->post('lab_anterior_ingresos'));

                $conyuge = array('id' => '',
                    'id_solicitud' => $id_solicitud,
                    'nombre' => $this->input->post('con_nombre'),
                    'lugar_trabajo' => $this->input->post('con_lugar_trabajo'),
                    'cargo' => $this->input->post('con_cargo'),
                    'fecha_ingreso' => $this->input->post('con_fecha_ingreso'),
                    'telefono' => $this->input->post('con_telefono'),
                    'celular' => $this->input->post('con_celular'),
                    'salario' => $this->input->post('con_salario'),
                    'email' => $this->input->post('con_email'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );


                $vehiculo = array('id' => '',
                    'id_solicitud' => $id_solicitud,
                    'vehiculo_propio' => $this->input->post('vehiculo_propio'),
                    'marca' => $this->input->post('marca'),
                    'modelo' => $this->input->post('modelo'),
                    'year' => $this->input->post('year'),
                    'placa' => $this->input->post('placa'),
                    'financiado' => $this->input->post('financiado'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );


                $ref_crediq1 = array(
                    'id_solicitud' => $id_solicitud,
                    'crediq' => $this->input->post('ref_crediq1'),
                    'tipo_credito' => $this->input->post('ref_crediq_tipo_credito1'),
                    'monto' => $this->input->post('ref_crediq_monto1'),
                    'referencia' => $this->input->post('1ref_crediq_referencia_n'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );
                $ref_crediq2 = array(
                    'id_solicitud' => $id_solicitud,
                    'crediq' => $this->input->post('ref_crediq2'),
                    'tipo_credito' => $this->input->post('ref_crediq_tipo_credito2'),
                    'monto' => $this->input->post('ref_crediq_monto2'),
                    'referencia' => $this->input->post('2ref_crediq_referencia_n'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );


                $ref_financiera = array(
                    'id_solicitud' => $id_solicitud,
                    'financiera' => $this->input->post('ref_financiera'),
                    'otorgamiento' => $this->input->post('ref_financiera_otorgamiento'),
                    'vencimiento' => $this->input->post('ref_financiera_vencimiento'),
                    'monto' => $this->input->post('ref_financiera_monto'),
                    'saldo' => $this->input->post('ref_financiera_saldo'),
                    'cuota' => $this->input->post('ref_financiera_cuota'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );
                $ref_tarjeta = array(
                    'id_solicitud' => $id_solicitud,
                    'emisor' => $this->input->post('ref_tarjeta_emisor'),
                    '_2_' => $this->input->post('ref_tarjeta_2'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );
                $ref_comercial = array(
                    'id_solicitud' => $id_solicitud,
                    'comercial' => $this->input->post('ref_comercial'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante',
                    'n_cuenta' => '',
                    'telefono' => '',
                );
                $ref_personal1 = array(
                    'id_solicitud' => $id_solicitud,
                    'personal' => $this->input->post('ref_personal1'),
                    'telefono' => $this->input->post('ref_per_telefono1'),
                    'celular' => $this->input->post('ref_per_celular1'),
                    'direccion' => $this->input->post('ref_per_direccion1'),
                    'parentesco' => '',
                    'direccion_trabajo' => '',
                    'tipo_referencia' => 'personal',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );

                $ref_personal2 = array(
                    'id_solicitud' => $id_solicitud,
                    'personal' => $this->input->post('ref_personal2'),
                    'telefono' => $this->input->post('ref_per_telefono2'),
                    'celular' => $this->input->post('ref_per_celular2'),
                    'direccion' => $this->input->post('ref_per_direccion2'),
                    'parentesco' => '',
                    'direccion_trabajo' => '',
                    'tipo_referencia' => 'personal',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante'
                );
                $ref_familiar1 = array(
                    'id_solicitud' => $id_solicitud,
                    'personal' => $this->input->post('ref_familiar1'),
                    'telefono' => $this->input->post('ref_fam_telefono1'),
                    'celular' => $this->input->post('ref_fam_celular1'),
                    'direccion' => $this->input->post('ref_fam_direccion1'),
                    'parentesco' => $this->input->post('ref_fam_parentesco1'),
                    'direccion_trabajo' => $this->input->post('ref_fam_direccion_trabajo1'),
                    'tipo_referencia' => 'familiar',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante',
                    'telefono_trabajo' => $this->input->post('ref_fam_telefono_tra1')
                );
                $ref_familiar2 = array(
                    'id_solicitud' => $id_solicitud,
                    'personal' => $this->input->post('ref_familiar2'),
                    'telefono' => $this->input->post('ref_fam_telefono2'),
                    'celular' => $this->input->post('ref_fam_celular2'),
                    'direccion' => $this->input->post('ref_fam_direccion2'),
                    'parentesco' => $this->input->post('ref_fam_parentesco2'),
                    'direccion_trabajo' => $this->input->post('ref_fam_direccion_trabajo2'),
                    'tipo_referencia' => 'familiar',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'solicitante',
                    'telefono_trabajo' => $this->input->post('ref_fam_telefono_tra2')
                );



                $this->session->set_userdata('solicitante', $solicitante);
                $this->session->set_userdata('laboral', $laboral);
                $this->session->set_userdata('conyuge', $conyuge);
                $this->session->set_userdata('vehiculo', $vehiculo);

                $this->session->set_userdata('ref_crediq1', $ref_crediq1);
                $this->session->set_userdata('ref_crediq2', $ref_crediq2);

                $this->session->set_userdata('ref_financiera', $ref_financiera);
                $this->session->set_userdata('ref_tarjeta', $ref_tarjeta);
                $this->session->set_userdata('ref_comercial', $ref_comercial);

                $this->session->set_userdata('ref_personal1', $ref_personal1);
                $this->session->set_userdata('ref_personal2', $ref_personal2);

                $this->session->set_userdata('ref_familiar1', $ref_familiar1);
                $this->session->set_userdata('ref_familiar2', $ref_familiar2);

                $this->session->set_userdata('paso2', 'ok');

                redirect(base_url() . 'index.php/solicitud/credito_natural/3');

                echo 'total_info_laboral | ' . count($this->session->userdata('info_laboral'));
            } else {
                redirect(base_url() . 'index.php/solicitud/credito_natural/1');
            }
        } elseif ($paso == 3) {
            if ($this->session->userdata('paso1') != 'ok') {

                $data['template'] = 'template/solicitud-natural_1';
            } elseif ($this->session->userdata('paso2') != 'ok') {

                $data['template'] = 'template/solicitud-natural_2';
            } else {


                $tipo_solicitud = $this->input->post('tipo_solicitud');
                //unos pocos Datos del fiador';
                $id_solicitud = $this->session->userdata('id_solicitud');
                $fiador = array(
                    'id_solicitud' => $id_solicitud,
                    'nombre' => $this->input->post('nombre'),
                    'relacion' => $this->input->post('relacion'),
                    'sexo' => $this->input->post('sexo'),
                    'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
                    'nacionalidad' => $this->input->post('nacionalidad'),
                    'estado_familiar' => $this->input->post('estado_familiar'),
                    'dui' => $this->input->post('dui'),
                    'nit' => $this->input->post('nit'),
                    'profesion' => $this->input->post('profesion'),
                    'email' => $this->input->post('email'),
                    'celular' => $this->input->post('celular'),
                    'n_dependientes' => $this->input->post('n_dependientes'),
                    'direccion_particular' => $this->input->post('direccion_particular'),
                    'bo_colonia' => $this->input->post('bo_colonia'),
                    'municipio' => $this->input->post('municipio'),
                    'departamento' => $this->input->post('departamento'),
                    'telefono' => $this->input->post('telefono'),
                    'tipo_vivienda' => $this->input->post('tipo_vivienda'),
                    'pago_mensual' => $this->input->post('pago_mensual'),
                    'tiempo_de_residir' => $this->input->post('tiempo_de_residir')
                );
                $fiador_laboral = array('id_solicitud' => $id_solicitud,
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador',
                    'lugar' => $this->input->post('lab_lugar'),
                    'fecha_ingreso' => $this->input->post('lab_fecha_ingreso'),
                    'direccion' => $this->input->post('lab_direccion'),
                    'cargo' => $this->input->post('lab_cargo'),
                    'jefe_inmediato' => '',
                    'telefono' => $this->input->post('lab_telefono'),
                    'salario' => $this->input->post('lab_salario'),
                    'otros_ingresos' => $this->input->post('lab_otros_ingresos'),
                    'origen_otros_ingresos' => $this->input->post('lab_origen_otros_ingresos'),
                    'gastos' => $this->input->post('lab_gastos'),
                    'anterior' => '',
                    'anterior_tel' => '',
                    'anterior_desde' => '',
                    'anterior_hasta' => '',
                    'anterior_ingresos' => '');


                $fiador_conyuge = array('id' => '',
                    'id_solicitud' => $id_solicitud,
                    'nombre' => $this->input->post('con_nombre'),
                    'lugar_trabajo' => $this->input->post('con_lugar_trabajo'),
                    'cargo' => '',
                    'fecha_ingreso' => $this->input->post('con_fecha_ingreso'),
                    'telefono' => $this->input->post('con_telefono'),
                    'celular' => $this->input->post('con_celular'),
                    'salario' => $this->input->post('con_salario'),
                    'email' => $this->input->post('con_email'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );

                $fiador_vehiculo = array('id' => '',
                    'id_solicitud' => $id_solicitud,
                    'vehiculo_propio' => $this->input->post('vehiculo_propio'),
                    'marca' => $this->input->post('marca'),
                    'modelo' => $this->input->post('modelo'),
                    'year' => $this->input->post('year'),
                    'placa' => $this->input->post('placa'),
                    'financiado' => $this->input->post('financiado'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );

                $fiador_ref_crediq1 = array(
                    'id_solicitud' => $id_solicitud,
                    'crediq' => $this->input->post('ref_crediq1'),
                    'tipo_credito' => $this->input->post('ref_crediq_tipo_credito1'),
                    'monto' => $this->input->post('ref_crediq_monto1'),
                    'referencia' => $this->input->post('1ref_crediq_referencia_n'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );

                $fiador_ref_crediq2 = array(
                    'id_solicitud' => $id_solicitud,
                    'crediq' => $this->input->post('ref_crediq2'),
                    'tipo_credito' => $this->input->post('ref_crediq_tipo_credito2'),
                    'monto' => $this->input->post('ref_crediq_monto2'),
                    'referencia' => $this->input->post('2ref_crediq_referencia_n'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );
                $fiador_ref_financiera = array(
                    'id_solicitud' => $id_solicitud,
                    'financiera' => $this->input->post('ref_financiera'),
                    'otorgamiento' => '',
                    'vencimiento' => '',
                    'monto' => '',
                    'saldo' => '',
                    'cuota' => '',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );


                $fiador_ref_tarjeta1 = array(
                    'id_solicitud' => $id_solicitud,
                    'emisor' => $this->input->post('ref_tarjeta_credito1'),
                    '_2_' => '',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );
                $fiador_ref_tarjeta2 = array(
                    'id_solicitud' => $id_solicitud,
                    'emisor' => $this->input->post('ref_tarjeta_credito2'),
                    '_2_' => '',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );


                $fiador_ref_comercial = array(
                    'id_solicitud' => $id_solicitud,
                    'comercial' => $this->input->post('ref_comercial'),
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador',
                    'n_cuenta' => '',
                    'telefono' => '',
                );
                $fiador_ref_personal = array(
                    'id_solicitud' => $id_solicitud,
                    'personal' => $this->input->post('ref_personal'),
                    'telefono' => $this->input->post('ref_per_telefono'),
                    'celular' => $this->input->post('ref_per_celular'),
                    'direccion' => '',
                    'parentesco' => '',
                    'direccion_trabajo' => '',
                    'tipo_referencia' => 'personal',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador'
                );
                $fiador_ref_familiar = array(
                    'id_solicitud' => $id_solicitud,
                    'personal' => $this->input->post('ref_familiar'),
                    'telefono' => $this->input->post('ref_fam_telefono'),
                    'celular' => $this->input->post('ref_fam_celular'),
                    'direccion' => '',
                    'parentesco' => '',
                    'direccion_trabajo' => '',
                    'tipo_referencia' => 'familiar',
                    'tipo_solicitud' => $tipo_solicitud,
                    'tipo_info' => 'fiador',
                    'telefono_trabajo' => $this->input->post('ref_fam_telefono_tra')
                );


                $this->session->set_userdata('fiador', $fiador);
                $this->session->set_userdata('fiador_laboral', $fiador_laboral);
                $this->session->set_userdata('fiador_conyuge', $fiador_conyuge);
                $this->session->set_userdata('fiador_vehiculo', $fiador_vehiculo);

                $this->session->set_userdata('fiador_ref_crediq1', $fiador_ref_crediq1);
                $this->session->set_userdata('fiador_ref_crediq2', $fiador_ref_crediq2);

                $this->session->set_userdata('fiador_ref_financiera', $fiador_ref_financiera);

                $this->session->set_userdata('fiador_ref_tarjeta1', $fiador_ref_tarjeta1);
                $this->session->set_userdata('fiador_ref_tarjeta2', $fiador_ref_tarjeta2);


                $this->session->set_userdata('fiador_ref_comercial', $fiador_ref_comercial);
                $this->session->set_userdata('fiador_ref_personal', $fiador_ref_personal);
                $this->session->set_userdata('fiador_ref_familiar', $fiador_ref_familiar);

                //echo '<br>ok<br>';
                //guardaMOS Data en respectivos campos
                //guardaMOS Data en respectivos tablas
                //paso 1
                $datos_generales = $this->session->userdata('datos_generales');
                $datos_generales['estado'] = 'pendiente';
                $this->session->set_userdata('datos_generales', $datos_generales);

                $this->Savedata_model->actualizar(array('id_solicitud' => $this->session->userdata('id_solicitud')), 'cq_sol_solicitud', $this->session->userdata('datos_generales'));

                //paso 2
                $this->Savedata_model->guardar('cq_sol_solicitante', $this->session->userdata('solicitante'));
                $this->Savedata_model->guardar('cq_sol_info-laboral', $this->session->userdata('laboral'));
                $this->Savedata_model->guardar('cq_sol_conyuge', $this->session->userdata('conyuge'));
                $this->Savedata_model->guardar('cq_sol_vehiculo', $this->session->userdata('vehiculo'));

                $this->Savedata_model->guardar('cq_sol_referencia_crediq', $this->session->userdata('ref_crediq1'));
                $this->Savedata_model->guardar('cq_sol_referencia_crediq', $this->session->userdata('ref_crediq2'));

                $this->Savedata_model->guardar('cq_sol_referencia_financiera', $this->session->userdata('ref_financiera'));
                $this->Savedata_model->guardar('cq_sol_referencia_tarjeta_credito', $this->session->userdata('ref_tarjeta'));
                $this->Savedata_model->guardar('cq_sol_referencia_comercial', $this->session->userdata('ref_comercial'));

                $this->Savedata_model->guardar('cq_sol_referencia', $this->session->userdata('ref_personal1'));
                $this->Savedata_model->guardar('cq_sol_referencia', $this->session->userdata('ref_personal2'));

                $this->Savedata_model->guardar('cq_sol_referencia', $this->session->userdata('ref_familiar1'));
                $this->Savedata_model->guardar('cq_sol_referencia', $this->session->userdata('ref_familiar2'));

                //paso 3
                $this->Savedata_model->guardar('cq_sol_fiador', $this->session->userdata('fiador'));
                $this->Savedata_model->guardar('cq_sol_info-laboral', $this->session->userdata('fiador_laboral'));
                $this->Savedata_model->guardar('cq_sol_conyuge', $this->session->userdata('fiador_conyuge'));
                $this->Savedata_model->guardar('cq_sol_vehiculo', $this->session->userdata('fiador_vehiculo'));

                $this->Savedata_model->guardar('cq_sol_referencia_crediq', $this->session->userdata('fiador_ref_crediq1'));
                $this->Savedata_model->guardar('cq_sol_referencia_crediq', $this->session->userdata('fiador_ref_crediq2'));

                $this->Savedata_model->guardar('cq_sol_referencia_financiera', $this->session->userdata('fiador_ref_financiera'));

                $this->Savedata_model->guardar('cq_sol_referencia_tarjeta_credito', $this->session->userdata('fiador_ref_tarjeta1'));
                $this->Savedata_model->guardar('cq_sol_referencia_tarjeta_credito', $this->session->userdata('fiador_ref_tarjeta2'));

                $this->Savedata_model->guardar('cq_sol_referencia_comercial', $this->session->userdata('fiador_ref_comercial'));

                $this->Savedata_model->guardar('cq_sol_referencia', $this->session->userdata('fiador_ref_personal'));
                $this->Savedata_model->guardar('cq_sol_referencia', $this->session->userdata('fiador_ref_familiar'));

                //echo '</br>la data se ha guardado</br>';
                //enviamos formulario a info.sv@crediq.com

                $send_Data = array('tipo' => 'solicitud',
                    'to' => 'info.sv@crediq.com',
                    'tipo_solicitud' => 'natural',
                    'datos_generales' => $datos_generales,
                    'solicitante' => $this->session->userdata('solicitante'),
                    'laboral' => $this->session->userdata('laboral'),
                    'conyuge' => $this->session->userdata('conyuge'),
                    'vehiculo' => $this->session->userdata('vehiculo'),
                    'ref_crediq1' => $this->session->userdata('ref_crediq1'),
                    'ref_crediq2' => $this->session->userdata('ref_crediq2'),
                    'ref_financiera' => $this->session->userdata('ref_financiera'),
                    'ref_tarjeta' => $this->session->userdata('ref_tarjeta'),
                    'ref_comercial' => $this->session->userdata('ref_comercial'),
                    'ref_personal1' => $this->session->userdata('ref_personal1'),
                    'ref_personal2' => $this->session->userdata('ref_personal2'),
                    'ref_familiar1' => $this->session->userdata('ref_familiar1'),
                    'ref_familiar2' => $this->session->userdata('ref_familiar2'),
                    'fiador' => $this->session->userdata('fiador'), //datos del fiador
                    'fiador_laboral' => $this->session->userdata('fiador_laboral'),
                    'fiador_conyuge' => $this->session->userdata('fiador_conyuge'),
                    'fiador_vehiculo' => $this->session->userdata('fiador_vehiculo'),
                    'fiador_ref_crediq1' => $this->session->userdata('fiador_ref_crediq1'),
                    'fiador_ref_crediq2' => $this->session->userdata('fiador_ref_crediq2'),
                    'fiador_ref_financiera' => $this->session->userdata('fiador_ref_financiera'),
                    'fiador_ref_tarjeta1' => $this->session->userdata('fiador_ref_tarjeta1'),
                    'fiador_ref_tarjeta2' => $this->session->userdata('fiador_ref_tarjeta2'),
                    'fiador_ref_comercial' => $this->session->userdata('fiador_ref_comercial'),
                    'fiador_ref_personal' => $this->session->userdata('fiador_ref_personal'),
                    'fiador_ref_familiar' => $this->session->userdata('fiador_ref_familiar')
                );

                $this->function_model->enviarMail($send_Data);
                //vaciamos sesiones
                $this->session->set_userdata('id_solicitud', '');


                session_destroy();

                //echo '</br>la data se ha guardado</br>';

                redirect(base_url() . 'index.php/solicitud/saved');
            }
        } else {
            $data['template'] = 'template/solicitud-natural_1';
        }

        //$this->load->view('template/masterpage.php', $data);
    }

    function credito_juridico($paso) {

        $data = $this->general();

        if ($paso == 1) {
            $data['template'] = 'template/solicitud-juridico_1';
        } else
        if ($paso == 2) {
            //if(count($this->session->userdata('paso1'))<1){
            //$data['template'] = 'template/solicitud-nuevos_1';
            //}else{
            $data['template'] = 'template/solicitud-juridico_2';
            //}
        } else
        if ($paso == 3) {
            //if(count($this->session->userdata('paso1'))<1 or count($this->session->userdata('paso2'))<1){
            //$data['template'] = 'template/solicitud-nuevos_1';
            //}else{
            $data['template'] = 'template/solicitud-juridico_3';
            //}
        } else {
            $data['template'] = 'template/solicitud-juridico_1';
        }

        $this->load->view('template/masterpage.php', $data);
    }

    function credito_natural_terceros($paso) {//credito natural terceros y usados
        $data = $this->general();

        if ($paso == 1) {
            $data['template'] = 'template/solicitud-natural-terceros_1';
        } else
        if ($paso == 2) {
            //if(count($this->session->userdata('paso1'))<1){
            //$data['template'] = 'template/solicitud-nuevos_1';
            //}else{
            $data['template'] = 'template/solicitud-natural-terceros_2';
            //}
        } else
        if ($paso == 3) {
            //if(count($this->session->userdata('paso1'))<1 or count($this->session->userdata('paso2'))<1){
            //$data['template'] = 'template/solicitud-nuevos_1';
            //}else{
            $data['template'] = 'template/solicitud-natural-terceros_3';
            //}
        } else {
            $data['template'] = 'template/solicitud-natural-terceros_1';
        }

        $this->load->view('template/masterpage.php', $data);
    }

    function credito_juridico_terceros($paso) {

        $data = $this->general();

        if ($paso == 1) {
            $data['template'] = 'template/solicitud-juridico-terceros_1';
        } else
        if ($paso == 2) {
            //if(count($this->session->userdata('paso1'))<1){
            //$data['template'] = 'template/solicitud-nuevos_1';
            //}else{
            $data['template'] = 'template/solicitud-juridico-terceros_2';
            //}
        } else
        if ($paso == 3) {
            //if(count($this->session->userdata('paso1'))<1 or count($this->session->userdata('paso2'))<1){
            //$data['template'] = 'template/solicitud-nuevos_1';
            //}else{
            $data['template'] = 'template/solicitud-juridico-terceros_3';
            //}
        } else {
            $data['template'] = 'template/solicitud-juridico-terceros_1';
        }

        $this->load->view('template/masterpage.php', $data);
    }

    /*     * *********************************************************************************************************************************************************** */
    /*     * *********************************************************************************************************************************************************** */
    /*     * **************************************************************** Solicitud final ************************************************************************** */
    /*     * *********************************************************************************************************************************************************** */
    /*     * *********************************************************************************************************************************************************** */

    function process_solicitud() {
        $solicitud = array(
            'ingreso' => $this->input->post('ingreso'),
            'comisiones' => $this->input->post('comisiones'),
            'tipo_ingresos' => $this->input->post('tipo_ingresos'),
            'tipo_cotizacion' => $this->input->post('seguro'),
            'lugar_trabajo' => $this->input->post('trabajo') . $this->input->post('j_trabajo'),
            'direccion_trabajo' => $this->input->post('direccion_trabajo'),
            'fecha_ingreso' => (is_numeric($this->input->post('asa_year')) ? $this->input->post('asa_year') . '-' : "") .
            (is_numeric($this->input->post('asa_mes')) ? $this->input->post('asa_mes') . '-' : "") .
            (is_numeric($this->input->post('asa_dia')) ? $this->input->post('asa_dia') . '-' : "") .
            (is_numeric($this->input->post('pro_year')) ? $this->input->post('pro_year') . '-' : "") .
            (is_numeric($this->input->post('pro_mes')) ? $this->input->post('pro_mes') . '-' : "") .
            (is_numeric($this->input->post('pro_dia')) ? $this->input->post('pro_dia') : ""),
            'egresos' => $this->input->post('egresos'),
            'cargo' => $this->input->post('cargo'),
            'telefono_trabajo' => $this->input->post('telefono_tra'),
            'tipo_profesion' => $this->input->post('profesion'),
            'fecha_jubilacion' => $this->input->post('j_year') . '-' . $this->input->post('j_mes') . '-' . $this->input->post('j_dia'),
            'destino' => $this->input->post('destino'),
            'valor_vehiculo' => $this->input->post('valor_v'),
            'prima_minima' => $this->input->post('prima_min'),
            'valor_financiar' => $this->input->post('valor_financiar'),
            'marca' => $this->input->post('marca'),
            'modelo' => $this->input->post('modelo'),
            'tipo_vehiculo' => $this->input->post('tipo_vehiculo'),
            'year' => $this->input->post('year'),
            'plazos' => $this->input->post('plazos'),
            'estado' => "en proceso",
        );

        $this_id = $this->Savedata_model->guardar('cq_solicitud', $solicitud);
        //informacion del cliente
        $clientes = array(
            'id_solicitud' => $this_id,
            'nombres' => $this->input->post('cli_nombres'),
            'apellidos' => $this->input->post('cli_apellidos'),
            'email' => $this->input->post('cli_email'),
            'nacionalidad' => $this->input->post('pais'),
            'documento' => $this->input->post('documento'),
            'numero' => $this->input->post('n_doc'),
            'nit' => $this->input->post('nit'),
            'fecha_nacimiento' => $this->input->post('nac_year') . "-" . $this->input->post('nac_mes') . "-" . $this->input->post('nac_dia'),
            'telefono_fijo' => $this->input->post('tel_fijo'),
            'celular' => $this->input->post('tel_celular'),
            'estado_civil' => $this->input->post('estado_civil'),
            'dependientes' => $this->input->post('dependientes'),
            'tipo_domicilio' => $this->input->post('tipo_domicilio'),
            'antiguedad_domicilio' => $this->input->post('dom_mes') . $this->input->post('dom_year'),
            'ciudad' => $this->input->post('ciudad'),
            'departamento' => $this->input->post('departamento'),
            'contactado_a' => $this->input->post('contactar')
        );
        $this->Savedata_model->guardar('cq_solicitud_cliente', $clientes);
        //referidos
        $referidos = array(
            'id_solicitud' => $this_id,
            'nombres' => $this->input->post('ref_nombres'),
            'apellidos' => $this->input->post('ref_apellidos'),
            'telefono_casa' => $this->input->post('ref_telefono_casa'),
            'telefono_trabajo' => $this->input->post('ref_telefono_trabajo'),
            'celular' => $this->input->post('ref_celular'),
            'comentarios' => $this->input->post('comentarios')
        );
        $this->Savedata_model->guardar('cq_solicitud_ref', $referidos);

        $this->session->set_userdata('this_id', $this_id);

        redirect(base_url() . 'index.php/site/aviso/29');
    }

    function guardar_sol_credito() {
        $now = date("Y-m-d H:i:s");
        $usuario = $this->session->userdata('user_email');

        if($usuario==null || $usuario==0 || $usuario== ''){
            $usuario ='anonimo';
        }
         /*MODIFICADO POR GGONZALEZ - 22/05/2015 - INI*/
        $clientes = array(
            'nombre_cliente' => $this->input->post('cli_nombre'),
            'email' => $this->input->post('cli_email'),
            'pais' => $this->input->post('pais'),
            'dui' => $this->input->post('cli_dui'),
            'monto_max' => $this->input->post('cli_monto_max'),
            'cuota_max' => $this->input->post('cli_cuota_max'),
            'telefono_fijo' => $this->input->post('cli_telefono_fijo'),
            'telefono_celular' => $this->input->post('cli_telefono_celular'),
            'telefono_oficina' => $this->input->post('cli_telefono_oficina'),
            'fecha_adicion' =>  $now,
            'comentario' => $this->input->post('cli_comentarios'),
            'ref_por' => $this->input->post('cli_ref_por'),
            'dui_ref_por' => $this->input->post('cli_dui_ref_por'),
            'telefono_fijo_ref_por' => $this->input->post('cli_telefono_fijo_ref_por'),
            'email_ref_por' => $this->input->post('cli_email_ref_por'),
            'usuario_adicion' => $usuario
        );
         /*MODIFICADO POR GGONZALEZ - 22/05/2015 - FIN*/
        $this_id = $this->Savedata_model->guardar('cq_solicitudes_creditos', $clientes);

        // Enviar Correo de notificacion a ejecutivos.



        $this->session->set_userdata('this_id', $this_id);
        redirect(base_url() . 'index.php/site/aviso/29');

    }


    function guardar_sol_vehiculo() {

        $usuario = $this->session->userdata('user_email');

        if($usuario==null || $usuario==0 || $usuario== ''){
            $usuario ='anonimo';
        }

          /*MODIFICADO POR GGONZALEZ - 22/05/2015 - INI*/
        $now = date("Y-m-d H:i:s");
        $nombre = $this->input->post('cli_nombre');
        $dui = $this->input->post('cli_dui');
        $lIdentificacion = $nombre.' '.$dui;
        $clientes = array(
            'nombre_cliente' => $lIdentificacion,
            'email' => $this->input->post('cli_email'),
            'pais'=> $this->input->post('pais'),
            'telefono_fijo' => $this->input->post('cli_telefono_fijo'),
            'telefono_celular' => $this->input->post('cli_telefono_celular'),
            'telefono_oficina' => $this->input->post('cli_telefono_oficina'),
            'fecha_adicion' =>  $now,
            'tipo_vehiculo' => $this->input->post('cli_tipo_vehiculo'),
            'marca' => $this->input->post('cli_marcas'),
            'anio_desde' => $this->input->post('cli_anio_desde'),
            'anio_hasta' => $this->input->post('cli_anio_hasta'),
            'precio_desde' => $this->input->post('cli_precio_desde'),
            'precio_hasta' => $this->input->post('cli_precio_hasta'),
            'procedencia_importado' => $this->input->post('cli_procedencia_importado'),
            'procedencia_agencia' => $this->input->post('cli_procedencia_agencia'),
            'comentario' => $this->input->post('cli_comentarios'),
            'usuario_adicion' => $usuario

        );

          /*MODIFICADO POR GGONZALEZ - 22/05/2015 - FIN*/
        $this_id = $this->Savedata_model->guardar('cq_solicitudes_vehiculos', $clientes);
        // Enviar Correo de notificacion a ejecutivos.
        $this->session->set_userdata('this_id', $this_id);

            $lbutton = "Solicitud Vehiculo";
        try {
                      $url = "https://script.google.com/macros/s/AKfycbyC-NQ7N4kT58YGS219ZbyLrKr907u9zLwJpMiDdG_odAKBvIMg/exec";

                      switch ($clientes['tipo_vehiculo']) {
                                      case 1:
                                          $lAutoSelected = "AUTOMÓVIL";

                                          break;
                                      case 9:
                                          $lAutoSelected = "PICK UP";

                                          break;
                                      case 10:
                                          $lAutoSelected = "SUV";

                                          break;
                                      case 11:
                                          $lAutoSelected = "OTROS";

                                          break;
                                      default:
                                          $lAutoSelected = 'Invalid car';
                      }

                      $params = array('vendedor' => "Solicitud de vehículo",
                                  'boton' => $lbutton,
                                  'name' => $nombre,
                                  'dui' => $dui,
                                  'email' => $clientes['email'],
                                  'phone' => $clientes['telefono_celular'],
                                  'automovil' => $lAutoSelected,
                                  'channel' => "web");

                      $query = http_build_query($params);
                      $ch    = curl_init();
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_HEADER, false);
                      curl_setopt($ch, CURLOPT_URL, $url);
                      curl_setopt($ch, CURLOPT_POST, true);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                      $response = curl_exec($ch);
                      curl_close($ch);
                      //interaccionSolicitudVehiculo
                      self::interaccionSolicitudVehiculo($clientes['email'], $nombre, $clientes['telefono_celular'],  $clientes['telefono_fijo'] , $clientes['pais'], $clientes['precio_desde']);
                      //redireccionamos al aviso
                       redirect(base_url().'index.php/site/aviso/37');

        } catch (Exception $e) {
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }

    }

    //consentimiento solicitud vehiculo
      function interaccionSolicitudVehiculo($email, $nombre, $telefonoMovil,  $telefonoFijo , $pais, $precio) {
        //obtenemos fecha, hora y microsegundos

        $datetime = new DateTime();
        $date = $datetime->format(DateTime::ATOM);


        //obtenemos el area marketing
        //select valor from cq_par_parametros where codigo = 'AREA_MARKETING';
          $this->db->select('valor');
          $this->db->from('cq_par_parametros');
          $this->db->where('codigo', 'AREA_MARKETING');
          $consulta = $this->db->get();
          $resultado = $consulta->result();
          $Area_Marketing = NULL;

            foreach ($resultado as $row)
              {
                  $Area_Marketing = $row->valor;
              }
        //obtenemos el Pais

        $this->db->select('codigo');
        $this->db->from('cq_pais');
        $this->db->where('id_pais', $pais);
        $consulta = $this->db->get();

        foreach ($consulta->result() as $row)
        {
            $codigo  = strtoupper($row->codigo);
        }

		//Autorizacion de credenciales

        $curl = curl_init();
        // $username = "b42866a9-56d4-3d8d-920d-0dcd8c38f4f6";
        // $password = "WXi4nWzJCIYq1oKNbQ#8fr7Vvh";
        $username = "8893b4ba-0a06-3af6-b109-0757138987a4";
        $password = "x&q1E!l9mN6c26!wltzQ40jq2&1H";
  	    curl_setopt_array($curl, array(
          // CURLOPT_URL => "https://oauthasservices-d48d16b03.us2.hana.ondemand.com/oauth2/api/v1/token?grant_type=client_credentials",
		  CURLOPT_URL => "https://oauthasservices-dd1d83ab9.us2.hana.ondemand.com/oauth2/api/v1/token?grant_type=client_credentials",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
          CURLOPT_USERPWD => $username . ":" . $password
        ));

        $result = json_decode(curl_exec($curl));

        curl_close($curl);
        $token = $result->{'access_token'};

        //echo "<script> console.log('TOKEN: ".$token."'); </script>";

          
		  $timestamp = gmdate("Y-m-d\TH:i:s") . ".547";
		  
		  //Autorizacion de token
          $curl = curl_init();
          $json = array(
            "WebsiteName" => "UsadosCrediQ - " . $codigo,
            "ContactID" => $email,
            "ContactOrigin" => "WEBCQ",
            "ContactOriginData" => array(
                "OriginDataLastChgUTCDateTime" => $timestamp,
                "CityName" => "",
                "Country" => $codigo,
                "EmailAddress" => $email,
                "FirstName" => "",
                "LastName" => "",
                "FullName" => $nombre,
                "GenderCode" => "",
                "AddressHouseNumber" => "",
                "IsConsumer" => true,
                "IsContactPerson" => false,
                "Language" => "ES",
                "MaritalStatus" => "",
                "MaritalStatusName" => "",
                "MobileNumber" => $telefonoMovil,
                "IsObsolete" => false,
                "PhoneNumber" => $telefonoFijo,
                "ContactPostalCode" => "",
                "AddressRegion" => "",
                "StreetName" => ""
            ),
            "MarketingPermissions" => array(
                    "MarketingPermission" => [
                    array(
                        "ContactPermissionID" =>  $email,
                        "ContactPermissionOrigin" => "EMAIL",
                        "MarketingArea" => $Area_Marketing,
                        "CommunicationMedium" => "WEB",
                        "CommunicationCategory" => "",
                        "ContactPermission" => "Y",
                        "PermissionUTCDateTime" => $timestamp,
                        "CommunicationDirection" => null,
                        "PermissionSourceObject" => null,
                        "PermissionSourceObjectType" => null,
                        "PermissionSourceSystem" => null,
                        "PermissionSourceSystemType" => null,
                        "PermissionSourceDataURL" => null,
                        "PermissionSourceCommMedium" => "WEB",
                        "IsConfirmationRequired" => false
                    )
                ]
            )
        );

        //echo "<script> console.log('** MENSAJE CONSENT:".json_encode($json)."'); </script>";

		
		$request_headers=array(
			'Content-type: application/json',
			'x-csrf-token: ' . $token,
			'Authorization: Bearer '.$token
		);

		  curl_setopt_array($curl, array(
			// CURLOPT_URL => "https://e5728-iflmap.hcisbt.us2.hana.ondemand.com/http/Web/MKT/Contact",
			CURLOPT_URL => "https://l5961-iflmap.hcisbp.us2.hana.ondemand.com/http/Web/MKT/Contact",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST=>true,
			CURLOPT_POSTFIELDS => json_encode($json),
			CURLOPT_HTTPHEADER=> $request_headers,
			CURLOPT_XOAUTH2_BEARER=>$token,
			CURLOPT_HEADER=>false
			)
		  );		

          $response = curl_exec($curl);
          curl_close($curl);

        //echo "<script> console.log('** RESP CONSENT:".$response."'); </script>";
		  
		  
		  $timestamp = gmdate("Y-m-d\TH:i:s") . ".123";
          //Trama interaccion
          $tramaInteraccion =
          '{
                          "InteractionContactOrigin": "WEBCQ",
                          "InteractionContactId": "'.$email.'",
                          "CommunicationMedium": "WEB",
                          "InteractionType": "COTIZACION",
                          "InteractionTimeStampUTC": "'.$timestamp.'",
                          "InteractionSourceObjectType": "WEBCQ",
                          "InteractionSourceObject": "WEBCQ",
                          "MarketingArea": "'.$Area_Marketing.'",
                          "CampaignID": "",
                          "MarketingLocationOrigin": "",
                          "MarketingLocation": "",
                          "DigitalAccountType": "",
                          "DigitalAccount": "",
                          "MKT_AgreementOrigin": "",
                          "MKT_AgreementExternalID": "",
                          "CampaignContent": null,
                          "InteractionWeightingFactor": null,
                          "InteractionSentimentValue": null,
                          "InteractionStatus": "",
                          "InteractionReason": "",
                          "InteractionLanguage": "ES",
                          "InteractionAmount": "",
                          "InteractionCurrency": "USD",
                          "InteractionLatitude": "",
                          "InteractionLongitude": "",
                          "SpatialReferenceSystem": "",
                          "DeviceType": "DESKTOP",
                          "InteractionDeviceName": "",
                          "SourceSystemType": "WEBCQ",
                          "SourceSystem": "WEBCQ",
                          "InteractionSourceObjectAddlID": "",
                          "InteractionSourceObjectStatus": "",
                          "InteractionSourceDataURL": "'.current_url().'",
                          "InteractionSourceTimeStampUTC": "'. $timestamp .'",
                          "CampaignContentLinkURL": "",
                          "CampaignContentLinkName": "",
                          "ReferralSource": "",
                          "ReferralSourceCategory": "",
                          "InteractionContentSubject": "",
                          "InteractionContent": "",
                          "InteractionProducts": {
                                  "InteractionProduct": [{
                                             "ProductOrigin": "EXTERNAL_01",
                                             "Product": "CQ_PRODUCTO_FINANCIERO",
                                             "InteractionProdWeightingFactor": "1",
                                             "InteractionProductSentimentVal": "1",
                                             "InteractionProductAmount": "'.$precio.'",
                                             "InteractionProductQuantity": "1",
                                             "InteractionProductUnit": "ST",
                                             "ProductRecommendationModelType": "",
                                             "ProductRecommendationScenario": null,
                                             "InteractionProductStatus": "",
                                             "InteractionProductReason": "",
                                             "InteractionSourceItemNumber": null
                                      }]
                          }
                      }';

       
					  
					  
          $request_headers=array(
            'Content-type: application/json',
            'Content-Length: '.strlen($tramaInteraccion),
            'InteractionType: Interactions',
            'Authorization: Bearer '.$token
          );

          $curl=curl_init();
          // $api_url='https://e5728-iflmap.hcisbt.us2.hana.ondemand.com/http/Web/MKT/Interactions';
		  $api_url='https://l5961-iflmap.hcisbp.us2.hana.ondemand.com/http/Web/MKT/Interactions';

          curl_setopt_array(
          $curl,
            array(

                CURLOPT_URL => $api_url,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER =>true,
                CURLOPT_POSTFIELDS => $tramaInteraccion,
                CURLOPT_HTTPHEADER => $request_headers,
                CURLOPT_XOAUTH2_BEARER=> $token,
                CURLOPT_HEADER=>false
            )
          );

          $res=curl_exec($curl);
          curl_close($curl);
          session_start();

        //echo "<script> console.log('** RESP INTERAC:".$res."') </script>";

          $_SESSION['data'] = $res;
          $_SESSION['res'] = $response;

        }

}
