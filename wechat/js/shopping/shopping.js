var shopping = new Vue({
	el: "#shopping", //限定作用域
	data: {
		totalMoney: 0,
		shoppingList: [],
		checkAllFlag: false,
		delFlag: false,
		curProduct: '',
		cartIdList: []
	},
	filters: { //局部过滤器
		formatMoney: function(value) {
			return "￥" + value.toFixed(2); //toFixed有精度缺失（四舍五入），所以价格一般有后台传入
		}

	},
	mounted: function() { //页面加载之后自动调用，常用于页面渲染
		//		this.$nextTick(function() { //在2.0版本中，加mounted的$nextTick方法，才能使用vm
		//			getShoppingData(function(data) {
		//				var _this = this;
		//				_this.shoppingList = data.list;
		//			});
		//		})

	},
	methods: {
		// 通过+、-改变商品数量从而改变总额
		changeMoney: function(product, way) {
			if(way > 0) {
				product.productNumber++;
			} else {
				product.productNumber--;
				if(product.productNumber < 1) {
					product.productNumber = 1; //当数量少于1个时保持1个不变
				}
			}
			this.calcTotalPrice();
			updateProductNum(product, product.productNumber); //更新数据库商品数量
		},
		//直接编辑商品数量
		changeProductNum: function(item, num) {
			this.calcTotalPrice();
			updateProductNum(item, num);
		},
		// 判断是否先中了按钮
		selectedProduct: function(item) {
			if(typeof item.checked == 'undefined') { //判断是否未定义，如果没点击过按钮是没有注册的，则需要先注册checked属性
				// Vue.set(item,"checked",true);//全局注册
				this.$set(item, "checked", true); //局部注册
			} else {
				item.checked = !item.checked;
			}

			var _this = this;
			var countTrue = 0; //记录选中的item,当countTrue==shoppingList.length,全选中状态
			var selectAll = document.getElementById("selectAll");
			//循环集合 判断item是否有未选中状态
			_this.shoppingList.forEach(function(item, index) {
				if(item.checked == true) {
					countTrue++;
				}
			});
			if(countTrue == _this.shoppingList.length) {
				document.getElementById('selectAll').classList.add("check"); //直接添加选中样式
			} else {
				document.getElementById('selectAll').classList.remove("check"); //直接移除选中样式
			}

			this.calcTotalPrice();
		},
		// 全选与取消全选，点击全选时flag为true,取消时为false
		checkAll: function() {
			var _this = this;
			var selectAll = localStorage.getItem("selectAll");
			if(selectAll == 1) {
				localStorage.setItem("selectAll", 2);
				var _selectAll = localStorage.getItem("selectAll");
				this.checkAllFlag = true;
			} else if(selectAll == 2) {
				localStorage.setItem("selectAll", 1);
				var _selectAll = localStorage.getItem("selectAll");
				this.checkAllFlag = false;
			}

			this.shoppingList.forEach(function(item, index) {
				if(typeof item.checked == 'undefined') { //也要防止未定义
					_this.$set(item, "checked", _this.checkAllFlag); //通过set来给item添加属性checked
				} else {
					item.checked = _this.checkAllFlag;
				}
			});
			this.calcTotalPrice();
		},
		// 计算总金额
		calcTotalPrice: function() {
			var _this = this;
			this.totalMoney = 0;
			this.shoppingList.forEach(function(item, index) {
				if(item.checked) {
					_this.totalMoney += item.price * item.productNumber;
				}
			});
		},
		// 确定删除
		delConfirm: function(item) {
			//			this.delFlag = true;
			//			this.curProduct = item;
			mui.confirm('你确定删除吗', ' ', ['取消', '确认'], function(e) {
				if(e.index == 0) {
					//nothing
					mui.toast('已取消');
				} else if(e.index == 1) {
					deleteCart(item);
				}
			});
		},
		//v-for不反应
		delProduct: function() {
			var index = this.shoppingList.indexOf(this.curProduct); //获取当前的对象索引
			this.shoppingList.splice(index, 1); //删除的位置,删除的个数
			this.delFlag = false;
		},
		//结算 获取选中的item的id
		settle: function() {
			var _this = this;
			_this.cartIdList = [];
			_this.shoppingList.forEach(function(item, index) {
				if(item.checked == true) {
					_this.cartIdList.push(
						item.id
					);
				}
			});

			if(this.cartIdList.length == 0) {
				mui.toast('请选择商品');
				return;
			}
			postSettle(this.cartIdList);
		}
	}
});
//全局过滤器，可以在任何一个页面使用
Vue.filter("money", function(value, type) {
	return "￥" + value.toFixed(2) + type;
})
/**
 * 结算
 * @param {Object} item
 * @param {Object} num
 */
function postSettle(cartIdList) {
	var param = {
		cart_id: cartIdList
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'order_pay_list', param, function(data) {
		toSureOrder(cartIdList);
	});
}

function toSureOrder(cartIdList) {
	var extras = {
		cart_id: cartIdList
	};
	mui_storage_set('confirm_order_form_data', extras);
	mui.openWindow({
		id: 'confirm',
		url: '../order/confirm.html',
		show: {
			autoShow: true,
			aniShow: 'pop-in',
			duration: 200
		},
		extras: {
			confirm_order_form_data: extras
		}
	})
}

/**
 * 修改商品数量
 * @param {Object} item
 * @param {Object} num
 */
function updateProductNum(item, num) {
	var param = {
		cart_id: item.id,
		num: num
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'edit_cart_product_num', param, function(data) {
	});
}

function deleteCart(item) {
	var param = {
		cart_id: item.id
	};
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'cart_product_delete', param, function(data) {
		window.location.reload();
		mui.toast('删除成功');
	});
}
/**
 * 获取购物车
 * @param {Object} type
 * @param {Object} page
 * @param {Object} callback
 */
function getShoppingData(callback) {
	var state = getState();
	callback = callback || $.noop;
	interface_aes_login(HTTP_ORDER_FLOW_URL + 'cart_product_list', {}, function(data) {
		if(data.status == 200) {
			shopping.shoppingList = convertShopping(data.list);
			return callback(data);
		} else {
			mui.toast(data.info);
		}

	}, 'json');
};

/*
 *购物车数据转换
 * */
function convertShopping(obj) {
	var newitems = [];
	var items = obj;

	for(var i = 0; i < items.length; i++) {
		var propertyList = [];
		var property = items[i].property; //商品属性
		for(var j = 0; j < property.length; j++) {
			var subitem = property[j];
			propertyList.push({
				propertyName: subitem.title,
				propertyValue: subitem.value
			});
		};

		var item = items[i];
		newitems.push({
			id: item.id, //购物车id
			contrastId: item.contrast_id,
			freight: item.freight, //运费
			productName: item.name, //商品名称
			price: item.price, //商品价格
			productId: item.product_id, //商品ID
			productNumber: item.product_number, //商品数量
			status: item.status, //商品状态
			storeNumber: item.store_number, //商品库存
			totalPrice: item.total_price, //商品总价
			unit: item.unit, //商品数量单位
			userId: item.user_id, //该购物车商品所属用户id
			src: HTTP_SRC_URL + item.thumb, //商品图片
			propertyList
		});
	};
	return newitems;
}