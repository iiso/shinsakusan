<?php
    
    require_once('config.php');
    require_once('functions.php');
        
    
    session_start();
    connectDb();
    mysql_query('set names UTF8');
    if (empty($_SESSION['user'])) {
        jump('www/index.php');
    }

    
    if ($_POST['id'] != ""){
        
        
        $sql7 = sprintf('DELETE FROM p_users WHERE member_id=%d',
                        mysql_real_escape_string($_SESSION['user']['member_id'])
                        );
        $sql8 = sprintf('DELETE FROM users_keywords WHERE user_id=%d',
                        mysql_real_escape_string($_SESSION['user']['member_id'])
                        );
        $sql9 = sprintf('DELETE FROM users_musicians WHERE user_id=%d',
                        mysql_real_escape_string($_SESSION['user']['member_id'])
                        );
                
        mysql_query($sql7) or die (mysql_error());
        mysql_query($sql8) or die (mysql_error());
        mysql_query($sql9) or die (mysql_error());
        
        header('Location: http://shinsakusan.com');
        exit;
        
    }else{
        
        header('Location: http://shinsakusan.com');
        exit;
    }
    
    
    ?>