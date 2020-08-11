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
class report_model extends CI_Model {

    
	function reporte($orden, $direccion,$limite,$tipo,$rango){
	
    $global="";
	if($orden==""){ $orden='usuario'; }
	if($direccion==""){ $direccion='ASC'; }
    //if($tipo=="global"){ $global=' GROUP BY  lote!="(NULL)" '; }else{ $global==""; } //seleccionamos todos que en el campo lote es igual a null
    if($tipo=="lotes"){ 
        $selectlote= " , (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND lote!='0'   ) AS lote ";
        $groupby=' GROUP BY lote  ';

    }else{ 
        $groupby="";
        $selectlote=""; 
    
    } 
		
	$query = $this->db->query("SELECT usuario.id_usuario AS usuario,
                                usuario.nombres ,
                                usuario.apellidos,
                                 
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario                     ) AS subidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='Aprobado' ) AS aprobados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='Rechazado' ) AS rechazados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='Vendido' ) AS vendidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND estado='de_baja' ) AS de_baja
                                ".$selectlote."
                            FROM 
                                cq_usuario AS usuario
                                ".$groupby."
                                ORDER BY ".$orden."  ".$direccion."  ". $limite);
	
	return $query->result_array();	
		
	}
    function reporte_fecha($orden, $direccion,$limite,$tipo,$rango){

    if($tipo=="lotes"){ 
        $selectlote= " , (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario   AND lote!='0'   ) AS lote ";
        $groupby=' GROUP BY lote  ';

    }else{ 
        $groupby="GROUP BY usuario";
        $selectlote=""; 
    
    } 

        $query = $this->db->query("SELECT usuario.id_usuario AS usuario,
                                usuario.nombres ,
                                usuario.apellidos,
                                auto.fecha,  
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  ".$rango."                   ) AS subidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  ".$rango." AND estado='Aprobado' ) AS aprobados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  ".$rango." AND estado='Rechazado' ) AS rechazados,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  ".$rango." AND estado='Vendido' ) AS vendidos,
                                (SELECT COUNT(*) FROM cq_automovil WHERE usuario=usuario.id_usuario  ".$rango." AND estado='de_baja' ) AS de_baja
                                ".$selectlote."
                            FROM 
                                cq_usuario AS usuario,
                                cq_automovil AS auto
                            WHERE 
                                auto.usuario=usuario.id_usuario 
                                ".$rango." 
                                ".$groupby."
                                  ORDER BY ".$orden."  ".$direccion."  ". $limite);
    
    return $query->result_array();  
    }

    function reporte_detalle($orden, $direccion,$limite,$tipo,$rango,$estado){

        $where_tex="";
        $and_text="";

        

        if($estado=="todos" or $estado==""){ 
            $estado="auto.estado!='' "; 
        }else{ 
            $estado=" auto.estado='".$estado."' "; 
        }

        if($tipo=="lotes"){ 

            $andlote=" AND auto.lote!='0' ";
            $groupby='';
            

        }else{ 
            $groupby="";
            $andlote="";
             
    
        }

        $query = $this->db->query("SELECT auto.numero_de_placa AS placa,
            auto.usuario AS usuario,
            (SELECT nombrecorto FROM cq_autolotes WHERE id_autolote=auto.lote LIMIT 1) AS nombrelote,
            (SELECT nombre FROM cq_marca WHERE id_marca=auto.marca LIMIT 1) AS marca,
            (SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo=auto.tipo_vehiculo LIMIT 1) AS tipo,
            auto.year AS year_,
            auto.tipo_ingreso AS ingreso,
            auto.precio AS precio,
            (SELECT SUM(total_hits) FROM cq_hits WHERE id_automovil=auto.id_automovil LIMIT 1) AS visitas,
            auto.certificado AS precalificado,
            auto.fecha AS antiguedad,
            auto.moneda,
            auto.lote 
            FROM
            
            cq_automovil AS auto  WHERE ".$estado."  ".$andlote."  ".$rango."  

            ".$groupby."

            ORDER BY ".$orden."  ".$direccion."  ". $limite);
        return $query->result_array(); 
    }

    function reporte_detalle_fecha($orden, $direccion,$limite,$tipo,$rango){
        
    }
    
}

?>