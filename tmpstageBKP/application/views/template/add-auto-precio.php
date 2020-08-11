<?php date_default_timezone_set('America/El_Salvador'); ?>

<style>
input[type="number"]:disabled, select[id="tipo_administrativo"]:disabled{ 
  background: #CFD8DC;
}
</style>

<form id="form_addCar" name="form_addCar" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/saveCarPrecio" enctype="multipart/form-data" method="post" >
    <input type="text" class="hidden" name="id_automovil" value="<?php echo $data_auto['id_automovil'];?>"/>
    <input type="text" class="hidden" name="id_renting" value="<?php echo $data_auto['id_renting'];?>"/>
    <input type="text" class="hidden" name="id_compra" value="<?php echo $data_auto['id_compra'];?>"/>
    <div class="content">
        <div class="container12">
            <div class="row agregarNuevo">
                <h3>Añadir valor de Venta<span></span></h3>
                    <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Visible</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="text-align:center">
                            <td><?php echo $data_auto[''] ?></td>
                            <td><?php echo $data_auto[''] ?></td>
                            <td><?php echo $data_auto[''] ?></td>
                            <td>
                                <select class="cabin_grey" name="estado" id="estado">
                                    <option value="">-Seleccione-</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                <div class="column12">
                    <p class="title-sec">Valor de venta</p>                  
                </div>
                <div class="column6">
                    <div class="panel panel-default">
                      <div class="panel-heading" >
                        Renting <label style="display:inline; margin-left:15px"><input id="R" name="aplicarenting" type="checkbox" value="1"> Aplica </label>
                        
                      </div>
                      <div class="panel-body">
                        <label><span>Precio para Renting:</span>
                          <input type="number" id="precio_r" name="precio_r" step='0.01' min='0.00'>
                        </label>
                        <div class="panel panel-default">
                          <div class="row">
                            <div class="col-md-4">
                              <button type="button" class="btn-medium" onclick="planesRenting();">Asignar plan renting</button>
                            </div>
                            <div class="col-md-8">
                              
                              <label><span>Tasa: </span>
                                <input type="number" id="tasa_r" name="tasa_r" value="" style="background:#CFD8DC" readonly>
                              </label>
                              <label><span>Plazo: </span>
                                <input type="number" id="plazo_r" name="plazo_r" value="" style="background:#CFD8DC" readonly>
                              </label>
                            </div>
                          </div>
                        </div>
                        <label><span>Valor residual: </span>
                          <input type="number" id="residual" name="residual" value="">
                        </label>
                        <label><span>Mantenimiento: </span>
                          <input type="number" id="mantenimiento" name="mantenimiento" value="">
                        </label>
                        <label><span>Cargo Administrativo: </span>
                          <select id="tipo_administrativo" name="tipo_administrativo" onchange="cambiarInput();" style="width: 50px">
                            <option value="" selected></option>
                            <option value="monetario">$</option>
                            <option value="porcentaje">%</option>
                          </select>
                          <input type="number" id="administrativo" name="administrativo" value="" readonly>
                        </label>
                        <div class="center">
                          <button type="button" class="btn-medium" style="width: 130px"
                          onclick="getCuotaRenting();"> Calcular </button>
                        </div>
                        <hr>
                        <label><span>Renting calculado:</span>
                          <input type="text" style="background:#CFD8DC" id="renting" name="renting" readonly>
                        </label> 
                      </div>
                    </div>
                </div>
                <div class="column6">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Cuota
                      </div>
                      <div class="panel-body">
                        <label><span>Precio para Compra:</span>
                          <input type="number" id="precio_c" name="precio_c" step='0.01' min='0.00'>
                        </label>
                        <div class="panel panel-default">
                          <div class="row">
                            <div class="col-md-4">
                              <button type="button" class="btn-medium" onclick="planesCompra();">Asignar plan compra</button>
                            </div>
                            <div class="col-md-8">
                            
                              <label><span>Tasa: </span>
                                <input type="number" id="tasa_c" name="tasa_c" value="" style="background:#CFD8DC" readonly>
                              </label>
                              <label><span>Plazo: </span>
                                <input type="number" id="plazo_c" name="plazo_c" value="" style="background:#CFD8DC" readonly>
                              </label>
                              <label><span>Prima: </span>
                                <input type="number" id="prima_c" name="prima_c" value="" style="background:#CFD8DC" readonly>
                              </label>
                              <label><span>Recargo: </span>
                                <input type="number" id="recargo_c" name="recargo_c" value="" style="background:#CFD8DC" readonly>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="center">
                          <button type="button" class="btn-medium" style="width: 130px"
                          onclick="getCuotaCompra();"> Calcular</button>
                        </div>
                        <hr>
                        <label><span>Cuota de Compra calculada:</span>
                          <input type="text" style="background:#CFD8DC" id="compra" name="compra" readonly>
                        </label>
                      </div>
                    </div>
                </div>             
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                <button type="submit">Guardar Nuevo Veh&iacute;culo</button>
                </div>
            </div>
        </div>
    </div>
