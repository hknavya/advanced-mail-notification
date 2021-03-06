<?php
defined('C5_EXECUTE') or die("Access Denied.");

class OJUtil{

	public static function getIncludeDirs($for = ''){
		$cur = dirname(__FILE__) . '/form/';
		$base = preg_replace('/packages\/.*?\//', '', $cur);
		if($base === $cur){
			return array($cur . $for);
		}
		return array($cur . $for, $base . $for);
	}

	public static function getFileName($str){
		return strtolower(preg_replace('/^_/','',preg_replace('/([A-Z])/', '_$1', $str))) . '.php';
	}

	public static function getCleanName($str){
		return ucwords(str_replace('_',' ',str_replace('.php', '', $str)));
	}

	public static function getCleanVarName($str){
		return preg_replace('/\W+/','',self::getCleanName($str));
	}

	public static function checkNotBlank($str){
		return isset($str) && $str != null && trim($str) != '' && $str != '0';
	}


	//got this from Abhi localhost file
	public static function extend(&$default,&$override){
		$retval = array();
		foreach ($default as $key => $value) {
			if(!isset($override[$key])){
				$retval[$key] = $value;
				continue;
			}
			$overriddenVal = $override[$key];
			if(is_array($value)){
				$retval[$key] = self::extend($value,$overriddenVal);
			}
			else{
				$retval[$key] = $overriddenVal;
			}
		}
	}

	public static function isAssoc($arr){
		return is_array($arr) && (array_keys($arr) !== range(0, count($arr) - 1));
	}

	public static function thisOrThat($first,$second,$key=null){
		if(!(is_array($first) || is_array($second)) || $key == null){
			return $first?$first:$second;
		}
		return $first[$key]?$first[$key]:$second[$key];
	}

	public static function queryLink($args,$custom){
		if(!is_array($args)) $args = array();
		if(!is_array($custom)) $custom = array();
		$args = array_merge($args,$custom);
		$qStrings = array();
		foreach ($args as $key => $value) {
			$qStrings[] = $key .'=' .$value;
		}
		return '?' . implode('&', $qStrings);
	}

	public static function confArrToHash($arr){
		$ret = array();
		foreach ($arr as $key => $val) {
			if(!is_array($val)){
				$key = $val;
				$val = array();
			}
			$ret[$key] = $val;
		}
		return $ret;
	}
	public static function arrryToHash($arr){
		if(!is_array($arr)) return array();
		$ret = array();
		foreach ($arr as $item) {
			$ret[$item] = $item;
		}
		return $ret;
	}

	public static function getErrorsList($errs){
		$retarr = array();
		foreach ($errs as $err) {
			$retarr[] = $err['message'];
		}
		return $retarr;
	}

	public static function array_unshift_assoc(&$arr, $key, $val){
		$arr = array_reverse($arr, true);
		$arr[$key] = $val;
		$arr = array_reverse($arr, true);
	} 
}
