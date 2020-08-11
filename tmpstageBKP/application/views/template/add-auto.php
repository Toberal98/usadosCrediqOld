<?php date_default_timezone_set('America/El_Salvador'); ?>

<style>
input[type="number"]:disabled, select[id="tipo_administrativo"]:disabled{ 
  background: #CFD8DC;
}
</style>

<form id="form_addCar" name="form_addCar" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/saveCarInPendiente" enctype="multipart/form-data" method="post" >
    <div class="content">
        <div class="container12">
            <div class="row agregarNuevo">
                <h3>Añadir Nuevo Veh&iacute;culo<span></span></h3>
                <div class="column6">
                <p class="title-sec">Caracter&iacute;sticas</p>
                    <label><span>Marca:</span> 
                        <select class="cabin_grey" name="marca" id="marca" onchange="getModelos(this.value);">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Modelo:</span>
                        <select class="cabin_grey" name="modelo" id="modelo">
                            <option value="">-Seleccione-</option>
                        </select>
                    </label>
                    <label><span>Tipo Veh&iacute;culo:</span> 
                      <select class="cabin_grey" name="tipo_vehiculo" id="tipo_vehiculo">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id_tipo_vehiculo']; ?>"><?php echo $cat['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                </div>

                <div class="column6">
                    <p class="title-sec">Fotograf&iacute;as</p>
                    <div class="photos">
                        <label><span class="cabin_white">Foto de Auto</span>
                            <div class="container-foto">
                            <span id="previa1">
                            </span>
                                <i class="fas fa-image"></i><input type="file" name="imagen1" id="imagen1">
                            </div>
                            <label for="imagen1" generated="true" class="error"></label>
                        </label>
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

<script type="text/javascript">
$(function() {
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
    }
  }
});
</script>