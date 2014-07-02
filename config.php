<?php

define('DB_HOST', 'mysql481.db.sakura.ne.jp');
define('DB_USER', 'shinsakusan');
define('DB_PASSWORD', 'shinsakusan2');
define('DB_NAME', 'shinsakusan_test');

define('APP_ID', '649114738465271');
define('APP_SECRET', 'a144b258c253511807db3dff090a53e7');

define('ACCESS_KEY_ID', 'AKIAJRUABQVC4GZ64R7A');
define('ASSOC_ID', 'shinsakusan2-22');
define('SECRET_ID', 'yNenTU+Hb2dJPGmlxE+95Dy4a/3Qui2yU58dPddg');

define('SITE_URL', 'http://shinsakusan.sakura.ne.jp/');

error_reporting(E_ALL & ~E_NOTICE);
ini_set( 'display_errors', 1 );

session_set_cookie_params(0, '/');

define('ENABLE_ARTIST_IMAGES', TRUE);
define('ENABLE_YOUTUBE', TRUE);

?>