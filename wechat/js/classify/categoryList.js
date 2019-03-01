var categoryTime = new Vue({
	el: '#categoryTime',
	data: {
		categoryTimeList: []
	}
});
var requestDelayTime = 600,
	currIndex = 0;
var sort_type = 1,
	type = '',
	order_type = 1;
var category_time_page = 1,
	category_sale_page = 1,
	category_hot_page = 1,
	category_price_page = 1;

var miniRefresh = new MiniRefresh({
	container: '#minirefresh',
	down: {
		callback: function() {
			setTimeout(function() {
				if(currIndex == 0) {
					getNewData(sort_id, currIndex, '1', order_type, function(data) {});
				} else if(currIndex == 1) {
					getNewData(sort_id, currIndex, '1', order_type, function(data) {});
				} else if(currIndex == 2) {
					getNewData(sort_id, currIndex, '1', order_type, function(data) {});
				} else if(currIndex == 3) {
					getNewData(sort_id, currIndex, '1', order_type, function(data) {});
				}
				miniRefresh.endDownLoading(true);
			}, requestDelayTime);
		}
	},
	//上拉加载更多后,显示没有更多数据后,@tap事件无效,原因是"没有更多数据了"的DIV,需要设置具体高度
	up: {
		isAuto: false,
		callback: function() {
			setTimeout(function() {
				if(currIndex == 0) {
					category_time_page++;
					getNewData(sort_id, currIndex, category_time_page, order_type, function(data) {
						var len = data.list.length;
						if(len > 0) {
							miniRefresh.endUpLoading(len < 20 ? true : false);
						} else {
							miniRefresh.endUpLoading(true);
						}
					});
				} else if(currIndex == 1) {
					category_sale_page++;
					getNewData(sort_id, currIndex, category_sale_page, order_type, function(data) {
						var len = data.list.length;
						if(len > 0) {
							miniRefresh.endUpLoading(len < 20 ? true : false);
						} else {
							miniRefresh.endUpLoading(true);
						}
					});
				} else if(currIndex == 2) {
					category_hot_page++;
					getNewData(sort_id, currIndex, category_hot_page, order_type, function(data) {
						var len = data.list.length;
						if(len > 0) {
							miniRefresh.endUpLoading(len < 20 ? true : false);
						} else {
							miniRefresh.endUpLoading(true);
						}
					});
				} else if(currIndex == 3) {
					category_price_page++;
					getNewData(sort_id, currIndex, category_price_page, order_type, function(data) {
						var len = data.list.length;
						if(len > 0) {
							miniRefresh.endUpLoading(len < 20 ? true : false);
						} else {
							miniRefresh.endUpLoading(true);
						}
					});
				}

			}, requestDelayTime);
		}
	}
});

function getSort(type, current) {
	var sort = $('.active').attr('id');
	if(sort == type) {
		if(sort_type == 1) {
			$('#' + type).children('p').children('img').attr('src', '../../img/icon_arrow_up.png');
			sort_type = 2;
		} else {
			$('#' + type).children('p').children('img').attr('src', '../../img/icon_arrow_down.png');
			sort_type = 1;
		}
	} else {
		$('.mui-col-xs-3').removeClass('active');
		$('.sort_img').attr('src', '../../img/icon_arrow_nor.png');
		$('#' + type).addClass('active');
		$('#' + type).children('p').children('img').attr('src', '../../img/icon_arrow_down.png');
		sort_type = 1;
	}
	//给类变量赋值,以便刷新时判断
	currIndex = current;
	order_type = sort_type;
	miniRefresh.triggerDownLoading();
	getNewData(sort_id, current, 1, sort_type, function(data) {});
}

/**
 * post回调的形式 处理下拉刷新和上拉加载 
 * @param {Object} sort_id 分类id
 * @param {Object} sort_type 时间/销量/人气/价格
 * @param {Object} page 页数
 * @param {Object} order_type 1降序 2升序
 * @param {Object} callback 根据返回的数值长度来判断有无数据
 */
