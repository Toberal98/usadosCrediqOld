<?php
require_once("SimpleRest.php");

class ImageRestHandler extends SimpleRest {
	
	function getImageByName($id) {	
		//$statusCode = 200;
		//$requestContentType = $_SERVER['HTTP_ACCEPT'];
		//$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$path = 'http://localhost/imagenes/204x137/'.$id;
		//$path = 'http://localhost/imagenes/800x600/'.$id;
		$path_headers = @get_headers($filename);

		/*
		if (file_exists($path)) {
		    echo base64_encode(file_get_contents($path));
		} else {
		    echo $path;
		}
		*/

		if(!($path_headers[0] == 'HTTP/1.0 404 NOT FOUND')){
		    echo base64_encode(file_get_contents($path));
		}else{
		    echo '';
		}
		
		
	}	
	
}	

?>