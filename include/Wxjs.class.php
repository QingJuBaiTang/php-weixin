<?php

require_once 'WxAuth.class.php';

class Wxjs{

	private $appId;

	private $appSecret;

	private $accessToken;

	private $ticket;

	public function __construct($appId, $appSecret) {

		$this->appId = $appId;

		$this->appSecret = $appSecret;

	}

	public function getShareScript(){

		$sign_data=$this->getSignPackage();

		$html 	= <<<EOM

	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

	<script type="text/javascript">

		wx.config({

		  debug: false,

		  appId:'{$sign_data['appId']}',

		  timestamp:{$sign_data['timestamp']},

		  nonceStr:'{$sign_data['nonceStr']}',

		  signature:'{$sign_data['signature']}',

		  jsApiList: [

	    	'checkJsApi',

		    'onMenuShareTimeline',

		    'onMenuShareAppMessage',

		    'onMenuShareQQ',

		    'onMenuShareWeibo',

			'openLocation',

			'getLocation',

			'addCard',

			'chooseCard',

			'openCard',

			'hideMenuItems',

			'scanQRCode',

			'startRecord',

			'stopRecord',

			'onVoiceRecordEnd',

			'playVoice',

			'pauseVoice',

			'stopVoice',

			'onVoicePlayEnd',

			'uploadVoice',

			'downloadVoice',

			'chooseImage',

			'previewImage',

			'uploadImage',

			'downloadImage'

		  ]

		});

	</script>

	<script type="text/javascript">

	wx.ready(function () {

	  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口

	    wx.onMenuShareAppMessage({

			title: window.shareData.tTitle,

			desc: window.shareData.tContent,

			link: window.shareData.sendFriendLink,

			imgUrl: window.shareData.imgUrl,

		    type: '', // 分享类型,music、video或link，不填默认为link

		    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空

		    success: function () {

		    },

		    cancel: function () {

		    }

		});

	  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口

		wx.onMenuShareTimeline({

			title: window.shareData.fTitle?window.shareData.fTitle:window.shareData.tTitle,

			link: window.shareData.sendFriendLink,

			imgUrl: window.shareData.imgUrl,

		    success: function () {

		    },

		    cancel: function () {

		    }

		});

	  // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口

		wx.onMenuShareWeibo({

			title: window.shareData.tTitle,

			desc: window.shareData.tContent,

			link: window.shareData.sendFriendLink,

			imgUrl: window.shareData.imgUrl,

		    success: function () {

		    },

		    cancel: function () {

		    }

		});

		wx.error(function (res) {

			if(res.errMsg){

			}

		});

	});

</script>

EOM;

		return $html;

	}

	public function getSignPackage() {

		$jsapiTicket = $this->getJsApiTicket();

		$protocol = (!empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";

		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$timestamp = time ();

		$nonceStr = $this->createNonceStr ();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序 

		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

		$signature = sha1 ( $string );

		$signPackage = array (

				"appId" => $this->appId,

				"nonceStr" => $nonceStr,

				"timestamp" => $timestamp,

				"url" => $url,

				"signature" => $signature,

				"rawString" => $string 

		);

		return $signPackage;

	}

	private function createNonceStr($length = 16) {

		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$str = "";

		for($i = 0; $i < $length; $i ++) {

			$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );

		}

		return $str;

	}

	private function getJsApiTicket() {

		$sql="select * from tbl_param_config limit 0,1";

		$res=mysql_query($sql);

		$data=mysql_fetch_assoc($res);

		if($data['ticket_expires_time']>time()){

			$this->ticket=$data['jsapi_ticket'];

		}

		else{

			$accessToken = $this->getAccessToken();

			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";

			$res = json_decode($this->httpGet($url));

			if($res->errcode==40001||$res->errcode==40014){//强制刷新accesstoken

				$accessToken=$this->forceRefreshAccessToken();

				$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";

				$res = json_decode($this->httpGet($url));

			}

			$this->ticket = $res->ticket;

			$data['jsapi_ticket']=$res->ticket;

			$data['ticket_expires_time']=$res->expires_in;

			$sql="update tbl_param_config set jsapi_ticket='".$data['jsapi_ticket']."',ticket_expires_time='".$data['ticket_expires_time']."' where id=".$data['id'];

			mysql_query($sql);

		}

		return $this->ticket;

	}

	private function getAccessToken(){

		$WxAuth=new WxAuth($this->appId, $this->appSecret);

		$this->accessToken=$WxAuth->getAccessToken();

		return $this->accessToken;

	}

	private function forceRefreshAccessToken(){

		$WxAuth=new WxAuth($this->appId, $this->appSecret);

		$this->accessToken=$WxAuth->forceRefreshAccessToken();

		return $this->accessToken;

	}

	private function httpGet($url) {

		$curl = curl_init ();

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curl, CURLOPT_TIMEOUT, 500);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

		curl_setopt($curl, CURLOPT_URL, $url );

		$res = curl_exec($curl);

		curl_close($curl);

		return $res;

	}

}

