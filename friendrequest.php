<!DOCTYPE html>
<?php session_start(); ?>
<html><body>

<?php
	include ("include.php");




if($stmt = $mysqli->prepare("insert into friendrequest(fre_uid,uid) values (?,?)")){
  
  
  $stmt->bind_param("ii", $_SESSION["user_id"],$_POST['fid']);
  $stmt->execute();
  $stmt->close();
  }
  $mysqli->close();
  
?>


</body></html>