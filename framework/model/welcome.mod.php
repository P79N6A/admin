<?php
/**
 * [WECHAT 2017]
 * [WECHAT  a free software]
 */
defined('IN_IA') or exit('Access Denied');

function welcome_notices_get() {
	$notices = pdo_getall('article_notice', array('is_display' => 1), array('id', 'title', 'createtime'), '', 'createtime DESC', array(1,15));
	if(!empty($notices)) {
		foreach ($notices as $key => $notice_val) {
			$notices[$key]['url'] = url('article/notice-show/detail', array('id' => $notice_val['id']));
			$notices[$key]['createtime'] = date('Y-m-d', $notice_val['createtime']);
		}
	}
	return $notices;
}

function welcome_database_backup_days($time) {
	global $_W;
	$cachekey = cache_system_key("back_days:");
	$cache = cache_load($cachekey);
	if (!empty($cache)) {
		return $cache;
	}
	$backup_days = 0;
	if (is_array($time)) {
		$max_backup_time = $time[0];
		foreach ($time as $key => $backup_time) {
			if ($backup_time <= $max_backup_time) {
				continue;
			}
			$max_backup_time = $backup_time;
		}
		$backup_days = ceil((time() - $max_backup_time) / (3600 * 24));
	}
	if (is_numeric($time)) {
		$backup_days = ceil((time() - $time) / (3600 * 24));
	}
	cache_write($cachekey, $backup_days, 24 * 3600);
	return $backup_days;
}
