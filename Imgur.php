<?php
/**
 * Built by: rpunnett
 * Url: https://github.com/rpunnett/extract_imgur
 * License: MIT
 * Requirements: cURL, Guzzle
 *
 *
 * Based on work by: hortinstein
 * Project: impurge
 * Use: JS Client to extract imgur links
 * Url: https://github.com/hortinstein/impurge
 */
use GuzzleHttp\Client;

class Imgur extends Image {

	

	public static function valid ($url){


		if(preg_match("^https?://((www)|(i)\.)?imgur.com/[./a-zA-Z0-9&,]+^", $url, $matches, null, 0))
		{
			return true;
		}
		else
		{
			return false;
		} 

	}

	public static function getType ($url){


		switch ($url) {
		   case (preg_match('^https?://(?:www\.)?imgur\.com/a/([a-zA-Z0-9]+)^', $url) ? true : false) :
		        return 'album';
		        break;
		   	case (preg_match('^https?://(?:www\.)?imgur\.com/gallery/([a-zA-Z0-9]+)^', $url) ? true : false) :
		        return 'gallery';
		        break;
		   	case (preg_match('^https?://(www\.)?(i\.)?imgur\.com/.{3,7}\.((jpg)|(gif)|(png))^', $url) ? true : false) :
		        return 'image';
		        break;
		    case (preg_match('^imgur\.com/(([a-zA-Z0-9]{5,7}[&,]?)+)^', $url) ? true : false) :
		        return 'hash';
		        break;
		     default:
		     	return false;
		     	break;
		}

	}

	public static function getId($url){

		preg_match('^(?<=\/)((?!imgur))[a-zA-Z0-9]{3,7}^', $url, $matches);
		return $matches[0];

	}

	public static function getJSON($url){

		if(Imgur::valid($url))
		{
			if(Imgur::getType($url) == 'image' || Imgur::getType($url) == 'hash')
			{
				$type = 'image';
			}
			else
			{
				$type = 'album';
			}

			try
			{
				$imgur_api_request = new Client([
				    'base_url' => ['http://api.imgur.com/2/{type}/{id}.json', ['type' => $type,'id' => Imgur::getId($url)]],
					    'defaults' => [
					        'headers' => ['User-Agent' => self::$header_user_agent]
					    ]
				]);
			}
			catch (Guzzle\Http\Exception\BadResponseException $e) 
			{
 				return $e->getMessage();
			}

			$response = $imgur_api_request->get();

			return $response->json(); 
		}	
		else
		{
			return false;
		}
	}



	private static function retrieveImage($json, $imgur_type_requested) {

		return $json['image']['links'][$imgur_type_requested];

	}

	private static function retrieveAlbum($json, $imgur_type_requested) {

		$images = count($json['album']['images']);
		$return =  array();

		for ($x=0; $x<$images; $x++) {
		 	array_push($return,$json['album']['images'][$x]['links'][$imgur_type_requested]);
		} 
		return $return;

	}

	public static function getImage($url,$imgur_type_requested){

	 $json = Imgur::getJSON($url);

		if(isset($json['image']))
		{
			return Imgur::retrieveImage($json, $imgur_type_requested);
		}
		else if(isset($json['album']))
		{
			return Imgur::retrieveAlbum($json, $imgur_type_requested);
		}

	}

}