var SocialShares = function(option) {
	this.options = {
		url: "jQuerySocialShares.php",
		cache: false,
		async: true,
		timeout: 10000,
		success: function(e){},
		error: function(e){},
		service: {
			facebook: true,
			twitter: true,
			google: true,
			hatena: true,
			pinterest: true
		}
	};
	this.params = {
		url: encodeURI(location.href),
		title: jQuery("title").html(),
		media: null
	};
	this.socialLink = {
		facebook: "http://www.facebook.com/sharer.php?u=%url%&amp;t=%title%",
		twitter: "http://twitter.com/share?text=%title%&url=%url%",
		hatena: "http://b.hatena.ne.jp/add?mode=confirm&url=%url%&title=%title%",
		google: "https://plusone.google.com/_/+1/confirm?hl=en&url=%url%",
		pinterest: "http://pinterest.com/pin/create/button/?url=%url%&media=%media%&description=%title%"
	};
	jQuery.extend(this.options,option);
	this.result = null;
	var self = this;
	this.successHandler = function(e) {
		self._success(e);
	};
	this.errorHandler = function(e) {
		self._error(e.message);
	};
};
SocialShares.prototype = {
	init: function(url,title,media) {
		if (url) {
			this.params.url = encodeURI(url);
		}
		if (title) {
			this.params.title = title;
		}
		var param = {
			url: this.params.url,
			title: this.params.title,
			media: this.params.media
		};
		jQuery.extend(param,this.options.social);
		jQuery.ajax({
			url: this.options.url,
			type: "get",
			dataType: "json",
			data: param,
			cache: this.options.cache,
			async: this.options.async,
			timeout: this.options.timeout,
			success: this.successHandler,
			error: this.errorHandler
		});
	},
	_success: function(e) {
		if (e.status === "success") {
			this.result = e;
			this.options.success(e);
		} else {
			this._error("JSON Error.");
		}
	},
	_error: function(message) {
		if (window.console) {
			window.console.error(message);
		}
	},
	_createLink: function(service,title,url,media) {
		var val = this.socialLink[service];
		val = val.replace("%url%",url);
		val = val.replace("%title%",title);
		val = val.replace("%media%",media);
		return val;
	},
	getLink: function(service,url,title,media) {
		if (!url) {
			url = this.params.url;
		}
		if (!title) {
			title = this.params.title;
		}
		if (!media) {
			media = this.params.media;
		}
		return this._createLink(service,url,title,media);
	}
};