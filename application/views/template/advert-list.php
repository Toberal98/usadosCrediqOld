<?php $moneda=$this->session->userdata('moneda'); ?>
<div id="head-vehiculo">Administrar banners</a></div>
<div style="float: right; margin-right: 50px;"><a href="<?php echo base_url(); ?>index.php/site/advert_crear" class="cabin_red">&nbsp;Nuevo&nbsp;</a></div>
<div class="cabin_blue">Lista de banners</div>
<table width="100%" border="0" id="hor-minimalist-a">
  <tr  class="t-head">
    <td >Nombre</td>
    <td >Posicion</td>
    <td >Hits</td>
    <td >Clicks</td>
    <td >Fin</td>
    <td >Seccion</td>
    <td >Tipo</td>
    <td >Acciones</td>
  </tr>

  <?php
    $v=1;
  if(isset($adverts)){ foreach ($adverts as $advert) : 
  if($v>2){ $v=1; }
  ?>
  <tr class="t_gris<?php echo $v; ?>">
    <td ><?php echo $advert['nombre']; ?></td>
    <td ><?php echo $advert['posicion']; ?></td>
    <td ><?php echo $advert['hits']; ?></td>
    <td ><?php echo $advert['clicks']; ?></td>
    <td ><?php echo $advert['fecha_expiracion']; ?></td>
    <td ><?php echo $advert['seccion']; ?></td>
    <td ><?php echo $advert['tipo']; ?></td>
    <td ><a href="<?php echo base_url() ?>index.php/site/advert_update/<?php echo $advert['id_banner'] ?>">Modificar</a>-
         <a href="<?php echo base_url() ?>index.php/site/advert_borrar/<?php echo $advert['id_banner'] ?>/preguntar">Eliminar</a>
       </td>
  </tr>
  <?php 
  $v++;
  endforeach; } ?>
</table>
<?php 
if(isset($pagination)){
echo '<div class="separator"></div>';
  echo $pagination;
  echo '<div class="separator"></div>';
}
?>
