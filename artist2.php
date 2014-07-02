<?php
    
    require_once('config.php');
    require_once('functions.php');
    require_once('facebook/facebook.php');
    
    
    session_start();
    
  
    
    
    connectDb();
    mysql_query('set names UTF8');
    
    
    
    
$sql = 'SELECT musicians.*,musics.* FROM musicians,musics WHERE musicians.id = '.$_GET['id'].' AND musics.musician_id='.$_GET['id'];
    $res = mysql_query($sql) or die(mysql_error());
    $musics = mysql_fetch_assoc($res);
      
      
      $sql3 = 'SELECT COUNT(*) FROM users_musicians WHERE musician_id ='.$_GET['id'];
    $res3 = mysql_query($sql3) or die(mysql_error());
    $count = mysql_fetch_assoc($res3);
    
    $sql2 = 'SELECT musicians.* FROM musicians WHERE id = '.$_GET['id'];
    $res2 = mysql_query($sql2) or die(mysql_error());
    $musician = mysql_fetch_assoc($res2);
    
    ?>



<html lang="ja"><head>
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
</head>
<body>
  <article class="home">
  	<nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="">トップへ</a></li>
          <li class="search"><a href="">登録</a></li>
          <li class="edit"><a href="">編集する</a></li>
          <li class="profile"><a href="">プロフ</a></li>
        </ul>
      </div>
    </nav>
    <section class="artist-info">
      <div>
        <figure class="artist-img"><img src="<?php print($musician["image"]); ?>"></figure>
        <div class="artist-inof">
          <p class="artist-name"><?php print($musician["name"]); ?></p>
          <p class="register-number">登録者数<span class="number"><?php print($count["COUNT(*)"]); ?></span></p>
          <div class="social">
            <p>このアーティストの新作情報をシェアする</p>
              <ul>
                <li class="facebook"><a href=""></a></li>
                <li class="twitter"><a href=""></a></li>
              </ul>
          </div>
        </div>
        <div class="profile-edit"><a class="button-edit" href="">プロフィールを編集する</a></div>
      </div>
    </section>
     <section class="release-list">
    　　<div class="title-bar">
       　　 <h2>アーティストの新作一覧</h2>
     　　 </div>
      
     　　 <div class="artist-list">
	<ul>
	 <?php 
    if (!empty($musics)) { ?>

<?php

    while ($music = mysql_fetch_assoc($res)) {
        ?>
	
          <li class="artist-box">
	       <span class="text">
	     <span class="time"> <?php print ($music["release_date"]); ?>発売　</span>
         
	     <a href="<?php print ($music[url]); ?>" target="blank"> <p class="name"><?php print($music["name"]); ?></p></a>
	    </span>
	    <span class="img">
	      <img src="<?php if(empty($music[image_url]))
	    {print($music[image]);
	    }else{print($music[image_url]);}?>" >
	    </span>
          </li>
	  
	  <?php 
    }?>
    
     <?php
    
    }else{
        echo ('まだ作品情報がありません。');
    }

    ?>
	
	
       　　 </ul>
    </div>
  </section>
  </article>

​</body></html>