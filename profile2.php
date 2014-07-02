<?php

    require_once('config.php');
    require_once('functions.php');
    require_once('facebook/facebook.php');
   require "php/config.inc.php";


    session_start();




    connectDb();
    mysql_query('set names UTF8');


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

    ?>




<html lang="ja"><head>
<script type="text/javascript" src="JS/jquery-1.7.1.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
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
  <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.17.custom.css" />
<script type="text/javascript" src="&lt;?php bloginfo(" template_url');="" ?="">/js/jquery-1.8.2.min.js'></script>
</head>
<body>


  <article class="home">
  	<nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="home.php">トップへ</a></li>
          <li class="search"><a href="">登録</a></li>
          <li class="edit"><a href="">編集する</a></li>
          <li class="profile"><a href="">プロフ</a></li>
        </ul>
      </div>
    </nav>
    <section class="profile-info">
      <div>
        <figure class="user-img"><img src="http://graph.facebook.com/<?php print ($profile[facebook_user_id]);?>/picture"></figure>
        <div class="user-info">
          <p class="user-name"><?php print h($profile[facebook_name]);?></p>
          <p class="register-number"><span class="number"><?php print $count["COUNT(*)"]; ?></span>アーティスト登録</p>
        </div>
        <div class="profile-edit"><a class="button-edit" href="">プロフィールを編集する</a></div>
      </div>
    </section>
    <section class="search-area">
    	<h3>アーティストを登録する</h3>
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
            <span class="text">
	     <a href="artist.php?id=<?php print ($artist[id]); ?>"> <p class="name"><?php print($artist["name"]); ?></p></a>
	    </span>
	     <BUTTON id="del_registration" name="<?php print($artist["name"]); ?>" class="btn  btn-mini" value="<?php print($artist["image"]); ?>">解除する</BUTTON>
	    <span class="img">
	      <img src="<?php if(empty($artist[image]))
	    { print('img/nowprinting.jpeg');
	    }else{print($artist[image]);}?>" >
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
    </section>
  </article>
<script src="js/jquery-ui-1.8.17.custom.min.js"></script>
	<script src="js/jquery.tablePagination.0.5.min.js"></script>
	<script src="js/jquery-common.js"></script>
​</body></html>