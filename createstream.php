<?php session_start(); ?>
<html><body>

<form action="createstream.php" method="POST">
<input type="text" name="sname" placeholder="Stream Name">
<?php

echo "select a board from your follow";

    if($stmt = $mysqli->prepare("select bid, bname from BOARD where uid = ? ")){
  
     $stmt->bind_param("i", $_SESSION["user_id"]);
     $stmt->execute();
     $stmt->bind_result($bid,$boardname);
     echo '<form><select name="boardid">';
      while($stmt->fetch()){
    
      echo '<option value="'.$bid.'">'.$boardname.'</option>';
    
      }
     echo '</select><br />';
     $stmt->close();
    }

?>
<input type="text" name="category" placeholder="Category">
<input type="submit">
</form>
<?php
include("include.php");
	if(isset($_POST['boardname']))
	{
		if($stmt=$mysqli->prepare("insert into board (uid,bname,description,category) values (?,?,?,?)"))
		{
			$stmt -> bind_param("isss",$_SESSION["user_id"],$_POST['boardname'],$_POST['desc'],$_POST['category'] );
			$stmt -> execute();
			$stmt->close();
		}
	}
?>

</body></html>