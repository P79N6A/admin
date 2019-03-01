/*
 * 我的收益数据
 */
function getEarningData() {
	interface_aes_login(HTTP_USER_URL + 'sellercenter', {}, function(data) {
		//	mui.post(HTTP_USER_URL+"sellercenter",
		//		{
		//			user_id:getState().id,
		//			token:getState().token
		//		},function(data){
		console.log("我的收益:" + JSON.stringify(data));
		var payment = parseEarning(data);

		//今日收益
		var today = '<span id ="income_today" style="display:block;font-size: 4.5vw;color: #333333;">';
		today += payment.today;
		today += '元</span>'
		document.getElementById("income_today").innerHTML = today;

		//可提现余额
		var balance = '<span id="payment_balance" style="font-size: 3.5vw;color: #ff1313;text-align:left;">';
		balance += payment.credit;
		balance += '元</span>';
		document.getElementById("payment_balance").innerHTML = balance;

		//累计收益
		var total = '<span id="payment_all" style="font-size: 3.5vw;color: #ff1313;text-align:left;">';
		total += payment.total;
		total += '元</span>';
		document.getElementById("payment_total").innerHTML = total;
	}, 'json');
}

function parseEarning(obj) {
	var status = obj.status;
	if(status == 200) {
		/*请求成功*/
		return obj;
	} else {
		//mui.toast(obj.info);
	}
}