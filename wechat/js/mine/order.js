/**
 * 订单
 * */
//所有订单数据
var orderAll = new Vue({
	el: '#order0',
	data: {
		orderAllList: []
	}
});
//所有待支付数据
var orderPay = new Vue({
	el: '#order1',
	data: {
		orderPayList: []
	}
});
//所有待发货数据
var orderConsignment = new Vue({
	el: '#order2',
	data: {
		orderConsignmentList: []
	}
});
//所有待评价数据
var orderEvaluate = new Vue({
	el: '#order3',
	data: {
		orderEvaluateList: []
	}
});

function getOrderData(type, page, callback) {
	var state = getState();
	callback = callback || $.noop;
	var param = {
		type: type,
		page: page
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'order_list', param, function(data) {
		//	mui.post(HTTP_ORDER_FLOW_URL + 'order_list', {
		//		user_id: state.id,
		//		token: state.token,
		//		type: type,
		//		page: page
		//	}, function(data) {
		if(type == 0 && page == 1) {
			orderAll.orderAllList = convertOrder(data.list);
			console.log("getOrderData" + JSON.stringify(data));
		} else if(type == 0 && page > 1) {
			orderAll.orderAllList = orderAll.orderAllList.concat(convertOrder(data.list));
		}
		if(type == 1 && page == 1) {
			orderPay.orderPayList = convertOrder(data.list);
		} else if(type == 1 && page > 1) {
			orderPay.orderPayList = orderPay.orderPayList.concat(convertOrder(data.list));
		}
		if(type == 2 && page == 1) {
			orderConsignment.orderConsignmentList = convertOrder(data.list);
		} else if(type == 2 && page > 1) {
			orderConsignment.orderConsignmentList = orderConsignment.orderConsignmentList.concat(convertOrder(data.list));
		}
		if(type == 3 && page == 1) {
			orderEvaluate.orderEvaluateList = convertOrder(data.list);
		} else if(type == 3 && page > 1) {
			orderEvaluate.orderEvaluateList = orderEvaluate.orderEvaluateList.concat(convertOrder(data.list));
		}
		return callback(data);
	}, 'json');
};

/*
 *订单数据转换
 * */
function convertOrder(obj) {
	//订单
	var newitems = [];
	var items = obj;
	//当请求服务器无响应时,提示length未定义
	for(var i = 0; i < items.length; i++) {
		var item = items[i];
		//商品
		var productList = [];
		var productItems = items[i].product_list;
		for(var j = 0; j < productItems.length; j++) {
			var productItem = productItems[j];
			//property 商品属性
			var propertyList = [];
			var propertyItems = productItems[j].property;
			for(var k = 0; k < propertyItems.length; k++) {
				var propertyItem = propertyItems[k];
				if(propertyItem.title == null) {
					propertyItem.title = "";
				}
				propertyList.push({
					propertyId: propertyItem.id,
					propertyTitle: propertyItem.title,
					propertyValue: propertyItem.value
				});
			}
			if(productItem.thumb == null) {
				productItem.thumb = "";
			}
			productList.push({
				productId: productItem.goods_id,
				productName: productItem.name,
				productNumber: productItem.product_number, //商品数量
				productPrice: productItem.price,
				src: HTTP_SRC_URL + productItem.thumb,
				propertyList
			});
		}
		var create_time = formatDate(item.create_time);
		newitems.push({
			orderId: item.order_id,
			paylogId: item.paylog_id,
			payType: item.pay_type,
			orderTime: create_time,
			orderStatus: item.status, //0:全部；1：待支付；2：待发货；3：待收货；4：待评价
			orderDeposit: item.deposit, //定金
			orderTotalPrice: item.total_price, //总计
			orderFreight: item.freight, //运费
			productList
		});
	}
	console.log("订单" + JSON.stringify(newitems));
	return newitems;
}

var bindEvent = Common.bindEvent,
	// 记录一个最新
	maxDataSize = 30,
	listDomArr = [],
	requestDelayTime = 500,
	miniRefreshArr = [],
	currIndex = 0;
var order_all_page = 1,
	order_pay_page = 1,
	order_consignment_page = 1,
	order_evaluate_page = 1;
