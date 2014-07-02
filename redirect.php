<?php

require_once('config.php');
require_once('functions.php');
require_once('facebook/facebook.php');
require_once('Services/Amazon.php');


session_start();

    $amazon=&new Services_Amazon('AKIAJRUABQVC4GZ64R7A',
                                 'yNenTU+Hb2dJPGmlxE+95Dy4a/3Qui2yU58dPddg','shinsakusan2-22');
    $amazon->setLocale('JP');//Amazon.co.jpを使う



    $facebook = new Facebook(array(
                                   'appId' => APP_ID,    // App ID/API
                                   'secret' => APP_SECRET,    // アプリの秘訣
                                   ));
    $user_id = $facebook->getUser();
  //  var_dump($user_id);
    if($user_id){
        try{
            $me = $facebook->api('/me');
        }catch(FacebookApiException $e){
            error_log($e);
        }
    }
   // var_dump($me);

    connectDb();
    $q = sprintf("select * from p_users where facebook_user_id='%s' limit 1", r($me['id']));
    $rs = mysql_query($q);
    $user = mysql_fetch_assoc($rs);


    if (empty($user)) {
    $q = sprintf("insert into p_users (facebook_user_id, facebook_name, icon,email,created, modified) values ('%s','%s','%s','%s',now(),now());",
                 r($me['id']),
                 r($me['name']),
                 r($me['picture']),

                 r($me['email'])

                 //r($facebook->getAccessToken();)
                 );
    $rs = mysql_query($q);
    // 挿入されたデータをひっぱってきて$userにセット
    $q = sprintf("select * from p_users where member_id=%d limit 1", mysql_insert_id());
    $rs = mysql_query($q);
        $user = mysql_fetch_assoc($rs);
        $_SESSION['user'] = $user;

        $permissions = $facebook->api("/me/permissions");
        if( array_key_exists('publish_stream', $permissions['data'][0]) ) {

        $user_token = 'Access Token';

        $attachment = array('access token' => $user_token,'message' =>  '〜気になる「新作」の情報を見逃さないようにお知らせします〜　新作さんβに参加しました。',
                            'picture' => 'http://shinsakusan.com/img/shinsakusan.png',
                            'link' => 'http://shinsakusan.com/',);

 $facebook->api('/me/feed', 'POST',$attachment );
        }

        //FBに登録してあるお気に入りミュージシャンをDBに挿入
        $musics = $facebook->api('/me/music?fields=id,name,picture.type(large)');
        $max = sizeof($musics['data']);
      //  Var_dump($musics['data'][1]["picture"]["data"]["url"]);


        $sql = sprintf('DELETE FROM users_musicians where user_id=%d',
                       mysql_real_escape_string($_SESSION['user']['member_id']));
        mysql_query($sql) or die(mysql_error());

        for($i = 0;$i< $max;$i++){
            $last_id="";

            $sql = sprintf('select * from musicians where name="%s"',
                           mysql_real_escape_string($musics['data'][$i]["name"]));
            $res = mysql_query($sql) or die(mysql_error());

            while($tag_id = mysql_fetch_assoc($res)){
                $last_id = $tag_id['id'];
                $last_picture = $tag_id['image'];
            }
            //insert image url into the musician field where the image is empty
            if($last_id!="" && $last_picture==""){
                $sql = sprintf('update  musicians set image="%s" where id = %d',
                               mysql_real_escape_string($musics['data'][$i]["picture"]["data"]["url"]),
                                mysql_real_escape_string($last_id)
                               
                               );
                mysql_query($sql) or die(mysql_error());
             //   $last_id = mysql_insert_id();
            }
            if($last_id==""){
                $sql = sprintf("INSERT into musicians (name, image) values ('%s','%s');",
                               mysql_real_escape_string($musics['data'][$i]["name"]),
                               mysql_real_escape_string($musics['data'][$i]["picture"]["data"]["url"]));
                mysql_query($sql) or die(mysql_error());
                $last_id = mysql_insert_id();
            }

            $sql = sprintf('insert into users_musicians set musician_id=%d, user_id=%d',
                           mysql_real_escape_string($last_id),
                           mysql_real_escape_string($_SESSION['user']['member_id']));
            mysql_query($sql) or die(mysql_error());
        }

        //FBに登録してあるお気に入り本の著者名をDBに挿入
        /**
        $books = $facebook->api('/me/books?fields=id,name');
        $max_book = sizeof($books['data']);

        $sql = sprintf('DELETE FROM users_keywords where user_id=%d',
                       mysql_real_escape_string($_SESSION['user']['member_id']));
        mysql_query($sql) or die(mysql_error());


       for($i = 0;$i< $max_book;$i++){

           $response = 'Medium';
           $options = array();
           $options['Keywords'] = $books['data'][$i]["name"];
           $options['ResponseGroup'] = $response;

           $response = $amazon->ItemSearch('Books', $options);
           if (!PEAR::isError($response))
           {
               $last_id="";

               $sql = sprintf('select * from keywords where name="%s"',
                              mysql_real_escape_string($response["Item"][0][ItemAttributes][Author][0]));
               $res = mysql_query($sql) or die(mysql_error());

               while($tag_id = mysql_fetch_assoc($res)){
                   $last_id = $tag_id['id'];
               }
               if($last_id==""){
                   $sql = sprintf('insert into keywords set name="%s"',
                                  mysql_real_escape_string($response["Item"][0][ItemAttributes][Author][0]));
                   mysql_query($sql) or die(mysql_error());
                   $last_id = mysql_insert_id();
               }
               $sql = sprintf('insert into users_keywords set artist_id=%d, user_id=%d',
                              mysql_real_escape_string($last_id),
                              mysql_real_escape_string($_SESSION['user']['member_id']));
               mysql_query($sql) or die(mysql_error());


           }
       }
**/

        $url = 'http://shinsakusan.sakura.ne.jp/register-fb.php';
       header('Location: '.$url);
        exit;
    }

    // ログイン処理
    if (!empty($user)) {
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
    }

    // index.phpにリダイレクト
    jump('home.php');




?>