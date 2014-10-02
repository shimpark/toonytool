/**************************************************
	
	Global
	
**************************************************/
/*
세션쿠키 컨트롤러
*/
//쿠키를 굽는다.
function setCookie( name, value, expiredays ) { 
	var todayDate = new Date(); 
	if (expiredays == null){
		expiredays = 30;
	}
	// Cookie Save Timeout (1Day = 1) 
	todayDate.setDate( todayDate.getDate() + expiredays ); 
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
}
//쿠키를 가져온다.
function getCookie( name ){ 
	var nameOfCookie = name + "="; 
	var x = 0; 
	while ( x <= document.cookie.length ){ 
		var y = (x+nameOfCookie.length); 
		if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
		if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
		endOfCookie = document.cookie.length; 
		return unescape( document.cookie.substring( y, endOfCookie ) ); 
	} 
	x = document.cookie.indexOf( " ", x ) + 1; 
	if ( x == 0 ) 
	break; 
	} 
	return ""; 
}
/*
AJAX 통신 시작하는 처리
*/
$(document).ajaxStart(function(){
	//중복 클릭 방지를 위한 DIV Cover 띄움
	$body_div_cover = $("<div id='body_div_cover'></div>");
	$body_div_cover.css({
		"background-color":"#ffffff",
		"opacity":"0.4",
		"position":"fixed",
		"width":"100%",
		"height":"100%",
		"z-index":"999",
		"top":"0",
		"left":"0"
	}).appendTo("body");
	$body_loading = $("<img src='"+__URL_PATH__+"images/loading.gif' />");
	$body_loading.css({
		"position":"fixed",
		"margin-top":"20px",
		"margin-left":"20px",
		"z-index":"999",
		"top":"10px",
		"left":"10px"
	}).appendTo("body");
})
.ajaxSuccess(function(){
	$body_div_cover.remove();
	$body_loading.remove();
});
/*
jQuery-ui Datepicker 설정
*/
$(document).ready(function(){
	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
					'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월',
					'7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['ko']);
});