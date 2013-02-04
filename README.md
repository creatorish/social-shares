jQuery Social Shares
======================
SNSでシェアされた数とその合計値が取得できるPHP&jQueryプラグイン

デモ
------
<a href="http://dev.creatorish.com/demo/social-shares/js.html" target="_blank">http://dev.creatorish.com/demo/social-shares/js.html</a>

動作環境
------

PHP5.2以上（curlを使用）

使い方
------
スクリプトを読み込みます。

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.social-shares.js"></script>

SocialSharesをnewして使用します。第一引数にObjectでオプションを渡すことができます。

    var shares = new SocialShares({
        success: function(data) {
            alert(data.count); //総シェア数
            alert(data.value.facebook.count); //いいね数
            alert(data.value.twitter.count); //ツイート数
            alert(data.value.google.count); //+1数
            alert(data.value.hatena.count); //はてブ数
            alert(data.value.pinterest.count); //Pin数
        }
    });
    //initで実行します。
    shares.init();

### オプション ###

+    url: "jQuerySocialShares.php" : jQuerySocialShares.phpのパスです。jQuerySocialSharesと**同階層**にSocialShares.phpを設置してください。
+    cache: false : 取得情報のキャッシュを残すかどうかのフラグです。デフォルトは残しません。
+    async: true : 非同期で通信するかどうかのフラグです。デフォルトは非同期です。
+    timeout: 10000 : タイムアウトまでの時間です。
+    success: function(data){} : シェア情報が取得できたときに実行する処理です。第一引数にはシェア情報が返ってきます。  
data.count → 総シェア数  
data.facebook.count → いいね！数  
data.twitter.count → ツイート数  
data.google.count → +1数  
data.hatena.count → はてブ数  
data.pinterest.count → Pin数
+    error: function(e){} : シェア数取得に失敗したときの処理です。
+    service: { facebook: true,twitter: true,google: true,hatena: true,pinterest: true} : シェア数を取得するSNSです。  
デフォルトはすべて取得です。通信量削減のために不要なサービスはfalseにしましょう。

すべてのオプションをまとめると以下のようになります。

    var shares = new SocialShares({
        url: "jQuerySocialShares.php",
        cache: false,
        async: true,
        timeout: 10000,
        success: function(data) {
            alert(data.count); //総シェア数
            alert(data.value.facebook.count); //いいね数
            alert(data.value.twitter.count); //ツイート数
            alert(data.value.google.count); //+1数
            alert(data.value.hatena.count); //はてブ数
            alert(data.value.pinterest.count); //Pin数
        },
        error: function() {
        },
        service: {
            facebook: true,
            twitter: true,
            google: true,
            hatena: true,
            pinterest: true
        }
    });
    //initで実行します。
    shares.init();


### 指定URLのシェア数を取得 ###

init時に取得したいURLを渡すだけです。

    shares.init("http://creatorish.com/lab/2282");

### シェア用のURLを取得 ###

    shares.init("http://creatorish.com/lab/2282","SNSでシェアされた数とその合計値が取得できるPHP&amp;jQueryプラグイン「jQuery Social Shares」","http://creatorish.com/wp/wp-content/uploads/2012/04/socialshares.png");

その後getLink(“SNS名”)でシェア用のURLが取得できます。

    shares.getLink("facebook");
    shares.getLink("twitter");
    shares.getLink("google");
    shares.getLink("hatena");
    shares.getLink("pinterest"); 

ライセンス
--------
[MIT]: http://www.opensource.org/licenses/mit-license.php
Copyright &copy; 2012 creatorish.com
Distributed under the [MIT License][mit].

作者
--------
creatorish yuu  
Weblog: <http://creatorish.com>  
Facebook: <http://facebook.com/creatorish>  
Twitter: <http://twitter.jp/creatorish>