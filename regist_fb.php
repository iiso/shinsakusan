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

if(!isset($_POST['artist_post'])){
  $artist = $_POST['artist'];
  print($artist);
}

?>
<!DOCTYPE html>
<!--  <?php global $c; $c++; echo $c;?>
<?php echo $post->ID;?>-->
<html lang="ja">
<head>
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
<script type = 'text/javascript' src = './js/jquery-1.8.2.min.js'></script>
</head>
<body>
  <article class="register-fb">
    <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-register-fb">
          <li class="login"><a href="">ログイン</a></li>
          <li class="next"><a href="">次のSTEPへ</a></li>
        </ul>
      </div>
    </nav>
    <section class="register-top">
      <div class="steps">
        <ul>
          <li class="step1"><a href="">STEP 1</a></li>
          <li class="step2"><a href="">STEP 2</a></li>
          <li class="step3"><a href="">STEP 3</a></li>
        </ul>
      </div>
      <h1 class="catch">Facebookでイイネしているアーティストを登録します</h1>
    </section>
    <section class="register-artist">
      <div class="title-bar">
        <h2>全てのチェックを外す</h2>
        <a href="button-allcheck"><span>解除</span></a>
      </div>
      <form name="form" method="post" action="regist_fb.php">
        <div class="artist-list">
          <ul>
  <?php
      if (!empty($artists)) {
  ?>
  <?php
      while ($artist = mysql_fetch_assoc($artists)) {
  ?>
            <li class="artist-box">
              <span class="checkbox"><input type="checkbox" name="artist[]" value="<?php print($artist["name"]); ?>" checked="checked"></span>
              <span class="name"><?php print($artist["name"]); ?></span>
              <span class="img">
                <img src="<?php if(empty($artist[image])) {
                  print('img/nowprinting.jpeg');
                } else {
                  print($artist[image]);}?>" >
              </span>
            </li>
  <?php } ?>
  <?php
      }else{
          echo ('まだアーティストを登録していません。');
      }
  ?>
          </ul>
          <div class="next">
            <input class="button-next" type="submit" name="artist_post" value="次のSTEPへ">
            <a class="button-next" href="">次のSTEPへ</a>
          </div>
        </div>
      </form>
    </section>
  </article>
</body>
</html>​