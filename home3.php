<?php

    require_once('config.php');
    require_once('functions.php');
    require "php/config.inc.php";
   // require_once('../common.php');

    session_start();

    if (empty($_SESSION['user'])) {
        jump('www/index.php');
    }



    connectDb();
    mysql_query('set names UTF8');

    if(!empty($_POST)){

     /**   print '<script language="JavaScript">
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
                       } **/

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
        }


    $sql= sprintf('SELECT facebook_user_id,facebook_name FROM p_users WHERE member_id=%d',
                  mysql_real_escape_string($_SESSION['user']['member_id']));
    $rs = mysql_query($sql) or die(mysql_error());
    $profile = mysql_fetch_assoc($rs);

    /**
    $sql = 'SELECT books.*,users_keywords.* FROM books,users_keywords WHERE users_keywords.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_keywords.artist_id = books.author_id ORDER BY publish_date DESC ';

    $book =  mysql_query($sql) or die(mysql_error());
   **/

    $sql2 = 'SELECT musics.*,users_musicians.* FROM musics,users_musicians WHERE users_musicians.user_id ='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND users_musicians.musician_id = musics.musician_id ORDER BY release_date DESC ';

    $music =  mysql_query($sql2) or die(mysql_error());



    ?>


<!DOCTYPE html>
<html lang="ja">
<head>
<script type="text/javascript" src="JS/jquery-1.7.1.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/jquery.tagsinput.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/pnotify.js"></script>
<script type="text/javascript"　charset="utf-8">





function onAddTag(tag) {
    alert("Added a tag: " + tag);
}
function onRemoveTag(tag) {
    alert("Removed a tag: " + tag);
}

function onChangeTag(input,tag) {
    alert("Changed a tag: " + tag);
}

$(function() {

  $('#tags_1').tagsInput({width:'auto'});

  });


$(function() {

  $('#tags_2').tagsInput({width:'auto'});

  });


</script>


<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/pnotify.css" />
<link rel="stylesheet" type="text/css" href="css/index.css" />
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.17.custom.css" />

<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="shortcut icon" href="img/shortcut.png">

　<meta name="keywords" content="新作、新刊、rss、新作情報、最新刊、最新作、新譜">
<title>新作さんβ</title>

</head>
<?php
    if(!empty($_POST['saved'])){
    ?>
<script language="JavaScript">
    $(function(){
      $.pnotify({
                title: 'お知らせ',
                text: '登録内容を保存しました！　　　　　最新作が発売されましたらメールでお知らせします。',
                animation: 'show'
                });
      });

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36894618-1']);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();



    </script>
<?php }


?>



<body >
<link rel="stylesheet" type="text/css" href="css/jquery.tagsinput.css" />
<script src="JS/bootstrap.min.js"></script>
<div class="container">

<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a class="brand" href="www/home.php" style="font-family:"ヒラギノ丸ゴ Pro W4","Hiragino Kaku Gothic StdN";"><img src="img/bull-horn.png" width="30px;">　新作さんβ</a>

<ul class="nav">


<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="icon-calendar"></i>発売スケジュール表
<span class="caret"></span>
</a>


<ul class="dropdown-menu">
<li><a href="schedule_book.php"><i class="icon-book"></i> 書籍</a></li>
<li><a href="schedule_music.php"><i class="icon-music"></i> 音楽</a></li>

</ul>
</li>


</ul>




<ul class="nav pull-right">
	<li class=""><a href="contact.php"><i class="icon-envelope"></i>Contact</a></li>


<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="icon-wrench"></i>アカウント設定
<span class="caret"></span>
</a>


<ul class="dropdown-menu">
<li><img  src="http://graph.facebook.com/<?php print ($profile[facebook_user_id]);?>/picture" width="40" height="40" style="padding:5px;border-radius:5px;"><?php print ($profile[facebook_name]);?>さん
</li>
<li><a href="setting.php"><i class="icon-folder-open"></i>アカウント</a></li>
<li><a href="logout.php"><i class="icon-off"></i>ログアウト</a></li>

