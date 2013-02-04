<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>SNSでシェアされた数とその合計値が取得できるPHPライブラリ SocialShares</title>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28381001-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body>
<?php require_once "SocialShares.php";
$ss = new SocialShares();
$ss->init("http://creatorish.com/lab/2257","SNSでシェアされた数とその合計値が取得できるPHPライブラリ「Social Shares」","http://creatorish.com/wp/wp-content/uploads/2012/04/socialshares.png");
?>
<h1>SocialShares</h1>
<p>SocialSharesはSNSでシェアされた数とその合計値が取得できるPHPライブラリです。</p>
<h2>Share Count: <?php echo $ss->count;?></h2>
<table>
	<tr>
		<th>facebook</th>
		<td><?php echo $ss->result["facebook"]["count"];?></td>
	</tr>
	<tr>
		<th>twitter</th>
		<td><?php echo $ss->result["twitter"]["count"];?></td>
	</tr>
	<tr>
		<th>Google+</th>
		<td><?php echo $ss->result["google"]["count"];?></td>
	</tr>
	<tr>
		<th>hatena</th>
		<td><?php echo $ss->result["hatena"]["count"];?></td>
	</tr>
	<tr>
		<th>pinterest</th>
		<td><?php echo $ss->result["pinterest"]["count"];?></td>
	</tr>
</table>
<h2>Share Link</h2>
<table>
	<tr>
		<th>facebook</th>
		<td><a href="<?php echo $ss->result["facebook"]["url"];?>" target="_blank"><?php echo $ss->result["facebook"]["url"];?></a></td>
	</tr>
	<tr>
		<th>twitter</th>
		<td><a href="<?php echo $ss->result["twitter"]["url"];?>" target="_blank"><?php echo $ss->result["twitter"]["url"];?></a></td>
	</tr>
	<tr>
		<th>Google+</th>
		<td><a href="<?php echo $ss->result["google"]["url"];?>" target="_blank"><?php echo $ss->result["google"]["url"];?></a></td>
	</tr>
	<tr>
		<th>hatena</th>
		<td><a href="<?php echo $ss->result["hatena"]["url"];?>" target="_blank"><?php echo $ss->result["hatena"]["url"];?></a></td>
	</tr>
	<tr>
		<th>pinterest</th>
		<td><a href="<?php echo $ss->result["pinterest"]["url"];?>" target="_blank"><?php echo $ss->result["pinterest"]["url"];?></a></td>
	</tr>
</table>
<p><a href="http://creatorish.com/lab/2257">記事へ戻る</a></p>
<p>copyright&copy; <a href="http://creatorish.com" target="_blank">creatorish.com</a>. All rights reserved.</p>
</body>
</html>