</form>


<div id="planesRenting" style="width: 800px; display: none;">
    <div class="padding">
        <div class="row">
              <h3>Selecciones un plan</h3>
              <table style="width:100%" class="table table-condensed">
                <tr>
                  <th>Plazo</th>
                  <th>Tasa Anual</th> 
                  <th>Opcion</th>
                </tr>
                <?php
                  foreach ($planes_renting as $plan):
                ?>
                <tr>
                  <td><?php echo $plan['plazo']; ?></td>
                  <td><?php echo $plan['tasa_anual']; ?></td> 
                  <td><button class="btn-small" onclick="llenarPlanRenting('<?php echo $plan['id'] ?>','<?php echo $plan['tasa_anual'] ?>','<?php echo $plan['plazo'] ?>')">Seleccionar</button></td>
                </tr>
                <?php 
                  endforeach;
                ?>
              </table>
          
        </div>
    </div>
</div>

<div id="planesCompra" style="width: 800px; display: none;">
    <div class="padding">
        <div class="row">
              <h3>Selecciones un plan</h3>
              <table style="width:100%" class="table table-condensed">
                <tr>
                  <th>Plazo</th>
                  <th>Tasa Anual</th> 
                  <th>Prima</th> 
                  <th>Recargo</th> 
                  <th>Opcion</th>
                </tr>
                <?php
                  foreach ($planes_compra as $plan):
                ?>
                <tr>
                  <td><?php echo $plan['plazo']; ?></td>
                  <td><?php echo $plan['tasa_anual']; ?></td> 
                  <td><?php echo $plan['prima']; ?></td> 
                  <td><?php echo $plan['recargo']; ?></td> 
                  <td><button class="btn-small" 
                  onclick="llenarPlanCompra('<?php echo $plan['id'] ?>','<?php echo $plan['tasa_anual'] ?>',
                  '<?php echo $plan['plazo'] ?>', '<?php echo $plan['prima'] ?>',
                  '<?php echo $plan['recargo'] ?>')">Seleccionar</button></td>
                </tr>
                <?php 
                  endforeach;
                ?>
              </table>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
    desabilitarRenting();
    $("#R").click(function() {
      if ($(this).prop('checked')){
        habilitarRenting();
      }else{
        desabilitarRenting();
      }
    });
    var uploader = '<?php echo base_url() ?>index.php/ajax/doUpload';//se hace adentro para llenar numero de imagen que se envia
    $('#imagen1').change(function(e) { addImage(e); });

    function addImage(e){
      var file = e.target.files[0],
      imageType = /image.*/;

      var sizeByte = file.size;
      var siezekiloByte = parseInt(sizeByte / 1024);

      if (!file.type.match(imageType)){
          return;
      }
      var reader = new FileReader();
      if(e.target.id == 'imagen1'){
        reader.onload = fileOnload1;
      }

      if(siezekiloByte > 2048){
        $('#imagen1').val("");
        swal("Invalido!", "La peso de imagen no debe ser superior a 2MB (2048 KB)!", "error");
      }else{
        reader.readAsDataURL(file);
      } 
    }
  
    function fileOnload1(e) {
      var result=e.target.result;
      $("#previa1 img:last-child").remove();
      $('#previa1').append('<img style="width:180px; height:130px;" src="' + result + '">');
    }
});

function desabilitarRenting(){
  $('#precio_r').attr('disabled',true);
  $('#residual').attr('disabled',true);
  $('#mantenimiento').attr('disabled',true);
  $('#tipo_administrativo').attr('disabled',true);
  $('#administrativo').attr('disabled',true);
}

function habilitarRenting(){
  $('#precio_r').removeAttr('disabled');
  $('#residual').removeAttr('disabled');
  $('#mantenimiento').removeAttr('disabled');
  $('#tipo_administrativo').removeAttr('disabled');
  $('#administrativo').removeAttr('disabled');
}

