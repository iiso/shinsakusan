<?php
// get previous requests for current visitor
$track_requests = get_user_requests($db);

// an artist is being searched for
if(isset($_GET['action']) && $_GET['action']=='find_artist') {
	// search for Artist
	$results = $lastfm_artist_class->search(array(
		'artist' => $_GET['term'],
		'limit' => 10
	));
//	FB::log($results);
	
	// format results
	$artists = array();
	if(isset($results['results']) && !empty($results['results'])) {
		foreach($results['results'] as $k=>$v) {
			$artists[] = array(
				'mbid' => $v['mbid'],
				'name' => $v['name']
			);
		}
	}
	
	echo json_encode($artists);
	exit;
}

// a Track is being searched for
if(isset($_GET['action']) && $_GET['action']=='find_track') {
	// search for Track
	if(isset($_GET['term'])) {
		$results = $lastfm_track_class->search(array(
			'track' => $_GET['term'],
			'limit' => 10
		));
//		FB::log($results);
	}
	
	// format results
	$tracks = array();
	if(isset($results['results']) && !empty($results['results'])) {
		foreach($results['results'] as $k=>$v) {
			$tracks[] = array(
				'key' => $k,
				'name' => $v['name'],
				'artist' => $v['artist'],
				'url' => $v['url'],
			);
		}
	}
	
	echo json_encode($tracks);
	exit;
}

// an Artist has been selected so get their top Tracks according to Lastfm
if($_POST && isset($_POST['ajax']) && isset($_POST['artist_mbid']) && isset($_POST['action']) && $_POST['action']=='find_top_tracks') {	
	// get Artist
	// http://www.last.fm/api/show/artist.getInfo
	$artist = $lastfm_artist_class->getInfo(array(
		'mbid' => $_POST['artist_mbid'],
	));
//	FB::log($artist);
	
	// search for Artist Top Tracks
	// http://www.last.fm/api/show/artist.getTopTracks
	$results = $lastfm_artist_class->getTopTracks(array(
		'artist' => $_POST['artist'],
		'limit' => 10
	));
//	FB::log($results);

	// format results
	$tracks_html = '';
	if(!empty($results)) {
		foreach($results as $k=>$v) {
			// build row class
			$class = ($k%2==0) ? 'even':'odd';
			
			// build track HTML table ready for Ajax insert
			$tracks_html .= '<tr class="'.$class.'"><td class="artist"><a href="'.$artist['url'].'" target="_blank">'.$artist['name'].'</a></td><td class="track"><a href="'.$v['url'].'" target="_blank">'.$v['name'].'</a></td><td class="request"><a href="#" class="request_link">Request</a></td></tr>';
		}
	} else {
		$tracks_html .= '<tr><td colspan="3">No Tracks to display</td></tr>';
	}
	
	echo json_encode(array('success'=>TRUE,'html'=>$tracks_html));
	exit;
}

// a Track has been requested so save it
if($_POST && isset($_POST['ajax']) && isset($_POST['action']) && $_POST['action']=='request_track') {
	// get Track info
	$track = $lastfm_track_class->getInfo(array(
		'artist' => $_POST['artist'],
		'track' => $_POST['track'],
	));
	
	// track already requested
	if(isset($track_requests[$track['id']])) {
		echo json_encode(array('success'=>FALSE,'msg'=>'You have already requested that track'));
		exit;
	}
	
	$success = TRUE;
	$msg = '';
	
	if(empty($track)) {
		$success = FALSE;
		$msg = 'An error occurred finding the track, please try again';
	} else {
		// see if Artist already exists
		$artist = $db->get_row("SELECT id FROM artists WHERE mbid='".$track['artist']['mbid']."'");
		
		// save Artist
		if(empty($artist)) {
			$db->insert('artists', array(
				'mbid' => $track['artist']['mbid'],
				'name' => $track['artist']['name'],
				'url' => $track['artist']['url'],
				'created' => date("Y-m-d H:i:s")
			));
			
			// get insert id
			$artist_insert_id = $db->get_insert_id();
			
			// save Artist Images
			// get Artist info
			$artist = $lastfm_artist_class->getInfo(array(
				'mbid' => $track['artist']['mbid'],
			));
			
			// loop and save Images
			if(isset($artist['image']) && !empty($artist['image'])) {
				foreach($artist['image'] as $k=>$v) {
					$db->insert('artist_images', array(
						'artist_id' => $artist_insert_id,
						'type' => $k,
						'url' => $v
					));
				}
			}
		} else {
			$artist_insert_id = $artist['id'];
		}
		
		// see if Track already exists
		$existing_track = $db->get_row("SELECT id FROM tracks WHERE mbid='".$track['id']."'");
		
		// save Track
		if(empty($existing_track)) {
			// search YouTube API for relevant track video
			$yt = new Zend_Gdata_YouTube();
			$query = $yt->newVideoQuery();
			$query->setQuery(urlencode($track['artist']['name'])."+".$track['name']);
			$query->setStartIndex(0);
			$query->setMaxResults(1);
			$query->setOrderBy('relevance');
			$feed = $yt->getVideoFeed($query);
			
			$youtube_video_id = null;
			if($feed) {
				foreach($feed as $k=>$v) {
					$youtube_video_id = $v->getVideoId();
					break;
				}
			}
			
			$db->insert('tracks', array(
				'artist_id' => $artist_insert_id,
				'mbid' => $track['id'],
				'name' => $track['name'],
				'url' => $track['url'],
				'youtube_video_id' => $youtube_video_id,
				'created' => date("Y-m-d H:i:s")
			));
			
			// get insert id
			$track_insert_id = $db->get_insert_id();
		} else {
			$track_insert_id = $existing_track['id'];
		}
		
		// save Request
		$db->insert('requests', array(
			'track_id' => $track_insert_id,
			'ip' => $_SERVER['REMOTE_ADDR'],
			'session_id' => session_id(),
			'created' => date("Y-m-d H:i:s")
		));
		
		$msg = '<strong>'.$track['name'].'</strong> by <strong>'.$track['artist']['name'].'</strong> was successfully requested';
	}
	
//	FB::log($_POST);
//	FB::log($track);
	
	echo json_encode(array('success'=>$success,'msg'=>$msg));
	exit;
}

// after a Track is requested reload requested tracks so that it appears
if($_POST && isset($_POST['ajax']) && isset($_POST['action']) && $_POST['action']=='reload_requested') {
	// get top requested tracks
	$top_requested_tracks = get_most_requested_tracks($db);
	
	echo json_encode(array('success'=>TRUE,'html'=>most_requested_tracks_table_rows_html($top_requested_tracks)));
	exit;
}