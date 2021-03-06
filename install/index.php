<?php
	include_once "functions.inc.php";
	$functions = new functions();

	function permission_txt($file){
		global $functions;
		if($functions->file_permission($file)){
			return "<span style='color:blue;font-size:11px;letter-spacing:-1px;padding-left:10px;'>변경 완료됨</span>";
		}else{
			return "<span style='color:red;font-size:11px;letter-spacing:-1px;padding-left:10px;'>변경되지 않음</span>";
		}
	}
	function module_check_txt($module){
		global $functions;
		if($functions->module_check($module)==TRUE){
			return "<span style='color:blue;font-size:11px;letter-spacing:-1px;padding-left:10px;'>설치됨</span>";
		}else{
			return "<span style='color:red;font-size:11px;letter-spacing:-1px;padding-left:10px;'>설치되지 않음</span>";
		}
	}
	function php_versionCheck_txt(){
		global $functions;
		if($functions->php_versionCheck()==TRUE){
			return "<span style='color:blue;font-size:11px;letter-spacing:-1px;padding-left:10px;'>5.2.0 이상의 버전 설치 완료</span>";
		}else{
			return "<span style='color:red;font-size:11px;letter-spacing:-1px;padding-left:10px;'>5.2.0 이상의 버전 설치 필요</span>";
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>투니페이퍼 투니툴 - 설치하기</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../library/js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../library/js/jquery-ui.js"></script>
<script type="text/javascript" src="../library/js/ghost_html5.js"></script>
<script type="text/javascript" src="../library/js/respond.min.js"></script>
</head>
<body>
<header>
	<img src="images/title.jpg" alt="투니툴 코어 설치" />
</header>
<form name="" action="step2.php" method="post">
<article>
	<?php
		if($functions->reinstallCheck()==TRUE){
	?>
	<div class="alert">
		<strong>Warning :</strong><br />
		이미 <strong>path.info.php</strong>, <strong>mysql.info.php</strong> 가 생성되어 있습니다.<br />
		현재 화면이 강제적으로 보여지는 경우 서버 이전, 도메인 변경등으로 info 파일이 손상된 것이므로
		아래 [다음 단계로] 를 클릭하여
		info 파일 재생성을 진행해 주시길 바랍니다.
	</div>
	<?php
		}else if($functions->file_check("../include/mysql.info.php")==TRUE&&$functions->file_check("../include/path.info.php")==FALSE){
	?>
	<div class="alert">
		<strong>Warning :</strong><br />
		<strong>path.info.php</strong>가 손상 되었으며,<br />
		이미 <strong>mysql.info.php</strong> 가 생성되어 있습니다.<br />
		info 파일 재생성을 진행해 주시길 바랍니다.
	</div>
	<?php
		}
	?>
	<div class="inner">
		<div class="t">
			<strong>1단계</strong>투니툴 파일의 퍼미션 설정 여부를 검사 합니다.
		</div>
		<div class="c">
			<?php
				if($functions->reinstallCheck()==TRUE){
			?>
			<span class="stitle">
				info 파일 손상으로 인한 info 파일 재생성을 위해선 아래 디렉토리의 권한(Permission)이 <strong>707</strong> 이상으로 설정되어 있어야 합니다.
			</span>
			<span class="tb" style="margin-bottom:10px;">
				1. <strong>include/path.info.php</strong> 파일<span class="__span_sment"><?=permission_txt("../include/path.info.php")?></span><br />
				2. <strong>include/mysql.info.php</strong> 파일<span class="__span_sment"><?=permission_txt("../include/mysql.info.php")?></span>
			</span>
			<?php
				}else{
			?>
			<span class="stitle">
				투니툴 설치를 위해선 서버 환경이 아래의 조건을 충족해야 합니다.
			</span>
			<span class="tb" style="margin-bottom:10px;">
				<strong>PHP</strong> 버전<span class="__span_sment"><?=php_versionCheck_txt()?></span><br />
				<strong>gd</strong> 추가모듈<span class="__span_sment"><?=module_check_txt("gd")?></span><br />
				<strong>mbstring</strong> 추가모듈<span class="__span_sment"><?=module_check_txt("mbstring")?></span>
			</span>
			<span class="stitle">
				투니툴 설치를 위해선 아래 디렉토리 혹은 파일의 권한(Permission)이 <strong>707</strong> 이상으로 설정되어 있어야 합니다.
			</span>
			<span class="tb">
				1. <strong>include/</strong> 디렉토리<span class="__span_sment"><?=permission_txt("../include/")?></span><br />
				2. <strong>capcha/</strong> 디렉토리<span class="__span_sment"><?=permission_txt("../capcha/")?></span><br />
				3. <strong>upload/sessionCookies/</strong> 디렉토리<span class="__span_sment"><?=permission_txt("../upload/sessionCookies/")?></span><br />
				4. <strong>upload/siteInformations/</strong> 디렉토리<span class="__span_sment"><?=permission_txt("../upload/siteInformations/")?></span><br />
				5. <strong>upload/smartEditor/</strong> 디렉토리<span class="__span_sment"><?=permission_txt("../upload/smartEditor/")?></span>
			</span>
			<?php
				}
				if($functions->reinstallCheck()==TRUE){
			?>
			<span class="stitle">
				재설치 모드인 경우 관리자 비밀번호 입력이 필요합니다.
			</span>
			<span style="display:block; text-align:center;">
				<input type="password" name="ad_password" style="width:96%; margin:10px 0;" />
			</span>
			<?php
				}
			?>
		</div>
	</div>
</article>
<footer>
	<?php
		if(($functions->reinstallCheck()==FALSE && $functions->file_permission("../include/")==TRUE && $functions->file_permission("../capcha/")==TRUE && $functions->file_permission("../upload/sessionCookies/")==TRUE && $functions->file_permission("../upload/siteInformations/")==TRUE && $functions->file_permission("../upload/smartEditor/")==TRUE && $functions->php_versionCheck()==TRUE && $functions->module_check("gd") && $functions->module_check("mbstring")) || ($functions->reinstallCheck()==TRUE && $functions->file_permission("../include/path.info.php")==TRUE && $functions->file_permission("../include/mysql.info.php")==TRUE)){
	?>
	<input type="submit" class="__button_submit" value="다음 단계로" />
	<?php
		}else{
	?>
	<input type="button" class="__button_cancel" value="다시 검사하기" onClick="document.location.reload();" />
	<?php
		}
	?>
</footer>
</form>
</body>
</html>
