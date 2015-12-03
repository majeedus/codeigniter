<?php include("header.php"); ?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<input type='hidden' id='value_draw' value='256,512,1076,2121' />




<script>

    /**
     * In order to synchronize tooltips and crosshairs, override the
     * built-in events with handlers defined on the parent element.
     */
    $('#container').bind('mousemove touchmove', function (e) {
        var chart,
            point,
            i;

        for (i = 0; i < Highcharts.charts.length; i = i + 1) {
            chart = Highcharts.charts[i];
            e = chart.pointer.normalize(e); // Find coordinates within the chart
            point = chart.series[0].searchPoint(e, true); // Get the hovered point

            if (point) {
                point.onMouseOver(); // Show the hover marker
                chart.tooltip.refresh(point); // Show the tooltip
                chart.xAxis[0].drawCrosshair(e, point); // Show the crosshair
            }
        }
    });
    /**
     * Override the reset function, we don't need to hide the tooltips and crosshairs.
     */
    Highcharts.Pointer.prototype.reset = function () {
        return undefined;
    };

    /**
     * Synchronize zooming through the setExtremes event handler.
     */
    function syncExtremes(e) {
        var thisChart = this.chart;

        if (e.trigger !== 'syncExtremes') { // Prevent feedback loop
            Highcharts.each(Highcharts.charts, function (chart) {
                if (chart !== thisChart) {
                    if (chart.xAxis[0].setExtremes) { // It is null while updating
                        chart.xAxis[0].setExtremes(e.min, e.max, undefined, false, { trigger: 'syncExtremes' });
                    }
                }
            });
        }
    }

    function drawchart(){
        $('#container').empty();
        $.ajax({
            url: '<?= base_url('welcome/selectdata') ?>',
            type: 'post',
            dataType: 'text',
            complete: function() {
            },
            success: function(html) {
                var arr = [];
                var arr1 = [];
                var arr2 = [];
                var arr3 = [];
                var text1 = html.split('<!--');
                var json = JSON.parse(text1[0]);
                var i = 0;
                var value_draw = $('#value_draw').val().split(',');
                for(var x in json){
                    var file_size = parseFloat(json[x]['file_size']);
                    var totaltime = parseFloat(json[x]['total_time']);
                    if (parseFloat(value_draw[0]) <= file_size && file_size <= parseFloat(value_draw[1])){
                        if (json[x]['protocol']== 'MQTT'  ){
                            arr.push(totaltime);
                        }else if (json[x]['protocol']== 'AMQP' ){
                            arr1.push(totaltime);
                        }else if (json[x]['protocol']== 'REST' ){
                            arr2.push(totaltime);
                        }
                    }
                }
                for (var i = 0 ;(i < arr.length ) || (i < arr1.length ) || ( i <  arr2.length ) ; i++){

                    var tong = 0;
                    if (arr[i]){
                        tong += parseFloat(arr[i]);
                    }
                    if (arr1[i]){
                        tong += parseFloat(arr1[i]);
                    }
                    if (arr2[i]){
                        tong += parseFloat(arr2[i]);
                    }
                    arr3.push(tong/3);
                }

                $('<div class="chart">').appendTo('#container').highcharts({
                    chart: {
                        marginLeft: 40, // Keep all charts left aligned
                        spacingTop: 20,
                        spacingBottom: 20,
                        zoomType: 'x'
                    },
                    title: {
                        text: "MQTT",
                        align: 'left',
                        margin: 0,
                        x: 30
                    },
                    credits: {
                        enabled: false
                    },
                    legend: {
                        enabled: false
                    },
                    xAxis: {
                        crosshair: true,
                        events: {
                            setExtremes: syncExtremes
                        },
                        labels: {
                            format: '{value}'
                        }
                    },
                    yAxis: {
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        positioner: function () {
                            return {
                                x: this.chart.chartWidth - this.label.width, // right aligned
                                y: -1 // align to title
                            };
                        },
                        borderWidth: 0,
                        backgroundColor: 'none',
                        pointFormat: '{point.y}',
                        headerFormat: '',
                        shadow: false,
                        style: {
                            fontSize: '18px'
                        },
                        valueDecimals: '0'
                    },
                    series: [  {

                        name: 'REST',
                        data: arr,
                        type: 'area',
                        color: Highcharts.getOptions().colors[0],
                        fillOpacity: 0.3,
                        tooltip: {
                            valueSuffix: ' ' + 'ms'
                        }
                    }]
                })
                $('<div class="chart">').appendTo('#container').highcharts({
                    chart: {
                        marginLeft: 40, // Keep all charts left aligned
                        spacingTop: 20,
                        spacingBottom: 20,
                        zoomType: 'x'
                    },
                    title: {
                        text: "AMQP",
                        align: 'left',
                        margin: 0,
                        x: 30
                    },
                    credits: {
                        enabled: false
                    },
                    legend: {
                        enabled: false
                    },
                    xAxis: {
                        crosshair: true,
                        events: {
                            setExtremes: syncExtremes
                        },
                        labels: {
                            format: '{value}'
                        }
                    },
                    yAxis: {
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        positioner: function () {
                            return {
                                x: this.chart.chartWidth - this.label.width, // right aligned
                                y: -1 // align to title
                            };
                        },
                        borderWidth: 0,
                        backgroundColor: 'none',
                        pointFormat: '{point.y}',
                        headerFormat: '',
                        shadow: false,
                        style: {
                            fontSize: '18px'
                        },
                        valueDecimals: '0'
                    },
                    series: [{
                        name: 'AMQP',
                        data: arr1,
                        type: 'area',
                        color: Highcharts.getOptions().colors[1],
                        fillOpacity: 0.3,
                        tooltip: {
                            valueSuffix: ' ' + 'ms'
                        }
                    }]
                });
                $('<div class="chart">').appendTo('#container').highcharts({
                    chart: {
                        marginLeft: 40, // Keep all charts left aligned
                        spacingTop: 20,
                        spacingBottom: 20,
                        zoomType: 'x'
                    },
                    title: {
                        text: "REST",
                        align: 'left',
                        margin: 0,
                        x: 30
                    },
                    credits: {
                        enabled: false
                    },
                    legend: {
                        enabled: false
                    },
                    xAxis: {
                        crosshair: true,
                        events: {
                            setExtremes: syncExtremes
                        },
                        labels: {
                            format: '{value}'
                        }
                    },
                    yAxis: {
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        positioner: function () {
                            return {
                                x: this.chart.chartWidth - this.label.width, // right aligned
                                y: -1 // align to title
                            };
                        },
                        borderWidth: 0,
                        backgroundColor: 'none',
                        pointFormat: '{point.y}',
                        headerFormat: '',
                        shadow: false,
                        style: {
                            fontSize: '18px'
                        },
                        valueDecimals: '0'
                    },
                    series: [  {

                        name: 'REST',
                        data: arr2,
                        type: 'area',
                        color: Highcharts.getOptions().colors[2],
                        fillOpacity: 0.3,
                        tooltip: {
                            valueSuffix: ' ' + 'ms'
                        }
                    }]
                });
                $('<div class="chart">').appendTo('#container').highcharts({
                    chart: {
                        marginLeft: 40, // Keep all charts left aligned
                        spacingTop: 20,
                        spacingBottom: 20,
                        zoomType: 'x'
                    },
                    title: {
                        text: "Average",
                        align: 'left',
                        margin: 0,
                        x: 30
                    },
                    credits: {
                        enabled: false
                    },
                    legend: {
                        enabled: false
                    },
                    xAxis: {
                        crosshair: true,
                        events: {
                            setExtremes: syncExtremes
                        },
                        labels: {
                            format: '{value}'
                        }
                    },
                    yAxis: {
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {
                        positioner: function () {
                            return {
                                x: this.chart.chartWidth - this.label.width, // right aligned
                                y: -1 // align to title
                            };
                        },
                        borderWidth: 0,
                        backgroundColor: 'none',
                        pointFormat: '{point.y}',
                        headerFormat: '',
                        shadow: false,
                        style: {
                            fontSize: '18px'
                        },
                        valueDecimals: '0'
                    },
                    series: [{

                        name: 'Average',
                        data: arr3,
                        type: 'area',
                        color: Highcharts.getOptions().colors[3],
                        fillOpacity: 0.3,
                        tooltip: {
                            valueSuffix: ' ' + 'ms'
                        }
                    } ]
                });

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });


    }
    $(document).ready(function() {
        //$("#value_draw").slider({});
        drawchart();
        $('#value_draw').change(function(){
            drawchart();
        })
    } );


</script>
