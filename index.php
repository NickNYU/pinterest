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
		<script src="js/jquery.infinitescroll.min.js"></script>
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
            <a href="index.html" class="logo"></a>

            <!-- search form -->
            <form action="" method="get" class="search"> <!--action for the search result page-->
                <input autocomplete="off" name="q" size="27" placeholder="Search" type="text" />
                <input name="search" type="submit" />
            </form>

            <!-- navigation menu -->
            <ul class="nav">
             <?php   
				if(!(isset($_SESSION["email"])))
                {echo '<li>';
                    echo '<a href="login.php">LogIn<span></span></a>';
    
                echo '</li>';}
			?>
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
		
		$con = new mysqli("localhost", "root", "", "pinterest");

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}


        //<!-- main container -->
        echo '<div class="main_container">';
			
		
		
		
		
		
		$sql="select distinct P.pid, P.local, pin.description from  picture P, pin where P.pid=pin.pid";
		if($stmt = $mysqli->prepare($sql))
		{
			$stmt->execute();
			$stmt->bind_result($pid,$local,$desc);
			while($stmt->fetch())
			{
				$Action=(isset($_SESSION["user_id"])) ? '<a href="#" pic_id="'.$pid.'" class="button likebutton">Like</a>' : '';
				echo $sExtra = <<<EOF
				<div class="pin">
					<div class="holder">
					<div class="actions" pic_id="{$pid}" >
							{$Action}
						<a href="#" class="button comment_tr">Comment</a>
						</div>
						<a class="image gallery" href="service.php?id={$pid}">
                        <img src="{$local}" />
						</a>
					</div>

						<p class="desc">{$desc}</p>
		
					
					<ul class="comment">

EOF;
					if($com = $con->prepare("select U.uname, C.comtime, C.text from user U, comment C where U.uid=C.uid and C.pid=?"))
					{
						$com->bind_param("i",$pid);
						$com->execute();
						$com->bind_result($uname,$comtime,$com_text);
						while($com->fetch())
						{
							echo $go1=<<<EOF
							<li><p>{$uname}: {$com_text} </br>{$comtime}</p></li>
EOF;
						}
						$com->close();
					}
					echo $go2=<<<EOF
					</ul>
					
				</div>
EOF;
			}
			$stmt->close();   
		}
		

$mysqli->close();
$con->close();			
			?>

            
			
			

        </div>
    </body>
</html>