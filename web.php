<?php session_start(); ?>

<html>

<?php
include ("include.php");
include ("picture.php");

// if the information ready
if(isset($_POST["web_URL"]) && isset($_POST["boardid"])){

    $image = new GetImage;
    $image->source = $_POST["web_URL"]; // remote file
    $image->save_to = './picture/'; // local dir
    $image->new_filename = time(); // if you want rename downloaded images, file name without extension
    $image->download();

    $type = $image->gettype();

    $link = $_POST["web_URL"];
    $local = 'http://localhost:80/pinterest1/picture/'.$image->new_filename.'.'.$type;
    
    
    
    if ($stmt = $mysqli->prepare("insert into picture (link,local) values (?,?)")) {
        $stmt->bind_param("ss", $link, $local);
        $stmt->execute();
        $stmt->close();
        echo "pin from website successfully. \n";
        echo 'You will be redirected in 3 seconds or click <a href="board_pic.php?boardid='.$_POST["boardid"].'">here</a>';
    }

    if($stmt = $mysqli->prepare("select pid from picture where local = ?")){
        $stmt->bind_param("s", $local);
        $stmt->execute();
        $stmt->bind_result($pid_sql);
        while($stmt->fetch()){
            $pid = $pid_sql;
        }
        $stmt->close();
    }

    if ($stmt = $mysqli->prepare("insert into pin (pid,bid,description) values (?,?,?)")) {
        $stmt->bind_param("iis", $pid, $_POST["boardid"],$_POST["description"]);
        $stmt->execute();
        $stmt->close();
        echo "pin from website successfully. \n";
        echo 'You will be redirected in 3 seconds or click <a href="board_pic.php?boardid='.$_POST["boardid"].'">here</a>';
    }
}


else{
	
    echo '<form action="web.php" method="POST">';

    // choose aa board
    echo "select a board";

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

    

    // add decription about pin
    echo "add your description";
    echo '<input type="text" name="description" /><br />';

    // enter URL
    echo "add URL";
    echo '<input type="text" name="web_URL" /><br />';
    echo '<input type="submit" value="Submit" />';
    echo '</form>';

}

$mysqli->close();

?>

</html>



