<?php
require_once('config.php');
require_once('functions.php');
require "php/config.inc.php";

/*pre_member_idの値を取得*/
// if($mode == "regist_form") {
  $pre_member_id = $_GET['pre_member_id'];
// }

/* pre_member_id 有効チェック */
$errorFlag = true;

/* 取得したユニークIDをキーに登録されたメールアドレスを取得 */
$query = "SELECT email from p_users where pre_member_id = '$pre_member_id'";
$result = mysql_query($query);

/*データベースより取得したメールアドレスを表示*/
if(mysql_num_rows($result) > 0) { //取得した結果のデータの数が0以上なら → データが取得できた
  //データが正常に取得できた
  $errorFlag = false;
  $data = mysql_fetch_array($result);
  $email = $data['email'];
}

if($errorFlag) {  // pre_member_idが無効
?>

<table>
  <caption>メールアドレス登録エラー</caption>
  <tr>
    <td class="item">Error：</td>
    <td>このURLは利用できません。<br>もう一度メールアドレスの登録からお願いします。<br> <a href="index.php">会員登録ページ</a></td>
  </tr>
</table>
<?php
} else { // pre_member_idが有効
	// regist_confirmでのエラー表示
  if(count($error) > 0) {
    foreach($error as $value) {
	  print $value."<br>";
    }
  }
?>
<form method="post" action="regist_confirm.php">
  <input type="hidden" name="mode" value="regist_confirm">
  <input type="hidden" name="pre_member_id" value="<?php print $pre_member_id; ?>">
  <table>
    <caption>会員情報登録フォーム</caption>
    <tr>
      <td class="item">E-mail：</td>
      <td><?php print $email; ?><input type="hidden" name="input_email" value="<?php print $email; ?>"></td>
    </tr>
    <tr>
      <td class="item">パスワード：</td>
      <td><input type="text" size="30" name="input_password" value="<?php print $input_password; ?>">&nbsp;&nbsp;※ 6文字以上16文字以下</td>
    </tr>
    <tr>
      <td class="item">ニックネーム：</td>
      <td><input type="text" size="30" name="input_name" value="<?php print $input_name; ?>"></td>
    </tr>
  </table>
  <div><input type="submit" value=" 送 信 "></div>
</form>
<?php
}
?>