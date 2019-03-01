/**
 * 跳转到新增地址页面
 */
function add_address() {
	var extras = {
		address_id: 0
	};
	mui_storage_set('address_form_data', extras);
	mui.openWindow({
		id: 'address',
		url: 'address.html',
		extras: {
			address_form_data: extras
		}
	});
}

/**
 * 编辑地址
 * @param {Object} id
 */
function edit_address(id) {
	if(id < 0) {
		mui.toast('请选择地址');
		return;
	}
	var extras = {
		address_id: id
	};
	if(isApp() == 1) { //APP环境下
		mui_storage_set('address_form_data', extras);
		mui.openWindow({
			id: 'address',
			url: 'address.html',
			extras: {
				address_form_data: extras
			}
		});
	} else {
		window.location.href = '../../html/address/address.html?address_id=' + id;
	}

}

/**
 * 获取地址信息
 * @param {Object} address_id
 */
function get_address_info(address_id) {
	var user = getState();

	if(address_id < 0) {
		mui.toast('请选择地址');
		return;
	}
	var param = {
		type: 5,
		address_id: address_id
	};
	interface_aes_login(HTTP_USER_URL + 'address_control', param, function(response) {
		//	mui.post(HTTP_BASE_URL + "m=distribution_user&do=address_control", {
		//			user_id: user.id,
		//			token: user.token,
		//			type: 5,
		//			address_id: address_id
		//		},
		//		function(response) {
		if(response.status = 200) {
			$('#address_id').val(address_id);
			$('#address_username').val(response.name);
			$('#address_phone').val(response.phone);
			$('#address').val(response.address);
			$('#address_detail').val(response.address_detail);
		} else {
			mui_plusReady(function() {
				mui.openWindow({
					url: 'address_list.html',
					id: 'address_list',
				});
			});
		}
	}, 'json');
}

/**
 * 设置默认地址
 * @param {Object} address_id
 */
function set_default_address(address_id) {
	if(address_id < 0) {
		mui.toast('请选择地址');
		return;
	}
	var param = {
		type: 2,
		address_id: address_id
	};
	interface_aes_login(HTTP_USER_URL + 'address_control', param, function(response) {
		//	var user = getState();
		//	mui.post(HTTP_BASE_URL + "m=distribution_user&do=address_control", {
		//			user_id: user.id,
		//			token: user.token,
		//			type: 2,
		//			address_id: address_id
		//		},
		//		function(response) {
		mui.toast(response.info);
		if(response.status = 200) {
			location.reload();
		}
	}, 'json');
}

/**
 * 修改 添加地址
 */
function post_address() {
	var address_id = $.trim($('#address_id').val());
	var name = $.trim($('#address_username').val());
	var phone = $.trim($('#address_phone').val());
	var address = $.trim($('#address').val());
	var address_detail = $.trim($('#address_detail').val());
	console.log("name=" + name);
	if(isEmpty(name)) {
		mui.toast('请填写收货人姓名');
		return;
	}
	if(mobile_validate(phone) == false) {
		return;
	}
	if(isEmpty(address)) {
		mui.toast('请填写地址');
		return;
	}
	if(isEmpty(address_detail)) {
		mui.toast('请填写详细地址');
		return;
	}
	var param = {
		type: 1,
		address_id: address_id,
		name: name,
		phone: phone,
		address: address,
		address_detail: address_detail
	};
	interface_aes_login(HTTP_USER_URL + 'address_control', param, function(response) {
		//	var user = getState();
		//	mui.post(HTTP_BASE_URL + "m=distribution_user&do=address_control", {
		//			user_id: user.id,
		//			token: user.token,
		//			type: 1,
		//			address_id: address_id,
		//			name: name,
		//			phone: phone,
		//			address: address,
		//			address_detail: address_detail
		//		},
		//		function(response) {
		mui.toast(response.info);
		if(response.status = 200) {
			if(isApp() == 1) {
				mui.openWindow({
					url: 'address_list.html',
					id: 'address_list'
				});
			} else {
				window.location.href = '../../html/address/address_list.html';
			}
		}
	}, 'json');
}

/**
 * 删除地址
 * @param {Object} id
 */
function del_address(address_id) {
	var btnArray = ['否', '是'];
	var user = getState();
	mui.confirm('确定要删除？', '删除地址', btnArray, function(e) {
		if(e.index == 1) {
			var param = {
				type: 3,
				address_id: address_id
			};
			interface_aes_login(HTTP_USER_URL + 'address_control', param, function(response) {
				//			mui.post(HTTP_BASE_URL + "m=distribution_user&do=address_control", {
				//					user_id: user.id,
				//					token: user.token,
				//					type: 3,
				//					address_id: address_id
				//				},
				//				function(response) {
				mui.toast(response.info);
				if(response.status == 200) {
					location.reload(true);
				}
			}, 'json');
		}
	});
}

function _get_address_param(obj, param) {
	return obj[param] || '';
}

/**
 * 获取地址列表
 */
function get_address_list() {
	var param = {
		type: 4
	};
	interface_aes_login(HTTP_USER_URL + 'address_control', param, function(response) {
		//	var user = getState();
		//	mui.post(HTTP_BASE_URL + "m=distribution_user&do=address_control", {
		//			user_id: user.id,
		//			token: user.token,
		//			type: 4
		//		},
		//			function(response) {
		var list = response.list;
		new Vue({
			el: '#address_list',
			data: {
				address_list: list
			}
		});

	}, 'json');
}

/**
 *订单选择地址
 */
function choose_adddress() {
	mui_plusReady(function() {
		console.log('购物车进入收货地址');
		mui.openWindow({
			url: '../address/address_list.html',
			id: 'address_list',
		});
	});
}
/**
 * 更换地址
 */
function choose_new_address() {
	var type = localStorage.getItem('address_back_type');
	console.log("===address_back_type===" + type); //1,设置   2,购物车  3,立即购买
	if(type == 1) {
		return;
	}
	//返回购物确认页面
	else if(type == 2) {
		mui.openWindow({
			url: '../order/confirm.html',
			id: 'confirm',
			extras: {
				cart_form_data: extras
			}
		});
		appRefreshPageById('confirm');
	}
	//返回立即下单确认页面
	else if(type == 3) {
		var goods_id = localStorage.getItem('goods_id');
		var number = localStorage.getItem('number');
		var contrast_id = localStorage.getItem('contrast_id');
		//closePageById('buy_now_confirm');
		var extras = {
			product_id: goods_id,
			number: number,
			contrast_id: contrast_id
		};
		mui_storage_set('buy_now_confirm_form_data', extras);
		mui.openWindow({
			url: '../order/buy_now_confirm.html',
			id: 'buy_now_confirm',
			extras: {
				buy_now_confirm_form_data: extras
			}
		});
		appRefreshPageById('buy_now_confirm');
	} else if(type == 4) {
		return;
	}

}