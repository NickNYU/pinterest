<!DOCTYPE html>
<?php session_start(); 
include ("include.php");
?>

<html lang="en">

<head>
        <meta charset="utf-8" />
        <meta name="author" content="Script Tutorials" />
        <title>Board_Picture</title>

        <!-- add styles -->
        <link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/board.css" rel="stylesheet" type="text/css" />
    <link href="css/colorbox.css" rel="stylesheet" type="text/css" />
    <link href="css/search.css" rel="stylesheet" type="text/css" />
        <!-- add scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.masonry.min.js"></script>
		<script src="js/jquery.colorbox-min.js"></script>
		<script src="js/followbutton.js"></script>
    </head>
  <body>
  <script>
            jQuery(document).ready(function () {
                jQuery('a.gallery').colorbox({ opacity:0.5 , rel:'group1' });
            });
      $(document).ready(function(){
        $('.main_container').masonry({
        // options
        itemSelector : '.pin',
        isAnimated: true,
        isFitWidth: true
    });});
        </script>
  <!-- header panel -->
        <div class="header_panel">

            <!-- logo -->
            <a href="index.html" class="logo"></a>

            <!-- search form -->
            <form action="search.php" method="get" class="search"> <!--action for the search result page-->
                <input autocomplete="off" name="q" size="27" placeholder="Search" type="text" />
                <input name="search" type="submit" />
            </form>

            <!-- navigation menu -->
            <ul class="nav">
                
                <li>
                    <a href="#">Add<span></span></a>
                    <ul>
                        <li><a class="gallery" href="web.php">From Website</a></li>
                        <li><a class="gallery" href="local.php">Upload</a></li>  
                    </ul>
                </li>
                <li>
                    <a href="#">Profile<span></span></a>
                    <ul>
                        <li><a href="#">Invite Friends</a></li>
                        <li><a href="friend.php">Find Friends</a></li>
                        <li class="div"><a href="board.php">Boards</a></li>
                        <li><a href="showpin.php">Pins</a></li>
                        <li><a href="showlike.php">Likes</a></li>
                        <li class="div"><a href="#">Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
                <li>
                    <a href="recommend.php">Lucky Finding<span></span></a>
                    <ul><?php

                      

                          if($stmt = $mysqli->prepare("select tag_name from tag")){
                              //$stmt->bind_param("s", $local);
                              $stmt->execute();
                              $stmt->bind_result($tag_name);
                              while($stmt->fetch()){
                                  //$pid = $pid_sql;
                                echo '<li><a href="recommend.php?tag_name='.$tag_name.'">'.$tag_name.'</a></li>';


                              }
                              $stmt->close();
                          }
                        

                        /*

                        <li><a href="#">Invite Friends</a></li>
                        <li><a href="friend.php">Find Friends</a></li>
                        <li class="div"><a href="board.php">Boards</a></li>
                        <li><a href="showpin.php">Pins</a></li>
                        <li><a href="showlike.php">Likes</a></li>
                        <li class="div"><a href="#">Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>

                        */
                      ?>
                    </ul>
                  </li>



                
            </ul>

        </div>

        <div class="main">
            <div class="panel">
              
                <a href="board.php"  id="pin">Your Board</a>
                <a href="board.php?follow={follow}" id="board">Your Follow</a>
              
            </div>

        </div> 

<?php

