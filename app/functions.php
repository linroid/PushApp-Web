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
function get_server_ip() {
	if (!empty($_SERVER['SERVER_ADDR']))
		return $_SERVER['SERVER_ADDR'];
	$result = shell_exec("/sbin/ifconfig");
	if (preg_match_all("/[(inet)(addr:)] (\d+\.\d+\.\d+\.\d+)/", $result, $match) !== 0) {
		foreach ($match[0] as $k => $v) {
			if ($match[1][$k] != "127.0.0.1")
				return $match[1][$k];
		}
	}
	return false;
}

/**
 * 显示友好的文件大小
 * @param $bytes
 * @param int $decimals
 * @return string
 */
function friendly_filesize($bytes, $decimals = 2) {
	$size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

/**
 * 友好的时间显示
 *
 * @param int $sTime 待显示的时间
 * @param string $type 类型. normal | mohu | full | ymd | other
 * @param string $alt 已失效
 * @return string
 */
function friendly_date($sTime, $type = 'normal', $alt = 'false') {
	if (!$sTime)
		return '';
	if (!ctype_digit($sTime))
		$sTime = strtotime($sTime);
	//sTime=源时间，cTime=当前时间，dTime=时间差
	$cTime = time();
	$dTime = $cTime - $sTime;
	$dDay = intval(date("z", $cTime)) - intval(date("z", $sTime));
	//$dDay     =   intval($dTime/3600/24);
	$dYear = intval(date("Y", $cTime)) - intval(date("Y", $sTime));
	//normal：n秒前，n分钟前，n小时前，日期
	if ($type == 'normal') {
		if ($dTime < 60) {
			if ($dTime < 10) {
				return '刚刚';    //by yangjs
			}
			else {
				return intval(floor($dTime / 10) * 10) . "秒前";
			}
		}
		elseif ($dTime < 3600) {
			return intval($dTime / 60) . "分钟前";
			//今天的数据.年份相同.日期相同.
		}
		elseif ($dYear == 0 && $dDay == 0) {
			//return intval($dTime/3600)."小时前";
			return '今天' . date('H:i', $sTime);
		}
		elseif ($dYear == 0) {
			return date("m月d日 H:i", $sTime);
		}
		else {
			return date("Y-m-d H:i", $sTime);
		}
	}
	elseif ($type == 'mohu') {
		if ($dTime < 60) {
			return $dTime . "秒前";
		}
		elseif ($dTime < 3600) {
			return intval($dTime / 60) . "分钟前";
		}
		elseif ($dTime >= 3600 && $dDay == 0) {
			return intval($dTime / 3600) . "小时前";
		}
		elseif ($dDay > 0 && $dDay <= 7) {
			return intval($dDay) . "天前";
		}
		elseif ($dDay > 7 && $dDay <= 30) {
			return intval($dDay / 7) . '周前';
		}
		elseif ($dDay > 30) {
			return intval($dDay / 30) . '个月前';
		}
		//full: Y-m-d , H:i:s
	}
	elseif ($type == 'full') {
		return date("Y-m-d , H:i:s", $sTime);
	}
	elseif ($type == 'ymd') {
		return date("Y-m-d", $sTime);
	}
	else {
		if ($dTime < 60) {
			return $dTime . "秒前";
		}
		elseif ($dTime < 3600) {
			return intval($dTime / 60) . "分钟前";
		}
		elseif ($dTime >= 3600 && $dDay == 0) {
			return intval($dTime / 3600) . "小时前";
		}
		elseif ($dYear == 0) {
			return date("Y-m-d H:i:s", $sTime);
		}
		else {
			return date("Y-m-d H:i:s", $sTime);
		}
	}
}
