
<?php 

 /*MODIFICADO POR GGONZALEZ - 22/05/2015 - INI*/
if($numAgencia==1)
{
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:558px;width:800px;"><div id="gmap_canvas" style="height:558px;width:800px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type="text/javascript"> function init_map() {var myOptions = {zoom: 18, center: new google.maps.LatLng(13.682948826961205, -89.22658272485353), mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map, position: new google.maps.LatLng(13.682948826961205, -89.22658272485353)});infowindow = new google.maps.InfoWindow({content: "<b>CrediQ</b><br/>Boulevard Los Pr&oacute;ceres, Calle los Heroes<br/> San Salvador"});google.maps.event.addListener(marker, "click", function() {infowindow.open(map, marker);});infowindow.open(map, marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
    

<?php
}
if($numAgencia==2){
?>    
    
    
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:558px;width:800px;"><div id="gmap_canvas" style="height:558px;width:800px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:16,center:new google.maps.LatLng(13.683462174110344,-89.2261492141472),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(13.683462174110344, -89.2261492141472)});infowindow = new google.maps.InfoWindow({content:"<b>CrediQ</b><br/>Boulevard Los Pr&oacute;ceres, contiguo a Dollar City, San Salvador<br/> San Salvador" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
<?php }
if($numAgencia==3){
?>    
    
    
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:558px;width:800px;"><div id="gmap_canvas" style="height:558px;width:800px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:16,center:new google.maps.LatLng(14.076886, -87.183727),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(14.076886, -87.183727)});infowindow = new google.maps.InfoWindow({content:"<b>CrediQ</b><br/>Boulevar Centro América, Frente a Plaza Miraflores Tegucigalpa M.D.C<br/> Honduras" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>

<?php }

if($numAgencia==4){
?>    
    
    
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:558px;width:800px;"><div id="gmap_canvas" style="height:558px;width:800px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:16,center:new google.maps.LatLng(9.949575, -84.098482),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(9.949575, -84.098482)});infowindow = new google.maps.InfoWindow({content:"<b>CrediQ</b><br/>Contiguo a la Plaza de La Uruca, San José, Costa Rica<br/> Costa Rica" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>

<?php }
 /*INI - Modificado por: GGONZALEZ - 30/08/2016 */    
if($numAgencia==5){
?>    
    
    
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:558px;width:800px;"><div id="gmap_canvas" style="height:558px;width:800px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:16,center:new google.maps.LatLng(9.949575, -84.098482),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(13.6828592,-89.2287747)});infowindow = new google.maps.InfoWindow({content:"<b>Autolote Durazno</b><br/>Avenida Las Amapolas y Calle Los Duraznos,  Frente a talleres de Nissan, San Salvador<br/> El Salvador" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>

<?php }
/*FIN - Modificado por: GGONZALEZ - 30/08/2016 */   

 /*MODIFICADO POR GGONZALEZ - 22/05/2015 - FIN*/
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Usados CrediQ® |Agencia Boulevard Los Próceres" ?></title>
</head>

<body>
</body>
</html>
