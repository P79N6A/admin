<?php


$sql = "
CREATE TABLE  if not exists  `ims_agent_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_no` int(11) DEFAULT '0' COMMENT '靓号',
  `uniacid` int(11) DEFAULT '0' COMMENT '公司ID',
  `openid` varchar(100) CHARACTER SET utf8 DEFAULT '' COMMENT 'openid',
  `union_id` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `nickname` varchar(150) DEFAULT '' COMMENT '会员昵称',
  `mobile` varchar(20) CHARACTER SET utf8 DEFAULT '' COMMENT '手机号码',
  `realname` varchar(150) CHARACTER SET utf8 DEFAULT '' COMMENT '真实姓名',
  `password` varchar(32) CHARACTER SET utf8 DEFAULT '' COMMENT '密码',
  `avatar` varchar(250) CHARACTER SET utf8 DEFAULT '' COMMENT '头像',
  `token` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT 'app登陆验证',
  `parent_agent` int(11) DEFAULT '0' COMMENT '上级代理',
  `account` varchar(255) DEFAULT '' COMMENT '登录账号',
  `credit1` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '会员余额',
  `credit2` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '可提现余额',
  `credit3` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '总收益',
  `sex` tinyint(1) DEFAULT '0' COMMENT '性别 0.保密 1.男 2.女',
  `zfb` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `is_black` tinyint(1) DEFAULT '0' COMMENT '是否黑名单 0否 1是',
  `is_parner` tinyint(1) DEFAULT '0' COMMENT '是否工会成员 0否 1待审核 2是',
  `rebate` tinyint(2) unsigned NOT NULL DEFAULT '70' COMMENT '分成比例',
  `location_p` varchar(150) CHARACTER SET utf8 DEFAULT '' COMMENT '省',
  `YY` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '微信号',
  `calling_card` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT '名片',
  `location_c` varchar(150) CHARACTER SET utf8 DEFAULT '' COMMENT '市',
  `intro` text CHARACTER SET utf8 NOT NULL COMMENT '简介',
  `location_a` varchar(150) CHARACTER SET utf8 DEFAULT '' COMMENT '区',
  `address` varchar(250) CHARACTER SET utf8 DEFAULT '' COMMENT '详细地址',
  `birth_year` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '出生年',
  `birth_month` varchar(50) CHARACTER SET utf8 DEFAULT '0' COMMENT '月',
  `birth_day` varchar(50) CHARACTER SET utf8 DEFAULT '0' COMMENT '日',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  `is_recommend` tinyint(1) DEFAULT '0' COMMENT '是否推荐 0.不推荐 1.推荐',
  `main_goods` int(10) DEFAULT '0' COMMENT '主接服务',
  `sign` varchar(255) DEFAULT '' COMMENT '个性签名',
  `qq` varchar(20) CHARACTER SET utf8 DEFAULT '',
  `talk_token` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `jg_id` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `notice_ver` int(10) DEFAULT '0',
  `is_realname` tinyint(1) DEFAULT '0' COMMENT '是否实名认证 0.否 1.是',
  `id_card` varchar(18) CHARACTER SET utf8 DEFAULT '',
  `vc_token` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `from_where` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `exp` decimal(15,2) DEFAULT '0.00' COMMENT '经验值',
  `vip_time` int(11) DEFAULT '0' COMMENT '最后消费时间',
  `charm_value` decimal(11,2) DEFAULT '0.00' COMMENT '魅力值',
  `last_login` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `contribution_value` decimal(11,2) DEFAULT '0.00' COMMENT '贡献值',
  `love_id` int(10) NOT NULL DEFAULT '0' COMMENT '情侣ID',
  `gold_coin` decimal(11,2) DEFAULT '0.00' COMMENT '金币值',
  `inviter_id` int(11) NOT NULL DEFAULT '0' COMMENT '邀请人ID',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '邀请获得金额',
  `other_avatar` varchar(255) NOT NULL COMMENT '个人封面集合',
  `city` varchar(255) NOT NULL COMMENT '所在的城市',
  `groupid` int(10) DEFAULT '0',
  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登陆时间',
  `fail_login_times` int(11) DEFAULT '0' COMMENT '连续失几次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

CREATE TABLE  if not exists   `ims_agent_odds` (
  `agent_id` int(11) NOT NULL,
  `odds1` int(10) DEFAULT '0' COMMENT '4e',
  `odds2` int(10) DEFAULT '0' COMMENT '4s',
  `odds3` int(10) DEFAULT '0' COMMENT '4a',
  `odds4` int(10) DEFAULT '0' COMMENT '3abc',
  `odds5` int(10) DEFAULT '0' COMMENT '3a',
  `odds6` int(10) DEFAULT '0' COMMENT 'box',
  `odds7` int(10) DEFAULT '0' COMMENT 'ibox',
  `odds8` int(10) DEFAULT '0' COMMENT 'a1',
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='代理赔率  odds1~odds8,对应4e,4s,4a,3abc,3a,box,ibox,a1赔率';

CREATE TABLE   if not exists  `ims_agent_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(255) DEFAULT '0',
  `to_user` int(11) DEFAULT '0',
  `score` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `user_type` tinyint(4) DEFAULT '1' COMMENT 'to_user类型 :1:下线  2：会员 ',
  `score_type` tinyint(255) DEFAULT '1' COMMENT '1:充值  2：减值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COMMENT='代理充值记录';


CREATE TABLE  if not exists   `ims_agent_recharge_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `admin` int(10) NOT NULL DEFAULT '0' COMMENT '管理员',
  `purchasing` int(10) NOT NULL DEFAULT '0' COMMENT '下线',
  `money` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '充值金额',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '充值时间',
  `remark` text NOT NULL COMMENT '理由',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;


";

pdo_run($sql);



if(!pdo_fieldexists('agent_member',  'module_name')) {
	pdo_query("ALTER TABLE ".tablename('agent_member')." ADD COLUMN `last_login_time`  int(11) DEFAULT '0'   COMMENT '最后登陆时间';");
}

if(!pdo_fieldexists('agent_member',  'module_name')) {
	pdo_query("ALTER TABLE ".tablename('agent_member')." ADD COLUMN `fail_login_times`  int(11) DEFAULT '0'   COMMENT '连续失败次数';");
}