<?php

/*
	[�������] Ʒ����Ʒһ������
	[���÷�Χ] ����ҳ��
*/



function ShopBrandClass(){

		global $msql,$fsql;


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		//��ַ��Ʒ��id
		if(isset($_GET["brandid"]) && $_GET["brandid"]!=""){
			$brandid=$_GET["brandid"];
		}else{
			return "ERROR: NO BRANDID";
		}

		//��ȡƷ�ƹ���catid
		$msql->query("select * from {P}_shop_brandcat where brandid='$brandid'");
		while($msql->next_record()){
			$catArr[]=$msql->f('catid');
		}

		
		$scl=" pid='0' ";

		
		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}

	

		//ģ�����
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		
		//ѭ����ʼ
		$var=array(
			'coltitle' => $coltitle
		);

		$str=ShowTplTemp($TempArr["start"],$var);

			
		$msql->query("select * from {P}_shop_cat where $scl order by xuhao");
		
		while($msql->next_record()){
				$pid=$msql->f("pid");
				$catid=$msql->f("catid");
				$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");

				if(is_array($catArr) && in_array($catid,$catArr)){
				
					$link=ROOTPATH."shop/class/?showbrandid=".$brandid."&catid=".$catid;

					$var=array (
					'link' => $link, 
					'cat' => $cat, 
					'target' => $target
					);
					$str.=ShowTplTemp($TempArr["list"],$var);
				}
		}
		
		
        $str.=$TempArr["end"];
       
		return $str;

		
}


?>