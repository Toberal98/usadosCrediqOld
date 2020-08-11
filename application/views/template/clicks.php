<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<!-- Este archivo es para poder exportar los datos que obtengamos  -->
<script type="text/javascript" src="<?php echo base_url() ?>public/js/modules/exporting.js"></script>


<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function(){
    
        var colors = Highcharts.getOptions().colors,
            categories = [<?php foreach($estadisticas_clicks as $dato){ echo "'".$dato['nombre_mes']."', ";} ?>],
            name = 'Clicks por mes',
            data = [
                <?php foreach($estadisticas_clicks as $dato){ echo "{y: ".$dato['total_clicks'].",color: colors[6]},";} ?>
                   ];
    
        function setChart(name, categories, data, color){
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
                text: 'Clicks, <?php echo date('F').', '.date('Y'); ?>'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Total clicks por mes'
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
                        s = this.x +':<b>'+ this.y +' </b><br/>';
                    if (point.drilldown) {
                        s += 'Click to view '+ point.category +' versions';
                    } else {
                        s += 'Click to return to browser brands';
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


<div class="left" id="container2" style="width: 330px; height: 230px; margin:  0 0 0 20px; "></div>