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
        <link href="css/colorbox.css" rel="stylesheet" type="text/css"?>
        <link href="css/search.css" rel="stylesheet" type="text/css" />
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
    <?php

    if(isset($_GET['tag_name'])){

        echo '<h2 class="pname">';
        echo $_GET['tag_name'];
        echo '</h2>';

        $conn = new mysqli("localhost", "root", "root", "pinterest","8889");

        echo '<div class="main_container">';

      if($stmt = $mysqli->prepare("
                                   SELECT distinct P.pid, P.local, pin.description, pin.bid from picture P, pin, board B where P.pid = pin.pid and pin.bid = B.bid  and B.uid <> ? and Pin.tag = ? ")){
         $stmt -> bind_param("is",$_SESSION["user_id"],$_GET["tag_name"]);
         $stmt -> execute();
         $stmt->bind_result($pid,$local,$desc,$bid);
         while($stmt->fetch()){
           
           echo $sExtra = <<<EOF
                    <div class="pin">
                        <div class="holder">
                            <div class="actions" pin_id="1">
                                <a href="repin.php?pid={$pid}&id={$bid}" class="button repinbutton gallery">Repin</a>
                                
                                <a href="#" class="button comment_tr">Comment</a>
                                
                                <a href="like.php?pid={$pid}" class="button likebutton">Like</a>
                                
                            </div>
                            <a class="image gallery" href="service.php?id={$pid}" title="Photo number {$pid}" pin_id="{$pid}">

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



                    if($com = $conn->prepare("select U.uname, C.comtime, C.text from user U, comment C where U.uid=C.uid and C.bid=? and C.pid=?"))
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
            echo '</div>';
            $conn->close();
        }

    else{
      

      echo '<h2 class="pname">';
      echo 'We assume you like';
      echo '</h2>';

      echo '<div class="main_container">';


      $mysqli_2 = new mysqli("localhost", "root", "root", "pinterest","8889");
      $mysqli_3 = new mysqli("localhost", "root", "root", "pinterest","8889");

            /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

      if($stmt = $mysqli->prepare("SELECT tag from user_tag where uid = ?")){
         $stmt -> bind_param("i",$_SESSION["user_id"]);
         $stmt -> execute();
         $stmt->bind_result($tag_name);
         while($stmt->fetch()){

            

             if($stmt_2 = $mysqli_2->prepare("
                                       SELECT distinct P.pid, P.local, pin.description from picture P, pin, board B where P.pid = pin.pid and pin.bid = B.bid and B.uid <> ? and Pin.tag = ? ")){
             $stmt_2 -> bind_param("is",$_SESSION["user_id"],$tag_name);
             $stmt_2 -> execute();
             $stmt_2->bind_result($pid,$local,$desc);
             while($stmt_2->fetch()){
               
           echo $sExtra = <<<EOF
                    <div class="pin">
                        <div class="holder">
                            <div class="actions" pin_id="1">
                                <a href="repin.php?pid={$pid}&id={$bid}" class="button repinbutton gallery">Repin</a>
                                
                                <a href="#" class="button comment_tr">Comment</a>
                                
                                <a href="like.php?pid={$pid}" class="button likebutton">Like</a>
                                
                            </div>
                            <a class="image gallery" href="service.php?id={$pid}" title="Photo number {$pid}" pin_id="{$pid}">

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




                    if($com = $mysqli_3->prepare("select U.uname, C.comtime, C.text from user U, comment C where U.uid=C.uid and C.bid=? and C.pid=?"))
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
                     $stmt_2->close();
                }
            echo '</div>';
            $mysqli_3->close();
        }

        $stmt->close();


    
    }
    
}


$mysqli_2->close();
$mysqli->close;




    ?>









</body>

</html>