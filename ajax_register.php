<?php
	
	require_once('config.php');
    require_once('functions.php');
    connectDb();
    session_start();
   // insert new musician data
	if(!empty($_POST['name'])){
	$sql = sprintf('select * from musicians where name="%s"',
                           mysql_real_escape_string($_POST['name']));
            $res = mysql_query($sql) or die(mysql_error());
            while($artist_id = mysql_fetch_assoc($res)){
                $last_id = $artist_id['id'];}
		if($last_id==""){
                $sql = sprintf('insert into musicians set name="%s", image="%s"',
                               mysql_real_escape_string($_POST['name']),
			       mysql_real_escape_string($_POST['img'])
			       );
                mysql_query($sql) or die(mysql_error());
                $last_id = mysql_insert_id();
            }else{
		$sql = sprintf('UPDATE  musicians set image="%s" where id=%d',
			       mysql_real_escape_string($_POST['img']),
			       mysql_real_escape_string($last_id)
			       );
		mysql_query($sql) or die(mysql_error());
               
	    }
    
    // insert user_musician relation data
    $res2 = mysql_query (sprintf("SELECT * from users_musicians where musician_id=%d AND user_id=%d",
				mysql_real_escape_string($last_id),
                              mysql_real_escape_string($_SESSION['user']['member_id'])
				
				));
    
    $result = mysql_fetch_assoc($res2);
    
    
    if(empty($result)){
	$rs = mysql_query(sprintf("insert into users_musicians set musician_id=%d, user_id=%d",
                            mysql_real_escape_string($last_id),
                              mysql_real_escape_string($_SESSION['user']['member_id'])
                              
                              ));
	
    }
	}else{
		
		$sql = sprintf('select * from musicians where name="%s"',
                           mysql_real_escape_string($_POST['title']));
            $res = mysql_query($sql) or die(mysql_error());
            while($artist_id = mysql_fetch_assoc($res)){
                $last_id = $artist_id['id'];}
		if($last_id==""){
                $sql = sprintf('insert into musicians set name="%s", image="%s"',
                               mysql_real_escape_string($_POST['title']),
			       mysql_real_escape_string($_POST['img'])
			       );
                mysql_query($sql) or die(mysql_error());
                $last_id = mysql_insert_id();
            }
    
    
    $res2 = mysql_query (sprintf("SELECT * from users_musicians where musician_id=%d AND user_id=%d",
				mysql_real_escape_string($last_id),
                              mysql_real_escape_string($_SESSION['user']['member_id'])
				
				));
    
    $result = mysql_fetch_assoc($res2);
    
    
    if(empty($result)){
	$rs = mysql_query(sprintf("insert into users_musicians set musician_id=%d, user_id=%d",
                            mysql_real_escape_string($last_id),
                              mysql_real_escape_string($_SESSION['user']['member_id'])
                              
                              ));
	
    }
		
		
		
		
		
	}
	
	
	
	
	
   
	
    ?>