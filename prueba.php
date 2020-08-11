<?php

echo 'Prueba de Contactlogger';

include 'ContactLogger1.php';


$this->load->library('ContactLogger');
$to = $this->contactlogger->getNextTo();
$this->contactlogger->addLine('to', 'email', 'button', 'name', 'phone', 'data_auto', 'channel');

?>