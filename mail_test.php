<?php
    
   // require_once('Services/Amazon.php');
    require_once('config.php');
    require_once('functions.php');
    
    header('Content-type: text/html; charset=UTF-8');
    
    mb_language("japanese");
    mb_internal_encoding("UTF-8");

    
    session_start();
    
    
    
   
                $to = "sotaroii1@gmail.com";
                $subject = "【新作さんてすと】【 Avicii】 本日発売！　新作のお知らせ";
                $body =<<<EOM
                
                <html lang="ja">

                <body style="padding: 0; margin: 0; color: #555555; font-size:16px; max-width:640px; width:100%; margin:0 auto; background-color:#fff; ">
               
                 <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                    <tbody style="max-width:600px">
                        <tr height="16">
                           <td width="100%" bgcolor="#3a428b"></td>
                        </tr>
                    </tbody>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px">
                    <tbody>
                        <tr>
                           <td align="center" style="padding:45px 0px;">
                            <img src="http://shinsakusan.sakura.ne.jp/img/mail-logo.png" alt="SHINSAKUSAN" width="50%">
                           </td>
                        </tr>
                        <tr>
                           <td align="center" style="padding:0px 0 35px;" >
                            <h1 style="font-size: 28px; font-weight: bold; color: #3a428b; line-height: 1.4;">
                              <span>サカナクション</span>の新作が<br>本日発売されました。</h1>
                           </td>
                        </tr>
                    </tbody>
                </table>

                 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f7f7f7; max-width:600px; margin:0 0 20px;">
                    <tbody>
                        <tr>
                           <td align="center" style="padding:45px 0 20px; ">
                            <img src="./img/others/true.jpg" alt="SHINSAKUSAN" style="width:324px; height:324px;">
                           </td>
                        </tr>
                        <tr>
                           <td align="center" style="padding=0 0 15px; ;">
                            <h2 style="font-size: 26px;line-height: 30px; font-weight:bold; margin: 0; padding: 0 0 0px;">ユリイカ</h2>
                            <h3 style="font-size: 18px;line-height: 30px; margin: 0; padding: 0 0 0px;">サカナクション</h2>
                           </td>
                        </tr>
                        <tr>
                           <td align="center" style="">
                            <p style="font-size: 20px; color:#f34b4e; line-height: 30px; margin: 0; padding: 0 0 8px;">2014年01月14日発売</p>
                           </td>
                        </tr>
                        <tr>
                           <td align="center" style="padding:0px 0 12px; ">
                              <a bgcolor="#3a4486;" style="display: block; color: #fff; text-decoration: none; font-size: 16px; font-weight: bold; width: 74%; line-height: 54px; border-radius: 4px; margin-bottom: 4px;
                              background-color:#3a4486;">
                                <span>新作の詳細を見る</span>
                            </a>
                           </td>
                        </tr>
                        <tr>
                           <td align="center" style="padding:0px 0 30px;">
                              <span bgcolor="#3b5998;" style="display: block; float:left; margin: 0 3% 0 0; padding: 10px 0 8px 10%;">シェアする：</span>
                              <a style="display: block; float:left; border:1px solid #3b5998; width: 26%; color: #3b5998; height: 34px; line-height:34px; border-radius: 8px; margin: 0 3% 0 0;">
                                FB</a>
                              <a bgcolor="#5ea9dd" style="display: block; float:left; border:1px solid #5ea9dd; width: 26%; color: #5ea9dd; height: 34px; line-height:34px; border-radius: 8px;">
                                tw
                              </a>
                           </td>
                        </tr>
                    </tbody>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#4c72a7; max-width:600px; margin:0 0 20px;">
                    <tr>
                            <td align="center" style="padding:0px 0 30px; ">
                              <p style="font-size:18px; margin:0; color:#fff; padding: 20px 0 0px;">お気に入りのアーティストを登録して</p>
                              <p style="font-size:18px; margin:0; color:#fff; padding:0 0 15px; ">新作情報を逃さずキャッチしよう</p>
                              <a bgcolor="#fff;" 
                              style="color:#555454; display: block; background-color: #fff; width: 280px; line-height: 44px; border-radius: 4px;
                              background-potision:center 40%;" >アーティストを登録する</a>
                           </td>
                        </tr>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" width="100%;"  style="max-width:600px" >
                    <tr>
                            <td align="center" style="padding:10px 0 30px;">
                              <p style="margin:0; padding:0 0 10px; font-size:20px;">新作さんを友達に教える</p>
                              <a href="" style="color: #fff; display: block; background-color: #3b5998; width: 56%; line-height: 44px; border-radius: 4px; 
                              background-potision:center 40%; margin:0 0 10px">Facebookで教える</a>
                              <p style="color: #fff; display: block; background-color: #5ea9dd; width: 56%; line-height: 44px; border-radius: 4px;
                              background-potision:center 40%; margin:0 0 10px">twitterで教える</p>
                           </td>
                        </tr>
                        <tr>
                           <td align="center" style="padding:35px 0 40px;">
                            <div style="height:1px; width:75px; margin:0 auto; background-color:#ccc;"></div>
                           </td>
                        </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width:600px;">
                    <tbody>
                        <tr>
                           <td align="center" style="padding:30px 0 10px; ">
                            <p style="font-size:14px;">Copyright 2014 新作さん All rights reserved.</p>
                           </td>
                        </tr>
                      </tbody>
                    </table>
                </body>
</html>

EOM;
                var_dump($body);

                $from = mb_encode_mimeheader(mb_convert_encoding("新作さんてすと","JIS","UTF-8"))."<info@shinsakusan.sakura.ne.jp>\n";
                $from .="Content-type: text/html\r\n";
                $success = mb_send_mail($to,$subject,$body,"From:".$from);
                
               
           

    ?>