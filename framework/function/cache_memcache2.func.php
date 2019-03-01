<?php 
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
//load()->func('logging');
function memcache_memcache() {
	global $_W;
	static $memcacheobj;
	if (!extension_loaded('memcache')) {
		return error(1, 'Class Memcache is not found');
	}
	if (empty($memcacheobj)) {
		$memcacheobj = new Memcache;
		$connect = $memcacheobj->pconnect('127.0.0.1', 11211);
		if(!$connect) {
			return error(-1, 'Memcache is not in work');
		}
	}
	return $memcacheobj;
}


function memcache_read($key) {
	$memcache = memcache_memcache();
	if (is_error($memcache)) {
		logging_run("memcached connect failed->".$memcache, 'error', 'Memcache');
		return $memcache;
	}
	return $memcache->get(memcache_prefix($key));
}


function memcache_search($key) {
	return memcache_read(memcache_prefix($key));
}


function memcache_write($key, $value, $ttl = 0) {
	$memcache = memcache_memcache();
	if (is_error($memcache)) {
		logging_run("memcached connect failed->".$memcache, 'error', 'Memcache');
		return $memcache;
	}
	if ($memcache->set(memcache_prefix($key), $value, MEMCACHE_COMPRESSED, $ttl)) {
		return true;
	} else {
		return false;
	}
}


function memcache_remove($key) {
	$memcache = memcache_memcache();
	if (is_error($memcache)) {
		logging_run("memcached connect failed->".$memcache, 'error', 'Memcache');
		return $memcache;
	}
	if ($memcache->delete(memcache_prefix($key))) {
		return true;
	} else {
		return false;
	}
}



function memcache_clean($prefix = '') {
	$memcache = memcache_memcache();
	if (is_error($memcache)) {
		logging_run("memcached connect failed->".$memcache, 'error', 'Memcache');
		return $memcache;
	}
	if ($memcache->flush()) {
		return true;
	} else {
		return false;
	}
}

function memcache_prefix($key) {
	return $key;
}
