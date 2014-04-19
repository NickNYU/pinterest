<!DOCTYPE html>
<?php session_start(); ?>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">


<!--add styles-->

<link href="css/login.css" rel="stylesheet" type="text/css" />

</head>
<body>

<?php

include "include.php";

// if the user has already logged in, go back to homepage

if(isset($_SESSION["email"])) {
  echo "You have been already logged in. ";
  echo "You will go back in 3 seconds or click <a href=\"index.php\">here</a>.";
  header("refresh: 3; index.php");
}

else{
// if the user enter all the required infromation, insert into database
if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
    // check if email is already used
    if ($stmt = $mysqli->prepare("select email from user where email = ?")) {
      $stmt->bind_param("s", $_POST["email"]);
      $stmt->execute();
      $stmt->bind_result($email);
        if ($stmt->fetch()) {
          echo "That email already exists. ";
          echo "You will be redirected in 3 seconds or click <a href=\"sign_up.php\">here</a>.";
          header("refresh: 3; sign_up.php");
		  $stmt->close();
        }
        //if not then insert the entry into database.
        else {
		    $stmt->close();
		    if ($stmt = $mysqli->prepare("insert into user (uname,email,password,builttime) values (?,?,?,)")) {
              $stmt->bind_param("sss", $_POST["username"], $_POST["email"], ($_POST["password"]));
              $stmt->execute();
              $stmt->close();
              echo "Registration complete, click <a href=\"index.php\">here</a> to return to homepage."; 
          }		  
        }	 
	}
  }
  //if not then display registration form
  else {
    echo $regist=<<<EOF
<div class="container">
	<section id="content">
		<form action="sign_up.php" method="POST">
			<h1>Login Form</h1>
			<div>
				<input type="text" placeholder="Username"  name="username" />
			</div>
			<div>
				<input type="text" placeholder="EMAIL" name="email"/>
			</div>
			<div>
				<input type="password" placeholder="Password"  name="password"/>
			</div>
			<div>
				<input type="submit" value="Register" />
				
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="index.php">Get Back</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
EOF;
  }
}
$mysqli->close();






?>
</body>
</html>