var initMiniRefreshs = function(index) {

	listDomArr[index] = document.querySelector('#order' + index);

	miniRefreshArr[index] = new MiniRefresh({
		container: '#minirefresh' + index,
		contentdown: '刷新完成',
		down: {
			callback: function() {
				setTimeout(function() {
					// 每次下拉刷新后，上拉的状态会被自动重置
					//appendTestData(listDomArr[index], 10, true, index);
					if(index === 0) {
						getOrderData('0', '1', function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条所有订单');
							} else {
								mui.toast('无数据');
							}
						});
					} else if(index === 1) {
						getOrderData('1', '1', function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条未支付订单');
							} else {
								mui.toast('无未支付订单');
							}
						});
					} else if(index === 2) {
						getOrderData('2', '1', function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条发货订单');
							} else {
								mui.toast('无发货订单');
							}
						});
					} else if(index === 3) {
						getOrderData('3', '1', function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条收货订单');
							} else {
								mui.toast('无收货订单');
							}
						});
					}
					miniRefreshArr[index].endDownLoading();
				}, requestDelayTime);
			}
		},
		up: {
			isAuto: false,
			callback: function() {
				setTimeout(function() {
					//miniRefreshArr[index].endUpLoading(listDomArr[index].children.length >= maxDataSize ? true : false);\
					//数据拼接
					if(index === 0) {
						order_all_page++;
						getOrderData('0', order_all_page, function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条全部订单');
								miniRefreshArr[index].endUpLoading(len < 20 ? true : false);
							} else {
								miniRefreshArr[index].endUpLoading(true);
							}
						});
					} else if(index === 1) {
						order_pay_page++;
						getOrderData('1', order_pay_page, function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条未支付订单');
								miniRefreshArr[index].endUpLoading(len < 20 ? true : false);
							} else {
								miniRefreshArr[index].endUpLoading(true);
							}
						});
					} else if(index === 2) {
						order_consignment_page++;
						getOrderData('2', order_consignment_page, function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条发货订单');
								miniRefreshArr[index].endUpLoading(len < 20 ? true : false);
							} else {
								miniRefreshArr[index].endUpLoading(true);
							}
						});
					} else if(index === 3) {
						order_evaluate_page++;
						getOrderData('3', order_evaluate_page, function(data) {
							var len = data.list.length;
							if(len > 0) {
								mui.toast('已刷新' + data.list.length + '条收货订单');
								miniRefreshArr[index].endUpLoading(len < 20 ? true : false);
							} else {
								miniRefreshArr[index].endUpLoading(true);
							}
						});
					}

				}, requestDelayTime);
			}
		}
	});
};

var navControl = document.querySelector('.nav-control');

var mySwiper = new Swiper('.swiper-container', {
	autoplay: 0,
	//				direction: 'vertical', //根据内容高度自动切换到下一个tab
	//				autoHeight: true,
	onTransitionStart: function(swiper) { //tab样式切换监听,开始(onTransitionStart)的时候监听,而不是结束(onTransitionEnd)的时候监听
		var index = swiper.activeIndex;
		navControl.querySelector('.active').classList.remove('active');
		navControl.children[index].classList.add('active');
		currIndex = index;
	}
});

bindEvent('.nav-control p', function(e) {
	var type = this.getAttribute('list-type');
	type = +type;
	if(type !== currIndex) {
		navControl.querySelector('.active').classList.remove('active');
		this.classList.add('active');
		currIndex = type;
		mySwiper.slideTo(currIndex, 0);
	}
}, 'click');

initMiniRefreshs(0);
initMiniRefreshs(1);
initMiniRefreshs(2);
initMiniRefreshs(3);

mui_plusReady(function() {
	window.setTimeout(function() {
		getOrderData('0', '1', function(data) { //全部
		});
		getOrderData('1', '1', function(data) { //待支付
		});
		getOrderData('2', '1', function(data) { //待发货
		});
		getOrderData('3', '1', function(data) { //待收货
		});

		appClosePageById('pay');
	}, 50);
});

/**
 * 打开订单详情
 * 
 * @param {Object} item 当前点击的订单对象
 */
function open_detail(item) {
	//alert(item.id);//提示未定义
	//	mui.toast(item.orderId);//未定义时,不toast
	var extras = {
		orderId: item.orderId
	};
	mui_storage_set('order_detail_form_data', extras);
	mui.openWindow({
		id: 'orderDetail',
		url: '../../html/mine/orderDetail.html',
		show: {
			autoShow: true,
			aniShow: "pop-in",
			duration: 300
		},
		extras: {
			order_detail_form_data: extras
		}
	});
}

/**
 * 订单支付
 */
function order_pay(item) {

	var extras = {
		paylog_id: item.paylogId,
		price: item.orderTotalPrice
	};
	console.log("订单列表-支付1" + JSON.stringify(extras));
	mui_storage_set('pay_form_data', extras);
	var req = mui_storage_get('pay_form_data');
	console.log("订单列表-支付2" + JSON.stringify(req));
	mui.openWindow({
		url: '../pay/pay.html',
		show: {
			autoShow: true,
			aniShow: "pop-in",
			duration: 300
		},
		extras: {
			pay_form_data: extras
		}
	});
}
/**
 * 订单取消
 */
function order_cancel(item) {
	//	mui.toast("取消" + item.orderId);
	mui.confirm('你确定取消订单吗', ' ', ['取消', '确认'], function(e) {
		if(e.index == 0) {
			//nothing
			//			mui.toast('已取消');
		} else if(e.index == 1) {
			cancelOrder(item.orderId, 1);
		}
	});
}
/**
 * 收货
 */
function order_receipt(item) {
	mui.confirm('收到货了吗', ' ', ['取消', '确认'], function(e) {
		if(e.index == 0) {
			//nothing
			//			mui.toast('已取消');
		} else if(e.index == 1) {
			cancelOrder(item.orderId, 2);
		}
	});
}

function cancelOrder(order_id, type) {
		var param = {
				order_id: order_id,
		type: type
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'order_control', param, function(data) {
//	var state = getState();
//	mui.getJSON(HTTP_ORDER_FLOW_URL + 'order_control', {
//		user_id: state.id,
//		token: state.token,
//		order_id: order_id,
//		type: type
//	}, function(data) {
		if(type == 1) {
			mui.toast('订单已取消');
		} else if(type == 2) {
			mui.toast('已收货');
		}
		//		refreshPage('order');
		window.location.reload();
	});
}