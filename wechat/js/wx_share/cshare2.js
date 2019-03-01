
const share_title = '共享提成';
const share_url = 'http://live.gangbengkeji.cn/img/fx_logo.png';
const share_link = 'http://live.gangbengkeji.cn/html/share/register.html?user_id=' + getState().id;
wx.ready(function () {
    wx.checkJsApi({
        jsApiList: [
      		"onMenuShareAppMessage",
	        "onMenuShareQQ",
	        "onMenuShareQZone",
	        "onMenuShareTimeline"
        ],
        success: function (res) {
            
        }
    });
    wx.onMenuShareAppMessage({
        title: share_title,
        desc: share_title,
        link: share_link,
        imgUrl: share_url ,
        trigger: function (res) {

        },
        success: function (res) {
            // alert('已分享');
        },
        cancel: function (res) {
            // alert('已取消');
        },
        fail: function (res) {
            // alert(JSON.stringify(res));
        }
    });
	wx.onMenuShareTimeline({
        title: share_title,
        desc: share_title,
        link: share_link,
        imgUrl: share_url ,
        trigger: function (res) {

        },
        success: function (res) {
            // alert('已分享');
        },
        cancel: function (res) {
            // alert('已取消');
        },
        fail: function (res) {
            // alert(JSON.stringify(res));
        }
    });
    wx.onMenuShareQQ({
        title:  share_title,
        desc: share_title,
        link: share_link,
        imgUrl:share_url,
        trigger: function (res) {

        },
        success: function (res) {
            // alert('已分享');
        },
        cancel: function (res) {
            // alert('已取消');
        },
        fail: function (res) {
            // alert(JSON.stringify(res));
        }
    });
    wx.onMenuShareQZone({
        title: share_title,
        desc: share_title,
        link: share_link,
        imgUrl:share_url,
        trigger: function (res) {

        },
        success: function (res) {
            // alert('已分享');
        },
        cancel: function (res) {
            // alert('已取消');
        },
        fail: function (res) {
            // alert(JSON.stringify(res));
        }
    });
    
});