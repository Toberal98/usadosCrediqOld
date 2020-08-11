
<?php
$enlace = mysql_connect("localhost", "root", "Tr0mp3ta");
if (!$enlace) {
    die("No pudo conectarse: " . mysql_error());
}
printf("Versión del servidor MySQL: %s\n", mysql_get_server_info());

echo php_info();

?>
