<?php
session_start();
// ini_set('upload_max_filesize', '10M');
// ini_set('post_max_size', '10M');
// ini_set('max_input_time', 300);
// ini_set('max_execution_time', 300);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(0);

ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
?>
<!DOCTYPE html>
<html lang="">
<head>
<title>Plagiarism Checker</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<style>
.mytextarea2{width:70%; padding:10px; border:1px solid;color:#FFFFFF; background:#333333;
	border-radius:8px;margin-left:15%;
}
.mytextarea2:focus{border-color:#B0CA35 !important;}
#center_div{
    margin-left:25%;
}
.hr_cls{
    border-color: gray;
}
</style>
</head>
<body id="top">
  <div class="bgded" style="background-image:url('images/demo/backgrounds/01.webp');"> 
    <div class="wrapper overlay row0">
      <div id="topbar" class="hoc clear">
        <div class="fl_left"> 
        </div>
      </div>
    </div>
  </div>
 
  

  <div class="wrapper overlay">
    <div id="pageintro2" class="hoc"> 
      <article>
        <h3 class="heading">Welcome to Code based submission system</h3>
        <div id="center_div"><h4 style="text-;">Please select whether you are a student or a conviener </h4></div>
        <br></br>
        <div>
          <form action="convenor_login.php" method="get">
           <button class="btn" style="margin-left:40%;" type="submit" name="Convenor">Convenor</button>
          </form>
        </div>
        <br></br><hr class="hr_cls">
        <span style="padding-bottom:40px;color:black;">..</span>
        <div>
        <form action="login.php" method="get">
         <button class="btn" style="margin-left:40%;" type="submit" name="Student">Student</button>
        </form>
        </div>
      </article>
    </div>
  </div>




<div class="bgded overlay row4" style="background-image:url('images/demo/backgrounds/01.png');">
  <footer id="footer" class="hoc clear"> 
  </footer>
</div>
  <div class="wrapper row5">
    <div id="copyright" class="hoc clear"> 
      <p class="fl_left">Copyright &copy; 2018 - All Rights Reserved - <a href="#">Domain Name</a></p>
      <p class="fl_right">Template by <a target="_blank" href="https://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    </div>
  </div>

<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.easypiechart.min.js"></script>
</body>
</html>