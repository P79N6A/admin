<?php 
global $_W,$_GPC;
// $ip = getip();
// $area = get_area($ip);
// if ($area['data']['country'] == '中国') {
//     exit;
// }
if ($_W['ispost']) {
    session_start();
    $account = $_GPC['account']?$_GPC['account']:'';
    $password = $_GPC['password']?$_GPC['password']:'';
    $memInfo = pdo_fetch("select id,password,account,nickname ,credit1 ,is_black,parent_agent,last_login_time,fail_login_times from ".tablename('member_system_member')." where account=:account ",array(':account'=>$account));

    if (empty($memInfo)) {
        $data = array(
            'status' => 404,
            'info'   => '用户不存在',
            );
        echo json_encode($data);
        // message('用户不存在',referer(),'error');
        exit();
    }

    //连续失败5次以上，限制登陆5分钟 
    if( $memInfo['fail_login_times'] >=5 && time() - $memInfo['last_login_time'] < 5*60 ){
         $data = array(
            'status' => 404,
            'info'   => '连续失败次数过多，请5分钟后重试',
        );
        echo json_encode($data);
        exit();
    }

    file_put_contents(IA_ROOT.'/addons/manji/password.txt', $password);

    if ($memInfo['password'] != md5(md5($password))) {
        $fail_login_times = $memInfo['fail_login_times'] + 1;
        $res = pdo_update('member_system_member',array( 'fail_login_times'=>$fail_login_times ), array('id'=>$memInfo['id']));
       $data = array(
            'status' => 402,
            'info'   => '密码错误，请重新输入',
            );
        echo json_encode($data);
        exit();
    }
    $_SESSION['uid'] = $memInfo['id'];
    setcookie('uid',$memInfo['id']);
    $data = array(
        'status' => 200,
        'info' => '登陆成功'
    );
    echo json_encode($data);
    exit;
}

include $this->template('login');

 ?>