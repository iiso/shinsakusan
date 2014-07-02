<?php
    
    require_once('config.php');
    require_once('functions.php');
    require_once('facebook/facebook.php');
    
    
    session_start();
    
    if (empty($_SESSION['user'])) {
        jump('index.php');
    }
    
    
    connectDb();
    mysql_query('set names UTF8');
    
       
    //プロフィール設定
    if(!empty($_POST['email'])){
        $sql= sprintf('UPDATE p_users SET facebook_name="%s",email="%s" Where member_id=%d',
                      mysql_real_escape_string($_POST['name']),
                      mysql_real_escape_string($_POST['email']),
                      mysql_real_escape_string($_SESSION['user']['member_id']));
        
        mysql_query($sql) or die(mysql_error());
        print '<script language="JavaScript">
        alert("設定を変更しました"); </script>';
        
    }
    //既存のプロフィール取得
    $sql= sprintf('SELECT facebook_user_id,facebook_name,email FROM p_users WHERE member_id=%d',
                  mysql_real_escape_string($_SESSION['user']['member_id']));
    $rs = mysql_query($sql) or die(mysql_error());
    $profile = mysql_fetch_assoc($rs);
    
    
       
    ?>




<!DOCTYPE html>
<html lang="ja">
<head>
<script type="text/javascript" src="JS/jquery-1.7.1.js"></script>

<script type="text/javascript"  charset="utf-8" src="JS/jquery.tagsinput.js"></script>
<script type="text/javascript"  charset="utf-8" src="JS/function.js"></script>


<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/index.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/tag.css" />
<link rel="shortcut icon" href="img/shortcut.png">

<title>アカウント設定</title>
</head>


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
<i class="icon-calendar"></i>発売予定表
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
<div class="row" >


<div class="span7" id="Settings">
<h3>アカウント設定</h3></br>

<form action="" method="post">


<blockquote><dd>ユーザー名<dd>
<textarea name="name" maxlength="" rows="1" class="field span5" rows="1" value="">
<?php print h($profile[facebook_name]);?>
</textarea></dd>
</blockquote>
<blockquote>アイコン<dd><img  src="http://graph.facebook.com/<?php print ($profile[facebook_user_id]);?>/picture"></dd></blockquote></br>


<blockquote><dd>メールアドレス設定</dd>
<dd><textarea name="email" maxlength="" rows="1" class="field span5" rows="1" value="">
<?php print h($profile[email]);?>
</textarea></dd></blockquote>

</br><input type="submit" value="変更を保存する"/>
</form>
</br>
</br>

<h3>退会</h3></br>

<form action="account_delete.php" method="post" onclick="return check()" style="">
<button type="submit" class="btn btn-danger"　 value="アカウントを削除する"/>
<i class="icon-trash"></i><span>退会する</span></button>
<input type="hidden" name="id" value="<?php  echo h($_SESSION['user']['member_id']) ?>" />
</form>

</br><a href="index.php">トップページへ</a>

</div>
</div>
</div>

<div id="fb-root"></div>

</a>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({
        appId : 346957875347433,
        status : true,
        cookie : true,
        xfbml : true
        });

function FacebookInviteFriends(){	 FB.ui({
                                           method : 'apprequests', // 「'apprequests'」固定(必須)
                                           title: 'Rekomを友達に紹介しよう',
                                           message : '自分に最適な「オススメ」が見つかるRekomを初めてみませんか？', // サイトの説明文など
                                           filters : ['app_non_users'] // アプリ未利用のユーザのみ一覧に表示
                                           });
}

</script>


</body>
</html>



