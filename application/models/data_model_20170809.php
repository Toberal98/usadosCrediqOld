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
class Data_model extends CI_Model {

    function getCategories() {
        $this->db->where('id_tipo_vehiculo !=', '2');
        $this->db->where('id_tipo_vehiculo !=', '3');
        $this->db->where('id_tipo_vehiculo !=', '4');
        $this->db->where('id_tipo_vehiculo !=', '5');
        $this->db->where('id_tipo_vehiculo !=', '7');
        $this->db->where('id_tipo_vehiculo !=', '10');

        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->result_array();
    }

    function getCategories2() {
        $query = $this->db->query("SELECT DISTINCT c.* FROM cq_tipo_vehiculo c, cq_automovil a, imagenes i  WHERE c.id_tipo_vehiculo = a.tipo_vehiculo AND a.estado='Aprobado' AND i.codigo_vehiculo = a.id_automovil ORDER BY c.nombre ASC");
        return $query->result_array();
    }

    function allCategories() {

        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->result_array();
    }

    function getCategoria($id = 0) {
        $this->db->where('id_tipo_vehiculo', $id);
        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->row_array();
    }

    function updateImgBanner($text, $orden, $id) {
        $this->db->query("update cq_imagen_x_banner set alt_text='" . $text . "' where id_banner=" . $id . " and orden=" . $orden);
    }

    function getMarks() {
        //$query = $this->db->get('cq_marca');

        $query = $this->db->query("SELECT * FROM cq_marca ORDER BY nombre ASC ");

        return $query->result_array();
    }




    function getParametro($codigo) {//para modificar
        //Top Banner
        $query = $this->db->query("SELECT valor FROM cq_par_parametros WHERE codigo ='" . $codigo . "' ");
        //returns the banners
        return $query->row_array();
    }



     /*MODIFICADO POR GGONZALEZ 26/05/2015 -  INI*/
    function getCamposMatriz($anio,$pais = 1) {//para modificar
        //Top Banner
        $query = $this->db->query("SELECT id, anio, plazo, tasa, prima FROM cq_mpl_matriz_planes WHERE anio =$anio AND pais = $pais");
        //returns the banners
        return $query->row_array();
    }

     /*MODIFICADO POR GGONZALEZ 26/05/2015 -  FIN*/

    function getMarksExistentes() {
        $query = $this->db->query("SELECT DISTINCT m.id_marca as id_marca, m.nombre  FROM cq_automovil a, imagenes i,  cq_marca m WHERE estado='Aprobado' AND m.id_marca= a.marca AND i.codigo_vehiculo = a.id_automovil ORDER BY m.nombre ASC ");
        return $query->result_array();
    }

    function ModelosPorMarca($marca) {
        //$this->db->where('marca', $marca);
        $query = $this->db->query("SELECT * FROM cq_modelo WHERE marca='" . $marca . "' ORDER BY nombre ASC ");

        return $query->result_array();
    }

    function getPaises() {
        $query = $this->db->get('cq_pais');
        return $query->result_array();
    }

    /* OBTENIENDO DATA DE UNA TABLA ESPECIFICA */

    function getData($tabla) {
        $query = $this->db->get($tabla);
        return $query->result_array();
    }

    function getprofesions() {
        $query = $this->db->get('cq_profesion');
        return $query->result_array();
    }

    function getcombus() {
        $query = $this->db->get('cq_tipo_combustible');
        return $query->result_array();
    }

    function getcolors() {
        $query = $this->db->get('cq_color');
        return $query->result_array();
    }

    function getBannerImg($id) {//para modificar
        //Top Banner
        $query = $this->db->query("SELECT * FROM cq_imagen_x_banner WHERE id_banner='" . $id . "'");
        //returns the banners
        return $query->result_array();
    }

	   /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/

