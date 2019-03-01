<?php
/**
 * 模块小程序接口定义
 */

defined('IN_IA') or exit('Access Denied');
require 'page_mobile.php';
require 'error_code.php';

class PurchasingModuleWxapp extends WeModuleWxapp
{
	public function __construct()
	{
		global $_GPC;
		global $_W;
		global $openid;
		$this->iswxapp = true;
		//$_W['openid'] = 'o9NSQt-C6M33iau0Cz-cBpsGlBJI';
		//$_W['fans']['from_user'] = 'o9NSQt-C6M33iau0Cz-cBpsGlBJI';
		//$_W['member']['uid'] = '156819';
		$this->openid = $_W['openid'];
	}
	public function logging($message = '')
	{
		$filename = IA_ROOT . '/data/logs/' . date('Ymd') . '.php';
		load()->func('file');
		mkdirs(dirname($filename));
		$content = date('Y-m-d H:i:s') . " \n------------\n";
		if (is_string($message) && !in_array($message, array('post', 'get'))) {
			$content .= "String:\n" . $message . "\n";
		}

		if (is_array($message)) {
			$content .= "Array:\n";

			foreach ($message as $key => $value) {
				$content .= sprintf("%s : %s ;\n", $key, $value);
			}
		}

		if ($message === 'get') {
			$content .= "GET:\n";

			foreach ($_GET as $key => $value) {
				$content .= sprintf("%s : %s ;\n", $key, $value);
			}
		}

		if ($message === 'post') {
			$content .= "POST:\n";

			foreach ($_POST as $key => $value) {
				$content .= sprintf("%s : %s ;\n", $key, $value);
			}
		}

		$content .= "\n";
		$filename = IA_ROOT . '/data/logs/' . date('Ymd') . '.log';
		$fp = fopen($filename, 'a+');
		fwrite($fp, $content);
		fclose($fp);
	}
	public function doPageTest()
    {
		global $_GPC, $_W;
		$errno = 0;
		$message = 'test返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}
	public function doPagelist() {
		include_once 'app/wxapp/list.php';
	}
	public function doPageadv() {
		include_once 'app/wxapp/adv.php';
	}
	public function doPagelistmore_rec() {
		include_once 'app/wxapp/listmore_rec.php';
	
	}
	public function doPagelistmore() {
		include_once 'app/wxapp/listmore.php';

	}
	public function doPageGoods() {
		include_once 'app/wxapp/goods.php';

	}
	
	public function doPageCategory() {
		include_once 'app/wxapp/category.php';

	}
	public function doPageAjaxdelete() {
		global $_GPC;
		$delurl = $_GPC['pic'];
		if (file_delete($delurl)) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function doPageOrder() {
		include_once 'app/wxapp/order.php';
		
	}
	public function doPageAddToCart() {
		include_once 'app/wxapp/addtocart.php';
		
	}
	public function doPageRemove() {
		global $_W, $_GPC;
		$id = intval($_GPC['good_id']);
		pdo_delete('shopping_cart', array('from_user' => $_W['fans']['from_user'], 'weid' => $_W['uniacid'], 'id' => $id));
		return $this->result(0, '删除成功', $list);
	}
	public function doPageClear() {
		global $_W, $_GPC;
		$id = intval($_GPC['id']);
		pdo_delete('shopping_cart', array('from_user' => $_W['fans']['from_user'], 'weid' => $_W['uniacid']));
		return $this->result(0, '已清空', '');
	}
	public function doPageUpdate() {
		global $_W, $_GPC;
		$id = intval($_GPC['id']);
		$num = intval($_GPC['num']);
		$sql = "update " . tablename('shopping_cart') . " set total=$num where id=:id";
		pdo_query($sql, array(":id" => $id));
		return $this->result(0, 'ok', '');
	}
	public function doPageMyCart() {
		include_once 'app/wxapp/mycart.php';

	}
	public function doPageDispatch(){
		include_once 'app/wxapp/dispatch.php';

	}
	public function doPageConfirm() {
		include_once 'app/wxapp/confirm.php';
		
	}
	public function doPageConfirmsub(){
		include_once 'app/wxapp/confirmsub.php';

	}
	public function doPagePay() {
		include_once 'app/wxapp/pay.php';
		
	}
	public function doPagePayResult() {
		include_once 'app/wxapp/payResult.php';
		
	}

	public function doPageContactUs() {
		global $_W;
		$cfg = $this->module['config'];
		return $this->result(0, '成功', $cfg);
	}
	public function doPageMyOrder() {
		include_once 'app/wxapp/myorder.php';
		
	}
	public function doPageDetail() {
		include_once 'app/wxapp/detail.php';
		
	}
	public function doPagePiclist(){
		include_once 'app/wxapp/piclist.php';
		
	}

	public function doPageAddress() {
		include_once 'app/wxapp/address.php';
	}
}

?>