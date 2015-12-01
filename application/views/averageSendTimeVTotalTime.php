<?php include("header.php"); ?>

    <h1 class="page-title">Average Send Time Vs. Total Time</h1>
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
                        }
                    }
                    var averageAMQP = function(){
                        var amqptotaltime=0;
                        var amqpsendtime=0;
                        for(i=0; i<timeAMQP.length; i++){
                            amqptotaltime+=timeAMQP[i].x;
                            amqpsendtime+=timeAMQP[i].y;
                        }
                        return (amqpsendtime/amqptotaltime)*100;
                    };
                    var averageMQTT = function(){
                        var mqtttotaltime=0;
                        var mqttsendtime=0;
                        for(i=0; i<timeMQTT.length; i++){
                            mqtttotaltime+=timeMQTT[i].x;
                            mqttsendtime+=timeMQTT[i].y;
                        }
                        return (mqttsendtime/mqtttotaltime)*100;
                    };
                    $('#container').highcharts({
                        chart: {
                            type: 'column',
                            zoomType: 'xy'
                        },
                        title: {
                            text: 'Sending Time vs Total Time Average'
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
                            max: 100,
                            title: {
                                text: 'Sending Time / Total Time (%)'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f}%</b></td></tr>',
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