<?php
    require_once('config.php');
    require_once('functions.php');
    
    header('Content-type: text/html; charset=UTF-8');
    
    session_start();
       
    connectDb();
// リクエスト URL の組み立て
$baseurl = "https://itunes.apple.com/search?";
$country = jp;
$term = str_replace(' ', "_", "スガ　シカオ");
$media = 'music';
$sort = 'recent';
$entity = 'album';
$lang = 'ja_jp';
$limit = '10';
$url = $baseurl."term=".$term."&country=".$country."&media=".$media."&sort=".$sort."&entity=".$entity."&lang=".$lang."&limit=".$limit;

// REST リクエストの発行 & レスポンスの取得
$json = file_get_contents( $url ); 

//連想配列に格納する
$data = json_decode( $json , true );var_dump($data);
$today = date("Y/m/d");
//var_dump($data);
$today = strtotime($today);
$max = sizeof($data['results']);
//var_dump($max);
for($i = 0;$i< $max;$i++){
    
 
$date = substr($data['results'][$i]["releaseDate"],0,10);
//var_dump($date);


if(strtotime($date) > $today){
    
 //   var_dump($today);
 //   var_dump($date);

$str = $data['results'][$i]["collectionName"];
$str = str_replace(" - Single", "", $str);
$str = str_replace(" - EP", "", $str);
$str = str_replace(" (Japan Edition)", "", $str);
$str = str_replace(" (Deluxe Edition)", "", $str);
//var_dump($str);
$sql = sprintf('SELECT musics.id FROM musics WHERE name LIKE "%s" AND musician_name = "%s"',
               $str."%",
               $data['results'][$i]["artistName"]
              );

             

$result = mysql_query($sql);
$result = mysql_fetch_assoc($result);

//var_dump($result["id"]);

  //アフィURL生成、date,url ,imageをupdate
 if(isset($result["id"])){
  
    
    //アフィURL生成
   $url = $data['results'][$i]['collectionViewUrl'];
   // var_dump($url);
    $search = "?uo=4";
    $url = str_replace($search, "?at=1l3vbIC",$url);
    var_dump($url);
    
    $sql = sprintf('UPDATE musics set i_link = "%s" i_date = %d i_image = "%s" WHERE music.id = %d',
    $url,
    $date,
    $data['results'][$i]["artworkUrl100"],
    $result["id"]  
                   );
    
    
    
} else{echo( "nothing");}

}
}

?>