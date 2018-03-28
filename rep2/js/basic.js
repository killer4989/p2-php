/* rep2 - ��{JavaScript�t�@�C�� */

var rep2 = { 'util': {}, 'info': {}, 'menu': {}, 'read': {}, 'subject': {} };

// �T�u�E�B���h�E���|�b�v�A�b�v����
rep2.util.openSubWindow = function (inUrl, inWidth, inHeight, boolS, boolR, boolW) {
	var proparty3rd = "width=" + inWidth + ",height=" + inHeight + ",scrollbars=" + boolS + ",resizable=1";
	SubWin = window.open(inUrl,"",proparty3rd);
	if (boolR == 1) {
		SubWin.resizeTo(inWidth,inHeight);
	}
	SubWin.focus();
	if (boolW) {
		return SubWin;
	}
	return false;
};

var OpenSubWin = rep2.util.openSubWindow;

// HTML�h�L�������g�̃^�C�g�����Z�b�g����
rep2.util.setWindowTitle = function () {
	if (top != self) {
		try {
			top.document.title = self.document.title;
		} catch (e) {
			// �������Ȃ�
		}
	}
};

var setWinTitle = rep2.util.setWindowTitle;

// DOM�I�u�W�F�N�g���擾
var p2GetElementById = document.getElementById;

/**
 * objHTTP ��url��n���āA���ʃe�L�X�g���擾����
 *
 * @param nc string ������L�[�Ƃ����L���b�V������̂��߂̃N�G���[���ǉ������
 */
function getResponseTextHttp(objHTTP, url, nc)
{
	if (nc) {
		url = url + '&' + nc + '=' + (new Date()).getTime(); // �L���b�V�����p
	}
	objHTTP.open('GET', url, false);
	objHTTP.send(null);
	
	if (objHTTP.readyState == 4) {
		if (objHTTP.status == 200) {
			return objHTTP.responseText;
		} else {
			// rt = '<em>HTTP Error:<br />' + req.status + ' ' + req.statusText + '</em>';
		}
	}
	
	return '';
}

/**
 * DOM���[�h���Ɏ��s�����֐���o�^����B
 *
 * �Â��u���E�U��DOMContentLoaded�Ɠ����̃^�C�~���O�ɂ͂������Ȃ��B
 * rep2�̓t���[�����g���̂�IE�̏ꍇ��jQuery.bindReady()�̂悤�ȋZ���g���Ȃ��B
 * �����defer��������script�v�f�ł��̊֐����Ăяo���X�N���v�g��ǂݍ��ށB
 *
 * @param {Function} callback
 * @param {String} filename
 * @return void
 */
function p2BindReady(callback, filename)
{
	var i, version = 0, isOpera = false, isWebKit = false;

	i = navigator.userAgent.indexOf('AppleWebKit/');
	if (i != -1) {
		isWebKit = true;
		version = parseFloat(navigator.userAgent.substring(i + 12));
	} else if (window.opera && window.opera.version) {
		isOpera = true;
		version = parseFloat(window.opera.version());
	}

	if (!isFinite(version)) {
		// Unknown
	} else if (isWebKit && version < 525) {
		// Safari < 3.1
	} else if (isOpera && version < 9) {
		// Opera < 9
	} else if (window.addEventListener) {
		if (isOpera) {
			// Opera��DOMContentLoaded����X�^�C���v�Z�����܂�
			// �x��������悤�Ȃ̂ŁA1/40�b�قǑ҂��Ă݂�
			document.addEventListener('DOMContentLoaded', (function (f) {
				return function (event) {
					document.removeEventListener(event.type, arguments.callee, false);
					window.setTimeout(f, 25);
				};
			})(callback), false);
		} else {
			document.addEventListener('DOMContentLoaded', (function (f) {
				return function (event) {
					document.removeEventListener(event.type, arguments.callee, false);
					f();
				};
			})(callback), false);
		}
		return;
	} else if (document.all && filename) { 
		document.write('<script type="text/javascript" src="' + filename + '" defer></script>');
		return;
	} else if (window.attachEvent) {
		window.attachEvent('onload', callback);
		return;
	}

	if (typeof window.onload == 'function') {
		var oldonload = window.onload;
		window.onload = function() {
			oldonload();
			callback();
		};
	} else {
		window.onload = callback;
	}
}

