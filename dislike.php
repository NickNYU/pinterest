<!DOCTYPE html>
<?php session_start(); ?>
<html><body>

<?php
	include ("include.php");




if($stmt = $mysqli->prepare("delete from rate where uid=? and pid=?")){
  
  
  $stmt->bind_param("ii", $_SESSION["user_id"],$_GET['pid']);
  $stmt->execute();
  $stmt->close();
  }
  $mysqli->close();
  
?>


</body></html>