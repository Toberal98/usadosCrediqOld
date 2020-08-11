<?php 
$c='checked="checked"';
$s='selected="selected"';

if($this->session->userdata('solicitante')){
	$d= $this->session->userdata('solicitante');
}


	
?>
<?php
//echo '<!-- ********************************************* count '.count($car).' -->';
?>
<form id="form111" name="form111" method="post" action="<?php echo base_url()?>index.php/solicitud_save/process_solicitud/" >
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/actions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/add-producto.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.bvalidator.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.form.js"></script>

<div id="head-vehiculo">Solicitud de Credito</div>
<div class="separator_fields"></div>
<span class="cabin_blue">Informacion del solicitante </span>
<div class="clear_10"></div>

<div class="info_credito">

<span class="cabin_blue">Tipo de cliente</span>
<div>
  
  		<div>
        <label>Ingreso Exacto: </label><!-- ancho 150 -->	
   		<input type="text" name="ingreso" id="ingreso"  data-bvalidator="number,required" /><!-- ancho 300 -->	
  		</div>
        <div class="clear_0"></div>
        <div>
        <label>*Comisiones(*): </label>
  		<input type="text" name="comisiones" id="comisiones"  data-bvalidator="number,required" />
        </div> 
        <div class="clear_0"></div>
        <span class="nota">*No son tomados en cuenta: bonificaciones, horas extras u otras. (Aplica únicamente personal  de venta).</span>
        <br/>
        <br/>   
  </div>
 	<div>
