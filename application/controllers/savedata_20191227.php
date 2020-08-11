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
    }

    function index() {
        redirect(base_url());
    }

    function general() {
        $home = $_SERVER['DOCUMENT_ROOT'] . '/';
        return $home;
    }

    function savecar($action) {

        $contador = 0;

        foreach($_FILES as $value){
            $tipo_archivo = $value['type'];
            if($tipo_archivo != '.jpg'){
                $contador ++;
            }
        }


        $home = $this->general();

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

        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $year = $this->input->post('year');
        $tipo_venta = $this->input->post('tipo_venta');
        $bid_available_until = $this->input->post('bid_available_until');
        $tipo_combus = $this->input->post('tipo_combus');
        $cap_motor = $this->input->post('cap_motor');
        $tipo_vehiculo = $this->input->post('tipo_vehiculo');
        $transmision = $this->input->post('transmision');
        $traccion = $this->input->post('traccion');
        $color_in = $this->input->post('color_in');
        $color_out = $this->input->post('color_out');
        $num_puertas = $this->input->post('num_puertas');
        $num_asientos = $this->input->post('num_asientos');
        $tipo_ingreso = $this->input->post('tipo_ingreso');
        $descripcion = htmlentities($this->input->post('descripcion'));
        $precio = $this->input->post('precio');
        $negociable = $this->input->post('negociable');
		$certificado = $this->input->post('certificado');
		$recomendado = $this->input->post('recomendado');
        $num_placa = $this->input->post('num_placa');
        $kilometraje = $this->input->post('kilometraje');
        $condiciones = $this->input->post('condiciones');
        $departamento = $this->input->post('departamento');
        $precio_extranjero = $this->input->post('cantidad') . " " . $this->input->post('moneda');
        $data_adicional = htmlentities($this->input->post('data_adicional'));
        $moneda_venta = $this->input->post('moneda_venta');
        $fecha_sub = date('Y-m-d');
        $ext_name = $this->input->post('ext_nombre');
        $ext_email = $this->input->post('ext_email');
        $ext_tel1 = $this->input->post('ext_tel1');
        $ext_tel2 = $this->input->post('ext_tel2');
		$ext_visible = $this->input->post('ext_visible');
         /*INI - Modificado por: GGONZALEZ - 30/08/2016 */
        $ubicacion = $this->input->post('ubicacion');
        /*FIN - Modificado por: GGONZALEZ - 30/08/2016 */
		
		if($ext_visible==""){
			$ext_visible="No";
		}

        $mail = $this->session->userdata('user_email');
        $valida = FALSE;

        if ($ext_email != "") {

            if (ereg("^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@+([_a-zA-Z0-9-]+.)*[a-zA-Z0-9-]{2,200}.[a-zA-Z]{2,6}$", $ext_email)) {
                $valida = TRUE;
            }
        }

        if ($valida == FALSE) {
            $ext_email = $mail;
        }

        if ($action == 'guardar') {
            $maxid = $this->data_model->maxid();
            $maxid = $maxid['max_id'] + 1;
            $car_id = $this->savedata_model->guardar('cq_ids', array('id_automovil' => $maxid));
            $car_id = $this->session->userdata('user_id') . $car_id;
        } else {
            $car_id = ''; //para que no de variable indefinida
        }

        $datos = array(
            'id_automovil' => $car_id,
            'marca' => $marca,
            'modelo' => $modelo,
            'year' => $year,
            'tipo_combustible' => $tipo_combus,
            'capacidad_de_motor' => $cap_motor,
            'tipo_venta' => $tipo_venta,
            'bid_available_until' => $bid_available_until ?: null,
            'tipo_vehiculo' => $tipo_vehiculo,
            'tipo_transmision' => $transmision,
            'traccion' => $traccion,
            'color_interno' => $color_in,
            'color_externo' => $color_out,
            'numero_puertas' => $num_puertas,
            'numero_asientos' => $num_asientos,
            'tipo_ingreso' => $tipo_ingreso,
            'pais' => $this->session->userdata('user_pais'),
            'estado' => 'Aprobado',
            'certificado' => $certificado,
            'usuario' => $this->session->userdata('user_id'),
            'precio' => $precio,
            'negociable' => $negociable,
            'numero_de_placa' => $num_placa,
            'kilometraje' => $kilometraje,
            'descripcion' => $descripcion,
            'financiamiento' => "0",
            'condiciones' => $condiciones,
            'departamento' => $departamento,
            'precio_extranjero' => $precio_extranjero,
            'data_adicional' => $data_adicional,
            'moneda' => $moneda_venta,
            'fecha' => $fecha_sub,
            'ext_nombre' => $ext_name,
            'ext_email' => $ext_email,
            'ext_tel1' => $ext_tel1,
            'ext_tel2' => $ext_tel2,
			'ext_visible' => $ext_visible,
            'ubicacion' => $ubicacion,
            'lote' => 0,
			'recomendado' => $recomendado /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
        );
        // OBTENEMOS EL ID DEL CARRO QUE ACABAMOS DE CREAR
        //
		//print_r($datos);
		

        if ($action == 'update') {
            unset($datos['id_automovil']);
            unset($datos['estado']);
          //  unset($datos['certificado']);
            unset($datos['financiamiento']);
           // unset($datos['recomendados']);
            unset($datos['usuario']);
            unset($datos['pais']);

            $car_id = $this->input->post('id_auto');
            $where = array('id_automovil' => $car_id);
            $this->savedata_model->actualizar($where, 'cq_automovil', $datos);

        } elseif ($action == 'guardar') {
            $this->savedata_model->guardar('cq_automovil', $datos); //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        }



        $tipo_foto = array();
        $tipo_foto[1] = 'FRONTAL';
        $tipo_foto[2] = 'TRASERA';
        $tipo_foto[3] = 'LATERAL';
        $tipo_foto[4] = 'INTERIOR';



        $total_imgs = count($this->data_model->total_Imgs($car_id));

        //echo '<br />total ikmga='.$total_imgs;
        $v=1;
        foreach($_FILES as $value){
            $nombre_archivo = $value['name'];
            $nombre_tmp = $value['tmp_name'];
            $tipo_archivo = $value['type'];
            $tamano_archivo = $value['size'];
            
            if ($nombre_archivo != '') {
             if($nombre_archivo!='' && isset($nombre_archivo)) {
              if(is_uploaded_file($nombre_tmp)) {
            
               $extension = strtolower(strrchr($nombre_archivo,'.'));
               
               $nombre_archivo = $car_id . '-0000' . $v . '-' . $tipo_foto[$v] . $extension;
               $ruta = FCPATH . 'imagenes/original/' . $nombre_archivo;
               $arch_doc = $nombre_tmp;
            
               if(move_uploaded_file($arch_doc, $ruta)) {
                unset($value['archivo']);
                //$nombre_archivo = $nombre_arch;
               }
              }
             }
            }
            $v++;
        }

        for ($v = 1; $v <= 4; $v++) {



            //if ($this->session->userdata('imagen' . $v) != "") {

                //$imgContent= read_file($home.'public/img_autos_temp/'.$this->session->userdata('imagen'.$v));

                $archivo = FCPATH . 'public/img_autos_temp/' . $car_id . $v;

                
                $mime = getimagesize($archivo);

                $datos = array(
                    'codigo_vehiculo' => $car_id,
                    'codigo_tipo_foto' => '0000' . $v,
                    'desc_tipo_foto' => $tipo_foto[$v],
                    'imagen' => '',
                    'header' => isset($mime['mime']) ? $mime['mime'] : 'Content-Type: image/jpeg',
                    'imagen_file' => NULL
                );

                $imagen_path = $this->imageuploader->getCarImageFilename($datos);
                $datos['imagen_path'] = $imagen_path;
                

                //chmod($home.'public/img_autos_temp/'.$this->session->userdata('imagen'.$v),'777');
                //unlink($home.'public/img_autos_temp/'.$this->session->userdata('imagen'.$v));
                //if($action=='update'){
                //if($total_imgs == 0){//gurdamo las nuevas imagenes
                //$this->savedata_model->save_image($datos);
                //}elseif($total_imgs > 0){

                $total_imgs_tipo = count($this->data_model->total_Imgs_tipo($car_id, $tipo_foto[$v]));

                if ($total_imgs_tipo == 0) {
                    $this->savedata_model->save_image($datos);
                } elseif ($total_imgs_tipo > 0) {
                    $this->savedata_model->update_image($datos, array(
                        'codigo_vehiculo' => $car_id,
                        'desc_tipo_foto' => $tipo_foto[$v]
                    ));
                }

                $moved = rename($archivo, FCPATH . "imagenes/original/{$imagen_path}");

                $this->imageuploader
                    ->doCarResizedImage($datos, 800, 600, null, true);
                $this->imageuploader
                    ->doCarResizedImage($datos, 99, 77, null, true);
                $this->imageuploader
                    ->doCarResizedImage($datos, 60, 40, null, true);
                $this->imageuploader
                    ->doCarResizedImage($datos, 204, 137, null, true);

                //}
                //}elseif($action=='guardar'){
                //$this->savedata_model->save_image($datos);
                //}

                $this->session->set_userdata('imagen' . $v, "");

                //echo '<br />imagen='.$this->session->userdata('imagen'.$v).'<br />';
                //,
            //}
        }

        //echo "echo i = ".$i;
        //Guardamos el quit del equipamiento
        if ($action == 'update') {
            //borramos todos los equipamientos con el id del auto
            $this->savedata_model->delEquipo($car_id);
        }
		$totEquipamiento=0;
		$totEquipamiento=$this->data_model->total_equipamientos();
		//$totEquipamiento

        for ($i = 1; $i <= $totEquipamiento["total"]; $i++) {//Guardamos equipamiento
            if ($this->input->post($i) and $this->input->post($i) != "") {
                $datos_eq = array(
                    'id_auto' => $car_id,
                    'id_eq' => $this->input->post($i)
                );

                $this->savedata_model->guardar('cq_auto_x_equipamiento', $datos_eq); //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            }
        }

        $dat = array('tipo' => 'revision',
            'to' => $mail,
			'cc' => 'usados.sv@crediq.com'
		);

        if ($action == 'update') {
            //aqui actualizamos
            $tipo_edit = $this->input->post('edit_user_car');
            if ($tipo_edit == 'user') {

                redirect(base_url() . 'index.php/car/datos/modificar/' . $car_id);
            } else {

                redirect(base_url() . 'index.php/car/administrar/modificar/' . $car_id);
            }
        } else {
            $this->function_model->enviarMail($dat); //enviamos notificacion("su vehiculo sera sometido a revision")>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            //redirect(base_url() . 'index.php/user/acount');
			redirect(base_url() . 'index.php/car/estado/userPendiente');
			
            //echo '<br>home  =  '.$home.'<br>'; 
        }


        //
    }

    function saveUser() {//del formulario de registro del site

        //datos desde el formulario
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $email = $this->input->post('email');
       // $marca_favorita = $this->input->post('marca_favorita');
      //  $modelo_favorito = $this->input->post('modelo');
      //  $profesion = $this->input->post('profesion');
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

    function updateUser() {
        //comprobacion de usuario
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1, 2))) {
            redirect(base_url());
        } else {
            //datos desde el formulario
            $nombres = $this->input->post('nombres');
            $apellidos = $this->input->post('apellidos');
            $email = $this->input->post('email');

            if ($this->input->post('profesion')) {

                $id_user = $this->input->post('id_usuario');

                if ($this->Secure_model->checkEmail($email) and $email != $this->input->post('email_actual')) {
                    redirect(base_url() . 'index.php/user/modificar/' . $id_user);
                }



                $profesion = $this->input->post('profesion');
                $marca_favorita = $this->input->post('marca_favorita');
                $modelo_favorito = $this->input->post('modelo_favorito');
                $pais = $this->input->post('pais');
                $tipo_usuario = $this->input->post('tipo_usuario');
                $estado = $this->input->post('estado');


                $datos = array(
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'marca_favorita' => $marca_favorita,
                    'modelo_favorito' => $modelo_favorito,
                    'profesion' => $profesion,
                    'pais' => $pais,
                    'tipo_usuario' => $tipo_usuario,
                    'estado' => $estado
                );
                $this->savedata_model->updateData('id_usuario', $id_user, 'cq_usuario', $datos);
                $tipo_redirect = 'index.php/user/modificar/' . $id_user;
            } else {
                $tipo_redirect = 'index.php/site/aviso/4';
                if ($this->Secure_model->checkEmail($email) and $email != $this->session->userdata('user_email')) {
                    redirect(base_url() . 'index.php/site/aviso/2');
                }
                $datos = array(
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'email' => $email);
                $this->savedata_model->updateData('id_usuario', $this->session->userdata('user_id'), 'cq_usuario', $datos);
                $id_user = $this->session->userdata('user_id');
            }

            //guardamos en base los datos de usuario
            //Guardamos en base los datos de telefonos
            for ($i = 1; $i <= 4; $i++) {

                if ($this->input->post('telefono' . $i)) {//si existe
                    $telefono = $this->input->post('telefono' . $i);


                    if ($telefono != "") { // y viene diferente de vacia (hacemos un update o insert)
                        if ($this->input->post('id_' . $i)) {//si el hidden que trae el id_telefono existe se hara un update en la tabla de telefonos
                            $id_telefono = $this->input->post('id_' . $i);
                            //$this->savedata_model->ModTelefono($id_telefono,$id_user,$telefono);

                            $datos_tel = array(
                                'telefono' => $telefono
                            );

                            $this->savedata_model->updateData('id_telefono', $id_telefono, 'cq_telefonos', $datos_tel);
                        } else {//si no viene hidden se hara un insert en la tabla de telefonos
                            $dato_tel = array(
                                'id_telefono' => '',
                                'id_usuario' => $id_user,
                                'telefono' => $telefono
                            );

                            $this->savedata_model->guardar('cq_telefonos', $dato_tel);
                        }
                    }
                } else {//si no hacemos un delete de este
                    if ($this->input->post('id_' . $i) != "") {//si el hidden que trae el id_telefono
                        $id_telefono = $this->input->post('id_' . $i);
                        $this->savedata_model->delTelefono($id_telefono, $id_user); //borramos de la bse el este
                    }
                }
            }//fin for

            $split = explode(' ', $nombres);
            $user_name = $split[0];
            $split = explode(' ', $apellidos);
            $user_name .= ' ' . $split[0];

            $data = array(
                'user_name' => $user_name,
                'user_email' => $email,
                'user_nombres' => $nombres,
                'user_apellidos' => $apellidos,
            );
            $this->session->set_userdata($data);


            redirect(base_url() . $tipo_redirect);
        }
//
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

    function crearUser() {//del panel de super administrador
        //comprobacion de usuario
        if (!$this->session->userdata('user_id') and !in_array($this->session->userdata('user_perfil'), array(1))) {
            redirect(base_url());
        } else {
            //datos desde el formulario
            $nombres = $this->input->post('nombres');
            $apellidos = $this->input->post('apellidos');
            $email = $this->input->post('email');

            if ($this->Secure_model->checkEmail($email)) {
                redirect(base_url() . 'index.php/user/crear');
            }

            $profesion = $this->input->post('profesion');
            $marca_favorita = $this->input->post('marca_favorita');
            $modelo_favorito = $this->input->post('modelo');
            $pais = $this->input->post('pais');
            $pass = $this->input->post('pass1');
            $tipo_usuario = $this->input->post('tipo_usuario');
            $estado = $this->input->post('estado');

            $datos = array(
                'id_usuario' => '',
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'email' => $email,
                'marca_favorita' => $marca_favorita,
                'modelo_favorito' => $modelo_favorito,
                'profesion' => $profesion,
                'pais' => $pais,
                'clave' => md5($pass),
                'tipo_usuario' => $tipo_usuario,
                'estado' => $estado
            );
            $last_id = $this->savedata_model->Guardar('cq_usuario', $datos);

            //Guardamos en base los datos de telefonos
            for ($i = 1; $i <= 3; $i++) {


                if ($this->input->post('telefono' . $i)) {
                    $dato_tel = array(
                        'id_telefono' => '',
                        'id_usuario' => $last_id,
                        'telefono' => $this->input->post('telefono' . $i)
                    );

                    $this->savedata_model->guardar('cq_telefonos', $dato_tel);
                }
            }//


            redirect(base_url() . 'index.php/site/aviso/16');
        }
//
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

//fin controlador =(

    function updateAdvert($id) {
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
                'nombre' => $nombre,
                'posicion' => $posicion,
                'estado' => $estado,
                'fecha_publicacion' => $inicio,
                'fecha_expiracion' => $fin,
                'modificado_por' => $this->session->userdata('user_id'),
                'link' => $link,
                'seccion' => $seccion,
                'tipo' => $tipo
            );

            $this->savedata_model->Actualizar(array('id_banner' => $id), 'cq_banner', $datos);

            //actualizamos imagenes
            $nombre_img = $this->input->post('nombre_img');



            for ($k = 0; $k < count($nombre_img); $k++) {
                $this->data_model->updateImgBanner($nombre_img[$k], ($k + 1), $id);
            }
            for ($i = 1; $i <= 4; $i++) {//son cuatro y las buscamos con un for
                if ($_FILES["archivo" . $i]['name'] != "") {

                    //seleccionamos imagen de la base de este orden $i

                    $este_nombre = $this->data_model->getDataWhere(array('id_banner' => $id, 'orden' => $i), 'cq_imagen_x_banner');

                    //echo 'echo imagen actual= ' .$este_nombre[0]['imagen'];
                    $vector = substr(md5($id), 0, 8) . '-' . $_FILES["archivo" . $i]['name'];

                    $destino_vector = $home . 'public/banners/' . $vector;

                    if (move_uploaded_file($_FILES["archivo" . $i]['tmp_name'], $destino_vector)) {
                        echo '<br />ok<br />';
                    } else {
                        echo '<br />fallo<br />';
                    }
                    //borramos actual si son diferentes esto evitara imagenes huerfanas
                    if (count($este_nombre) > 0) {
                        if ($este_nombre['imagen'] != $vector) {
                            chmod($home . 'public/banners/' . $este_nombre[0]['imagen'], 777);
                            unlink($home . 'public/banners/' . $este_nombre[0]['imagen']);
                        }
                    }
                    $datos_img_banner = array(
                        'imagen' => $vector
                    );

                    $img_where = array(
                        'id_banner' => $id,
                        'orden' => $i
                    );

                    $this->savedata_model->Actualizar($img_where, 'cq_imagen_x_banner', $datos_img_banner);
                }
            }

            //echo '<br />guaerdado<br />';
            redirect(base_url() . 'index.php/site/aviso/17');
        }//fin if user
    }

