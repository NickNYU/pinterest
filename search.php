<!DOCTYPE html>
<?php session_start(); 
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

    if(isset($_GET["q"])){

        $search_pin = $_GET["q"];
       
        $un = $_GET["q"];
    }

    if(isset($_GET['search_pin'])){
      $un = $_GET['search_pin'];
      $search_pin = $_GET['search_pin'];

    }

    if(isset($_GET['search_board'])){
      $un = $_GET['search_board'];
      $search_board = $_GET['search_board'];

    }



    echo $haha =<<< EOF

        <div class="main">
            <div class="panel">
              
                <a href="search.php?search_pin={$un}"  id="pin">Pins</a>
                <a href="search.php?search_board={$un}" id="board">Boards</a>
              
            </div>

        </div> 
EOF;




include ("include.php");






if(isset($search_pin)){
    //$un = $search_pin;
    //$un_html = htmlspecialchars($un);
   // echo $search_pin;
    
    
    echo '<div class="main_container">';

      if($stmt = $mysqli->prepare("
                                   (SELECT distinct P.pid, P.local, pin.description from picture P, pin, board B where P.pid = pin.pid and pin.bid = B.bid and Pin.prebid is null  and B.uid <> ? and Pin.tag like '%$un%')
                                   UNION
                                   (SELECT distinct P.pid, P.local, pin.description from picture P, pin, board B where P.pid = pin.pid and pin.bid = B.bid and B.uid <> ? and Pin.description like '%$un%')
                                 ")){
         $stmt -> bind_param("ii",$_SESSION["user_id"],$_SESSION["user_id"]);
         $stmt -> execute();
         $stmt->bind_result($pid,$local,$desc);
         while($stmt->fetch()){
           
           echo $sExtra = <<<EOF
                    <div class="pin">
                        <div class="holder">
                            <div class="actions" pin_id="1">
                                <a href="repin.php?pid={$pid}&id={$bid}" class="btn red"><span class="entypo-pinterest"></span></a>
                                
                                <a href="#" class="button comment_tr">Comment</a>
                                
                                <a href="like.php?pid={$pid}" class="btn light"><span class="entypo-heart"></span></a>
                                
                            </div>
                            <a class="image gallery" href="service.php?id={$pid}" title="Photo number 1" pin_id="1">

                            <img src="{$local}" />
                    
                            </a>
                        </div>

                            <p class="desc">{$desc}</p>
            
                        
                        <p class="info"><span> likes</span>
                        <span> repins</span>
                        </p>

                        
                        
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
}


if(isset($search_board)){
    
      //$un = $search_board;
      //$un_html = htmlspecialchars($un);

            $con = new mysqli("localhost", "root", "root", "pinterest","8889");

            /* check connection */
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            $connect = new mysqli("localhost", "root", "root", "pinterest","8889");

            /* check connection */
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            echo '<div class="board_container">';
        if($stmt = $mysqli->prepare(
                                    "(SELECT B.bid, B.bname, count(*) from BOARD as B, PIN as P 
                                     where  B.bid = P.bid and B.uid <> ? and B.description like '%$un%' group by B.bid,B.bname) 
                                     UNION
                                     (SELECT B.bid, B.bname, count(*) from BOARD as B, PIN as P 
                                     where  B.bid = P.bid and B.uid <> ? and B.category = '$un' group by B.bid,B.bname)
                                     UNION
                                     (SELECT B.bid, B.bname, count(*) from BOARD as B, PIN as P 
                                     where  B.bid = P.bid and B.uid <> ? and B.bname like '%$un%' group by B.bid,B.bname) 
                                     "
                                    )){
          //$user_id = $_SESSION["user_id"];
         // echo $_SESSION["user_id"];
          
          $stmt->bind_param("iii", $_SESSION["user_id"],$_SESSION["user_id"],$_SESSION["user_id"]);
          $stmt->execute();
          
          $stmt->bind_result($boardid,$boardname,$pin_num);
           while($stmt->fetch())
           {
            $bid = $boardid;
            $bname=$boardname;
            $num=$pin_num;
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
                  <ul class="nav">
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
                  echo $go=<<<EOF
                  </ul>
                  <div class="edit">
                  <button type="button" class="edit_button">Edit</button>
                  </div>
                </div>
EOF;
                }
              $cover->close();
            }
          } 
          $stmt->close();   
        }

        $connect ->close();
        $con->close();
        echo '</div>';

 
}











$mysqli->close();


?>

</body>

</html>





  


























