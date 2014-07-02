<?php
	
	require_once('config.php');
    require_once('functions.php');
      require_once('facebook/facebook.php');
    connectDb();
    session_start();
    
    
    mb_language("japanese");
    mb_internal_encoding("UTF-8");
    
     $facebook = new Facebook(array(
                                       'appId' => APP_ID,    // App ID/API
                                       'secret' => APP_SECRET,    // アプリの秘訣
                                       ));
        
        $user_token = 'Access Token';
        
        $attachment = array('access token' => $user_token,'message' => $_POST['name'].'を新作さんに登録しました！',
                            'link' => 'shinsakusan.sakura.ne.jp','picture' => $_POST['img']);
        
        $facebook->api('/me/feed', 'POST',$attachment);

    
   
    ?>