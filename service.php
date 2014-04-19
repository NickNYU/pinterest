<!DOCTYPE html>
<?php session_start(); ?><html>

<head>
        <meta charset="utf-8" />
        <meta name="author" content="Script Tutorials" />
        <title>Board_Picture</title>

        <!-- add styles -->
        <link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/colorbox.css" rel="stylesheet" type="text/css" />
        
    </head>
<body>
<?php
		include ("include.php");
		
		$pid=$_GET['id'];
		
		$sql="select distinct U.uname, U.uid, P.local, pin.ptime from user U, picture P, pin, board B where P.pid=pin.pid and pin.bid=B.bid and B.uid=U.uid and P.pid = ? limit 1";
		if($stmt = $mysqli->prepare($sql))
		{
			
			$stmt->bind_param("i", $pid);
			$stmt->execute();
			$stmt->bind_result($uname,$uid,$url,$time);
			
			
		
		
		
	while($stmt->fetch())	
	{
echo $box = <<<EOF
<div class="pin bigpin">
    <div class="owner">
        <a href="#" class="button follow_button">Follow</a>
        <a target="_blank" class="owner_img" href="board.php?uid_vistor={$uid}">
            <img alt="Mr Brown" src="images/userimage.png" />
        </a>
        <p class="owner_name"><a target="_blank" href="board.php?uid_vistor={$uid}">{$uname}</a></p>
        <p class="owner_when">{$time}</p>
    </div>
    <div class="holder">
        <div class="actions">
            <a href="#" class="button">Repin</a>
            <a href="#" class="button">Like</a>
        </div>
        <a class="image" href="#" title="Photo">
           <img alt="Photo" src="{$url}" />
        </a>
    </div>

    <p class="desc">photo desc</p>

    <div class="comments"></div>

    <form class="comment" method="post" action="#">
        <input type="hidden" name="id" value="0" />
        <textarea placeholder="Add a comment..." maxlength="1000"></textarea>
        <button type="button" class="button">Comment</button>
    </form>
</div>
EOF;
}
$stmt->close();
}
$mysqli->close();
?>
</body></html>