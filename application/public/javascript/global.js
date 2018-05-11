/* original js */

var scrollDivRect = {
	'x' : 0,
	'y' : 0,
	'threshold_h' : 0,
	'getXY':function(el) {
		var _y = el.getBoundingClientRect().top + document.body.scrollTop;
		var _x = el.getBoundingClientRect().left + document.body.scrollLeft;
		return {x:_x,y:_y};
		},
	'getMyDivXY':function(el) {
		this.y = this.getXY(el).y;
		return this.y;
	},
	'addEvent': function(w, t, fn, useCapture) {
		if(w.addEventListener) {
			w.addEventListener(t, fn, useCapture);
			return true;
		} else if(w.attachEvent) {
			var r = w.attachEvent('on'+t, fn);
			return r;
		} else {
			w['on'+t] = fn;
		}
	},
	'checkFloat':function(el) {
		var windowScrollTop = document.body.scrollTop;
		//console.log(windowScrollTop+'@@@@@@@@@@@'+$(window).scrollTop());
		if(this.y == 0) {
		    this.y = this.getMyDivXY(el);
		}
		//console.log(windowScrollTop+'__________'+this.y);
		
		if(windowScrollTop > this.y) {
			if(windowScrollTop >= this.threshold) {
				el.style.cssText = "position:absolute; bottom:0px";
			} else {
				el.style.cssText = "position:fixed; top:"+this.y+"px";
			}    
		} else {
		    el.style.cssText = "";
		}
	}

}
// window.onload=function(){
// 	var floatDiv = document.getElementById('aside');
// 	var mainDiv = document.getElementById('main');
// 	scrollDivRect.threshold = mainDiv.offsetHeight - floatDiv.offsetHeight;
// 	scrollDivRect.getMyDivXY(floatDiv);
//     scrollDivRect.addEvent(window, 'scroll', function(){scrollDivRect.checkFloat(floatDiv)});
// }
function showTool()
{
    var w = document.body.clientWidth;
   	var s = window.location.pathname;
    if (w < 500 || s.indexOf('posts-') > -1){
        document.getElementById('aside').style.display = 'none';
    }
    else{
        document.getElementById('aside').style.display = 'block';
    }
	if(w < 500) {
		document.getElementById('main_bg').style.width = '90%';
	} else {
		document.getElementById('main_bg').style.width = '70%';
	}
        
}
function search() {
	var keywords = $('#search_txt').val();
    var url = '/search.html?s='+keywords;
    window.location.href = url;
}
