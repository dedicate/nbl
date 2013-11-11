<?php

define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");

global $SiteUrl;

$act = $_GET['act'];
$first = $_GET['first'];
if($act=='setpic'){

	$id=intval($_GET['id']);
	if($first == 'first'){
		$fsql->query("select * from {P}_shop_con where id='$id'");
		if($fsql->next_record()){
				
			$id=$fsql->f('id');
			$src=$fsql->f('src');
		
		$src=ROOTPATH.$src;
		
		$picinfo = "<img id='bigimg' class='bigimg' src='".$src."' width='280' height='280' />";
		}
	}else{
		$fsql->query("select * from {P}_shop_pages where id='$id'");
		if($fsql->next_record()){
			
		$src=$fsql->f('src');
	
		$src=ROOTPATH.$src;
	
		$picinfo = "<img id='bigimg' class='bigimg' src='".$src."' width='280' height='280' />";
		}
	}
	
	echo $picinfo;

}
if($act=='setbody'){

	$id=intval($_GET['id']);

	$fsql->query("select * from {P}_shop_con where id='$id'");
	if($fsql->next_record()){
		$id=$fsql->f('id');
		$memo=$fsql->f('memo');
	}else{
		$fsql->query("select * from {P}_shop_pages where id='$id'");
		if($fsql->next_record())
		$memo=$fsql->f('memo');
	}
		
	echo $memo;

}

?>