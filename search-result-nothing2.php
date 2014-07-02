<?php
require_once('config.php');
require_once('functions.php');
require_once('facebook/facebook.php');
require "php/config.inc.php";

session_start();
connectDb();
mysql_query('set names UTF8');

if (empty($_SESSION['user']) && $_SESSION['user']['facebook_user_id'] == null) {
  jump('index.php');
}


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
    
    
    $sql4 = 'SELECT users_musicians.*,musicians.* FROM users_musicians,musicians WHERE users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).'  AND users_musicians.musician_id = musicians.id ';
    $aaa = mysql_query($sql4) or die(mysql_error());


    $sql3 = 'SELECT COUNT(*) FROM users_musicians WHERE user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' ';
    $res2 = mysql_query($sql3) or die(mysql_error());
    $count = mysql_fetch_assoc($res2);

    
    
    

?>
<!DOCTYPE html>
<html lang="ja"><head>
<script type="text/javascript" src="JS/jquery-1.7.2.min.js"></script>
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
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.17.custom.css" />

</head>
<body>
  <article class="search-result-nogthing">
  	<div class="sp-sv"><span class="sp-svname">SHINSAKU-SAN</span></div>
    <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="./home.php"></a></li>
          <li class="search"><a href="./search-result-nothing.php">登録する</a></li>
          <li class="profile"><a href="./profile.php">マイリスト</a></li>
        </ul>
      </div>
    </nav>
    <section class="home-search">
    	<h1>検索して<br>アーティストを登録する</h1>
<div id="search_div" class="sixteen columns">
			<noscript>
			<p class="flash_bad">
				Your browser currently doesn't support javascript or you have it turned off.
				Functionality will be limited and will only return a list of nearby stores.
			</p>
			</noscript>

			<?php if($db === FALSE): ?>
			<ul class="flash_bad">
				<li>Unable to connect to the database, please check your settings</li>
			</ul>
			<?php endif; ?>

			<!--
			This is the main Form HTML
			-->
            <section class="register-title-search" >
			  <form  method="POST" id="search" onsubmit="return false;">
				<fieldset>
	
					<div class="input">
						<input type="search" name="artist" id="artist" value="" class="search-form" placeholder="アーティスト名を入力" />
						<img src="imgs/ajax-loader.gif" class="ajax_loader hide"/>
					</div>

				</fieldset>
			  </form>
		   </section>
			<!--
			This will populate via Ajax requesr after an Artist or Track search
			-->
			
		</div>
    </section>
    <section class="search-result-artist">
      <div class="artist-search-result">
              <span class="img">
                <a href="artist.php?id=<?php print ($artist[id]); ?>">
                  <img src="<?php if(empty($artist[image]))
              { print('img/nowprinting.jpeg');}else{print($artist[image]);}?>" ></a></span>
            </a>
              <span class="text">
                <p class="name">
                  <a href="artist.php?id=<?php print ($artist[id]); ?>"><?php print($artist["name"]); ?></a>
                </p>
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
                    <span  onclick="" id="del_registration" name="<?php print($artist["name"]); ?>" class="add-button-on" value="<?php print($artist[image]); ?>"></span>
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
	       
	       
	            
        <ul>
	   <?php
    if (!empty($aaa)) { ?>

<?php

    while ($aaaa = mysql_fetch_assoc($aaa)) {
        ?>
          <li class="artist-box">
            <a href="artist.php?id=<?php print ($aaaa[id]); ?>"> 
              <span class="img">
                <img src="<?php if(empty($aaaa[image]))
              { print('img/nowprinting.jpeg');}else{print($aaaa[image]);}?>" >
              </span>
            </a>
              <span class="text">
                <p class="name"><?php print($aaaa["name"]); ?></p>
                <p class="button">
                  <span onclick="" href="#" class="register-button active" id="del_registration" name="<?php print($aaaa["name"]); ?>" class="add-button-on" value="<?php print($aaaa[image]); ?>">
                   
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
      
	       
	       
              </span>
          </div>
    </section>
    <table id="tracks" >
				
				<tbody>
					
				</tbody>
			</table>
   <!-- <section class="search-result">
      <!--<div class="search-result-list-nothing">
        <figure class="sinsakukun"><img src=""></figure>
        <p>アーティスト名を入力して<br>お気に入りのアーティストを<br>登録するぜよ</p> 
      </div>
    </section>-->
  </article>
  <footer>
    <div class="footer-wrap">
      <ul class="footer-menu">
        <li><a href="">よくある質問</a></li>
        <li><a href="">ご意見・ご要望</a></li>
        <li><a href="logout.php">ログアウト</a></li>
      </ul>
      <p class="logo-type"><a href="./index.html"><img src="./img/logo-an-type.png"></a></p>
      <p class="copyright">copyright©2014 SHINSAKU-SAN</p>
    </div>
  </footer>
 <!-- <ul class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" role="listbox" aria-activedescendant="ui-active-menuitem" style="z-index: 1; top: 139px; left: 158px; display: block; width: 954px;">
    <li class="ui-menu-item" role="menuitem">
      <a class="ui-corner-all" tabindex="-1">Avicii</a></li><li class="ui-menu-item" role="menuitem"><a class="ui-corner-all" tabindex="-1">Avicii &amp; Sebastien Drums</a></li><li class="ui-menu-item" role="menuitem"><a class="ui-corner-all" tabindex="-1">Avicii vs. Nicky Romero</a></li></ul>-->
  <script src="js/jquery-ui-1.8.17.custom.min.js"></script>
	<script src="js/jquery.tablePagination.0.5.min.js"></script>
	<script src="js/jquery-common.js"></script>
	
	
	     
	
</body>
</html>