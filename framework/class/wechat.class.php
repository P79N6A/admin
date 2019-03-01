<?php
load()->func('cache_memcache2');
load()->func('logging');
load()->func('communication');
class WechatMsg{
	
    // private $APPID = 'wxcc49b47033b6bad7';
    // private $SECRET = '03fcae68b190add20d2645009b4c75fd';
    
    public static function getAccessToken(){
        $accessToken = memcache_read( 'wechat.accessToken' );
        if( empty($accessToken) ){
        	$APPID = 'wx1091e81cd478a956';
    		$SECRET = '1568ee31f293027468489b9242909d38';
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$SECRET;
            $response = ihttp_get( $url );
            $data = $response['content'];
            $tokenJson = json_decode($data, true);
            if( !empty($tokenJson['errcode'])){
                logging_run("get access_token fail, url->".$url.", errmsg->".$tokenJson['errmsg'], 'error', 'sendWechatTemplateMsg');
                
                return false;
            }
            $accessToken = $tokenJson['access_token'];
            memcache_write( 'wechat.accessToken', $accessToken, 7000);
            return $accessToken;    
        }else{
            return $accessToken;
        }
    }

    public static function sendWechatTemplateMsg( $openId,$url, $postJson, $templateId ,$topcolor = '#FF683F'){

        if( empty($openId) ||empty($postJson) || empty($templateId) ){
            return false;
        }
        $data = array();
        $data['touser'] = $openId;
        $data['template_id'] = trim($templateId);
        $data['url'] = trim($url);
        $data['data'] = $postJson;
        $data = json_encode($data);

        $token = self::getAccessToken();
        
        $post_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
        $response = ihttp_post( $post_url, $data );

        if (is_error($response)) {
            logging_run("send template msg fail, response->".$response, 'error', 'sendWechatTemplateMsg');
            return false;
        }
        $data = $response['content'];
        $tokenJson = json_decode($data, true);
        if( !empty($tokenJson['errcode'])){
            logging_run("send template msg fail, response->".$tokenJson['errmsg'], 'error', 'sendWechatTemplateMsg');
            return false;
        }
        return true;
    
    }
}
?>