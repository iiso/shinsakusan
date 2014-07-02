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
<script type="text/javascript" src="JS/jquery-1.7.1.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
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

</head>
<body>
  <article class="register-fb">
    <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-register">
          <li class="next"><a href="register_search.php">次のステップに進む</a></li>
        </ul>
      </div>
    </nav>
    <section class="register-title">
      <h1 class="catch">Facebookで<br>イイネしている<br>アーティストを登録しよう</h1>
      <div class="steps">
        <ul>
          <li class="step on">1</li>
          <li class="arrow"><hr></li>
          <li class="step">2</li>
          <li class="arrow"><hr></li>
          <li class="step">3</li>
        </ul>
      </div>
    </section>
    <section class="register-artist">
      <div class="title-bar"><a href="">チェックを外す</a></div>
      <div class="artist-list">
        
        <ul>
           <?php
      if (!empty($artists)) {
  ?>
  <?php
      while ($artist = mysql_fetch_assoc($artists)) {
  ?>
         <li class="artist-box">
            <a href="artist.php?id=<?php print ($artist[id]); ?>"> 
              <span class="img">
                <img src="<?php if(empty($artist[image]))
              { print('img/nowprinting.jpeg');}else{print($artist[image]);}?>" ></span>
            </a>
              <span class="text">
                <p class="name"><?php print($artist["name"]); ?></p>
                <p class="button">
                  <span href="#" class="register-button">
                    <span onclick="" id="del_registration" name="<?php print($artist["name"]); ?>" class="add-button-on" value="<?php print($artist[image]); ?>"></span>
                    <script>
                    $('.button span.register-button').click(function(){
                      $(this).toggleClass('active');});</script>
                </p>
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
             <a  href="register_search.php" class="button-next" type="submit" name="artist_post">次のステップに進む</a>
        </div>
      </div>
   
    </section>
  </article>
      <?php require("footer.php"); ?>