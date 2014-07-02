<?php
	
	require_once('config.php');
    require_once('functions.php');
    connectDb();
    session_start();
    
    $sql = sprintf('select * from musicians where id="%s"',
                           mysql_real_escape_string($_POST['id']));
            $res = mysql_query($sql) or die(mysql_error());
           
    $id = mysql_fetch_assoc($res);
    
    $res2 = mysql_query (sprintf("SELECT * from users_musicians where musician_id=%d AND user_id=%d",
				mysql_real_escape_string($id['id']),
                              mysql_real_escape_string($_SESSION['user']['member_id'])
				
				));
    
    $result = mysql_fetch_assoc($res2);
    
    if(empty($result)){
	$rs = mysql_query(sprintf("insert into users_musicians set musician_id=%d, user_id=%d",
                            mysql_real_escape_string($id['id']),
                              mysql_real_escape_string($_SESSION['user']['member_id'])
                              
                              ));}
    ?>