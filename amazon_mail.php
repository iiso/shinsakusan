<?php
    
   // require_once('Services/Amazon.php');
    require_once('config.php');
    require_once('functions.php');
    
    header('Content-type: text/html; charset=UTF-8');
    
    mb_language("japanese");
    mb_internal_encoding("UTF-8");

    
    session_start();
    
    
    
    connectDb();

    $date='INSERT INTO mail_log(date) VALUES (CURDATE())';
    $result = mysql_query($date) or die(mysql_error());
    $sql = 'SELECT count FROM mail_log Where date=CURDATE()';
    $result = mysql_query($sql) or die(mysql_error());
    $r = mysql_fetch_assoc($result);
    $count = $r['count'];
       
    var_dump($count);
/**
$sql = 'SELECT * FROM books';
$rs = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($rs)){

    $today = date('Y-m-d');
   
    if(strtotime($today) == strtotime($row['publish_date'])){
        
        $sql = sprintf('SELECT u.email, u.facebook_name,u.member_id,b.author_id,uk.user_id,uk.artist_id,b.name,b.author_name,b.url,b.image_url,b.publish_date,k.name AS a_name FROM books b,p_users u,users_keywords uk,keywords k WHERE b.id =%d AND b.author_id = uk.artist_id AND uk.user_id = u.member_id AND k.id=b.author_id ',
                       mysql_real_escape_string($row[id])
                       );
        $result = mysql_query($sql) or die(mysql_error());
        $new_book = mysql_fetch_assoc($result);
        var_dump($new_book['a_name']);
       
        $sql2 = sprintf('SELECT u.email FROM p_users u, users_keywords uk WHERE uk.artist_id =%d AND uk.user_id = u.member_id',
                    mysql_real_escape_string($row[author_id])
                    );
        
        $result2 = mysql_query($sql2) or die(mysql_error());
    
        while($email = mysql_fetch_assoc($result2) ){
                 
        $to = $email[email];
        $subject = "【新作さん】【 ". $new_book['a_name']."】本日発売！　新作のお知らせ";
             mb_language("ja"); 
            $body =<<<EOM
            <html>
             <body style>
             <div style="boder: 1px solid gray;border-radius:6px; padding:5px;">
            <h4><img src="http://shinsakusan.com/img/bull-horn.png" width="30px;">　新作さんより新作発売のお知らせです。</h4></br>
           <h3>【{$new_book['a_name']}】の新作が本日発売されました!</h3>
             
            <h2><a href="  {$new_book['url']}">   {$new_book['name']}</a> </h2>
     
    
                 <a href="{$new_book['url']}">   <img src="{$new_book['image_url']}"><a/><br /><br />
             <a href="{$new_book['url']}"> <img src="http://shinsakusan.com/img/amazon.gif"><a/><br/><br/>
        
   新しい作家・アーティストの登録はログイン後<a href="http://shinsakusan.com/">コチラ</a>のリンクからお願いします。
             </div>
            </body>
            </html>
EOM;
            var_dump($body);
            
          $from = mb_encode_mimeheader(mb_convert_encoding("新作さん","JIS","UTF-8"))."<info@shinsakusan.com>\n";
        $from .="Content-type: text/html\r\n";
        //   $headers = '新作さん info@shinsakusan.com' . "\r\n" . 'content-type: text/html;charset=JIS'. "\r\n" ;

        $success = mb_send_mail($to,$subject,$body,"From:".$from);
        
            echo("発売日です");
            var_dump($new_book['name']);
            var_dump($email[email]);
  
            $count++;
            $sql6='UPDATE mail_log SET count='.$count.' WHERE mail_log.date=CURDATE()';
            mysql_query($sql6) or die(mysql_error());
            $sql = 'SELECT count FROM mail_log Where date=CURDATE()';
            $result = mysql_query($sql) or die(mysql_error());
            $r = mysql_fetch_assoc($result);
            $count = $r['count'];
a
        }
    
    }else{echo("発売日じゃありません");
    }
} **/
    
    
    $sql2 = 'SELECT * FROM musics';
    $rs = mysql_query($sql2) or die(mysql_error());
    while($row = mysql_fetch_array($rs)){
        
        $today = date('Y-m-d');
        
        if(strtotime($today) == strtotime($row['release_date'])){
            
            $sql = sprintf('SELECT u.email, u.facebook_name,u.member_id,m.musician_id,um.user_id,um.musician_id,m.name,m.musician_name,m.url,m.image_url,m.release_date,mu.name,mu.id FROM musics m,p_users u,users_musicians um,musicians mu WHERE m.id =%d AND mu.id = m.musician_id  AND m.musician_id = um.musician_id AND um.user_id = u.member_id  AND m.musician_name = mu.name',
                           mysql_real_escape_string($row[id])
                           );
            $result = mysql_query($sql) or die(mysql_error());
            $new_music = mysql_fetch_array($result);
            if (!empty($new_music)){ //ignore in case m.musican_name dosen't match m.name
            var_dump($new_music);
            var_dump(strtotime($row['release_date']));
            $sql2 = sprintf('SELECT u.email FROM p_users u, users_musicians um WHERE um.musician_id =%d AND um.user_id = u.member_id',
                            mysql_real_escape_string($row[musician_id])
                            );
            
            $result2 = mysql_query($sql2) or die(mysql_error());
        
            while($email = mysql_fetch_assoc($result2) ){
                $to = $email[email];
               
                $subject = "【新作さん】【 ". $new_music['11']."】 本日発売！　新作のお知らせ";
 /**               $body =<<<EOM
                <html>
                <body style>
                <div style="boder: 1px solid gray;border-radius: 6px;">
                <h4><img src="http://shinsakusan.com/img/bull-horn.png" width="30px;">　新作さんより新作発売のお知らせです。</h4></br>
                <h3> 【{$new_music['11']}】の新作が本日発売されました！</h3>
                <h2><a href="  {$new_music['url']}">   {$new_music['6']}</a> </h2>
                               
                <a href="{$new_music['url']}">   <img src="{$new_music['image_url']}"><a/><br /><br />
                <a href="{$new_music['url']}"> <img src="http://shinsakusan.com/img/amazon.gif"><a/><br/><br/>

                
                新しい作家・アーティストの登録はログイン後<a href="http://shinsakusan.com/">コチラ</a>のリンクからお願いします。
                </div>
                </body>
                </html>
EOM;
**/
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
                              <span>{$new_music['11']}</span>の新作が<br>本日発売されました。</h1>
                           </td>
                        </tr>
                    </tbody>
                </table>

                 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f7f7f7; max-width:600px; margin:0 0 20px;">
                    <tbody>
                        <tr>
                           <td align="center" style="padding:45px 0 20px; ">
                            <img src="{$new_music['image_url']}" alt="SHINSAKUSAN" style="width:324px; height:324px;">
                           </td>
                        </tr>
                        <tr>
                           <td align="center" style="padding=0 0 15px; ;">
                            <h2 style="font-size: 26px;line-height: 30px; font-weight:bold; margin: 0; padding: 0 0 0px;"> {$new_music['6']}</h2>
                            <h3 style="font-size: 18px;line-height: 30px; margin: 0; padding: 0 0 0px;">{$new_music['11']}</h2>
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
                                <span><a href="{$new_music['url']}">新作の詳細を見る</span>
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
                              <a href="http://shinsakusan.sakura.ne.jp/search-result-nothing.php" bgcolor="#fff;" 
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

                $from = mb_encode_mimeheader(mb_convert_encoding("新作さん","JIS","UTF-8"))."<info@shinsakusan.com>\n";
                $from .="Content-type: text/html\r\n";
               // $success = mb_send_mail($to,$subject,$body,"From:".$from);
                
                echo("発売日です");
                var_dump($email[email]);
                $count++;
                $sql6='UPDATE mail_log SET count='.$count.' WHERE date=CURDATE()';
                mysql_query($sql6) or die(mysql_error());
                $sql = 'SELECT count FROM mail_log Where date=CURDATE()';
                $result = mysql_query($sql) or die(mysql_error());
                $r = mysql_fetch_assoc($result);
                $count = $r['count'];
            }
        }
            
        }else{echo("発売日じゃありません");
        }
    }


    ?>