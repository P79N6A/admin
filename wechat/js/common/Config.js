/**
 * 常量
 **/
var VERSION='1.0';	
var HTTP_URL = 'http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_mainpage&do=',//公共接口(无需登录)
	HTTP_SRC_URL = 'http://kake.gangbengkeji.cn/',//图片接口
	HTTP_ORDER_FLOW_URL='http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_orderflow&&version='+VERSION+'&do=',//订单模块接口
	HTTP_BASE_URL='http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&',
	HTTP_USER_URL='http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_user&version='+VERSION+'&do=';//会员模块接口
	HTTP_PATTERN_URL='http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_pattern&version='+VERSION+'&do=';//显示模块
var WECHAT_URL = 'http://kake.gangbengkeji.cn/wechat/index.php';


//加密key
var AES_KEY = 'fe98ze65qa87qw63';
//加密偏移量
var AES_IV  = '987DEF654ABC3210';
//提现规则
var TIXIAN_RULE_URL = 'http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_mainpage&do=help&op=tixian';
//注册协议
var REGISTER_RULE_URL = 'http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_mainpage&do=help&op=reg';
//微信自定义分享签名
var SHARE_PATH = 'http://kake.gangbengkeji.cn/app/index.php?i=6&c=entry&m=distribution_mainpage&do=share_info';
//分享注册页面
var SHARE_REGISTER_URL = 'http://live.gangbengkeji.cn/html/share/register.html';
//商品详情分享链接
var SHARE_GOODS_DETAIL = 'http://live.gangbengkeji.cn/html/goods/goodsDetail.html';
//商品分类分享链接
var SHARE_GOODS_CATEGORY_LIST = 'http://live.gangbengkeji.cn/html/classify/categoryList.html';
//h5页面地址	
var HWEB_URL='http://live.gangbengkeji.cn';
