function get_follow_list(page) {
	var state = getState();
	console.log("====" + page + "====")

	if (is_weixin()) {
		var send_url = WECHAT_URL;
		if (page > 1) {
			var param = {user_id: state.id,token: state.token,page: page,url:HTTP_BASE_URL + 'm=distribution_orderflow&do=my_collects'};
		}
		else{
			var param = {user_id: state.id,token: state.token,page: 1,url:HTTP_BASE_URL + 'm=distribution_orderflow&do=my_collects'};
		}
	}
	else{
		var send_url = HTTP_BASE_URL + 'm=distribution_orderflow&do=my_collects';
		if (page > 1) {
			var param = {user_id: state.id,token: state.token,page: page};
		}
		else{
			var param = {user_id: state.id,token: state.token,page: 1};
		}
	}

	if(page > 1) {
		mui.getJSON(send_url, param, function(data) {

			vm.follow_list = follow_list.concat(convert(data.list));
			console.log(vm.follow_list.length);

			mui('#scroll-pull').pullRefresh().endPullupToRefresh(data.list.length == 0);
		});
	} else {
		console.log(vm.follow_list.length);
		mui.getJSON(send_url, param, function(data) {
			vm.follow_list = convert(data.list);
			mui('#scroll-pull').pullRefresh().endPulldownToRefresh();
		});
	}
}