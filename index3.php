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
<meta http-equiv="Content-Type" content=”text/html; charset=utf-8">
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
    <div class="head">
      <p class="service-title">SHINSAKU-SAN</p>
      <div class="logo"><a href=""><p class="white-border1"></p><p class="white-border2"></p></a></div>
    </div>
    <div class="copy">
      <h1 class="main-text">最短１分で、お気に入りアーティストの新作情報が逃さず届く</h1>
      <a  href="<?php echo($loginUrl); ?>" class="fbloginlp-button">Facebookで無料登録・ログイン</a>
    </div>
  </section>
  <section class="lp-artistlist">
    <div class="lp-subtitle">
      <h2>あなたのお気に入りのアーティストを登録することができます。</h2>
      <p>国内外問わず、あなたの好きなあのアーティストを登録することで新作情報を得ることができます。</p>
    </div>
    <div class="flow-area">
        <ul class="list-area">
            
             <?php


    while ($image = mysql_fetch_assoc($rs)) {
    
        ?>
           <li class="artist"><img src="<?php print($image[image]) ?>"></li>
           <?php
            }
    ?>
        </ul>
    
        <ul class="list-area">
            
             <?php


    while ($image2 = mysql_fetch_assoc($rs2)) {
    
        ?>

           <li class="artist"><img src="<?php print($image2[image]) ?>"></li>
           <?php
    }
    ?>
        </ul>
            <ul class="list-area">
            
             <?php

    while ($image2 = mysql_fetch_assoc($rs2)) {
    
        ?>
            
           <li class="artist"><img src="<?php print($image2[image]) ?>"></li>
           <?php
            }
    ?>
        </ul>
        
        
    </div>
    <script type="text/javascript">
$(function(){
  $('.flow-area').each(function(){
    var loopsliderWidth = $(this).width();
    var loopsliderHeight = $(this).height();
    $(this).children('ul').wrapAll('<div class="flow-area_wrap"></div>');

    var listWidth = $('.flow-area_wrap').children('ul').children('li').width();
    var listCount = $('.flow-area_wrap').children('ul').children('li').length;

    var loopWidth = (listWidth)*(listCount);

    $('.flow-area_wrap').css({
      top: '0',
      left: '0',
      width: ((loopWidth) * 2),
      height: (loopsliderHeight),
      overflow: 'hidden',
      position: 'absolute'
    });

    $('.flow-area_wrap ul').css({
      width: (loopWidth)
    });
    loopsliderPosition();

    function loopsliderPosition(){
      $('.flow-area_wrap').css({left:'0'});
      $('.flow-area_wrap').stop().animate({left:'-' + (loopWidth) + 'px'},85000,'linear');
      setTimeout(function(){
        loopsliderPosition();
      },25000);
    };

    $('.flow-area_wrap ul').clone().appendTo('.flow-area_wrap');
  });
});
</script>
  </section>
  <section class="lp-notificate">
    <div class="lp-subtitle">
      <h2>新作通知が届くまで</h2>
    </div>
    <ul>
      <li class="features">
        <div class="icon-one"></div>
          <h3>1.アーティストを検索する</h3>
          <p>検索して、登録したいアーティストを探しましょう。サービス登録時はFacebookでイイネしているアーティストを自動で探してくれます。</p>
      </li>
      <li class="features">
        <div class="icon-two"></div>
          <h3>2.アーティストを登録する</h3>
          <p>登録したいアーティストが見つかったらアーティストを登録しましょう。登録すると新作情報が届くようになります。</p>
      </li>
      <li class="features">
        <div class="icon-three"></div>
          <h3>3.メールで新作情報が届く</h3>
          <p>発売日当日に、また、１週間に１度、登録しているアーティストの新作情報を届けてくれます。</p>
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