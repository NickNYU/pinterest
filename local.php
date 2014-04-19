<?php session_start(); ?>

<html>

<?php
include ("include.php");



 //This function separates the extension from the rest of the file name and returns it 
 function findexts ($filename) 
 { 
 $filename = strtolower($filename) ; 
 $exts = split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 } 
 
 //This applies the function to our file  
 




// if the information ready
if(isset($_FILES["file"]["name"]) && isset($_POST["boardid"])){

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/JPEG")
    || ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/JPG")
    || ($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/x-png")
    || ($_FILES["file"]["type"] == "image/png"))
    && ($_FILES["file"]["size"] < 2000000)
    && in_array($extension, $allowedExts))
      {
      if ($_FILES["file"]["error"] > 0)
        {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
        }
      else
        {

        $ext = findexts($_FILES['file']['name']) ; 
        $target = 'picture/';
        $ran = time();
        $target = $target.$ran.'.'.$ext;
        echo $target;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $target)) 
         {

            //$link = $_POST["web_URL"];
            $local = 'http://localhost:80/pinterest1/picture/'.$ran.'.'.$ext;
            
            
            
            if ($stmt = $mysqli->prepare("insert into picture (local) values (?)")) {
                $stmt->bind_param("s", $local);
                $stmt->execute();
                $stmt->close();    
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
                echo "upload successfully. \n";
            }
			
            
            echo "The pin has been uploaded";
         } 
         else
         {
           echo "Sorry, there was a problem uploading your file.";
         }
              
        }
      }
    else
      {
      echo "Invalid file";
      }
	
}


else{
	
    echo '<form action="local.php" method="POST" enctype="multipart/form-data">';

    // choose aa board
    echo "select a board";

    if($stmt = $mysqli->prepare("select bid, bname from BOARD where uid = ? ")){
  
     $stmt->bind_param("i", $_SESSION["user_id"]);
     $stmt->execute();
     $stmt->bind_result($bid,$boardname);
     echo '<form><select name="boardid">';
      while($stmt->fetch()){
    
      echo $value=<<<EOF
	  <option value="{$bid}">{$boardname}</option>
EOF;
      }
     echo '</select><br />';
     $stmt->close();
    }

    

    // add decription about pin
    echo "add your description";
    echo '<input type="text" name="description" /><br />';
	
    // select a picture
    echo '<label for="file">Filename:</label>';

    echo '<input type="file" name="file" id="file"><br>';
    echo '<input type="submit" value="Submit" />';
    echo '</form>';

}

$mysqli->close();

?>

</html>



