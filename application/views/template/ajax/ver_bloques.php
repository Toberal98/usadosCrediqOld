<script type="text/javascript" src="<?php echo base_url(); ?>public/js/calculadora.js"></script>
<?php $moneda = $this->session->userdata('moneda'); ?>



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
             //echo "recomendado:".$car['recomendado'];

            ?>

            <li>
                <figure><?php if ($car['certificado'] ==1 ): ?><div class="certificated"></div><?php elseif ($car['recomendado'] ==1 ): ?><div class="recomendado"></div><?php endif ?><a  href="<?php echo base_url() ?>car/ver/<?php echo $car['id_automovil']; ?>" onclick="event.preventDefault();

                        doClick(<?php echo $car['id_automovil']; ?>)">
                        <img src="<?php echo base_url(); ?>index.php/ajax/dothums/<?php echo $car['id_automovil']; ?>-1" alt="<?php echo $titulo_auto; ?>">

                    </a>
                </figure>

                <article>
                    <p class="title"><?php echo $car['nombre_marca'] . ' '; ?> <?php if(strlen($car['modelo'])>15) {echo substr($car['modelo'],0,15)."..." ;} else{ echo $car['modelo'];} ?></p>
                    <!--em><?php echo $car['id_automovil'];?></em-->
                    <p class="desc"> <?php
                        echo $car['year'] . ' / ';
                        if ($car['kilometraje'] != "" and $car['kilometraje'] != "0") {
                            echo number_format($car['kilometraje']) . ' Km / ';
                        } else {
                            echo " / ";
                        } echo $car['tipo_comb'];
                        ?> </p>
                </article>
                <div class="bottom">
                    <?php if ($car['tipo_venta'] == '1'): ?>
                        
                        <?php if($car['aplica_renting'] == "si"): ?>
                        
                        <p class="price">Cuota desde: <?php echo $moneda . $car['cuota_renting']; ?>
                            	<em><br></em>
				<em><br></em>	 
                        </p>

                        <?php else: ?>   

                        <p class="price">Cuota desde: <?php echo $moneda . $car['cuotaMin']; ?><br/>
                            <em>Precio: <?php echo $moneda . number_format($car['precio'], 2, ".", ","); ?> </em>
                            <em>* Cuota no incluye seguros.</em>
                        </p>

                        <?php endif; ?>

                    <?php elseif ($car['tipo_venta'] == '2'): ?>
                        <p class="price">Precio base: <?php echo $moneda . number_format($car['precio'], 2, ".", ","); ?></p>
                    <?php elseif ($car['tipo_venta'] == '3'): ?>
                        <p class="price">Oferta mínima: <?php echo $moneda . number_format($car['precio'], 2, ".", ","); ?></p>
                    <?php endif; ?>
                </div>
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
