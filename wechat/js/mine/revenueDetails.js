function getRevenueDetails(p) {
	var param = {
		page: page
	};
	interface_aes_login(HTTP_USER_URL + 'incomeinfo', param, function(data) {
		//	mui.post(HTTP_USER_URL + "incomeinfo",{
		//		user_id : getState().id,
		//		token : getState().token,
		//		page : p
		//	},function(data){
		console.log("收入明细" + JSON.stringify(data));
		mui('#revenueDetailsList').pullRefresh().endPullupToRefresh((data.list.length == 0));
		var list = coverRevenueDetails(data.list);

		//页面封装
		//mui('#revenueDetailsList').pullRefresh().endPullupToRefresh((list.length == 0));
		var table = document.body.querySelector('.mui-table-view');
		var cells = document.body.querySelectorAll('.mui-col-xs-12');
		for(var i = cells.length, len = i + list.length; i < len; i++) {
			var item = list[i];
			var li = document.createElement('li');
			li.className = 'mui-col-xs-12 ';
			li.style = 'height: 15vw;border-bottom: 1px solid #e3e3e3;';
			li.innerHTML = '<div class="mui-col-xs-4 mui-pull-left item-style" > ' + item.time + '</div><div class="mui-col-xs-4 mui-pull-left item-style" >' + item.title + '</div><div class="mui-col-xs-4 mui-pull-left item-style" ">' + item.income + '</div>';
			table.appendChild(li);
		}
	}, 'json');
}

function coverRevenueDetails(obj) {
	var newItems = [];
	var items = obj;
	for(var i = 0; i < items.length; i++) {
		var item = items[i];
		newItems.push({
			time: formatDate(item.finishtime), //时间
			title: item.title, //收入来源
			income: item.income //收入金额
		});
	}
	return newItems;
}