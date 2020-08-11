<?php

addBusiness();

function addBusiness() {
    echo "Iniciando el proceso <br>";
    require_once('nusoap.php');

    $soap_url = 'http://10.1.11.221/sugarcrm/soap_custom.php';
    $soap_user = 'admin';
    $soap_pass = 'Lun3tt3s';

    //ID de la campania "Solicitudes usadoscrediq.com"
    $campaniaID = "68f76de3-fdc0-e198-3991-53b470ff118e";


    echo "URL: " . $soap_url . "<br>";
    echo "Usr: " . $soap_user . " || Pass: " . md5($soap_pass) . "<br>";
    echo "Id Campaña: " . $campaniaID . "<br>";
    echo "Librerias cargadas<br>";



    /* Creando conexiones a las bases */
    // Conexion a sugarCRM
    $connSugarCRM = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");
    if ($connSugarCRM->connect_error) {
        die('Connect Error (' . $connSugarCRM->connect_errno . ') '
                . $connSugarCRM->connect_error);
    }
    echo "Conexion exitosa a sugarCRM 10.1.11.221 || " . $connSugarCRM->host_info . "<br>";

    // Conexion a usadoscrediq.com
    $connUsados = new mysqli("190.86.197.251", "root", "Tr0mp3ta", "usadoscrediq_dev");
    if ($connUsados->connect_error) {
        die('Connect Error (' . $connUsados->connect_errno . ') '
                . $connUsados->connect_error);
    }
    echo "Conexion exitosa a usadoscrediq.com 190.86.197.251 || " . $connUsados->host_info . "<br/><br/>";

    // Creando objeto de WS SOAP de sugarCRM
    $soapclient = new nusoap_client($soap_url);
    $result = $soapclient->call('login', array('user_auth' => array('user_name' => $soap_user, 'password' => md5($soap_pass), 'version' => '.01'), 'application_name' => 'LeadSOAP'));
    $session = $result['id'];


    //Control conteo de solicitudes
    $iCredito = 0;
    $iVehiculos = 0;


    echo "<br/><br/><br/>###########################################################<br/>";
    echo "Ejecutando solicitudes creditos... <br/>";
    // SQL QUERY - Obtiene los registros de solicitudes de creditos
    $sql = "SELECT id, nombre_cliente, email, dui, monto_max, cuota_max, telefono_fijo, "
            . "telefono_celular, telefono_oficina, comentario, fecha_adicion, usuario_adicion, 'USD' AS moneda "
            . "FROM cq_solicitudes_creditos "
            . "WHERE fecha_asignacion IS NULL limit 1";

    echo "Ejecutando QUERY #connUsados: " . $sql . '<br><br>';
    $res = $connUsados->query($sql);
    while ($row = $res->fetch_assoc()) {
        guardarRegistro($connUsados, $connSugarCRM, $session, $row, $soapclient, $campaniaID, 'CREDITO');
        $iCredito++;
    }

    // SQL QUERY - Obtiene los registros de solicitudes de vehiculos
    $sql = "SELECT id, nombre_cliente, email, telefono_fijo, telefono_celular, "
            . "telefono_oficina, fecha_adicion, tipo_vehiculo, marca, anio_desde, "
            . "anio_hasta, precio_desde, precio_hasta, procedencia_importado, "
            . "procedencia_agencia, comentario, 'USD' AS moneda,"
            . "(SELECT nombre FROM cq_marca WHERE id_marca = marca) AS marca_nombre, "
            . "(SELECT nombre FROM cq_tipo_vehiculo WHERE id_tipo_vehiculo = tipo_vehiculo) AS tipo_vehiculo_nombre  "
            . "FROM cq_solicitudes_vehiculos "
            . "WHERE fecha_asignacion IS NULL limit 1";


    echo "<br/><br/><br/>###########################################################<br/>";
    echo "Ejecutando solicitudes vehiculos... <br/>";
    echo "Ejecutando QUERY #connUsados: " . $sql . '<br><br>';
    $res = $connUsados->query($sql);
    while ($row = $res->fetch_assoc()) {
        guardarRegistro($connUsados, $connSugarCRM, $session, $row, $soapclient, $campaniaID, 'VEHICULO');
        $iVehiculos++;
    }


    echo "SOLICITUDES DE CREDITOS CARGADAS: $iCredito <br/>";
    echo "SOLICITUDES DE VEHICULOS CARGADAS: $iVehiculos <br/><br/>";

    mysqli_close($connSugarCRM);
    mysqli_close($connUsados);
    echo "<script>window.close();</script>";
}

