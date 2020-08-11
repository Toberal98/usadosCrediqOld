<div id="wrapper"><!-- banner rotador-dinamico(slider) wrapper  -->

                    <div class="slider-wrapper theme-default">
                      <div id="slider" class="nivoSlider">
                        <?php 
						
                        foreach ($banner['imgs'] as $imagen){
                        ?>
                            <img src="<?php echo base_url(); ?>public/publicidad/<?php echo $imagen['imagen']; ?>" alt="baner" />
                        <?php 
                         } 
                        ?>
                      </div>
                    </div>
                    <script type="text/javascript" src="<?php echo base_url() ?>public/js/jquery.nivo.slider.js"></script>
                    <script type="text/javascript">
                        
                          $('#slider').nivoSlider();
                        
                    </script>

</div><!-- fin wrapper banner rotador dinamico -->