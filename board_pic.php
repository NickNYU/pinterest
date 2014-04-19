<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <meta name="author" content="Script Tutorials" />
        <title>Board_Picture</title>

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
	
		
		<script>
            jQuery(document).ready(function () {
                jQuery('a.gallery').colorbox({ opacity:0.5 , rel:'group1' });
            });
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
			include ("include.php");
		$bid=$_GET['boardid'];
		if($stmt = $mysqli->prepare("select bname,uid from board where bid=?"))
		{
			
			$stmt->bind_param("i", $bid);
			$stmt->execute();
			$stmt->bind_result($boardname,$uid);
			while($stmt->fetch())
			{$bname=$boardname;
			$userid=$uid;}
			$stmt->close();
		}
        echo '<h2 class="pname">';
		echo $bname;
		echo '</h2>';
		$con = new mysqli("localhost", "root", "", "pinterest");

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
		
        //<!-- main container -->
        echo '<div class="main_container">';
			
		
		
		
		
		
		$sql="select distinct P.pid, P.local, pin.description from  picture P, pin, board B where P.pid=pin.pid and pin.bid = ?";
		if($stmt = $mysqli->prepare($sql))
		{
			
			$stmt->bind_param("i", $bid);
			$stmt->execute();
			$stmt->bind_result($pid,$local,$desc);
			while($stmt->fetch())
			{
				$Delete=($userid==$_SESSION["user_id"]) ? '<a bid="'.$bid.'" id="'.$pid.'" class="button repinbutton">Delete</a>' : '';
				$Action=($userid!=$_SESSION["user_id"]) ? '<a href="repin.php?id='.$bid.'&pid='.$pid.'" class="button repinbutton gallery">Repin</a><a href="#" id="'.$pid.'" pic_id="'.$pid.'" class="button likebutton">Like</a>' : '';
				echo $sExtra = <<<EOF
				<div class="pin">
					<div class="holder">
						<div class="actions" pic_id="{$pid}" board_id={$bid}>
							{$Action}
							{$Delete}
							<a href="#" class="button comment_tr">Comment</a>
						
						</div>
						<a class="image gallery" href="service.php?id={$pid}" title="Photo number {$pid}" pic_id="{$pid}">

                        <img src="{$local}" />
				
						</a>
					</div>
EOF;
					if(isset($desc))
					{
						echo $go1=<<<EOF
						<p class="desc">{$desc}</p>
EOF;
					}
					
					echo '<ul class="comment">';


					if($com = $con->prepare("select U.uname, C.comtime, C.text from user U, comment C where U.uid=C.uid and C.bid=? and C.pid=?"))
					{
						$com->bind_param("ii", $bid, $pid);
						$com->execute();
						$com->bind_result($uname,$comtime,$com_text);
						while($com->fetch())
						{
							if(isset($uname)){
							echo $go1=<<<EOF
							<li><p>{$uname}: {$com_text} </br>{$comtime}</p></li>
EOF;
							}
						}
						$com->close();
					}
					echo $go2=<<<EOF
					</ul>
					<form class="comment" method="get" action="comment.php">
						
					
						<input type="hidden" name="bid" value="{$bid}" />
						<input type="hidden" name="pid" value="{$pid}" />
						<textarea placeholder="Add a comment..."  name="text" maxlength=100 >
						</textarea>
						<button type="submit" class="button">
						Comment
						</button>
					</form>
				</div>
EOF;
			}
			$stmt->close();   
		}
		else{
		echo 'You have no Board';
		}

$mysqli->close();
$con->close();			
			?>

            
			
			

        </div>
    </body>
</html>