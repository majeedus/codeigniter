<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Ford Test Harness Visualizer</title>

  <?php include("head_section.php"); ?>

  <style>
  a:hover,a:active,a:focus{
    text-decoration: none;
  }
  #wrapper {
    position: relative;
    width: 100%;
    height: 100%;
  }
  #header-img-div{
    display: inline-block;
    margin: 4px;
  }
  .navbar-header h3 {
    vertical-align: top;
    display: inline-block;
    margin: 15px 2px;
    font-weight: 400;
    font-size: 18px;
    color:#676767;
  }
  #header-welcome {
    color: #4C4C4C;
  }
  #left-nav {
    position: absolute;
    left: 0;
    bottom:0;
    top:50px;
    display: inline-block;
    width:200px;
    background-color: #EFEEEE;
    border-color: #e7e7e7;
  }
  #left-nav > .link-wrapper{
    margin:3px;
  }
  .left-nav-link {
    padding:10px;
    color: #fcf9f9;
    background-color: #1d97ef;
  }
  .left-nav-link:hover {
    background-color: #74c3fb;
  }
  .left-nav-link i {
    margin-right: 5px;
  }
  #copyright-div {
    position: absolute;
    bottom:0;
    width: 150px;
    margin: 5px 25px;
    font-size: 10px;
    text-align: center;
  }
  #page-wrapper {
    position: absolute;
    left: 200px;
    bottom:0;
    top:50px;
    right:0;
    overflow-y: scroll;

  }
  .page-title {
    margin:15px;
    border-bottom: 1px solid #A5A5A5;
    color: #4C4C4C;
  }
  table.dataTable thead > tr > th {
    padding:4px;
  }
  </style>
</head>
<body>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <div id="header-img-div"><img src="<?php echo base_url('application/third_party/ford-icon.png');?>" height="40" /></div>
        <h3>Connected Vehicle Protocol Test Harness</h3>
      </div>
      <div style="float:right;vertical-align:middle;margin:3px 10px">
        <div style="display:inline-block;">
          <h4 id="header-welcome">Welcome, <?php echo $username; ?>!</h4>
        </div>
        <div style="margin:10px;display:inline-block;">
          <a href="<?php echo base_url()?>home/logout">Logout</a>
        </div>
      </div>
    </nav>
    <div id="left-nav">
      <div class="link-wrapper"><a href="<?php echo base_url('home')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-home"></i>Home</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/runStats')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-stats"></i>Run Stats</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/tables')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-th-list"></i>Results Table</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/scatter')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-stats"></i>Scatter Graph</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/averageByFileType')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-signal"></i>Average By File Type</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/averageByProtocol')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-signal"></i>Average By Protocol</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/averageSendTimeVTotalTime')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-signal"></i>Average Time Ratio</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/search')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-signal"></i>Custom Graph</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/chart1')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-signal"></i>Chart1</div></a></div>
      <div class="link-wrapper"><a href="<?php echo base_url('welcome/chart2')?>"><div class="left-nav-link"><i class="glyphicon glyphicon-signal"></i>Chart2</div></a></div>

      <div id="copyright-div">&copy; Capstone - Team Ford</div>
    </div>
    <div id="page-wrapper">

<script>
/**
 * Dark theme for Highcharts JS
 * @author Torstein Honsi
 */

Highcharts.theme = {
   colors: ["#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
         stops: [
            [0, '#2a2a2b'],
            [1, '#3e3e40']
         ]
      },
      style: {
         fontFamily: "'Unica One', sans-serif"
      },
      plotBorderColor: '#606063'
   },
   title: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
   },
   subtitle: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
   },
   xAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      }
   },
   yAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      }
   },
   plotOptions: {
      series: {
         dataLabels: {
            color: '#B0B0B3'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      }
   },
   legend: {
      itemStyle: {
         color: '#E0E0E3'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#606063'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#707073'
      }
   },

   drilldown: {
      activeAxisLabelStyle: {
         color: '#F0F0F3'
      },
      activeDataLabelStyle: {
         color: '#F0F0F3'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         theme: {
            fill: '#505053'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: '#505053',
         stroke: '#000000',
         style: {
            color: '#CCC'
         },
         states: {
            hover: {
               fill: '#707073',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: '#000003',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            }
         }
      },
      inputBoxBorderColor: '#505053',
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(255,255,255,0.1)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      },
      xAxis: {
         gridLineColor: '#505053'
      }
   },

   scrollbar: {
      barBackgroundColor: '#808083',
      barBorderColor: '#808083',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: '#606063',
      buttonBorderColor: '#606063',
      rifleColor: '#FFF',
      trackBackgroundColor: '#404043',
      trackBorderColor: '#404043'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   background2: '#505053',
   dataLabelsColor: '#B0B0B3',
   textColor: '#C0C0C0',
   contrastTextColor: '#F0F0F3',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);

</script>