// �E�C���h�E�̑傫����}�E�X�̈ʒu���擾���邽�߂̊֐��Q
var parsePixels, isStaticLayout;
var getCurrentStyle, getTargetNode;
var getWindowWidth, getWindowHeight, getWindowSize;
var getScrollX, getScrollY, getScrollXY;
var getOffsetX, getOffsetY, getOffsetXY;
var getLayerX, getLayerY, getLayerXY;
var getPageX, getPageY, getPageXY;

// {{{ parsePixels(), isStaticLayout()

parsePixels = function(value) {
	var n = 0;

	switch (typeof value) {
		case 'number':
			n = Math.floor(value);
			break;
		case 'string':
			if (value.length > 2 && value.indexOf('px') === value.length - 2) {
				n = parseInt(value);
				if (!isFinite(n)) {
					n = 0;
				}
			}
			break;
	}

	return n;
};

isStaticLayout = function(element) {
	switch (getCurrentStyle(element).position) {
		case 'absolute':
		case 'relative':
		case 'fixed':
			return false;
		default:
			return true;
	}
};

// }}}
// {{{ getCurrentStyle(), getTargetNode(), getScrollXY()

if (document.all && !window.opera) {
	// {{{ IE

	getCurrentStyle = function(element) {
		return element.currentStyle;
	};

	getTargetNode = function(event) {
		var target = event.srcElement;
		while (target.nodeType !== 1) {
			target = target.parentNode;
		}
		return target;
	};

	if (document.compatMode === 'BackCompat') {
		getScrollX = function() { return document.body.scrollLeft; };
		getScrollY = function() { return document.body.scrollTop; };
		getScrollXY = function() {
			return [document.body.scrollLeft, document.body.scrollTop];
		};
	} else {
		getScrollX = function() { return document.documentElement.scrollLeft; };
		getScrollY = function() { return document.documentElement.scrollTop; };
		getScrollXY = function() {
			return [document.documentElement.scrollLeft, document.documentElement.scrollTop];
		};
	}

	// }}}
} else {
	// {{{ Others

	getCurrentStyle = function(element) {
		return document.defaultView.getComputedStyle(element, '');
	};

	getTargetNode = function(event) {
		var target = event.target;
		while (target.nodeType !== 1) {
			target = target.parentNode;
		}
		return target;
	};

	if (typeof window.scrollX === 'number') {
		getScrollX = function() { return window.scrollX; };
		getScrollY = function() { return window.scrollY; };
		getScrollXY = function() {
			return [window.scrollX, window.scrollY];
		};
	} else {
		getScrollX = function() { return window.pageXOffset; };
		getScrollY = function() { return window.pageYOffset; };
		getScrollXY = function() {
			return [window.pageXOffset, window.pageYOffset];
		};
	}

	// }}}
}

// }}}
// {{{ getWindowWidth(), getWindowHeight(), getWindowSize()

if (typeof document.compatMode === 'undefined') {
	// Safari <= 2.x, etc.
	getWindowWidth  = function() { return window.innerWidth; };
	getWindowHeight = function() { return window.innerHeight; };
	getWindowSize = function() {
		return [window.innerWidth, window.innerHeight, document.width, document.height];
	};
} else if (document.compatMode === 'BackCompat') {
	// Backward Compatibility Mode
	getWindowWidth  = function() { return document.body.clientWidth; };
	getWindowHeight = function() { return document.body.clientHeight; };
	getWindowSize = function() {
		return [document.body.clientWidth, document.body.clientHeight,
		        document.body.scrollWidth, document.body.scrollHeight];
	};
} else {
	// Standard Mode
	getWindowWidth  = function() { return document.documentElement.clientWidth; };
	getWindowHeight = function() { return document.documentElement.clientHeight; };
	getWindowSize = function() {
		return [document.documentElement.clientWidth, document.documentElement.clientHeight,
		        document.documentElement.scrollWidth, document.documentElement.scrollHeight];
	};
}

// }}}
// {{{ getOffsetXY(), getLayerXY(), getPageXY()

// Common
getOffsetX = function(event) { return event.offsetX; };
getOffsetY = function(event) { return event.offsetY; };
getOffsetXY = function(event) {
	return [event.offsetX, event.offsetY];
};

getLayerX = function(event) { return event.layerX; };
getLayerY = function(event) { return event.layerY; };
getLayerXY = function(event) {
	return [event.layerX, event.layerY];
};

