<?php
	include "../../../include/engine.inc.php";
	include __DIR_PATH__."include/global.php";
	
	$lib = new libraryClass();
	$mysql = new mysqlConnection();
	$method = new methodController();
	$validator = new validator();
	
	$method->method_param("POST","type,board_id,skin,name,use_list,use_m_list,use_secret,use_comment,use_likes,use_reply,use_category,category,use_file1,use_file2,file_limit,list_limit,list_m_limit,length_limit,length_m_limit,array_level,write_level,secret_level,comment_level,delete_level,read_level,controll_level,reply_level,write_point,read_point,top_file,top_source,bottom_file,bottom_source,thumb_width,thumb_m_width,thumb_height,thumb_m_height,articleIMG_width,articleIMG_m_width,articleIMG_height,articleIMG_m_height,article_length,article_m_length,ico_file_p,ico_file_m,ico_mobile_p,ico_mobile_m,ico_secret_p,ico_secret_m,ico_secret_def,ico_new_p,ico_new_m,ico_new_def,ico_hot_def_v,ico_hot_def_r,ico_hot_def_type,ico_hot_p,ico_hot_m,tc_1,tc_2,tc_3,tc_4,tc_5");
	$lib->security_filter("referer");
	$lib->security_filter("request_get");
	
	/*
	검사
	*/
	if($type=="new"){
		$mysql->select("
			SELECT *
			FROM toony_module_board_config
			WHERE board_id='$board_id'
		");
		if($mysql->numRows()>0){
			$validator->validt_diserror("board_id","이미 존재하는 코드입니다.");
		}
		$validator->validt_idx("board_id",1,"");
	}
	$validator->validt_null("name","");
	$validator->validt_number("list_limit",1,10,1,"");
	$validator->validt_number("list_m_limit",1,10,1,"");
	$validator->validt_number("length_limit",1,10,1,"");
	$validator->validt_number("length_m_limit",1,10,1,"");
	$validator->validt_number("file_limit",1,10,1,"");
	$validator->validt_number("article_length",1,10,1,"");
	$validator->validt_number("article_m_length",1,10,1,"");
	$validator->validt_number("write_point",1,10,1,"");
	$validator->validt_number("read_point",1,10,1,"");
	$validator->validt_number("thumb_width",1,10,1,"");
	$validator->validt_number("thumb_m_width",1,10,1,"");
	$validator->validt_number("thumb_height",1,10,1,"");
	$validator->validt_number("thumb_m_height",1,10,1,"");
	$validator->validt_number("articleIMG_width",1,10,1,"");
	$validator->validt_number("articleIMG_m_width",1,10,1,"");
	$validator->validt_number("articleIMG_height",1,10,1,"");
	$validator->validt_number("articleIMG_m_height",1,10,1,"");
	$validator->validt_number("ico_new_def",1,10,1,"");
	$validator->validt_number("ico_hot_def_v",1,10,1,"");
	$validator->validt_number("ico_hot_def_r",1,10,1,"");
	
	/*
	홈페이지, 모바일페이지 각각의 옵션 설정값을 하나의 필드로 결합
	*/
	$use_list = $use_list."|".$use_m_list;
	$list_limit = $list_limit."|".$list_m_limit;
	$length_limit = $length_limit."|".$length_m_limit;
	$article_length = $article_length."|".$article_m_length;
	$thumb_width = $thumb_width."|".$thumb_m_width;
	$thumb_height = $thumb_height."|".$thumb_m_height;
	$articleIMG_width = $articleIMG_width."|".$articleIMG_m_width;
	$articleIMG_height = $articleIMG_height."|".$articleIMG_m_height;
	$top_file = $top_file."{||||||||||}".$top_m_file;
	$bottom_file = $bottom_file."{||||||||||}".$bottom_m_file;
	$top_source = $top_source."{||||||||||}".$top_m_source;
	$bottom_source = $bottom_source."{||||||||||}".$bottom_m_source;
	$ico_file = $ico_file_p."|".$ico_file_m;
	$ico_mobile = $ico_mobile_p."|".$ico_mobile_m;
	$ico_secret = $ico_secret_p."|".$ico_secret_m;
	$ico_new = $ico_new_p."|".$ico_new_m;
	$ico_hot = $ico_hot_p."|".$ico_hot_m;
	$ico_hot_def = $ico_hot_def_v."|".$ico_hot_def_type."|".$ico_hot_def_r;
	
	/**************************************************
	추가 모드인 경우
	**************************************************/
	if($type=="new"){
		/*
		DB입력
		*/
		include_once __DIR_PATH__."modules/board/install/board_create.php";
		$mysql->query($db_toony_module_board_config_insert); //게시판 정보 테이블에 정보 기록
		$mysql->query($db_toony_module_board_create_board); //게시판 테이블 생성
		$mysql->query($db_toony_module_board_create_board_comment); //게시판 덧글 테이블 생성
		/*
		완료 후 리턴
		*/
		$validator->validt_success("게시판을 성공적으로 생성 하였습니다.","admin/?m=board&p=boardList");
	}
	
	/**************************************************
	수정 모드인 경우
	**************************************************/
	if($type=="modify"){
		/*
		DB수정
		*/
		$mysql->query("
			UPDATE toony_module_board_config
			SET skin='$skin',name='$name',use_secret='$use_secret',use_list='$use_list',use_category='$use_category',category='$category',use_comment='$use_comment',use_likes='$use_likes',use_reply='$use_reply',use_file1='$use_file1',use_file2='$use_file2',file_limit='$file_limit',list_limit='$list_limit',length_limit='$length_limit',array_level='$array_level',write_level='$write_level',secret_level='$secret_level',comment_level='$comment_level',delete_level='$delete_level',read_level='$read_level',controll_level='$controll_level',reply_level='$reply_level',write_point='$write_point',read_point='$read_point',top_file='$top_file',top_source='$top_source',bottom_file='$bottom_file',bottom_source='$bottom_source',thumb_width='$thumb_width',thumb_height='$thumb_height',articleIMG_width='$articleIMG_width',articleIMG_height='$articleIMG_height',article_length='$article_length',ico_file='$ico_file',ico_mobile='$ico_mobile',ico_secret='$ico_secret',ico_secret_def='$ico_secret_def',ico_new='$ico_new',ico_new_def='$ico_new_def',ico_hot='$ico_hot',ico_hot_def='$ico_hot_def',tc_1='$tc_1',tc_2='$tc_2',tc_3='$tc_3',tc_4='$tc_4',tc_5='$tc_5'
			WHERE board_id='$board_id'
		");
		
		/*
		완료 후 리턴
		*/
		$validator->validt_success("성공적으로 수정 하였습니다.","admin/?m=board&p=boardList_modify&type=modify&act={$board_id}");
	
	/**************************************************
	삭제 모드인 경우
	**************************************************/
	}else if($type=="delete"){
		/*
		검사
		*/
		$mysql->select("
			SELECT board_id
			FROM toony_module_board_config
			WHERE board_id='$board_id';
		");
		if($mysql->numRows()<1){
			$validator->validt_diserror("","게시판이 존재하지 않습니다.");
		}
		
		/*
		DB삭제
		*/
		$mysql->query("
			DROP TABLE toony_module_board_data_$board_id
		");
		$mysql->query("
			DROP TABLE toony_module_board_comment_$board_id
		");
		$mysql->query("
			DELETE FROM toony_module_board_config
			WHERE board_id='$board_id'
		");
		
		/*
		첨부파일 모두 삭제
		*/
		$path = __DIR_PATH__."modules/board/upload/".$board_id;
		if(is_dir($path)){
			$arr = array();
			$dir = opendir($path);
			while($file = readdir($dir)){
				if($file=='.'||$file=='..'){
					continue;
				}else{
					unlink($path."/".$file);
				}
			}
			closedir($dir);
			rmdir($path);
		}
		
		/*
		완료 후 리턴
		*/
		$validator->validt_success("게시판을 성공적으로 삭제 하였습니다.","admin/?m=board&p=boardList");
	}
	
?>