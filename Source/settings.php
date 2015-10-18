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
            <li class="inactive"><a onclick="bypass()" href="license.php">Licensing</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a onclick="bypass()" href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
            <li class="inactive"><a onclick="bypass()" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>








    <div class="container">
      <div class="starter-template">
        <h1>Settings</h1>
      </div>
      <div class="row">

      <div class="col-sm-4">
      <h3>Change Account Settings</h3>
      <u><b>Change password</b></u><br><br>
      <form role="form" action='functions.php' method='post'>
      <div class="form-group">
        <label for="pwd">Current password:</label>
        <input type="password" class="form-control" name="password1" placeholder="Enter current password"><br>
        <label for="pwd">New password:</label>
        <input type="password" class="form-control" name="password2" placeholder="Enter new password"><br>
        <label for="pwd">Confirm new password:</label>
        <input type="password" class="form-control" name="password3" placeholder="Confirm new password">
      </div>
      <button type="update" name="changepw" onclick="bypass()" class="btn btn-default">Update Password</button>
      </form>
      <?php //error checks//          
          if (isset ($_SESSION["error"])){
            if($_SESSION["error"]=="pwsnotthere"){
              $_SESSION["error"]="none";
              echo("<span style='color: red'>Please fill in all the fields.</span>");
            }
             else if($_SESSION["error"]=="oldpwmatch"){
               $_SESSION["error"]="none";
              echo("<span style='color: red'>Please make sure the old password is correct.</span>");
            }
            else if($_SESSION["error"]=="nopwmatch"){
               $_SESSION["error"]="none";
              echo("<span style='color: red'>Please make sure the new passwords match.</span>");
            }
            else if($_SESSION["error"]=="pwupdated"){
               $_SESSION["error"]="none";
              echo("<span style='color: green'>Password updated.</span>");
            }
          }
        ?>
        </div>

        <?php 
        if ($_SESSION["admin"]==false){
        ?>


      
      <div class="col-sm-4">
      <h3>Change Hotel Settings</h3>
      <B>Your project is setup with URL:</B> <br>
      <?=$_SESSION["ScrapeURL"];  ?><br><br>
      <u><b>Change TripAdvisor URL</b></u><br><br>
      <form role="form" action='functions.php' method='post'>
      <div class="form-group">
        <label >New TripAdvisor URL:</label>
        <input type="text" class="form-control" name="newurl" placeholder="Paste URL here">
      </div>
      <button type="update" name="changeurl" onclick="bypass()" class="btn btn-default">Change URL</button>
      </form>
      <?php //error checks//
          if (isset ($_SESSION["error"])){
            if($_SESSION["error"]=="invalidurl"){
              $_SESSION["error"]="none";
              echo("<span style='color: red'>Please enter a valid TripAdvisor URL.</span>");
            }
            else if($_SESSION["error"]=="sameurl"){
              $_SESSION["error"]="none";
              echo("<span style='color: red'>Please enter a different TripAdvisor URL.</span>");
            }
            else if($_SESSION["error"]=="updatedurl"){
               $_SESSION["error"]="none";
              echo("<span style='color: green'>URL updated.</span>");
            }
        }
      ?>
      </div>
      <div class="col-sm-4">
      <h3>Helpful tips about settings</h3>
      <br><u><b>Passwords</b></u><br>
      When changing your password, use a password that is suitably secure and memorable.
      <br>
      If you forget your password, please contact the site admin.
      <br><br><u><b>Changing website URL</b></u><br>
      When you change the url of your hotel, you must submit a valid, active URL from the current TripAdvisor website. When your URL is updated, all previously saved data will be removed.
      </div>
      <?php

      }
      else if ($_SESSION["admin"]==true){
      ?>

      <div class="col-sm-4">
      <h3>Change Hotel Settings</h3>
      <u><b>Change a users TripAdvisor URL</b></u><br><br>
      <form role="form" action='functions.php' method='post'>
      <div class="form-group">
        <label >Select user via Email:</label>
        <select class="form-control" name="emailchoice">
        <option value='na'>Select an email</option>
        <?php
        $user=$_SESSION["userid"];
        $emails = mysqli_fetch_all(mysqli_query($con,"SELECT ownerId,email FROM owner WHERE ownerId>0"));
        foreach($emails as $row){
          echo('<option>');
          echo $row[1];
          echo('</option>');
        }?>
        </select><br>
        <label >New TripAdvisor URL:</label>
        <input type="text" class="form-control" name="newurl1" placeholder="Paste URL here">
      </div>
      <button type="update" name="changeuserurl" onclick="bypass()" class="btn btn-default">Change URL</button>
      </form>
      <?php //error checks//
          if (isset ($_SESSION["error"])){
            if($_SESSION["error"]=="invalidurl1"){
              $_SESSION["error"]="none";
              echo("<span style='color: red'>Please enter a valid TripAdvisor URL.</span>");
            }
            else if($_SESSION["error"]=="sameurl1"){
              $_SESSION["error"]="none";
              echo("<span style='color: red'>Please enter a different TripAdvisor URL.</span>");
            }
            else if($_SESSION["error"]=="emailselect"){
              $_SESSION["error"]="none";
              echo("<span style='color: red'>Please select an email.</span>");
            }
            else if($_SESSION["error"]=="updatedurl1"){
               $_SESSION["error"]="none";
              echo("<span style='color: green'>URL updated.</span>");
            }
        }
      ?>

      
      </div>
      <div class="col-sm-4">
      <h3>Admin only settings</h3>      
      <u><b>Change global settings for data analysis</b></u><br><br>
      <form role="form" action='functions.php' method='post'>
      <div class="form-group">
        <label >Loop Timeout:</label>
        <input type="number" class="form-control" name="looptimeout" placeholder="loop_timeout"><br>
        <label >Sleep Time:</label>
        <input type="number" class="form-control" name="sleeptime" placeholder="sleep_time"><br>
        <label >Write Quota:</label>
        <input type="number" class="form-control" name="writequota" placeholder="database_write_quota"><br>
        <div class="checkbox">
          <label><input type="checkbox" value="reset" name="reset">Reset to standard - (loop=600, sleep=5, database=5)</label>
        </div>
      </div>
      <button type="update" name="changeadminsettings" onclick="bypass()" class="btn btn-default">Change settings</button>
      </form>
      <?php //error checks//
          if (isset ($_SESSION["error"])){
            if($_SESSION["error"]=="resetDBsettings"){
              $_SESSION["error"]="none";
              echo("<span style='color: green'>System global settings have been reset.</span>");
            }
            if(strpos($_SESSION["error"],"looptime") !== false ){
              echo("<span style='color: green'>Loop time has been changed.</span><br>");
            }
            if(strpos($_SESSION["error"],"sleeptime") !== false ){
              echo("<span style='color: green'>Sleep time has been changed.</span><br>");
            }
            if(strpos($_SESSION["error"],"writequota") !== false ){
              echo("<span style='color: green'>Write quota has been changed.</span>");
            }
            $_SESSION["error"]="none";
        }
      ?>




      </div>
      <?php } ?>
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