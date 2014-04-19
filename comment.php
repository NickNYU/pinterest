<!DOCTYPE html>
<?php session_start(); ?>
<html><body>

<?php
	include ("include.php");




if($stmt = $mysqli->prepare("insert into comment(uid,bid,pid,text) values (?,?,?,?)")){
  
  
  $stmt->bind_param("iiis", $_SESSION["user_id"],$_GET['bid'],$_GET['pid'],$_GET['text']);
  $stmt->execute();
  $stmt->close();
  }
  $mysqli->close();
  
?>
<script>

  window.history.back()

</script>

</body></html>