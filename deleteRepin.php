<!DOCTYPE html>
<?php session_start(); ?>
<html><body>

<?php
include ("include.php");
$bid=$_GET["bid"];
$pid=$_GET["pid"];


if($stmt= $mysqli->prepare("select prebid from pin where pid=? and bid=?")){
    $stmt->bind_param("ii", $pid,$bid);
    $stmt->execute();
	$stmt->bind_result($prebid);
	while($stmt->fetch())
	{ if(isset($prebid)){
	$pre_bid = 1;
	
	}else{
	$pre_bid = 0;
	}
	}
	
    $stmt->close();
  }
  if($pre_bid==1){
if ($stmt = $mysqli->prepare("delete from pin where pid=? and bid=?")) {
    $stmt->bind_param("ii", $pid,$bid);
    $stmt->execute();
    $stmt->close();
  }
  }
  if($pre_bid!=1)
  {
	if ($stmt = $mysqli->prepare("delete from pin where pid=?")) {
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->close();
  }
	if ($stmt = $mysqli->prepare("delete from picture where pid=?")) {
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->close();
  }
  }
$mysqli->close();  
  
?>

</body></html>