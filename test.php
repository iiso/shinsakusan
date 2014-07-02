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
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
<script type="text/javascript" src="JS/share.min.js"></script>
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
<script type="text/javascript" src="&lt;?php bloginfo(" template_url');="" ?="">/js/jquery-1.8.2.min.js'></script>
   <script>
    $(function(){
      $('.share-button').share({
        title: 'Share Button Test',
        image: 'http://carrot.is/img/fb-share.jpg',
        app_id: '602752456409826',
        background: 'rgba(255,255,255,.5)',
        color: '#3B2B45',
        flyout: 'top center',
        text_font: true
      });
    });
  </script>
</head>
<body>
  <article class="profile">
     <div class="sp-sv"><span class="sp-svname">SHINSAKU-SAN</span></div>
  	 <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="./home.php"><span class="sp">ホーム</span><span class="pc">SHINSAKU-SAN</span></a></li>
          <li class="search"><a href="./search-result-nothing.php">登録する</a></li>
          <li class="profile"><a href="./profile.php">マイリスト</a></li>
          <script type="text/javascript">
          $(function(){ $('.nav-wrap .nav-static li a').each(function(){ var $href = $(this).attr('href');
            if(location.href.match($href)) {
            $(this).addClass('active');
            } else {
            $(this).removeClass('active');
            }
         });
     });
           </script>
        </ul>
      </div>
    </nav>
    <section class="profile-info">
      <div class="profile-info-wrap">
        <div class="profile-edit"><a href="#" class="edit-icon"></a></div>
        <figure class="user-img">
          <img src="http://graph.facebook.com/<?php print ($profile[facebook_user_id]);?>/picture">
        </figure>
        <div class="user-info">
          <p class="user-name"><?php print h($profile[facebook_name]);?></p>
          <p class="register-number">アーティスト登録数<span class="number"><?php print $count["COUNT(*)"]; ?></span></p>
        </div>
        
      </div>
    </section>
    <section class="profile-share">
      <div class="share-button share-button-top sharer-0" style="display: block;">
        <label class="entypo-export"><span class="share">自分の登録情報をシェアする</span></label>
        <div class="social top center">
          <p>シェアする場所を選択する</p>
          <ul>
            <li class="entypo-twitter" data-network="twitter">twああああああ</li>
            <li class="entypo-facebook" data-network="facebook">fb</li>
          </ul>
          <p class="share-button">閉じる</p>
        </div>
      </div>
      <div class="divider"></div>
    </section>
    <section class="register-artist">
      <div class="title-bar">
        <h2>登録したアーティスト</h2>
      </div>
      <div class="artist-list">
        <ul>
	   <?php
    if (!empty($artists)) { ?>

<?php

    while ($artist = mysql_fetch_assoc($artists)) {
        ?>
          <li class="artist-box">
            <a href="artist.php?id=<?php print ($artist[id]); ?>"> 
              <span class="img">
                <img src="<?php if(empty($artist[image]))
              { print('img/nowprinting.jpeg');}else{print($artist[image]);}?>" >
              </span>
            </a>
              <span class="text">
                <p class="name"><?php print($artist["name"]); ?></p>
                <p class="button">
                  <span href="#" class="register-button active">
                    <span onclick="" id="del_registration" name="<?php print($artist["name"]); ?>" class="add-button-on" value="<?php print($artist[image]); ?>"><a></a></span>
                  </span>
                </p>
              </span>
          </li>
	    <?php

    }?>

     <?php

    }else{
        echo ('まだアーティストを登録していません。');
    }

    ?>
        </ul>
      </div>
    </section>
  </article>
      <?php require("footer.php") ?>
      