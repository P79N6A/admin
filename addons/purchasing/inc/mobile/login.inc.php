<?php 
global $_W,$_GPC;

$weid = $_W['uniacid'];
if (isset($_GPC['submit'])) {
    session_start();
    $account = $_GPC['account']?$_GPC['account']:'';
    $password = $_GPC['password']?$_GPC['password']:'';
    $jg_id = $_GPC['jg_id']?$_GPC['jg_id']:'';
    $memInfo = pdo_fetch("select cid,id,password,mobile,nickname,credit1,is_black,last_login_time,fail_login_times,`level`    from ".tablename('agent_member')." where account=:account ",array(':account'=>$account));

    if (empty($memInfo)) {
        message('用户不存在',referer(),'error');
    }

    if ($memInfo['is_black']==1) {
        message('账号已冻结',referer(),'error');
    }

    // $password = decrypt_password($password);
    if ($memInfo['password'] != md5(md5($password))) {
       message('密码错误，请重新输入',referer(),'error');
    }

    $_SESSION['mid'] = $memInfo['id'];
    $_SESSION['level'] = $memInfo['level'];
    $_SESSION['cid'] = $memInfo['cid'];
    $ip = getip();
    pdo_update('agent_member',array('last_login_time'=>time(),'last_login_ip'=>$ip),array('id'=>$memInfo['id']));
    message('登录成功',$this->createMobileUrl('manager',array('op'=>'main')),'success');
}

include $this->template('login');

 ?>