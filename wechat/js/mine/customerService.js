function getPhoneList() {
	interface_aes_login(HTTP_USER_URL + 'service_phone_list', {}, function(data) {
		//	mui.post(HTTP_USER_URL+"service_phone_list",
		//		{
		//			user_id:getState().id,
		//			token:getState().token
		//		},
		//		function(data){
		console.log("客服列表:" + JSON.stringify(data));

		//数据封装

		var phonelist = converPhoneList(data.list);

		var tmp = '';
		var tmp0 = '<li class="mui-table-view-cell mui-media"><a href="tel:';
		var tmp1 = '"><div class="mui-media-body">';
		var tmp2 = '<p class="mui-ellipsis">';
		var tmp3 = '</p></div></a></li>';

		for(i in phonelist) {
			tmp += tmp0;
			tmp += phonelist[i].phone;
			tmp += tmp1;
			tmp += phonelist[i].name;
			tmp += tmp2;
			tmp += phonelist[i].phone;
			tmp += tmp3;
		}

		console.log(tmp);

		document.getElementById("phoneList").innerHTML = tmp;
	}, 'json');
}
/*<li class="mui-table-view-cell mui-media"><a href="tel:18812351562"><div class="mui-media-body">
							客服一号
							<p class='mui-ellipsis'>18814112413</p>
						</div>
					</a>
				</li>*/

//客服电话数据转换
function converPhoneList(obj) {
	var newitems = [];
	var items = obj;
	for(var i = 0; i < items.length; i++) {
		var item = items[i];
		newitems.push({
			id: item.id,
			name: item.name,
			phone: item.phone
		});
	}
	return newitems;
}