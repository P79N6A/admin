<?php 
global $_W,$_GPC;

$mid = $_SESSION['mid'];
if (empty($mid)) {
	$data = array(
		'status' => 3,
		'info' => '请先登录'
	);
	echo json_encode($data);
	exit;
}

$op = $_GPC['op'];

if ($op == 'del') {
	$date = $_GPC['date'];
	$cid = $_GPC['cid'];

	$periods = pdo_fetchall('select * from '.tablename('manji_run_setting').' where date=:date and aid=:aid',array(':date'=>$date,':aid'=>$cid));

	if (!empty($periods)) {
		foreach ($periods as $key => $value) {
			$order = pdo_fetchcolumn('select count(*) from '.tablename('manji_order').' where period_id like \'%('.$value['id'].')%\'');
			if ($order > 0) {
				$data = array(
					'status' => 2,
					'info' => '该期已有人投注，无法删除'
				);
				echo json_encode($data);
				exit;
			}
		}
	}

	$res = pdo_delete('manji_run_setting',array('date'=>$date,'aid'=>$cid));
	if ($res) {
		$data = array(
			'status' => 1,
			'info' => '删除成功'
		);
		echo json_encode($data);
		exit;
	}
	else{
		$data = array(
			'status' => 2,
			'info' => '删除失败'
		);
		echo json_encode($data);
		exit;
	}
}





 ?>