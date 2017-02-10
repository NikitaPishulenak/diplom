<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/libreport.php';
include 'autofixation.php';

$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 1;
$type = isset($_GET['type']) ? (int) $_GET['type'] : 1;

$settings = db_kv('db_settings', 'hashkey', 'value');

$login=$settings['abby_login'];
$pass=md5(md5($settings['abby_pass']));

mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);

$sql="SELECT `total`,`target`,`target_type`,`target_cell`,`region_cell`,`faculty`,`edu_form`,`time_form_id` FROM `db_fixed_target` WHERE 
	`fixation_id` = ".$AUTOFIXATION."  AND `state_id` = 1   ORDER BY `total` DESC";
$result= mysql_query($sql);
$i=0;
while ($row = mysql_fetch_assoc($result)) {
	$line[$i]['total']=$row['total'];
	$line[$i]['target']=$row['target'];
	$line[$i]['target_type']=$row['target_type'];
	$line[$i]['target_cell']=$row['target_cell'];
	$line[$i]['faculty']=$row['faculty'];
	$line[$i]['edu_form']=$row['edu_form'];
	$line[$i]['region_cell']=$row['region_cell'];
	$line[$i]['time_form_id']=$row['time_form_id'];
	$i++;
}
$i--;
$mas[1]='';
$mas[2]='';
$mas[3]='';
$mas[4]='';
$bi=0;
$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 1;
$tp = isset($_GET['tp']) ? (int) $_GET['tp'] : 1;
if ($tp==1){
	
	mysql_select_db("admx");
	$sql1=mysql_query("SELECT `monid` FROM `db_abby_monid` WHERE `faculty_id`=".$fc." AND `time_form_id`=1");
	$monitoring=mysql_result($sql1,0);
	$sql="SELECT SUM(  `plan` ) FROM  `db_plancell` WHERE  `faculty_id` =".$fc;
	$celev= mysql_result(mysql_query($sql),0);
	$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =1 AND  `edu_form_id` =1 AND `faculty_id` =".$fc;
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
				if($line[$t]['total']<=$d && $line[$t]['total']>=$dd && $line[$t]['time_form_id']==1 && $line[$t]['target']==3  && $line[$t]['faculty']==$fc){$count++;$tot_sum[1]++;}

			}
			$mas[1].='{"category":1,"diap_start":'.$dd.',"diap_end":'.$d.',"count":'.$count.'},';
				
		}
				
			$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=80 && $line[$t]['total']>=70  && $line[$t]['target']==3 && $line[$t]['time_form_id']==1 &&  $line[$t]['target_type']==1 && $line[$t]['target_cell']==0 && $line[$t]['faculty']==$fc){$count++;$tot_sum[1]++;}

		}
		$mas[1].='{"category":1,"diap_start":70,"diap_end":80,"count":'.$count.'},';	
		
		$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=69 && $line[$t]['total']>0  && $line[$t]['target']==3 && $line[$t]['time_form_id']==1 &&  $line[$t]['target_type']==1 && $line[$t]['target_cell']==0 && $line[$t]['faculty']==$fc){$count++;$tot_sum[1]++;}

		}
		$mas[1].='{"category":1,"diap_start":0,"diap_end":69,"count":'.$count.'},';	
		
		///////////////////////////////////////////////////
		for($d=400;$d>81;$d=$d-10){
			$dd=$d-9;
			$count=0;
			for($t=0;$t<$i-1;$t++){
				if($line[$t]['total']<=$d && $line[$t]['total']>=$dd && $line[$t]['target']==1 && $line[$t]['time_form_id']==1 &&  $line[$t]['faculty']==$fc){$count++;$tot_sum[2]++;}

			}
			$mas[2].='{"category":2,"diap_start":'.$dd.',"diap_end":'.$d.',"count":'.$count.'},';	
			
		}
				
			$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=80 && $line[$t]['total']>=70  && $line[$t]['target']==1 &&  $line[$t]['time_form_id']==1 &&  $line[$t]['faculty']==$fc){$count++;$tot_sum[2]++;}

		}
		$mas[2].='{"category":2,"diap_start":70,"diap_end":80,"count":'.$count.'},';	
		
		$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=69 && $line[$t]['total']>0  && $line[$t]['target']==1 && $line[$t]['time_form_id']==1 &&  $line[$t]['faculty']==$fc){$count++;$tot_sum[2]++;}
		
		}
		$mas[2].='{"category":2,"diap_start":0,"diap_end":69,"count":'.$count.'}';	
		
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
if ($tp==2){
	
	mysql_select_db("admx");
	$sql1=mysql_query("SELECT `monid` FROM `db_abby_monid` WHERE `faculty_id`=".$fc." AND `time_form_id`=3");
	$monitoring=mysql_result($sql1,0);
	$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =1 AND  `edu_form_id` =2 AND `faculty_id` =".$fc;
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
				if($line[$t]['total']<=$d && $line[$t]['total']>=$dd && $line[$t]['time_form_id']==1 && $line[$t]['edu_form']==2 && $line[$t]['target']==3 && $line[$t]['faculty']==$fc){$count++;}
				
			}
			$mas[1].='{"category":1,"diap_start":'.$dd.',"diap_end":'.$d.',"count":'.$count.'},';
			$tot_sum[1]+=$count;	
		}
				
			$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=80 && $line[$t]['total']>=70 && $line[$t]['time_form_id']==1 && $line[$t]['edu_form']==2 && $line[$t]['target']==3 &&  $line[$t]['faculty']==$fc){$count++;}
		}
		$mas[1].='{"category":1,"diap_start":70,"diap_end":80,"count":'.$count.'},';	
		$tot_sum[1]+=$count;
		$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=69 && $line[$t]['total']>0  && $line[$t]['time_form_id']==1 && $line[$t]['edu_form']==2 && $line[$t]['target']==3 && $line[$t]['faculty']==$fc){$count++;}
		}
		$mas[1].='{"category":1,"diap_start":0,"diap_end":69,"count":'.$count.'},';	
		$tot_sum[1]+=$count;
		///////////////////////////////////////////////////

		$totsum=$tot_sum[2]+$tot_sum[1];
		$head='{"method":"updateMonitoring",
			"params":{  "login":"'.$login.'",
						"password":"'.$pass.'",
						"monitoring_id":'.$monitoring.',
						"plan_total":'.$plan.',
						"plan_navigation":"0",
						"plan_prepair":0,
						"total":'.$totsum.',
						"wo_preexamination":0,
						"footnote":"", 
						"diapazones":[';

	
	
}
if ($tp==3){
	
	mysql_select_db("admx");
	$sql1=mysql_query("SELECT `monid` FROM `db_abby_monid` WHERE `faculty_id`=".$fc." AND `time_form_id`=2");
	$monitoring=mysql_result($sql1,0);
	$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =2 AND  `edu_form_id` =2 AND `faculty_id` =".$fc;
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
				if($line[$t]['total']<=$d && $line[$t]['total']>=$dd && $line[$t]['time_form_id']==2 && $line[$t]['edu_form']==2 && $line[$t]['target']==3 && $line[$t]['faculty']==$fc){$count++;}
				
			}
			$mas[1].='{"category":1,"diap_start":'.$dd.',"diap_end":'.$d.',"count":'.$count.'},';
			$tot_sum[1]+=$count;	
		}
				
			$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=80 && $line[$t]['total']>=70 && $line[$t]['time_form_id']==2 && $line[$t]['edu_form']==2 && $line[$t]['target']==3 &&  $line[$t]['faculty']==$fc){$count++;}
		}
		$mas[1].='{"category":1,"diap_start":70,"diap_end":80,"count":'.$count.'},';	
		$tot_sum[1]+=$count;
		$count=0;
		for($t=0;$t<$i-1;$t++){
			if($line[$t]['total']<=69 && $line[$t]['total']>0  && $line[$t]['time_form_id']==2 && $line[$t]['edu_form']==2 && $line[$t]['target']==3 && $line[$t]['faculty']==$fc){$count++;}
		}
		$mas[1].='{"category":1,"diap_start":0,"diap_end":69,"count":'.$count.'},';	
		$tot_sum[1]+=$count;
		///////////////////////////////////////////////////

		$totsum=$tot_sum[2]+$tot_sum[1];
		$head='{"method":"updateMonitoring",
			"params":{  "login":"'.$login.'",
						"password":"'.$pass.'",
						"monitoring_id":'.$monitoring.',
						"plan_total":'.$plan.',
						"plan_navigation":"0",
						"plan_prepair":0,
						"total":'.$totsum.',
						"wo_preexamination":0,
						"footnote":"", 
						"diapazones":[';

	
	
}




echo $head.$mas[1].$mas[2].']}}';