var page = 1;
var follow_list = [];
var collect = new Vue({
	el: '#collect',
	data: {
		collectList: [],
	}
});
getCollectList(1, function(data) {});

var requestDelayTime = 600;
var miniRefresh = new MiniRefresh({
	container: '#minirefresh',
	down: {
		callback: function() {
			setTimeout(function() {
				getCollectList(1, function(data) {});
				miniRefresh.endDownLoading(true);
			}, requestDelayTime);
		}
	},
	up: {
		isAuto: false,
		callback: function() {
			setTimeout(function() {
				page++;
				getCollectList(page, function(data) {
					var len = data.list.length;
					if(len > 0) {
						miniRefresh.endUpLoading(len < 20 ? true : false);
					} else {
						miniRefresh.endUpLoading(true);
					}
				});
			}, requestDelayTime);
		}
	}
});

function getCollectList(page, callback) {
	var state = getState();
	if(isEmpty(state.id) || isEmpty(state.token)) {
		return;
	}
	callback = callback || $.noop;
	var param = {
		page: page
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'my_collects', param, function(data) {
		if(page == 1) {
			collect.collectList = convert(data.list);
		} else {
			collect.collectList = collect.collectList.concat(convert(data.list));
		}
		return callback(data);
	});
};

function convert(items) {
	var newItems = [];
	//遍历items
	items.forEach(function(item) {
		var src = HTTP_SRC_URL + item.thumb
		newItems.push({
			name: item.name,
			productId: item.id,
			price: item.price,
			order_num: item.order_num,
			thumb: src
		})
	});
	return newItems;
}