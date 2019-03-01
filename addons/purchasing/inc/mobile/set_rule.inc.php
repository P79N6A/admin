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

if ($op == 'post') {
	$title = $_GPC['title'];
	$content = $_GPC['content'];

	if (empty($title)) {
		$data = array(
			'status' => 2,
			'info' => '请输入标题'
		);
		echo json_encode($data);
		exit;
	}

	foreach ($content as $key => $value) {
		if ($value != '') {
			$content_str[] = $value;
		}
	}
	if (count($content_str) == 0) {
		$data = array(
			'status' => 2,
			'info' => '请选择至少一个投注项'
		);
		echo json_encode($data);
		exit;
	}

	$save = array(
		'title' => $title,
		'content' => implode(',',$content_str)
	);

	$res = pdo_insert('manji_rules',$save);
	if ($res) {
		$data = array(
			'status'=> 1,
			'info' => '添加成功'
		);
	}
	else{
		$data = array(
			'status' => 2,
			'info' => '添加失败'
		);
	}
	echo json_encode($data);
	exit;
}





 ?>