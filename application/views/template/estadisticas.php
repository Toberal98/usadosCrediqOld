<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<!-- Este archivo es para poder exportar los datos que obtengamos -->
<script type="text/javascript" src="<?php echo base_url() ?>public/js/modules/exporting.js"></script>
<?php $moneda=$this->session->userdata('moneda'); ?>
<div id="head-vehiculo">Estadisticas de vehiculos</a></div>
<div class="cabin_blue">Hits y clicks por cada vehiculo</div>
<table width="100%" border="0" id="hor-minimalist-a">
  <tr class="t-head">
    <td >Marca</td>
    <td >Modelo</td>
    <td >Año</th>
    <td >Combustible</td>
    <td >Precio</th>
    <td >acciones</td>
  </tr>

  <?php
  $v=1;
  if(isset($cars)){ foreach ($cars as $car) : 
    if($v>2){ $v=1; }
  ?>
  <tr  class="t_gris<?php echo $v; ?>">
    <td ><?php echo $car['nombre_marca']; ?></td>
    <td ><?php echo $car['modelo']; ?></td>
    <td ><?php echo $car['year']; ?></td>
    <td ><?php echo $car['tipo_comb']; ?></td>
    
    <td ><?php echo $moneda.$car['precio']; ?></td>
    <td ><a href="<?php echo base_url() ?>index.php/car/estadisticas/<?php echo $car['id_automovil'] ?>">Estadisticas</a></td>
  </tr>
  <?php 
    $v++;
  endforeach; } ?>
</table>
<?php 
if(isset($pagination)){
echo '<div class="limiter"></div>';
  echo $pagination;
echo '<div class="limiter"></div>';
}
?>


<script type="text/javascript">
$(function () {
    var chart = new Highcharts.Chart({
		
        chart: {
            renderTo: 'container',
            marginBottom: 150,
			type: 'column'
                
        },
		
        xAxis: {
            categories: [<?php foreach($topMarca as $dato){ echo "'".$dato['nombre']."', ";} ?>],
            labels: { rotation: 270 }
          
        },
		
		 title: { text: 'Marcas' },
		
        yAxis: { title: { text: 'Numero de busquedas' } },
		
		plotOptions: {
            series: {
                dataLabels: { enabled: true },
				borderWidth: 1,
                borderColor: 'white'
            }
        },
		
        series: [{
            data: [<?php foreach($topMarca as $dato){ echo $dato['valor'].","; } ?>]        
        }]
		
    });
});
</script>

    
 
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function(){
    
        var colors = Highcharts.getOptions().colors,
            categories = [<?php foreach($TopModelo as $dato){ echo "'".$dato['nombre']."', ";} ?>],
            name = 'Clicks por Modelo',
            data = [<?php foreach($TopModelo as $dato){ echo "{y: ".$dato['valor'].",color: colors[6]},";} ?>];
    
        function setChart(name, categories, data, color) {
            chart.xAxis[0].setCategories(categories);
            chart.series[0].remove();
            chart.addSeries({
                name: name,
                data: data,
                color: color || 'white'
            });
        }
    
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container2',
                type: 'column'
            },
            title: {
                <?php date_default_timezone_set('America/El_Salvador'); ?>
                text: 'Modelos'
            },
            xAxis: {
                categories: categories,
				labels: { rotation: 270 }
            },
            yAxis: {
                title: {
                    text: 'Numero de busquedas'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    setChart(name, categories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +':<b>'+ this.y +'</b><br/>';
                    if (point.drilldown) {
                        s += 'Click to view '+ point.category +' versions';
                    } else {
                        s += '';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: 'white'
            }],
            exporting: {
                enabled: false
            }
        });
    });
    
});
    </script>    
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function(){
    
        var colors = Highcharts.getOptions().colors,
            categories = [<?php foreach($TopAnio as $dato){ echo "'".$dato['nombre']."', ";} ?>],
            name = 'Clicks por Año',
            data = [
                <?php foreach($TopAnio as $dato){ echo "{y: ".$dato['valor'].",color: colors[6]},";} ?>
                   ];
    
        function setChart(name, categories, data, color) {
            chart.xAxis[0].setCategories(categories);
            chart.series[0].remove();
            chart.addSeries({
                name: name,
                data: data,
                color: color || 'white'
            });
        }
    
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container3',
                type: 'column'
            },
            title: {
                text: 'Año mas buscado'
            },
            xAxis: {
                categories: categories,
				labels: { rotation: 270 }
            },
            yAxis: {
                title: {
                    text: 'Numero de busquedas'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    setChart(name, categories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y;
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +':<b>'+ this.y +'</b><br/>';
                    if (point.drilldown) {
                        s += 'Click to view '+ point.category +' versions';
                    } else {
                        s += '';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: 'white'
            }],
            exporting: {
                enabled: false
            }
        });
    });
    
});
    </script>        

    <br><br><br>
<div class="left" id="container" style="width: 660px; height: 350px; margin:  0 0 0 20px; "></div>
<div class="clear_10"></div>
<div class="left" id="container2" style="width: 660px; height: 630px; margin:  0 0 0 20px; "></div>
<div class="clear_10"></div>
<div class="left" id="container3" style="width: 660px; height: 330px; margin:  0 0 0 20px; "></div>
<div class="clear_10"></div>