<!DOCTYPE html>
<?php session_start(); 

include ("include.php");
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
?>

<html lang="en">

<head>
        <meta charset="utf-8" />
        <meta name="author" content="Script Tutorials" />
        <title>Board_Picture</title>

        <!-- add styles -->
        <link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/profile.css" rel="stylesheet" type="text/css" />
        <link href="css/board.css" rel="stylesheet" type="text/css"?>
        <link href="css/search.css" rel="stylesheet" type="text/css" />
                <!-- add scripts -->
        <script src="js/jquery.min.js"></script>
		<script src="js/script.js"></script>
        <script src="js/jquery.masonry.min.js"></script>
    <script src="js/jquery.colorbox-min.js"></script>
    </head>
  <body>
  <script>
            jQuery(document).ready(function () {
                jQuery('a.gallery').colorbox({ opacity:0.5 , rel:'group1' });
            });
      $(document).ready(function(){
        $('.profile_container').masonry({
        // options
        itemSelector : '.pin',
        isAnimated: true,
        isFitWidth: true
    });});
        </script>
  <!-- header panel -->
        <div class="header_panel">

            <!-- logo -->
            <a href="index.php" class="logo"></a>

            <!-- search form -->
            <form action="" method="get" class="search"> <!--action for the search result page-->
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
                        <li><a href="#">Find Friends</a></li>
                        <li class="div"><a href="board.php">Boards</a></li>
                        <li><a href="showpin.php">Pins</a></li>
                        <li><a href="showlike.php">Likes</a></li>
                        <li class="div"><a href="#">Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
                
            </ul>

        </div>

<?php

 echo $haha =<<< EOF

        <div class="main">
            <div class="panel">
                 
                <a href="friend.php?" id="board">Your friend</a>
                <a href="friend.php?friend_request={true}"  id="pin">friend request</a>
                <a href="friend.php?search_friend={true}" id="board">Add friend</a>
                
              
            </div>

        </div> 
EOF;


if(isset($_POST["Accept"])){
  if($stmt = $mysqli->prepare(" UPDATE friendrequest SET replytime = now(), state = 'yes' WHERE uid = ? and fre_uid = ? and state is null")){
    $stmt->bind_param("ii", $_SESSION["user_id"], $_POST["fre_id"]);
    $stmt->execute();
    $stmt->close();
  }
}

if(isset($_POST["Decline"])){
  if($stmt = $mysqli->prepare(" UPDATE friendrequest SET replytime = now(), state = 'no' WHERE uid = ? and fre_uid = ? and state is null")){
    $stmt->bind_param("ii", $_SESSION["user_id"], $_POST["fre_id"]);
    $stmt->execute();
    $stmt->close();
  }
}




//$username = htmlspecialchars($_SESSION['username']);

//echo "<h4>$username's friend:</h4> ";

// show all the friend of user and can link to his friend;
$fnum=0;
$pnum=0;
if((!isset($_GET['friend_request']))&&(!isset($_GET['search_friend']))){

  echo '<h2 class="pname">';
    echo 'Your Friend';
    echo '</h2>';
	echo '<div class="board_container">';
  if($stmt = $mysqli->prepare("(select U.uid,U.uname from USER as U, FRIENDSHIP as F where F.uid1 = U.uid and F.uid2 = ?) union (select U.uid, U.uname from USER as U, FRIENDSHIP as F where F.uid2 = U.uid and F.uid1 = ?) ")){
    //$user_id = $_SESSION["user_id"];
   // echo $_SESSION["user_id"];
    
    $stmt->bind_param("ii", $_SESSION["user_id"],$_SESSION["user_id"]);
    $stmt->execute();
    $stmt->bind_result($fre_id,$fre_name);
    
   

    while($stmt->fetch()){
	
	if($pin_num=$con->prepare("select distinct count(*) from board,pin where pin.bid=board.bid and board.uid=? group by board.uid"))
	{
		$pin_num->bind_param("i",$fre_id);
		$pin_num->execute();
		$pin_num->bind_result($pinnum);
		while($pin_num->fetch()){
			$pnum=$pinnum;
			}
		$pin_num->close();
	}
	if($follow_num=$con->prepare("select distinct count(*) from board,follow where follow.bid=board.bid and board.uid=? group by board.uid"))
	{	
		
		$follow_num->bind_param("i",$fre_id);
		$follow_num->execute();
		$follow_num->bind_result($follownum);
		while($follow_num->fetch()){
			$fnum=$follownum;
			}
		$follow_num->close();
	}
	echo $go1=<<<EOF
	<div class="board">
          <div class="board_name">
          <p>{$fre_name}</p>
          </div>
		  <div class="blank">
		  <p>{$pnum} Pins . {$fnum} Follower</p>
          <div class="holder"> 
			
            <a class="image" href="board.php?uid_vistor={$fre_id}" >
                        <img src="images/userimage.png" />
            
            </a>
			</div>
          
          <ul class="nav_board">
EOF;
    if($cover = $con->prepare("select local from picture, cover, board where picture.pid=cover.pid and cover.bid=board.bid and board.uid=? limit 4"))
    {
      $cover->bind_param("i",$fre_id);
      $cover->execute();
      $cover->bind_result($link);
      while($cover->fetch()){
    echo $go2=<<<EOF
	<li><span class="little"><img src="{$link}"></span></li>
EOF;
		}
		$cover->close();
		}
		
                //echo $user_name .' and U are friend';
                echo $go1=<<<EOF
                </ul>
				
                <div class="edit">
                <button type="button" id="{$fre_id}" class="edit_button deleteFriend">UnFollow</button>
                </div>
EOF;
           
             echo '</div>';  
}  
    $stmt->close(); 
    } 
    echo '</div>';   
      
  }
  else{
  echo 'You have no friend now';
  }