<div>
        	<label>Tipo de Ingresos: </label><!-- ancho 150 -->	
 
            <select name="tipo_ingresos" id="tipo_ingresos" onchange="ingresos(this.value)">
          		<option>-Seleccione-</option> 
  		  		<option value="Asalariado"  >Asalariado</option>
  		  		<option value="Profesional" >Profesional Independiente</option>
                <option value="Jubilado"  >Jubilado</option>
                <option value="Mypime"  >Mypime</option>
                <option value="Empresas"  >Empresas</option>
        	</select>
        </div>
        	     
	</div>
    <div class="clear_0"></div>
  	<div class="asalariado" style="display:none;"><!-- Asalariado -->
  
  		<div>
        	<label>Cotiza Seguro Social: </label>
   			<input type="radio" name="seguro" id="seguro" value="seguro"  />	
  		</div>
        <div class="clear_0"></div>
        <div>
        	<label>No Cotiza Seguro Social : </label>
        	<input type="radio" name="seguro" id="seguro" value="no" class="asa_no_seguro" />
        </div>
           
    </div>
    
    <div class="profesional" style="display:none;"><!-- 	Profesional Independiente -->
  <div class="clear_0"></div>
  		<div>
        	<label>Cotiza AFP: </label>	
   			<input type="radio" name="seguro" id="seguro" value="AFP" />
  		</div>
        <div class="clear_0"></div>
        <div>
        	<label>Declaración de Renta: </label>
        	<input type="radio" name="seguro" id="seguro" value="Renta" />	
        </div>
        <div class="clear_0"></div>
        <div>
        	<label>Ambas: </label>
        	<input type="radio" name="seguro" id="seguro" value="AFP y Renta" />
        </div>
           
    </div>
    
    <div class="jubilado" style="display:none;"><!--	jubilado -->
  
  		<div>
        	<label>Cotiza Seguro Social: </label>
   			<input type="radio" name="seguro" id="seguro" value="seguro" />	
  		</div>
        <div class="clear_0"></div>
        <div>
        	<label>No Cotiza Seguro Social: </label>
        	<input type="radio" name="seguro" id="seguro" value="no" class="asa_no_seguro2" />
        </div>
           
    </div>
    <br />
    <script>
    	$(document).ready(function() {
			
			$(".asa_no_seguro").click(function() {
  				alert("Lo sentimos el tramite lo debe hacer directamente en nuestras oficinas");
			});

			$(".asa_no_seguro2").click(function() {
  				alert("Lo sentimos el tramite lo debe hacer directamente en nuestras oficinas");
			});
			
		});
    </script>
    
    
    <div class="clear_0"></div>
  <span class="cabin_blue">Informacion laboral</span><!-- lugar de trabajo ************************************************************************************************* -->
  <br />
	<div class="asalariado" style="display:none;"><!--	asalariado -->
  
  		<div>
        	<label>Lugar de Trabajo según taco del ISSS: </label>
   			<input type="text" name="trabajo" id="trabajo" value="" />	
  		</div>
        <div class="clear_0"></div>
        <div>
        	<label>Direccion del Trabajo: </label>	
        	<input type="text" name="direccion_trabajo" id="direccion_trabajo" data-bvalidator="required" />	
        </div>
        <div class="clear_0"></div>
        <div>
        <?php 
		$mes['1']='Enero';
		$mes['2']='Febrero';
		$mes['3']='Marzo';
		$mes['4']='Abril';
		$mes['5']='Mayo';
		$mes['6']='Junio';
		$mes['7']='Julio';
		$mes['8']='Agosto';
		$mes['9']='Septiembre';
		$mes['10']='Octubre';
		$mes['11']='Noviembre';
		$mes['12']='Diciembre';
		?>
        <label>Fecha de Ingreso a la empresa: </label>
            	
        	<select name="asa_dia" id="asa_dia" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-dia-</option> 
  		  		<?php for($i=1;$i<=31;$i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
        	</select>	
            <select name="asa_mes" id="asa_mes" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-mes-</option> 
  		  		<?php for($i=1;$i<=12;$i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $mes[$i]; ?></option>
                <?php } ?>
        	</select>	
            <select name="asa_year" id="asa_year" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-año-</option> 
                <?php  for($i=date('Y');$i>=date('Y')-50;$i--){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
  		  		
        	</select>
        </div>   
        <div class="clear_0"></div>
        <div>
        		<label>Egresos Mensuales: </label>
        		<input type="text" name="egresos" id="egresos" />	
        </div>
        
   </div>
   
   <div class="profesional" style="display:none;"><!--	profesional -->
   		<label>Tipo de Profesión : </label>	
   		<select name="profesion" id="profesion">
          		<option>-profesion-</option> 
  		  		<option value="Abogado">Abogado</option>
                <option value="Medico">Medico</option>
                <option value="Ingeniero Civil">Ingeniero Civil</option>
                <option value="Arquitecto">Arquitecto</option>
                <option value="Ingeniero Industrial">Ingeniero Industrial</option>
                <option value="Ingeniero Mecánico">Ingeniero Mecánico</option>
                <option value="Administrador de Empresas">Administrador de Empresas</option>
                <option value="Agrónomo">Agrónomo</option>
                <option value="Economista">Economista</option>
                <option value="Consultor">Consultor</option>
                <option value="Empresario">Empresario</option>
                <option value="Comerciante">Comerciante Negocio Propio</option>
                <option value="Estudiante">Estudiante </option>
                <option value="Ama de Casa">Ama de Casa</option>
        </select>
   <div>
   <div class="clear_0"></div>
        <label>Fecha de Inicio: </label>
            	
        	<select name="pro_dia" id="pro_dia" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-dia-</option> 
  		  		<?php for($i=1;$i<=31;$i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
                
        	</select>
            	
            <select name="pro_mes" id="pro_mes" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-mes-</option> 
  		  				<?php for($i=1;$i<=12;$i++){ ?>
                		<option value="<?php echo $i; ?>"><?php echo $mes[$i]; ?></option>
                		<?php } ?>
        	</select>	
            
            <select name="pro_year" id="pro_year" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-año-</option> 
                <?php  for($i=date('Y');$i>=date('Y')-50;$i--){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
  		  		
        	</select>
        </div>	
   </div>
   
   <div class="jubilado" style="display:none;"><!-- jubilado -->
   		<div>
        	<label>Lugar de Trabajo según taco del ISSS: </label>
   			<input type="text" name="j_trabajo" id="j_trabajo" value="" />	
  		</div>
        <div class="clear_0"></div>
        <div>
        
        	<label>fecha_jubilacion: </label>
   			<select name="j_dia" id="j_dia" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-dia-</option> 
  		  		<?php for($i=1;$i<=31;$i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
        	</select>	
            <select name="j_mes" id="j_mes" onchange="ingresos(this.value)" style="width:65px;"> 
  		  		<option>-mes-</option> 
  		  				<?php for($i=1;$i<=12;$i++){ ?>
                		<option value="<?php echo $i; ?>"><?php echo $mes[$i]; ?></option>
                		<?php } ?>
        	</select>	
            <select name="j_year" id="j_year" onchange="ingresos(this.value)" style="width:65px;">
          		<option>-año-</option> 
                <?php  for($i=date('Y');$i>=date('Y')-50;$i--){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
  		  		
        	</select>	
  		</div>
   </div>
   
<div class="clear_0"></div>
        <div class="cargo">
        		<div>
        				<label>Cargo que desempeña: </label>	
        				<input type="text" name="cargo" id="cargo" value="" />	
       			 </div>	
                 <div class="clear_0"></div>

        		<div>
        				<label>Teléfono de Trabajo: </label>	
        				<input type="text" name="telefono_tra" id="telefono_tra" value="" data-bvalidator="maxlength[8], minlength[8], number, required" />	
        		</div>		   
    	</div>
    
  
    
 <div class="clear_0"></div>
 <span class="cabin_blue">Monto solicitado</span><!-- Monto solicitado ************************************************************************************************* -->
 				<div>
        				<label>Destino: </label>	
        				<select name="destino" id="destino" style="float:left" data-bvalidator="required">
          					<option>-seleccione-</option> 
  		  					<option value="Vehículo nuevo">Vehículo nuevo</option>
                			<option value="Vehículo usado">Vehículo usado</option>
        				</select>	
       			 </div>	
                 
				<div class="clear_0"></div>
        		<div>
                		<script>
                        $(document).ready(function(){
							$('#prima_min').val()
							
							var valor_v;
							var prima_min;
							var valor_financiar;
							
							valor_v=$('#valor_v').val();
							prima_min=valor_v * 0.30;
							valor_financiar=valor_v-prima_min;
							
							
							$('#prima_min').val(prima_min);
							$('#valor_financiar').val(valor_financiar);
							
						});
                        </script>
        				<label>Valor del Vehículo: </label>	
        				<input type="text" name="valor_v" id="valor_v" data-bvalidator="number,required" value="<?php if(isset($car['precio'])){ echo $car['precio']; } ?>" />	
        		</div>	
                <div class="clear_0"></div>
                <div>
        				<label>Prima Mínima: </label>	
        				<input type="text" name="prima_min" id="prima_min" data-bvalidator="required" />	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Valor a Financiar: </label>	
        				<input type="text" name="valor_financiar" id="valor_financiar" data-bvalidator="required"  />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Marca del Vehículo: </label>	
        				<select class="cabin_grey" name="marca" id="marca" onchange="getModels(this.value);" style="float:left" data-bvalidator="required">
							<option value="">-Seleccione-</option>
							<?php foreach ($marks as $mark): ?>
							<option value="<?php echo $mark['id_marca']; ?>" <?php if(isset($car['id_marca'])){ if($car['id_marca']==$mark['id_marca']){ echo ' selected="selected" '; } } ?>><?php echo $mark['nombre']; ?></option>
							<?php endforeach ?>
						</select>	 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Modelo del Vehículo : </label>	
        				<select class="cabin_grey" name="modelo" id="modelo" data-bvalidator="required">
							<option value="">-Seleccione-</option>
              
              <?php if(isset($car['modelo'])){ 
							$ci = &get_instance();
							$ci->load->model("data_model");
	 						$nombre_modelo=$ci->data_model->getNombre_modelo($car['modelo'],$car['id_marca']);
							
							?>
                            	<option value="<?php echo $car['modelo']; ?>">-Seleccione-</option>
                            <?php } ?>
						</select>	
        		</div>	
                <div class="clear_0"></div>
                <div>
        				<label>Tipo de Vehículo  : </label>	
        				<select class="cabin_grey" name="tipo_vehiculo" id="tipo_vehiculo" style="float:left" data-bvalidator="required">
							<option value="">-Seleccione-</option>
							<?php foreach($allcategories as $category): ?>
							<option value="<?php echo $category['id_tipo_vehiculo']; ?>"><?php echo $category['nombre']; ?></option>
        					<?php endforeach ?>
						</select> 	
        		</div>
                <div class="clear_0"></div>	
                <div>
        				<label>Año del Vehículo  : </label>	
        				<select class="cabin_grey" name="year" id="year" data-bvalidator="required">
							<option value="">-Seleccione-</option>
							<?php for ($i = date('Y'); $i > (date('Y') - 15) ; $i--): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor ?>
						</select> 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Plazos   : </label>	
        				<select class="cabin_grey" name="plazos" id="plazos" data-bvalidator="required">
							<option value="">-Seleccione-</option>
                            <option value="12">1 año - 12 meses</option>
                            <option value="24">2 años - 24 meses</option>
                            <option value="36">3 años - 36 meses</option>
                            <option value="48">4 años - 48 meses</option>
                            <option value="60">5 años - 60 meses</option>
                            <option value="72">6 años - 72 meses</option>
                            <option value="84">7 años - 84 meses</option>
                            <option value="96">8 años - 96 meses</option>
						</select>	
        		</div>	
                
                
                
                
                
                
                
                
                <div class="clear_0"></div>
                <span class="cabin_blue">Información del Cliente</span>	
                <div>
        				<label>Nombres   : </label>	
        				  <input type="text" name="cli_nombres" id="cli_nombres" data-bvalidator="alpha,minlength[3],required" /> 	
        		</div>
                <div class="clear_0"></div>	
                <div>
        				<label>Apellidos   : </label>	
        				 <input type="text" name="cli_apellidos" id="cli_apellidos" data-bvalidator="alpha,minlength[3],required" /> 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Email: </label>	
        				<input type="text" name="cli_email" id="cli_email" data-bvalidator="email, required" /> 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Nacionalidad:  </label>	
        				<select name="pais" id="pais">
                  <?php
                  $nit="";
                   foreach ($paises as $pais): ?>
                            <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                                 <?php echo $pais['nombre']; ?>
                            </option>
                            <?php endforeach ?>
                       </select>	
        		</div>
                <div class="clear_0"></div>
                <div>
        <?php  
				
				if($this->session->userdata('pais')=='1'){ $doc='DUI'; $nit='NIT'; }
				if($this->session->userdata('pais')=='2'){ $doc='CEDULA'; $nit='NIT'; }
				if($this->session->userdata('pais')=='3'){ $doc='IDENTIDAD'; $nit='RTN'; } 
				
				?>
        				<label>Documento: </label>	
        				<select name="documento" id="documento" onchange="ingresos(this.value)" style="float:left">
          					<option>-Seleccione-</option> 
  		  					<option value="<?php echo $doc; ?>"><?php  echo $doc; ?></option>
                			<option value="carnet redidente">Carnet de Residente</option>
                            <option value="Pasaporte">Pasaporte</option>
        				</select>	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Numero de Documento: </label>	
        				<input type="text" name="n_doc" id="n_doc" data-bvalidator="number,required" /> 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label><?php  echo $nit; ?>: </label>	
        				<input type="text" name="nit" id="nit" data-bvalidator="number,required" /> 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Fecha de Nacimiento: </label>	
                        
                        	<select name="nac_dia" id="nac_dia" onchange="ingresos(this.value)" style="width:65px;">
          					<option>-dia-</option> 
  		  						<?php for($i=1;$i<=31;$i++){ ?>
                					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
               					 <?php } ?>
        					</select>	
            				<select name="nac_mes" id="nac_mes" onchange="ingresos(this.value)" style="width:65px;"> 
  		  					<option>-mes-</option> 
  		  						<?php for($i=1;$i<=12;$i++){ ?>
                					<option value="<?php echo $i; ?>"><?php echo $mes[$i]; ?></option>
                				<?php } ?>
        					</select>	
            				<select name="nac_year" id="nac_year" onchange="ingresos(this.value)" style="width:65px;">
          					<option>-año-</option> 
                				<?php  for($i=date('Y');$i>=date('Y')-50;$i--){ ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?>
                            </option>
								<?php } ?>
  		  					</select>
                        
                        	 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Teléfono Fijo Casa: </label>	
        				<input type="text" name="tel_fijo" id="tel_fijo"  data-bvalidator="maxlength[8], minlength[8], number, required"/> 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Teléfono Celular: </label>	
        				<input type="text" name="tel_celular" id="tel_celular" data-bvalidator="maxlength[8], minlength[8], number, required" /> 	
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Estado Civil: </label>	
        				
                        <select name="estado_civil" id="estado_civil" style="width:200px;" data-bvalidator="required">
          				<option>-Seleccione-</option> 
  		  				
                		<option value="Soltero">Soltero</option>
                        <option value="Casado">Casado</option>
                        
        			</select>
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Numero de Personas Dependientes: </label>	
        				<input type="text" name="dependientes" id="dependientes"  data-bvalidator="number, required" />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Tipo de Domicilio : </label>	
                        
                        <select name="tipo_domicilio" id="tipo_domicilio" style=" width:200px;" data-bvalidator="required">
                        	<option value="propia">propia</option>
                            <option value="propia_hipotecada">propia_hipotecada</option>
                            <option value="alquilada">alquilada</option>
                        </select>
        		</div>
                <div class="clear_0"></div>
                <div>
        			<label>Antigüedad Domicilio : </label>	
            		<select name="dom_mes" id="dom_mes" style=" width:95px;">
          				<option>-mes-</option> 
  		  				
  		  				<?php for($i=1;$i<=12;$i++){ ?>
                		<option value="<?php echo $i; ?>"><?php echo $mes[$i]; ?></option>
                		<?php } ?>
        				
        			</select>
                    	
            		<select name="dom_year" id="dom_year"  style=" width:95px;">
          			<option>-año-</option> 
                	<?php  for($i=date('Y');$i>=date('Y')-50;$i--){ ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
  		  		
        			</select>
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Ciudad: </label>	
        				<input type="text" name="ciudad" id="ciudad" data-bvalidator="alpha,minlength[3],required" />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Departamento: </label>	
        				<input type="text" name="departamento" id="departamento" data-bvalidator="alpha,minlength[3],required"  />
        		</div>
                <div class="clear_0"></div>
                <div>
                		<br />
        				<span class="cabin_blue">Seleccionar el teléfono por el cual desea ser contactado:</span><br />	
                        <div class="clear_10"></div>
        				<input type="radio" name="contactar" id="contactar" value="Telefono trabajo"  /><label>Teléfono lugar de trabajo</label> 
						<div class="clear_0"></div>
                        <input type="radio" name="contactar" id="contactar" value="Telefono celular" /><label>Teléfono Celular</label>
                        <div class="clear_0"></div>
                       	<input type="radio" name="contactar" id="contactar" value="Telefono casa" /><label>Teléfono de Casa</label>
 
        		</div>
                <br />
                <span class="cabin_blue" >Referidos</span><br/>
                <span class="cabin_parrafo">Para nosotros será un placer atender a sus familiares y amigos. Agradecemos que nos proporcione los siguientes datos para contactarles</span>
                <div>
        				<label>Nombres: </label>	
        				<input type="text" name="ref_nombres" id="ref_nombres" data-bvalidator="alpha,minlength[3],required" />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Apellidos: </label>	
        				<input type="text" name="ref_apellidos" id="ref_apellidos" data-bvalidator="alpha,minlength[3],required" />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Teléfono Casa: </label>	
        				<input type="text" name="ref_telefono_casa" id="ref_telefono_casa" data-bvalidator="maxlength[8], minlength[8], number, required" />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Teléfono de Trabajo: </label>	
        				<input type="text" name="ref_telefono_trabajo" id="ref_telefono_trabajo" data-bvalidator="maxlength[8], minlength[8], number, required" />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Teléfono Celular: </label>	
        				<input type="text" name="ref_celular" id="ref_celular" value="" data-bvalidator="maxlength[8], minlength[8], number, required" />
        		</div>
                <div class="clear_0"></div>
                <div>
        				<label>Comentarios: </label>	
        				<input type="text" name="comentarios" id="comentarios" value="" />
        		</div>
                <div class="clear_0"></div>
                <span class="nota">Nota: Al remitir esta solicitud autorizo al Banco para realizar consulta sobre mi referencia crediticia</span>
 
 
</div><!-- fin info credito **************************** -->


	<div class="separator_fields"></div>
 
 

<!-- /fase2/index.php/solicitud/credito_natural/2  -->

<input type="submit" name="Enviar" id="Enviar" value="Enviar" />


</form>
<script type="text/javascript">
	$('#form111').bValidator();
</script>	
