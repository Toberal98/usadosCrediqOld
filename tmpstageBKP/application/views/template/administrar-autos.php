<?php $moneda = $this->session->userdata('moneda'); ?>

<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">            	
                <h3>Veh&iacute;culos<span></span></h3>
                <p class="title-sec">Listado de veh&iacute;culos <?php echo $estado; ?></p>
                <br>
                <p style="display:inline">
                    <a href="<?php echo base_url().'index.php/car/add'?>" class="nuevo" target="_top">Nuevo Auto</a>
                    <span style='background-color: #FFE082; float:right'>Autos aun no visibles.</span>
                </p>
                <div class="tabla">
                <input type="search" class="light-table-filter" data-table="order-table" placeholder="Filter">
                <br>
                <br>
                    <table class="order-table table" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>  
                            <th >Marca</th>
                            <th >Modelo</th>   
                            <th >Tipo</th>                       
                            <th >Cuota Compra</th>
                            <th>Cuota Renting</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                        <?php
                            $visible = array("no" => "style='background-color: #FFE082;'");
                            foreach ($cars as $car) :
                                ?>
                                <tr <?php echo $visible[$car["visible"]]; ?>>

                                    <td><?php echo $car['id_automovil']; ?></td>
                                    <td><?php echo $car['marca']; ?></td>
                                    <td><?php echo $car['modelo']; ?></td>
                                    <td><?php echo $car['tipo_vehiculo']; ?></td>
                                    <td><?php echo $moneda. number_format($car['cuota_compra'],2); ?></td>
                                    <td><?php echo $moneda. number_format($car['cuota_renting'],2); ?></td>
                                    <td> 
                                        <a href="<?php echo base_url() ?>index.php/car/administrar/editar/<?php echo $car['id_automovil'] ?>">Editar <i class="fas fa-edit"></i></a>
                                        <a href="#" onclick="openformDel('<?php echo $car['id_automovil'] ?>','<?php echo $car['idrenting'] ?>','<?php echo $car['idcompra'] ?>');">Eliminar <i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php

                            endforeach;
                        ?>

                    </table> 

                    <?php
                    if (isset($pagination)) {
                        echo '<div class="limiter"></div>';
                        echo $pagination;
                        echo '<div class="limiter"></div>';
                    }
                    ?>
                </div>                
            </div>
        </div>     
    </div>
</div>

<script>
    function openformDel(id, ren, com){
        swal({
          title: "Esta seguro?",
          text: "Desea eliminar este registro?",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Registro eliminado!", {
              icon: "success",
            });
            window.location.replace("<?php echo base_url() ?>index.php/savedata/deleteCar/"+id+"/"+ren+"/"+com);
          } else {
            
          }
        });
    }

(function(document) {
	'use strict';

	var LightTableFilter = (function(Arr) {

		var _input;

		function _onInputEvent(e) {
			_input = e.target;
			var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
			Arr.forEach.call(tables, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, _filter);
				});
			});
		}

		function _filter(row) {
			var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('light-table-filter');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = _onInputEvent;
				});
			}
		};
	})(Array.prototype);

	document.addEventListener('readystatechange', function() {
		if (document.readyState === 'complete') {
			LightTableFilter.init();
		}
	});

})(document);
</script>