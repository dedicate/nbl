<?php

/*
	[插件名称] 模块导航条
*/


function ShopNavPath(){

	global $msql;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];

	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);


	$var=array (
		'coltitle' => $coltitle,
		'sitename' => $GLOBALS["CONF"]["SiteName"]
	);

	$str=ShowTplTemp($TempArr["start"],$var);

	//显示模块频道名称
	if($GLOBALS["SHOPCONF"]["ChannelNameInNav"]=="1"){
		$var=array (
			'channel' => $GLOBALS["SHOPCONF"]["ChannelName"]
		);

		$str.=ShowTplTemp($TempArr["col"],$var);

		//页头标题
		$GLOBALS["pagetitle"]=$GLOBALS["SHOPCONF"]["ChannelName"];
	}
	

	//不同页面名称显示不同的第三节导航
	if($pagename=="query"){
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
				$nowcatid=$Arr[0];
			}elseif($_GET["catid"]>0){
				$nowcatid=$_GET["catid"];
			}else{
				$nowcatid=0;
			}
			
			$msql->query("select catpath from {P}_shop_cat where catid='$nowcatid'");
			if($msql->next_record()){
				$catpath=$msql->f('catpath');
			}
				$array=explode(":",$catpath);
				$cpnums=sizeof($array)-1;
				for($i=0;$i<$cpnums;$i++){
					$arr=$array[$i]+0;
					$msql->query("select * from {P}_shop_cat where catid='$arr'");
					while($msql->next_record()){
						$catid=$msql->f('catid');
						$cat=$msql->f('cat');
						$ifchannel=$msql->f('ifchannel');
							if($ifchannel=="1"){
								$url=ROOTPATH."shop/class/".$catid."/";
							}else{
								if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$catid.".html")){
									$url=ROOTPATH."shop/class/".$catid.".html";
								}else{
									$url=ROOTPATH."shop/class/?".$catid.".html";
								}
							}
							
							
							$var=array (
							'nav' => $cat,
							'url' => $url
							);
							$str.=ShowTplTemp($TempArr["list"],$var);

							$GLOBALS["pagetitle"].="-".$cat;
						
					}
				
			  }
	}


	if($pagename=="detail"){
			
			//获取地址栏参数
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
				$id=$idArr[0];
			}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
				$id=$_GET["id"];
			}
			$msql->query("select title from {P}_shop_con where id='$id'");
			if($msql->next_record()){
				$title=$msql->f('title');
			}
			$var=array (
			'nav' => $title
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$title;
	}

	if($pagename=="brand" || $pagename=="brandquery"){
			
			$var=array (
			'nav' => "品牌查询"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="品牌查询";
	}

	if($pagename=="cart"){
			
			$var=array (
			'nav' => "购物车"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="购物车";
	}

	if($pagename=="startorder"){
			
			$var=array (
			'nav' => "商品订购"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="商品订购";
	}
	if($pagename=="shoporderpay"){
			
			$var=array (
			'nav' => "订单付款"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="订单付款";
	}
	if($pagename=="shoporderdetail"){
			
			$var=array (
			'nav' => "查看订单"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="查看订单";
	}

	if(substr($pagename,0,6)=="class_"){
			$var=array (
			'nav' => $GLOBALS["PSET"]["name"],
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$GLOBALS["PSET"]["name"];
	}

	if($pagename=="branddetail"){
			
			//获取地址栏参数
			if(isset($_GET["brandid"]) && $_GET["brandid"]!=""){
				$brandid=$_GET["brandid"];
			}
			$msql->query("select brand from {P}_shop_brand where id='$brandid'");
			if($msql->next_record()){
				$brand=$msql->f('brand');
			}
			$var=array (
			'nav' => $brand
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$brand;
	}


	

	$str.=$TempArr["end"];
	return $str;
}

?>