function getNewData(sort_id, sort_type, page, order_type, callback) {
	console.log("分类列表数据参数sort_id=" + sort_id + " sort_type=" + sort_type + " page=" + page + " order_type=" + order_type);
	callback = callback || $.noop;
	if (is_weixin()) {
		var send_url = WECHAT_URL;
		var param = {sort_id: sort_id,sort_type: sort_type,page: page,reorder_type: order_type,url:HTTP_URL + 'products_list'};
	}
	else{
		var send_url = HTTP_URL + 'products_list';
		var param = {sort_id: sort_id,sort_type: sort_type,page: page,reorder_type: order_type};
	}
	mui.post(send_url, param , function(data) {
		if(page == 1) {
			categoryTime.categoryTimeList = convert(data.list);
		} else {
			categoryTime.categoryTimeList = categoryTime.categoryTimeList.concat(convert(data.list));
		}
		return callback(data);
	}, 'json');
};

function convert(items) {
	var newItems = [];
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

function detail(productId) {
	var extras = {
		goodsId: productId
	};
	mui_storage_set('goods_detail_form_data', extras);
	mui.openWindow({
		id: "goodsDetail",
		url: "../../html/goods/goodsDetail.html",
		extras: {
			goods_detail_form_data: extras
		},
		show: {
			autoShow: true,
			aniShow: 'pop-in',
			duration: 300
		}
	})
}

if(isApp()) {
	$('#sharecategorylist').show();
	document.getElementById('sharecategorylist').addEventListener('tap', function() {
		shareHref();
	});

	document.addEventListener("plusready", function() {
		//获取分享列表
		plus.share.getServices(function(ss) {
			//获取成功
			shares = {};
			for(var i in ss) {
				var t = ss[i];
				shares[t.id] = t;
			}
		}, function(e) {
			//获取分享列表失败
		});
	}, false);
	/*判断是否授权*/
	function shareAction(id, ex) {
		var s = null;
		if(!id || !(s = shares[id])) {
			mui.toast("无效的分享服务！");
			return;
		}
		if(!s) {
			console.log("无效的分享服务！");
			return;
		}
		if(s.authenticated) {
			console.log("---已授权---");
			shareMessage(s, ex);
		} else {
			console.log("---未授权---");
			s.authorize(function() {
				shareMessage(s, ex);
			}, function(e) {
				console.log("认证授权失败：" + e.code + " - " + e.message);
			});
		}
	}

	function shareMessage(s, ex) {
		//http://download.sdk.mob.com/web/images/2018/01/30/09/1517276913964/242_242_46.6.png
		var msg = {
			href: SHARE_GOODS_CATEGORY_LIST + '?cateId=' + sort_id +'&cateName=' + title,
			title: '共享提成',
			content: title,
			thumbs: ['http://kake.gangbengkeji.cn/attachment/images/4/2018/03/123.png'],
			pictures: ['http://kake.gangbengkeji.cn/attachment/images/4/2018/03/123.png'],
			extra: {
				scene: ex
			}
		};
		s.send(msg, function() {
			mui.toast("分享到\"" + s.description + "\"成功！ ");
		}, function(e) {
			mui.toast("分享到\"" + s.description + "\"失败");
		});
	}

	/**
	 * 分享按钮点击事件
	 */
	function shareHref() {
		var ids = [{
				id: "weixin",
				ex: "WXSceneSession" /*微信好友*/
			}, {
				id: "weixin",
				ex: "WXSceneTimeline" /*微信朋友圈*/
			}, {
				id: "qq" /*QQ好友*/
			}],
			bts = [{
				title: "发送给微信好友"
			}, {
				title: "分享到微信朋友圈"
			}, {
				title: "分享到QQ"
			}];
		plus.nativeUI.actionSheet({
				cancel: "取消",
				buttons: bts
			},
			function(e) {
				var i = e.index;
				if(i > 0) {
					shareAction(ids[i - 1].id, ids[i - 1].ex);
				}
			}
		);
	}
}else{
	$('#sharecategorylist').hide();
}