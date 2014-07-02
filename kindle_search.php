<?php
    
    require_once('Services/Amazon.php');
    require_once('config.php');
    require_once('functions.php');
    
    header('Content-type: text/html; charset=UTF-8');
    
    session_start();
    
    connectDb();
    
    $amazon=&new Services_Amazon('AKIAIOT6VTM4YUMTILDA',
                                 'kM3CoDxpnfGASHC6Ne5F3pa9Y6aPorY2fad6UkUj','seraphic-22');
    $amazon->setLocale('JP');//Amazon.co.jpを使う
    $sql3 = 'SELECT * FROM keywords';
    $rs = mysql_query($sql3) or die(mysql_error());
    while($row = mysql_fetch_array($rs)){
        //   var_dump($row[name]);
        
        $response = 'Small';
        $options = array();
        $options['Sort'] = 'daterank';
        $options['Keywords'] = $row[name];
        $options['ResponseGroup'] = $response;
        // $options['ItemPage'] = $itempage;
        
        $response = $amazon->ItemSearch('KindleStore', $options);
        //  var_dump($response);
        if (!PEAR::isError($response))
        {
            foreach ($response["Item"] as $item){
                $today = date("Y/m/d",strtotime("-3 month"));
                if( strtotime($item[ItemAttributes][PublicationDate]) > strtotime($today) ){
                    $sql = sprintf('INSERT IGNORE INTO kindles SET name="%s", author_id=%d,publish_date="%s",url="%s",image_url="%s",author_name="%s",ean="%s"',
                                   mysql_real_escape_string($item[ItemAttributes][Title]),
                                   mysql_real_escape_string($row[id]),
                                   $item[ItemAttributes][PublicationDate],
                                   $item[DetailPageURL],
                                   $item[MediumImage][URL],
                                   $item[ItemAttributes][Author][0],
                                   $item[ItemAttributes][EAN]
                                   
                                   );
                    //    var_dump($item[ItemAttributes][Author]);
                    mysql_query($sql) or die(mysql_error());
                    // if($item[ItemAttributes][Author] = ($row[name])){
                    //  var_dump($item[ItemAttributes][Title]);
                    // var_dump($item[ItemAttributes][Author]);
                    //       var_dump($item[ItemAttributes][PublicationDate]);
                    // var_dump($item[DetailPageURL]);
                    
                }
            }
        }else{
            var_dump($row[name]);}}
    
    
    ?>


