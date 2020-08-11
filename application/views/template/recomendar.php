<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.bvalidator.js"></script>



<div class="input"> 

<div class="close"></div>
    
    <div id="master">
    
    <div class="term_title">Términos y Condiciones</div>
     	• El REFERENTE es sujeto del premio única y exclusivamente cuando su REFERIDO haya escriturado el préstamo con CrediQ o tomado el seguro con QUALITY ASSURANCE respectivamente y dentro del período de vigencia del programa.<br /> 
		• Compensación aplica por créditos desde $5,000.00 <br />
		• Aplica la restricción en política que son para vehículos usados con antigüedad no mayor a 10 años, de marcas y modelos aprobados de acuerdo a la aceptación de CREDIQ y/o QUALITY ASSURANCE respectivamente. <br />
		• Es responsabilidad del REFERENTE llamar al call center de CrediQ para registrarse y referir a posibles clientes.<br /> 
		• El REFERENTE poseerá un código en los sistemas de CREDIQ y/o QUALITY ASSURANCE respectivamente, que lo identifique para seguimiento de su acreditación de premios.<br />
		• CREDIQ y/o QUALITY ASSURANCE respectivamente se comunicará con el referente para informarle si su referido se ha convertido en cliente CREDIQ y por lo tanto acreedor del premio.<br />
		• El pago del premio será una semana después de escriturado el préstamo con CrediQ o tomado el seguro con QUALITY ASSURANCE.<br />
		• No participan de este programa los ejecutivos de CREDIQ y QUALITY ASSURANCE.<br />
		• Vigencia: del 1 de Septiembre al 31 de Octubre de 2012.<br />
    </div>
    
</div>

<div id="overlay"></div>




<div class="red_title" >Promociones</div>
<br />
<span class="cabin_blue">Refiere a un amigo</span>
<div class="separator"></div>

<div id="reco_wrap">

<div><!-- wrap_terminos ****************************** -->

	<div class="l_cond">
    	Refiérenos un cliente nuevo y CrediQ te premiará con dinero en efectivo<br>
		* Crédito con seguro $40.00<br>
		* Crédito sin seguro $20.00<br>
		* Seguro $10.00
    </div>
    
    <div class="pwdname" id="comentario_tag">Terminos y condiciones</div>
    
    
    
	<div class="clear_0"></div>
</div><!-- ***************************************** -->

<form name="form1" id="form1" method="post" action="<?php echo base_url() ?>index.php/savedata/saveRec">
	<div id="reco_title">Referir para &nbsp;&nbsp;&nbsp;
	  
	    <input type="radio" name="tipo" id="tipo" value="credito" data-bvalidator="required">
	    <label for="referir_para">Crédito</label>
        <input type="radio" name="tipo" id="tipo" value="seguro" data-bvalidator="required">
	    <label for="referir_para">Seguro</label>
      
	</div>
  <div id="reco_body">
  
	  <div id="reco_izq">
        <img src="<?php echo base_url() ?>public/images/vig.png"> Cliente referido
        <div class="clear_0"></div>
        	 
        	<input name="nombre" type="text" data-bvalidator="required">
            <label>Nombre&nbsp;<br />(Segun DUI)&nbsp;</label>
            <div class="clear_0"></div> 
            
            
        	<input name="dui" type="text" data-bvalidator="number, required">
            <label>DUI&nbsp;</label>
            <div class="clear_0"></div>
             
           
        	<input name="nit" type="text" data-bvalidator="number, required">
             <label>NIT&nbsp;</label>
            <div class="clear_0"></div> 
            
            
        	<input name="telefono" type="text" data-bvalidator="maxlength[8], minlength[8], number, required">
            <label>Telefono&nbsp;</label>
            <div class="clear_0"></div>
            
        	<label style="float:left" for="referir_para">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vehiculo&nbsp;</label>
        
            <label style="float:left"><input type="radio" name="vehiculo" value="nuevo" id="vehiculo" data-bvalidator="required">Nuevo</label>
              
            <label style="float:left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="vehiculo" value="usado" id="vehiculo"data-bvalidator="required">Usado</label>
              
        
  		</div><!-- fin recon izq -->
        
        
        <div id="reco_izq">
        <img src="<?php echo base_url() ?>public/images/vig.png"> Referido por
        <div class="clear_0"></div>
        	 
        	<input name="from_nombre" type="text" data-bvalidator="required">
            <label>Nombre&nbsp;<br />(Segun DUI)&nbsp;</label>
            <div class="clear_0"></div> 
            
            
        	<input name="from_dui" type="text" data-bvalidator="number, required">
            <label>DUI&nbsp;</label>
            <div class="clear_0"></div>
             
           
        	<input name="from_nit" type="text" data-bvalidator="number, required">
             <label>NIT&nbsp;</label>
            <div class="clear_0"></div> 
            
            
        	<input name="from_telefono" type="text" data-bvalidator="maxlength[8], minlength[8], number, required">
            <label>Telefono&nbsp;</label>
            <div class="clear_0"></div>
            
        	<input name="from_email" type="text" data-bvalidator="email, required">
            <label>E-mail&nbsp;</label>
            <div class="clear_0"></div>
              
        
  		</div><!-- fin recon izq -->
       
   
  </div>
  <div class="clear_0"></div>
  <div id="reco_footer">
  		<br/>
        <br/>
        <br/>
        <div class="clear_0"></div>
 		 <input class="reco_enviar" name="enviar" type="submit" value="Enviar">
  </div>
</form>
<script type="text/javascript">
	$('#form1').bValidator();
</script>
</div>
