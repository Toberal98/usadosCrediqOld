<style>
    #hide{ visibility: hidden;}
    
   
</style>


<script type="text/javascript" src="<?php echo base_url(); ?>public/js/calculadora.js"></script>



<?php $moneda = $this->session->userdata('moneda'); ?>


<div id="hide">

    <label for="year" class="year"> <input type="hide" id="year" readonly /> </label>               
    <div id="slider-range-year" class="slider-range" ></div>
    
   <?php 
    if ($this->session->userdata('pais') == 1) {  
	
		$pais_amount= 1;      
        ?>
   
    <label for="hasta" class="amount" > <input type="hide" id="amount" readonly /> </label>               
   <div id="slider-range-amount" class="slider-range"></div> 
   
    <?php  }
    elseif ($this->session->userdata('pais') == 2) {   
    
		$pais_amount= 2;
	
     ?>
   
    <label for="hasta" class="amountcr"> <input type="hide" id="amountcr" readonly /> </label>               
   <div id="slider-range-amount-cr" class="slider-range"></div>
   
    <?php  }
    elseif ($this->session->userdata('pais') == 3) {   
    
		$pais_amount= 3;
     ?>
   
   <label for="hasta" class="amounthn" >  <input type="hide" id="amounthn" readonly /> </label>               
   <div id="slider-range-amount-hn" class="slider-range"></div>
   
   <?php  }   
    
     ?>
  </div>

<div class="column10">
    <ul class="car-list">

        <?php
        $id_css = "";
        $i = 1;
        foreach ($products as $car):

            if ($car['certificado'] == 1) {
                $id_css = 'premium';
            } else {
                $id_css = '';
            }

            if ($car['usuario'] == '1' or $car['nombre_usuario'] == "") {
                $titulo_auto = $car['nombre_marca'];
            } else {
                $titulo_auto = $car['nombre_usuario'];
            }
            ?>

            <li>
                <figure><img src="<?php echo base_url(); ?>index.php/ajax/dothums/<?php echo $car['id_automovil']; ?>-1" alt="<?php echo $titulo_auto; ?>">                        
                   
                </figure>
                <article>
                    <p class="title"><?php echo $car['nombre_marca'] . ' '; ?> <?php echo $car['modelo'] ?></p>
                    <!--em><?php echo $car['id_automovil'];?></em-->
                    <p class="desc"> <?php
                        echo $car['year'] . ' / ';
                        if ($car['kilometraje'] != "" and $car['kilometraje'] != "0") {
                            echo number_format($car['kilometraje']) . ' Km / ';
                        } else {
                            echo " / ";
                        } echo $car['tipo_comb'];
                        ?> </p>
                    
                    <img width="60" height="60" src="<?php echo base_url(); ?>public/img/vendido.jpg" alt=""/>
                </article>                
            </li>
        <?php $i++;endforeach;?>

    </ul>
<?php
    if (isset($paginacion)) {
        echo $paginacion; 
         
    }
   
    echo "Total de resultados $total_resultados";
    ?>
   
  <div id="loading">
        <img src="<?php echo base_url(); ?>public/images/enviando.gif" width="32" height="32" alt="enviando formulario" class="flotar" />
        <div id="enviando">Buscando...</div>
    </div>
      
    <form id="principal" action="<?php echo base_url(); ?>" method="Post">
    
</form>
    
   
<script>

    $('#loading').hide();
</script>


    
<?php



if ($total_resultados < 1) {
    echo '<span><h3>No se han encontrado vehiculos con estas caracteristicas!</h3></span>';
}


?>
</div>
