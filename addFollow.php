<!DOCTYPE html>
<?php session_start(); ?>
<html><body>

<?php
include ("include.php");
$bid=$_GET["bid"];
$uid=$_SESSION["user_id"];
if ($stmt = $mysqli->prepare("insert into follow (uid,bid) values (?,?)")) {
    $stmt->bind_param("ii", $uid,$bid);
    $stmt->execute();
    $stmt->close();
  }
$mysqli->close();  
  
?>

</body></html>