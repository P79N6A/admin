<?php
/**
 * 
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;

$b=pdo_fetch('SELECT * FROM '.tablename('agent_member'));
$a=tablename('agent_member');
template('member_system/index');
