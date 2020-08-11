<?php
$rowc = $compra->row_array();
$rowr = $renting->row_array();
?>

<style>
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #fff;
}
/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  width: 50%;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
  margin-top: -5px;
  margin-bottom: -5px;
  color:#546E7A;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ccc;
}

/* Create an activo/current tablink class */
.tab button.activo {
  background-color: #1565C0;
  color:#fff;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
  font-size: 14px;
}
</style>
<div class="content">
    <div class="container12">
        <div class="row">
            <h3>Parametros de cuotas y renting.
            <div class="tab">
              <button class="tablinks" onclick="openCity(event, 'renting')" id="defaultOpen">Renting</button>
              <button class="tablinks" onclick="openCity(event, 'compra')">Compra</button>
            </div>

            <div id="renting" class="tabcontent">
               <br>
              <form method="POST" action="<?php echo base_url();?>index.php/savedata/updateRentingDefault"
              onsubmit="return sendRenting()">
                <input type="text" name="id_r" class="hidden" value="<?php echo $rowr['id'] ?>"/>
                <label class="form-label">Tasa:</label>
                <input type="number" id="tasa_r" name="tasa_r" min="0.00" step="0.01" value="<?php echo $rowr['tasa_anual'] ?>" required><br>
                <br>
                <label class="form-label">Plazo:</label>
                <input type="number" id="plazo_r" name="plazo_r" value="<?php echo $rowr['plazo'] ?>" required><br>
                <br>
                <label class="form-label"></label>
                <button type="submit" style="width:150px;">Actualizar</button>
              </form>
            </div>

            <div id="compra" class="tabcontent">
            <br>
              <form method="POST" action="<?php echo base_url();?>index.php/savedata/updateCompraDefault" 
              onsubmit="return sendCompra();">
                <input type="text" name="id_c" class="hidden" value="<?php echo $rowc['id'] ?>"/>
                <label class="form-label">Tasa:</label>
                <input type="number" id="tasa_c" name="tasa_c"  min="0.00" step="0.01" value="<?php echo $rowc['tasa_anual'] ?>" required><br>
                <br>
                <label class="form-label">Plazo:</label>
                <input type="number" id="plazo_c" name="plazo_c" value="<?php echo $rowc['plazo'] ?>" required><br>
                <br>
                <label class="form-label">Prima:</label>
                <input type="number" id="prima_c" name="prima_c"  min="0.00" step="0.01" value="<?php echo $rowc['prima'] ?>" required><br>
                <br>
                <label class="form-label">Recargo:</label>
                <input type="number" id="recargo_c" name="recargo_c" value="<?php echo $rowc['recargo'] ?>" required><br>
                <br>
                <label class="form-label"></label>
                <button type="submit" style="width:150px;">Actualizar</button>
              </form>
            </div>

        </div>     
    </div>
</div>
<script>

function sendRenting(){ 
  return confirm("Esta seguro que desea actualizar los parametros de renting?");
    
}

function sendCompra(){
  return confirm("Esta seguro que desea actualizar los parametros de compra?");
}


function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" activo", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " activo";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>