function guardarRegistro($connUsados, $connSugarCRM, $session, $row, $soapclient, $campaniaID, $tipo) {
    $dateEntered = date('Y-m-d');

    // Obtener el usuario que se asignara el negocio
    $assignedUser = getUsuarioAsignar($connSugarCRM, $campaniaID);
    echo "El registro se asignara a: " . $assignedUser . '<br/>';

    echo "Creando negocio..: " . $tipo . " - " . $row['id'] . " - " . $row['nombre_cliente'] . '<br/>';

    if ($tipo == 'CREDITO') {
        $name = $row['nombre_cliente'];
        $name1 = $row['nombre_cliente'];
        $name2 = $row['nombre_cliente'];
        $phones = $row['telefono_fijo'] . " | " . $row['telefono_celular'] . " | " . $row['telefono_oficina'];
        $comentario = $row['comentario'];
        $usuario_adicion = $row['usuario_adicion'];

        $amount = $row['monto_max'];
        $cuota = $row['cuota_max'];
        $address = $row['email'];
        $moneda = $row['moneda'];
        $dui = $row['dui'];
    } else {
        $name = $row['nombre_cliente'];
        $name1 = $row['nombre_cliente'];
        $name2 = $row['nombre_cliente'];
        $phones = $row['telefono_fijo'] . " | " . $row['telefono_celular'] . " | " . $row['telefono_oficina'];
        $comentario = $row['comentario'];
        $usuario_adicion = $row['usuario_adicion'];

        $precio_desde = $row['precio_desde'];
        $amount = $row['precio_hasta'];
        $address = $row['email'];
        $moneda = $row['moneda'];

        $marca = $row['marca_nombre'];
        $anio_desde = $row['anio_desde'];
        $anio_hasta = $row['anio_hasta'];
        $tipo_vehiculo = $row['tipo_vehiculo_nombre'];
    }

    $paramsLead = array(
        'session' => $session,
        'module_name' => "Leads",
        'name_value_list' => array(
            array('name' => "id", 'value' => ''),
            array('name' => "description", 'value' => $name),
            array('name' => "deleted", 'value' => 0),
            array('name' => "assigned_user_id", 'value' => $assignedUser),
            array('name' => "first_name", 'value' => $name1),
            array('name' => "last_name", 'value' => $name2),
            array('name' => "phone_work", 'value' => $phones),
            array('name' => "lead_source", 'value' => 'usadoscrediq'),
            array('name' => "opportunity_amount", 'value' => $amount),
            array('name' => "campaign_id", 'value' => $campaniaID),
            array('name' => "status", 'value' => 'Assigned'),
            array('name' => "typclt_c", 'value' => 'PNAT'),
            array('name' => "medcam_c", 'value' => 'CCEN'),
            array('name' => "typpro_c", 'value' => 'CREA'),
            array('name' => "carret_c", 'value' => 0),
            array('name' => "extfin_c", 'value' => 1),
            array('name' => "direccion_visita_c", 'value' => $address),
        )
    );


    //var_dump($params);
    $leadId = $soapclient->call('set_entry', $paramsLead);
    $idParent = $leadId["id"];
    echo "LEAD CREADO: " . $leadId['id'] . " <br>";

    $paramsCall = array(
        'session' => $session,
        'module_name' => "Calls",
        'name_value_list' => array(
            array('name' => "id", 'value' => ''),
            array('name' => "name", 'value' => $name),
            array('name' => "created_by", 'value' => '1'),
            array('name' => "description", 'value' => 'Llamada de Colocación negocios ingresados en usadoscrediq.com'),
            array('name' => "deleted", 'value' => 0),
            array('name' => "assigned_user_id", 'value' => $assignedUser),
            array('name' => "duration_hours", 'value' => 0),
            array('name' => "duration_minutes", 'value' => 15),
            array('name' => "date_start", 'value' => $dateEntered),
            array('name' => "date_end", 'value' => $dateEntered + 900),
            array('name' => "parent_type", 'value' => 'Leads'),
            array('name' => "status", 'value' => 'Planned'),
            array('name' => "direction", 'value' => 'Outbound'),
            array('name' => "parent_id", 'value' => $idParent),
            array('name' => "reminder_time", 'value' => 900),
            array('name' => "url_encuesta_c", 'value' => "http://10.1.11.221/tareas/scriptAniversario.php?"),
            array('name' => "survey_type_c", 'value' => 'UsadosCrediq'),
            array('name' => "monto_prestamo_c", 'value' => $amount),
            array('name' => "call_type_c", 'value' => 'Telemercadeo'),
            array('name' => "producto_c", 'value' => 'Usados'),
            array('name' => "resultado_c", 'value' => 'Pendiente'),
            array('name' => "telefonos_c", 'value' => $phones),
            array('name' => "campaign_id_c", 'value' => $campaniaID),
        )
    );

    //Create the Call record
    $call_result = $soapclient->call('set_entry_calls', $paramsCall);
    echo "CALL CREADO: " . $call_result["id"] . "<br/>";

    // Se crea el detalle del negocio en DTNG_DetalleNegocios
    $params = array(
        'session' => $session,
        'module_name' => 'DTNG_DetalleNegocios',
        'name_value_list' => array(
            array('name' => "id", 'value' => ''),
            array('name' => "name", 'value' => $name),
            array('name' => "date_entered", 'value' => $dateEntered),
            array('name' => "description", 'value' => "Negocio creado desde usadoscrediq.com"),
            array('name' => "deleted", 'value' => 0),
            array('name' => "assigned_user_id", 'value' => $assignedUser),
            array('name' => "opportunity_amount", 'value' => $amount),
            array('name' => "current_balance", 'value' => $cuota),
            array('name' => "currency_name_c", 'value' => $moneda),
            array('name' => "dui_c", 'value' => $dui),
            array('name' => "marca_c", 'value' => $marca),
            array('name' => "tipo_vehiculo_c", 'value' => $tipo_vehiculo),
            array('name' => "anio_desde_c", 'value' => $anio_desde),
            array('name' => "anio_c", 'value' => $anio_hasta),
            array('name' => "precio_desde_c", 'value' => $precio_desde),
            array('name' => "procedencia_c", 'value' => "usadoscrediq.com"),
            array('name' => "comentario_c", 'value' => $comentario),
            array('name' => "usuario_adicion_c", 'value' => $usuario_adicion),
            array('name' => "tipo_solicitud_c", 'value' => $tipo),
        )
    );

    //Create the Account record
    $bunisses_result = $soapclient->call('set_entry', $params);
    echo 'NEGOCIO CREADO: ' . $bunisses_result["id"] . "<br>";


    $relationship = array(
        'session' => $session,
        array(
            'module1' => 'DTNG_DetalleNegocios',
            'module1_id' => $bunisses_result["id"],
            'module2' => 'Leads',
            'module2_id' => $leadId["id"],
        )
    );


    // call set_relationship()
    $response = $soapclient->call('set_relationship_business', $relationship);
    echo "RELACION CREADO: " . $response['id'] . "<br/>";

    // Actualizar registro en usadoscrediq.com    
    $isUpdate = actualizarAsignado($connUsados, $row['id'], $assignedUser, $tipo);
    echo "Negocio creado exitosamente...";
    echo "<br/><br/><br/>";
}

