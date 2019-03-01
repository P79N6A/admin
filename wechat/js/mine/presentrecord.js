/*
 * 提现明细
 */

var present = new Vue({
	el: '#presentRecordList',
	data: {
		presentrecordlist: []
	}
});

function getPresentRocordData(p) {
	var param = {
		page: p
	};
	interface_aes_login(HTTP_USER_URL + 'tixianlist', param, function(data) {
		//	mui.post(HTTP_USER_URL + "tixianlist",{
		//		user_id : getState().id,
		//		token : getState().token,
		//		page : p
		//	},function(data){
		console.log("取现明细" + JSON.stringify(data));
		mui('#presentRecordList').pullRefresh().endPullupToRefresh((data.list.length == 0));
		if(p == 1) {
			present.presentrecordlist = coverPresentRecord(data.list);
		} else {
			present.presentrecordlist.concat(coverPresentRecord(data.list));
		}

	}, 'json');
}

function coverPresentRecord(obj) {
	var newItems = [];
	var items = obj;
	for(var i = 0; i < items.length; i++) {
		var item = items[i];
		var type = '';
		if(item.type == 1) {
			type = "提现到支付宝";
		}
		newItems.push({
			money: item.money,
			type: type,
			time: formatDate(item.createtime)
		});
	}
	return newItems;
}