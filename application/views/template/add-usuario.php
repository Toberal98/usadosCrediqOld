 <!-- Inicio add-producto *********************************************************************************************************************** -->


            <script type="text/javascript">
                var RecaptchaOptions = {
                    theme: 'white',
                    custom_theme_widget: 'recaptcha_widget'
                };
            </script>
            <form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/saveUser" method="post">


                <h2>Registro</h2> 
                <div class="form"> 
                    <label><span>Nombre:</span> <input type="text" name="nombres" id="nombres" data-bvalidator="required" ></label>
                    <label><span>Apellido:</span> <input type="text" name="apellidos" id="apellidos" data-bvalidator="required" ></label>
                    <label><span>Email:</span> <input type="text" name="email" id="email" data-bvalidator="email, required" onBlur="CheckUser();" ></label>
                    <label><span>Teléfono:</span> <input type="text" name="telefono" id="telefono" data-bvalidator="maxlength[8], minlength[8], number, required"></label>

                    <label><span>Marca Favorita:</span> 
                        <select class="cabin_grey" name="marca_favorita" id="marca_favorita" onchange="getModelsRegistro(this.value);" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($marks_registro as $mark): ?>
                                <option value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
                            <?php endforeach ?>
                        </select></label>
                    <label><span>Modelo Favorito:</span><select class="cabin_grey" name="modelo" id="modelo_registro" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                        </select></label>
                    <label><span>Profesión:</span> <select class="cabin_grey" name="profesion" id="profesion" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($profesions_registro as $profesion): ?>
                                <option value="<?php echo $profesion['id_profesion']; ?>"><?php echo $profesion['nombre']; ?></option>
                            <?php endforeach ?>
                        </select></label>
                    <label><span>País:</span> <select class="cabin_grey" name="pais" id="pais" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($paises as $pais): ?>
                                <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                                    <?php echo $pais['nombre']; ?>
                                </option>
                            <?php endforeach ?>
                        </select></label> 
                    <label> <span>Ingresa c&oacute;digo:</span> 
                    <div class="g-recaptcha" data-sitekey="6Lcbny4UAAAAAGmtIQrDGsrMLUanfOD0H7SbwV1Z"></div>
                    <div class="photos mleft-10"></div>
</label> 

                    <div class="clearfix"></div>
                    <label class="condiciones"><input type="checkbox" checked/> Condiciones de uso</label>
                    <label><button type="submit">Enviar</button></label>
                </div>




                
            </form>
            <script type="text/javascript">
                $('#form_reg_user').bValidator();
                $('#form_reg_user').submit(function() {
                    return validarCaptcha();
                });

                function validarCaptcha() {
                    challengeField = $("input#recaptcha_challenge_field").val();
                    responseField = $("input#recaptcha_response_field").val();

                    var htmlC = $.ajax({
                        type: "POST",
                        url: site_root + '/public/aplications/validate.php',
                        data: "recaptcha_challenge_field=" + challengeField + "&recaptcha_response_field=" + responseField,
                        async: false
                    }).responseText;

                    var pattern = /success/i;



                    if (pattern.test(htmlC)) {
                        $("#captchaStatus").html(htmlC);
                        //alert('ttrue');
                        return true;
                    } else {
                        //alert('falsee');
                        $("#captchaStatus").html(htmlC);
                        Recaptcha.reload();
                        return false;
                    }

                }

            </script>


            <!-- FIN add-USUARIO *********************************************************************************************************************** --> 
