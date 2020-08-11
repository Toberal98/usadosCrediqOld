<div id="head-vehiculo">Solicitud de credito detalle</div>
<div class="clear_0"></div>

<span class="cabin_blue">Informacion del solicitante  </span>
<div class="clear_0"></div>

<div class="detalle_credito">

  <label for="producto">Id: </label>
  <li><?php echo $solicitud['id']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Estado: </label>
  <li><?php echo $solicitud['estado']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Ingreso Exacto: </label>
  <li><?php echo $solicitud['ingreso']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Comisiones: </label>
  <li><?php echo $solicitud['comisiones']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Tipo de Ingresos: </label>
  <li><?php echo $solicitud['tipo_ingresos']; ?></li>
  <div class="clear_0"></div>
  
  <div class="separator_fields"></div>
<span class="cabin_blue">Informacion laboral  </span><!--infornmacion laboral ******************************** -->
  <div class="clear_0"></div>

<label>Tipo de seguro: </label>
  <li><?php echo $solicitud['tipo_cotizacion']; ?></li>
  <div class="clear_0"></div>

<label>Lugar de trabajo: </label>
  <li><?php echo $solicitud['lugar_trabajo']; ?></li>
  <div class="clear_0"></div>
  
  <label>Direccion de trabajo: </label>
  <li><?php echo $solicitud['direccion_trabajo']; ?></li>
  <div class="clear_0"></div>

  
  <label>Fecha de ingreso: </label>
  <li><?php echo $solicitud['fecha_ingreso']; ?></li>
  <div class="clear_0"></div>

<label>Egresos mensuales: </label>
  <li><?php echo $solicitud['egresos']; ?></li>
  <div class="clear_0"></div>
  
  <label>Cargo: </label>
  <li><?php echo $solicitud['cargo']; ?></li>
  <div class="clear_0"></div>


  <label >Teléfono de Trabajo: </label>
  <li><?php echo $solicitud['telefono_trabajo']; ?></li>
  <div class="clear_0"></div>
  
  <label>Tipo de profesion: </label>
  <li><?php echo $solicitud['tipo_profesion']; ?></li>
  <div class="clear_0"></div>
  
  <label>Fecha de jubilacion: </label>
  <li><?php echo $solicitud['fecha_jubilacion']; ?></li>
  <div class="clear_0"></div>
  
<!--  
  
-->
 
 
 
  
  
  <div class="separator_fields"></div>
<span class="cabin_blue">Monto solicitado  </span>
<div class="clear_0"></div>  
  
  
  <label for="producto">Destino: </label>
  <li><?php echo $solicitud['destino']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Valor vehiculo: </label>
  <li><?php echo $solicitud['valor_vehiculo']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Prima_minima: </label>
  <li><?php echo $solicitud['prima_minima']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Valor_financiar: </label>
  <li><?php echo $solicitud['valor_financiar']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Marca: </label>
  <li><?php echo $solicitud['marca']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Modelo: </label>
  <li><?php echo $solicitud['modelo']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Tipo de vehiculo: </label>
  <li><?php echo $solicitud['tipo_vehiculo']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Año: </label>
  <li><?php echo $solicitud['year']; ?></li>
  <div class="clear_0"></div>
  <label for="producto">Plazos: </label>
  <li><?php echo $solicitud['plazos']; ?></li>
  <div class="clear_0"></div>

  
  
<div class="separator_fields"></div>
<span class="cabin_blue">Información del Cliente  </span>  
<div class="clear_0"></div>  
  
  
  <label for="producto">Nombres: </label>
  <li><?php echo $cliente['nombres']; ?></li>
  <div class="clear_0"></div>
  
  <label for="producto">Apellidos: </label>
  <li><?php echo $cliente['apellidos']; ?></li>
  <div class="clear_0"></div>
  
  <label for="producto">Email: </label>
  <li><?php echo $cliente['email']; ?></li>
  <div class="clear_0"></div>
  
  <label for="producto">Nacionalidad: </label>
  <li><?php echo $cliente['nacionalidad']; ?></li>
  <div class="clear_0"></div>
  
    <label for="producto">Documento: </label>
  <li><?php echo $cliente['documento'].' - '.$cliente['numero']; ?></li>
  <div class="clear_0"></div>

<label for="producto">Nit: </label>
  <li><?php echo $cliente['documento']; ?></li>
  <div class="clear_0"></div>
  
  <label for="producto">Fecha de nacimiento: </label>
  <li><?php echo $cliente['fecha_nacimiento']; ?></li>
  <div class="clear_0"></div>
  
    <label for="producto">telefono_fijo: </label>
  <li><?php echo $cliente['telefono_fijo']; ?></li>
  <div class="clear_0"></div>
  
    <label for="producto">celular: </label>
  <li><?php echo $cliente['celular']; ?></li>
  <div class="clear_0"></div>
  
    <label for="producto">Estado Civil: </label>
  <li><?php echo $cliente['estado_civil']; ?></li>
  <div class="clear_0"></div>
  
      <label for="producto">Dependientes: </label>
  <li><?php echo $cliente['dependientes']; ?></li>
  <div class="clear_0"></div>
  
      <label for="producto">Tipo de domicilio: </label>
  <li><?php echo $cliente['tipo_domicilio']; ?></li>
  <div class="clear_0"></div>
  
      <label for="producto">Antiguedad del domicilio: </label>
  <li><?php echo $cliente['antiguedad_domicilio']; ?></li>
  <div class="clear_0"></div>
  
        <label for="producto">Ciudad: </label>
  <li><?php echo $cliente['ciudad']; ?></li>
  <div class="clear_0"></div>
  
  <label for="producto">Departamento: </label>
  <li><?php echo $cliente['departamento']; ?></li>
  <div class="clear_0"></div>
  
  <label for="producto">Contacto a: </label>
  <li><?php echo $cliente['contactado_a']; ?></li>
  <div class="clear_0"></div>
  
  
<div class="separator_fields"></div>
<span class="cabin_blue">Referencias:</span>
<div class="clear_0"></div>   
  
 <label for="producto">Nombres: </label>
  <li><?php echo $referencia['nombres']; ?></li> 
  <div class="clear_0"></div>
  
   <label for="producto">Apellidos: </label>
  <li><?php echo $referencia['apellidos']; ?></li> 
  <div class="clear_0"></div>
  
     <label for="producto">Telefono de casa: </label>
  <li><?php echo $referencia['telefono_casa']; ?></li> 
  <div class="clear_0"></div>
  
     <label for="producto">Telefono de trabajo: </label>
  <li><?php echo $referencia['telefono_trabajo']; ?></li> 
  <div class="clear_0"></div>
  
     <label for="producto">Celular: </label>
  <li><?php echo $referencia['celular']; ?></li> 
  <div class="clear_0"></div>
  
  <label for="producto">Comentarios: </label>
  <li><?php echo $referencia['comentarios']; ?></li> 
  <div class="clear_0"></div>


<div class="clear_0"></div>
  
  
  
  <div class="separator_fields"></div>

  
  
  
  
  
  

</div><!-- fin info credito **************************** -->


