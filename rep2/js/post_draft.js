(function(){

var draft_cache = {};
var autosave_interval_id = null;

/**
 * �������ۑ�����
 *
 * @param {Object} form
 */
var saveDraftForm = function(form) {
	document.getElementById('post_draft_msg').innerHTML =
		(autosave_interval_id !== null ? '����' : '') + '�ۑ���...';
	post_draft(form.host.value, form.bbs.value, form.key.value, form.csrfid.value, take_kakiko_data(form),
			function(st) {
				setTimeout(function() {
					if (st == '1') {
						document.getElementById('post_draft_msg').innerHTML = '�ۑ����܂���(' +
							(function (d) {
								return d.getHours() + ':' +
									('0' + d.getMinutes().toString()).slice(-2) + ':' +
									('0' + d.getSeconds().toString()).slice(-2);
							})(new Date()) + ')';
						draft_cache = take_kakiko_data(form);
					} else {
						document.getElementById('post_draft_msg').innerHTML = '�ۑ����s';
					}
				}, 500);
			},
			function(st) {
				document.getElementById('post_draft_msg').innerHTML = '�G���[(' + st + ')';
			});
};

var post_draft = function(host, bbs, key, csrfid, data, fin, err) {
	var req = new XMLHttpRequest();
	if (!req) return;

	req.open('POST', 'post_draft.php', true);
	req.withCredentials = true;
	req.onreadystatechange = function (aEvt) {
		if (req.readyState == 4) {
			if(req.status == 200)
				fin(req.responseText);
			else
				err(req.status);
		}
	};
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send(foldl(
		function(acc, x) {
			if (x.toLowerCase() in data)
				acc.push(x + '=' + encodeURIComponent(data[x.toLowerCase()]));
			return acc;
		},
		(function() {
			var ret = [];
			var h = {'host' : host, 'bbs' : bbs, 'key' : key, 'csrfid' : csrfid};
			for (var i in h)
				ret.push(i + '=' + encodeURIComponent(h[i]));
			return ret;
		})(),
		['FROM', 'mail', 'subject', 'MESSAGE']).join('&'));
	return '';
};

var foldl = function(kons, knil, col) {
	var result = knil;
	for (var i = 0; i < col.length; i++) {
		result = kons(result, col[i]);
	}
	return result;
};

/**
 * �����������ۑ�
 *
 * @param {Object} form
 * @param {Int} interval
 */
var startAutoSave = function(form, interval) {
	if (autosave_interval_id != null) {
		if (is_kakiko_changed(form))
			document.getElementById('post_draft_msg').innerHTML = '';
		return;
	}

	draft_cache = take_kakiko_data(form);
	autosave_interval_id = setInterval(
			function () {
				if (is_kakiko_changed(form))
					saveDraftForm(form);
			},
			interval);
};

var is_kakiko_changed = function(form) {
	return (draft_cache.from !== form.FROM.value ||
			draft_cache.mail !== form.mail.value ||
			draft_cache.message !== form.MESSAGE.value ||
			(('subject' in draft_cache) && draft_cache.subject !== form.subject.value));
};

var take_kakiko_data = function(form) {
	var data = {
		from : form.FROM.value,
		mail : form.mail.value,
		message : form.MESSAGE.value
	};
	if ('subject' in form) data.subject = form.subject.value;
	return data;
};


if (!this['DraftKakiko']) DraftKakiko = {
	startAutoSave : startAutoSave,
	saveDraftForm : saveDraftForm
};

})();
