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

<html>
<title>Login</title>
<body>



<?php

include "include.php";


//if the user is already logged in, redirect them back to homepage
if(isset($_SESSION["email"])) {
  echo "You are already logged in. \n";
  echo "You will be redirected in 3 seconds or click <a href=\"board.php\">here</a>.\n";
  header("refresh: 3; board.php");
}
else {
  //if the user have entered both entries in the form, check if they exist in the database
  if(isset($_POST["password"])&& isset($_POST["email"])) {

    //check if entry exists in database
    if ($stmt = $mysqli->prepare("select uid, uname, email, password from user where email = ? and password = ?")) {
      $stmt->bind_param("ss", $_POST["email"], ($_POST["password"]));
      $stmt->execute();
      $stmt->bind_result($uid, $uname, $email, $password);
      
	    //if there is a match set session variables and send user to homepage
        if ($stmt->fetch()) {
		  $_SESSION["user_id"] = $uid;
		  $_SESSION["username"] = $uname;
		  $_SESSION["email"] = $email;
		  $_SESSION["password"] = $password;
		 
		  //$_SESSION["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"]; //store clients IP address to help prevent session hijack
		  
          echo "Login successful. \n"; 
          echo "You will be redirected in 3 seconds or click <a href=\"index.php\">here</a>.";
          header("refresh: 3; index.php");
        }
		//if no match then tell them to try again
		else {
		  sleep(1); //pause a bit to help prevent brute force attacks
		  echo "Your username or password is incorrect, click <a href=\"login.php\">here</a> to try again.";
		}
      $stmt->close();
	  
    } 
		if ($result = $mysqli->prepare("update user set logintime = now() where uid=?")) 
		{
			$result->bind_param("i", $_SESSION["user_id"]);
			$result->execute();
			$result->close();
		}	
		$mysqli->close();
  }
  //if not then display login form
  else {
  //for($k=1;$k<=20;$k++){
	//echo '</br>';}
	
    echo '<div class="container">';
	echo '<section id="content">';
		echo '<form action="login.php" method="POST">';
			echo '<h1>';
			echo "Login Form";
			echo '</h1>';
			echo '<div>';
				echo '<input type="text" name="email" placeholder="Email" required="" id="email"/>';
			echo '</div>';
			echo '<div>';
				echo '<input type="password" name="password" placeholder="Password" required="" id="password"/>';
			echo '</div>';
			echo '<div>';
				echo '<input type="submit" value="Log in" />';
				echo '<a href="#">';
				echo "Lost your password?";
				echo '</a>';
				echo '<a href="sign_up.php">';
				echo "Register";
				echo '</a>';
			echo '</div>';
		echo '</form>';
		echo '<div class="button">';
			echo '<a href="index.php">';
			echo "Get Back";
			echo '</a>';
		echo '</div>';
	echo '</section>';
	echo '</div>';
  }
}
?>
</body>

</html>