if(isset($_GET['friend_request'])){


  // show all the friend request
  echo '<h2 class="pname">';
    echo 'Friend Request';
    echo '</h2>';

  if($stmt = $mysqli->prepare("SELECT F.fre_uid, F.requesttime, U.uname FROM USER as U, FRIENDREQUEST as F WHERE U.uid = F.fre_uid and F.uid = ? and F.state is null")){
     $stmt->bind_param("i", $_SESSION["user_id"]);
     $stmt->execute();
     $stmt->bind_result($fre_id,$requesttime,$fre_name);
     echo "<table border='1' style='margin-left:8px'>
      <tr>
      <th>requester</th>
      <th>request time</th>
      <th>reply</th>
      </tr>";
      while($stmt->fetch()){
        $fre_name_char = htmlspecialchars($fre_name);
        $fre_id_char = htmlspecialchars($fre_id);
        $requesttime_char = htmlspecialchars($requesttime);
        echo $fre_name;
        echo
        "<form action='friend.php?' method='POST'> 
        <tr>
        <td align='center'>
        <input type='button' name='fre_name' value='$fre_name_char' readonly='readonly'/>
        <input type='hidden' name='fre_id' value='$fre_id_char' readonly='readonly'/>
        </td>

        <td align='center'><input type='text' name='requesttimetime' value='$requesttime_char' readonly='readonly' /></td>
        
        <td>
        <input type='submit' name='Accept' value='Accept' /> 
        <input type='submit' name='Decline' value='Decline' /> 
        </td>
        </tr>
        </form>";

      }
      echo '</table>';
      $stmt->close();

  }

}

// add friend with email
if(isset($_GET['search_friend'])){


  echo '<h2 class="pname">';
    echo 'ADD Friend';
    echo '</h2>';

  echo "<form action='friend.php' method='get'>
        <p><strong>email:</strong> 
        <input type='text' name='search_email'/>
        <input type='submit' value='Search' name='search_friend' style='margin-left:30px;font-size:30px'/>
        <p>
        </form>";
		echo '<div class="profile_container">';
  if($stmt = $mysqli->prepare("SELECT uid,uname FROM USER WHERE email = ?")){
    $stmt -> bind_param("s",$_GET["search_email"]);
    $stmt -> execute();
    $stmt->bind_result($search_id,$search_name);

    //超链接到vistor's board
    while($stmt->fetch()){
		if($pin_num=$con->prepare("select distinct count(*) from board,pin where pin.bid=board.bid and board.uid=? group by board.uid"))
	{
		$pin_num->bind_param("i",$fre_id);
		$pin_num->execute();
		$pin_num->bind_result($pinnum);
		while($pin_num->fetch()){
			$pnum=$pinnum;
			}
		$pin_num->close();
	}
	if($follow_num=$con->prepare("select distinct count(*) from board,follow where follow.bid=board.bid and board.uid=? group by board.uid"))
	{	
		
		$follow_num->bind_param("i",$fre_id);
		$follow_num->execute();
		$follow_num->bind_result($follownum);
		while($follow_num->fetch()){
			$fnum=$follownum;
			}
		$follow_num->close();
	}
	
	echo $go1=<<<EOF
	<div class="profile">
          <div class="profile_name">
          <p>{$search_name}</p>
          </div>
		  <div class="blank">
		  <p>{$pnum} Pins . {$fnum} Follower</p>
          <span class="holder"> 
			
            <a class="image" href="board.php?uid_vistor={$search_id}" >
                        <img src="images/userimage.png" />
            
            </a>
			</span>
          
          <span><ul class="nav_profile">
EOF;
    if($cover = $con->prepare("select local from picture, cover, board where picture.pid=cover.pid and cover.bid=board.bid and board.uid=? limit 2"))
    {
      $cover->bind_param("i",$search_id);
      $cover->execute();
      $cover->bind_result($link);
      while($cover->fetch()){
    echo $go2=<<<EOF
	<li><span class="little"><img src="{$link}"></span><li>
EOF;
		}
		$cover->close();
		}
		
                //echo $user_name .' and U are friend';
                echo $go1=<<<EOF
                </ul></sapn>
				</div>
                <div class="edit">
                <button type="button" class="edit_button request" id="{$search_id}">FollowAll</button>
                </div>
			
EOF;
    }
    //echo "</table>";
    $stmt->close();


  }
  echo '</div>';

}
















$connect ->close();
$con->close();
$mysqli->close();


?>


</html>