//fin controlador =(

    function marcar($id) {

        $this->savedata_model->Actualizar(array('id_automovil' => $id), 'cq_automovil', array('certificado' => '1'));
        redirect(base_url() . 'index.php/car/estado/aprobado-admin');

        //
    }

    function desmarcar($id) {

        $this->savedata_model->Actualizar(array('id_automovil' => $id), 'cq_automovil', array('certificado' => '0'));
        redirect(base_url() . 'index.php/car/estado/aprobado-admin');
        //
    }

   /*INI INI - Modificado por: GGONZALEZ - 25/01/2015 */
     function marcar_rec($id) {

        $this->savedata_model->Actualizar(array('id_automovil' => $id), 'cq_automovil', array('recomendado' => '1'));
        redirect(base_url() . 'index.php/car/estado/aprobado-admin');


    }

    function desmarcar_rec($id) {

        $this->savedata_model->Actualizar(array('id_automovil' => $id), 'cq_automovil', array('recomendado' => '0'));
        redirect(base_url() . 'index.php/car/estado/aprobado-admin');
        //
    }

      /*FIN INI - Modificado por: GGONZALEZ - 25/01/2015 */

    function saveRec() {
        //datos desde el formulario

        $this_id = $this->savedata_model->GuardarRec($this->input->post('tipo'));

        $referido = array(
            'id' => '',
            'id_rec' => $this_id,
            'nombre' => $this->input->post('nombre'),
            'dui' => $this->input->post('dui'),
            'nit' => $this->input->post('nit'),
            'telefono' => $this->input->post('telefono'),
            'email' => '',
            'vehiculo' => $this->input->post('vehiculo'),
            'sujeto' => 'referido'
        );

        $this->savedata_model->Guardar('cq_recomendar', $referido);


        $referidor = array(
            'id' => '',
            'id_rec' => $this_id,
            'nombre' => $this->input->post('from_nombre'),
            'dui' => $this->input->post('from_dui'),
            'nit' => $this->input->post('from_nit'),
            'telefono' => $this->input->post('from_telefono'),
            'email' => $this->input->post('from_email'),
            'vehiculo' => '',
            'sujeto' => 'referidor'
        );
        $this->savedata_model->Guardar('cq_recomendar', $referidor);

        $dat = array('tipo' => 'form_Rec',
            'to' => 'callcenter@crediq.com, cpacheco@crediq.com, koporto@crediq.com',
            'referidor' => $referidor,
            'referido' => $referido,
            'tipo_rec' => $this->input->post('tipo')
        );

        $this->function_model->enviarMail($dat);

        $fase = $this->input->post('fase1');
        if ($fase == 'fase1') {
            redirect(base_url() . 'index.php/site/aviso/28');
        } elseif ($fase == 'website') {
            redirect('http://crediq.com/index.php/promociones.html');
        } else {
            redirect(base_url() . 'index.php/site/aviso/27');
        }
    }

}

//fin clase =(
