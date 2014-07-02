<?php
class Lastfm {
	
	var $api='';
	var $secret='';
	var $root_url = 'http://ws.audioscrobbler.com/2.0/';
	
	function __construct($params=array()) {
		$this->init($params);
	}
	
	function init($params) {
		foreach($params as $k=>$v) {
			if(isset($this->{$k})) {
				$this->{$k} = $v;
			}
		}
	}
	
	function search_artist($artist) {
		if(empty($artist)) {
			return array();
		}
		
		$params = array(
			'method' => 'artist.search',
			'artist' => $artist
		);
		
		$response = $this->query($params);
		
		if($response === FALSE) {
			return FALSE;
		}
		
		
	}
	
	function search_track($track='') {
		if(empty($track)) {
			return array();
		}
		
		$params = array(
			'method' => 'track.search',
			'track' => $track
		);
		
		$response = $this->query($params);
		
		if($response === FALSE) {
			return FALSE;
		}
		
		$tracks = array();
		foreach($response->results->trackmatches->track as $track) {
			$tracks[] = array(
				'name' => (string) $track->name,
				'artist' => (string) $track->artist,
				'url' => (string) $track->url,
				'streamable' => (string) $track->streamable,
				'listeners' => (string) $track->listeners,
				'image' => array(
					'small' => (string) $track->image[0],
					'medium' => (string) $track->image[1],
					'large' => (string) $track->image[2],
					'square' => ((isset($track->image[3])) ? (string) $track->image[3] : ''),
				)
			);
		}
		
	return $tracks;
	}
	
	function query($params) {
		if(!isset($params['method'])) {
			return FALSE;
		}
		
		$params['api_key'] = $this->api;
		
		$url = $this->root_url.'?';
		foreach($params as $k=>$v) {
			$url .= $k.'='.urlencode($v).'&';
		}
		
		// remove last &
		$url = substr($url,0,(strlen($url)-1));
		
		$curl  = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, "PHP last.fm API (PHP/" . phpversion() . ")");
		//curl_setopt($curl, CURLOPT_HEADERFUNCTION, array(&$this, 'header'));
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 0);
		//$response = curl_exec($curl);
		//pr($response);
	return $this->deal_with_response($response);
	}
	
	function deal_with_response($response='') {
		//$response = file_get_contents('search.track.xml');
		$response = file_get_contents('search.artist.xml');
		libxml_use_internal_errors(true);
		$xml = new SimpleXMLElement($response);
		
		$attributes = array();
		foreach($xml->attributes() as $k=>$v) {
			$attributes[$k] = (string)$v;
		}
		
		if(!isset($attributes['status']) || (isset($attributes['status']) && $attributes['status']!='ok') ) {
			return FALSE;
		}
		
	return $xml;
	}
}