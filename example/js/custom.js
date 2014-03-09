'use strict';

hljs.tabReplace = '    ';
hljs.lineNodes = true;
hljs.initHighlightingOnLoad();

$(window).keydown(function(e) {
	switch(e.keyCode) {
		case 37:
		case 72:
			if($('.bar .new a')[0] != undefined)
				$('.bar .new a')[0].click();
			break;
		case 39:
		case 76:
			if($('.bar .old a')[0] != undefined)
				$('.bar .old a')[0].click();
			break;
		case 74:
			scrollBy(0, 40);
			break;
		case 75:
			scrollBy(0, -40);
			break;
	}
});