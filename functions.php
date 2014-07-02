<?php

function connectDb() {
    mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('can not connect to DB: '.mysql_error());
    mysql_select_db(DB_NAME) or die('can not select DB: '.mysql_error());
    mysql_query('SET NAMES UTF8');
   
}

function h($s) {
    return htmlspecialchars($s);
}

function r($s) {
    return mysql_real_escape_string($s);
}

function jump($s) {
    header('Location: '.SITE_URL.$s);
    exit;
}

function checkDB($_table,$_where){
    $sql = 'SELECT * FROM '.$_table.' where '.$_where;
    $res = mysql_query($sql) or die(mysql_error());
    return mysql_fetch_array($res);
}

function setReview($_id,$_view){
	$sql = sprintf('CREATE TEMPORARY TABLE f_table SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
				   mysql_real_escape_string($_id)
				   );
	mysql_query($sql) or die(mysql_error());
	
	if($_view=='all'){
	$sql = sprintf('INSERT INTO f_table SET follow_id="%s",follower_id="%s"',
				   mysql_real_escape_string($_id),
				   mysql_real_escape_string($_id)
				   );
		mysql_query($sql) or die(mysql_error());
	}
	$sql2 = 'SELECT reviews.*, users.icon, tags.*, tr.* users.facebook_name ';
	$sql2 .= 'FROM (reviews INNER JOIN f_table ON f_table.follow_id = reviews.member_id, tags, tag_review_relates tr)';
	$sql2 .= 'INNER JOIN users ON users.member_id = reviews.member_id AND tags.tag_id=tr.tag_id AND tr.review_id';
	
	$posts = mysql_query($sql2) or die(mysql_error());
	return $posts;
}
    
function getFriendsFromFB(){//follow,folloerのidを取得し、配列生成
		$sql = 'SELECT '.$select.' FROM users WHERE '.$where.'='.$_SESSION['user']['member_id'];
		$res = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_array($res)){
			$arr[]=$row[$select];
			//$arr[]=getInfo($row[$select]);
		}
		return $arr;
}
    /*
    function getFollowsIdArr($select,$where){//follow,folloerのidを取得し、配列生成
		$sql = 'SELECT '.$select.' FROM relationships WHERE '.$where.'='.$_SESSION['user']['member_id'];
		$res = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_array($res)){
			$arr[]=$row[$select];
			//$arr[]=getInfo($row[$select]);
        }
		return $arr;
	}
    
    
	function getInfo($_id){
		$sql = "SELECT icon,facebook_name,member_id,facebook_user_id FROM users WHERE member_id='".$_id."'";
		$res = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($res);
		return $row;
	}
    

/*	
function getFollowsIdArr($select,$where){//follow,folloerのidを取得し、配列生成
		$sql = 'SELECT '.$select.' FROM relationships WHERE '.$where.'='.$_SESSION['user']['member_id'];
		$res = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_array($res)){
			$arr[]=$row[$select];
			//$arr[]=getInfo($row[$select]);
		}
		return $arr;
}
	
function getInfo($_id){
		$sql = "SELECT icon,facebook_name,member_id FROM users WHERE member_id='".$_id."'";
		$res = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($res);
		return $row;
}
*/	

function searchFriends($_id){
	$sql = sprintf('CREATE TEMPORARY TABLE f_table SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
				   mysql_real_escape_string($_id)
				   );
	mysql_query($sql) or die(mysql_error());
	$sql2 = 'SELECT users.icon,users.facebook_name,users.member_id,users.facebook_user_id,f_table.follower_id ';//users.icon,users.facebook_name,users.facebook_user_id,f_table.follower_id; ';
	$sql2 .= 'FROM (users LEFT JOIN f_table ON f_table.follow_id = users.member_id)';
	$res = mysql_query($sql2) or die(mysql_error());
	return $res;
}

