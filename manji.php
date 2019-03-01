<?php
use Workerman\Worker;
use Workerman\Lib\Timer;
require_once __DIR__ . '/workerman/Autoloader.php';
require_once  __DIR__.'/framework/bootstrap.inc.php';
define('HEARTBEAT_TIME',10);
$basic_url = "http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=manji&do=";//
$ws_worker = new Worker("tcp://0.0.0.0:8087");
// 启动1个进程对外提供服务,多个进程会导致发送消息时出现问题
$ws_worker->count = 1;
$last_check_read_buffer = 0;
//日志文件
//$ws_worker::$stdoutFile = '/www/web/master/public_html/stdout.log';
$ws_worker->deviceConnections = array();

//当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onConnect = function($connection){
    global $global_uid;
    
    $connection->uid = ++$global_uid;//保存当前的用户链接标志
    $connection->all_data = ""; //用户当前的数据缓存
    $connection->lastMessageTime = 0;//上一次发送数据的时间
    //Canche_Data();房间信息的缓存
};

$ws_worker->onMessage = function($connection, $data)//有问题
{
    global $ws_worker,$global_uid,$global_status;
    echo $data;
    $connection->lastMessageTime = time();//设置单个链接上一次发消息的时间
    if(empty($connection->all_data)){
        $connection->all_data = $data;
    }else{
        $connection->all_data .= $data;//第一次传输的数据
    }
    while ( strlen($connection->all_data)> 20 ) {
        $all_data = $connection->all_data;
        //如果数据出错，丢包
        if( substr($all_data,0, 4) != 'HEAD' ){
            $connection->all_data = '';
            break;
        }
        $data_size = substr($all_data,5, 4);
        if( $data_size <= 0 || $data_size > 1000 ){
            $connection->all_data = '';
            break;
        }
        //数据不完整
        if($data_size > strlen($all_data)){
            break;
        }
        //数据处理
        //
        process_data($connection, substr($all_data, 0, $data_size ) );//第二次传输的数据
        //下一个包数据
        $connection->all_data =  substr( $all_data,$data_size );
    }
};

function process_data($connection,$data){
    global $global_uid,$ws_worker;
    $cmd_info = get_command($data);//解析指令类型
    $data_info = get_data($data);//具体解析的数据
    switch ($cmd_info) {
        case 'OPENRESULT': $result = send_service($data_info,'openresult','OPENRESULT');break;
        case 'HEART': $result = get_heart($connection,$data);break;
        case 'SPECIALRESULT': $result = send_service($data_info,'specialresult','OPENRESULT');break;
        case 'COMFORTRESULT': $result = send_service($data_info,'comfortresult','OPENRESULT');break;
        case 'BIGRESULT': $result = send_service($data_info,'bigresult','OPENRESULT');break;
        case 'RETURN': $result = send_service($data_info,'return','OPENRESULT');break;
        default:
        break;
    }
}

function get_heart($connection,$data){ //解析命令
    $connection->send($data);
}

function get_command($data){
    //数据的解密在这里完成
    $source = $data; 
    $source_data = explode('/',$source); 
    return $source_data[2];
}

function get_data($data){ //解析具体的数据
    $source = $data; 
    $source_data = explode('/',$source); 
    return $source_data[3];
}

function send_service($data_info,$op,$cmd){
    global $basic_url;
    $url = $basic_url.'pc_lottery';
    $postData = array(
        'code'=>$data_info,
        'op' => $op,
    );
    echo '发送给接口的数据';
    print_r($postData);
    echo '发送给接口的数据';
    $result = callback($url,$postData);
    $info = json_decode($result,true);
    echo '---接口返回的数据---';
    print_r($info);
    echo '---接口返回的数据---';
    $ret = joint($info['status'],$cmd);
    send_data($ret);
    if(!empty($info['data'])){
        $ret1 = joint($info['data'],$cmd);
        send_data($ret1);
    }

}

function send_data($data){//单个用户发送数据
    global $ws_worker;
    foreach($ws_worker->connections as $conn)
    {
        $conn->send($data);
    }
}

function joint($data,$cmd){
    //包头/长度(整个包长)/机号/用户名/密码/命令/数据/包尾（数据之间以","逗号分隔）
    $first = 'HEAD';//指令头部开始
    $end = 'END';//指令尾部结束
    $first_length = strlen($first);
    $end_length = strlen($end);
    $data_length = strlen($data);
    $cmd_length = strlen($cmd);
    //$device_length = strlen($device_number);
    $total_length = ($data_length+$cmd_length+$first_length+$end_length)+8;
    $total_length = sprintf("%04d",$total_length);
    $length = $first.'/'.$total_length.'/'.$cmd.'/'.$data.'/'.$end;
    return $length;
}

function callback($url,$data){ //转发接口
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
    $result = curl_exec ($ch);
    curl_close ($ch);
    return $result;
}
// 运行worker
Worker::runAll();