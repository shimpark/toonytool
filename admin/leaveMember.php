<?php
	$tpl = new skinController();
	$header = new skinController();
	$loop = new skinController();
	$footer = new skinController();
	$mysql = new mysqlConnection();
	$lib = new libraryClass();
	$paging = new pagingClass();
	$method = new methodController();
	
	$method->method_param("GET","page,where,keyword,order,orderby");
	
	/*
	검색 키워드 설정
	*/
	if(trim($keyword)!=""){
		$array_where = $where." LIKE '%".$keyword."%' AND me_admin!='Y' AND me_drop_regdate IS NOT NULL";
	}else{
		$array_where = "me_admin!='Y' AND me_drop_regdate IS NOT NULL";
	}
	
	/*
	정렬 기준 설정
	*/
	if(!$order){ $order = "me_drop_regdate"; }
	if(!$orderby){ $orderby = "DESC"; }
	$array_order = $order." ".$orderby;
	
	/*
	페이징 설정
	*/
	$paging_query = "
		SELECT * 
		FROM toony_member_list
		WHERE $array_where
		ORDER BY $array_order
	";
	$mysql->select($paging_query);
	$paging_query_no = $mysql->numRows();
	$paging->page_param($page);
	$total_num = $paging->setTotal($paging_query_no);
	$paging->setListPerPage(10);
	$sql = $paging->getPaggingQuery($paging_query);
	$mysql->select($sql);
	$array_total = $mysql->numRows();
	
	/*
	템플릿 로드
	*/
	$tpl->skin_file_path("admin/_tpl/leaveMember.html");
	$header->skin_html_load($tpl->skin);
	$header->skin_loop_header("[{loop_start}]");
	$loop->skin_html_load($tpl->skin);
	$loop->skin_loop_array("[{loop_start}]","[{loop_end}]");
	$footer->skin_html_load($tpl->skin);
	$footer->skin_loop_footer("[{loop_end}]");
	
	/*
	템플릿 함수
	*/
	function keyword_value_func(){
		global  $where,$keyword;
		if($where=="me_nick"||$where=="me_id"||$where=="me_login_ip"){
			return $keyword;
		}else{
			return "";
		}
	}
	function where_value_func($val){
		global $where;
		if($where==$val){
			return "selected";
		}else{
			return "";
		}
	}
	
	/*
	템플릿 치환
	*/
	//header
	$header->skin_modeling("[keyword_value]",keyword_value_func());
	$header->skin_modeling("[keyword_link_value]",urlencode($keyword));
	$header->skin_modeling("[where_value]",$where);
	$header->skin_modeling("[where_link_value]",urlencode($where));
	$header->skin_modeling("[where_value_me_nick]",where_value_func("me_nick"));
	$header->skin_modeling("[where_value_me_id]",where_value_func("me_id"));
	$header->skin_modeling("[where_value_me_login_ip]",where_value_func("me_login_ip"));
	$header->skin_modeling("[order_value]",$order);
	$header->skin_modeling("[orderby_value]",$orderby);
	echo $header->skin_echo();
	//loop
	if($array_total>0){
		$i = 0;
		do{
			$mysql->fetchArray("me_idno,me_id,me_level,me_nick,me_regdate,me_point,me_drop_regdate");
			$array = $mysql->array;
			$loop->skin_modeling("[number]",$paging->getNo($i));$i++;
			$loop->skin_modeling("[member_type]",$member_type_var[$array['me_level']]." ({$array['me_level']})");
			$loop->skin_modeling("[name]",$array['me_nick']);
			$loop->skin_modeling("[point]",number_format($array['me_point']));
			$loop->skin_modeling("[id]",$array['me_id']);
			$loop->skin_modeling("[regdate]","<span title=\"".$array['me_regdate']."\">".date("Y.m.d",strtotime($array['me_regdate']))."</span>");
			$loop->skin_modeling("[drop_regdate]","<span title=\"".$array['me_drop_regdate']."\">".date("Y.m.d",strtotime($array['me_drop_regdate']))."</span>");
			echo $loop->skin_echo();
		}while($mysql->nextRec());
	}
	//footer
	if($array_total>0){
		$footer->skin_modeling_hideArea("[{not_content_start}]","[{not_content_end}]","hide");
	}else{
		$footer->skin_modeling_hideArea("[{not_content_start}]","[{not_content_end}]","show");
	}
	$footer->skin_modeling("[paging_area]",$paging->Show(__URL_PATH__."admin/?p=leaveMember&where={$where}&keyword={$keyword}&order={$order}&orderby={$orderby}"));
	
	echo $footer->skin_echo();
?>