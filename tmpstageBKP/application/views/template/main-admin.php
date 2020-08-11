<style type="text/css">
	.opcion-admin{
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
		color: #fff;
		width: 100%;
		height: 200px;
		text-align: center;
		padding-top: 40px;
	}
	.opcion-admin:hover{
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
	}
	.opcion-admin i{
		font-size: 60px
	}
	.opcion-admin span{
		font-size: 20px;
	}
</style>
<div class="content">
	<div class="containerb">
		<h3>Accesos Rapidos</h3>
		<hr>
		<div class="row">		
			<div class="col-md-4">
				<a href="<?php echo base_url().'index.php/car/add' ?>" style="text-decoration: none">
					<div class="opcion-admin" style="background-color: #42A5F5; margin-top:15px">
						<i class="fas fa-car"></i><br>
						<span>Agregar nuevo vehiculo</span>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="<?php echo base_url().'index.php/car/estado/completado/' ?>" style="text-decoration: none">
					<div class="opcion-admin" style="background-color: #e53935; margin-top:15px">
						<i class="fas fa-list"></i><br>
						<span>Listado de vehiculos</span>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="<?php echo base_url().'index.php/user/crear' ?>" style="text-decoration: none">
					<div class="opcion-admin" style="background-color: #FFA000; margin-top:15px">
						<i class="fas fa-user"></i><br>
						<span>Agregar nuevo usuario</span>
					</div>
				</a>
			</div>	
		</div>
	</div>
</div>
<br><br><br><br><br><br><br><br><br>

