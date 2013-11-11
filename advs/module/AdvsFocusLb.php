<?php

/*
	[插件名称] 轮播广告(可共享设置) 
	[适用范围] 全站
*/

function AdvsFocusLb () { 

	global $msql;

	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$w=$GLOBALS["PLUSVARS"]["w"];
	$h=$GLOBALS["PLUSVARS"]["h"];
	//模版解释
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	$str=$TempArr["start"];

	$pics="";
	$titles="";
	$m=0;
	$msql->query("select * from {P}_advs_lb  where groupid='$groupid' order by xuhao limit 0,$shownums");
	while($msql->next_record()){
		$src=$msql->f('src');
		$url=$msql->f('url');
		$title=$msql->f('title');
		if($url=="http://" || $url==""){
		}
		else{
			if(!strchr($url,htmlspecialchars("http://")))
			$url=htmlspecialchars("http://").$url;
		}
		$src=ROOTPATH.$src;
		if($m==0)
			$pics.="<div class='img dpn' style='z-index:2'><a href='".$url."' target='_blank'><img src='".$src."' border='0' /></a></div>";
		else
			$pics.="<div class='img dpn'><a href='".$url."' target='_blank'><img src='".$src."' border='0' /></a></div>";
		$titles.="<li><a href='".$url."' target='_blank'>".$title."</a></li>";
		$m++;
	}

	$var=array(
		'pics' => $pics
	);

	$str.=ShowTplTemp($TempArr["m0"],$var);
	
	$str.=$TempArr["m1"];

	$var=array(
		'titles' => $titles
	);

	$str.=ShowTplTemp($TempArr["list"],$var);

	$str.=$TempArr["end"];
	return $str;
	
}
?>