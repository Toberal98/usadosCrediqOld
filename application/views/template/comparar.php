<?php 

           if(isset($error)){
	            $usuario_existe=1;
           }
           if(!isset($total_comparar)){
           	$total_comparar=0;
           }
           
		?>



<div class="contenth1">
	<div class="container12">
    	<div class="row">
			<div class="column12">            	
                            <h1>Comparaci&oacute;n de Veh&iacute;culos <span></span></h1> 
            <p><a  href="<?php echo base_url()?>"class="nuevo">Agregar Nuevo</a></p>
            <div class="tabla">
                <?php 
	$ci = &get_instance();
	$ci->load->model("data_model");	
?>
                <table width="100%" cellpadding="0" cellspacing="0">
                	<tr>
                    	<th width="25%">Característica</th>
                        
                        
                         <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<th>Vehiculo '.$i.'<a href="'.base_url().'index.php/car/removeComparar/'.$car[$i]['id_automovil'].'" class="quitar_com">
		   <img  src="'.base_url().'public/images/quitar_comparar.png" >
		   <a></th>';
       }
    ?>                        
                    </tr>
                    <tr>
                    	<td></td>
                        
                        <?php 		
       for($i=1;$i<=$total_comparar;$i++){
		   //if($v==1){ $t_gris='t_gris'; }else{ $t_gris=''; }
           echo '<td ><a href="" onclick="event.preventDefault()" onmousedown="doClick('.$car[$i]['id_automovil'].')">
		   <img width="99" height="77" src="'.base_url().'index.php/ajax/dothums/'.$car[$i]['id_automovil'].'-3" alt=""></a></td>';
		   }
    ?>
                    </tr>
                    <tr>
                    	<td><strong>Marca</strong></td>
                         <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td><a href="'. base_url() .'index.php/car/ver/'.$car[$i]['id_automovil'].'">'.$car[$i]['marca'].'</a></td>';
       }
    ?>
                    </tr>
                    <tr>
                    	<td><strong>Modelo</strong></td>
                        <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td class="cabin_parrafo">'.$car[$i]['modelo'].'</td>';
       }
    ?>
                    </tr>
                    <tr>
                    <td><strong>Año</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td>'.$car[$i]['year'].'</td>';
       }
    ?>
    
  </tr>
  <tr>
    <td><strong>Precio</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td>'.$car[$i]['precio'].'</td>';
       }
    ?>
    
  </tr>
  <tr>
    <td><strong>Combustible</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td>'.$car[$i]['tipo_comb'].'</td>';
       }
    ?>
    
  </tr>
  <tr>
    <td><strong>Transmision</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td>'.$car[$i]['tipo_transmision'].'</td>';
       }
    ?>
    
  </tr>
  <tr>
    <td><strong>Kilometraje</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td>'.$car[$i]['kilometraje'].' kms.</td>';
       }
    ?>
    
  </tr>
  <tr >
    <td ><strong>Puertas</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td >'.$car[$i]['numero_puertas'].'</td>';
       }
    ?>
    
  </tr>
  <tr >
    <td ><strong>Motor</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td >'.$car[$i]['capacidad_de_motor'].'</td>';
       }
    ?>
    
  </tr>
  <tr >
      <td ><strong>Traccion</strong></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<td >'.$car[$i]['traccion'].'</td>';
       }
    ?>
    
  </tr>
                </table>
                
                
                
                
                <table width="100%" cellpadding="0" cellspacing="0">
                	<tr>
                    	<th width="25%">Equipamiento</th>
                                          <?php 
       for($i=1;$i<=$total_comparar;$i++){
           echo '<th></th>';
       }
    ?>  
                        
                    </tr>
                    
                      <?php 
  foreach($equipamiento_list as $lista_equipo){ 
	
  ?>
  
  <tr>
    <td ><?php echo $lista_equipo['nombre']; ?></td>
    <?php 
       for($i=1;$i<=$total_comparar;$i++){
		   
		   $equipo=$ci->data_model->GetEquipo($car[$i]['id_automovil'],$lista_equipo['id_eq']);
		   
		   if(count($equipo)>=1){
			   	$img='<img src="'.base_url().'public/img/check.png">';
			}else if(count($equipo)==0){
				$img='<img src="'.base_url().'public/img/cross.png">';
			}
		   
           echo '<td >'.$img.'</td>';
       }
    ?>

  </tr>
 <?php
 	
 	
  } 
 ?>
                </table>
            </div>
                       
            </div>
        </div>
            
            
       <?php if(isset($mostrar) && $mostrar>0){     ?>
            <div class="row">
			<div class="column12">       
                        
                         <h3>Otros vehiculos Navegados<span></span></h3>
                        

<form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/saveUser" method="post" >

</form>
<div>
<?php
//echo '<br/> total vistos mostrar='.$vistos_mostrar;

 for($i=1;$i<=$mostrar;$i++){
          echo '<div >
                    <div >
                        <img src="'.base_url().'index.php/ajax/dothums/'.$car_visto[$i]['id_automovil'].'-2" alt="">
                        <a href="'.base_url().'index.php/car/comparar/'.$car_visto[$i]['id_automovil'].'"><img src="'.base_url().'public/images/adicionar.png"></a>
                    </div>
                    <div >
                        <li>'.$car_visto[$i]['marca'].'</li>
                        <li>'.$car_visto[$i]['modelo'].'</li>
                        <li>precio:'.$moneda.$car_visto[$i]['precio'].'</li>
                    </div>

                </div>';
          //echo '<br/>valor de i'.$i;
  }

  
//echo $mostrar;

  ?>
</div>
                         
                         
                         
                        
                        
                        </div>
</div>
            
       <?php }   ?>
            
            

    </div>
</div>







