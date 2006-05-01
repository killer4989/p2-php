// textareaの高さをライブ調節する
function adjustTextareaRows(obj, org, plus) {
	var brlen = null;
	if (obj.wrap) {
		if (obj.wrap == 'virtual' || obj.wrap == 'soft') {
			brlen = obj.cols;
		}
	}
	var aLen = countLines(obj.value, brlen);
	var aRows = aLen + plus;
	var move = 0;
	var scroll = 14;
	if (org) {
		if (aRows > org + plus) {
			if (obj.rows < aRows) {
				move = (aRows - obj.rows) * scroll;
			} else if (obj.rows > aRows) {
				move = (aRows - obj.rows) * -scroll;
			}
			if (move != 0) {
				if (move < 0) {
					window.scrollBy(0, move);
				}
				obj.rows = aRows;
				if (move > 0) {
					window.scrollBy(0, move);
				}
			}
			
		}
	} else if (obj.rows < aRows) {
		move = (aRows - obj.rows) * scroll;
		obj.rows = aRows;
		window.scrollBy(0, move);
	}
}

/**
 * \n を改行として行数を数える
 *
 * @param integer brlen 改行する文字数。無指定なら文字数で改行しない
 */
function countLines(str, brlen) {
	var lines = str.split("\n");
	var count = lines.length;
	var aLen = 0;
	for (var i = 0; i < lines.length; i++) {
		aLen = jstrlen(lines[i]);
		if (brlen) {
			var adjust =  1.15; // 単語単位の折り返しに対応していないのでアバウト調整
			if ((aLen * adjust) > brlen) {
				count = count + Math.floor((aLen * adjust) / brlen);
			}
		}
	}
	return count;
}

// 文字列をバイト数で数える
function jstrlen(str) {
	var len = 0;
	str = escape(str);
	for (var i = 0; i < str.length; i++, len++) {
		if (str.charAt(i) == "%") {
			if (str.charAt(++i) == "u") {
				i += 3;
				len++;
			}
			i++;
		}
	}
	return len;
}

// (対象がdisableでなければ) フォーカスを合わせる
function setFocus(ID){
	if (obj = document.getElementById(ID)) {
		if (obj.disabled != true) {
			obj.focus();
		}
	}
}

// sageチェックに合わせて、メール欄の内容を書き換える
function mailSage(){
	if (cbsage = document.getElementById('sage')) {
		if (mailran = document.getElementById('mail')) {
			if (cbsage.checked == true) {
				mailran.value = "sage";
			} else {
				if (mailran.value == "sage") {
					mailran.value = "";
				}
			}
		}
	}
}

// メール欄の内容に応じて、sageチェックをON OFFする
function checkSage(){
	if (mailran = document.getElementById('mail')) {
		if (cbsage = document.getElementById('sage')) {
			if (mailran.value == "sage") {
				cbsage.checked = true;
			} else {
				cbsage.checked = false;
			}
		}
	}
}

/*
// 自動で読み込むことにしたので、使わない

// 前回の書き込み内容を復帰する
function loadLastPosted(from, mail, message){
	if (fromran = document.getElementById('FROM')) {
		fromran.value = from;
	}
	if (mailran = document.getElementById('mail')) {
		mailran.value = mail;
	}
	if (messageran = document.getElementById('MESSAGE')) {
		messageran.value = message;
	}
	checkSage();
}
*/
