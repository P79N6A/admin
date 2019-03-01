<?php
/**
 * [WECHAT 2017]
 * [WECHAT  a free software]
 */
require './framework/bootstrap.inc.php';
$host = $_SERVER['HTTP_HOST'];
if (!empty($host)) {
	$bindhost = pdo_fetch("SELECT * FROM ".tablename('site_multi')." WHERE bindhost = :bindhost", array(':bindhost' => $host));
	if (!empty($bindhost)) {
		header("Location: ". $_W['siteroot'] . 'app/index.php?i='.$bindhost['uniacid'].'&t='.$bindhost['id']);
		exit;
	}
}
header('Location: ./app/index.php?i=6&c=entry&m=purchasing&do=login');