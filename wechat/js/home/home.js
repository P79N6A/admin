/**
 * 首页
 * */

function getHomeData() {
	if (is_weixin()) {
		var send_url = WECHAT_URL;
		var param = {url:HTTP_URL + 'main_page'};
	}
	else{
		var send_url = HTTP_URL + 'main_page';
		var param = {};
	}
	mui.getJSON(send_url, param, function(data) {

		var len = data.advert.length;
		var arr = convertAdvert(data.advert);
		//		console.log("轮播图数据ajax获取" + JSON.stringify(arr));
		var arrl = arr.length - 1; //最后一张
		category.categoryList = convertCategory(data.sorts);
		//		console.log("分类列表" + JSON.stringify(category.categoryList));
		classify.classifyList = convertClassify(data.product_list);
		//		console.log("分类列表详情" + JSON.stringify(classify.classifyList));
		var tmp = '<div class="mui-slider-group mui-slider-loop">';
		//第一个或者最后一个轮播图 lunbo--轮播图大小
		var tmp1 = '<div class="mui-slider-item mui-slider-item-duplicate"><a href="#"><img class="carousel" src="'
		//常规轮播图
		var tmp2 = '<div class="mui-slider-item"><a href="#"><img class="carousel" src="'
		//公共结尾
		var tmp3 = '" id="banner"></a></div>'

		//按钮盒子
		var anniu = '<div class="mui-slider-indicator">'
		//第一个按钮盒子
		var anniu1 = '<div class="mui-indicator  mui-active"></div>'
		//常规按钮盒子
		var anniu2 = '<div class="mui-indicator"></div>'

		for(i in arr) {
			var img = arr[i].src;
			//显示最后一张   
			if(i == 0) {
				tmp += tmp1 + arr[arrl].src + tmp3
				anniu += anniu1
			} else {
				anniu += anniu2
			}
			tmp += tmp2 + img + tmp3
			//显示第一张
			if(i == arrl) {
				tmp += tmp1 + arr[0].src + tmp3
			}
		}
		//轮播盒子结尾
		tmp += '</div>'
		//按钮盒子结尾
		anniu += '</div>'
		//轮播与按钮拼接
		tmp += anniu
		//获取页面上的盒子
		var bigbox = document.getElementById('slider');
		//添加进盒子
		bigbox.innerHTML = tmp;
		var gallery = mui('.mui-slider');
		gallery.slider({
			interval: 3000 //自动轮播周期，若为0则不自动播放，默认为0；
		});
	});
}
/*
 *轮播图数据转换
 * */
function convertAdvert(obj) {
	var newitems = [];
	var items = obj;
	for(var i = 0; i < items.length; i++) {
		var item = items[i];
		newitems.push({
			id: item.id,
			redirectType: item.redirect_type,
			src: HTTP_SRC_URL + item.thumb
		});
	}
	return newitems;
}

/*
 *分类数据转换
 * */
function convertCategory(obj) {
	var newitems = [];
	var items = obj;
	for(var i = 0; i < items.length; i++) {
		var item = items[i];
		newitems.push({
			id: item.cate_id,
			title: item.cate_title,
			src: HTTP_SRC_URL + item.cate_thumb
		});
	}
	return newitems;
}

/*
 *分类列表数据转换
 * */
function convertClassify(obj) {
	var newitems = [];
	var items = obj;
	for(var i = 0; i < items.length; i++) {
		var subnewitems = [];
		var subitems = items[i].list;

		var item = items[i];
		for(var j = 0; j < subitems.length; j++) {
			var subitem = subitems[j];
			subnewitems.push({
				productId: subitem.id,
				productName: subitem.name,
				productOrderNum: subitem.order_num,
				productPrice: subitem.price,
				productSrc: HTTP_SRC_URL + subitem.thumb
			});
		}
		newitems.push({
			id: item.cate_id,
			title: item.cate_title,
			src: HTTP_SRC_URL + item.cate_thumb,
			subnewitems
		});
	}
	return newitems;
}

function openCategoryList(item) {
	var extras = {
		cateId: item.id,
		cateName: item.title
	};
	mui_storage_set('cate_form_data', extras);
	mui.openWindow({
		id: 'categoryList',
		url: '../../html/classify/categoryList.html',
		show: {
			autoShow: true,
			aniShow: 'pop-in',
			durnation: 300
		},
		extras: {
			cate_form_data: extras
		}
	});
}