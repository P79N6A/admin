function loginOut() {
	interface_aes_login(HTTP_USER_URL + 'logoutjg', {}, function(resp) {
		if(resp.status == 403) {
			mui.toast('已在另外的设备上登录');
			localStorage.clear();
		} else if(resp.status == 200) {
			localStorage.clear();
			toMine();
		}
	});
}
/**
 *个人信息转换
 * */
function convertUserInfo(obj) {
	var newitems = [];
	var items = obj.list;
	newitems.push({
		userId: items.user_no,
		nickname: items.nickname,
		sex: items.sex,
		src: HTTP_SRC_URL + items.avatar,
		credit1: items.credit1,
		credit2: items.credit2,
		credit3: items.credit3,
		sign: items.sign
	});
	return newitems;
}