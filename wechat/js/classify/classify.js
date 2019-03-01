/*
 * 分类
 */



function getData() {
	if (is_weixin()) {
		var send_url = WECHAT_URL;
		var param = {url:HTTP_URL + 'all_cates'};
	}
	else{
		var send_url = HTTP_URL + 'all_cates';
		var param = {};
	}
	mui.getJSON(send_url, param,
		function(data) {
			console.log("分类" + JSON.stringify(data));
			category.categroyList = coverCategory(data.list);
		});
}

/*
 * 数据解析
 */
function coverCategory(obj) {
	var newCategroyList = [];
	var categroysList = obj;
	for(var i = 0; i < categroysList.length; i++) {
		var categroy = categroysList[i];
		var cates = categroy.category;
		var newCates = [];

		for(var j = 0; j < cates.length; j++) {
			var cate = cates[j];
			newCates.push({
				cate_id: cate.id,
				cate_title: cate.cate_title,
				cate_thumb: HTTP_SRC_URL + cate.cate_thumb
			});
		}
		newCategroyList.push({
			id: categroy.id,
			title: categroy.cate_title,
			category: newCates
		});
	}

	return newCategroyList;
}