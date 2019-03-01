/**
 * 首页刷新
 */
var app = {
	initialize: function() {
		this.bindEvents();
		this.setupVue();
	},
	bindEvents: function() {
		mui.ready(this.onReady);
	},
	onReady: function() {
		mui.init({
			swipeBack: false,
			pullRefresh: {
				container: '#app',
				deceleration: (mui.os.ios ? 0.003 : 0.0006),
				down: {
					callback: down
				}
				/*,
								up: {
									callback: up
								}*/
			}
		});
		//自动上拉
		setTimeout(function() {
			//mui('#app').pullRefresh().pulldownLoading(); 
		}, 200);
	},

	setupVue: function() {
		this.vm = new Vue({
			el: "#app",
			data: {
				randomWord: '',
				list: [],
				page: { //页面数据
					No: 1, //当前下标
					Size: 4, //数量
					oNo: 1, //上一次啊的上拉下标
					isDown: false, //是否下拉
					fname: 'push'
				}
			},
			methods: {
				//获取列表数据
				getNetData: function(fn) {
					var _vm = this;
					if(_vm.page.isDown) { //下拉
						//记住上拉的页数
						_vm.page.No = 1;
						_vm.page.fname = 'unshift';
					} else { //上拉
						//重新获取上拉的页数
						_vm.page.No = _vm.page.oNo++;
						_vm.page.fname = 'push';
					}

					//模拟列表数据 
					setTimeout(function() {
						var _data = _list();
						_vm.list[_vm.page.fname].apply(_vm.list, _data);
						fn && fn(!_data || _data.length === 0);
						getHomeData();
					}, 500);
				},
				//条目点击
				onTap: function(o) {
					mui.toast(o.id);
				}
			}
		});
	}
};

var _list = (function() {
	var index = 0;
	return function() {
		var rs = [];
		for(var i = index; i < index + 10; i++) {
			rs.push({
				id: i
			});
		}
		index = i;
		return rs;
	}
}());

//下拉刷新
function down() {
	app.vm.page.isDown = true;
	app.vm.getNetData(function() {
		mui('#app').pullRefresh().endPulldownToRefresh();
	});
}
//上拉加载更多
function up() {
	app.vm.page.isDown = false;
	app.vm.getNetData(function(c) {
		mui('#app').pullRefresh().endPullupToRefresh(c);
	});
}

app.initialize();