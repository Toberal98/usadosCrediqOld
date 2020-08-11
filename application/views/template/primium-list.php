<?php $moneda=$this->session->userdata('moneda'); ?>
<div id="head-vehiculo">Premium</a></div>
<div class="cabin_blue">Lista de vehiculos </div>
  <?php
  if(isset($cars)){ foreach ($cars as $car) : ?>
<table width="683" height="130" border="0" cellpadding="0" cellspacing="0" class="cabin_gray_12">
  <tr>
    <td width="133" height="97"><a href="index.php/car/ver/<?php $car['id_automovil']; ?>"><img src="<?php echo base_url(); ?>index.php/ajax/dothums/<?php echo $car['id_automovil']; ?>-2"></a></td>
    <td width="105">
    <strong>Marca:</strong> <?php echo $car['nombre_marca']; ?><br/>
    <strong>Modelo:</strong> <?php echo $car['modelo']; ?> <br/>
    <strong>Año:</strong> <?php echo $car['year']; ?><br/>
    </td>
    <td width="106">
    <strong>Color:</strong><?php 
	$ci = &get_instance();
	$ci->load->model("data_model");
	 
	$color_vehiculo=$ci->data_model->getColorExterior($car['color_externo']); 
	echo $color_vehiculo['nombre'];
	?>
    <br />
    <strong>Precio:</strong> <?php echo $car['precio']; ?><br />
    <strong>Tipo vehiculo:</strong> <?php 
	 
	 
	 
	 $tipo_vehiculo=$ci->data_model->getTipoVehiculo($car['tipo_vehiculo']);
	 
	 echo $tipo_vehiculo['nombre'];
	 
	 
	?><br />
    </td>
    <td width="315">Descripcion: <?php echo $car['descripcion']; ?></td>
  </tr>
  <tr>
    <td height="23" colspan="4">
    <?php if($car['certificado']=='0'){ ?>
    
    <a href="<?php echo base_url() ?>index.php/savedata/marcar/<?php echo $car['id_automovil']; ?>">Marcar como premium</a>
    
    <?php } else{ ?>
	<a href="<?php echo base_url() ?>index.php/savedata/desmarcar/<?php echo $car['id_automovil']; ?>">Quitar premium</a>
	<?php 
		
		} 
	?>
    </td>
  </tr>
</table>
<div class="separator"></div>
  <?php endforeach; } ?>

<p>
  <?php 
if(isset($pagination)){

  echo $pagination;
}
?>
</p>
