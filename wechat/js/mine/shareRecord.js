function getShareRecordList(p){
	interface_aes_login(HTTP_PATTERN_URL+"share_record",
		{
			page : p
		},
		function(data){
		console.log("分享记录" +JSON.stringify(data));
		var shareList = coverShreRecord(data.list);
		 
		mui('#shareRecord').pullRefresh().endPullupToRefresh((shareList.length==0)); //参数为true代表没有更多数据了。
					var table = document.body.querySelector('.mui-table-view');
					var cells = document.body.querySelectorAll('.mui-col-xs-12');
					//注意域的大小变化
					for (var i = cells.length, len = i + shareList.length; i < len; i++) {
						var item = shareList[i];
						var li = document.createElement('li');
						li.className = 'mui-col-xs-12 ';
						li.style = 'height: 15vw;border-bottom: 1px solid #e3e3e3;';
						li.innerHTML = '<div class="mui-col-xs-6 mui-pull-left item-style" > ' + item.name + '</div><div class="mui-col-xs-6 mui-pull-left item-style" style="border-left: 1px solid #e3e3e3;">' + item.phone +'</div>';
						table.appendChild(li);
					}
	},'json');
}

function coverShreRecord(obj){
	//解析分享记录
	var newItems = [];
	var items = obj;
	for(var i=0;i<items.length;i++){
		var item = items[i];
		newItems.push({
			name : item.name,
			phone : item.mobile
		});
	}
	return newItems;
}
