<script type="text/javascript" src="<?php echo base_url(); ?>public/js/calculadora.js"></script>
<?php $moneda = $this->session->userdata('moneda'); ?>
<!--INI - Modificado por: GGONZALEZ - 25/01/2015 --> 
<div class="column10">
    <!--FIN - Modificado por: GGONZALEZ - 25/01/2015 --> 
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
                <figure> 
               <!--INI - Modificado por: GGONZALEZ - 25/01/2015 -->    
                    
            <a  href="<?php echo base_url() ?>car/ver/<?php echo $car['id_automovil'] . $string; ?>" onclick="event.preventDefault();          
            doClick(<?php echo $car['id_automovil']; ?>)"> 
                <img src="<?php echo base_url(); ?>index.php/ajax/dothums/<?php echo $car['id_automovil']; ?>-1" alt="<?php echo $titulo_auto; ?>"> </a>
                                
                  <!--FIN - Modificado por: GGONZALEZ - 25/01/2015 -->   
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
                    
                     <img width="60" height="60" src="<?php echo base_url(); ?>public/img/recomendado.jpg" alt="Recomendados CrediQ"/>
                </article> 
                              
            </li>
        <?php $i++;endforeach;?>

    </ul>

<?php


 
   if (isset($paginacion)) {
        echo $paginacion;
    }
    ?>
    
<?php

echo "Total de resultados $total_resultados";

if ($total_resultados < 1) {
    echo '<span><h3>No se han encontrado vehiculos con estas caracteristicas!</h3></span>';
}
?>
</div>


