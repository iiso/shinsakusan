<?php

    require_once('config.php');
    require_once('functions.php');
    require_once('facebook/facebook.php');
   require "php/config.inc.php";


    session_start();

    connectDb();
    mysql_query('set names UTF8');


    //既存のプロフィール取得
    $sql= 'SELECT facebook_user_id,facebook_name,email FROM p_users WHERE member_id='.$_GET['id'];
    $rs = mysql_query($sql) or die(mysql_error());
    $profile = mysql_fetch_assoc($rs);
if(empty($profile)) {
    jump('index.php');
    
    }
    
$sql2 = 'SELECT users_musicians.*,musicians.* FROM users_musicians,musicians WHERE users_musicians.user_id ='.$_GET['id'].'  AND users_musicians.musician_id = musicians.id ';
    $artists = mysql_query($sql2) or die(mysql_error());


    $sql3 = 'SELECT COUNT(*) FROM users_musicians WHERE user_id ='.$_GET['id'].' ';
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
          <li class="profile"><a href="./profile.php?id=<?php print( $_SESSION['user']['member_id']); ?>">マイリスト</a></li>
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
      <div class="social-button">
              <span>シェアする：</span>
              <!-- facebookボタンパラメーター動かない -->
<!--               <a class="facebook-button" href="http://www.facebook.com/dialog/feed?
                app_id=581119165295767&
                link=http://shinsakusan.sakura.ne.jp/artist.php?id=<?php print ($musician[id]); ?>&num=<?php print ($music[id]); ?>&
                name=Facebook%20Dialogs&
                caption=Reference%20Documentation&
                description=Using%20Dialogs%20to%20interact%20with%20users.&
                redirect_uri=http://shinsakusan.sakura.ne.jp/artist.php?id=<?php print ($musician[id]); ?>"></a> -->
              <a class="twitter-button" href=""></a>
              <!-- facebookボタン正常に動く -->
              <div class="fb-share-button" data-href="http://shinsakusan.sakura.ne.jp/artist.php?id=<?php print ($musician[id]); ?>&num=<?php print ($music[id]); ?>#<?php print ($music[id]); ?>" data-type="link"></div>
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
            <a href="artist.php?id=<?php print ($artist[id]);?>"> 
		<?php if(empty($artist[image])){ ?>
		 <span class="img">
		     <div class="nophoto-artist"><p>No-Photo</p></div>
		 </span>
	<?php	}else{ ?>
	    <span class="img">
                <img src="<?php print($artist[image]); ?>">	    
            </span>
	    <?php } ?>
            </a>
              <span class="text">
                <p class="name"><?php print($artist["name"]); ?></p>
                <p class="button">
		<span onclick="" href="#" class="register-button active"  id="del_registration" name="<?php print($artist["name"]); ?>" value="<?php print($artist[image]); ?>"> </span>
                 
                 
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
      