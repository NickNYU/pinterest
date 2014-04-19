<?php session_start(); ?>
<html><body>


<?php
include("include.php");
	if(isset($_POST['uname']))
	{
		if($stmt=$mysqli->prepare("update user,profile set user.uname=?, profile.birthday=?, profile.address=?, profile.gender=? where user.uid=profile.uid and user.uid=?"))
		{
			$stmt -> bind_param("ssssi",$_POST['uname'],$_POST['birth'],$_POST['address'],$_POST['gender'],$_SESSION["user_id"] );
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
	if($stmt=$mysqli->prepare("select uname,birthday,address,gender from user,profile where user.uid=profile.uid and user.uid=?"))
	{
		
		$stmt->bind_param("i",$_SESSION["user_id"]);
		$stmt->execute();
		$stmt->bind_result($userName,$birthday,$addr,$gen);
		while($stmt->fetch()){
	echo $go1=<<<EOF
	<form action="changeProfile.php" method="POST">
	<p>User Name</p><input type="text" name="uname" value="{$userName}"></br>
	<p>User Birthdat</p><input type="text" name="birth" value="{$birthday}"></br>
	<p>User Address</p><input type="text" name="address" value="{$addr}"></br>
	<p>User Gender</p><input type="text" name="gender" value="{$gen}"></br>
	<input type="submit">
	</form>
EOF;
}
	}
	}
$mysqli->close();
?>

</body></html>