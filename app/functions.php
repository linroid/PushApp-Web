<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/28/15
 * Time: 17:55
 */


/**
 * 获取服务器端IP地址
 * @return string
 */
function get_server_ip(){
	if(!empty($_SERVER['SERVER_ADDR']))
		return $_SERVER['SERVER_ADDR'];
	$result = shell_exec("/sbin/ifconfig");
	if(preg_match_all("/[(inet)(addr:)] (\d+\.\d+\.\d+\.\d+)/", $result, $match) !== 0){
		foreach($match[0] as $k=>$v){
			if($match[1][$k] != "127.0.0.1")
				return $match[1][$k];
		}
	}
	return false;
}