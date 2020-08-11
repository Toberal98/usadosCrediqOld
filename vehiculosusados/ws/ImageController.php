<?php
require_once("ImageRestHandler.php");
/*
controls the RESTful services
URL mapping
*/

$imageRestHandler = new ImageRestHandler();
$imageRestHandler->getImageByName($_GET["id"]);

?>