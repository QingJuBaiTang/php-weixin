<?php
class WxAuth{
	private $appId;
	private $appSecret;
	private $accessToken;
	public function __construct($appId,$appSecret){ 
		$this->appId=$appId;
		$this->appSecret=$appSecret;
	}
	public function getAccessToken() {
		$sql="select * from tbl_param_config limit 0,1";
		$res=mysql_query($sql);
		$data=mysql_fetch_assoc($res);
		if ($data['expire_time'] > time()) {
			$this->accessToken = $data['access_token'];
		}
		else {
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
			$res = json_decode($this->httpGet($url));
			$this->accessToken = $res->access_token;
			if ($this->accessToken) {
				$data['expire_time'] = $res->expires_in;
				$data['access_token'] = $this->accessToken;
				$sql="update tbl_param_config set access_token='".$data['access_token']."',expire_time='".$data['expire_time']."' where id=".$data['id'];
				mysql_query($sql);
			}
		}
		return $this->accessToken;
	}
	public function forceRefreshAccessToken(){
		$sql="select * from tbl_param_config limit 0,1";
		$res=mysql_query($sql);
		$data=mysql_fetch_assoc($res);
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
		$res = json_decode($this->httpGet($url));
		$this->accessToken = $res->access_token;
		if ($this->accessToken) {
			$data['expire_time'] = $res->expires_in;
			$data['access_token'] = $this->accessToken;
			$sql="update tbl_param_config set access_token='".$data['access_token']."',expire_time='".$data['expire_time']."' where id=".$data['id'];
			mysql_query($sql);
		}
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