</ul>
</li>
</div>
</div>
</div>
</br>


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
					<div class="input">
						<label>Track:</label>
						<input type="text" name="track" id="track" value="" />
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
						<td colspan="3">Search for an Artist or Track above</td>
					</tr>
				</tbody>
			</table>
		</div>
    <div class="row2" >


        <div class="span6" id="Settings">
            <h2><img src="img/bull-horn.png" width="30px;">　お知らせリスト登録<hr></h2>



<p class="description" >最新作の情報を知りたい作家名やアーティスト名を、</br>
お知らせリストに登録して下さい。</br></br>
新作が発売され次第、メールでお知らせします。</p>

            <form action="" method="post" >



</br>

                <div class="tabbale">
                    <ul class="nav nav-tabs" id="line">
                    <li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-pencil"></i>作家・漫画家を登録</a></li>
                    <li><a href="#tab2" data-toggle="tab"><i class="icon-music"></i>音楽アーティストを登録</a></li>
                    </ul>
                        <div class="tab-content">

                            <div id="tab1" class="tab-pane fade in active">
※画面右上の検索窓から著者名を検索出来ます。</br></br>
<input id='tags_1' type='text' class='tags' name='books' size='150'/>


                                <button class="btn btn-large btn-success" type="submit" value="保存する"/>登録する</BUTTON>


                            </div>


                            <div id="tab2" class="tab-pane fade">



<input id='tags_2' type='text' class='tags' name='musics' size='150'  value='<?php  $sql2= sprintf('select distinct name from musicians m, users_musicians um where m.id=um.musician_id and user_id=%d',
mysql_real_escape_string($_SESSION['user']['member_id']));
$record2 = mysql_query($sql2) or die (mysql_error());
while( $my_tags2 = mysql_fetch_assoc($record2)){
    $m_tags2= $my_tags2[name].',';
    echo h($m_tags2);
}
?>'
/></p>


                                <button class="btn btn-large btn-success" type="submit" value="保存する"/>登録する</BUTTON>
<input type="hidden" name="saved" value="1" />


                            </div>


                    </form>


                </div>
            </div>



            </br>
        </div>
<div class="span3 well" id="search_contents" style="">
<div id="search_results">
<blockquote>
<h4>作家・漫画家の名前を作品名で検索</h4>
</blockquote>


<textarea id="text1" name="best" cols="20" rows="1" placeholder="作品名を入力してください。" ></textarea>
<BUTTON class="btn btn-info" id="search" name="best"><i class="icon-search"></i>検索</BUTTON>

<div id="amazon_product" style="display:none">
<img class="test" src="test">
<b class="a_title">商品</b>
<c class="a_value"></c><br>
<BUTTON class="btn btn-info"　id="test" name="choice">リストに追加</BUTTON>
</div> <!--amazon_product-->
</div> <!--search_results-->
</div> <!--span3 well-->
<div class="span3 well" id="search_contents" style="">
<blockquote>
<h4>間もなく発売</h4>
</blockquote>

<?php

    $today = date('Y-m-d');
    $n_month = date("Y/m/d",strtotime("+1 month"));

    while($musics = mysql_fetch_assoc($music)){
        if(strtotime($today) < strtotime($musics[release_date]) && strtotime($musics[release_date]) < strtotime($n_month)){
            echo <<<EOM


            <h4><i class="icon-music"></i>　{$musics[release_date]}　発売予定</h4></br>
             <a href="{$musics[url]}" target="_blank">
            <img src="{$musics[image_url]}">
            </a>
            <br />
           {$musics[musician_name]}</br>
            </a>
            <a href="{$musics[url]}" target="_blank">
            {$musics[name]}
            </a>
</br></br>






EOM;
        }
    }



?>


	<script src="js/jquery-ui-1.8.17.custom.min.js"></script>
	<script src="js/jquery.tablePagination.0.5.min.js"></script>

	<script src="js/jquery-common.js"></script>
</div>
    </div>

</div>

</br></br>


</body>
</html>





br></br>


</body>
</html>





