<script type="text/javascript">
  var onloadCallback = function() {
    alert("grecaptcha is ready!");
  };
</script>

<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
$this->load->view('template/inc/header_stripe.php');
?>

<div class="contenth1">
    <div class="container12">
        <div class="row">
            <div class="column4"><img src="<?php echo base_url(); ?>public/img/woman.jpg" alt=""/></div>
            <div class="column8">





                <form id="form1" onsubmit="return checkCaptcha()" accept-charset="utf-8" action="<?php echo base_url() ?>index.php/site/remakeClave" enctype="multipart/form-data" method="post" >
                    <h1>Recuperar Clave<span></span></h1>
                    <div class="formDatos">
                        <label><span>Correo Electr&oacute;nico*:</span> <input type="text" name="email" id="email" data-bvalidator="email, required" /></label>
                        <label>
                        <div class="g-recaptcha"  data-callback="recaptchaCallback" data-sitekey="6LffiC4UAAAAAIdcOIqQ9R5qgQ0CyGUkXUoGnBye"></div>
                        </label>
                        <label><button id="SubmitBtn" type="submit">Enviar</button></label>
                        <br/>
                        <div class="clear_0"></div>

                        <div class="separator">&nbsp;</div>
                    </div>
                </form>
            </div>
        </div>
    </div>        
</div>



<script type="text/javascript">
        let response = grecaptcha.getResponse();
        console.log(response);
        /*
        if(response){
            alert('true');
            //return validarCaptcha();
        }else{
            alert('false');
        }
        */
    //$('#form1').bValidator();

    function checkCaptcha(){
        let response = grecaptcha.getResponse();
        console.log(response);
        response ? submit() : checkStatus();
    }
    function submit(){
        $('#form1').submit(function() {       
        });   
    }
    /*
    $('#form1').submit(function() {
        var isCaptchaChecked = (grecaptcha && grecaptcha.getResponse().length !== 0);
        console.log(isCaptchaChecked);
        return false;
        
    });
    */
    function checkStatus(){
        alert('¡Por favor verifica el captcha para continuar!');
        event.preventDefault();
    }
    function validarCaptcha() {
        //challengeField = $("input#recaptcha_challenge_field").val();
        //console.log(challengeField);
        //responseField = $("input#recaptcha_response_field").val();
        //console.log(responseField);
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