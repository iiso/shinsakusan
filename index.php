<?php
    require_once('config.php');
    require_once('functions.php');
    require "php/config.inc.php";
    require_once('facebook/facebook.php');
    $facebook = new Facebook(array(
                                   'appId' => APP_ID,    // App ID/API
                                   'secret' => APP_SECRET,    // アプリの秘訣
                                   ));
    $user_id = $facebook->getUser();

    $loginUrl = $facebook->getLoginUrl(array(
                                             'scope' => 'email,publish_stream',
                                             'redirect_uri'  => 'http://shinsakusan.sakura.ne.jp/redirect.php'
                                             ));
    //メールアドレスログイン処理
    session_start();

    
    //アー写を取得
     $sql= 'SELECT distinct image FROM musicians where image <>"" ORDER BY RAND() limit 0,18 ';
     $rs = mysql_query($sql) or die(mysql_error());
     
     
    
   $sql2= 'SELECT distinct image FROM musicians where image <>"" ORDER BY RAND() limit 10,18';
    $rs2 = mysql_query($sql2) or die(mysql_error());
 

    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=”ja”>
<head>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content=”text/html; charset=utf-"8">
<title>新作さん　てすと</title>
<meta name="description" content="あなたの気になる「新作」の情報を見逃さないようにお知らせします。">
<meta name="keywords" content="新作、新刊、rss、新作情報、最新刊、最新作、新譜">

<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
                                                   k='66892733-0',d=document,l=d.location,c=d.cookie;
                                                   if(l.search.indexOf('utm_expid='+k)>0)return;
                                                   function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
                                                   indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write('<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+" typ="text/javascript" charset="utf-8"></s'+'ript>')})();
</script>
<script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

<link rel="stylesheet" href="css/reset.css" media="all">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/pc.css">


<meta property="og:image" content="http://shinsakusan.com/img/shinsakusan.png" />



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/imgpreview.js"></script>
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36894618-1']);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();

$(function(){
  $('a img').hover(
                   function(){
                   $(this).fadeTo(200, 0.6);
                   },
                   function(){
                   $(this).fadeTo(200, 1.0);
                   }
                   );
  });


</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
{lang: 'ja'}
</script>
<script type="text/javascript" src="//shutto.com/embed/sotaroii/convert.js" charset="utf-8"></script>
</head>
<body>
<article class="lp">

  <section class="lp-top">

    <div class="top-wrap">
    
    <div class="head">
      <p class="service-title">SHINSAKU-SAN</p>
    </div>

    <div class="contents-wrap">
      <div class="copy">
        <h1 class="main-text">新作情報を<br>二度と逃さない</h1>
        <p>発売日に大好きなアーティストの新作情報をお知らせしてくれるわりと便利なサービスです。</p>
        <a  href="<?php echo($loginUrl); ?>" class="fbloginlp-button">Facebookで無料登録・ログイン</a>
      </div>
      <figure><img src="./img/lp/lpsp-img1.png" alt="sp-img"><img src=""></figure>
    </div>

   </div>

  </section>

  <section class="lp-merit1">

    <div class="right">
      <h2>新作発売日に<br>メールでお届け</h2>
      <p>「新作さん」にあなたの好きなアーティストを登録しておけば、そのアーティストの新作の発売日にメールでお知らせします。</p>
   </div>

   <div class="left">
    <figure><img src="./img/lp/feature1.png"></figure>
   </div>
  </section>

  <section class="lp-merit2">
   <h2>毎月の新作情報を<br>まとめてお届け</h2>
   <p>当日の新作情報だけでなく、月の始めに<br>今月の登録アーティストの新作情報をまとめてお知らせ。</p>
   <div class="row">
    <div class="feature1">
      <div class="text">
        <h3>毎月1日にメールが届く</h3>
        <p>月の始めは「新作さん」をチェック</p>
      </div>
      <hr>
    </div>
    <div class="feature2">
      <img src="./img/lp/lpsp-img2.png" alt="img" class="monthly_notification">
    </div>
    <div class="feature3">
      <hr>
      <div class="text">
        <h3>欲しい情報だけお届け</h3>
        <p>登録したアーティストの新作情報だけ届くので、逃さない。</p>
      </div>
    </div>
   </div>
  </section>

  <section class="lp-notificate">
    <div class="lp-subtitle">
      <h2>アーティストを検索して登録<br>たったそれだけ</h2>
    </div>
    <ul>
      <li class="features">
        <div class="icon-one"></div>
          <h3>1.アーティストを検索する</h3>
          <p>サジェスト機能で簡単検索</p>
      </li>

      <li class="features">
        <div class="icon-two"></div>
          <h3>2.アーティストを登録する</h3>
          <p>大好きなバンドから気になるDJまで<br>忘れずに登録しよう</p>
      </li>
      <li class="features">
        <div class="icon-three"></div>
          <h3>3.メールで新作情報が届く</h3>
          <p>登録したアーティストに合わせて<br>新作さんからお知らせ</p>
      </li>
    </ul>
  </section>

  <section class="lp-start">
    <div class="lp-start-wrap">
      <h2>今すぐ新作さんを始める</h2>
      <a  href="<?php echo($loginUrl); ?>" class="fbloginlp-button">Facebookで無料登録・ログイン</a>
    </div>
  </section>
</article>

<footer>
    <div class="footer-wrap">
      <ul class="footer-menu">
        <li><a href="">よくある質問</a></li>
        <li><a href="">ご意見・ご要望</a></li>
        <li><a href="">ログアウト</a></li>
      </ul>
      <p class="logo-type"><a href="./index.html"><img src="./img/logo-an-type.png"></a></p>
      <p class="copyright">copyright©2014 SHINSAKU-SAN</p>
    </div>
  </footer>
<script>
$('ul#fourth a').imgPreview({
                            containerID: 'imgPreviewWithStyles2',
                            imgCSS: {
                            height: 250
                            },
                            onShow: function(link){
                            $('' + $(link).text() + '').appendTo(this);
                            },
                            onHide: function(link){
                            $('span', this).remove();
                            }
                            });
</script>
</body>
</html>