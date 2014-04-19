<!DOCTYPE html>
<?php session_start(); ?>
<html><body>

<?php
	include ("include.php");




if($stmt = $mysqli->prepare("insert into rate(uid,pid) values (?,?)")){
  
  
  $stmt->bind_param("ii", $_SESSION["user_id"],$_GET['pid']);
  $stmt->execute();
  $stmt->close();
  }
  $mysqli->close();
  
?>


</body></html>