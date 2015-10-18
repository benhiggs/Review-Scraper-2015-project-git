<!DOCTYPE html>
<?php
session_start();
include 'constants.php';
checklogin();
?>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website Scraper">
    <meta name="author" content="Group H">
    <link rel="icon" href="favicon.ico">

    <title>Hotel review scraper</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./js/ie-emulation-modes-warning.js"></script><style type="text/css"></style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      var hook = true;
      window.onbeforeunload = function() {
        if (hook) {
          return "Please log out first"
        }
      }
      function unhook() {
        hook=false;
      }
      function bypass(){
        unhook();
    }
    </script>
  </head>


  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Group H - Review Scraper</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="inactive"><a onclick="bypass()" href="home.php">Introduction</a></li>
            <li class="inactive"><a onclick="bypass()" href="scrape.php">Scrape!</a></li>
            <li class="inactive"><a onclick="bypass()" href="project_info.php">Project Info</a></li>
            <li class="active"><a onclick="bypass()" href="license.php">Licensing</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="inactive"><a onclick="bypass()" href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
            <li class="inactive"><a onclick="bypass()" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>








    <div class="container">
      <div class="starter-template">
        <h1>Licenses</h1>
      </div>

    </div>













    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
  

</body></html>