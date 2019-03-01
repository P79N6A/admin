<?php
global $_W,$_GPC;

$op = $_GPC['op']?$_GPC['op']:'display';
if ($op == 'display') {
    $manager = pdo_fetch('select * from '.tablename('agent_member').' where level=1');
}

if ($op == 'add') {
    $save = array(
        'account' => 'MANAGER',
        'nickname' => 'MANAGER',
        'password' => md5(md5(123456)),
        'createtime' => time(),
        'level' => 1
    );
    $res = pdo_insert('agent_member',$save);
    if ($res) {
        $result = array(
            'status' => 1,
            'info' => '添加成功'
        );
    }
    else{
        $result = array(
            'status' => 2,
            'info' => '添加失败'
        );
    }
    echo json_encode($result);
        exit;
}

include $this->template('agent');
?>