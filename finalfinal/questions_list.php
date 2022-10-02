<?php
session_start();
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(0);
?>
<!DOCTYPE html>
<html lang="">
<head>
<title>Questions</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<?php
#connection to the database
$conn = mysqli_connect("localhost:3306","root","") or die("Erreur: Connection Issue");
$bd = mysqli_select_db($conn,"checker") or die("Errreur: Database Issue");


$_SESSION["student_id"] = $_GET['student'];
$_SESSION["assignment_id"] = $_GET['assignment'];
//$_SESSION['question_list'] = "";
$default_student_id = $_SESSION["student_id"];
$default_assignment_id = $_SESSION["assignment_id"];

$final_file = $_SESSION["final_file"];


 $question_list = explode('|', $_SESSION['question_list']);  

  if($question_list[0] && $question_list[1] && $question_list[2] && $question_list[3] && $question_list[4]){
    $radom_5_questions = $question_list;
  } 
  else if(!$question_list[0] && !$question_list[1] && !$question_list[2] && !$question_list[3] && !$question_list[4]){
  #Generating questions based on the extennsion of the input file
  if($_SESSION["file_type"] == "py" && $_SESSION["questions_generated"]==0){
    $_SESSION["questions_generated"] = 1;
    $questions_generated = 0;
    // Read from file
    $lines = file("upload/".$final_file);
    foreach($lines as $line)
    {
      //Generating questions based on classes
      #getting the lines containing classes 
      if(strpos($line, 'class') !== false){
        $class = explode(' ', $line);
        #the class name can be followed by '(' without any spaces before it
        $class_name = explode('(', $class[1]);
        if ($class_name[0]){
          $question_1 = "Is the class ".$class_name[0]." instantiable or not?";
          $choices_1 = "Yes,No,Only in some cases";

          $request_insert_generated_question = "insert into question(assignment,description,choices,programming_language,type,right_response) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','py','generated',1)";
          $result = mysqli_query($conn,$request_insert_generated_question);
          $questions_generated+=1;

          $question_2 = "Which class is the parent of the class ".$class_name[0]."?";
          $choices_2 = "Object, Class, The class ".$class_name[0]." has no parent class, other";
          //checking if the class has a parent, if it does w include it in the choices
          //the parent class will be included inside () if it exists
          $parent_class = explode(')', $class_name[1]);
          if($parent_class[0])
            $choices_2=$choices_2.",".$parent_class[0]; 

          $request_insert_generated_question = "insert into question(assignment,description,choices,programming_language,type,right_response) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','py','generated',7)";
          $result = mysqli_query($conn,$request_insert_generated_question);
          $questions_generated+=1;
        }

      }
      //Generating Questions based on functions
    if(strpos($line, 'def') !== false){
      $after_def= substr($line, strpos($line, 'def') + 3); //getting all what comes after def to avoid the blank spaces
      $function_name = explode('(',$after_def);
   
      $question_1 = "What is the type of the value returned by the function ".$function_name[0]."?";
      $choices_1 = "Void,Integer,String,Float,Object,Other";

      $request_insert_generated_question = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','py','generated')";
      $result = mysqli_query($conn,$request_insert_generated_question);
      $questions_generated+=1;

      $question_2 = "Choose the correct function declaration of ".$function_name[0]."() so that we can execute the function call successfully";
      $choices_2 = $function_name[0]."(**kwargs), it's not possible to call the function, ".$function_name[0]."(args*),".$function_name[0]."(data*),other";
   
      $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','py','generated')";
      $result_2 = mysqli_query($conn,$request_insert_generated_question_2);
      $questions_generated+=1;

      $question_3 = "What will be the output if we rename the function ".$function_name[0]." ?";
      $choices_3 = "Syntax error, False, None, Integer value, None of the above";
   
      $request_insert_generated_question_3 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','py','generated')";
      $result_3 = mysqli_query($conn,$request_insert_generated_question_3);
      $questions_generated+=1;

      $question_4 = "What will be the output if we remove the function ".$function_name[0]." ?";
      $choices_4 = "Syntax error, False, None, Integer value, None of the above";
   
      $request_insert_generated_question_4 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_4."','".$choices_4."','py','generated')";
      $result_4 = mysqli_query($conn,$request_insert_generated_question_4);
      $questions_generated+=1;
    }
    }
    $count_lines = count($lines);
    $line_number = rand(1,$count_lines);

    $question_1 = "Will the code compile if we remove the line ".$line_number." ?";
    $choices_1 = "Yes, No, Yes but only sometimes";

    $request_insert_generated_question_1 = "insert into question(assignment,description,choices,programming_language,type,right_response) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','py','generated',2)";
    $result_1 = mysqli_query($conn,$request_insert_generated_question_1);
    $questions_generated+=1;


    $question_2 = "After which line can we insert a break statement, and code will still run ?";
    $choices_2 = rand(1,$count_lines).",".rand(1,$count_lines).",Break can be added after any line, none of the above, all of the above";

    $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','py','generated')";
    $result_2 = mysqli_query($conn,$request_insert_generated_question_2);
    $questions_generated+=1;

    if($questions_generated<5){
      //insertng random quesions if the algorithm didn't succeed to generate enough question (when the file is empty or too small)
      $question_1 = "Which operator has higher precedence in the following list?";
      $choices_1 = "Modulus, BitWise AND,Exponent,Comparison";
      $request_insert_generated_question_1 = "insert into question(assignment,description,choices,programming_language,type,right_response) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','py','random',3)";
      $result_1 = mysqli_query($conn,$request_insert_generated_question_1);

      $question_2 = "What is the output of print(type({}) is set) ?";
      $choices_2 = "True, False";
      $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','py','random')";
      $result_2 = mysqli_query($conn,$request_insert_generated_question_2);

      $question_3 = "What is the data type of print(type(0xFF)) ?";
      $choices_3 = "number,hexint,hex,int";
      $request_insert_generated_question_3 = "insert into question(assignment,description,choices,programming_language,type,right_response) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','py','random',2)";
      $result_3 = mysqli_query($conn,$request_insert_generated_question_3);

      $question_4 = "Choose the correct function to get the ASCII code of a character";
      $choices_4 = "char('char'),ord('char'),ascii('char')";
      $request_insert_generated_question_4 = "insert into question(assignment,description,choices,programming_language,type,right_response) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','py','random',3)";
      $result_4 = mysqli_query($conn,$request_insert_generated_question_4);

      // $question_5 = "The in operator is used to check if a value exists within an iterable object container such as a list. Evaluate to True if it finds a variable in the specified sequence and False otherwise";
      // $choices_5 = "True,False";
      // $request_insert_generated_question_5 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','py','random')";
      // $result_5 = mysqli_query($conn,$request_insert_generated_question_5);
    }
  }
  else if($_SESSION["file_type"] == "cpp" && $_SESSION["questions_generated"] ==0){
    $_SESSION["questions_generated"] = 1;
    $questions_generated = 0;
    $lines = file("upload/".$final_file);
    foreach($lines as $line)
    {
      //Generating questions based on classes
      if(strpos($line, 'class') !== false){
        $after_class= substr($line, strpos($line, 'class') + 5); //getting all what comes after 'class' but 'class' is not included
        $after_class_name = explode(':', $after_class);
        $class_name = explode('{', $after_class_name[0]);
     
        if (strlen($class_name[0])>1){
          $question_1 = "Is the class ".$class_name[0]." instantiable or not ?";
          $choices_1 = "Yes,No,Only in some cases";

          $request_insert_generated_question = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','cpp','generated')";
          $result = mysqli_query($conn,$request_insert_generated_question);
          $questions_generated+=1;

          $question_2 = "Which class is the parent of the class ".$class_name[0]."?";
          $choices_2 = "Object, Class, The class ".$class_name[0]." has no parent class, other";
          //checking if the class has a parent, if it does we include it in the choices
          //if a class has a parent it will be coded like class child: public parent {}
          // so to get the parent class, we get what's between ': public' and '{' or ':public' and '{'
          if(strpos($line, ':')){
            $parent = substr($line, strpos($line, ': public')+8);
            if(!$parent)
              $parent = substr($line, strpos($line, ':public')+7);
            
            $parent_class_name = explode('{',$parent);
            $choices_2=$choices_2.",".$parent_class_name[0]; 
          }
          $request_insert_generated_question2 = "insert into question(assignment,description,choices,programming_language,type,right_response) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','cpp','generated',6)";
          $result = mysqli_query($conn,$request_insert_generated_question2);
          $questions_generated+=1;
        }
      }
      if(strpos($line, '()') !== false){
        $funtion_signature_start = strtok($line, '()'); //for 'void func(){}' the output will be 'void func'
        $function_name = explode(' ',$funtion_signature_start);
        
        $question_1 = "What is the type of the value returned by the function ".end($function_name)."?";
        $choices_1 = "Integer,Character,Boolean,Floating Point,Valueless or Void,Reference,Pointer,None of the above";
    
        $request_insert_generated_question = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','cpp','generated')";
        $result = mysqli_query($conn,$request_insert_generated_question);
        $questions_generated+=1;
    
        $question_2 = "Choose the correct function declaration of ".end($function_name)."() so that we can execute the function call successfully";
        $choices_2 = "result=".end($function_name)."(**kwargs), it's not possible to call the function,result=".end($function_name)."(args*),result=".end($function_name)."(),All of the above,None of te above";
     
        $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','cpp','generated')";
        $result_2 = mysqli_query($conn,$request_insert_generated_question_2);
        $questions_generated+=1;
    
        $question_3 = "What will be the output if we rename the function ".end($function_name)." ?";
        $choices_3 = "Syntax error, Referance, Integer value,1, None of the above";
     
        $request_insert_generated_question_3 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','cpp','generated')";
        $result_3 = mysqli_query($conn,$request_insert_generated_question_3);
        $questions_generated+=1;
    
        $question_4 = "What will be the output if we remove the function ".end($function_name)." ?";
        $choices_4 = "Syntax error, 0, Pointer, Integer value, None of the above";
     
        $request_insert_generated_question_4 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_4."','".$choices_4."','cpp','generated')";
        $result_4 = mysqli_query($conn,$request_insert_generated_question_4);
        $questions_generated+=1;
      }
    }
    $count_lines = count($lines);
    $line_number = rand(1,$count_lines);

    $question_1 = "Will the code compile if we remove the line ".$line_number." ?";
    $choices_1 = "Yes, No, Yes but only sometimes";

    $request_insert_generated_question_1 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','cpp','generated')";
    $result_1 = mysqli_query($conn,$request_insert_generated_question_1);
    $questions_generated+=1;


    $question_2 = "After which line can we insert a break statement, and code will still run ?";
    $choices_2 = rand(1,$count_lines).",".rand(1,$count_lines).",Break can be added after any line, none of the above, all of the above";

    $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','cpp','generated')";
    $result_2 = mysqli_query($conn,$request_insert_generated_question_2);
    $questions_generated+=1;

    if($questions_generated<5){
      $question_1 = "What is a correct syntax to output 'Hello World' in C++?";
      $choices_1 = 'print("Hello World");,cout<<"Hello world";,System.out.prinln("Hello World");';
      $request_insert_generated_question_1 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','cpp','random')";
      $result_1 = mysqli_query($conn,$request_insert_generated_question_1);

      $question_2 = "C++ is an alias of C#";
      $choices_2 = "True,False";
      $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','cpp','random')";
      $result_2 = mysqli_query($conn,$request_insert_generated_question_2);

      $question_3 = "How do you insert COMMENTS in C++ code ?";
      $choices_3 = "//this is a comment,#this is a comment,/*this is a comment";
      $request_insert_generated_question_3 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','cpp','random')";
      $result_3 = mysqli_query($conn,$request_insert_generated_question_3);

      $question_4 = "Which data type is used to create a variable that should store text ?";
      $choices_4 = "myString,string,String,Txt";
      $request_insert_generated_question_4 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_4."','".$choices_4."','cpp','random')";
      $result_4 = mysqli_query($conn,$request_insert_generated_question_4);

      // $question_5 = "Which operator is used to add together two values ?";
      // $choices_5 = "The & sign,The + sign,The * sign";
      // $request_insert_generated_question_5 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_5."','".$choices_5."','cpp','random')";
      // $result_5 = mysqli_query($conn,$request_insert_generated_question_5);
    }

  }
  else if($_SESSION["file_type"] == "php" && $_SESSION["questions_generated"] ==0){

    $_SESSION["questions_generated"] = 1;
    $questions_generated = 0;
    $lines = file("upload/".$final_file);
    foreach($lines as $line)
    {
      //Generating questions based on classes
      if(strpos($line, 'class') !== false){
        $after_class= substr($line, strpos($line, 'class') + 6); //getting all what comes after 'class' but 'class' is not included
        $class_name = explode(' ', $after_class);
        if(strlen($class_name[0])>1){
          $question_1 = "Is the class ".$class_name[0]." instantiable or not ?";
          $choices_1 = "Yes,No,Only in some cases";
    
          $request_insert_generated_question = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','php','generated')";
          $result = mysqli_query($conn,$request_insert_generated_question);
          $questions_generated+=1;
    
          $question_2 = "Which class is the parent of the class ".$class_name[0]."?";
          $choices_2 = "Object, Class, The class ".$class_name[0]." has no parent class, other";
          //checking if the class has a parent, if it does we include it in the choices
          //if a class has a parent it will be coded like class child extends parent {}
          // so to get the parent class, we get what's between 'extends' and '{' 
          if(strpos($line, 'extends')){
            $parent = substr($line, strpos($line, 'extends')+7);
            $parent_class_name = explode('{',$parent);
            $choices_2=$choices_2.",".$parent_class_name[0]; 
          }
          $request_insert_generated_question2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','php','generated')";
          $result = mysqli_query($conn,$request_insert_generated_question2);
          $questions_generated+=1;
        }
      }
      //Generating questions based on functions
      if(strpos($line, 'function') !== false){
        $funtion_signature = substr($line, strpos($line, 'function')+8);
        $function_name = explode('(',$funtion_signature);

        $question_1 = "What is the type of the value returned by the function ".$function_name[0]."?";
        $choices_1 = "Integer,Character,Boolean,Valueless or Void,Array,Object,None of the above";
    
        $request_insert_generated_question = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','php','generated')";
        $result = mysqli_query($conn,$request_insert_generated_question);
        $questions_generated+=1;
    
        $question_2 = "Choose the correct function declaration of ".$function_name[0]."() so that we can execute the function call successfully";
        $choices_2 = "result=".$function_name[0]."(**kwargs), it's not possible to call the function,result=".end($function_name)."(args*),result=".end($function_name)."(),All of the above,None of te above";
     
        $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','php','generated')";
        $result_2 = mysqli_query($conn,$request_insert_generated_question_2);
        $questions_generated+=1;
    
        $question_3 = "What will be the output if we rename the function ".$function_name[0]." ?";
        $choices_3 = "Syntax error, Referance, Integer value,1, None of the above";
     
        $request_insert_generated_question_3 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','php','generated')";
        $result_3 = mysqli_query($conn,$request_insert_generated_question_3);
        $questions_generated+=1;
    
        $question_4 = "What will be the output if we remove the function ".$function_name[0]." ?";
        $choices_4 = "Syntax error, 0, Pointer, Integer value, None of the above";
     
        $request_insert_generated_question_4 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_4."','".$choices_4."','php','generated')";
        $result_4 = mysqli_query($conn,$request_insert_generated_question_4);
        $questions_generated+=1;
      }
    }
    $count_lines = count($lines);
    $line_number = rand(1,$count_lines);

    $question_1 = "Will the code compile if we remove the line ".$line_number." ?";
    $choices_1 = "Yes, No, Yes but only sometimes";

    $request_insert_generated_question_1 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','php','generated')";
    $result_1 = mysqli_query($conn,$request_insert_generated_question_1);
    $questions_generated+=1;


    $question_2 = "After which line can we insert a break statement, and code will still run ?";
    $choices_2 = rand(1,$count_lines).",".rand(1,$count_lines).",Break can be added after any line, none of the above, all of the above";

    $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','php','generated')";
    $result_2 = mysqli_query($conn,$request_insert_generated_question_2);
    $questions_generated+=1;

    if($questions_generated<5){
      $question_1 = "PHP server scripts are surrounded by delimiters, which?";
      $choices_1 = '<&>..</&>,<?php>..</?>,<?php ?>,<script>..</script>';
      $request_insert_generated_question_1 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_1."','".$choices_1."','php','random')";
      $result_1 = mysqli_query($conn,$request_insert_generated_question_1);

      $question_2 = "All variables in PHP start with which symbol ?";
      $choices_2 = "&,!,$";
      $request_insert_generated_question_2 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_2."','".$choices_2."','php','random')";
      $result_2 = mysqli_query($conn,$request_insert_generated_question_2);

      $question_3 = "What is the correct way to end a PHP statement ?";
      $choices_3 = ".,;,</php>,New line";
      $request_insert_generated_question_3 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_3."','".$choices_3."','php','random')";
      $result_3 = mysqli_query($conn,$request_insert_generated_question_3);

      $question_4 = "The PHP syntax is most similar to ?";
      $choices_4 = "VBScript,Perl and C,Javascript";
      $request_insert_generated_question_4 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_4."','".$choices_4."','php','random')";
      $result_4 = mysqli_query($conn,$request_insert_generated_question_4);

      // $question_5 = "When using the POST method, variables are displayed in the URL";
      // $choices_5 = "True,False";
      // $request_insert_generated_question_5 = "insert into question(assignment,description,choices,programming_language,type) values(".$default_assignment_id.",'".$question_5."','".$choices_5."','php','random')";
      // $result_5 = mysqli_query($conn,$request_insert_generated_question_5);
    }
  }

 

 $req_get_question_ids = "select distinct question_id from question where question.assignment=".$default_assignment_id." and question_id not in(select question from response)";
 
  $res_ids = mysqli_query($conn,$req_get_question_ids);
  $ids = array();
 
  $l = mysqli_fetch_row($res_ids);
  while($l = mysqli_fetch_row($res_ids)){
    array_push($ids,$l[0]);
  }

  $radom_5_questions = array();
  for ($i=1;$i<=5;$i++){
      shuffle($ids);
      $selected = array_pop($ids);
      array_push($radom_5_questions,$selected);
  }
}
else{
   $radom_5_questions = $question_list;
}
?>
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
        <h3 class="heading">Welcome To Plagiarism Checker</h3>
        <br></br>
        <span class="center_title">Answer the questions to complete the test</span>
        <br></br><br>
      </article>
    </div>
  </div>
<div class="wrapper row3">
  <main class="hoc container clear"> 
        <section id="introblocks">
      <ul class="nospace group elements elements-three">
        <?php 
          //getting the question description for each of the 5 random questions
          $index = 0;$questions="";
          foreach ($radom_5_questions as $question_id) {
            $questions = $questions.$question_id."|";
            $_SESSION["question_list"] = $questions; 

            $index++;
            $request_get_question = "select description from question where question_id=".$question_id;
            $request_get_question_result = mysqli_query($conn,$request_get_question);
          //displaying the questions 
            while($l = mysqli_fetch_row($request_get_question_result)){
              $description = $l[0];
              echo "<li class='one_third'>
                      <article>
                        <footer><a href='answer_form_extention.php?question_id=".$question_id."&question_number=".$index."&quesions=".$_SESSION['question_list']."'><i class='fas fa-question'></i></a></footer>
                        <h6 class='heading'>Question ".$index."</h6>
                        <p>".$description."</p>
                      </article>
                    </li>";
            }
          }
       
           
    ?>
      
      </ul>
    </section>

    <div class="clear"></div>
  </main>
</div>


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