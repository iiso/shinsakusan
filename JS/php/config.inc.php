<?php
// required includes
require "functions.inc.php";
require "lastfmapi/lastfmapi.php";
require "FirePHPCore/fb.php";
require "class.db.php";
require "Zend/Loader.php";

// define database settings
define('HOSTNAME','localhost');
define('DB_USERNAME','');
define('DB_PASSWORD','');
define('DB_NAME','song_requests');

// define options
define('ENABLE_ARTIST_IMAGES', TRUE);
define('ENABLE_YOUTUBE', TRUE);

// connect to DB
$db = db_connect();

// define Lastfm settings
define('LASTFM_API_KEY','');
define('LASTFM_SECRET_KEY','');

// setup LastFm API params
$lastfm_params = array(
	'apiKey' => LASTFM_API_KEY,
	'secret' => LASTFM_SECRET_KEY
);

// setup LastFM
$lastfm_auth = new lastfmApiAuth('setsession', $lastfm_params);

// various options
$lastfm_config = array(
	'enabled' => true,
	'path' => 'php/lastfmapi/',
	'cache_length' => 1800
);

// load LastFM API class
$lastfm_api_class = new lastfmApi();
// get the Arist Class
$lastfm_artist_class = $lastfm_api_class->getPackage($lastfm_auth, 'artist', $lastfm_config);
// get the Track Class
$lastfm_track_class = $lastfm_api_class->getPackage($lastfm_auth, 'track', $lastfm_config);

// load YouTube API
// include the Zend library in include path
set_include_path(ini_get("include_path").':'.str_replace("config.inc.php","",__FILE__));
Zend_Loader::loadClass('Zend_Gdata_YouTube');

// start PHP session
session_start();

// deal with ajax requests
require "requests.inc.php";

// get top requested tracks
$top_requested_tracks = get_most_requested_tracks($db);

// get Artist Images
$artist_images = get_artist_images($db);

// get YouTube Video Ids
$youtube_video_ids = get_youtube_video_ids($db);