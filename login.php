<?php
require_once('config.php');
require_once('functions.php');
require "php/config.inc.php";
//セッション作成
session_start();

if(!isset($_POST['login'])) {
  //ログインフォームを表示
  inputForm();
} else {

  //フォームの値を取得
  $formEmail = $_POST['formEmail'];
  $formPassword = $_POST['formPassword'];

  //ID, PASWORDが未入力の場合
  if(($formEmail == "") || ($formPassword == "")) {

  //エラー関数の呼び出し
  error(1);

  } else {
  //ID,PASSWORD 入力アリ

  //memberテーブルのデータを取得
  $query = "select * from p_users";
  $result = mysql_query($query);

  //フォームから取得したUSERIDとデータベース内のUSERIDが一致したらデータベースのPASSWORDを変数に格納
  while($data = mysql_fetch_array($result)) {
    if($data['email'] == $formEmail) {  //フォームから取得したUSERIDとデータベースのUSERIDが一致
      $dbPassword = $data['password'];
      $facebook_name = $data['facebook_name'];
      break;
    }
  }

  //$dbPasswordという変数に値が格納されていない場合→formEmailとデータベースのIDが不一致
  if(!isset($dbPassword)) {
    error(2);
  } else {
  //formEmailとデータベースのIDが一致
  //フォームのパスワードとデータベース内のパスワードが不一致
    if($dbPassword != $formPassword){
	  error(3);
	} else {
	  //ID,パスワードどちらも一致
	  //セッション変数を作成→セッション変数に　$formEmail を登録
	  $_SESSION['loginUser'] = $formEmail;
    //セッション変数に$userを登録
    $q = sprintf("insert into p_users (facebook_user_id, facebook_name, icon,email,created, modified) values ('null','%s','null','%s',now(),now());",
      r($data['facebook_name']),
      r($data['email'])
    );
    $rs = mysql_query($q);
    // 直前に挿入されたデータをひっぱってきて$userにセット
    $q = sprintf("select * from p_users where member_id=%d limit 1", mysql_insert_id());
    $rs = mysql_query($q);
    $user = mysql_fetch_assoc($rs);
    $_SESSION['user'] = $user;
    header("Location:home.php");
    }
	}
  }
}
?>
<?php
  //入力画面表示画面
  function inputForm() {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ログイン</title>
</head>
<body>
  <h1>ログインページ</h1>
  <form action="login.php" method="post">
  <label for="userid">ユーザーID</label>：
  <input type="text" name="formEmail" id="userid"/>
  <br />
  <label for="password">パスワード</label>：
  <input type="text" name="formPassword" id="password"/>
  <br />
  <input type="submit" name="login" value="ログイン" />
</form>
</body>
</html>
<?php
}

//エラー表示関数
function error($errorType) {

  switch($errorType) {
    case 1:
    $errorMsg = "IDとパスワードを入力してください。";
    break;

    case 2:
    $errorMsg = "IDが違います";
    break;

    case 3:
    $errorMsg = "パスワードが違います";
    break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ログイン</title>
</head>
<body>
<h1>エラーページ</h1>
<?php
  print $errorMsg;
?>
</body>
</html>
<?php
}
?>