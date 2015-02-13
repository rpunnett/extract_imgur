<?php namespace punnettr\ImageHost;


interface ImageHostInterface {

	public static function valid($url);

	public static function getImage($url,$type_requested);
}