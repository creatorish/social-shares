<?php
	/**
	 * SocialShares Class
	 * SNSでシェアされた数をまとめて取得するPHP ClassのjQueryとの連携をするPHPです。
	 *
	 * author: creatorish.com
	 * url: http://creatorish.com/lab/2257
	 * PHP 5.2以上,curl使用
	 * license: MIT
	 *
	 **/
	
	require_once "SocialShares.php";
	$settings = array(
		"facebook" => true,
		"twitter" => true,
		"hatena" => true,
		"google" => true,
		"pinterest" => true
	);
	$url = null;
	$title = null;
	$media = null;
	
	foreach($settings as $service => $value) {
		if (isset($_GET[$service])) {
			$settings[$service] = $_GET[$service];
		}
	}
	
	$ss = new SocialShares($settings);
	
	if (isset($_GET["url"])) {
		$url = $_GET["url"];
	} else {
		echo '{"status": "error", "value": "null"}';
	}
	if (isset($_GET["title"])) {
		$title = $_GET["title"];
	}
	if (isset($_GET["media"])) {
		$media = $_GET["media"];
	}
	
	$ss->init($url,$title,$media);
	
	$json = json_encode($ss->result);
	echo '{"status": "success","count": ' . $ss->count . ',"value": ' . $json . '}';
?>