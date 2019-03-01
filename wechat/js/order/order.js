/**
 * 购物车确认页面
 * @param {Object} cart_id
 */
function confirm_order_load(cart_id) {
	var param = {
		cart_id: cart_id
	};
	console.log("刷新购物车重新选择地址后的数据1=" + cart_id);
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'order_pay_list', param, function(response) {
		console.log("刷新购物车重新选择地址后的数据2=" + JSON.stringify(response));
		var html = '';
		var list = response.product_list;
		var address = response.address;
		if(address.id) {
			$('#address_id').val(address.id);
			$('#address_username').text(address.name);
			$('#address_phone').text(address.phone);
			$('#address_detail').text(address.address + address.address_detail);
		} else {
			$('#address_username').text('请选择地址');
		}
		for(var i in list) {
			list[i].productId = list[i].goods_id;
			list[i].thumb = HTTP_SRC_URL + list[i].thumb;
		}
		new Vue({
			el: '#product_list',
			data: {
				product_list: list,
				freight: response.freight,
				total_price: response.total_price,
			}
		});

	}, 'json');

}

/**
 * 购物车确认支付
 */
function confirm_order() {
	if(!get_user_login_state()) {
		mui.toast('请先登陆');
		return;
	}
	var cart_id = $('#cart_id').val();
	cart_id = cart_id.split(',');
	if(cart_id.length < 0) {
		mui.toast('请选择订单');
		return;
	}
	var comments = $('#comments').val();
	var address_id = $('#address_id').val();
	var user = getState();
	if(address_id < 1) {
		mui.toast('请选择地址');
		return;
	}
	var param = {
		cart_id: cart_id,
		comments: comments,
		address_id: address_id
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'order_sure', param, function(response) {
		//	mui.post(HTTP_BASE_URL + "m=distribution_orderflow&do=order_sure", {
		//			user_id: user.id,
		//			token: user.token,
		//			cart_id: cart_id,
		//			comments: comments,
		//			address_id: address_id
		//		},
		//		function(response) {

		if(response.status = 200) {
			var price = response.price;
			paylog_id = response.paylog_id;
			var extras = {
				paylog_id: paylog_id,
				price: price
			};
			appClosePageById('buy_now_confirm');
			mui_storage_set('pay_form_data', extras);
			mui.openWindow({
				id: 'pay',
				url: '../pay/pay.html',
				extras: {
					pay_form_data: extras
				}
			});
		}
	}, 'json');

}

/**
 * 立即购买
 * @param {Object} goods_id
 * @param {Object} number
 * @param {Object} contrast_id
 */
function buy_now_confirm_order_load(goods_id, number, contrast_id) {
	var param = {
		product_id: goods_id,
		number: number,
		contrast_id: contrast_id
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'buy_now', param, function(response) {
		//	var user = getState();
		//	mui.post(HTTP_ORDER_FLOW_URL + "buy_now", {
		//			user_id: user.id,
		//			token: user.token,
		//			product_id: goods_id,
		//			number: number,
		//			contrast_id: contrast_id
		//		},
		//		function(response) {
		console.log("errmsg " + response.info);
		var html = '';
		var list = response.product_list;
		var address = response.address;
		if(address.id) {
			$('#address_id').val(address.id);
			$('#address_username').text(address.name);
			$('#address_phone').text(address.phone);
			$('#address_detail').text(address.address + address.address_detail);
		} else {
			$('#address_username').text('请选择地址');
		}

		for(var i in list) {
			console.log(" goods for " + JSON.stringify(list));
			list[i].productId = list[i].goods_id;
			list[i].thumb = HTTP_SRC_URL + list[i].thumb;
		}
		new Vue({
			el: '#product_list',
			data: {
				product_list: list,
				freight: response.freight,
				total_price: response.total_price,
			}
		});

	}, 'json');

}

/**
 * 立即购买 确认
 */
function buy_now_confirm_order(goods_id, number, contrast_id) {

	if(!get_user_login_state()) {
		mui.toast('请先登陆');
		return;
	}

	if(goods_id < 0) {
		mui.toast('请选择商品');
		return;
	}

	var comments = $('#comments').val();
	var address_id = $('#address_id').val();
	var user = getState();
	if(address_id < 1) {
		mui.toast('请选择地址');
		return;
	}

	var param = {
			product_id: goods_id,
			comments: comments,
			address_id: address_id,
			contrast_id: contrast_id,
			number: number,
		};


	interface_aes_login(HTTP_BASE_URL + "m=distribution_orderflow&do=order_sure", param,
		function(response) {
			if(response.status == 200) {
				var price = response.price;
				paylog_id = response.paylog_id;
				var extras = {
					paylog_id: paylog_id,
					price: price
				};
				console.log("确认订单-支付3" + JSON.stringify(extras));
				mui_storage_set('pay_form_data', extras);
				//				alert('buy_now_confirm_order');

				//				app_close_current_page();
				//				window.location.href = '../../html/pay/pay.html?paylog_id=' + paylog_id;
				mui.openWindow({
					id: "pay",
					url: '../pay/pay.html',
					extras: {
						pay_form_data: extras
					}
				});

			}
		}, 'json');

}