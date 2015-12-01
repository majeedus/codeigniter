<?php include("header.php"); ?>
<?php
//quick make sure there are actually results, if not just go back.
if (isset($_SERVER["HTTP_REFERER"]) && count($results) == 0) {
  header("Location: " . $_SERVER["HTTP_REFERER"]);
}
?>

<div id="container" style="min-width: 310px; height: 600px; max-width: 800px; margin: 0 auto"></div>

<script>
Array.prototype.contains = function(k) {
  for(var i=0; i < this.length; i++){
    if(this[i] === k){
      return true;
    }
  }
  return false;
}
function drawchart(){
  var multiple = '<?php echo json_encode($multiple); ?>';
  var data = '<?php echo json_encode($results); ?>';
  var categories = [];
  var catArray = [];
  var results = JSON.parse(data);

  if(multiple !== "false"){
    for(var x = 0; x < results.length; x++){
      for(var i = 0; i < results[x].length; i++){
        if(!categories.contains(String(results[x][i].protocol + " - " + results[x][i].file_type))){
          categories.push(String(results[x][i].protocol + " - " + results[x][i].file_type));
          var obj = {};
          obj.type = results[x][i].file_type;
          obj.protocol = results[x][i].protocol;
          obj.time = 0;
          obj.count = 0;
          obj.avg = 0;
          catArray.push(obj);
        }
      }
    }
    for(var i = 0; i < results.length; i++){
      for(var j = 0; j < results[i].length; j++){
        for(var k = 0; k < catArray.length; k++){
          if(catArray[k].type === results[i][j].file_type && catArray[k].protocol === results[i][j].protocol){
            if(typeof(results[i][j].total_time) !== "undefined"){
              catArray[k].time += parseFloat(results[i][j].total_time);
            } else {
              catArray[k].time += parseFloat(results[i][j].send_time);
            }
            catArray[k].count++;
            catArray[k].avg = (catArray[k].time / catArray[k].count);
          }
        }
      }
    }
  } else {
    //cry a river, dev note, this sucks, a lot.
    for(var x = 0; x < results.length; x++){
      if(!categories.contains(String(results[x].protocol + " - " + results[x].file_type))){
        categories.push(String(results[x].protocol + " - " + results[x].file_type));
        var obj = {};
        obj.type = results[x].file_type;
        obj.protocol = results[x].protocol;
        obj.time = 0;
        obj.count = 0;
        obj.avg = 0;
        catArray.push(obj);
      }
    }
    // console.log(catArray);
    for(var i = 0; i < results.length; i++){
      for(var k = 0; k < catArray.length; k++){
        if(catArray[k].type === results[i].file_type && catArray[k].protocol === results[i].protocol){
          if(typeof(results[i].total_time) !== "undefined"){
            catArray[k].time += parseFloat(results[i].total_time);
          } else {
            catArray[k].time += parseFloat(results[i].send_time);
          }
          catArray[k].count++;
          catArray[k].avg = (catArray[k].time / catArray[k].count);
        }
      }
    }
  }
  var objects = [];
  $.each(catArray, function (index, value) {
    objects.push([value.name, value.avg]);
  });
  $('#container').highcharts({
    chart: {
      type: 'column',
      zoomType: 'xy'
    },
    title: {
      text: 'Time vs File Type'
    },
    subtitle: {
      text: 'Source: Test Harness'
    },
    xAxis: {
      title: {
        enabled: true,
        text: 'File Type'
      },
      categories: categories,
      showLastLabel: true
    },
    yAxis: {
      min: 0,
      title: {
        text: 'Time'
      }
    },
    tooltip: {
      headerFormat: '<span><h4>{point.key}</h4></span><table width=150>',
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
      data: objects

    }]
  });
}

$(document).ready(function() {
  drawchart();
});
</script>

<?php include("footer.php"); ?>
