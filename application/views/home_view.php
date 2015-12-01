<?php include("header.php"); ?>

<h1 class="page-title">Home</h1>

<div style="min-width:620; max-width:900px; margin: 0 auto;">
  <div id="bar" style="min-width: 400px; height: 400px; max-width: 400px; margin: 10px; display:inline-block;"></div>
  <div id="pie" style="min-width: 400px; height: 400px; max-width: 400px; margin: 10px; display:inline-block;"></div>
  <div id="pieFile" style="min-width: 400px; height: 400px; max-width: 400px; margin: 10px; display:inline-block;"></div>
  <div id="stacked" style="min-width: 400px; height: 400px; max-width: 400px; margin: 10px; display:inline-block;"></div>
</div>

<?php include("footer.php"); ?>

<script>
function drawchart(){
  $.ajax({
    url: '<?php echo base_url('index.php/welcome/data');?>',
    type: 'GET',
    dataType: 'text',
    complete: function() {
    },
    success: function(data) {
      var types = '<?php echo json_encode($fileTypes); ?>';
      var types = JSON.parse(types);
      var runs = '<?php echo json_encode($runs);?>';
      var runs = JSON.parse(runs);
      var averages = '<?php echo json_encode($averageTotal)?>';
      var averages = JSON.parse(averages);
      console.log(averages);
      var typeObjects = [];
      $.each(types, function (index, value) {
        typeObjects.push([value.file_type, parseFloat(value.count)]);
      });
      var runObjects = [];
      $.each(runs, function (index, value) {
        runObjects.push([value.protocol, parseFloat(value.count)]);
      });
      console.log(runObjects);
      var averageObject = [];
      var categoriesObject = [];
      $.each(averages, function (index, value) {
        averageObject.push([value.protocol, parseFloat(value.total_time)]);
        categoriesObject.push([value.protocol]);
      });
      console.log(averageObject);
      var amqpRuns = 0; var amqpEncrypt = 0;
      var mqttRuns = 0; var mqttEncrypt = 0;
      var restRuns = 0; var restEncrypt = 0;
      var results = JSON.parse(data);
      for(i=0; i < results.length; i++){
        if(results[i].protocol === "AMQP"){
          amqpRuns++;
          if(results[i].encryption_used === "AES"){
            amqpEncrypt++;
          }
        } else if(results[i].protocol === "MQTT"){
          mqttRuns++;
          if(results[i].encryption_used === "AES"){
            mqttEncrypt++;
          }
        } else if(results[i].protocol === "REST"){
          restRuns++;
        }
      }

      $('#pie').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },
        title: {
          text: 'Percentage of Protocol Tests Run'
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b>: {point.percentage:.1f} %',
              style: {
                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
              }
            }
          }
        },
        series: [{
          name: 'Protocols',
          colorByPoint: true,
          data: runObjects
          }]
        });

        $('#stacked').highcharts({
          chart: {
            type: 'bar'
          },
          title: {
            text: 'Breakdown of Protocol Runs'
          },
          xAxis: {
            categories: ['REST', 'AMQP', 'MQTT']
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Total Runs Breakdown'
            }
          },
          legend: {
            reversed: true
          },
          plotOptions: {
            series: {
              stacking: 'normal'
            }
          },
          series: [{
            name: 'Encrypted',
            data: [0, amqpEncrypt, mqttEncrypt]
          }, {
            name: 'Unencrypted',
            data: [restRuns, (amqpRuns - amqpEncrypt), (mqttRuns - mqttEncrypt)]
          }]
        });

        $('#pieFile').highcharts({
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Percentage of Total Files'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
              }
            }
          },
          series: [{
            name: 'File Type',
            colorByPoint: true,
            data: typeObjects
            }]
          });

          $('#bar').highcharts({
            chart: {
              type: 'column',
              zoomType: 'xy'
            },
            title: {
              text: 'Average Total Time'
            },
            subtitle: {
              text: 'Source: Test Harness'
            },
            xAxis: {
              title: {
                enabled: true,
                text: 'Protocol'
              },
              categories: categoriesObject,
              showLastLabel: true
            },
            yAxis: {
              min: 0,
              title: {
                text: 'Time (seconds)'
              }
            },
            tooltip: {
              headerFormat: '<span><h4>{point.key}</h4></span><table width=175>',
              pointFormat: '<tr><td style="color:#FFF;padding:0">{series.name}: </td>' +
              '<td style="font-size:100%;color:#FFF">{point.y:.1f} second(s)</td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
            },
            plotOptions: {
              column: {
                pointPadding: 0.2,
                borderWidth: 0,
                colorByPoint: true
              }
            },
            series: [{
              name: 'Time (s)',
              data: averageObject
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
