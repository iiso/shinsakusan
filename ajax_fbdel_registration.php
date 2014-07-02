<?php
	
	require_once('config.php');
    require_once('functions.php');
    connectDb();
    session_start();
	
    
    session_start();
    $r = mysql_query(sprintf('SELECT id FROM musicians Where id="%s"',
			       mysql_real_escape_string($_POST['id'])
			     
			     ));
    $id = mysql_fetch_assoc($r);
    
	$rs = mysql_query(sprintf("DELETE FROM users_musicians WHERE musician_id=%d AND user_id=%d",
                              mysql_real_escape_string($id['id']),
                              mysql_real_escape_string($_SESSION['user']['member_id'])
                              
                              ));	
    ?>