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
  /** 
    if(!empty($_POST)){

     print '<script language="JavaScript">
        alert("設定を保存しました！"); </script>'; **/
/**
        //作家情報をDBに挿入
        $tags = explode ( ',', $_POST['books'] );

        $sql = sprintf('DELETE FROM users_keywords where user_id=%d',
                       mysql_real_escape_string($_SESSION['user']['member_id']));
        mysql_query($sql) or die(mysql_error());
        foreach($tags as $tag){
            $last_id="";


            $sql = sprintf('select * from keywords where name="%s"',
                           mysql_real_escape_string($tag));
            $res = mysql_query($sql) or die(mysql_error());
            while($tag_id = mysql_fetch_assoc($res)){
                $last_id = $tag_id['id'];
            }
                if($last_id==""){
                    $sql = sprintf('insert into keywords set name="%s"',
                                   mysql_real_escape_string($tag));
                    mysql_query($sql) or die(mysql_error());
                    $last_id = mysql_insert_id();
                }


                $sql = sprintf('insert into  users_keywords set artist_id=%d, user_id=%d',
                               mysql_real_escape_string($last_id),
                               mysql_real_escape_string($_SESSION['user']['member_id']));
                mysql_query($sql) or die(mysql_error());
                       } 

         //音楽アーティスト情報をDBに挿入
        $tags = explode ( ',', $_POST['musics'] );

        $sql = sprintf('DELETE FROM users_musicians where user_id=%d',
                       mysql_real_escape_string($_SESSION['user']['member_id']));
        mysql_query($sql) or die(mysql_error());
        foreach($tags as $tag){
            $last_id="";


            $sql = sprintf('select * from musicians where name="%s"',
                           mysql_real_escape_string($tag));
            $res = mysql_query($sql) or die(mysql_error());
            while($tag_id = mysql_fetch_assoc($res)){
                $last_id = $tag_id['id'];
            }
            if($last_id==""){
                $sql = sprintf('insert into musicians set name="%s"',
                               mysql_real_escape_string($tag));
                mysql_query($sql) or die(mysql_error());
                $last_id = mysql_insert_id();
            }

            $sql = sprintf('insert into users_musicians set musician_id=%d, user_id=%d',
                           mysql_real_escape_string($last_id),
                           mysql_real_escape_string($_SESSION['user']['member_id']));
            mysql_query($sql) or die(mysql_error());
                    }
        }**/

    $sql2 = 'SELECT musics.name AS m_name,musics.release_date,musics.musician_id,musics.url,musics.image_url,users_musicians.*,musicians.* FROM musics,users_musicians,musicians WHERE release_date > CURRENT_DATE()  AND users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_musicians.musician_id = musics.musician_id AND musicians.id = musics.musician_id ORDER BY release_date limit 7 ';

    $music =  mysql_query($sql2) or die(mysql_error());
    $musics = mysql_fetch_assoc($music);

    $sql= sprintf('SELECT facebook_user_id,facebook_name FROM p_users WHERE member_id=%d',
                  mysql_real_escape_string($_SESSION['user']['member_id']));
    $rs = mysql_query($sql) or die(mysql_error());
    $profile = mysql_fetch_assoc($rs);

    /**
    $sql = 'SELECT books.*,users_keywords.* FROM books,users_keywords WHERE users_keywords.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_keywords.artist_id = books.author_id ORDER BY publish_date DESC limit 7 ';

    $book =  mysql_query($sql) or die(mysql_error());
   **/

