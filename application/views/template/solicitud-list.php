
<?php $moneda=$this->session->userdata('moneda'); ?>
<div id="head-vehiculo">Administrar Solicitudes</a></div>
<div class="cabin_blue">Lista de solicitudes</div>
<table border="0" id="hor-minimalist-a">
  <tr class="t-head">
    <td >Nº</td>
    <td >Tipo de ingreso</td>
    <td >Valor del vehiculo</td>
    <td >Destino</td>
    <td >estado</td>
    <td >Acciones</td>
  </tr>

  <?php
  $v=1;
  if(isset($solicitudes)){ foreach ($solicitudes as $sol) :
 if($v>2){ $v=1; }
  
   ?>
  <tr class="t_gris<?php echo $v; ?>">
    <td ><?php echo $sol['id']; ?></td>
    <td ><?php echo $sol['tipo_ingresos']; ?></td>
    <td ><?php echo $sol['valor_vehiculo']; ?></td>
    <td ><?php echo $sol['destino']; ?></td>
    <td ><?php echo $sol['estado']; ?></td>
    <td ><a href="<?php echo base_url() ?>index.php/solicitud/ver/<?php echo $sol['id'] ?>">Ver detalle</a>-
         <a href="<?php echo base_url() ?>index.php/solicitud/rechazar/<?php echo $sol['id'] ?>/preguntar">Rechazar</a>
       </td>
  </tr>
  <?php 
  $v++;
  endforeach; } ?>
</table>
<?php 
if(isset($pagination)){
echo '<div class="limiter"></div>';
  echo $pagination;
echo '<div class="limiter"></div>';  
}
?>
