<?php

    require_once('config.php');
    require_once('functions.php');
    require_once('facebook/facebook.php');


    session_start();

    connectDb();
    mysql_query('set names UTF8');



//作品情報取得
$sql = 'SELECT musicians.*,musics.* FROM musicians,musics WHERE musicians.id = '.$_GET['id'].' AND musics.musician_id='.$_GET['id'];
    $res = mysql_query($sql) or die(mysql_error());
  //  $musics = mysql_fetch_assoc($res);

//登録者数取得
      $sql3 = 'SELECT COUNT(*) FROM users_musicians WHERE musician_id ='.$_GET['id'];
    $res3 = mysql_query($sql3) or die(mysql_error());
    $count = mysql_fetch_assoc($res3);

//アーティスト情報取得
    $sql2 = 'SELECT musicians.* FROM musicians WHERE id = '.$_GET['id'];
    $res2 = mysql_query($sql2) or die(mysql_error());
    $musician = mysql_fetch_assoc($res2);

//登録済みか否か
  $sql4= sprintf('SELECT um.* FROM users_musicians um WHERE um.user_id = %d AND musician_id = %d ',
                  mysql_real_escape_string($_SESSION['user']['member_id']),
		  $_GET['id']);
 $res4 = mysql_query($sql4) or die(mysql_error());
  $um = mysql_fetch_assoc($res4);
    ?>



<!DOCTYPE html>
<html lang="ja"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<meta id="title" property="og:title">
<meta id="description" property="og:description" content="説明文が入ります">
<meta id="url" property="og:url" content="http://shinsakusan.sakura.ne.jp/artist.php?id=35">
<meta id="image" property="og:image" content="">
<meta property="og:site_name" content="新作さん">
<meta property="og:type" content="article">
<link rel="stylesheet" href="./css/reset.css" media="all">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/pc.css">
<script type="text/javascript" src="JS/jquery-1.7.2.min.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
<style type="text/css">
li.work.shere {
  border: double red;
  /*padding: 1%;*/
}
</style>
</head>
<body>
  <article class="artist-page">
    <div class="sp-sv"><span class="sp-svname">SHINSAKU-SAN</span></div>
    <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="./home.php"><span class="sp">ホーム</span><span class="pc">SHINSAKU-SAN</span></a></li>
          <li class="search"><a href="./search-result-nothing.php">登録する</a></li>
          <li class="profile"><a href="./profile.php?id=<?php print( $_SESSION['user']['member_id']); ?>">マイリスト</a></li>
        </ul>
      </div>
    </nav>
    <section class="artist-top">
      <div class="artist-data">
	<?php
    // 写条件分岐　アー写が無い場合
	if (empty($musician["image"])){
	    ?>
	       <figure class="nophoto"><p>No-Photo</p></figure>
	       <?php }else{
    //アー写がある場合
	?>
            <figure><img src="<?php print($musician["image"]); ?>"></figure>
	    <?php } ?>
            <p class="artist-name"><?php print($musician["name"]); ?></p>
            <p class="added-number">登録数 : <span class="number"><?php print($count["COUNT(*)"]); ?></span></p>
             <p class="button">
		  <?php
    if (!empty($um)) { ?>
                   <span  onclick="" href="#" class="register-button active"  id="del_registration" name="<?php print($musician["name"]); ?>" value="<?php print($musician[image]); ?>">
		   <?php  }else{ ?>
		    <span  onclick="" href="#" class="register-button"  id="register" name="<?php print($musician["name"]); ?>" value="<?php print($musician[image]); ?>">
                      <?php   }  ?>

      </div>
    </section>
    <section class="artist-works">
      <ul class="works-list">
	 <?php
    if (!empty($res)) {
      ?>

<?php while ($music = mysql_fetch_assoc($res)) {
        ?>
           <li class="work <?php if ($music[id] == $_GET['num']) print("shere") ?>" id="<?php print ($music[id]); ?>">
	      <figure class="jacket">
		<?php if(empty($music[image_url])){
		    ?>
	     <div class="nophoto-jacket"><p>No-Photo</p></div>
		<?php }else{ ?>
		<img src="<?php print($music[image_url]); }?>"></figure>
	       <div class="work-info">
            <p class="work-name"><?php print($music["name"]); ?></p>
            <div class="release-date">
              <p class="month"><span class"number"><?php print ($music["release_date"][5]); ?><?php print ($music["release_date"][6]); ?></span>月</p>
              <p class="date"><span class"number"><?php print ($music["release_date"][8]); ?><?php print ($music["release_date"][9]); ?></span>日</p>
              <p>発売</p>
            </div>
	    </div>
	        <div class="link-area">
            <a class="amazon-button" href="<?php print ($music[url]); ?>" target="_blank">この新作の詳細を見る</a>
            <div class="social-button">
              <span>シェアする：</span>
              <!-- facebookシェア -->
              <!-- <button id="fb">しぇあ</button> -->
              <a id="facebook-button" class="facebook-button" href="http://www.facebook.com/share.php?u=http://shinsakusan.sakura.ne.jp/artist.php?id=<?php print ($musician[id]); ?>%26num=<?php print ($music[id]); ?>%23<?php print ($music[id]); ?>" onclick="window.open(this.href, 'FBwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;"></a>

              <script>
              (function($, window, document){
                $(function() {
                  $('a#facebook-button').on('click', function(){
                    $('head')
                      .find('meta#title')
                      .attr({content: "<?php print ($musician[name]); ?> 新作情報 「<?php print ($music[name]); ?>」<?php print ($music[release_date]); ?>発売"});
                      // console.log($('head').find('meta#title'));
                      console.log();
                  });
                });
              }(window.jQuery, window, document));
              </script>
              <!-- twitter -->
              <a class="twitter-button" href="http://twitter.com/share?count=horizontal&original_referer=http://shinsakusan.sakura.ne.jp/artist.php?id=<?php print ($musician[id]); ?>&num=<?php print ($music[id]); ?>&text=<?php print ($musician[name]); ?>%20新作情報%20「<?php print ($music[name]); ?>」<?php print ($music[release_date]); ?>発売&url=http://shinsakusan.sakura.ne.jp/artist.php?id=<?php print ($musician[id]); ?>%26num=<?php print ($music[id]); ?>%23<?php print ($music[id]); ?>" onclick="window.open(this.href, 'tweetwindow', 'width=550, height=450,personalbar=0,toolbar=0,scrollbars=1,resizable=1'); return false;"></a>
            </div>
          </div>
          </li>
          <?php
            $arr = array();
            $i++;
            $arr[$i] = $music[id];
            // print_r($arr);
          ?>

	  <?php }?><?php }else{ echo ('まだ作品情報がありません。'); } ?>
      </ul>
    </s