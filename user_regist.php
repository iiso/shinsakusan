<?php
  require_once('config.php');
  require_once('functions.php');
  require "php/config.inc.php";

/* 入力フォームからパラメータを取得 */
$formList = array('mode','pre_member_id','input_email','input_password','input_name');

/* ポストデータを取得しパラメータと同名の変数に格納 */
foreach($formList as $value) {
  $$value = $_POST[$value];
}

/* エラーメッセージの初期化 */
$error = array();

if(count($error) == 0) {

  //登録するデーターにエラーがない場合、memberテーブルにデータを追加する。
  //トランザクション開始
  mysql_query("begin");

  $query = "UPDATE p_users SET password='{$input_password}', facebook_name='{$input_name}' WHERE email = '{$input_email}'";

  $result = mysql_query($query);

  if($result){  //登録完了
    //トランザクション終わり
    mysql_query("commit");

    /* 登録完了メールを送信 */
    mb_language("japanese");  //言語の設定
    mb_internal_encoding("utf-8");//内部エンコーディングの設定

    $to = $input_email;
    $subject = "会員登録URL送信メール";
    $message = "会員登録ありがとうございました。";
    $header = "From:test@test.com";

    if(!mb_send_mail($to, $subject, $message, $header)) {  //メール送信に失敗したら
      array_push($error,"メールが送信できませんでした。<br>ただしデータベースへの登録は完了しています。");
    }
  } else {  //データベースへの登録作業失敗
    //ロールバック
    mysql_query("rollback");
    array_push($error, "データベースに登録できませんでした。");
  }
}
if(count($error) == 0) {
?>
<table>
  <caption>データベース登録完了</caption>
  <tr>
    <td class="item">Thanks：</td>
    <td>登録ありがとうございます。<br>登録完了のお知らせをメールで送信しましたので、ご確認ください。</td>
  </tr>
</table>
<?php
/* エラー内容表示 */
} else {
?>
<table>
  <caption>データベース登録エラー</caption>
  <tr>
  <td class="item">Error：</td>
  <td>
  <?php
  foreach($error as $value) {
    print $value;
  ?>
  </td>
  </tr>
</table>
<?php
  }
}
?>
