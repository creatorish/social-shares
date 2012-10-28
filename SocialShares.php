<?php
	/**
	 * SocialShares Class
	 * SNSでシェアされた数をまとめて取得するPHP Classです。
	 *
	 * author: creatorish.com
	 * url: http://creatorish.com/lab/2257
	 * PHP 5.2以上,curl使用
	 * license: MIT
	 *
	 **/
	class SocialShares {
		private $social_api = array(
			"facebook" => "http://graph.facebook.com/",
			"twitter" => "http://urls.api.twitter.com/1/urls/count.json?url=",
			"hatena" => "http://api.b.st-hatena.com/entry.count?url=",
			"google" => "https://plusone.google.com/u/0/_/+1/fastbutton?url=",
			"pinterest" => "http://api.pinterest.com/v1/urls/count.json?callback=&url="
		);
		
		private $social_link = array(
			"facebook" => "http://www.facebook.com/sharer.php?u=%url%&amp;t=%title%",
			"twitter" => "http://twitter.com/share?text=%title%&url=%url%",
			"hatena" => "http://b.hatena.ne.jp/add?mode=confirm&url=%url%&title=%title%",
			"google" => "https://plusone.google.com/_/+1/confirm?hl=en&url=%url%",
			"pinterest" => "http://pinterest.com/pin/create/button/?url=%url%&media=%media%&description=%title%"
		);
		
		private $curl_option = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_USERAGENT => 'socialshares',
			CURLOPT_AUTOREFERER => true,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_MAXREDIRS => 3,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false
		);
		private $setting = array(
			"facebook" => true,
			"twitter" => true,
			"hatena" => true,
			"google" => true,
			"pinterest" => true
		);
		public $result = array();
		public $count = 0;
		private $_url = "";
		private $_title = "";
		private $_media = "";
		public function SocialShares($setting=null) {
			if (isset($setting) && is_array($setting)) {
				$this->setting = array_merge($this->setting,$setting);
			}
		}
		public function init($url=null,$title=null,$media=null) {
			$this->url($url);
			$this->title($title);
			$this->media($media);
			if (!$this->_url) {
				$protocol = "http://";
				if(isset($_SERVER['HTTPS'])){
					$protocol = "https://";
				}
				$this->url($protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
			}
			foreach($this->setting as $service => $value) {
				if ($value === true) {
					$count = $this->get_count($service);
					$this->result[$service] = array(
						"url" => $this->create_link($this->social_link[$service]),
						"count" => $count
					);
					$this->count += $count;
				}
			}
			return $this->result;
		}
		public function url($val=null) {
			if (isset($val)) {
				$this->_url = urlencode($val);
			}
			return $this->_url;
		}
		public function title($val=null) {
			if (isset($val)) {
				$this->_title = $val;
			}
			return $this->_title;
		}
		public function media($val=null) {
			if (isset($val)) {
				$this->_media = $val;
			}
			return $this->_media;
		}
		
		private function get_count($service) {
			$count = 0;
			switch($service) {
				case "facebook":
					$count = $this->get_facebook_count();
					break;
				case "twitter":
					$count = $this->get_twitter_count();
					break;
				case "hatena":
					$count = $this->get_hatena_count();
					break;
				case "google":
					$count = $this->get_google_count();
					break;
				case "pinterest":
					$count = $this->get_pinterest_count();
					break;
			}
			return $count;
		}
		private function get_facebook_count() {
			$likecount = file_get_contents($this->social_api["facebook"] . $this->_url, true);
			$decode_likecount = json_decode($likecount, true);
			if ($decode_likecount && $decode_likecount["shares"]) {
				return $decode_likecount["shares"];
			}
			return 0;
		}
		private function get_twitter_count() {
			$tweetcount = file_get_contents($this->social_api["twitter"] . $this->_url, true);
			$decode_tweetcount = json_decode($tweetcount, true);
			if ($decode_tweetcount) {
				return $decode_tweetcount['count'];
			}
			return 0;
		}
		private function get_hatena_count() {
			$bookmarkcount = file_get_contents($this->social_api["hatena"] . $this->_url, true);
			if($bookmarkcount){
				return $bookmarkcount;
			}
			return 0;
		}
		private function get_google_count() {
			$content = $this->parse($this->social_api["google"] . $this->_url . "&count=true");
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false;
			@$dom->loadHTML($content);
			$domxpath = new DOMXPath($dom);
			$newDom = new DOMDocument;
			$newDom->formatOutput = true;
			
			$filtered = $domxpath->query("//div[@id='aggregateCount']");
			return str_replace('>', '', $filtered->item(0)->nodeValue);
		}
		private function get_pinterest_count() {
			$content = $this->parse($this->social_api["pinterest"] . $this->_url);
			$result = json_decode(str_replace(array('(', ')'), array('', ''), $content));
			if ($result->count) {
				return $result->count;
			};
			return 0;
		}
		private function parse($encUrl) {
			$ch = curl_init();
			$options = $this->curl_option;
			$options[CURLOPT_URL] = $encUrl;  
			curl_setopt_array($ch, $options);
			
			$content = curl_exec($ch);
			$err = curl_errno($ch);
			$errmsg = curl_error($ch);
			
			curl_close($ch);
			if ($errmsg != '' || $err != '') {
				
			}
			return $content;
		}
		private function create_link($url) {
			$url = str_replace("%title%",$this->_title,$url);
			$url = str_replace("%url%",$this->_url,$url);
			$url = str_replace("%media%",$this->_media,$url);
			return $url;
		}
	}
?>