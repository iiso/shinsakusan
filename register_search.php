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


// facebookでイイねずみのアーティストを取得
$sql = 'SELECT users_musicians.*,musicians.* FROM users_musicians,musicians WHERE users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).'  AND users_musicians.musician_id = musicians.id ';
    $artists = mysql_query($sql) or die(mysql_error());

    $sql2 = 'SELECT users_musicians.*,musicians.* FROM users_musicians,musicians WHERE users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).'  AND users_musicians.musician_id = musicians.id ';
    $p_artists = mysql_query($sql2) or die(mysql_error());

    
    

?>



<!DOCTYPE html>
<!--  <?php global $c; $c++; echo $c;?>
<?php echo $post->ID;?>-->
<html lang="ja">
<head>
  <script type="text/javascript" src="JS/jquery-1.7.1.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/jquery.tagsinput.js"></script>

<script type="text/javascript"  charset="utf-8" src="JS/pnotify.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/jquery.noty.packaged.min.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<meta property="og:title" content="" />
<meta property="og:description" content="" />
<meta property="og:url" content="" />
<meta property="og:image" content="" />
<meta property="og:site_name" content="" />
<meta property="og:type" content="article" />
<link rel="stylesheet" href="./css/reset.css" media="all">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/pc.css">
  <link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.17.custom.css" />

</head>
<body>
  <article class="register-search">
    <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-register">
          <li class="next"><a href="./register-finish.php">次のステップに進む</a></li>
        </ul>
      </div>
    </nav>
    <section class="register-title">
      <h1 class="catch" style="letter-spacing:-1px;">お気に入りの<br>アーティストを検索して<br>登録しよう</h1>
      <div class="steps">
        <ul>
          <li class="step">1</li>
          <li class="arrow"><hr></li>
          <li class="step on">2</li>
          <li class="arrow"><hr></li>
          <li class="step">3</li>
        </ul>
      </div>
    </section>
    
     
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
			<form action="./" method="POST" id="search" onsubmit="return false;">
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
			<table id="tracks" >
				
				<tbody>
					
				</tbody>
			</table>
		</div>
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
            <a> 
              <span class="img">
                <img src="<?php if(empty($artist[image])){ print('img/nowprinting.jpeg');}else{print($artist[image]);}?>" ></span>
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
    <?php    }?>

     <?php 
   }else{
        echo ('まだアーティストを登録していません。');}?>
        </ul>
        <div class="next"><a class="button-next" href="register-finish.php">次のSTEPへ</a></div>
      </div>
        
    </section>
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
<script src="js/jquery-ui-1.8.17.custom.min.js"></script>
	<script src="js/jquery.tablePagination.0.5.min.js"></script>
	<script src="js/jquery-common.js"></script>
	<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
  <script>
   $('.button span.register-button').click(function(){
   $(this).toggleClass('active');});</script>
</body>
</html>​