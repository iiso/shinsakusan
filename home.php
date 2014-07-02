<?php

    require_once('config.php');
    require_once('functions.php');
    require "php/config.inc.php";
   // require_once('../common.php');

    session_start();

    if (empty($_SESSION['user'])) {
        jump('index.php');
    }



    connectDb();
    mysql_query('set names UTF8');
  

    $sql2 = 'SELECT musics.name AS m_name,musics.release_date,musics.musician_id,musics.url,musics.image_url,users_musicians.*,musicians.* FROM musics,users_musicians,musicians WHERE release_date >= CURRENT_DATE()  AND users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_musicians.musician_id = musics.musician_id AND musicians.id = musics.musician_id ORDER BY release_date limit 7 ';

    $music =  mysql_query($sql2) or die(mysql_error());
    $musics = mysql_fetch_assoc($music);


    $sql= sprintf('SELECT facebook_user_id,facebook_name FROM p_users WHERE member_id=%d',
                  mysql_real_escape_string($_SESSION['user']['member_id']));
    $rs = mysql_query($sql) or die(mysql_error());
    $profile = mysql_fetch_assoc($rs);

   
$sql3 = 'SELECT musics.name AS m_name,musics.release_date,musics.musician_id,musics.url,musics.image_url,users_musicians.*,musicians.* FROM musics,users_musicians,musicians WHERE  release_date < CURRENT_DATE()  AND users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_musicians.musician_id = musics.musician_id AND musicians.id = musics.musician_id ORDER BY release_date';
 $rs3 = mysql_query($sql3) or die(mysql_error());
    ?>
<!DOCTYPE html>
<html lang="ja"><head>
<script type="text/javascript" src="JS/jquery-1.7.1.js"></script>
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
<script type="text/javascript" src="./js/jquery-1.8.2.min.js"></script>
</head>
<body>
  <article class="home">
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
  <?php require("header.php"); ?>
     <section class="search-area">
      <div class="search-area-bg1">
        <div class="search-area-link">
          <a href="./search-result-nothing.php">
             <h1>好きなアーティストを<br>検索して新作登録しよう</h1>
             <p>検索して登録する</p>
          </a>
        </div>
      </div>
      <div class="search-area-tab">
            <ul id="tabnavi" class="tab">
                <li class="left on">
                     <a href="home.php">
                     <span>これから発売</span>
                     </a>
                </li>
               <li class="right"><a href="./home_old.php"><span>過去に発売</span></a></li>
            </ul>
        </div>
    </section>
  
    <div id="tabcontent" class="release-soon">
      <div id="#tab01" class="artist-list">
        <ul>
            
      <?php
    if (!empty($musics)) {
        
        $sql2 = 'SELECT musics.name AS m_name,musics.release_date,musics.musician_id,musics.url,musics.image_url,users_musicians.*,musicians.* FROM musics,users_musicians,musicians WHERE release_date >= CURRENT_DATE()  AND users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_musicians.musician_id = musics.musician_id AND musicians.id = musics.musician_id ORDER BY release_date';

        $music =  mysql_query($sql2) or die(mysql_error());
        
    while ($item = mysql_fetch_assoc($music)) {  
        ?>
         <li class="release-info-box">
            <div class="time">
            <p class="month">
                <span class"number">
                     <?php print ($item["release_date"][5]); ?><?php print ($item["release_date"][6]); ?>
                </span>月
            </p>
              <p class="date">
                <span class"number">
                      <?php print ($item["release_date"][8]); ?><?php print ($item["release_date"][9]); ?>
                </span>日
            </p>
            </div>
            <a href="artist.php?id=<?php print($item["musician_id"]); ?>">
           
              <span class="img"><?php
               //条件分岐 ジャケ写がない場合
               if(empty($item[image_url])){   ?>
                <div class="nophoto"><p>No-Photo</p></div>
                <?php }else{
            　 //条件分岐 ジャケ写がある場合
                    ?> 
                <img src="<?php print($item[image_url]);?>">
                <?php }?>
              </span>
            </a>
            <div class="text">
              <p class="release-title">
                <a href="artist.php?id=<?php print($item["musician_id"]); ?>" target="_blank"><?php print($item["m_name"]); ?></a>
              </p>
	            <p class="name">
                <a href="artist.php?id=<?php print($item["musician_id"]); ?>"><?php print ($item["name"]); ?></a>
              </p>
            </div>
          </li>
          <?php }?>　<?php }else{ echo ('発売予定の商品がまだありません。'); }?>
          
        </ul>
      </div>
    
    </div>
  </article>
    <?php require("footer.php"); ?>