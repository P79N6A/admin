<?php 
global $_W,$_GPC;

$periods = $_GPC['periods'];
$date = $_GPC['date'];
pdo_begin();
foreach ($periods as $key => $value) {
    $period_id = $value['id'];
    $period = pdo_fetch('select aid,cid,endtime from '.tablename('manji_run_setting').' where id=:period_id',array(':period_id'=>$period_id));
    if($period['endtime'] > time() ){
        pdo_rollback();
        message('不在开奖时间，不能开奖',referer(),'error');
    }

    $first_no = $value['first']?$value['first']:'';
    $second_no = $value['secound']?$value['secound']:'';
    $third_no = $value['third']?$value['third']:'';
    $consolation_no = $value['consolation']?$value['consolation']:'';
    $special_no = $value['special']?$value['special']:'';
    $D5 = $value['D5']?$value['D5']:array();
    $D6_no = substr($first_no,-2).substr($second_no,-2).substr($third_no,-2);
    $D6 = $D6_no?$D6_no:'';

    //前三等奖要4位
    if( strlen( $first_no) != 4 ){
        pdo_rollback();
        message('请填写正确的一等奖号码',referer(),'error');
    }
    if(  strlen( $second_no) != 4){
        pdo_rollback();
        message('请填写正确的二等奖号码',referer(),'error');
    }
    if( strlen( $third_no) != 4 ){
        pdo_rollback();
        message('请填写正确的三等奖号码',referer(),'error');
    }
    //特等奖10名
    foreach( $special_no  as $special_no_arr_sub ){
        if( strlen( $special_no_arr_sub) != 4  ){
            pdo_rollback();
            message('请填写正确的特等奖号码',referer(),'error');
        }
    }
    //安慰奖10名
    foreach( $consolation_no as $consolation_no_arr_sub ){
        if( strlen( $consolation_no_arr_sub ) != 4  ){
            pdo_rollback();
            message('请填写正确的安慰奖号码',referer(),'error');
        }
    }

    if(empty($first_no)||!preg_match('/[0-9]{4,4}/',$first_no)){
        pdo_rollback();
        message('请填写正确的一等奖号码',referer(),'error');
    }
    if(empty($second_no)||!preg_match('/[0-9]{4,4}/',$second_no)){
        pdo_rollback();
        message('请填写正确的二等奖号码',referer(),'error');
    }
    if(empty($third_no)||!preg_match('/[0-9]{4,4}/',$third_no)){
        pdo_rollback();
        message('请填写正确的三等奖号码',referer(),'error');
    }
    if(empty($special_no)||count($special_no)!=10){
        pdo_rollback();
        message('请填写正确的特等奖号码',referer(),'error');
    }
    if(empty($consolation_no)||count($consolation_no)!=10){
        pdo_rollback();
        message('请填写正确的安慰奖号码',referer(),'error');
    }
    $data = array(
        'cid' => $period['cid'],
        'first_no'=>$first_no,
        'second_no'=>$second_no,
        'third_no'=>$third_no,
        'special_no'=>implode('|',$special_no),
        'consolation_no'=>implode('|',$consolation_no),
        'result_5D' => implode('|',$D5),
        'result_6D' => $D6
    );
        
    $periods = pdo_fetch( 'select * from '. tablename('manji_run_setting') . ' where id=:period_id',array(':period_id'=>$period_id));

    if (time() < $periods['endtime']) {
        pdo_rollback();
        message('尚未到开奖时间，请稍等',referer(),'error');
    }
    $data['period_id'] = $period_id;
    pdo_delete('manji_lottery_record',array('period_id'=>$period_id));
    $res = pdo_insert('manji_lottery_record',$data);
    if($res){
        $record_list = pdo_fetchall('select member_old_money,member_id from '.tablename('manji_reward_log').' where period_id=:period_id order by id desc',array(':period_id'=>$period_id));
        foreach ($record_list as $val) {
            pdo_update('member_system_member',array('credit1'=>$val['member_old_money']),array('id'=>$val['member_id']));
        }
        pdo_delete('manji_reward_log',array('period_id'=>$period_id));
    
        $first_money = 0;
        $second_money = 0;
        $third_money = 0;
        $special_money = 0;
        $consolation_money = 0;
        
        //先进行B计算，所有数字 都要算
        $first_money += cal_B($period_id, $periods['periods'],  $first_no, "头等奖",1);  //头等奖
        $second_money += cal_B($period_id,  $periods['periods'], $second_no, '二等奖',2); //二等奖
        $third_money += cal_B($period_id,  $periods['periods'],$third_no, '三等奖',3);  //三等奖
        
        foreach($special_no as $special_no_arr_idx){
            $special_money += cal_B($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖

            //4D计算，只算特别奖
            $special_money += cal_4D($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
            $special_money += cal_C4($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
            $special_money += cal_2D($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
            $special_money += cal_EA($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
            $special_money += cal_EC($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
            $special_money += cal_EX($period_id,  $periods['periods'],$special_no_arr_idx, '特别奖',4);  //特别奖
        }
        
        foreach($consolation_no as $consolation_no_arr_idx){
            $consolation_money += cal_B($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖

            //4D计算，只算安慰奖
            $consolation_money += cal_4E($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
            $consolation_money += cal_C5($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
            $consolation_money += cal_2E($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
            $consolation_money += cal_EA($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
            $consolation_money += cal_EC($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
            $consolation_money += cal_EX($period_id,  $periods['periods'],$consolation_no_arr_idx, '安慰奖',5);  //安慰奖
        }

        if (count($D5) == 6) {
            $D5_money += cal_5D1($period_id,  $periods['periods'],$D5[0], '头等奖',1);  //安慰奖
            $D5_money += cal_5D2($period_id,  $periods['periods'],$D5[1], '二等奖',2);  //安慰奖
            $D5_money += cal_5D3($period_id,  $periods['periods'],$D5[2], '三等奖',3);  //安慰奖
            $D5_money += cal_5D4($period_id,  $periods['periods'],substr($D5[0],-4), '四等奖',4);  //安慰奖
            $D5_money += cal_5D5($period_id,  $periods['periods'],substr($D5[0],-3), '五等奖',5);  //安慰奖
            $D5_money += cal_5D6($period_id,  $periods['periods'],substr($D5[0],-2), '六等奖',6);  //安慰奖
        }

        if (!empty($D6)) {
            $D6_money += cal_6D1($period_id,  $periods['periods'],$D6, '头等奖',1);  //安慰奖
            $D6_money += cal_6D2($period_id,  $periods['periods'],$D6, '二等奖',2);  //安慰奖
            $D6_money += cal_6D3($period_id,  $periods['periods'],$D6, '三等奖',3);  //安慰奖
            $D6_money += cal_6D4($period_id,  $periods['periods'],$D6, '四等奖',4);  //安慰奖
            $D6_money += cal_6D5($period_id,  $periods['periods'],$D6, '五等奖',5);  //安慰奖
        }
        
        //4A计算，只算头奖
        $first_money += cal_4A($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
        $second_money += cal_4B($period_id,  $periods['periods'],$second_no, '二等奖',2);  //二等奖
        $third_money += cal_4C($period_id,  $periods['periods'],$third_no, '三等奖',3);  //三等奖

        //4ABC计算，只算头二三等奖
        $first_money += cal_4ABC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
        $second_money += cal_4ABC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_4ABC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖
        
        
        //S计算，只算二三等奖
        $first_money += cal_S($period_id,  $periods['periods'],$first_no, '头等奖',1);//二等奖       //
        $second_money += cal_S($period_id,  $periods['periods'],$second_no, '二等奖',2);//二等奖
        $third_money += cal_S($period_id,  $periods['periods'],$third_no, '三等奖',3);//三等奖
        
        //C3计算，前三等奖
        $first_money += cal_3ABC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
        $second_money += cal_3ABC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_3ABC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖
        
        //3A=首奖的最后三个号码
        $first_money += cal_A($period_id,  $periods['periods'],  $first_no, '头等奖',1);  //头等奖
        $second_money += cal_C2($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_C3($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

        //3A=首奖的最后三个号码
        $first_money += cal_2A($period_id,  $periods['periods'],  $first_no, '头等奖',1);  //头等奖
        $second_money += cal_2B($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_2C($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

        //2C计算，前三等奖
        $first_money += cal_2ABC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
        $second_money += cal_2ABC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_2ABC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

        //EA计算，前三等奖
        $first_money += cal_EA($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
        $second_money += cal_EA($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_EA($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

        //EC计算，前三等奖
        $first_money += cal_EC($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
        $second_money += cal_EC($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_EC($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

        //EX计算，前三等奖
        $first_money += cal_EX($period_id,  $periods['periods'],$first_no, '头等奖',1);  //头等奖
        $second_money += cal_EX($period_id,  $periods['periods'],$second_no, '二等奖',2); //二等奖
        $third_money += cal_EX($period_id,  $periods['periods'], $third_no, '三等奖',3);  //三等奖

        if ($periods['cid'] == 1) {
            random_jackpot($period_id);
            major_jackpot($period_id);
            minor_jackpot($period_id);
        }
        
        //保存中奖结果
        $save = array(
        'period_id'=>$period_id,
        'fisrt'=>$first_money,
        'second'=>$second_money,
        'third'=>$third_money,
        'consolation'=>$consolation_money,
        'special'=>$special_money,
        'D5_result' => $D5_money,
        'D6_result' => $D6_money
        );
        pdo_delete('manji_pay_award',array('period_id'=>$period_id));
        pdo_insert('manji_pay_award', $save);
        
        //更新中奖名单
        pdo_delete('manji_downline_report',array('periods_id'=>$period_id));
        if ($period['cid'] == 1) {
            saveDownline($period_id);
        }
        else{
            saveEat($period_id);
        }
    }
}

$period_count = pdo_fetchColumnValue('select id from '.tablename('manji_run_setting').' where date=:date and cid<>1',array(':date'=>$date),'id');
$result_fields = implode(',',$period_count);
$result_count = pdo_fetchcolumn('select count(*) from '.tablename('manji_lottery_record').' where period_id in ('.$result_fields.')');
if (count($period_count) == $result_count) {
    total_big_jackpot($date);
    total_middle_jackpot($date);
    total_small_jackpot($date);

}
pdo_commit();
message('保存成功','','success');





 ?>