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
            var_dump(strtotime($row['release_date']));
            $sql2 = sprintf('SELECT u.email FROM p_users u, users_musicians um WHERE um.musician_id =%d AND um.user_id = u.member_id',
                            mysql_real_escape_string($row[musician_id])
                            );
            
            $result2 = mysql_query($sql2) or die(mysql_error());
        
            while($email = mysql_fetch_assoc($result2) ){var_dump($new_music);
                $to = $email[email];
                $subject = "【新作さん】【 ". $new_music['11']."】 本日発売！　新作のお知らせ";
                $body =<<<EOM
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
                var_dump($body);

               
            }
        }else{echo("発売日じゃありません");
        }
    }


    ?>