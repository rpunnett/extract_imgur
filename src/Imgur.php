<?php  namespace Imgur;
/**
 * Built by: rpunnett
 * Url: https://github.com/rpunnett/extract_imgur
 * License: MIT
 * Requirements: cURL
 *
 *
 * Based on work by: hortinstein
 * Project: impurge
 * Use: JS Client to extract imgur links
 * Url: https://github.com/hortinstein/impurge
 */




class Imgur {

	protected static $header_user_agent = 'extract_imgur';

	public static function valid ($url){


		if(!preg_match("^https?://((www)|(i)\.)?imgur.com/[./a-zA-Z0-9&,]+^", $url, $matches, null, 0))
		{
			return false;
		}

		return true;
	}

	public static function getType ($url){


		switch ($url) {
		   case (preg_match('^https?://(?:www\.)?imgur\.com/a/([a-zA-Z0-9]+)^', $url) ? true : false) :
		        return 'album';
		        break;
		   	case (preg_match('^https?://(?:www\.)?imgur\.com/gallery/([a-zA-Z0-9]+)^', $url) ? true : false) :
		        return 'album'; //Gallery
		        break;
		   	case (preg_match('^https?://(www\.)?(i\.)?imgur\.com/.{3,7}\.((jpg)|(gif)|(png))^', $url) ? true : false) :
		        return 'image';
		        break;
		    case (preg_match('^imgur\.com/(([a-zA-Z0-9]{5,7}[&,]?)+)^', $url) ? true : false) :
		        return 'image'; //Hash
		        break;
		     default:
		     	return false;
		     	break;
		}

	}

	public static function getId($url){

		if(self::valid($url) == false)
		{
			return false;
		}

		preg_match('/(?<=\\/)((?!imgur))((?!gallery))[a-zA-Z0-9]{3,7}/i', $url, $matches);
		
		return $matches[0];

	}


	public static function getJSON($url){

		return self::connectToCurl(self::getType($url),self::getId($url));
			
	}


	private static function connectToCurl($type, $id){

        $cURL_IMGUR = curl_init();
        curl_setopt($cURL_IMGUR, CURLOPT_URL, "http://api.imgur.com/2/".$type."/".$id.".json");
        curl_setopt($cURL_IMGUR, CURLOPT_RETURNTRANSFER, 1);
        $cURL_Result = curl_exec($cURL_IMGUR);

        if ($cURL_Result === FALSE) 
		{
			throw new Exception("Unable to retrieve output from Imgur API V2");
		}

        curl_close($cURL_IMGUR);      

        return self::decodeJSONString($cURL_Result);
	} 


	private static function decodeJSONString($string){

		return json_decode($string);
	}

	private static function encodeJSONString($string){

		return json_encode($string);
	}


	private static function retrieveImage($json, $type_requested) {

		$imageArray = array();
		array_push($imageArray,$json->image->links->$type_requested);
		return $imageArray;

	}

	private static function retrieveAlbum($json, $type_requested) {

		$images = count($json->album->images);

		$albumArray = array();

		for ($x=0; $x<$images; $x++) {
		 	array_push($albumArray,$json->album->images[$x]->links->$type_requested);
		} 

		return $albumArray;

	}

	public static function getImage($url,$type_requested = 'original'){

		if(self::valid($url) == false)
		{
			return false;
		}

		$json = self::getJSON($url);

		if(isset($json->image))
		{
			return self::retrieveImage($json, $type_requested);
		}

		return self::retrieveAlbum($json, $type_requested);
		
	}

}
