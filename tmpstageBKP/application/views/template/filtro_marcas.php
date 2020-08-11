
<script>
$(document).ready(function() {
    $('.cq-carousel').slick({
        arrows: true,
        slidesToShow: 9,
        infinite: false,
        prevArrow: '<button type="button" class="slick-arrow slick-prev"><span class="fas fa-angle-left"></span></button>',
        nextArrow: '<button type="button" class="slick-arrow slick-next"><span class="fas fa-angle-right"></span></button>'
      });
})
</script>
    <div id="myMarcas" class="row section-marca center-col" style="padding-left:25px; padding-right:25px">
        <div class="cq-carousel">
            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-1 center item" style="padding-left:0; padding-right:0;">
                <div class="container-marca ripple">
                    <center>
                    <h4 class="marca-img animated zoomInUp faster" style="padding-top:28px">TODOS</h4>
                    <input type="radio" name="marca" value="" onclick="filtrarbymarca();">
                    <span></span>
                    </center>
                </div>
            </div>
            <?php 
            foreach ($marcas as $marca):
            ?>
            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1_5 center item" style="padding-left:0; padding-right:0;">
                <div class="container-marca ripple">
                    <center>
                    <img class="marca-img animated zoomInUp faster" src="<?php echo base_url(); ?>imagenes/logos/<?php echo $marca['foto'] ?>" 
                    alt="<?php echo $marca['nombre'] ?>" >
                    <input type="radio" name="marca" value="<?php echo $marca['id_marca']; ?>" onclick="filtrarbymarca();">
                    <span></span>
                    </center>
                </div>
            </div>
            <?php
            endforeach;
            ?>
        </div>
        
    </div>

<!-- SCRIPT JS para refinal la busqueda mediante las marcas -->
<script>
function filtrarbymarca(){
    pagina=0;
    moveToResult(); 
    buscar();
}

</script>