<?php

    require_once('config.php');
    require_once('functions.php');
    require_once('facebook/facebook.php');
   require "php/config.inc.php";


    session_start();




    connectDb();
    mysql_query('set names UTF8');


    //既存のプロフィール取得
    $sql= sprintf('SELECT facebook_user_id,facebook_name,email FROM p_users WHERE member_id=%d',
                  mysql_real_escape_string($_SESSION['user']['member_id']));
    $rs = mysql_query($sql) or die(mysql_error());
    $profile = mysql_fetch_assoc($rs);

$sql2 = 'SELECT users_musicians.*,musicians.* FROM users_musicians,musicians WHERE users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).'  AND users_musicians.musician_id = musicians.id ';
    $artists = mysql_query($sql2) or die(mysql_error());


    $sql3 = 'SELECT COUNT(*) FROM users_musicians WHERE user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' ';
    $res2 = mysql_query($sql3) or die(mysql_error());
    $count = mysql_fetch_assoc($res2);

    ?>




<!DOCTYPE html>
<html lang="ja"><head>
<script type="text/javascript" src="JS/jquery-1.7.2.min.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/jquery.tagsinput.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/jquery.noty.packaged.min.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<meta property="og:title" content="">
<meta property="og:description" content="">
<meta property="og:url" content="">
<meta property="og:image" content="">
<meta property="og:site_name" content="">
<meta property="og:type" content="article">
<link rel="stylesheet" href="./css/reset.css" media="all">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/pc.css">
<link rel="stylesheet" type="text/css" href="css/jquery.noty.css"/>
<script type="text/javascript" src="&lt;?php bloginfo(" template_url');="" ?="">/js/jquery-1.8.2.min.js'></script>

</head>
<body>
  <article class="artist-edit-list">
    <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="./home.php"></a></li>
          <li class="search"><a href="./search-result-nothing.php">登録する</a></li>
          <li class="profile"><a href="./profile.php">マイリスト</a></li>
        </ul>
      </div>
    </nav>
    <section class="list-top">
      <div><p><a href="./profile.php">戻る</a></p><h1>登録しているアーティスト一覧</h1></div>
    </section>
    <section class="artist-list-edit">
       <ul class="artist-list">
         <?php
    if (!empty($artists)) { ?>

<?php

    while ($artist = mysql_fetch_assoc($artists)) {
        ?>
          <li class="artist-content">
              <figure class="artist-img"><img src="<?php if(empty($artist[image]))
	    { print('img/nowprinting.jpeg');
	    }else{print($artist[image]);}?>"></figure>
               <div class="artist-data">
            <p class="artist"><span class="artist-name"><?php print($artist["name"]); ?></span></p>
            <p class="button"><span onclick="" id="del_registration" name="<?php print($artist["name"]); ?>" class="add-button-on" value="<?php print($artist[image]); ?>"><a></a></span> </p>
          </div>
            
	    
          </li>

	  <?php

    }?>

     <?php

    }else{
        echo ('まだアーティストを登録していません。');
    }

    ?>
        
        
       </ul>
    </section>
  </article>
  <footer>
    <div class="footer-wrap">
      <div class="logo" src=""><a href=""><p class="white-border"></p><p class="white-border"></p></a></div>
      <p class="logo-type"></p>
      <p class="copyright">copyright©2014 SHINSAK-SAN</p>
    </div>
  </footer>
​</body></html>