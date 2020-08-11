<?php

function getCodigo() {
    return $_REQUEST["codigo"];
}

function getNombre() {
    return $_REQUEST["nombre"];
}

function getPrestamo() {
    return $_REQUEST["prestamo"];
}

function getFechaPago() {
    return $_REQUEST["fecha"];
}

function getEmail() {
    return $_REQUEST["email"];
}

function getProducto() {
    return $_REQUEST["producto"];
}

function getCuota() {
    return $_REQUEST["cuota"];
}

function getMarca() {
    return $_REQUEST["marca"];
}

function getMonto() {
    return $_REQUEST["monto"];
}

function getPlazo() {
    return $_REQUEST["plazo"];
}

function getTipoEncuesta() {
    return $_REQUEST["tipoEncuesta"];
}

function getId() {
    return $_REQUEST["idCall"];
}

function getAccount() {
    return $_REQUEST["account"];
}

function getUser() {
    return $_REQUEST["userAssigned"];
}

function getNumQuestion() {

    $i = 0;
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");
    //echo '$conexion';

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }

    $tipo = getTipoEncuesta();

    $queEmp = "select * from sugarcrm.cq_calls_scripts where survey_type = '$tipo' and estado = 'A' order by orden";

    //echo $queEmp;
    $res = $conexion->query($queEmp);
    if (!$res) {
        printf("Errormessage: %s\n", $conexion->error);
    }

    while ($row = $res->fetch_assoc()) {
        $i++;
    }
    //echo $i;
    return $i;
}

function generarScript($q) {

    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");
    //echo '$conexion';

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }


    $codigo = getCodigo();
    $nombre = getNombre();
    $prestamo = getPrestamo();
    $fecha = getFechaPago();
    $email = getEmail();
    $producto = getProducto();
    $cuota = getCuota();
    $marca = getMarca();
    $tipo = getTipoEncuesta();
    //echo 'nombre: ' . getNombre() . '<br>';
    $queEmp = "select * from sugarcrm.cq_calls_scripts where no_pregunta = $q and survey_type = '$tipo' and estado = 'A' order by orden";
    //echo $queEmp;
    $res = $conexion->query($queEmp);
    if (!$res) {
        printf("Errormessage: %s\n", $conexion->error);
    }

    /* $html = "<html><head><script type='text/javascript'>$(document).ready(function () { alert('prueba'); $('#preguntas').html('');" .
      "$('#div1').css('z-index','1000'); var nombres = $('#preguntas').contents().find('.nombre'); " .
      "$.each(nombres, function(item, i) {item.value();alert(i);});});</script></head><body>"; */
    $html = "";
    while ($row = $res->fetch_assoc()) {
        $respuesta = $row["respuesta"];
        $tipoResp = $row['tipo_respuesta'];
        $btnFirst = $row['etiqueta_si'];
        $btnSecond = $row['etiqueta_no'];
        $opcSi = $row['siguiente_si'];
        $opcNo = $row['siguiente_no'];
        $texto = $row['text'];
        $opcion = $row['no_pregunta'];
        $conDetalle = $row['detalle_negocios'];

        $botones;

        if ($tipoResp == "A") {
            $botones = "<table><tr><td><input type='submit' value='" . $btnFirst .
                    "' name='btnSi' id='btnSi' onClick='siguiente(this," .
                    $opcSi . "," . ($conDetalle == "S" ? 1 : 0) . ",true);'/></td>" .
                    "<td><input type='submit' value='" . $btnSecond .
                    "' name='btnNo' id='btnNo' onClick='siguiente(this, " .
                    $opcNo . "," . ($conDetalle == "S" ? 1 : 0) . ",false);'/></td></tr></table>";
        } else {
            if ($tipoResp == "S") {
                $botones = "<table><tr><td><input type='submit' value='" . $btnFirst .
                        "' name='btnSig' id='btnSig' onClick='siguiente(this," .
                        $opcSi . "," . ($conDetalle == "S" ? 1 : 0) . ",false);'/></td></tr></table>";  //$opcSi . ",0,false);'/></td></tr></table>";
            } else {
                if ($tipoResp == "F") {
                    $botones = "<table><tr><td><input type='submit' value='" . $btnFirst .
                            "' name='btnFin' id='btnFin' onClick='finalizar();'/></td></tr></table>";
                }
            }
        }

        $detalle = "";
        if ($conDetalle == "S") {
            if ($tipo == 'Extra' || $tipo == 'RecallExtra') {
                $detalle .= detalleNegociosExtra(getId());
            }
            if ($tipo == 'Retanqueo' || $tipo == 'RecallRetanqueo') {
                $detalle .= detalleNegociosRetanqueo(getId());
            }
            if ($tipo == 'Alargamiento' || $tipo == 'RecallAlargamiento') {
                $detalle .= detalleNegociosAlargamiento(getId());
            }
            if ($tipo == 'Combinada' || $tipo == 'RecallCombinada') {
                $detalle .= detalleNegociosExtraRetanqueo(getId());
            }
            if ($tipo == 'Recompra' || $tipo == 'RecallRecompra') {
                $detalle .= detalleNegociosRecompra(getId());
            }
            if ($tipo == 'RecompraExtra' || $tipo == 'RecallRecompraExtra') {
                $detalle .= detalleNegociosRecompraExtra(getId());
            }
            if ($tipo == 'RecompraRetanqueo' || $tipo == 'RecallRecompraRetanqueo') {
                $detalle .= detalleNegociosRecompraRetanqueo(getId());
            }
            if ($tipo == 'RecompraExtraRetanqueo' || $tipo == 'RecallRecompraExtraRetanqueo') {
                $detalle .= detalleNegociosRecompraExtraRetanqueo(getId());
            }
            if ($tipo == 'UsadosCrediq' || $tipo == 'UsadosCrediq') {
                $detalle .= detalleNegociosUsadosCrediq(getId());
            }


            //Cambio Detalle Cancelados y RecallBaseCancOct12.
            if ($tipo == 'BaseCancOct12' || $tipo == 'RecallBaseCancOct12') {
                $detalle .= detalleNegociosCancelados(getId());
            }
        }

        $html = $html . "<div id='div" . $opcion . "' class='question'><table><tr><td>" .
                $texto . "</td></tr><tr><td>" . $detalle .
                "</td></tr><tr><td>" . $botones . "</td></tr></table></div>";
    }

    return $html;
}

