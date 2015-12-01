<?php include("header.php"); ?>

    <h1 class="page-title">Average By Protocol</h1>
    <div id="container" style="min-width: 310px; height: 600px; max-width: 800px; margin: 0 auto"></div>

    <script>
        function drawchart(){
            $.ajax({
                url: '<?php echo base_url('index.php/welcome/data');?>',
                type: 'GET',
                dataType: 'text',
                complete: function() {
                },
                success: function(data) {
                    var timeAMQP = [];
                    var timeMQTT = [];
                    var timeREST = [];
                    var results = JSON.parse(data);
                    for(i=0; i < results.length; i++){
                        if(results[i].protocol === "AMQP"){
                            var amqp = {};
                            amqp.x = parseFloat(results[i].total_time);
                            amqp.y = parseFloat(results[i].send_time);
                            amqp.file_size = results[i].file_size;
                            amqp.package_size = results[i].pkt_size;
                            //var amqp = [parseFloat(results[i].total_time), parseFloat(results[i].send_time), results[i].file_size];
                            timeAMQP.push(amqp);
                        } else if(results[i].protocol === "MQTT"){
                            var mqtt = {};
                            mqtt.x = parseFloat(results[i].total_time);
                            mqtt.y = parseFloat(results[i].send_time);
                            mqtt.file_size = results[i].file_size;
                            mqtt.package_size = results[i].pkt_size;
                            timeMQTT.push(mqtt);
                        } else if(results[i].protocol === "REST"){
                            var rest = {};
                            rest.x = parseFloat(results[i].total_time);
                            rest.file_size = results[i].file_size;
                            timeREST.push(rest);
                        }
                    }
                    var averageAMQP = function(){
                        var amqptotaltime=0;
                        for(i=0; i<timeAMQP.length; i++){
                            amqptotaltime+=(timeAMQP[i].file_size/timeAMQP[i].x);
                        }
                        return (amqptotaltime/timeAMQP.length);
                    };
                    var averageMQTT = function(){
                        var mqtttotaltime=0;
                        for(i=0; i<timeMQTT.length; i++){
                            mqtttotaltime+=(timeMQTT[i].file_size/timeMQTT[i].x);
                        }
                        return (mqtttotaltime/timeMQTT.length);
                    };
                    var averageREST = function(){
                        var resttotaltime=0;
                        for(i=0; i<timeREST.length; ++i){
                            resttotaltime+=(timeREST[i].file_size/timeREST[i].x);
                        }
                        return (resttotaltime/timeREST.length);
                    };
                    $('#container').highcharts({
                        chart: {
                            type: 'column',
                            zoomType: 'xy'
                        },
                        title: {
                            text: 'Average Total Time vs Protocol'
                        },
                        subtitle: {
                            text: 'Source: Test Harness'
                        },
                        xAxis: {
                            title: {
                                enabled: false,
                                text: 'Protocol'
                            },
                            categories: [
                                'Protocol'
                            ],
                            showLastLabel: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Speed (KB/s)'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} KB/s</b></td></tr>',
                            footerFormat: '</table>',
                            shared: false,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [{
                            name: 'AMQP',
                            data: [averageAMQP()]

                        }, {
                            name: 'MQTT',
                            data: [averageMQTT()]

                        }, {
                            name: 'REST',
                            data: [averageREST()]

                        }]
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
        $(document).ready(function() {
            drawchart();
        } );
        $(function () {
        });
    </script>

<?php include("footer.php"); ?>