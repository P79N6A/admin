/*
 * 我的团队
 */

//当天
var list1 = new Vue({
	el : '#time1',
	data : {
		listTime1 : []
	}
});

//昨天
var list2 = new Vue({
	el : '#time2',
	data : {
		listTime2 : []
	}
});


//本月
var list3 = new Vue({
	el : '#time3',
	data : {
		listTime3 : []
	}
});

//上月
var list4 = new Vue({
	el : '#time4',
	data : {
		listTime4 : []
	}
});

//今年
var list5 = new Vue({
	el : "#time5",
	data : {
		listTime5 : []
	}
});


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


/*
 * timetype 时间类型
 * page 分页
 * call 成功回调
 */
function getData(timetype,page,callback){
	
	callback = callback || $.noop();
	var state = getState();//登录信息
	mui.post(HTTP_PATTERN_URL+'team_benefits',
	{
		user_id : state.id,
		token : state.token,
		time_type : timetype,
		page : page
	},function(data){
		//数据
		//console.log(JSON.stringify(data));
		if(timetype == 1 && page == 1){
			list1.listTime1 = coverData(data.list);
		}else if(timetype ==1 && page >1){
			list1.listTime1 = list1.listTime1.concat(coverData(data.list));
		}
		
		if(timetype == 2 && page == 1){
			list2.listTime2 = coverData(data.list);
		}else if(timetype ==2 && page >1){
			list2.listTime2 = list2.listTime2.concat(coverData(data.list));
		}
		
		if(timetype == 3 && page == 1){
			list3.listTime3 = coverData(data.list);
		}else if(timetype ==3 && page >1){
			list3.listTime3 = list3.listTime3.concat(coverData(data.list));
		}
		
		if(timetype == 4 && page == 1){
			list4.listTime4 = coverData(data.list);
		}else if(timetype ==4 && page >1){
			list4.listTime4 = list4.listTime4.concat(coverData(data.list));
		}
		
		if(timetype == 5 && page == 1){
			list5.listTime5 = coverData(data.list);
		}else if(timetype == 5 && page >1){
			list5.listTime5 = list5.listTime5.concat(coverData(data.list));
		}
		return callback(data);
	},'json');
}


/*数据解析*/
function coverData(obj){
	var newItems = [];
	var items = obj;
	for(var i = 0; i < items.length;i++){
		var item = items[i];
		newItems.push({
			userId : item.user_id,
			nickname : item.nickname,
			avatar : HTTP_SRC_URL + item.avatar,
			shareNumber : item.share_number,
			teamIncome : item.team_income,
			allIncome : item.all_income
			/*userId : '',
			nickname : item.name,
			avatar : '',
			shareNumber : '123',
			teamIncome : '100',
			allIncome : '1000'*/
		});
	}
	return newItems;
}


bindEvent = Common.bindEvent,
	// 记录一个最新
	maxDataSize = 30,
	listDomArr = [],
	requestDelayTime = 500,
	miniRefreshArr = [],
	currIndex = 0;
	
	bindEvent('.nav-control p', function(e) {
	var type = this.getAttribute('list-type');
	type = +type;
	console.log(type + ',' + currIndex);
	if(type !== currIndex) {
		navControl.querySelector('.active').classList.remove('active');
		this.classList.add('active');
		currIndex = type;
		mySwiper.slideTo(currIndex, 0);
	}
}, 'click');

/*#############下拉刷新，上拉加载#################*/
var time1_page = 1,
	time2_page = 1,
	time3_page = 1,
	time4_page = 1,
	time5_page = 1;
	
var initMiniRefresh = function(index){
	listDomArr[index] = document.querySelector('#time' + index);
	
	miniRefreshArr[index] = new MiniRefresh({
		container: '#minirefresh' + index,
		contentdown: '刷新完成',
		down: {
			callback: function() {
				setTimeout(function() {
					// 每次下拉刷新后，上拉的状态会被自动重置
					//appendTestData(listDomArr[index], 10, true, index);
					getData(index,'1',function(data){
							
						});
					miniRefreshArr[index].endDownLoading();
				}, requestDelayTime);
			}
		},
		
		up : {
			isAuto : false,
			callback : function(){
				setTimeout(function(){
					//console.log("timetype1"+"------page="+time1_page);
					var page = 1;
					if(index == 1){
						time1_page++;
						page = time1_page;
					}else if(index == 2){
						time2_page++;
			            page = time2_page;
					}else if(index == 3){
						time3_page++;
						page = time3_page;
					}else if(index == 4){
						time4_page++;
						page = time4_page;
					}else if(index == 5){
						time5_page++;
						page = time5_page;
						
					}
					getData(index,page,function(data){
						//console.log("time_type="+index+"------page="+page);
						//console.log(time1_page+"+++"+time2_page+"+++"+time3_page+"+++"+time4_page+"+++"+time5_page+"+++");
							if(data.list.length == 0){
								miniRefreshArr[index].endUpLoading(true);
							}else{
								miniRefreshArr[index].endUpLoading(false);
							}
						});
				},requestDelayTime);
			}
		}
	});
}
	
	
initMiniRefresh(1);
initMiniRefresh(2);
initMiniRefresh(3);
initMiniRefresh(4);
initMiniRefresh(5);
/*#############下拉刷新，上拉加载#################*/
 
mui.plusReady(function() {
	window.setTimeout(function() {
		getData('1','1',function(data){}); 
		getData('2','1',function(data){});
		getData('3','1',function(data){});
		getData('4','1',function(data){});
		getData('5','1',function(data){});
	}, 500);
});
