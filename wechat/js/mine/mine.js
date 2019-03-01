function getUserInfo(callback) {
	callback = callback || $.noop;
	interface_aes_login(HTTP_USER_URL + 'usercenter', {}, function(data) {
		if(data.status == 200) {
			userInfo.userInfos = convertUserInfo(data);
		}
		return callback(data);
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