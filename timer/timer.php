<?php
require_once '../framework/bootstrap.inc.php';
auto_order_done();
function auto_order_done(){
    /*自动确认收货时间*/
    //$end = 15;
    $etime = time() - 7 * 60*60*24;
    $numberbegin = pdo_fetchcolumn("select max(id) from".tablename('distribution_order'));
    $numberend = $numberbegin - 10000;
    if($numberend < 0){
        $numberend = 0;
    }
    $order = pdo_fetchall("select * from ".tablename($this->modulename.'_order')." where shipping_time<=".$etime." and status=3  and id between ".$numberend." and ".$numberbegin);
        if (!empty($order)) {
            $num = count($order,0);
            for ($i=0; $i < $num; $i++) {
            	pdo_update("distribution_order",array('status'=>4),array('id'=>$order[$i]['id']));
            }
        }
}
?>