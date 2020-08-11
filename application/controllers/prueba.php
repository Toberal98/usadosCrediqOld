<?php

echo 'Prueba de Contactlogger';

$data_auto = '2';

$this->load->library('ContactLogger');

        if ($data_auto['tipo_venta'] == '2') {
            $to = 'veh.liquidacion@crediq.com';
            //$this->contactlogger->setSpreadsheetId('1rxkLkWwJhap-pQUS5XHXO-Btyq7jxBLwc4pfzpIFRHc');
            $this->contactlogger->setSpreadsheetId('1RwNSzpAJNDHw0sjM6fEy8XAOgIJAl7acIf83nl_7AAI');
        } else {
            $to = $this->contactlogger->getNextTo();
        }

        $this->contactlogger->addLine('to', 'email', 'button', 'name', 'phone', 'data_auto', 'channel');

?>