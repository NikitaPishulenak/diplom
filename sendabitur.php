	
	
	
	
	if ($fc==2){
	$facultet=1;
	mysql_select_db("admx");
	$sql1=mysql_query("SELECT `monid` FROM `db_abby_monid` WHERE `faculty_id`=2 AND `time_form_id`=1");
	$monitoring=mysql_result($sql1,0);
	$sql="SELECT SUM(  `plan` ) FROM  `db_plancell` WHERE  `faculty_id` = 2";
	$celev= mysql_result(mysql_query($sql),0);
	$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =1 AND  `edu_form_id` =1 AND `faculty_id` = 2";
	$plan= mysql_result(mysql_query($sql),0);
	
	/////////////////////////////////////////////////////////
	$tot_sum[1]=0;
	$tot_sum[2]=0;
	$tot_sum[3]=0;
	$tot_sum[4]=0;
		for($d=400;$d>81;$d=$d-10){
			$dd=$d-9;
			$count=0;
			for($t=0;$t<$i-1;$t++){
				if($line[$t]['total']<=$d && $line[$t]['total']>=$dd && $line[$t]['edu_form']==1 && $line[$t]['target']==3 && $line[$t]['target_type']==1 && $line[$t]['target_cell']==0 && $line[$t]['faculty']==2){$count++;}
				
			}
			$mas[1].='{"category":1,"diap_start":'.$dd.',"diap_end":'.$d.',"count":'.$count.'},';
			$tot_sum[1]+=$count;	
		}
				
			$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=80 && $line[$t]['total']>=70  && $line[$t]['target']==3 && $line[$t]['edu_form']==1 &&  $line[$t]['target_type']==1 && $line[$t]['target_cell']==0 && $line[$t]['faculty']==2){$count++;}
		}
		$mas[1].='{"category":1,"diap_start":70,"diap_end":80,"count":'.$count.'},';	
		$tot_sum[1]+=$count;
		$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=69 && $line[$t]['total']>0  && $line[$t]['target']==3 && $line[$t]['edu_form']==1 &&  $line[$t]['target_type']==1 && $line[$t]['target_cell']==0 && $line[$t]['faculty']==2){$count++;}
		}
		$mas[1].='{"category":1,"diap_start":0,"diap_end":69,"count":'.$count.'},';	
		$tot_sum[1]+=$count;
		///////////////////////////////////////////////////
		for($d=400;$d>81;$d=$d-10){
			$dd=$d-9;
			$count=0;
			for($t=0;$t<$i-1;$t++){
				if($line[$t]['total']<=$d && $line[$t]['total']>=$dd && $line[$t]['target']==1 && $line[$t]['edu_form']==1 &&  $line[$t]['faculty']==2){$count++;}
			}
			$mas[2].='{"category":2,"diap_start":'.$dd.',"diap_end":'.$d.',"count":'.$count.'},';	
			$tot_sum[2]+=$count;
		}
				
			$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=80 && $line[$t]['total']>=70  && $line[$t]['target']==1 &&  $line[$t]['edu_form']==1 &&  $line[$t]['faculty']==2){$count++;}
		}
		$mas[2].='{"category":2,"diap_start":70,"diap_end":80,"count":'.$count.'},';	
		$tot_sum[2]+=$count;
		$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=69 && $line[$t]['total']>0  && $line[$t]['target']==1 && $line[$t]['edu_form']==1 &&  $line[$t]['faculty']==2){$count++;}
		}
		$mas[2].='{"category":2,"diap_start":0,"diap_end":69,"count":'.$count.'}';	
		$tot_sum[2]+=$count;
		///////////////////////////////////////////////////
		$totsum=$tot_sum[2]+$tot_sum[1];
		$head='{"method":"updateMonitoring",
			"params":{  "login":"'.$login.'",
						"password":"'.$pass.'",
						"monitoring_id":'.$monitoring.',
						"plan_total":'.$plan.',
						"plan_navigation":'.$celev.',
						"plan_prepair":0,
						"total":'.$totsum.',
						"wo_preexamination":0,
						"footnote":"", 
						"diapazones":[';
	}