function actualizarAsignado($connUsados, $id, $assignedUser, $tipo) {
    if ($tipo == 'CREDITO') {
        $sql = "update cq_solicitudes_creditos set fecha_asignacion=NOW(), ejecutivo_asignado = '$assignedUser' where id =$id ";
    } else {
        $sql = "update cq_solicitudes_vehiculos set fecha_asignacion=NOW(), ejecutivo_asignado = '$assignedUser' where id =$id ";
    }
    echo "EJECUTANDO..: " . $sql;
    $connUsados->query($sql);
    mysqli_query($connUsados, $sql);
    printf("Filas Afectadas (UPDATE): %d\n", mysqli_affected_rows($connUsados));
    echo "<br/>NEGOCIO ACTUALIZADO EN USADOS.";

    return true;
}

function getUsuarioAsignar($connSugarCRM, $campaniaID) {
    // Obtiene el numero del ultimo grupo asignado
    $ultimoGrupo = getUltimoGrupoAsignado($connSugarCRM);
    // Obtiene el id de usuario con menos carga para la campaia
    $id = getUsuarioMenosCarga($connSugarCRM, $ultimoGrupo, $campaniaID);
    // Se actualiza el ultimo grupo asignado.
    actualizarUltimoGrupoAsignado($connSugarCRM, $ultimoGrupo);
    return $id;
}

function getUltimoGrupoAsignado($connSugarCRM) {
    echo "Obteniendo ultimo grupo... "; 
    $sql = "SELECT MAX(ultimo_grupo)+1 AS ultimo_grupo FROM cq_grupo_cargado";
    $ultimoGrupo = 1;
    $res = $connSugarCRM->query($sql);
    while ($row = $res->fetch_assoc()) {
        $ultimoGrupo = $row['ultimo_grupo'];
    }
    if ($ultimoGrupo > 4) {
        $ultimoGrupo = 1;
    }
    echo "GRUPO: $ultimoGrupo <br/>";
    return $ultimoGrupo;
}

function getUsuarioMenosCarga($connSugarCRM, $ultimoGrupo, $campaniaID) {
    $id = null;
    $sql = "SELECT * FROM (
                    SELECT  u.id AS id, u.user_name AS USER, 
	(SELECT COUNT(c.id) FROM calls c WHERE c.assigned_user_id = u.id AND c.deleted=0 AND STATUS='Planned' AND (SELECT id_c FROM calls_cstm cs WHERE c.id = cs.id_c AND cs.campaign_id_c ='$campaniaID' ) ) cantidad
	FROM users u
	WHERE u.department LIKE  'Negocios USADOS G$ultimoGrupo'
	HAVING cantidad < 10
	) t 
	ORDER BY cantidad ASC limit 1";

    $res = $connSugarCRM->query($sql);
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
    }
    return $id;
}

function actualizarUltimoGrupoAsignado($connSugarCRM, $ultimoGrupo) {
    $sql = "UPDATE cq_grupo_cargado SET ultimo_grupo = $ultimoGrupo ";
    $connSugarCRM->query($sql);
    mysqli_query($connSugarCRM, $sql);
    //printf("Filas Afectadas (UPDATE): %d\n", mysqli_affected_rows($connSugarCRM));        
}

?>