function planesRenting(){
  $.fancybox.open({
    src  : '#planesRenting',
    type : 'inline',
    opts : {
      afterShow : function( instance, current ) {
        console.info('done!');
      }
    }
  });
}
function planesCompra(){
  $.fancybox.open({
    src  : '#planesCompra',
    type : 'inline',
    opts : {
      afterShow : function( instance, current ) {
        console.info('done!');
      }
    }
  });
}
function llenarPlanRenting(id, tasa, plazo){
  $('#id_R').val(id);
  $('#tasa_r').val(tasa);
  $('#plazo_r').val(plazo);
  $.fancybox.close({
    src  : '#planesRenting'
  });
}
function llenarPlanCompra(id, tasa, plazo, prima, recargo){
  $('#id_C').val(id);
  $('#tasa_c').val(tasa);
  $('#plazo_c').val(plazo);
  $('#prima_c').val(prima);
  $('#recargo_c').val(recargo);
  $.fancybox.close({
    src  : '#planesCompra'
  });
}

function getCuotaCompra(){
  var precio = $('#precio_c').val();
  var tasa = $('#tasa_c').val();
  var plazo = $('#plazo_c').val();
  var recargo = $('#recargo_c').val();
  
  if(precio == "" || tasa == "" || plazo == ""){
    swal("Debe rellenar algunos campos necesarios!");
    return;
  }
  $("#loading").show();
  $.ajax({
      type: "POST",
      url: '<?php echo base_url() ?>index.php/ajax/calcCuotaCompra', 
      data:{precio:precio, tasa:tasa, plazo:plazo, recargo:recargo},
      success: function(data){
        $("#compra").val(data);
        $("#loading").hide();
      }
  });
}
function getCuotaRenting(){
  var precio = $('#precio_r').val();
  var tasa = $('#tasa_r').val();
  var plazo = $('#plazo_r').val();
  var nper = $('#plazo_r').val();
  var valor_res = $('#residual').val();
  var mante = $('#mantenimiento').val();
  var tipo_admi = $('#tipo_administrativo').val();
  var adminis = $('#administrativo').val();

  if(precio == ""){swal("Debe rellenar el campo precio!"); return;}
  if(tasa == "" || plazo ==""){swal("Debe seleccionar un plan reting!"); return;}
  if(valor_res == ""){swal("Debe rellenar el campo valor residual!"); return;}
  
  $("#loading").show();
  $.ajax({
      type: "POST",
      url: '<?php echo base_url() ?>index.php/ajax/calcCuotaRenting', 
      data:{residual: valor_res, precio: precio, tasa: tasa, plazo: plazo, mantenimiento: mante, tipo_mante:tipo_admi, administrativo:adminis },
      success: function(data){
        $("#renting").val(data);
        $("#loading").hide();
      }
  });
}
function getModelos(idMarca){
    $("#modelo option").remove();
    $.ajax({
        type: "GET",
        url: '<?php echo base_url() ?>index.php/car/cargarModelByMarca/'+idMarca+'', 
        dataType: "json",
        success: function(data){
            console.log(data);
            $("#modelo").append("<option value=''>Seleccione</option>");
            var i=0;
          $.each(data,function(key, registro) {
            $("#modelo").append('<option value='+registro.id_modelo+'>'+registro.nombre+'</option>');
          });     
        },
        error: function(data) {
          //alert('error');
        }
    });
}
function cambiarInput(){
  if($('#tipo_administrativo').val() == "porcentaje"){
    $('#administrativo').removeAttr("readonly");
    $('#administrativo').attr("step", "0.0001");
  }else if($('#tipo_administrativo').val() == "monetario"){
    $('#administrativo').removeAttr("readonly");
    $('#administrativo').removeAttr("step");
  }else{
    $('#administrativo').attr("readonly", true);
  }
}
function limitarTeclas(){
  var input = $('#renting');
  input.on('keydown', function() {
  var key = event.keyCode || event.charCode;
  if( key < 48 || key > 57 )
      return false;
  });
}
jQuery.validator.setDefaults({
  success: "valid"
});
$("#form_addCar").validate({
  rules: {
    marca: {
      required: true
    },
    modelo: {
      required: true
    },
    tipo_vehiculo: {
        required: true
    },
    pais: {
        required: true
    },
    estado: {
        required: true
    },
    imagen1: {
        required: true,
        extension: "jpg|png"
    },
    renting:{
        required: "#R:checked"
    },
    compra:{
        required: true
    }
  },
  messages: {
    email: {
      remote: "Email ya esta en uso."
    }
  }
});
</script>