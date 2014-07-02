<?php
    
    require_once('config.php');
    require_once('functions.php');
    
    header('Content-type: text/html; charset=UTF-8');
    
    session_start();
       
    connectDb();
    
  
    $sql = 'SELECT musics.musician_id, musics.musician_name , musics.id AS mid, musics.name, musicians.* FROM musics, musicians WHERE musics.musician_id = musicians.id  AND musics.musician_name != musicians.name';
    $rs = mysql_query($sql) or die(mysql_error());
    
    if (!empty($rs)) {
       while ($musics = mysql_fetch_assoc($rs)) {
        $sql2 = sprintf('DELETE FROM musics WHERE id =%d',
                         mysql_real_escape_string($musics['mid']));
        mysql_query($sql2) or die(mysql_error());               
        var_dump($musics['mid']);
       }
        
        }
?>
