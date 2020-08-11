
<?php
$this->load->view('template/inc/header_stripe.php');
?>

<div class="content">
	<div class="container12">
    	<div class="row">
            	<div class="column12">
                <h3>Autolotes Premium<span></span></h3>
                <p class="title-sec">Buscar autolote</p>
                <form id="form1" name="form1" method="post" action="<?php echo base_url(); ?>index.php/autolote/usuarios">
                  <label for="buscar">Buscar</label>
                  <input type="text" name="criterio" id="criterio" />
                  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
                </form>
            </div>
            
            <div class="column12">            	
            	<hr>
                <p><a href="<?php echo base_url(); ?>index.php/autolote/add" class="nuevo">Nuevo</a></p>
                
                
                
                <div class="tabla">
                <table width="100%" cellpadding="0" cellspacing="0">
                	<tr>
                    	<th>Usuario</th>
                        <th>Fecha ingreso</th>
                        <th>Cant. vehiculos</th>
                        <th></th>
                    </tr>
                    <?php
  $ci = &get_instance();
  $ci->load->model("data_model");
  
  if(isset($usuarios)){ 
   $v=1;
 foreach ($usuarios as $usuario) : 
  if($v>2){ $v=1; }
  $cant_vehiculos=$ci->data_model->getDataWhere(array('usuario'=> $usuario['id_usuario']), 'cq_automovil');
   
	if($usuario['primium']=='1'){
	  $text='Quitar';	
	}else{
	  $text='Marcar';
	}	
  ?>
  
  <tr class="t_gris<?php echo $v; ?>">
    <td ><?php echo $usuario['nombres']; ?> <?php echo $usuario['apellidos']; ?></td>
    <td ><?php echo $usuario['fecha_registro']; ?></td>
    <td ><?php echo count($cant_vehiculos); ?></td>
    <td ><a href="<?php echo base_url() ?>index.php/autolote/primium/<?php echo $text; ?>/<?php echo $usuario['id_usuario'] ?>"><?php echo $text; ?> como primium</a></td>
  </tr>
  <?php 
  $v++;
  endforeach; } ?>
                </table> 
                </div>                
            </div>
        </div>
    </div>
</div>



<?php 
if(isset($pagination)){
	echo '<div class="limiter"></div>';
  echo $pagination;
  echo '<div class="limiter"></div>';
}
?>