getPageX = function(event) { return event.pageX; };
getPageY = function(event) { return event.pageY; };
getPageXY = function(event) {
	return [event.pageX, event.pageY];
};

if (window.opera) {
	// {{{ Opera

	getOffsetX = function(event) { return getOffsetXY(event)[0]; };
	getOffsetY = function(event) { return getOffsetXY(event)[1]; };
	getOffsetXY = function(event) {
		var style = getCurrentStyle(getTargetNode(event));
		return [event.offsetX + parsePixels(style.borderLeftWidth) + parsePixels(style.paddingLeft),
		        event.offsetY + parsePixels(style.borderTopWidth)  + parsePixels(style.paddingTop)];
	};

	getLayerX = function(event) { return getLayerXY(event)[0]; };
	getLayerY = function(event) { return getLayerXY(event)[1]; };
	getLayerXY = function(event) {
		var target = getTargetNode(event);
		var offset = getOffsetXY(event);
		if (isStaticLayout(target) && target.offsetParent) {
			offset[0] += target.offsetLeft;
			offset[1] += target.offsetTop;
		}
		return offset;
	};

	// }}}
} else if (document.all) {
	// {{{ IE

	getOffsetX = function(event) { return getOffsetXY(event)[0]; };
	getOffsetY = function(event) { return getOffsetXY(event)[1]; };
	getOffsetXY = function(event) {
		var style = getCurrentStyle(getTargetNode(event));
		return [event.offsetX + parsePixels(style.borderLeftWidth),
		        event.offsetY + parsePixels(style.borderTopWidth)];
	};

	getLayerX = function(event) { return getLayerXY(event)[0]; };
	getLayerY = function(event) { return getLayerXY(event)[1]; };
	getLayerXY = function(event) {
		var target = getTargetNode(event);
		var offset = getOffsetXY(event);
		if (isStaticLayout(target) && target.offsetParent) {
			offset[0] += target.offsetLeft;
			offset[1] += target.offsetTop;
		}
		return offset;
	};

	getPageX = function(event) {
		return event.clientX + getScrollX();
	};
	getPageY = function(event) {
		return event.clientY + getScrollY();
	};
	getPageXY = function(event) {
		return [event.clientX + getScrollX(), event.clientY + getScrollY()];
	};

	// }}}
} else if (navigator.userAgent.indexOf('AppleWebKit') === -1) {
	// {{{ Firefox and other non WebKit browsers

	getOffsetX = function(event) { return getOffsetXY(event)[0]; };
	getOffsetY = function(event) { return getOffsetXY(event)[1]; };
	getOffsetXY = function(event) {
		var target = getTargetNode(event);
		var offsetX = event.layerX;
		var offsetY = event.layerY;
		if (isStaticLayout(target) && target.offsetParent) {
			var style = getCurrentStyle(target.offsetParent);
			offsetX -= target.offsetLeft + parsePixels(style.borderLeftWidth);
			offsetY -= target.offsetTop  + parsePixels(style.borderTopWidth);
		}
		return [offsetX, offsetY];
	};

	// }}}
}

// }}}

// prototype.js 1.4.0 : string.js : escapeHTML ���������C�i�[��
// IE6 �W�����[�h�΍�ŉ��s�R�[�h�� CR+LF �ɓ���
/*  Prototype JavaScript framework, version 1.4.0
 *  (c) 2005 Sam Stephenson <sam@conio.net>
 *
 *  Prototype is freely distributable under the terms of an MIT-style license.
 *  For details, see the Prototype web site: http://prototype.conio.net/
 */
function escapeHTML(cont)
{
	return document.createElement('div').appendChild(document.createTextNode(cont)).parentNode.innerHTML;
}

/**
 * @return  object
 */
function getDocumentBodyIE()
{
	return (document.compatMode=='CSS1Compat') ? document.documentElement : document.body;
}

function setWindowOnLoad(callback)
{
	if (typeof window.onload == 'function') {
		var oldonload = window.onload;
		window.onload = function() {
			oldonload();
			callback();
		};
	} else {
		window.onload = callback;
	}
}

/*
 * Local Variables:
 * mode: javascript
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: t
 * End:
 */
/* vim: set syn=javascript fenc=cp932 ai noet ts=4 sw=4 sts=4 fdm=marker: */
