<!DOCTYPE html>
<?php session_start(); ?>
<html><body>


<?php
	include ("include.php");

  
	
if(isset($_POST['boardid'])){
$bid=$_POST['boardid'];
$desc=$_POST['description'];
$prebid=$_POST['prebid'];
$pid=$_POST['pid'];
if($stmt = $mysqli->prepare("insert into pin(pid,bid,description,prebid) values (?,?,?,?)")){
  

  $stmt->bind_param("iisi", $pid,$bid,$desc,$prebid);
  $stmt->execute();
  $stmt->close();
  }
echo $show=<<<EOF
<script>
  window.history.back();
</script> 
EOF;
  }
else{


    echo '<form action="repin.php" method="POST" enctype="multipart/form-data" class="gallery">';

    // choose aa board
    echo "select a board";

    if($stmt = $mysqli->prepare("select bid, bname from BOARD where uid = ? ")){
  
     $stmt->bind_param("i", $_SESSION["user_id"]);
     $stmt->execute();
     $stmt->bind_result($boardid,$boardname);
     echo '<form><select name="boardid">';
      while($stmt->fetch()){
    
      echo '<option value="'.$boardid.'">'.$boardname.'</option>';
    
      }
     echo '</select><br />';
     $stmt->close();
    }
echo $box = <<<EOF
	add your description
    <input type="text" name="description" /><br />
	<input type="hidden" name="prebid" value="{$_GET['id']}" />
	<input type="hidden" name="pid" value="{$_GET['pid']}"  />
    <input type="submit" value="Submit" />
EOF;
	}
  $mysqli->close();


	
	
  
  
?>

<input type="button" value="Back" onclick="goBack()">
<script>

 function goBack()
  {
  window.history.back();
  }
</script>

</script>

</body></html>
