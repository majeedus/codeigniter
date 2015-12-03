<?php include("header.php"); ?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<input type='hidden' id='value_draw' value='256,512,1076,2121' />

<script>

    function drawchart(){
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
                $('#container').highcharts({
                    title: {
                        text: 'Results'
                    },
                    xAxis: {
                        categories: ['0', '1']
                    },
                    yAxis: {

                        title: {
                            text: 'Time'
                        }
                    },
                    labels: {
                        items: [{
                            html: '',
                            style: {
                                left: '50px',
                                top: '18px',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                            }
                        }]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{

                        name: 'MQTT',
                        data: arr,
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[0],
                            fillColor: 'white'
                        }
                    }, {

                        name: 'AMQP',
                        data: arr1,
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[1],
                            fillColor: 'white'
                        }
                    }, {

                        name: 'REST',
                        data: arr2,
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[2],
                            fillColor: 'white'
                        }
                    }, {

                        name: 'Average',
                        data: arr3,
                        marker: {
                            lineWidth: 2,
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
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
    } );






</script>