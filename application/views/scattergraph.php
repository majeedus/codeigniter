
<?php include("header.php"); ?>

<h1 class="page-title">Scatter Graph</h1>
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

      $('#container').highcharts({
        chart: {
          type: 'scatter',
          zoomType: 'xy'
        },
        title: {
          text: 'Sending Time vs Total Time'
        },
        subtitle: {
          text: 'Source: Test Harness'
        },
        xAxis: {
          title: {
            enabled: true,
            text: 'Total Time (sec)'
          },
          min: 0,
          startOnTick: true,
          endOnTick: true,
          showLastLabel: true
        },
        yAxis: {
          title: {
            text: 'Sending Time (sec)'
          }
        },
        legend: {
          layout: 'vertical',
          align: 'left',
          verticalAlign: 'top',
          x: 70,
          y: 70,
          floating: true,
          backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
          borderWidth: 1
        },
        plotOptions: {
          scatter: {
            marker: {
              radius: 3,
              states: {
                hover: {
                  enabled: true,
                  lineColor: 'rgb(100,100,100)'
                }
              }
            },
            states: {
              hover: {
                marker: {
                  enabled: false
                }
              }
            },
            tooltip: {
              headerFormat: '<b>{series.name}</b><br>',
              pointFormat: 'Total Time: {point.x} seconds, Sending Time: {point.y} seconds,' +
              '<br> File Size: {point.file_size} KB, Package Size: {point.package_size} KB',
            }
          }
        },
        series: [{
          turboThreshold:10000, //set it to a larger threshold, it is by default to 1000
          name: 'AMQP',
          color: 'rgba(0, 255, 0, .75)',
          data: timeAMQP
        }, {
          turboThreshold:10000, //set it to a larger threshold, it is by default to 1000
          name: 'MQTT',
          color: 'rgba(0, 255, 255, .75)',
          data: timeMQTT
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
