/*
 * 分享
 */
if(isApp()){
document.getElementById('sharenow').addEventListener('tap', function() {
						shareHref();
					});
					
					document.addEventListener("plusready",function(){
					//获取分享列表
					plus.share.getServices(function(ss){
						//获取成功
					shares = {};
        			for (var i in ss) {
            		var t = ss[i];
            		shares[t.id] = t;
           			}
					},function(e){
						//获取分享列表失败
							});
						},false);
/*判断是否授权*/
function shareAction(id, ex) {
    var s = null;
    if (!id || !(s = shares[id])) {
        mui.toast("无效的分享服务！");
        return;
        }
    if (!s) {
        console.log("无效的分享服务！");
        return;
    }
    if (s.authenticated) {
        console.log("---已授权---");
        shareMessage(s, ex);
    } else {
        console.log("---未授权---");
        s.authorize(function() {
            shareMessage(s, ex);
        }, function(e) {
            console.log("认证授权失败：" + e.code + " - " + e.message);
        });
    }
}

function shareMessage(s,ex){
	//http://download.sdk.mob.com/web/images/2018/01/30/09/1517276913964/242_242_46.6.png
    var msg = {
                href: SHARE_REGISTER_URL + '?user_id=' + getState().id,
                title: '共享提成',
                content: '共享提成',
                thumbs: ['http://kake.gangbengkeji.cn/attachment/images/4/2018/03/123.png'],
                pictures: ['http://kake.gangbengkeji.cn/attachment/images/4/2018/03/123.png'],
                extra: {
                    scene: ex
                }
          };
    s.send( msg, function(){
        mui.toast( "分享到\""+s.description+"\"成功！ " );
    }, function(e){
        mui.toast( "分享到\""+s.description+"\"失败");
    } );
}

/**
         * 分享按钮点击事件
         */
        function shareHref() {
            var ids = [{
                    id: "weixin", 
                    ex: "WXSceneSession"  /*微信好友*/
                }, {
                    id: "weixin",
                    ex: "WXSceneTimeline" /*微信朋友圈*/
                }, {
                    id: "qq"   /*QQ好友*/
                }],
                bts = [{
                    title: "发送给微信好友"
                }, {
                    title: "分享到微信朋友圈"
                }, {
                    title: "分享到QQ"
                }];
            plus.nativeUI.actionSheet({
                    cancel: "取消",
                    buttons: bts
                },
                function(e) {
                    var i = e.index;
                    if (i > 0) {
                        shareAction(ids[i - 1].id, ids[i - 1].ex);
                    }
                }
            );
        }
   }