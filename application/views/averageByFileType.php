<?php include("header.php"); ?>

    <h1 class="page-title">Average By File Type</h1>
    <div id="container" style="min-width: 310px; height: 600px; max-width: 800px; margin: 0 auto"></div>

    <script>
        function drawchart(){
            $.ajax({
                url: '<?php echo base_url('index.php/welcome/data');?>',
                type: 'GET',
                dataType: 'text',
                complete: function() {
                    //console.log("Complete");
                },
                success: function(data) {
                    var fileTypes = [];
                    var MQTTtotal_time = [];
                    var MQTTsend_time = [];
                    var MQTTtally = [];
                    var AMQPtotal_time = [];
                    var AMQPsend_time = [];
                    var AMQPtally = [];
                    var RESTtotal_time = [];
                    var RESTtally = [];
                    var AMQP = [];
                    var MQTT = [];
                    var REST = [];
                    var results = JSON.parse(data);
                    for(i = 0; i < results.length; ++i){
                        var index = jQuery.inArray(results[i].file_type, fileTypes);
                        if(index == -1){
                            fileTypes.push(results[i].file_type);
                            index = fileTypes.length - 1;
                            MQTTtotal_time[index] = 0;
                            MQTTsend_time[index] = 0;
                            MQTTtally[index] = 0;
                            AMQPtotal_time[index] = 0;
                            AMQPsend_time[index] = 0;
                            AMQPtally[index] = 0;
                            RESTtotal_time[index] = 0;
                            RESTtally[index] = 0;
                        }
                        if(results[i].protocol === "AMQP"){
                            var amqp = {};
                            amqp.x = parseFloat(results[i].total_time);
                            amqp.y = parseFloat(results[i].send_time);
                            amqp.file_size = results[i].file_size;
                            amqp.package_size = results[i].pkt_size;
                            amqp.file_type = results[i].file_type;
                            AMQP.push(amqp);
                            //console.log("AMQP: ", amqp.file_size, " ", amqp.x, " " , amqp.file_size/amqp.y);
                            AMQPtotal_time[index]+=(amqp.file_size/amqp.x);
                            AMQPsend_time[index]+=(amqp.file_size/amqp.y);
                            AMQPtally[index]++;
                        } else if(results[i].protocol === "MQTT"){
                            var mqtt = {};
                            mqtt.x = parseFloat(results[i].total_time);
                            mqtt.y = parseFloat(results[i].send_time);
                            mqtt.file_size = results[i].file_size;
                            mqtt.package_size = results[i].pkt_size;
                            mqtt.file_type = results[i].file_type;
                            MQTT.push(mqtt);
                            //console.log("MQTT: ", mqtt.file_size, " ", mqtt.x, " " , mqtt.file_size/mqtt.y);
                            MQTTtotal_time[index]+=(mqtt.file_size/mqtt.x);
                            MQTTsend_time[index]+=(mqtt.file_size/mqtt.y);
                            MQTTtally[index]++;
                        } else if(results[i].protocol === "REST"){
                            var rest = {};
                            rest.x = parseFloat(results[i].total_time);
                            rest.file_size = results[i].file_size;
                            rest.file_type = results[i].file_type;
                            REST.push(rest);
                            RESTtotal_time[index]+=(rest.file_size/rest.x);
                            RESTtally[index]++;
                        }
                    }

                    var AMQPDataTotal = [];
                    var AMQPDataSend = [];
                    var MQTTDataTotal = [];
                    var MQTTDataSend = [];
                    var RESTData = [];
                    for(i=0;i<fileTypes.length;++i){
                        if(AMQPtally[i]==0){
                            AMQPDataTotal[i] = 0;
                            AMQPDataSend[i] = 0;
                        }
                        else {
                            AMQPDataTotal[i] = AMQPtotal_time[i] / AMQPtally[i];
                            AMQPDataSend[i] = AMQPsend_time[i] / AMQPtally[i];
                        }
                        if(MQTTtally[i]==0){
                            MQTTDataTotal[i] = 0;
                            MQTTDataSend[i] = 0;
                        }
                        else {
                            MQTTDataTotal[i] = MQTTtotal_time[i] / MQTTtally[i];
                            MQTTDataSend[i] = MQTTsend_time[i] / MQTTtally[i];
                        }
                        if(RESTtally[i]==0){
                            RESTData[i] = 0;
                        }
                        else {
                            RESTData[i] = RESTtotal_time[i] / RESTtally[i];
                        }
                    }
                    //console.log(AMQPDataTotal);
                    console.log(AMQPsend_time);
                    //console.log(AMQPtally);
                    //console.log(AMQPDataSend);
                    //console.log(MQTTDataTotal);
                    console.log(MQTTDataSend);
                    //console.log(RESTtotal_time);
                    //console.log(RESTtally);
                    //console.log(RESTData);
                    $('#container').highcharts({
                        chart: {
                            type: 'column',
                            zoomType: 'xy'
                        },
                        title: {
                            text: 'Sending Time vs File Type'
                        },
                        subtitle: {
                            text: 'Source: Test Harness'
                        },
                        xAxis: {
                            title: {
                                enabled: true,
                                text: 'Protocol'
                            },
                            categories: fileTypes,
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
                                pointPadding: 0.1,
                                borderWidth: 0
                            }
                        },
                        series: [{
                            name: 'AMQP Total Time',
                            data: AMQPDataTotal
                        //}, {
                        //    name: 'AMQP Send Time',
                        //    data: AMQPDataSend
                        }, {
                            name: 'MQTT Total Time',
                            data: MQTTDataTotal
                        //}, {
                        //    name: 'MQTT Send Time',
                        //    data: MQTTDataSend
                        }, {
                            name: 'REST Total Time',
                            data: RESTData
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