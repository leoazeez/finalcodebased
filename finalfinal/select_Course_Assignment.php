<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

?>
<!DOCTYPE html>
<html lang="">
<head>
<title>Plagiarism Checker</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
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
			<h3 class="heading">Code Submission System</h3>
		  </article>
		</div>
		<?php
		
		
		?>
	  </div>
<?php
#connection to the database
$conn = mysqli_connect("localhost:3306","root","") or die("Erreur: Connection Issue");
$bd = mysqli_select_db($conn,"checker") or die("Errreur: Database Issue");

session_start();
if (!isset($_SESSION['profile'])) {
    header("Location: login.php");
} else {
    $profile = unserialize($_SESSION['profile']);
	$student_id = $profile[0];
	$student_name = $profile[1];
	$student_email = $profile[2];
}
	
include "navbar.php";
echo "<br>";

echo "Welcome ".$student_name."<br>" ;
 

$sql_getenrollement = "select course_id from enrollement where student = '$student_id' ";
$get_enroollement = mysqli_query($conn,$sql_getenrollement);
$rows = mysqli_fetch_row($get_enroollement);
$courses = array();
$count = 0;
while($rows){
	$courses[$count] = $rows[0]; 
	$rows = mysqli_fetch_row($get_enroollement);
	$count+=1;
}



?>
<div class="wrapper coloured">
    <article id="cta" class="hoc container clear"> 
          <h6 class="heading"><span>&ldquo;</span>View Submission<span>&bdquo;</span></h6>
		  
	<table>
		<tr>
			<th>Course ID</th>
			<th>Assignment ID</th>
			<th>Submssion</th>
		</tr>
		
		<?php
		
			foreach($courses as $course){
				$sql_get = "select * from assignment where course = '$course' ";
				$get = mysqli_query($conn,$sql_get);
				$rows = mysqli_fetch_row($get);
				$holders = array();
				$count = mysqli_num_rows($get);
				$assignmentId = array();
				while($rows){
					$holders[$count] = array($rows[0],$rows[1],$rows[2]); 
					$assignmentId[$count] = $rows[0];
					$rows = mysqli_fetch_row($get);
					$count+=1;
				}
				foreach($holders as $holder){
					
					echo "
							<tr>
								<th>".$holder[1]."</th>
								<th>".$holder[0]."</th>
								<th><a href='file_upload.php?course=$holder[1]&assignment=$holder[0]'>Submmit</a></th>
							</tr>
						";
				}
			}		
			
			
		?>
	  
	</table> 
	<form action="inputinfo.php" method="get">
         <button class="btn" style="margin-left:10%;" type="submit" name="Student">Upload Assignment</button>
        </form>
			
		  
    
        
    </article>
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