function setBest($_id,$_view){
	$sql = sprintf('CREATE TEMPORARY TABLE f_table SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
					mysql_real_escape_string($_id)
					);
	mysql_query($sql) or die(mysql_error());
	
	if($_view=='all'){
		$sql = sprintf('INSERT INTO f_table SET follow_id="%s",follower_id="%s"',
						mysql_real_escape_string($_id),
						mysql_real_escape_string($_id)
						);
		mysql_query($sql) or die(mysql_error());
	}
	$sql2 = 'SELECT DISTINCT mybest_titles.*,users.icon,users.facebook_user_id, users.facebook_name,mybests.url, mybests.picture,tags.tag_name,fav.member_id AS fav,COUNT(DISTINCT fav2.u_title_id,fav2.member_id) AS cnt,COUNT(DISTINCT comments.comment) AS com FROM mybest_titles INNER JOIN f_table ON f_table.follow_id = mybest_titles.member_id LEFT JOIN favorites fav ON fav.member_id='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND  fav.u_title_id=mybest_titles.u_title_id INNER JOIN users ON users.member_id = mybest_titles.member_id INNER JOIN mybests ON mybest_titles.title_id=mybests.title_id LEFT JOIN tag_review_relates trr ON trr.review_id = mybest_titles.u_title_id LEFT JOIN tags ON tags.tag_id = trr.tag_id LEFT JOIN favorites fav2 ON fav2.u_title_id = mybest_titles.u_title_id LEFT JOIN comments ON comments.title_id = mybest_titles.title_id  GROUP by u_title_id   UNION SELECT DISTINCT mybest_titles.*, users.icon,users.facebook_user_id, users.facebook_name,mybests.url, mybests.picture,tags.tag_name,fav.member_id AS fav,COUNT(DISTINCT fav2.u_title_id,fav2.member_id) AS cnt, COUNT(DISTINCT comments.comment) AS com  FROM mybest_titles LEFT JOIN favorites fav ON fav.member_id='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND  fav.u_title_id=mybest_titles.u_title_id INNER JOIN users ON users.member_id = mybest_titles.member_id INNER JOIN mybests ON mybest_titles.title_id=mybests.title_id INNER JOIN tag_member_relates tmr ON tmr.member_id='.mysql_real_escape_string($_SESSION['user']['member_id']).' INNER JOIN tags ON tags.tag_id = tmr.tag_id  INNER JOIN tag_review_relates trr ON trr.review_id = mybest_titles.u_title_id AND tags.tag_id = trr.tag_id LEFT JOIN favorites fav2 ON fav2.u_title_id = mybest_titles.u_title_id LEFT JOIN comments ON comments.title_id = mybest_titles.title_id  GROUP by u_title_id ORDER BY created DESC';
    
	
	$posts = mysql_query($sql2) or die(mysql_error());
	return $posts;
}
    
    /*リクエスト取得
    function setRequest($_id,$_view){
        $sql = sprintf('CREATE TEMPORARY TABLE f_table2 SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
                       mysql_real_escape_string($_id)
                       );
        mysql_query($sql) or die(mysql_error());
        
        if($_view=='all'){
            $sql = sprintf('INSERT INTO f_table2 SET follow_id="%s",follower_id="%s"',
                           mysql_real_escape_string($_id),
                           mysql_real_escape_string($_id)
                           );
            mysql_query($sql) or die(mysql_error());
        }
        $sql2 = 'SELECT requests.*, users.icon, users.facebook_name ';
        $sql2 .= 'FROM (requests INNER JOIN f_table2 ON f_table2.follow_id = requests.member_id)';
        $sql2 .= 'INNER JOIN users ON users.member_id = requests.member_id ORDER BY created DESC';
        
        $requests = mysql_query($sql2) or die(mysql_error());
        
        return $requests;
    }*/
    
    //リクエスト取得
    function setRequest($_id,$_view){
        $sql = sprintf('CREATE TEMPORARY TABLE f_table2 SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
                       mysql_real_escape_string($_id)
                       );
        mysql_query($sql) or die(mysql_error());
        
        if($_view=='all'){
            $sql = sprintf('INSERT INTO f_table2 SET follow_id="%s",follower_id="%s"',
                           mysql_real_escape_string($_id),
                           mysql_real_escape_string($_id)
                           );
            mysql_query($sql) or die(mysql_error());
        }
        $sql2 = 'SELECT DISTINCT a1.facebook_user_id AS icon, a1.facebook_name,a2.facebook_user_id AS r_icon,a2.facebook_name AS r_name,requests.*,ri.member_id AS rid,COUNT(ri2.request_id) AS cnt FROM requests LEFT JOIN users a1 ON a1.member_id = requests.member_id  LEFT JOIN users a2 ON a2.member_id = requests.requested_id INNER JOIN f_table2 ON f_table2.follow_id = requests.member_id LEFT JOIN request_interest ri ON ri.member_id='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND  ri.request_id=requests.request_id LEFT JOIN request_interest ri2 ON ri2.request_id = requests.request_id WHERE a1.member_id = requests.member_id OR a2.member_id = requests.requested_id  GROUP BY requests.request_id UNION SELECT a1.facebook_user_id AS icon,a1.facebook_name,a2.facebook_user_id AS r_icon,a2.facebook_name AS r_name, requests.*,ri.member_id AS rid,COUNT(ri2.request_id) AS cnt FROM requests LEFT JOIN  users a1 ON a1.member_id = requests.member_id  LEFT JOIN users a2 ON a2.member_id = requests.requested_id LEFT JOIN request_interest ri ON ri.member_id='.mysql_real_escape_string($_SESSION['user']['member_id']).' AND  ri.request_id=requests.request_id LEFT JOIN request_interest ri2 ON ri2.request_id = requests.request_id WHERE requests.requested_id='.mysql_real_escape_string($_SESSION['user']['member_id']).' GROUP BY requests.request_id   ORDER BY created DESC';
        
        $requests = mysql_query($sql2) or die(mysql_error());
        
        return $requests;
    }

    
    
    /*リクエストされた側の情報取得
    function setRequested($_id,$_view){
        $sql = sprintf('CREATE TEMPORARY TABLE f_table3 SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
                       mysql_real_escape_string($_id)
                       );
        mysql_query($sql) or die(mysql_error());
        
        if($_view=='all'){
            $sql = sprintf('INSERT INTO f_table3 SET follow_id="%s",follower_id="%s"',
                           mysql_real_escape_string($_id),
                           mysql_real_escape_string($_id)
                           );
            mysql_query($sql) or die(mysql_error());
        }
        $sql3 = 'SELECT requests.requested_id,requests.created, users.icon, users.facebook_name ';
        $sql3 .= 'FROM (requests INNER JOIN f_table3 ON f_table3.follow_id = requests.member_id)';
        $sql3 .= 'INNER JOIN users ON users.member_id = requests.requested_id ORDER BY created DESC';
        
        $requested = mysql_query($sql3) or die(mysql_error());
        
        
        return $requested;
    }
    
    
//リクエストの数を取得
    function setCount($_id,$_view){
        $sql = sprintf('CREATE TEMPORARY TABLE f_table4 SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
                       mysql_real_escape_string($_id)
                       );
        mysql_query($sql) or die(mysql_error());
        
        if($_view=='all'){
            $sql = sprintf('INSERT INTO f_table4 SET follow_id="%s",follower_id="%s"',
                           mysql_real_escape_string($_id),
                           mysql_real_escape_string($_id)
                           );
            mysql_query($sql) or die(mysql_error());
        }
        $sql4 = 'SELECT member_id, COUNT(request_id)';
        $sql4 .= 'FROM (requests INNER JOIN f_table4 ON f_table4.follow_id = requests.member_id)';
        
        $count = mysql_query($sql4) or die(mysql_error());
    
        return $count;
    }

    function setCount2($_id,$_view){
        $sql = sprintf('CREATE TEMPORARY TABLE f_table5 SELECT follow_id,follower_id FROM relationships WHERE follower_id="%s"',
                       mysql_real_escape_string($_id)
                       );
        mysql_query($sql) or die(mysql_error());
        
        if($_view=='all'){
            $sql = sprintf('INSERT INTO f_table5 SET follow_id="%s",follower_id="%s"',
                           mysql_real_escape_string($_id),
                           mysql_real_escape_string($_id)
                           );
            mysql_query($sql) or die(mysql_error());
        }
        $sql5 = 'SELECT member_id, COUNT(requested_id)';
        $sql5 .= 'FROM (requests INNER JOIN f_table5 ON f_table5.follow_id = requests.member_id) WHERE requested_id > 0 ';
        
        $count_requested = mysql_query($sql5) or die(mysql_error());
        
        return $count_requested;
    }

    */

    
	