$sql3 = 'SELECT musics.name AS m_name,musics.release_date,musics.musician_id,musics.url,musics.image_url,users_musicians.*,musicians.* FROM musics,users_musicians,musicians WHERE  release_date < CURRENT_DATE()  AND users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_musicians.musician_id = musics.musician_id AND musicians.id = musics.musician_id ORDER BY release_date';
 $rs3 = mysql_query($sql3) or die(mysql_error());
 //$pmusics = mysql_fetch_assoc($rs3);

 


    ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<script type="text/javascript" src="JS/jquery-1.7.1.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/jquery.tagsinput.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/pnotify.js"></script>
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
<link href="css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="&lt;?php bloginfo(" template_url');="" ?="">/js/jquery-1.8.2.min.js'></script>
</head>

 <script language="JavaScript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36894618-1']);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();

    </script>

<body>

  <article class="home">
  	<nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="">トップへ</a></li>
          <li class="search"><a href="">登録</a></li>
          <li class="edit"><a href="">編集する</a></li>
          <li class="profile"><a href="http://shinsakusan.sakura.ne.jp/profile.php">プロフ</a></li>
        </ul>
      </div>
    </nav>
	    <section class="home-search">
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
			<form action="./" method="POST" id="search">
				<fieldset>
					<legend>Search Artist or Track</legend>
					<div class="input">
						<label>Artist:</label>
						<input type="text" name="artist" id="artist" value="" />
						<img src="imgs/ajax-loader.gif" class="ajax_loader hide"/>
					</div>

				</fieldset>
			</form>
			<!--
			This will populate via Ajax requesr after an Artist or Track search
			-->
			<table id="tracks">
				<thead>
					<tr>
						<th>Artist</th>
						<th>Track</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr>

					</tr>
				</tbody>
			</table>
		</div>
	    </section>







    <section class="release-soon">
      <div class="title-bar">
        <h2>もうすぐ発売</h2>
      </div>
      <div class="artist-list">

        <ul>
	  <?php
    if (!empty($musics)) { ?>

<?php
    while ($item = mysql_fetch_assoc($music)) { 
        ?>
          <li class="artist-box">
            <span class="time"> <?php print ($item["release_date"]); ?>　</span>
            <span class="text"><p class="release-title"><a href="<?php print($item["url"]); ?>" target="_blank">  <?php print($item["m_name"]); ?></a></p>
	      <p class="name"><a href="artist.php?id=<?php print($item["musician_id"]); ?>"><?php print ($item["name"]); ?></p></a></span>
            <a href="<?php print($item["url"]); ?>" target="_blank">
	    <span class="img"><img src="<?php if(empty($item[image_url]))
	    { print($item[image]);
	    }else{print($item[image_url]);}?>"></a></span>
          </li>

	  <?php

    }?>

     <?php 

    }else{
        echo ('発売予定の商品がまだありません。');
    }

    ?>

    </ul>
	</div>
      </section>
    

    <section class="release-list">
    　　<div class="title-bar">
       　　 <h2>過去に発売</h2>
     　　 </div>
     　　 <div class="artist-list">
      　　  <ul>
          
           <?php 
    if (!empty($rs3)) {
        ?>

<?php
        
    while ($item2 = mysql_fetch_assoc($rs3)) {  
        ?>
        
         <li class="artist-box">
            <span class="time"> <?php print ($item2["release_date"]); ?>　</span>
            <span class="text"><p class="release-title"><a href="<?php print($item2["url"]); ?>" target="_blank">  <?php print($item2["m_name"]); ?></a></p>
	      <p class="name"><a href="artist.php?id=<?php print($item2["musician_id"]); ?>"><?php print ($item2["name"]); ?></p></a></span>
            <a href="<?php print($item2["url"]); ?>" target="_blank">
	    <span class="img"><img src="<?php if(empty($item2[image_url]))
	    { print($item2[image]);
	    }else{print($item2[image_url]);}?>"></a></span>
          </li>

	  <?php

    }
    }else{
        echo ('過去に発売された商品が見つかりませんでした');
    }

    ?>
        
       　　 </ul>
    </div>

</section>
  </article>
  <a href="logout.php">logout</a>
<script src="js/jquery-ui-1.8.17.custom.min.js"></script>
	<script src="js/jquery.tablePagination.0.5.min.js"></script>
	<script src="js/jquery-common.js"></script>
​</body></html>