if(isset($_GET['follow'])){

$con_2 = new mysqli("localhost", "root", "", "pinterest");

    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $connect_2 = new mysqli("localhost", "root", "", "pinterest");

    $mysqli_2 = new mysqli("localhost", "root", "", "pinterest");



    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    echo '<h2 class="pname">';
        echo "Your Follow";
        echo '</h2>';

    echo '<div class="board_container">';

    if($stmt = $mysqli_2->prepare("select distinct bid from follow 
                                 where  uid = ? ")){
      //$user_id = $_SESSION["user_id"];
     // echo $_SESSION["user_id"];
      
      $stmt->bind_param("i", $_SESSION["user_id"]);
      $stmt->execute();
      
      $stmt->bind_result($boardid);
       while($stmt->fetch())
       {
      $num=0;

        $bid = $boardid;
      
      if($pin_num=$con_2->prepare("select distinct num from board_pins where bid=? "))
      {
        $pin_num->bind_param("i",$bid);
        $pin_num->execute();
        $pin_num->bind_result($pinnum);
        while($pin_num->fetch()){
          $num=$pinnum;
          }

          $pin_num->close();

      }

      if($name=$con_2->prepare("select distinct bname from board where bid=? "))
      {
        $name->bind_param("i",$bid);
        $name->execute();
        $name->bind_result($boardname);
        while($name->fetch()){
          $bname=$boardname;
          }
          $name->close();
      }




      
        if($cover = $con_2->prepare("select local from picture, cover where picture.pid=cover.pid and cover.bid=? limit 1"))
        {
          $cover->bind_param("i",$bid);
          $cover->execute();
          $cover->bind_result($local);
          while($cover->fetch()){
          echo $show=<<<EOF
            <div class="board">
              <div class="board_name">
              <p>{$bname}</p>
              </div>
              <div class="holder">  
                <a class="image" href="board_pic.php?boardid={$bid}&boardname={$bname}" title="Photo number 1" pin_id="1">
                            <img src="{$local}" />
                <p>{$num} pins</p>
                </a>
              </div>
              <ul class="nav_board">
EOF;
              if($little=$connect_2->prepare("select P.local from picture P, pin where P.pid=pin.pid and pin.bid=?  limit 4")){
              $little->bind_param("i",$bid);
              $little->execute();
              $little->bind_result($link);
              while($little->fetch())
              {
              echo $mad=<<<EOF
              <li><span class="little"><img src="{$link}"></span></li>
EOF;
              }
              $little->close();
              }

              

               
                    //echo $user_name .' and U are friend';
                    echo $go1=<<<EOF
                    </ul>
                    <div class="edit">
                    <button type="button" id="{$bid}" class="edit_button" onclick="deleteFollow({$bid})">UnFollow</button>
                    </div>
EOF;
              

        
              
            echo '</div>';





            }
          $cover->close();
        }
      } 
      $stmt->close();   
    }

$connect_2->close();
$con_2->close();
$mysqli_2->close();

echo '</div>';


}

else{

//include ("include.php");

$con = new mysqli("localhost", "root", "", "pinterest");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$connect = new mysqli("localhost", "root", "", "pinterest");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if(isset($_GET["fre_request_uid"])){

  if ($stmt = $mysqli->prepare("insert into friendrequest (uid,fre_uid) values (?,?)")) {
    $stmt->bind_param("ii", $_GET["fre_request_uid"], $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->close();
    echo 'Your request has been sent, click '.'<a href="board.php?uid_vistor='.$_GET["fre_request_uid"].'">here</a> to go on';

  }
}
else{

  
  // check if the person is vistor or user himself
  if(isset($_GET["uid_vistor"])){
    $user_id = $_GET["uid_vistor"];
    
    // check if the vistor is friend of user;
    if($stmt = $mysqli->prepare("(select uid1, uid2 from FRIENDSHIP where uid1 = ? and uid2 = ?) union (select uid1, uid2 from FRIENDSHIP where uid1 = ? and uid2 = ?)")){
     $stmt->bind_param("iiii",$_GET["uid_vistor"],$_SESSION["user_id"],$_SESSION["user_id"],$_GET["uid_vistor"]);
     $stmt->execute();
     $stmt->bind_result($uid1,$uid2);
     while($stmt->fetch())
     {
      
        if(isset($uid1)&&isset($uid2)){
          $isFriend = 1;
          }
     }
	$stmt->close(); 
    }
  }
  
  else{

    $user_id = $_SESSION["user_id"];

  }


  // get the user'name
  if($stmt = $mysqli->prepare("SELECT uname FROM USER WHERE uid = ?")){
    $stmt -> bind_param("i",$user_id );
    $stmt -> execute();
    $stmt->bind_result($user_name_sql);
    while($stmt->fetch()){
      $user_name = htmlspecialchars($user_name_sql);
    }
    $stmt->close();
  }

echo '<h2 class="pname">';
    echo $user_name;
    echo '</h2>';

		echo '<div class="board_container">';
		if($user_id == $_SESSION["user_id"]){
echo $show1=<<<EOF
	
		<div class="board">
          <div class="board_name">
          <p>Create a Board</p>
          </div>
          <div class="holder">  
            <a class="image gallery" href="createboard.php" >
                        <img src="" />
            </a>
          </div>
		</div>
EOF;
}
if($stmt = $mysqli->prepare("select distinct B.bid, B.bname from BOARD as B
                             where  B.uid = ? ")){
  //$user_id = $_SESSION["user_id"];
 // echo $_SESSION["user_id"];
  
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  
  $stmt->bind_result($boardid,$boardname);
   while($stmt->fetch())
   {
	$num=0;
    $bid = $boardid;
    $bname=$boardname;

   // chenk if this board have been followed

   if($follow=$con->prepare("SELECT distinct bid from follow where uid = ? and bid = ?")){

    $follow->bind_param("ii",$_SESSION["user_id"],$bid);
    $follow->execute();
    $follow->bind_result($bid_follow);
    while($follow->fetch()){
      if(isset($bid_follow)){
        $follow_ture = 1;
      }
    }

   }


	if($pin_num=$con->prepare("select distinct num from board_pins where bid=? "))
	{
		$pin_num->bind_param("i",$bid);
		$pin_num->execute();
		$pin_num->bind_result($pinnum);
		while($pin_num->fetch()){
			$num=$pinnum;
			}
    $pin_num->close();
	}
	
    if($cover = $con->prepare("select local from picture, cover where picture.pid=cover.pid and cover.bid=? limit 1"))
    {
      $cover->bind_param("i",$bid);
      $cover->execute();
      $cover->bind_result($local);
      while($cover->fetch()){
      echo $show=<<<EOF
        <div class="board">
          <div class="board_name">
          <p>{$bname}</p>
          </div>
          <div class="holder">  
            <a class="image" href="board_pic.php?boardid={$bid}&boardname={$bname}" title="Photo number 1" pin_id="1">
                        <img src="{$local}" />
            <p>{$num} pins</p>
            </a>
          </div>
          <ul class="nav_board">
EOF;
          if($little=$connect->prepare("select P.local from picture P, pin where P.pid=pin.pid and pin.bid=?  limit 4")){
          $little->bind_param("i",$bid);
          $little->execute();
          $little->bind_result($link);
          while($little->fetch())
          {
          echo $mad=<<<EOF
          <li><span class="little"><img src="{$link}"></span><li>
EOF;
          }
          $little->close();
          }

          if($user_id != $_SESSION["user_id"]){

            if(isset($isFriend)||isset($follow_ture)){
                //echo $user_name .' and U are friend';
                echo $go1=<<<EOF
                </ul>
                <div class="edit">
                <button type="button" id="{$bid}" class="edit_button" fol_id="2">UnFollow</button>
                </div>
EOF;
              $follow_ture = null;
            }
           else{
                echo $go2=<<<EOF
                </ul>
                <div class="edit">
                <button type="button" id="{$bid}" class="edit_button" fol_id="1">Follow</button>
                </div>           
EOF;
               }
          }
          else{

            
                echo $go2=<<<EOF
                </ul>
                <div class="edit">
                <button type="button" class="edit_button">edit</button>
                </div>           
EOF;
            }         
          
        echo '</div>';





        }
      $cover->close();
    }
  } 
  $stmt->close();   
}
else{
echo 'You have no Board';
}


$connect ->close();
$con->close();
$mysqli->close();

echo '</div>';


}

}





?>


</body>

</html>