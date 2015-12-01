<head>
  <title>Ford Login</title>
  <link href="<?php echo base_url('application/third_party/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
  
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
  </style>
  
</head>
<body>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	      <div class="navbar-header">
	      		<div id="header-img-div"><img src="<?php echo base_url('application/third_party/ford-icon.png');?>" height="40" /></div>
	      		<h3>Connected Vehicle Protocol Test Harness</h3>
	      </div>
	      <div style="float:right;vertical-align:middle;margin:3px 10px">
	      </div>
	    </nav>
<div class="container">
  <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info" >
      <div class="panel-heading">
        <div class="panel-title">Sign In</div>
      </div>

      <div style="padding-top:30px" class="panel-body" >

        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

        <?php echo validation_errors(); ?>
        <?php echo form_open('verifylogin'); ?>
        <form id="loginform" class="form-horizontal" role="form">
          <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="username" type="text" class="form-control" name="username" value="" placeholder="username">
          </div>

          <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="password" type="password" class="form-control" name="password" placeholder="password">
          </div>
          <div style="margin-top:10px" class="form-group">
            <div class="col-sm-12 controls">
              <input class="btn btn-success" type="submit" value="Login"/>
            </div>
          </div>
        </form>
        <?php echo form_close(); ?>


      </div>
    </div>
  </div>
</body>
</html>
