<?php


$sql = "
CREATE TABLE IF NOT EXISTS `ims_manji_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ordersn` varchar(50) NOT NULL,
  `user_id` int(20) unsigned NOT NULL DEFAULT 0,
  `number` int(11) unsigned NOT NULL DEFAULT 0,
  `4E` int(11) unsigned NOT NULL DEFAULT 0,
  `4S` int(11) unsigned NOT NULL DEFAULT 0,
  `4A` int(11) unsigned NOT NULL DEFAULT 0,
  `3ABC` int(11) unsigned NOT NULL DEFAULT 0,
  `3A` int(11) unsigned NOT NULL DEFAULT 0,
  `Box` int(11) unsigned NOT NULL DEFAULT 0,
  `IBox` int(11) unsigned NOT NULL DEFAULT 0,
  `A1` int(11) unsigned NOT NULL DEFAULT 0,
  `order_amount` int(11) unsigned NOT NULL DEFAULT 0,
  `createtime` int(11) unsigned NOT NULL DEFAULT 0,
  `periods` int(11) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(2) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE if not exists  `ims_manji_lottery_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periods` int(11) DEFAULT '0',
  `first` int(11) DEFAULT '',
  `secound` int(11) default '',
  `third` int(11) DEFAULT '',
  `consolation` varchar(100) DEFAULT '',
  `special` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists  `ims_manji_winner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periods` int(11) DEFAULT 0,
  `fisrt` int(11) DEFAULT 0,
  `secound` int(11) DEFAULT 0,
  `third` int(11) DEFAULT 0,
  `consolation` varchar(255) DEFAULT '',
  `special` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `ims_manji_run_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periods` int(10) DEFAULT 0,
  `starttime` int(11) DEFAULT 0,
  `endtime` int(11) DEFAULT 0,
  `stoptime` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE  if not exists  `ims_manji_reward_log` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL DEFAULT '0',
  `period_num` varchar(60) NOT NULL COMMENT '编号',
  `member_id` int(11) NOT NULL,
  `member_nikename` varchar(60) NOT NULL,
  `member_old_money` int(11) NOT NULL COMMENT '原金额',
  `member_new_money` int(11) NOT NULL DEFAULT '0' COMMENT '中奖后金额',
  `winner_number` int(11) NOT NULL COMMENT '中奖号码',
  `winner_number_type` varchar(255) NOT NULL,
  `winner_money` decimal(11,1) NOT NULL COMMENT '中奖金额',
  `winner_odds` int(11) NOT NULL COMMENT '赔率',
  `winner_type` varchar(60) NOT NULL DEFAULT '' COMMENT '中奖类型',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '代理人ID',
  `agent_name` varchar(60) NOT NULL DEFAULT '' COMMENT '代理人名',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

";

pdo_run($sql);