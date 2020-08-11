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
class Filter_model extends CI_Model {
    /* FILTRADOS POR TIPO DE VEHICULO */

    function getByCategory($tipo_vehiculo = 1) {
        $query = $this->db->query(
                "SELECT 
		 auto.id_automovil,
		 auto.year,
		 auto.precio,
		 auto.certificado,
		 auto.kilometraje, 
		 auto.negociable,
		 img.imagen,
		 modelo.nombre AS modelo,
		 combustible.nombre tipo_comb,
		 marca.nombre nombre_marca	
		 FROM 
		    cq_automovil auto, 
			cq_imagen_x_auto img, 
			cq_tipo_combustible combustible, 
			cq_modelo modelo,
			cq_marca marca 
		WHERE auto.id_automovil = img.id_automovil AND
			 auto.tipo_combustible = combustible.id_tipo_combustible AND 
			 auto.marca = marca.id_marca AND 
			 auto.modelo = modelo.id_modelo AND 
			 img.id_imagen = 1 AND 
			 auto.estado = 'Aprobado' AND  
			 auto.pais = '" . $this->session->userdata('pais') . "' AND  
			 auto.tipo_vehiculo = ? ", array($tipo_vehiculo));

        $this->session->set_userdata('categoria_actual', $tipo_vehiculo);

        return $query->result_array();
    }

    /* USANDO FILTROS */
/*INI - Modificado por: GGONZALEZ - 25/01/2015 */
    function getProducts($start_year, $end_year, $mark, $model, $start_price, $end_price, $tipo_vehiculo, $combustible, $financiamiento, $transmision, $limite, $ingreso,$recomendados, $idUsuario = "") {
        
        
        $cont = 0;
        $pais = $this->session->userdata('pais');
        $orden = $this->session->userdata('orden_actual');

        switch ($orden) :
            case "1":
                $order_by = "auto.precio ASC " ;
                break;
            case "2":
                $order_by = "auto.year ASC ";
                break;
            case "3":
                $order_by = "marca.nombre ASC ";
                break;
            case "4":
                $order_by = "modelo.nombre ASC ";
                break;
            case "5":
                $order_by = "auto.prioridad DESC, auto.id_automovil DESC ";
                break;
            default:
                $order_by = "nombre_marca ASC ";
        endswitch;

        $sql_anio = "";
        $sql_idUsuario = "";
        $sql_modelo = "";
        $sql_marca = "";
        $desde_hasta = "";
        $sql_combustible = "";
        $sql_financiamiento = "";
        $sql_recomendados = "";
        $sql_transmision = "";
        $sql_ingreso = "";
        $sql_tipo_vehiculo = "";
        $arregloCampos = "";
      
        if ($idUsuario != "") {
            $sql_idUsuario = " AND auto.usuario = ?  ";
            $arregloCampos[$cont] = $idUsuario;
            $cont ++;
        }        
        
        /*
          if ($year != ""){
          $sql_anio = " AND auto.year = ?  ";
          $arregloCampos[$cont] = $year;
          $cont ++;
          }
         */

        if ($mark != "") {
            $sql_marca = "AND auto.marca = ? ";
            $arregloCampos[$cont] = $mark;
            $cont ++;
        }

        if ($model != "") {
            $sql_modelo = "AND auto.modelo = ? ";
            $arregloCampos[$cont] = $model;
            $cont ++;
        }

        if ($combustible != "") {
            $sql_combustible = "AND combustible.id_tipo_combustible = ? ";
            $arregloCampos[$cont] = $combustible;
            $cont ++;
        }

        if ($financiamiento != "") {
            //$sql_financiamiento = "AND auto.financiamiento = ? ";
            $sql_financiamiento = "AND auto.certificado = ? ";
            $arregloCampos[$cont] = $financiamiento;
            $cont ++;
        }
        
       
        
        if ($recomendados != "") {           
            $sql_recomendados = "AND auto.recomendado = ? ";
            $arregloCampos[$cont] = $recomendados;
            $cont ++;
        }

        if ($transmision != "") {
            $sql_transmision = "AND auto.tipo_transmision = ? ";
            $arregloCampos[$cont] = $transmision;
            $cont ++;
        }
        if ($ingreso != "") {
            $sql_ingreso = "AND auto.tipo_ingreso = ? ";
            $arregloCampos[$cont] = $ingreso;
            $cont ++;
        }

        if ($tipo_vehiculo != "" and $tipo_vehiculo != "todas") {
            $sql_tipo_vehiculo = "AND auto.tipo_vehiculo = '" . $tipo_vehiculo . "' ";
            //no se necesita agregarlo al array por que ya se le esta dando valor
            $this->session->set_userdata('categoria_actual', $tipo_vehiculo);
        }

        $sql_precioInit = "0";
        $sql_precioFin = "999999999999";


        if ($start_price != "" and $end_price != "") {

            $desde_hasta = "AND auto.precio BETWEEN '" . $start_price . "' AND '" . $end_price . "' ";
            $arregloCampos[$cont] = $start_price;
            $cont ++;
            $arregloCampos[$cont] = $end_price;
            $cont ++;
        } else if ($start_price != "") {

            $desde_hasta = "AND auto.precio BETWEEN '" . $start_price . "' AND '" . $sql_precioFin . "' ";
            $arregloCampos[$cont] = $start_price;
            $cont ++;
            $arregloCampos[$cont] = $sql_precioFin;
            $cont ++;
        } else if ($end_price != "") {

            $desde_hasta = "AND auto.precio BETWEEN  '" . $sql_precioInit . "'  AND  '" . $end_price . "' ";
            $arregloCampos[$cont] = $sql_precioInit;
            $cont ++;
            $arregloCampos[$cont] = $end_price;
            $cont ++;
        }


        $sql_yearInit = date('Y') - 15;
        $sql_yearFin = date('Y');

        $sql_anio = "AND auto.year BETWEEN '" . $start_year . "' AND '" . $end_year . "' ";


        $queryToExecute = "SELECT DISTINCT (auto.id_automovil),
			auto.year, 
			auto.precio, 
			auto.certificado,
			auto.recomendado, 
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
            img.codigo_vehiculo = auto.id_automovil
			" . $sql_tipo_vehiculo . "  			
			" . $sql_marca . "
			" . $sql_modelo . "
			" . $sql_combustible . " 
			" . $sql_financiamiento . "
                        " . $sql_recomendados . "    
			" . $sql_transmision . " 
            " . $sql_ingreso . "                       
            " . $sql_idUsuario . "
			" . $sql_anio . "    
            " . $desde_hasta . "  
			  ORDER BY " . $order_by . $limite;

        $this->session->set_userdata('queryDebug', $queryToExecute);

        $query = $this->db->query($queryToExecute, $arregloCampos);

        //error_log("\r\n-->Consulta=".$queryToExecute."\r\n", 3, dirname(__FILE__)."/log.log");
        //error_log("\r\n-->Marca=".$mark."\r\n", 3, dirname(__FILE__)."/log.log");
        //error_log("\r\n-->ingreso=".$ingreso."\r\n", 3, dirname(__FILE__)."/log.log");
        return $query->result_array();

        //return $queryToExecute;
    }
/*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
    /* USANDO FILTROS */

    function getProductsVendidos($limite, $idUsuario = "") {
        $cont = 0;
        $pais = $this->session->userdata('pais');
        $orden = $this->session->userdata('orden_actual');
        $order_by = "nombre_marca";

        $sql_anio = "";
        $sql_idUsuario = "";


        $arregloCampos = "";

        if ($idUsuario != "") {
            $sql_idUsuario = " AND auto.usuario = ?  ";
            $arregloCampos[$cont] = $idUsuario;
            $cont ++;
        }
        $queryToExecute = "SELECT DISTINCT (auto.id_automovil),
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
			auto.estado='Vendido' AND
			img.codigo_vehiculo = auto.id_automovil                           
                        " . $sql_idUsuario . "
			  ORDER BY " . $order_by . "  ASC " . $limite;

        $this->session->set_userdata('queryDebug', $queryToExecute);

        $query = $this->db->query($queryToExecute, $arregloCampos);

        //error_log("\r\n-->Consulta=".$queryToExecute."\r\n", 3, dirname(__FILE__)."/log.log");
        return $query->result_array();

        //return $queryToExecute;
    }
    
    
    function getProductsRecomendados($limite, $idUsuario = "", $recomendados) {
        $cont = 0;
        $pais = $this->session->userdata('pais');
        $orden = $this->session->userdata('orden_actual');
        $order_by = "nombre_marca";

        $sql_anio = "";
        $sql_idUsuario = "";
        

        $arregloCampos = "";

        if ($idUsuario != "") {
            $sql_idUsuario = " AND auto.usuario = ?  ";
            $arregloCampos[$cont] = $idUsuario;
            $cont ++;
        }
        
     
        
        $queryToExecute = "SELECT DISTINCT (auto.id_automovil),
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
                        auto.recomendado = '" . $recomendados . "' AND 
			img.codigo_vehiculo = auto.id_automovil                           
                        " . $sql_idUsuario . "                        
			  ORDER BY " . $order_by . "  ASC " . $limite;

        $this->session->set_userdata('queryDebug', $queryToExecute);

        $query = $this->db->query($queryToExecute, $arregloCampos);

        //error_log("\r\n-->Consulta=".$queryToExecute."\r\n", 3, dirname(__FILE__)."/log.log");
        return $query->result_array();

        //return $queryToExecute;
    }
    

    function paginar($total, $walls_x_pagina, $size, $objeto_fun) {

        $total_paginas = 0;
        if ($total == 0) {//si el total es igual a cero
            //total 150
            $total_paginas = 1;
        } else if ($total > $walls_x_pagina) {// si no si el total es mayor a 9 quiere decir que sobrepasa la capacidad de dibujos por pagina(lapso)
            $lapsos = $total / $walls_x_pagina; //entonces tenemos que paginar y sacamos el total de lapsos dividiendo el total de dibujos entre 9 que es la capacidad de cada pag.
            //=16.6
            if (!is_int($lapsos)) {//si  el resultado de la division es diferente de entero quiere decir que la ultima pagina tendra menos de 9 dibujos
                $lapsos = floor($lapsos + 1); //como el total de lapsos me dio lapsos.decimales, tomando en cuenta que en la comparacion de forma estricta tomara en cuenta solo enteros, entonces sumamos + 1 pagina y quitamos decimales con floor()
                $cont = 1;
                $total_paginas = $lapsos;
            } else if (is_int($lapsos)) {
                $total_paginas = $lapsos;
            }
        } else if ($total < $walls_x_pagina) {//si el total de dibujos es menor a 9 solo utilizaremos una pagina sin necesidad de paginar
            $lapso_actual = 0; // y al lapso actual de damos un valor de uno
            $total_paginas = 1;
        }

        //$ancho_wrap=33*$total_paginas;

        $this->load->library('session');
        $this->session->set_userdata('total_paginas', $total_paginas);

        //definimos la pagina actual
        $pagina_actual = $this->session->userdata('pagina_actual');
        $lapso_actual = $this->session->userdata('lapso_actual');

        if ($total_paginas > $size) {
            $inicio = $pagina_actual - 2;
            $tope = $pagina_actual + 3; //definimos el tope de la paginacion sumando la pagina actual mas

            if ($tope > $total_paginas) {
                $tope = $total_paginas; //13
                $inicio = $tope - 5; //4
            }
            if ($inicio < 1) {
                $inicio = 1;
                $tope = 6;
            }
        } else {
            $inicio = 1;
            $tope = $total_paginas;
        }
        //echo 'onclick="'.$objeto_fun.'(\''.$sitio.$galeria.'?ord='.$_GET['ord'].'&l='.$_GET['l'].'&lap_act=1&pag=1\', \''.$capa_galeria.'\'), show_objeto(\''.$sitio.$paginacion.'?pag=1 \', \''.$capa_paginacion.'\' ) "';
        $paginacion = '<div class="pag">';
        //$paginacion .= '<div class="paginas_wrap"><div class="paginas"><ul><li id="paginas_label">Mostrando ' . $pagina_actual . ' de ' . $total_paginas . ' paginas:</li>';
        
       
        
        if ($total_paginas > $size) {

            $anterior_lapso = $lapso_actual - $walls_x_pagina;
            $anterior_pagina = $pagina_actual - 1;

            if ($anterior_pagina < 1) {//si la siguiente pagina el mayor que el total de paginas entoces
                $anterior_pagina = 1; //igualamos las dos variables
                $anterior_lapso = 0;
            }

            $paginacion .= '<a href="#" onclick="' . $objeto_fun . '(\'0\',\'1\',\'\',\'\')" ></a>'
                    . '<a onclick="' . $objeto_fun . '(\'' . $anterior_lapso . '\',\'' . $anterior_pagina . '\',\'\',\'\') ">'
                    . '</a>';
        }
        $i = 1;
        $contador = 0;
        while ($i <= $total_paginas) {

            if ($i >= $inicio and $i <= $tope) {
                //en el barrido si i tiene el valor de la pagian actual le decimos que le de otro estilo que reppresntara la pagina actual
                if ($i == $pagina_actual) {
                    $clase = 'class="active"';
                } else {
                    $clase = '';
                }

                $paginacion .= '<a id="' . $i . '" '.$clase.' onclick="' . $objeto_fun . '(\'' . $contador . '\',\'' . $i . '\',\'\',\'\')">   ' . $i . '  </a>';
            }
            $contador = $contador + $walls_x_pagina;
            $i++;
        }

        if ($total_paginas > $size) {
            $siguiente_lapso = $lapso_actual + $walls_x_pagina;
            $siguiente_pagina = $pagina_actual + 1;

            if ($siguiente_pagina > $total_paginas) {//si la siguiente pagina el mayor que el total de paginas entoces
                $siguiente_pagina = 1; //igualamos las dos variables al minimo valor
                $siguiente_lapso = 0;
            }
            $ultimo_lapso = $contador - $walls_x_pagina; //esto es por que el contador en la ultima repeticion suma 12 mas de lo soportado
            $paginacion .= '<a onclick="' . $objeto_fun . '(\'' . $siguiente_lapso . '\', \'' . $siguiente_pagina . '\',\'\',\'\')"><i class="icon-angle-right"></a>
							<a onclick="' . $objeto_fun . '(\'' . $ultimo_lapso . '\', \'' . $total_paginas . '\',\'\',\'\')" ></a>';
        }
        $paginacion .= '</div>';
        return $paginacion;
    }

    /* OBTENIENDO MODELOS A PARTIR DE UNA MARCA */

    function getModelsByMarck($marca) {

        $q ="SELECT * FROM cq_modelo WHERE marca='" . $marca . "' ORDER BY nombre ASC ";
        $query = $this->db->query("SELECT * FROM cq_modelo WHERE marca='" . $marca . "' ORDER BY nombre ASC ");

        //error_log("\r\n-->Query Modelos: ".$q."\r\n", 3, dirname(__FILE__)."/log.log");
        return $query->result_array();
    }
	

    function getModelsByMarckExistentes($marca) {
        $q ="SELECT DISTINCT m.* FROM cq_modelo m, cq_automovil a, imagenes i WHERE m.marca='$marca' AND  m.id_modelo =a.modelo AND  a.estado='Aprobado' AND i.codigo_vehiculo = a.id_automovil  ORDER BY m.nombre ASC ";
        $query = $this->db->query("SELECT DISTINCT m.* FROM cq_modelo m, cq_automovil a, imagenes i WHERE m.marca='$marca' AND  m.id_modelo =a.modelo AND  a.estado='Aprobado' AND i.codigo_vehiculo = a.id_automovil  ORDER BY m.nombre ASC ");
        //error_log("\r\n-->Query Modelos: ".$q."\r\n", 3, dirname(__FILE__)."/log.log");
        return $query->result_array();
    }

    function getDataWhere($tabla, $campo, $valor) {//solo un criterio(where $campo=$valor)
        $this->db->where($campo, $valor);
        $query = $this->db->get($tabla);
        return $query->row_array();
    }

    function MarcasByTipo($tipo) {//
        $query = $this->db->query("SELECT DISTINCT marca, (SELECT nombre FROM cq_marca WHERE id_marca=marca limit 1 ) as nombre_marca FROM cq_automovil WHERE tipo_vehiculo=?  ORDER BY nombre_marca ASC ", array($tipo));
        return $query->result_array();
    }

    function MarcasByTipoExistentes($tipo) {//
        $query = $this->db->query("SELECT DISTINCT m.id_marca as marca, m.nombre FROM cq_automovil a, imagenes i,  cq_marca m WHERE  tipo_vehiculo=? AND estado='Aprobado' AND m.id_marca= a.marca AND i.codigo_vehiculo = a.id_automovil ORDER BY m.nombre ASC ", array($tipo));
        return $query->result_array();
    }

    /* PARA RESULTADOS MEDIANTE VIENE DEL SITIO JOOMLA */

    function filter_ymm($year, $mark, $model, $pais) {
        $query = $this->db->query("SELECT auto.id_automovil, auto.year, auto.precio, auto.certificado, auto.kilometraje,
			auto.negociable, img.imagen, modelo.nombre AS modelo, combustible.nombre tipo_comb
			FROM cq_automovil auto, cq_imagen_x_auto img, cq_tipo_combustible combustible, cq_modelo modelo
			WHERE auto.id_automovil = img.id_automovil AND auto.tipo_combustible = combustible.id_tipo_combustible AND auto.modelo = modelo.id_modelo 
			AND img.id_imagen = 1 AND auto.estado = 'Aprobado' AND auto.pais = ? AND auto.year = ? AND auto.marca = ? AND auto.modelo = ? LIMIT 0,9", array($pais, $year, $mark, $model));

        return $query->result_array();
    }

}