function updateBest($_best,$_img,$_com,$_url,$_time){
	
	$sql = sprintf('INSERT INTO mybests SET item_name="%s", picture="%s", comment="%s",url="%s", title_id=%d',
				   mysql_real_escape_string($_best),
				   mysql_real_escape_string($_img),
				   mysql_real_escape_string($_com),
				   mysql_real_escape_string($_url),
				   mysql_real_escape_string($_time)
				   );
	mysql_query($sql) or die(mysql_error());
}
    
function modifyBest($_best,$_img,$_com,$_url,$_id){
        
        $sql = sprintf('INSERT INTO mybests SET item_name="%s", picture="%s", comment="%s",url="%s", title_id=%d',
                       mysql_real_escape_string($_best),
                       mysql_real_escape_string($_img),
                       mysql_real_escape_string($_com),
                       mysql_real_escape_string($_url),
                       mysql_real_escape_string($_id)
                       );
        mysql_query($sql) or die(mysql_error());
    }


function createFile($_id,$_title){
	$sql = sprintf('SELECT title_id FROM mybest_titles WHERE member_id="%s" AND title="%s"',
				   mysql_real_escape_string($_id),
				   mysql_real_escape_string($_title)
				   );
	$res = mysql_query($sql) or die(mysql_error());
	while($t_id = mysql_fetch_assoc($res)){
	$file_name = $t_id['title_id'].'.php';
	// ファイルの存在確認
	if( !file_exists($file_name) ){
		// ファイル作成
		touch( $file_name );
	}else{
		// すでにファイルが存在する為エラーとする
		echo('Warning - ファイルが存在しています。 file name:['.$file_name.']');
		exit();
	}
	 
	
	// ファイルのパーティションの変更
	chmod( $file_name, 0666 );
	echo('Info - ファイル作成完了。 file name:['.$file_name.']');
	}
	 
}

/*
function setReviewByKey($_key){
	$sql2 = 'SELECT reviews.*, users.icon, users.facebook_name ';
	$sql2 .= 'FROM reviews INNER JOIN users ON users.member_id = reviews.member_id';
	$sql2 .= 'WHERE ';
}
*/	

?>