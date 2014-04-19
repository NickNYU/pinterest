/**
 *
 * Pinterest-like script - a series of tutorials
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */

jQuery(document).ready(function () {
                jQuery('a.gallery').colorbox({ opacity:0.5 , rel:'group1' });
            });

$(document).ready(function(){



    // masonry initialization
    $('.main_container').masonry({
        // options
        itemSelector : '.pin',
        isAnimated: true,
        isFitWidth: true
    });

    // onclick event handler (for comments)
    $('.comment_tr').click(function () {
        $(this).toggleClass('disabled');
        $(this).parent().parent().parent().find('form').slideToggle(250, function () {
            $('.main_container').masonry();
        });
		$(this).parent().parent().parent().find('ul').slideToggle(250, function () {
            $('.main_container').masonry();
        });
    }); 
	
	// onclick event handler (for like button)
    $('.pin .actions .likebutton').click(function () {
        var iPId = $(this).attr('pic_id');
    
		var act = document.getElementById(iPId).innerHTML;
		
		if(act=="Like"){
        $.ajax({ 
          url: 'like.php',
          type: 'GET',
          data: 'pid=' + iPId,
          cache: false,  
          success: function(){
			//todo=$(this).attr('todo','unfollow');
            document.getElementById(iPId).innerHTML = "DisLike";
          } 
        });
        return false;
    }
		if(act=="DisLike"){
        $.ajax({ 
          url: 'dislike.php',
          type: 'GET',
          data: 'pid=' + iPId,
          cache: false, 
          success: function(){
			//todo=$(this).attr('todo','unfollow');
            document.getElementById(iPId).innerHTML = "Like";
          } 
        });
        return false;
    }
	}); 
	$('.request').click(function () {
        
        var Sid = $(this).attr('id');
		var followAct=document.getElementById(Sid).innerHTML;
		if(followAct=="FollowAll"){
        $.ajax({ 
          url: 'friendrequest.php',
          type: 'POST',
          data: 'fid=' + Sid,
          cache: false, 
          success: function(res){
            document.getElementById(Sid).innerHTML = "Follow sent";
          } 
        });
        return false;
		}
    }); 
	
	$('.deleteFriend').click(function () {
        
        var Did = $(this).attr('id');
		var friendAct=document.getElementById(Did).innerHTML;
		if(friendAct=="UnFollow"){
        $.ajax({ 
          url: 'deleteFriend.php',
          type: 'GET',
          data: 'did=' + Did,
          cache: false, 
          success: function(res){
            document.getElementById(Did).innerHTML = "Deleted";
          } 
        });
        return false;
		}
    }); 
	$('.pin .actions .repinbutton').click(function () {
        
        var Pid = $(this).attr('id');
		var Bid = $(this).attr('bid');
		var deleteAct=document.getElementById(Pid).innerHTML;
		if(deleteAct=="Delete"){
        $.ajax({ 
          url: 'deleteRepin.php',
          type: 'GET',
          data: 'pid=' + Pid+'&bid='+Bid,
          cache: false, 
          success: function(res){
            document.getElementById(Pid).innerHTML = "Deleted";
          } 
        });
        return false;
		}
    }); 
	
    
});