	function getEquipamiento_sv($id) {
        $query = $this->db->query(
                "select cq_equipamiento.id_eq, cq_equipamiento.nombre, 'CK' ind_ck  from cq_equipamiento, cq_auto_x_equipamiento
where cq_equipamiento.id_eq = cq_auto_x_equipamiento.id_eq
and cq_auto_x_equipamiento.id_auto ='" . $id . "'
UNION ALL
select cq_equipamiento.id_eq, cq_equipamiento.nombre, 'NCK' ind_ck from cq_equipamiento
where id_eq not in (select cq_auto_x_equipamiento.id_eq FROM cq_auto_x_equipamiento
where cq_auto_x_equipamiento.id_auto = '" . $id . "')");



        return $query->result_array();
    }

  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/

    function getBanner($id) {//para modificar
        //Top Banner
        $query = $this->db->query("SELECT * FROM cq_banner WHERE id_banner='" . $id . "'");
        //returns the banners
        return $query->row_array();
    }

    function getUserIdAutolote($id) {//para modificar
        //Top Banner
        $query = $this->db->query("SELECT * FROM cq_autolotes WHERE nombrecorto = '" . $id . "' ");
        //returns the banners
        return $query->row_array();
    }

    function getBanners_list($limite) {//lista de banners
        //Top Banner
        $query = $this->db->query("SELECT * FROM cq_banner " . $limite);
        //returns the banners
        return $query->result_array();
    }

    function getBanners() {//banners para mostrar en el sitio
        $query = $this->db->query("SELECT * FROM cq_banner WHERE estado = 'Activo' AND fecha_publicacion < NOW() AND fecha_expiracion > NOW() AND posicion=2 ORDER BY creacion DESC LIMIT 1");

        $banners = $query->result_array();
        $i = 0;
        foreach ($banners as $banner) {

            //obteneemos imagenes para cada uno
            $query = $this->db->query("SELECT imagen, orden,alt_text FROM cq_imagen_x_banner WHERE id_banner='" . $banner['id_banner'] . "'");
            //returns the banners
            $imgs = $query->result_array();

            $banners[$i] = array('id_banner' => $banner['id_banner'], 'tipo' => $banner['tipo'], 'posicion' => $banner['posicion'], 'link' => $banner['link'], 'seccion' => $banner['seccion'], 'imgs' => $imgs);

            $this->db->query('UPDATE cq_banner SET hits = hits+1 WHERE id_banner=?', array($banner['id_banner']));

            $i++;
        }

        return $banners;
    }

    function Banners() {
        $query = $this->db->query("SELECT * FROM cq_banner WHERE estado = 'Activo' AND fecha_publicacion < NOW() AND fecha_expiracion > NOW() AND posicion=1 ORDER BY creacion DESC LIMIT 1");

        $banners = $query->result_array();
        $i = 0;
        foreach ($banners as $banner) {

            //obteneemos imagenes para cada uno
            $query = $this->db->query("SELECT imagen, orden,alt_text FROM cq_imagen_x_banner WHERE id_banner='" . $banner['id_banner'] . "'");
            //returns the banners
            $imgs = $query->result_array();

            $banners[$i] = array('id_banner' => $banner['id_banner'], 'tipo' => $banner['tipo'], 'posicion' => $banner['posicion'], 'link' => $banner['link'], 'seccion' => $banner['seccion'], 'imgs' => $imgs);

            $this->db->query('UPDATE cq_banner SET hits = hits+1 WHERE id_banner=?', array($banner['id_banner']));

            $i++;
        }

        return $banners;
    }

    function Productos($pais = 1) {
        $query = $this->db->query(
                "SELECT
			auto.id_automovil,
			auto.year,
			auto.precio,
			auto.certificado,
                        auto.recomendado,
			auto.kilometraje,
			auto.negociable,
			img.imagen,
			modelo.nombre AS modelo, combustible.nombre tipo_comb
			FROM
			cq_automovil auto,
			cq_imagen_x_auto img,
			cq_tipo_combustible combustible,
			cq_modelo modelo
			WHERE
			auto.id_automovil = img.id_automovil AND
			auto.tipo_combustible = combustible.id_tipo_combustible AND
			auto.modelo = modelo.id_modelo AND
			img.id_imagen = 1 AND
			auto.estado = 'Aprobado' AND
			auto.pais = ? LIMIT 9", $pais);

        return $query->result_array();
    }

    function getUser($id) {
        $query = $this->db->query("SELECT * FROM cq_usuario WHERE id_usuario='" . $id . "'  ");

        return $query->row_array();
    }

    function getCar($id, $pais = 1) {
        $query = $this->db->query("SELECT
									auto.*,
									auto.marca AS id_marca,
									marca.nombre AS marca,
									modelo.nombre AS modelo,
                                    auto.modelo AS id_modelo,
									combustible.nombre tipo_comb,
                                    auto.tipo_vehiculo,
                                    (SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo=auto.tipo_vehiculo LIMIT 1 ) AS estilo,
                                    (SELECT nombre FROM cq_departamentos WHERE id_departamento=auto.Departamento LIMIT 1 ) AS ciudad
			FROM cq_automovil auto,
			  	cq_tipo_combustible combustible,
			  	cq_modelo modelo, cq_marca marca
			WHERE auto.tipo_combustible = combustible.id_tipo_combustible AND
				 auto.modelo = modelo.id_modelo AND
				 auto.marca = marca.id_marca AND
				 /*auto.pais = '" . $pais . "' AND -- Des-comentar para filtrar el pais*/
				 auto.id_automovil = '" . $id . "' AND
				 auto.estado = 'Aprobado' AND
				 marca.id_marca = modelo.marca");

        //AND auto.estado = 'activo'

        return $query->row_array();
    }

    function getUserCar($id, $pais = 1) {

        $query = $this->db->query("SELECT
									auto.*,
									auto.marca AS id_marca,
									marca.nombre AS marca,
									modelo.nombre AS modelo,
                                    auto.modelo AS id_modelo,
									combustible.nombre tipo_comb,
                                    (SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo=auto.tipo_vehiculo LIMIT 1 ) AS estilo,
                                    (SELECT nombre FROM cq_departamentos WHERE id_departamento=auto.Departamento LIMIT 1 ) AS ciudad
			FROM
				cq_automovil auto,
			  	cq_tipo_combustible combustible,
			  	cq_modelo modelo, cq_marca marca
			WHERE
				 auto.tipo_combustible = combustible.id_tipo_combustible AND
				 auto.modelo = modelo.id_modelo AND
				 auto.marca = marca.id_marca AND
				 auto.pais = " . $pais . " AND
				 auto.id_automovil = " . $id . " AND
                 auto.estado != 'eliminado' AND
				 marca.id_marca = modelo.marca");

        //AND auto.estado = 'activo'

        return $query->row_array();
    }

  /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/
    function editUserCar($id, $pais = 1) {

        $query = $this->db->query("SELECT auto.*,
		                            auto.marca AS id_marca,
                                    auto.modelo AS id_modelo, (SELECT nombre FROM cq_marca WHERE id_marca=auto.marca LIMIT 1) AS nombre_marca,
                                                    (SELECT nombre FROM cq_modelo WHERE id_modelo=auto.modelo AND marca=auto.marca LIMIT 1 ) as nombre_modelo

            FROM
                cq_automovil as auto

            WHERE
                 auto.id_automovil = '" . $id . "' ");

        //AND auto.estado = 'activo'

        return $query->row_array();
    }
  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/

    function getPendiente($id, $pais = 1) {//obtienes carros sin importar el estado
        $query = $this->db->query("SELECT
									auto.*,
									auto.marca AS id_marca,
									marca.nombre AS marca,
									modelo.nombre AS modelo,
                                    auto.modelo AS id_modelo,
									combustible.nombre tipo_comb
			FROM cq_automovil auto,
			  	cq_tipo_combustible combustible,
			  	cq_modelo modelo, cq_marca marca
			WHERE auto.tipo_combustible = combustible.id_tipo_combustible AND
				 auto.modelo = modelo.id_modelo AND
				 auto.marca = marca.id_marca AND
				 auto.pais = '" . $pais . "' AND
				 auto.id_automovil = '" . $id . "' AND
				 auto.estado = 'pendiente' AND
				 marca.id_marca = modelo.marca");

        //AND auto.estado = 'activo'

        return $query->row_array();
    }

    function getDepartamentos() {
        $pais_actual = $this->session->userdata('pais');
        $query = $this->db->query("SELECT * FROM cq_departamentos WHERE id_pais= '" . $pais_actual . "' ");

        return $query->result_array();
    }

    function getActiveCars() {
        $this->db->select('auto.*, combustible.nombre AS combustible, marca.nombre AS marca, modelo.nombre AS modelo');
        $this->db->where(array('auto.estado' => 'activo', 'auto.tipo_combustible' => 'combustible.id_tipo_combustible', 'auto.marca' => 'marca.id_marca'
            , 'auto.modelo' => 'modelo.id_modelo'), NULL, false);
        $query = $this->db->get('cq_automovil auto, cq_tipo_combustible combustible, cq_modelo modelo, cq_marca marca');

        return $query->result_array();
    }
 /*INI - Modificado por: GGONZALEZ - 25/01/2015*/
    function carsbystado($pais, $estado, $limite) {

        $query = $this->db->query("SELECT DISTINCT auto.id_automovil,
			auto.year,
			auto.precio,
			auto.certificado,
                        auto.recomendado,
			auto.kilometraje,
			auto.negociable,
			modelo.nombre AS modelo,
			combustible.nombre tipo_comb,
			marca.nombre nombre_marca,
			auto.tipo_vehiculo,
			auto.color_externo,
			auto.descripcion,
			img.codigo_vehiculo,
                        auto.fecha,
            auto.marca
			FROM
			cq_automovil auto,
			cq_tipo_combustible combustible,
			cq_modelo modelo,
			cq_marca marca,
			imagenes img
			WHERE
			auto.tipo_combustible = combustible.id_tipo_combustible AND
			auto.marca = marca.id_marca AND
			auto.modelo = modelo.id_modelo AND
			auto.pais = '" . $pais . "' AND
			marca.id_marca = modelo.marca AND
			img.codigo_vehiculo = auto.id_automovil AND
			auto.estado = '" . $estado . "' order by auto.id_automovil desc " . $limite); // agregamos tabla imagenes para seleccionar solo autos con fotos
        return $query->result_array();
    }
        /*FIN- Modificado por: GGONZALEZ - 25/01/2015*/
    function getpendientes($pais, $estado, $limite) {
        $query = $this->db->query("SELECT
                                    auto.id_automovil AS id_auto,
                                    (SELECT nombre FROM cq_marca  WHERE id_marca=auto.marca LIMIT 1) AS marca,
                                    (SELECT nombre FROM cq_modelo WHERE id_modelo=auto.modelo AND marca=auto.marca LIMIT 1) AS modelo,
                                    (SELECT nombre FROM cq_tipo_combustible WHERE id_tipo_combustible=auto.tipo_combustible LIMIT 1) AS tipo_comb,
                                    auto.year,
                                    (SELECT nombre FROM cq_tipo_combustible WHERE id_tipo_combustible=auto.tipo_combustible LIMIT 1) AS combustible,

                                    auto.moneda,
                                    auto.precio
                                    FROM
                                    cq_automovil AS  auto
                                    WHERE
                                    auto.pais = '" . $pais . "' AND
                                    auto.estado = '" . $estado . "' " . $limite);
        return $query->result_array();
    }

    function statTopMarca() {

        $query = $this->db->query("SELECT b.nombre AS nombre,
                                          COUNT(marca) AS valor,
                                          b.id_marca
                                          FROM cq_buscados a, cq_marca b
									WHERE a.marca = b.id_marca GROUP BY marca LIMIT 10");

        return $query->result_array();
    }

    function statTopModelo() {

        $query = $this->db->query("SELECT CONCAT(c.nombre,'-',b.Nombre) as nombre, COUNT(CONCAT(a.marca,'-',a.modelo)) as valor FROM cq_buscados a, cq_modelo b, cq_marca c
                                    WHERE a.marca = b.marca AND a.modelo = b.id_modelo
                                    AND a.marca = c.id_marca
                                    GROUP BY a.modelo LIMIT 10");

        return $query->result_array();
    }

    /*
      SELECT CONCAT(c.nombre,'-',b.Nombre) as nombre, COUNT(CONCAT(a.marca,'-',a.modelo)) as valor FROM cq_buscados a, cq_modelo b, cq_marca c
      WHERE a.marca = b.marca AND a.modelo = b.id_modelo
      AND a.marca = c.id_marca
      GROUP BY CONCAT(a.marca,'-',a.modelo)
     */

    function statTopAnio() {

        $query = $this->db->query("SELECT YEAR as nombre, COUNT(YEAR) as valor FROM cq_buscados GROUP BY YEAR ");

        return $query->result_array();
    }

    function getUsers($limite) {

        //$query = $this->db->query("SELECT * FROM cq_usuario WHERE tipo_usuario = 1 ");
        $query = $this->db->query("SELECT * FROM cq_usuario WHERE tipo_usuario=1 " . $limite);

        return $query->result_array();
    }

    function getUserActiveCars($idUsuario) {
        $query = $this->db->query("SELECT
		marca.nombre as marca,
		auto.id_automovil, auto.year,
		 auto.precio, auto.certificado,
		  auto.kilometraje,
			auto.negociable,
			 modelo.nombre AS modelo,
			 combustible.nombre  combustible,
			 auto.estado
			FROM
			 cq_automovil auto,

			   cq_tipo_combustible combustible,
			    cq_modelo modelo, cq_marca marca
			WHERE

			 auto.tipo_combustible = combustible.id_tipo_combustible AND
			  auto.modelo = 	modelo.id_modelo AND
			   auto.marca = marca.id_marca AND
			   modelo.marca = marca.id_marca AND

				 auto.estado in ('Aprobado', 'pendiente', 'Rechazado') AND auto.usuario = ? ", $idUsuario);

        //$query = $this->db->get('cq_automovil auto, cq_tipo_combustible combustible, cq_modelo modelo, cq_marca marca');

        return $query->result_array();
    }

    function getUserCars($idUsuario) {
        $query = $this->db->query("SELECT
		marca.nombre as marca,
		auto.id_automovil, auto.year,
		 auto.precio, auto.certificado,
		  auto.kilometraje,
			auto.negociable,
			 modelo.nombre AS modelo,
			 combustible.nombre  combustible,
			 auto.estado
			FROM
			 cq_automovil auto,

			   cq_tipo_combustible combustible,
			    cq_modelo modelo, cq_marca marca
			WHERE

			 auto.tipo_combustible = combustible.id_tipo_combustible AND
			  auto.modelo = 	modelo.id_modelo AND
			   auto.marca = marca.id_marca AND
			   modelo.marca = marca.id_marca AND
               auto.estado != 'eliminado' AND

				   auto.usuario = ?
          ORDER BY auto.id_automovil DESC ", $idUsuario);

        //$query = $this->db->get('cq_automovil auto, cq_tipo_combustible combustible, cq_modelo modelo, cq_marca marca');

        return $query->result_array();
    }

    function getTumbnails($id) {
        // $this->db->where('codigo_vehiculo', $id);
        // $this->db->order_by('codigo_tipo_foto');
        $query = $this->db->query("SELECT codigo_tipo_foto as tipo FROM imagenes WHERE codigo_vehiculo='" . $id . "'");

        return $query->result_array();
    }

    function getColor($id) {
        $this->db->where('id_color', $id);
        $query = $this->db->get('cq_color');
        return $query->row_array();
    }

    function getPaisbyCode($pais) {
        $this->db->where('codigo', $pais);
        $query = $this->db->get('cq_pais');
        $data = $query->row_array();
        return $data['id_pais'];
    }

    function SetMoneda() {



        if ($this->session->userdata('pais')) {

            $pais = $this->session->userdata('pais');

            if ($pais == 1) {
                $this->session->set_userdata('moneda', '$');
            } elseif ($pais == 2) {
                $this->session->set_userdata('moneda', '₡');
            } elseif ($pais == 3) {
                $this->session->set_userdata('moneda', 'L');
            }
        } else {
            $this->session->set_userdata('moneda', '$');
        }



        return $this->session->userdata('moneda');
    }

    function GetEquipamiento($id) {

        $query = $this->db->query(
                "SELECT
			equipo.nombre
			FROM
			cq_auto_x_equipamiento equipo_auto,
			cq_equipamiento equipo

			WHERE
			equipo_auto.id_auto = ? AND
			equipo.id_eq = equipo_auto.id_eq
			", $id);


        return $query->result_array();
    }

    function GetEquipo($id, $id_eq) {
        $query = $this->db->query("SELECT * FROM  cq_auto_x_equipamiento WHERE id_auto = '" . $id . "' AND id_eq = '" . $id_eq . "' ");


        return $query->row_array();
    }

    function GetEquipamientoList() {
        $query = $this->db->query("SELECT * FROM cq_equipamiento");
        return $query->result_array();
    }

    function crearThum($source, $ancho, $alto, $new_image) {

        //CONFIGURACION PARA EL THUMBNAIL
        $configThumb = array();
        $configThumb['image_library'] = 'gd2';
        $configThumb['source_image'] = $source;
        $configThumb['create_thumb'] = TRUE;
        $configThumb['maintain_ratio'] = TRUE;
        $configThumb['width'] = $ancho; //58px
        $configThumb['height'] = $alto;
        $configThumb['new_image'] = $new_image;

        $this->load->library('upload', $config);
        $this->load->library('image_lib');

        $this->image_lib->initialize($configThumb);
        return $this->image_lib->resize();
    }

    function getDataWhere($where, $tabla) {
        $this->db->where($where);
        $query = $this->db->get($tabla);
        return $query->result_array();
    }

    function RowDataWhere($where, $tabla) {
        $this->db->where($where);
        $query = $this->db->get($tabla);
        return $query->row_array();
    }

    function getAllHits($id) {
        $query = $this->db->query("SELECT
			SUM(total_hits) as total
			FROM
			cq_hits
			WHERE
			id_automovil  = '" . $id . "' ");

        return $query->row_array();
    }

    function gethits($id) {
        $query = $this->db->query("SELECT
			hits.total_hits,
			mes.nombre AS nombre_mes
			FROM
			cq_hits hits,
			cq_mes mes
			WHERE
			hits.id_automovil = '" . $id . "' AND
			mes.id_mes = hits.mes");

        return $query->result_array();
    }

    function getclicks($id) {
        $query = $this->db->query("SELECT
			clicks.total_clicks,
			mes.nombre AS nombre_mes
			FROM
			cq_clicks clicks,
			cq_mes mes
			WHERE
			clicks.id_automovil = '" . $id . "' AND
			mes.id_mes = clicks.mes");

        return $query->result_array();
    }

    function inyectarHit($id) {

        date_default_timezone_set('America/El_Salvador');

        $where_date = array('mes' => date('n'), 'year' => date('Y'), 'id_automovil' => $id);

        $hits_base = $this->getDataWhere($where_date, 'cq_hits'); //sacamos los hits del auto

        if (count($hits_base) == 0) {//si no hay hits del mes actual guardamos un nuevo registro
            $datos_hit = array('mes' => date('n'),
                'id_automovil' => $id,
                'total_hits' => 1,
                'year' => date('Y')
            );

            $this->db->insert('cq_hits', $datos_hit); //insesertamos nuevo registro en la tabla de hits
        } elseif (count($hits_base) > 0) {//si no actualizamos los del mes actual
            $nuevos_hits = $hits_base[0]['total_hits'] + 1;

            $where_hit = array('mes' => $hits_base[0]['mes'], 'year' => $hits_base[0]['year'], 'id_automovil' => $id);
            $datos_hit = array('total_hits' => $nuevos_hits);

            $this->db->where($where_hit);
            $this->db->update('cq_hits', $datos_hit);
        }
    }

    function inyectarClick($id) {

        date_default_timezone_set('America/El_Salvador');

        $where_date = array('mes' => date('n'), 'year' => date('Y'), 'id_automovil' => $id);

        $clicks_base = $this->getDataWhere($where_date, 'cq_clicks'); //sacamos los clicks del auto

        if (count($clicks_base) == 0) {//si no hay clicks del mes actual guardamos un nuevo registro
            $datos_click = array('mes' => date('n'),
                'id_automovil' => $id,
                'total_clicks' => 1,
                'year' => date('Y')
            );

            $this->db->insert('cq_clicks', $datos_click); //insesertamos nuevo registro en la tabla de clicks
        } elseif (count($clicks_base) > 0) {//si no actualizamos los del mes actual
            $nuevos_clicks = $clicks_base[0]['total_clicks'] + 1;

            $where_click = array('mes' => $clicks_base[0]['mes'], 'year' => $clicks_base[0]['year'], 'id_automovil' => $id);
            $datos_click = array('total_clicks' => $nuevos_clicks);

            $this->db->where($where_click);
            $this->db->update('cq_clicks', $datos_click);
        }
    }

    function getUsermodel($id) {

        $query = $this->db->query("SELECT
			nombre
			FROM
			cq_modelo
			WHERE
			id_modelo = '" . $id . "' ");

        return $query->result_array();
    }

    function getTipoUser() {
        $query = $this->db->query("SELECT *  FROM cq_tipo_usuario ");

        return $query->result_array();
    }

    function deleteBanner($id) {
        $this->db->query("DELETE  FROM cq_banner WHERE id_banner='" . $id . "' ");
    }

    function deleteBannerImgs($id) {
        $query = $this->db->query("SELECT * FROM cq_imagen_x_banner WHERE id_banner='" . $id . "' ");
        $imagenes = $query->result_array();

        foreach ($imagenes as $imagen) {
            chmod($_SERVER['DOCUMENT_ROOT'] . '/public/banners/' . $imagen['imagen'], 777);
            unlink($_SERVER['DOCUMENT_ROOT'] . '/public/banners/' . $imagen['imagen']);
        }

        $this->db->query("DELETE  FROM cq_imagen_x_banner WHERE id_banner='" . $id . "' ");
    }

    function GetSolicitudes($limite) {
        $query = $this->db->query("SELECT * FROM cq_solicitud  " . $limite);
        return $query->result_array();
    }

    function getTipoVehiculo($id_tipo) {
        $query = $this->db->get('cq_tipo_vehiculo');
        return $query->row_array();
    }

    function getColorExterior($id) {
        $query = $this->db->query("SELECT nombre  FROM  cq_color WHERE id_color='" . $id . "'	");
        return $query->row_array();
    }

    function buscar($criterio, $limite) {
        $query = $this->db->query(" SELECT * FROM cq_usuario WHERE nombres = '" . $criterio . "' OR apellidos = '" . $criterio . "' " . $limite);
        return $query->result_array();
    }

    function autolote_users($limite) {
        $query = $this->db->query(" SELECT * FROM cq_usuario WHERE estado= 'activo' " . $limite);
        return $query->result_array();
    }

    function tendencias_marcas() {
        $query = $this->db->query(" SELECT
											DISTINCT(auto.marca),
											(SELECT nombre FROM cq_marca WHERE id_marca=auto.marca LIMIT 1 ) AS marca_nombre,
											SUM(hits.total_hits) AS total
										FROM
											cq_hits AS hits, cq_automovil AS auto
										WHERE
											auto.id_automovil=hits.id_automovil
										GROUP BY
											auto.marca LIMIT 10");
        return $query->result_array();
    }

    function tendencias_modelos() {
        $query = $this->db->query("SELECT
											DISTINCT(auto.modelo),
											(SELECT nombre FROM cq_modelo WHERE id_modelo=auto.modelo LIMIT 1 ) AS modelo_nombre,
											SUM(hits.total_hits) AS total
										FROM
											cq_hits AS hits, cq_automovil AS auto
										WHERE
											auto.id_automovil=hits.id_automovil
										GROUP BY
											auto.modelo
										LIMIT 10");
        return $query->result_array();
    }

    function getCampo($campo, $tabla, $condicion, $id) {

        if ($campo != "" and $tabla != "" and $id != "") {

            $query = $this->db->query("SELECT " . $campo . " FROM " . $tabla . " WHERE " . $condicion . " = '" . $id . "' LIMIT 1");


            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    function getCategoriasExistentes() {//
        //$query = $this->db->query("SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo IN (SELECT tipo_vehiculo FROM cq_automovil WHERE estado='Aprobado') ORDER BY nombre ASC");
        $query = $this->db->query("SELECT DISTINCT c.* FROM cq_tipo_vehiculo c, cq_automovil a, imagenes i  WHERE c.id_tipo_vehiculo = a.tipo_vehiculo AND a.estado='Aprobado' AND i.codigo_vehiculo = a.id_automovil ORDER BY c.nombre ASC");
        return $query->row_array();
    }

    function Similares($id, $criterio, $pais) {
        $query = $this->db->query("SELECT DISTINCT (auto.id_automovil),
			auto.year,
			auto.precio,
			auto.certificado,
			auto.kilometraje,
			auto.negociable,
			modelo.nombre AS modelo,
			combustible.nombre tipo_comb,
			marca.nombre nombre_marca,
			img.codigo_vehiculo,
			auto.usuario,
			(SELECT nombres FROM cq_usuario WHERE id_usuario='auto.usuario' LIMIT 1) as nombre_usuario
			FROM
			cq_automovil auto,
			cq_tipo_combustible combustible,
			cq_modelo modelo,
			cq_marca marca,
			imagenes img
			WHERE
			auto.tipo_combustible = combustible.id_tipo_combustible AND
			auto.marca = marca.id_marca AND
			auto.modelo = modelo.id_modelo AND
			auto.pais = '" . $pais . "' AND
			marca.id_marca = modelo.marca AND
			auto.estado='Aprobado' AND
			img.codigo_vehiculo = auto.id_automovil AND
			auto.usuario='" . $criterio . "' AND auto.id_automovil != '" . $id . "'

			 LIMIT 2");
        return $query->result_array();
    }

    function reporte($orden, $direccion, $limite, $tipo, $rango) {

        $global = "";
        if ($orden == "") {
            $orden = 'usuario';
        }
        if ($direccion == "") {
            $direccion = 'ASC';
        }
        if ($tipo == "global") {
            $global = ' GROUP BY  lote!="(NULL)" ';
        } else {
            $global == "";
        } //seleccionamos todos que en el campo lote es igual a null


        $query = $this->db->query("SELECT usuario.id_usuario AS usuario,
                                usuario.nombres ,
                                usuario.apellidos,

                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario                     ) AS subidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='Aprobado' ) AS aprobados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='Rechazado' ) AS rechazados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='Vendido' ) AS vendidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='de_baja' ) AS de_baja
                            FROM
                                cq_usuario AS usuario



                                ORDER BY " . $orden . "  " . $direccion . "  " . $limite);

        return $query->result_array();
    }

    function reporte_fecha($orden, $direccion, $limite, $tipo, $rango) {

        $query = $this->db->query("SELECT usuario.id_usuario AS usuario,
                                usuario.nombres ,
                                usuario.apellidos,
                                auto.fecha,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  " . $rango . "                   ) AS subidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  " . $rango . " AND estado='Aprobado' ) AS aprobados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  " . $rango . " AND estado='Rechazado' ) AS rechazados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  " . $rango . " AND estado='Vendido' ) AS vendidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  " . $rango . " AND estado='de_baja' ) AS de_baja
                            FROM
                                cq_usuario AS usuario,
                                cq_automovil AS auto
                            WHERE
                                auto.usuario=usuario.id_usuario
                                " . $rango . " GROUP BY usuario  ORDER BY " . $orden . "  " . $direccion . "  " . $limite);

        return $query->result_array();
    }

    function reporte_detalle($orden, $direccion, $limite, $tipo, $rango, $estado) {

        $where_tex = "";
        $and_text = "";

        if ($rango != "") {
            $where_tex = " WHERE ";
        }

        if ($estado == "todos") {
            $estado = "";
        }

        if ($estado != "") {
            $where_tex = " WHERE ";
            $estado = "auto.estado='" . $estado . "' ";
        }

        if ($rango != "" and $estado != "") {
            $and_text = " AND ";
        }

        $query = $this->db->query("SELECT auto.numero_de_placa AS placa,
            auto.usuario AS usuario,
            (SELECT nombrecorto FROM cq_autolotes WHERE idUsuario=auto.usuario LIMIT 1) AS lote,
            (SELECT nombre FROM cq_marca WHERE id_marca=auto.marca LIMIT 1) AS marca,
            (SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo=auto.tipo_vehiculo LIMIT 1) AS tipo,
            auto.year AS year_,
            auto.tipo_ingreso AS ingreso,
            auto.precio AS precio,
            (SELECT SUM(total_hits) FROM cq_hits WHERE id_automovil=auto.id_automovil LIMIT 1) AS visitas,
            auto.certificado AS precalificado,
            auto.fecha AS antiguedad,
            auto.moneda
            FROM

            cq_automovil AS auto  " . $where_tex . "  " . $rango . "  " . $and_text . " " . $estado . " ORDER BY " . $orden . "  " . $direccion . "  " . $limite);
        return $query->result_array();
    }

    function reporte_detalle_fecha($orden, $direccion, $limite, $tipo, $rango) {

    }

    function getOneUser($id) {
        $query = $this->db->query("SELECT * FROM cq_usuario WHERE id_usuario='" . $id . "' ");
        return $query->row_array();
    }

    function get_estado_user($email) {
        $query = $this->db->query("SELECT estado  FROM  cq_usuario WHERE email='" . $email . "'	");
        return $query->row_array();
    }

    function getNombre_modelo($modelo, $marca) {
        $query = $this->db->query("SELECT id_modelo, nombre FROM cq_modelo WHERE id_modelo='" . $modelo . "' AND  marca='" . $marca . "'  ");

        return $query->row_array();
    }

    function estaBytipo($marca) {
        $query = $this->db->query("SELECT  SUM(hit.total_hits) AS total,

                                    (SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo=auto.tipo_vehiculo ) AS estilo
                                    FROM
                                    cq_hits AS hit,
                                    cq_automovil AS auto
                                    WHERE
                                    auto.id_automovil=hit.id_automovil AND
                                    auto.estado='aprobado' AND
                                    auto.tipo_vehiculo!='(NULL)' AND
                                    auto.marca='" . $marca . "'
                                    GROUP BY auto.tipo_vehiculo
                                    ");

        return $query->result_array();
    }

    function maxid() {
        $query = $this->db->query("SELECT MAX(id_automovil) AS max_id FROM cq_ids ");

        return $query->row_array();
    }

    function total_Imgs($car_id) {
        $query = $this->db->query("SELECT codigo_vehiculo FROM imagenes WHERE codigo_vehiculo='" . $car_id . "'  ");

        return $query->result_array();
    }

    function total_Imgs_tipo($car_id, $desc_tipo) {
        $query = $this->db->query("SELECT codigo_vehiculo FROM imagenes WHERE codigo_vehiculo='" . $car_id . "' AND desc_tipo_foto='" . $desc_tipo . "'  ");

        return $query->result_array();
    }

    function getInfoVendedor($id) {


        $query = $this->db->query("SELECT fecha, ext_nombre, ext_email, ext_tel1, ext_tel2, justi_solicitud , ubicacion"
                . " FROM cq_automovil WHERE id_automovil = " . $id);
        return $query->row_array();
    }
	   /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/
	function getInfoCliente($id) {


        $query = $this->db->query("SELECT  fecha, ext_nombre, ext_email, ext_tel1, ext_tel2, justi_solicitud, ubicacion "
                . " FROM cq_automovil WHERE id_automovil = " . $id);
        return $query->result_array();
    }

	  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/

}

?>
