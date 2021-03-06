<?php
	include "../include/engine.inc.php";
	include __DIR_PATH__."include/global.php";
	
	$lib = new libraryClass();
	$mysql = new mysqlConnection();
	$method = new methodController();
	$validator = new validator();
	
	$method->method_param("POST","type,cnum,id,memo");
	$lib->security_filter("referer");
	$lib->security_filter("request_get");
	
	/**************************************************
	추가 모드인 경우
	**************************************************/
	if($type=="new"){
		/*
		검사
		*/
		$validator->validt_email("id",1,"");
		$validator->validt_null("memo","");
		$mysql->select("
			SELECT *
			FROM toony_member_list 
			WHERE me_id='$id' AND me_drop_regdate IS NULL
		");
		if($mysql->numRows()<1){
			$validator->validt_diserror("id","존재하지 않는 아이디 입니다.");
		}
		$mysql->fetchArray("me_idno,me_admin");
		$array = $mysql->array;
		$mysql->select("
			SELECT *
			FROM toony_admin_security_member
			WHERE me_id='$id';
		");
		if($mysql->numRows()>0){
			$validator->validt_diserror("id","이미 등록된 아이디 입니다.");
		}
		if($array['me_admin']=="Y"){
			$validator->validt_diserror("id","최고 관리자는 등록할 수 없습니다.");
		}
		
		/*
		DB 저장
		*/
		$mysql->query("
			INSERT INTO toony_admin_security_member
			(me_idno,me_id,memo,regdate)
			VALUES
			('{$array['me_idno']}','$id','$memo',now())
		");
		
		/*
		완료 후 리턴
		*/
		$validator->validt_success("성공적으로 추가 되었습니다.","admin/?p=blockMember");
		
	/**************************************************
	삭제 모드인 경우
	**************************************************/
	}else if($type=="delete"){
		
		if(sizeof($cnum)<1){
			$validator->validt_diserror("","하나의 항목도 선택되지 않았습니다.");
		}
		$b = 0;
		for($i=0;$i<sizeof($cnum);$i++){
			if($cnum[$i]!=""){
				/*
				DB Delete
				*/
				$mysql->query("
					DELETE FROM toony_admin_security_member
					WHERE idno='$cnum[$i]'
				");
			}
			$b++;
		}
		
		/*
		완료 후 리턴
		*/
		$validator->validt_success($b."건이 성공적으로 삭제 되었습니다.","admin/?p=blockMember");
	}
	
	
?>