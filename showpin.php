<?php session_start(); ?>

<html>
<head>
        <meta charset="utf-8" />
        <meta name="author" content="Script Tutorials" />
        

        <!-- add styles -->
        <link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/colorbox.css" rel="stylesheet" type="text/css" />
        <!-- add scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.masonry.min.js"></script>
		<script src="js/jquery.colorbox-min.js"></script>
        <script src="js/script.js"></script>
    </head>
	<body>

<?php
include ("include.php");

$username = htmlspecialchars($_SESSION["username"]);



if($stmt = $mysqli->prepare("select distinct PIC.pid, PIC.link from BOARD as B, PIN as P, PICTURE as PIC 
                             where  PIC.pid=P.pid and B.bid = P.bid and B.uid = ? ")){
  //$user_id = $_SESSION["user_id"];
 // echo $_SESSION["user_id"];
  
  $stmt->bind_param("i", $_SESSION["user_id"]);
  $stmt->execute();
  $stmt->bind_result($pid,$link);
   ?>
   
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
                        <li><a href="friend.php">Find Friends</a></li>
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
		echo $go=<<<EOF
		<h2 class="pname">$username's Pins</h2>
		<div class="main_container">
EOF;
		while($stmt->fetch())
		{
			echo '<div class="pin">';
					echo '<div class="holder">';
						echo '<div class="actions" pin_id="1">';
							echo '<a href="#" class="button">';
							echo "Repin";
							echo '</a>';
							echo '<a href="#" class="button">';
							echo "Like";
							echo '</a>';
							echo '<a href="#" class="button disabled comment_tr">';
							echo "Comment";
							echo '</a>';
						echo '</div>';
						echo '<a class="image gallery" href="service.php?id='.$pid.'" title="Photo number 1" pin_id="1">';
                        echo "<img src=".$link." />";
						echo '</a>';
					echo '</div>';
					echo '<p class="desc">';
					echo "Photo number 1 description";
					echo '</p>';
					echo '<p class="info">';
						echo '<span>';
						echo "1 likes";
						echo '</span>';
						echo '<span>';
						echo "1 repins";
						echo '</span>';
					echo '</p>';
					echo '<form class="comment" method="post" action="">';
						echo '<input type="hidden" name="id" value="1" />';
						echo '<textarea placeholder="Add a comment..." maxlength="1000">';
						echo '</textarea>';
						echo '<button type="button" class="button">';
						echo "Comment";
						echo '</button>';
					echo '</form>';
				echo '</div>';
		}
  
 
  
    
		$stmt->close();   
		}
		else{
		echo 'You have no Board';
		}

$mysqli->close();


?>

    </div>
</body>

</html>