/**
 * 订单详情
 */
mui.init({
	keyEventBind: {
		backbutton: false //关闭back按键监听
	}
});
var orderDetail = new Vue({
	el: '#orderDetail',
	data: {
		orderDetailList: []
	}
});
mui_plusReady(function() {
	var self = mui_storage_get('order_detail_form_data');
	var id = self.orderId;
	console.log("order detail order_id:" + id);
	getOrderDetail(id);
});
/**
 * 获取订单详情
 * @param {Object} orderId 订单id
 */
function getOrderDetail(orderId) {
	var param = {
		order_id: orderId
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'order_detail', param, function(resp) {
		//	var state = getState();
		//	mui.getJSON(HTTP_ORDER_FLOW_URL + 'order_detail', {
		//		user_id: state.id,
		//		token: state.token,
		//		order_id: orderId
		//	}, function(resp) {
		console.log("获取订单详情" + JSON.stringify(resp));
		if(resp.status == 403) {} else if(resp.status == 200) {
			orderDetail.orderDetailList = convertOrderDetail(resp);
			console.log("订单详情" + JSON.stringify(orderDetail.orderDetailList));
		}
	});
}
/*
 *订单数据转换
 * */
function convertOrderDetail(obj) {
	//订单
	var newitems = [];
	var orderAddress = [];
	var item = obj;
	//当请求服务器无响应时,提示length未定义
	//商品
	var productList = [];
	var productItems = item.product_list;
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
			propertyList //商品属性
		});
	}
	orderAddress.push({
		addressId: item.address.id,
		address: item.address.address,
		addressDetail: item.address.address_detail,
		name: item.address.name,
		phone: item.address.phone
	});
	var create_time = formatDate(item.create_time);
	newitems.push({
		orderId: item.order_id,
		orderTime: create_time,
		orderStatus: item.state, //0:全部；1：待支付；2：待发货；3：待收货；4：待评价
		orderDeposit: item.deposit, //定金
		orderTotalPrice: item.total_price, //总计
		orderFreight: item.freight, //运费
		orderComments: item.comments, //留言
		orderSn: item.order_sn, //订单编号
		productList, //商品
		orderAddress
	});
	return newitems;
}

/**
 * 订单支付
 */
function order_pay(item) {
	var extras = {
		paylog_id: item.orderId,
		price: item.orderTotalPrice
	};
	mui_storage_set('pay_form_data', extras);
	mui.openWindow({
		id: 'pay',
		url: '../../html/pay/pay.html',
		show: {
			autoShow: true,
			aniShow: "pop-in",
			duration: 300
		},
		extras: {
			pay_form_data: item.extras,
		}
	});
}
/**
 * 订单取消
 */
function order_cancel(item) {
	mui.confirm('你确定取消订单吗', ' ', ['取消', '确认'], function(e) {
		if(e.index == 0) {
			//nothing
			//			mui.toast('已取消');
		} else if(e.index == 1) {
			cancelOrder(item.orderId, 1);
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
		appRefreshPageById('order');
		//		location.href = '../../html/mine/order.html';
	});
}