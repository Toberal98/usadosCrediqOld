<script type="text/javascript" src="<?php echo base_url(); ?>public/js/actions.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
	
 	$('#<?php echo $this->session->userdata('rep_sort'); ?>').css("background","#777777");
	$('#<?php echo $this->session->userdata('rep_sort'); ?>').css("color","#FFF");
	
 });
 
</script>

<div id="head-vehiculo">Reporte resumen de control usadoscrediq.com</div>

<form id="sort_form" name="sort_form" method="post" action="<?php echo base_url() ?>index.php/site/reportes/0">

<table width="656" border="0" class="filters"  >
  <tr>
    <td width="273"><strong>Rango de fechas:</strong>
    <div class="clear_3"></div>
     
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
		date_default_timezone_set ('America/El_Salvador');
		?>
         <span style="float:left; width:auto; display:block ">Desde</span>
        <select name="desde_dia" id="desde_dia" onchange="ingresos(this.value)" style="float:left">
          		<option value="01">-dia-</option> 
  		  		<?php for($i=1;$i<=31;$i++){  if($i<10){ $c='0'; }else{ $c=''; } ?>
                <option value="<?php echo $c.$i; ?>"><?php echo $i; ?></option>
                <?php } ?>
        	</select>	
            <select name="desde_mes" id="desde_mes" onchange="ingresos(this.value)" style="float:left">
          		<option value="01">-mes-</option> 
  		  		<?php for($i=1;$i<=12;$i++){ if($i<10){ $c='0'; }else{ $c=''; } ?>
                <option value="<?php echo $c.$i; ?>"><?php echo $mes[$i]; ?></option>
                <?php } ?>
        	</select>	
            <select name="desde_year" id="desde_year" onchange="ingresos(this.value)" style="float:left">
          		<option value="2000">-año-</option> 
                <?php  for($i=date('Y');$i>=date('Y')-50;$i--){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
  		  		
        	</select>
  <span style="float:left; width:auto; display:block "> Hasta:</span> 
   <select name="hasta_dia" id="hasta_dia" onchange="ingresos(this.value)" style="float:left">
   		  <option value="<?php echo date('d'); if($i<10){ $c='0'; }else{ $c=''; } ?>">-dia-</option> 
  		  		<?php for($i=1;$i<=31;$i++){ ?>
          <option value="<?php echo $c.$i; ?>"><?php echo $i; ?></option>
                <?php } ?>
   	</select>	
            <select name="hasta_mes" id="hasta_mes" onchange="ingresos(this.value)" style="float:left">
       		  <option value="<?php echo date('m'); ?>">-mes-</option> 
  		  		<?php for($i=1;$i<=12;$i++){ ?>
              <option value="<?php echo $c.$i; ?>"><?php echo $mes[$i]; ?></option>
                <?php } ?>
        	</select>	
        <select name="hasta_year" id="hasta_year" onchange="ingresos(this.value)" style="float:left">
   		  <option value="<?php echo date('Y'); ?>">-año-</option> 
                <?php  for($i=date('Y');$i>=date('Y')-50;$i--){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
  		  		
        	</select>
            <div class="clear_3"></div>
   <input id="rango_val" name="rango_val" type="submit" value="Filtrar"   onmousedown="rangoVal(this.value)" onclick="$('#sort_form').submit();" class="boton_filtrar_f"    />
   <input type="hidden" id="rango" name="rango"  value="" />
    <td width="176">
      
      
      <input id="global" name="global" type="button" value="Global" onmousedown="tipo_val(this.value)" onclick="$('#sort_form').submit();" />
      <input id="autolote" name="autolote" type="button" value="Autolote" onmousedown="tipo_val(this.value)" onclick="$('#sort_form').submit();" />
      
      <input id="tipo" name="tipo" type="hidden" value="" /></td>
      
      
      <td width="82"><input id="ASC" name="ASC" type="button" value="Ascendente" onmousedown="sort_val(this.value)" onclick="$('#sort_form').submit();" /></td>
      <td width="107"><input id="DESC" name="DESC" type="button" value="Descendente" onmousedown="sort_val(this.value)" onclick="$('#sort_form').submit();" />
      <input id="sort" name="sort" type="hidden" value="" /></td>
    </tr>
  </table>
</form>
<div class="separator"></div>
<table border="0" id="hor-minimalist-a">
  <tr class="t-head">
    <td ><a href="<?php echo base_url(); ?>index.php/site/reportes/0/usu">Usuario</a></td>
    <td ><a href="<?php echo base_url(); ?>index.php/site/reportes/0/sub">Subidos</a></td>
    <td ><a href="<?php echo base_url(); ?>index.php/site/reportes/0/apro">Aprobados</a></td>
    <td ><a href="<?php echo base_url(); ?>index.php/site/reportes/0/rech">Rechazados</a></td>
    <td ><a href="<?php echo base_url(); ?>index.php/site/reportes/0/ven">Vendidos</a></td>
    <td ><a href="<?php echo base_url(); ?>index.php/site/reportes/0/deb">De baja</a></td>
<?php 
if($this->session->userdata('rep_tipo')=='lotes'){
?> 
    <td ><a href="<?php echo base_url(); ?>index.php/site/reportes/0/deb">Lote</a></td> 
<?php } ?>
    
  </tr>

  <?php
  $v=1;
  if(isset($reportes)){ foreach ($reportes as $reporte) : 
  if($v>2){ $v=1; }


  ?>
  <tr class="t_gris<?php echo $v; ?>">
    <td class="txt_L"><?php echo $reporte['nombres'].$reporte['apellidos']; ?></td>
    <td ><?php echo $reporte['subidos']; 	?></td>
    <td ><?php echo $reporte['aprobados']; ?></td>
    <td ><?php echo $reporte['rechazados']; ?></td>
    <td ><?php echo $reporte['vendidos']; 		?></td>
    <td ><?php echo $reporte['de_baja']; 	?></td>

    <?php 
if($this->session->userdata('rep_tipo')=='lotes'){
?> 
    <td ><?php echo $reporte['lote'];  ?></td> 
<?php } ?>
    
  </tr>
  <?php
  $v++;
   endforeach; } ?>
</table>

<?php 
if(isset($pagination)){
	echo '<div class="separator"></div>';
  echo $pagination;
  echo '<div class="separator"></div>';
}
?>


