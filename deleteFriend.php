<!DOCTYPE html>
<?php session_start(); ?>
<html><body>

<?php
	include ("include.php");




if($stmt = $mysqli->prepare("delete from friendrequest where (uid=? and fre_uid=? ) or (uid=? and fre_uid=?)")){
  
  
  $stmt->bind_param("iiii", $_SESSION["user_id"],$_GET['did'],$_GET['did'], $_SESSION["user_id"]);
  $stmt->execute();
  $stmt->close();
  }
  $mysqli->close();
  
?>


</body></html>