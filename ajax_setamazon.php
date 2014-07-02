<?php
	
	
    require_once('Services/Amazon.php');
    require_once('config.php');
    
    header('Content-type: text/html; charset=UTF-8');
    
    session_start();
	
	if ($_POST['best'] != "") {
        //if ($test) {
		$amazon=&new Services_Amazon('AKIAJRUABQVC4GZ64R7A',
									 'yNenTU+Hb2dJPGmlxE+95Dy4a/3Qui2yU58dPddg','shinsakusan2-22');
		$amazon->setLocale('JP');//Amazon.co.jpを使う
		
		$sort = 'daterank';
		$itempage = '1';
		$response = 'Large';
		
		$options = array();
		$options['Keywords'] = $_POST['best'];
		//$options['Keywords'] = $test;
		
		$options['ResponseGroup'] = $response;
		$options['ItemPage'] = $itempage;
		
		$response = $amazon->ItemSearch('Books', $options);
		$item=$response["Item"];
        $array2 = array_unique($item);
		$item = json_encode( $array2);
		echo($item);//商品配列を返す
	}
	
    ?>