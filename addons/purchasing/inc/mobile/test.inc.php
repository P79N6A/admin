<?php 
global $_W,$_GPC;
$sql1 = '';
$sql2 = '';
$sql3 = '';
for ($i=1; $i <= 500; $i++) { 
	$sql1 .= 'Insert '.tablename('manji_order').' set id='.$i.',user_id='.$i.',number=1234,pay_B=50,pay_S=50,mode=1,period_id=(2),cid=(1),goods_amount=2400,order_amount=2400,createtime='.time().';';
	$number = sort_number(1234);
	foreach ($number as $key => $value) {
		$sql1 .= 'Insert '.tablename('manji_order_detail').' set order_id='.$i.',pay_B=50,pay_S=50,period_id=(2),number='.$value.';';
	}
}
echo $sql1;exit;
$res = pdo_query($sql1);
echo $res;

 ?>