function detalleNegociosCancelados($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }


    $queEmp = "select id, format(amount_60,2) amount_60, format(payment_60,2) payment_60, format(amount_72,2) amount_72, format(payment_72,2) payment_72, " .
            "format(amount_84,2) amount_84, format(payment_84,2) payment_84, format(amount_96,2) amount_96, format(payment_96,2) payment_96, (format(interest_rate,2)*100) interest_rate " .
            "from sugarcrm.dtnc_detallescancelados a " .
            "where id in (select dtnc_de0d43ados_idb from sugarcrm.dtnc_detancelados_leads_c " .
            "where dtnc_de0855eads_ida in ( select parent_id from sugarcrm.calls a where id = '$idCall' ) )";

    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($queEmp);
    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Plazo / Meses</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto $</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Cuota $</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Tasa %</th>" .
            //"<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
            "</tr>";
    $i = 1;
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>60 - > 1</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["amount_60"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["payment_60"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["interest_rate"] . "</th>" .
                //"<th style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='radio' name='chkData$i' value='1' id='chkData$i' class='negocios'></th>" .
                //"<th style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='radio' name='chkData$i' value='1' id='chkData$i' class='negocios'><input type='radio' name='chkData$i' value='2' id='chkData$i' class='cancelados'><input type='radio' name='chkData$i' value='3' id='chkData$i' class='cancelados'><input type='radio' name='chkData$i' value='4' id='chkData$i' class='cancelados'></th>" .
                "</tr>" .
                "<tr>" .
                "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>72 - > 2</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["amount_72"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["payment_72"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["interest_rate"] . "</th>" .
                //"<th style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='radio' name='chkData$i' value='2' id='chkData$i' class='negocios'></th>" .
                "</tr>" .
                "<tr>" .
                "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>84 - > 3</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["amount_84"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["payment_84"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["interest_rate"] . "</th>" .
                //"<th style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='radio' name='chkData$i' value='3' id='chkData$i' class='negocios' checked></th>" .
                "</tr>" .
                "<tr>" .
                "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>96 - > 4</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["amount_96"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["payment_96"] . "</th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["interest_rate"] . "</th>" .
                //"<th style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='radio' name='chkData$i' value='4' id='chkData$i' class='negocios'></th>" .
                "</tr>" .
                /*
                  .
                  "<tr>" .
                  "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
                  "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>60</th>" .
                  "<th style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='radio' name='chkData$i' value='1' id='chkData$i' class='negocios'></th>" .
                  "</tr>"
                 */
                "<tr>" .
                "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th>" .
                "<th style='border-collapse: collapse; border: solid black 1px; text-align: center;'> <select id='lista' class='lista'><option value='" . $row["amount_60"] . "|" . $row["payment_60"] . "|" . $row["id"] . "' selected='selected' >60 -> 1</option><option value='" . $row["amount_72"] . "|" . $row["payment_72"] . "|" . $row["id"] . "'>72 -> 2</option><option value='" . $row["amount_84"] . "|" . $row["payment_84"] . "|" . $row["id"] . "'>84 -> 3</option><option value='" . $row["amount_96"] . "|" . $row["payment_96"] . "|" . $row["id"] . "'>96 -> 4</option></select> </th>" .
                "</tr>"
        ;
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosRetanqueo($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }


    $queEmp = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, " .
            "source_loan, format(administration_fee,2) administration_fee, format(insurance_fee,2) insurance_fee, " .
            "format(fee_tracking_device,2) fee_tracking_device, b.currency_name_c moneda, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, " .
            "b.seguro_c seguro, b.lojack_c lojack, b.fiador_c fiador, b.marca_c marca, b.anio_c anio, b.remanente_c remanente " .
            "from dtng_detallenegocios a, dtng_detallenegocios_cstm b where a.id = b.id_c and " .
            "id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";

    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($queEmp);
    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>N&uacute;mero Prestamo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto 100&#37;</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa 100&#37;</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Monto 70&#37;</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa 70&#37;</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Saldo actual</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Plazo</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Cargo por Administraci&oacute;n Nuevo</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Cuota de Seguro de Da&ntilde;os</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Cuota de Dispositivo de Rastreo</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posse Seguro</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Lojack</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Fiador</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Anio</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Remanente</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Moneda</th> " .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;
    while ($row = $res->fetch_assoc()) {

        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["source_loan"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_rate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["amount_70"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["rate_70"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'><span id='saldo$i'>" . $row["current_balance"] . "</span></td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["administration_fee"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["insurance_fee"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fee_tracking_device"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["seguro"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["lojack"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fiador"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["remanente"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosExtra($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }


    $queEmp = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, source_loan, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, currency_name_c moneda, " .
            "b.seguro_c seguro, b.lojack_c lojack, b.fiador_c fiador, b.marca_c marca, b.anio_c anio,  b.remanente_c remanente " .
            "from dtng_detallenegocios a, dtng_detallenegocios_cstm b where a.id = b.id_c and " .
            "id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";

    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($queEmp);
    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>N&uacute;mero Prestamo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Plazo</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posse Seguro</th> " .
            //"<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Lojack</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Fiador</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Anio</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Remanente</th> " .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["source_loan"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_rate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["seguro"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["lojack"] . "</td>" .	     
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fiador"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["remanente"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosAlargamiento($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }


    $queEmp = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, source_loan, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, " .
            "format(current_payment,2) current_payment, format(new_payment,2) new_payment, " .
            "new_term, format(administration_fee,2) administration_fee, currency_name_c moneda, " .
            "format(insurance_fee,2) insurance_fee, format(fee_tracking_device,2) fee_tracking_device " .
            "from dtng_detallenegocios a, dtng_detallenegocios_cstm b where a.id = b.id_c and " .
            "id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";

    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($queEmp);
    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Saldo Actual</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Plazo Actual</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Cuota Actual</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Nuevo Plazo</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Cuota de Seguro de Da&ntilde;os</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Cuota de Dispositivo de Rastreo</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";

    $i = 1;
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["current_balance"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["current_payment"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["new_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["insurance_fee"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fee_tracking_device"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosExtraRetanqueo($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }

    $sql = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, source_loan, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, description, " .
            "b.seguro_c seguro, b.lojack_c lojack, b.fiador_c fiador, b.marca_c marca, b.anio_c anio,  b.remanente_c remanente " .
            "from dtng_detallenegocios a,dtng_detallenegocios_cstm b where a.id = b.id_c and id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";
    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($sql);

    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Numero Prestamo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Descripci&oacute;n Negocio</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Plazo</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posse Seguro</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Lojack</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Fiador</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Anio</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Remanente</th> " .
            //"<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;

    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["source_loan"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["description"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_rate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["seguro"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["lojack"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fiador"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["remanente"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosRecompra($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }

    $sql = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, source_loan, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, description, " .
            "b.seguro_c seguro, b.lojack_c lojack, b.fiador_c fiador, b.marca_c marca, b.anio_c anio,  b.remanente_c remanente " .
            "from dtng_detallenegocios a,dtng_detallenegocios_cstm b where a.id = b.id_c and id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";
    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($sql);

    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Numero Prestamo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Descripci&oacute;n Negocio</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Plazo</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posse Seguro</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Lojack</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Fiador</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Anio</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Remanente</th> " .
            //"<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;

    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["source_loan"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["description"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_rate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["seguro"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["lojack"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fiador"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["remanente"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosRecompraExtra($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }

    $sql = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, source_loan, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, description, " .
            "b.seguro_c seguro, b.lojack_c lojack, b.fiador_c fiador, b.marca_c marca, b.anio_c anio,  b.remanente_c remanente " .
            "from dtng_detallenegocios a,dtng_detallenegocios_cstm b where a.id = b.id_c and id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";
    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($sql);

    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Numero Prestamo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Descripci&oacute;n Negocio</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Plazo</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posse Seguro</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Lojack</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Fiador</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Anio</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Remanente</th> " .
            //"<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;

    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["source_loan"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["description"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_rate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["seguro"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["lojack"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fiador"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["remanente"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosRecompraRetanqueo($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }

    $sql = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, source_loan, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, description, " .
            "b.seguro_c seguro, b.lojack_c lojack, b.fiador_c fiador, b.marca_c marca, b.anio_c anio,  b.remanente_c remanente " .
            "from dtng_detallenegocios a,dtng_detallenegocios_cstm b where a.id = b.id_c and id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";
    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($sql);

    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Numero Prestamo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Descripci&oacute;n Negocio</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Plazo</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posse Seguro</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Lojack</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Fiador</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Anio</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Remanente</th> " .
            //"<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;

    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["source_loan"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["description"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_rate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["seguro"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["lojack"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fiador"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["remanente"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosRecompraExtraRetanqueo($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }

    $sql = "select id, format(opportunity_amount,2) opportunity_amount, format(amount_70,2) amount_70, " .
            "concat(format(opportunity_rate,2),'%') opportunity_rate, concat(format(rate_70,2),'%') rate_70, source_loan, " .
            "plate, loan_term, format(current_balance,2) current_balance, order_number, description, " .
            "b.seguro_c seguro, b.lojack_c lojack, b.fiador_c fiador, b.marca_c marca, b.anio_c anio,  b.remanente_c remanente " .
            "from dtng_detallenegocios a,dtng_detallenegocios_cstm b where a.id = b.id_c and id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";
    //echo '$queEmp - > ' . $queEmp . '<br><br>';

    $res = $conexion->query($sql);

    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Numero Prestamo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Descripci&oacute;n Negocio</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Placa Veh&iacute;culo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tasa</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Plazo</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posse Seguro</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Lojack</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Posee Fiador</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Anio</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Remanente</th> " .
            //"<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;

    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["source_loan"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["description"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["plate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_rate"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["loan_term"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["seguro"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["lojack"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["fiador"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["remanente"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

function detalleNegociosUsadosCrediq($idCall) {
    $conexion = new mysqli("10.1.11.221", "root", "Lun3tt3s", "sugarcrm");

    if ($conexion->connect_error) {
        die('Connect Error (' . $conexion->connect_errno . ') '
                . $conexion->connect_error);
    }

    /*
     * Use this instead of $connect_error if you need to ensure
     * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
     */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }

    $sql = "select id, format(opportunity_amount,2) opportunity_amount, " .
            "format(current_balance,2) current_balance, description, " .
            " dui_c, marca_c, tipo_vehiculo_c, anio_desde_c, anio_c, precio_desde_c, procedencia_c, comentario_c, usuario_adicion_c, tipo_solicitud_c " .
            "from dtng_detallenegocios a,dtng_detallenegocios_cstm b where a.id = b.id_c and id in (select dtng_de341ccios_idb from dtng_detenegocios_leads_c " .
            "where dtng_de6ccdeads_ida in ( select parent_id from calls a where id = '$idCall' ) )";


    $res = $conexion->query($sql);

    $html = "<div><table style='border-collapse: collapse; border: solid black 1px;'><tr>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Tipo Vehiculo</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Comentario</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Monto Max</th>" .
            "<th style='border-collapse: collapse;border: solid black 1px; width:100px;'>Cuota Max</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Precio Desde - Hasta</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Anio Desde - Hasta</th>" .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Dui</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Marca</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Tipo Vehiculo</th> " .
            //"<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Procedencia</th> " .
            "<th style='border-collapse: collapse; width:100px; border: solid black 1px;'>Usuario Ingreso</th> " .
            //"<th style='border-collapse: collapse; border: solid black 1px; width:100px;'>Moneda</th>" .
            "<th style='border-collapse: collapse; border: solid black 1px;'>Seleccione </th></tr>";
    $i = 1;

    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $html .= "<tr>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["tipo_solicitud_c"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; '>" . $row["comentario_c"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["current_balance"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["precio_desde_c"] . " - " . $row["opportunity_amount"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["anio_desde_c"] . " - " . $row["anio_c"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["dui_c"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["marca_c"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["tipo_vehiculo_c"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["procedencia_c"] . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: right;'>" . $row["usuario_adicion_c"] . "</td>" .
                //"<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'>" . htmlentities($row["moneda"]) . "</td>" .
                "<td style='border-collapse: collapse; border: solid black 1px; text-align: center;'><input type='checkbox' name='chkData$i' value='$id' id='chkData$i' class='negocios'/>Incluir</td></tr>";
        $i++;
    }
    $html .= "</table></div>";

    return $html;
}

//generarScript();
?>
<html>
    <head>
        <title></title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="../InventarioVehiculos/resources/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="../InventarioVehiculos/resources/js/jquery-ui-1.8.17.custom.min.js" type="text/javascript"></script>
        <script src="../InventarioVehiculos/resources/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
        <link rel="StyleSheet" href="../InventarioVehiculos/resources/css/custom-theme/jquery-ui-1.8.17.custom.css" type="text/css"/>

        <script type='text/javascript'>
            var qst = "<?php echo getNumQuestion(); ?>",
                    id = "<?php echo getId(); ?>",
                    account = "<?php echo getAccount(); ?>",
                    user = "<?php echo getUser(); ?>",
                    name = "<?php echo getNombre(); ?>",
                    mail = "<?php echo getEmail(); ?>",
                    fechaAnterior = "<?php echo getFechaPago(); ?>",
                    tipo = "<?php echo getTipoEncuesta(); ?>";

            if (tipo != "BaseCancOct12") {							//Cambios para Base Octubre.
                tipo = tipo.toString().substring(0, 6);
            }


            function siguiente(obj, next, detalle, opc) {
                var x = 0;
                if (detalle == 1) {
                    if (opc) {
                        for (i = 1; i <= 20; i++) {
                            if ($("#chkData" + i).attr('checked')) {
                                x = x + 1;
                            }
                        }
                    } else {
                        for (i = 1; i <= 20; i++) {
                            $("#chkData" + i).attr('checked', false)
                            x = x + 1;
                        }
                        $(".fechacita").val("");
                        $("#fechacita").val("");
                        $("#fechacita1").val("");
                    }
                } else {
                    x = 1;
                }

                if (x > 0) {
                    $(obj).removeClass("top");
                    $("#div" + next).addClass("top");
                } else {
                    alert("Debe seleccionar al menos un crédito");
                }

            }

            function finalizar() {
                var correo = $(".correo").val(),
                        minutos = $(".minutos").val(),
                        telefono = $(".telefono").val(),
                        lugarcita = $(".lugarcita").val(),
                        referencia = $(".referencia").val(),
                        ciudad = $(".ciudad").val(),
                        agencia = $(".agencia").val();
                lista = $(".lista").val();

                var fecha = $(".fechacita").val();

                if (fecha == "" || fecha == undefined) {
                    fecha = $("#fechacita").val();
                }

                var hora = $(".hora").val();
                if (hora == "" || hora == undefined) {
                    hora = $("#hora").val();
                }

                var minutos = $(".minutos").val();
                if (minutos == "" || minutos == undefined) {
                    minutos = $("#minutos").val();
                }

                var negocios = "";
                for (i = 1; i <= 20; i++) {
                    if ($("#chkData" + i).attr('checked')) {
                        negocios = negocios + $("#chkData" + i).val() + "|";
                    }
                }
                if (negocios == null || negocios == "") {										//Cambios para Base Octubre.
                    negocios = lista;
                }

                //alert(negocios);
                if (fecha == "" || fecha == undefined) {
                    //$("#preguntas").html("<span style='font-size:3em;'>Script Finalizado sin programar cita</span>");
                    //$("#preguntas").html("");
                    var nada = 0;
                }

                var jsonData = {
                    "email": correo,
                    "fecha": fecha,
                    "hora": hora,
                    "minutos": minutos,
                    "id": id,
                    "account": account,
                    "name": name,
                    "user": user,
                    "telefono": telefono,
                    "lugarcita": lugarcita,
                    "referencia": referencia,
                    "ciudad": ciudad,
                    "agencia": agencia,
                    "pais": 14,
                    "negocios": negocios,
                    "tipo": tipo
                };
                $("#preguntas").html('<img src="ajax-loader.gif" width="100" height="100" alt="ajax-loader"/>');
                $.ajax({
                    data: jsonData,
                    type: "POST",
                    dataType: "json",
                    url: "registro.php",
                    success: function(data) {
                        if (data.idCita != "-1") {
                            $("#preguntas").html("<div><span style='font-size:3em;'>Script Finalizado</span><br/><div>Cita programada:<table><tr><td><label>Fecha:</label></td><td>" +
                                    fecha + "</td></tr><tr><td><label>Hora:</label></td><td>" + hora + ":" + minutos + "</td></tr></table></div></div>");
                        } else {
                            $("#preguntas").html("<span style='font-size:3em;'>Script Finalizado con error al programar cita en Las Cascadas</span>");
                        }

                        if (data.idCorreo != "-1") {
                            if (data.idCorreo != "0") {
                                $("#preguntas").append("<div><span style='font-size:3em;'>Se ha registrado el correo</span></div>");
                            } else {
                                $("#preguntas").append("<div><span style='font-size:3em;'></span></div>");
                            }
                        } else {
                            $("#preguntas").append("<div><span style='font-size:3em;'>Error al registrar el correo</span></div>");
                        }

                        if (tipo != 'Recall') {
                            if (data.idContacto != "-1") {
                                $("#preguntas").append("<div><span style='font-size:3em;'></span></div>");
                            } else {
                                $("#preguntas").append("<div><span style='font-size:3em;'>Error al registrar el contacto</span></div>");
                            }

                            if (data.idOportunidad != "-1") {
                                $("#preguntas").append("<div><span style='font-size:3em;'></span></div>");

                            } else {
                                $("#preguntas").append("<div><span style='font-size:3em;'>Error al registrar la oportunidad</span></div>");
                            }
                        }
                    },
                    error: function(data, texto) {
                        $("#preguntas").html("<span style='font-size:3em;'>Script Finalizado con error al programar cita en Las Cascadas: " + texto + "</span>");
                    }
                });

            }

            $(document).ready(function() {

                var questions = [], i;
                $('#preguntas').html('');
                for (i = 0; i < qst; i++) {
                    switch (i) {
                        case 0:
                            questions[i] = "<?php echo generarScript(1); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 1:
                            questions[i] = "<?php echo generarScript(2); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 2:
                            questions[i] = "<?php echo generarScript(3); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 3:
                            questions[i] = "<?php echo generarScript(4); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 4:
                            questions[i] = "<?php echo generarScript(5); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 5:
                            questions[i] = "<?php echo generarScript(6); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 6:
                            questions[i] = "<?php echo generarScript(7); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 7:
                            questions[i] = "<?php echo generarScript(8); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 8:
                            questions[i] = "<?php echo generarScript(9); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 9:
                            questions[i] = "<?php echo generarScript(10); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 10:
                            questions[i] = "<?php echo generarScript(11); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 11:
                            questions[i] = "<?php echo generarScript(12); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 12:
                            questions[i] = "<?php echo generarScript(13); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 13:
                            questions[i] = "<?php echo generarScript(14); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 14:
                            questions[i] = "<?php echo generarScript(15); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 15:
                            questions[i] = "<?php echo generarScript(16); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 16:
                            questions[i] = "<?php echo generarScript(17); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 17:
                            questions[i] = "<?php echo generarScript(18); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                        case 18:
                            questions[i] = "<?php echo generarScript(19); ?>";
                            $('#preguntas').append(questions[i]);
                            break;
                    }
                }
                //alert(htmlData);
                var plazo = "<?php echo getPlazo(); ?>";
                var nombre = "<?php echo getNombre(); ?>";
                var marca = "<?php echo getMarca(); ?>";
                var fechaAnterior = "<?php echo getFechaPago(); ?>";
                var monto = "<?php echo getMonto(); ?>";
                var producto = "<?php echo getProducto(); ?>";
                var cuota = "<?php echo getCuota(); ?>";

                //alert("monto :" + monto);


                $('#div1').addClass('top');

                $(".monto").html(monto);
                $(".nombre").html(nombre);
                $(".marca").html(marca);
                $(".fecha").html(fechaAnterior);
                $(".plazo").html(plazo);
                $(".producto").html(producto);
                $(".cuota").html(cuota);
                $(".correo").val(mail);
                var hora = new Date().getHours(),
                        minutos = new Date().getMinutes();

                $(".fechacita").datepicker({
                    minDate: 0,
                    dateFormat: 'dd/mm/yy'
                });

                /*Esto es para que solo se puede seleccionar un negocio y no ambos en el caso de la campaña combinada*/
                $('.negocios').click(function() {
                    var id = $(this).attr('id');
                    var checked = $('#' + id).attr('checked');
                    if (checked == 'checked') {
                        $('.negocios').removeAttr('checked');
                        $('#' + id).attr('checked', 'checked');
                    }
                });

            });
        </script>
        <style type="text/css">
            .question {
                z-index: 1;
                float: none;
                position: absolute;
                opacity:1;
                -moz-opacity: 1;
                filter: alpha(opacity=100);
                background-color: #ffffff;
                height: 700px;
                width: 900px;
                font-size: 1.2em;
                font-family:  Gill, Helvetica, sans-serif;
            }
            .top {
                z-index: 3000;
            }
            .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
            .ui-timepicker-div dl { text-align: left; }
            .ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
            .ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
            .ui-timepicker-div td { font-size: 90%; }
            .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

            .correo {
                width:300px;
            }
        </style>
    </head>
    <body>
        <div id="preguntas">
        </div>
    </body>
</html>

