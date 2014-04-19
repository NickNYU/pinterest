<?php session_start(); ?>
<html><body>



<?php
include("include.php");
	if(isset($_POST['boardname']))
	{
		if($stmt=$mysqli->prepare("insert into board (uid,bname,description,category,secret) values (?,?,?,?,?)"))
		{
			$stmt -> bind_param("isssi",$_SESSION["user_id"],$_POST['boardname'],$_POST['desc'],$_POST['category'],$_POST['secret'] );
			$stmt -> execute();
			$stmt->close();
		}
		echo $show=<<<EOF
<script>
  window.history.back();
</script> 
EOF;
	}
	else{
	echo $go1=<<<EOF
	<form action="createboard.php" method="POST">
	<input type="text" name="boardname" placeholder="Board Name"></br>
	<input type="text" name="desc" placeholder="Description"></br>
	<input type="text" name="category" placeholder="Category"></br>
	secret: <select name="secret">
	<option value="1">yes</option>
	<option value="0">no</option>
	</select><br />
	<input type="submit">
	</form>
EOF;
	}
$mysqli->close();
?>

</body></html>