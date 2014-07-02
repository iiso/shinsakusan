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
?>



<!DOCTYPE html>
<!--  <?php global $c; $c++; echo $c;?>
<?php echo $post->ID;?>-->
<html lang="ja">
<head>
 <script type="text/javascript" src="JS/jquery-1.7.1.js"></script>

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
  <article class="register-finish">
    <nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-register">
          <li class="next"><a href="home.php">トップページへ移動する</a></li>
        </ul>
      </div>
    </nav>
    <section class="register-title">
      <h1 class="catch" style="letter-spacing:-1px;">これで登録は完了です！<br>トップページで内容を<br>確認してみましょう。</h1>
      <div class="steps">
        <ul>
          <li class="step">1</li>
          <li class="arrow"><hr></li>
          <li class="step">2</li>
          <li class="arrow"><hr></li>
          <li class="step on">3</li>
        </ul>
      </div>

      <div class="gototop-area">
        <div class="button"><a href="home.php">トップページへ移動する</a></div>
        <p class="sub-text">登録したアーティストは<br>自由に追加、削除することができます。</p>
      </div>
    </section>

    <!--<section class="register-artist">
      <div class="title-bar">
        <h2>登録したアーティスト</h2>
      </div>
      <div class="artist-list">
        <ul>
          
           <?php
      if (!empty($artists)) {
  ?>
  <?php
      while ($artist = mysql_fetch_assoc($artists)) {
  ?>
            <li class="artist-box-added" >
               <div class="added-layer-top" id="<?php print($artist["id"]); ?>">
              <div class="added-mark">
              <img class="check-icon" src="./img/basic/check.png"><p>登録中</p></div>
                
            </div>
              <span class="text"><span class="name"><?php print($artist["name"]); ?></span></span>
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
        <div class="next"><a class="blue-button" href="home.php">サービスを開始する</a></div>
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
</body>
</html>​