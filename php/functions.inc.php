<?php
/**
 * Print out an array for debugging
 * @param array $arr
 */
function pr($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

/**
 * Connect to DB
 * @return mixed
 */
function db_connect() {
	// connect to DB
	$db = new DB(array(
		'hostname' => HOSTNAME,
		'username' => DB_USERNAME,
		'password' => DB_PASSWORD,
		'db_name' => DB_NAME
	));

	// stop on db fail
	if(isset($db->errors) && !empty($db->errors)) {
		return FALSE;
	}
	
return $db;
}

/**
 * Create Lastfm class
 * @return class
 */
function lastfm_connect() {
	// setup LastFm API params
	$params = array(
		'apiKey' => LASTFM_API_KEY,
		'secret' => LASTFM_SECRET_KEY
	);

	// setup LastFM
	$auth = new lastfmApiAuth('setsession', $params);

	// various options
	$config = array(
		'enabled' => true,
		'path' => 'php/lastfmapi/',
		'cache_length' => 1800
	);
	
return new lastfmApi();
}

/**
 * Get the most requested tracks
 * @param object $db
 * @return array
 */
function get_most_requested_tracks($db) {
	if($db===FALSE) {
		return array();
	}
	
	$sql = 
	"SELECT tracks.*, 
		artists.name AS a_name, 
		artists.url AS a_url, 
		(SELECT COUNT(*) FROM requests WHERE requests.track_id=tracks.id) AS requests
	FROM tracks
	LEFT JOIN artists ON artists.id=tracks.artist_id
	ORDER BY (SELECT COUNT(*) FROM requests WHERE requests.track_id=tracks.id) DESC, artists.name";
	
return $db->get_rows($sql);
}

/**
 * Gets list of previous request of current user
 * @param object $db
 * @return array
 */
function get_user_requests($db) {
	if($db === FALSE) {
		return array();
	}
	
	// get previous requests
	$sql = "SELECT * FROM requests WHERE session_id='".session_id()."'";
	$rows = $db->get_rows($sql);

	// key by Track ID for easy checking
	$track_requests = array();
	foreach($rows as $k=>$v) {
		$track_requests[$v['track_id']] = $v;
	}
	
return $track_requests;
}

/**
 * Gets list of Artist images
 * @params object $db
 * @param string $type
 * @return array
 */
function get_artist_images($db, $type='large') {
	if($db === FALSE) {
		return array();
	}
	
	// get previous requests
	$sql = "SELECT artist_images .*, artists.url AS artist_url
			FROM artist_images 
			LEFT JOIN artists ON artists.id=artist_images.artist_id
			WHERE artist_images .type='{$type}'";
	$rows = $db->get_rows($sql);
	
return $rows;
}

/**
 * Gets list of YouTube Video IDs
 * @params object $db
 * @return array
 */
function get_youtube_video_ids($db) {
	if($db === FALSE) {
		return array();
	}
	
	// get tracks with youtube video ids
	$sql = "SELECT tracks.id, tracks.youtube_video_id
			FROM tracks
			WHERE tracks.youtube_video_id IS NOT NULL
			ORDER BY (SELECT COUNT(*) FROM requests WHERE requests.track_id=tracks.id) DESC";
	$rows = $db->get_rows($sql);
	
	$ids = array();
	foreach($rows as $k=>$v) {
		$ids[] = $v['youtube_video_id'];
	}
	
return $ids;
}

/**
 * Format the most requested tracks ready for HTML table
 * @param array $tracks
 * @return string
 */
function most_requested_tracks_table_rows_html($tracks) {
	$html = "";
	
	if(!empty($tracks)) {
		foreach($tracks as $k=>$v) {
			$html .= "<tr class='".(($k%2==0)?'even':'odd')."'>";
			$html .= "<td><a href='".$v['a_url']."' target='_blank'>".$v['a_name']."</a></td>";
			$html .= "<td><a href='".$v['url']."' target='_blank'>".$v['name']."</a></td>";
			$html .= "<td class='request'>".$v['requests']."</td>";
			$html .= "</tr>";
		}
	} else {
		$html .= '<tr><td colspan="3">No Tracks to display</td></tr>';
	}
	
return $html;
}

/**
 * PHP4 version of json_encode
 * taken from: http://au.php.net/manual/en/function.json-encode.php#82904
 */
if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}

function printVideoFeed($videoFeed)
{
  $count = 1;
  foreach ($videoFeed as $videoEntry) {
    echo "Entry # " . $count . "\n";
    printVideoEntry($videoEntry);
    echo "\n";
    $count++;
  }
}

function printVideoEntry($videoEntry) 
{
  // the videoEntry object contains many helper functions
  // that access the underlying mediaGroup object
  echo 'Video: ' . $videoEntry->getVideoTitle() . "\n";
  echo 'Video ID: ' . $videoEntry->getVideoId() . "\n";
  echo 'Updated: ' . $videoEntry->getUpdated() . "\n";
  echo 'Description: ' . $videoEntry->getVideoDescription() . "\n";
  echo 'Category: ' . $videoEntry->getVideoCategory() . "\n";
  echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "\n";
  echo 'Watch page: ' . $videoEntry->getVideoWatchPageUrl() . "\n";
  echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "\n";
  echo 'Duration: ' . $videoEntry->getVideoDuration() . "\n";
  echo 'View count: ' . $videoEntry->getVideoViewCount() . "\n";
  echo 'Rating: ' . $videoEntry->getVideoRatingInfo() . "\n";
  echo 'Geo Location: ' . $videoEntry->getVideoGeoLocation() . "\n";
  echo 'Recorded on: ' . $videoEntry->getVideoRecorded() . "\n";
  
  // see the paragraph above this function for more information on the 
  // 'mediaGroup' object. in the following code, we use the mediaGroup
  // object directly to retrieve its 'Mobile RSTP link' child
  foreach ($videoEntry->mediaGroup->content as $content) {
    if ($content->type === "video/3gpp") {
      echo 'Mobile RTSP link: ' . $content->url . "\n";
    }
  }
  
  echo "Thumbnails:\n";
  $videoThumbnails = $videoEntry->getVideoThumbnails();

  foreach($videoThumbnails as $videoThumbnail) {
    echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
    echo ' height=' . $videoThumbnail['height'];
    echo ' width=' . $videoThumbnail['width'] . "\n";
  }
}