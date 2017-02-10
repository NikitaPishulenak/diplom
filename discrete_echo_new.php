<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/libreport.php';
//include 'autofixation.php';
$dt = date('H:i');
$dd = date('d.m.Y');


//cr_logic();

$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 1;
$type = isset($_GET['type']) ? (int) $_GET['type'] : 1;

//-------------------------------------------------------------------------------------
mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
//$AUTOFIXATION =24;//////////////////////////////////////////////////////////////////////////////УБРАТЬ,,,,,,,,,,,,,,,,,,,,,,,,,,,,
if ($type==1){
$sql="SELECT `total`,`target`,`target_type`,`target_cell`,`region_cell` FROM `db_fixed_target` WHERE `fixation_id` = ".$AUTOFIXATION." AND `faculty` = ".$fc." AND `edu_form` = 1 AND `state_id` = 1   ORDER BY `total` DESC";
$result= mysql_query($sql);
$i=0;
while ($row = mysql_fetch_assoc($result)) {
	$line[$i]['total']=$row['total'];
	$line[$i]['target']=$row['target'];
	$line[$i]['target_type']=$row['target_type'];
	$line[$i]['target_cell']=$row['target_cell'];
	$line[$i]['region_cell']=$row['region_cell'];
	$i++;
}

for  ($n = 400; $n > 90; $n=$n-10) {
	$lin[$n][1]=0;
	$lin[$n][2]=0;
	$lin[$n][3]=0;
	$lin[$n][4]=0;
	$lin[$n][5]=0;
	$lin[$n][6]=0;
	$lin[$n][0]=0;
	$lintarget2[$n][1]=0;
	$lintarget2[$n][2]=0;
	$lintarget2[$n][3]=0;
	$lintarget2[$n][4]=0;
	$lintarget2[$n][5]=0;
	$lintarget2[$n][6]=0;
}
$linsum[0]=0;
$linsum[1]=0;
$linsum[2]=0;
$linsum[3]=0;
$linsum[4]=0;
$linsum[5]=0;
$linsum[6]=0;
$linsumtarget2[1]=0;
$linsumtarget2[2]=0;
$linsumtarget2[3]=0;
$linsumtarget2[4]=0;
$linsumtarget2[5]=0;
$linsumtarget2[6]=0;
$lin_fail[0]=0;
$lin_fail[1]=0;
$lin_fail[2]=0;
$lin_fail[3]=0;
$lin_fail[4]=0;
$lin_fail[5]=0;
$lin_fail[6]=0;
$lin_fail2[1]=0;
$lin_fail2[2]=0;
$lin_fail2[3]=0;
$lin_fail2[4]=0;
$lin_fail2[5]=0;
$lin_fail2[6]=0;
$mo=0;
$bezisp=0;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($fc==6){
if(isset($line)){
for ($i = 0; $i < count($line); $i++) {
	for  ($n = 400; $n > 90; $n=$n-10) {
		$temp=$n;
		if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==3 && $line[$i]['target_type']==1 && $line[$i]['target_cell']==0){
			$lin[$n][0]++;
			$linsum[0]++;
		}
		if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==1 && $line[$i]['target_cell']==1){
			$lin[$n][$line[$i]['region_cell']]++;
			$linsum[$line[$i]['region_cell']]++;
		}


		if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==1 && $line[$i]['target_cell']==2){
			$lintarget2[$n][$line[$i]['region_cell']]++;
			$linsumtarget2[$line[$i]['region_cell']]++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==2 ){
			$bezisp++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==5 ){
			$mo++;
		}
	}
		if($line[$i]['total']<90 && $line[$i]['target']==3 && $line[$i]['target_type']==1 && $line[$i]['target_cell']==0){
			$linfail[0]++;
			$linsum[0]++;
		}
		if($line[$i]['total']<90 && $line[$i]['target']==1 && $line[$i]['target_cell']==1){
			$linfail[$line[$i]['region_cell']]++;
			$linsum[$line[$i]['region_cell']]++;
		}


		if($line[$i]['total']<90 && $line[$i]['target']==1 && $line[$i]['target_cell']==2){
			$linfail2[$line[$i]['region_cell']]++;
			$linsumtarget2[$line[$i]['region_cell']]++;
		}

}


}

$tbl="<style>th{border:1px solid black;border-collapse: collapse; width:auto;padding:5px; text-align:center;}table{width:100%;border-collapse: collapse;}</style>";
for  ($n = 400; $n > 90; $n=$n-10) {
	if($lin[$n][0]==0){$lin[$n][0]='';}	
	if($lin[$n][1]==0){$lin[$n][1]='';}	
	if($lin[$n][2]==0){$lin[$n][2]='';}	
	if($lin[$n][3]==0){$lin[$n][3]='';}	
	if($lin[$n][4]==0){$lin[$n][4]='';}	
	if($lin[$n][5]==0){$lin[$n][5]='';}	
	if($lin[$n][6]==0){$lin[$n][6]='';}	

	if($lintarget2[$n][1]==0){$lintarget2[$n][1]='';}	
	if($lintarget2[$n][2]==0){$lintarget2[$n][2]='';}	
	if($lintarget2[$n][3]==0){$lintarget2[$n][3]='';}	
	if($lintarget2[$n][4]==0){$lintarget2[$n][4]='';}	
	if($lintarget2[$n][5]==0){$lintarget2[$n][5]='';}	
	if($lintarget2[$n][6]==0){$lintarget2[$n][6]='';}
}
$tbl.="<table>";
$stringfirs="<tr><th colspan='3'>Балл</th><th>БИ</th><th>МО</th>";
$stringm="<tr><th colspan='3'>Общий конкурс</th><th>".$bezisp."</th><th>".$mo."</th>";

$string11="<th>РУП</th><th>-</th><th>-</th>";
$string12="<th>РУП</th><th>-</th><th>-</th>";
$string13="<th>РУП</th><th>-</th><th>-</th>";
$string14="<th>РУП</th><th>-</th><th>-</th>";
$string15="<th>РУП</th><th>-</th><th>-</th>";
$string16="<th>РУП</th><th>-</th><th>-</th>";

$string1="<tr><th rowspan='12' colspan='0'>Целевой приём</th>
	      <th rowspan='2'>Бр</th><th>УЗО</th><th>-</th><th>-</th>";
$string2="<tr><th rowspan='2'>Вт</th><th>УЗО</th><th>-</th><th>-</th>";
$string3="<tr><th rowspan='2'>Го</th><th>УЗО</th><th>-</th><th>-</th>";
$string4="<tr><th rowspan='2'>Гр</th><th>УЗО</th><th>-</th><th>-</th>";
$string5="<tr><th rowspan='2'>Мн</th><th>УЗО</th><th>-</th><th>-</th>";
$string6="<tr><th rowspan='2'>Мг</th><th>УЗО</th><th>-</th><th>-</th>";





for  ($n = 400; $n > 90; $n=$n-10) {
	$d=$n-9;
	$stringfirs.="<th>".$d."-".$n."</th>";
	$stringm.="<th>".$lin[$n][0]."</th>";
	$string1.="<th>".$lin[$n][1]."</th>";
	$string2.="<th>".$lin[$n][2]."</th>";
	$string3.="<th>".$lin[$n][3]."</th>";
	$string4.="<th>".$lin[$n][4]."</th>";
	$string5.="<th>".$lin[$n][5]."</th>";
	$string6.="<th>".$lin[$n][6]."</th>";

	$string11.="<th>".$lintarget2[$n][1]."</th>";
	$string12.="<th>".$lintarget2[$n][2]."</th>";
	$string13.="<th>".$lintarget2[$n][3]."</th>";
	$string14.="<th>".$lintarget2[$n][4]."</th>";
	$string15.="<th>".$lintarget2[$n][5]."</th>";
	$string16.="<th>".$lintarget2[$n][6]."</th>";


}
	if($lin_fail[0]==0){$lin_fail[0]='';}	
	if($lin_fail[1]==0){$lin_fail[1]='';}	
	if($lin_fail[2]==0){$lin_fail[2]='';}	
	if($lin_fail[3]==0){$lin_fail[3]='';}	
	if($lin_fail[4]==0){$lin_fail[4]='';}	
	if($lin_fail[5]==0){$lin_fail[5]='';}	
	if($lin_fail[6]==0){$lin_fail[6]='';}
	if($lin_fail2[1]==0){$lin_fail2[1]='';}	
	if($lin_fail2[2]==0){$lin_fail2[2]='';}	
	if($lin_fail2[3]==0){$lin_fail2[3]='';}	
	if($lin_fail2[4]==0){$lin_fail2[4]='';}	
	if($lin_fail2[5]==0){$lin_fail2[5]='';}	
	if($lin_fail2[6]==0){$lin_fail2[6]='';}		
$linsum[0]=$linsum[0]+$bezisp;
$tbl.= $stringfirs."<th> < 90 </th><th>Всего</th></tr>";
$tbl.= $stringm."<th>".$lin_fail[0]."</th><th>".$linsum[0]."</th></tr>";
$tbl.= $string1."<th>".$lin_fail[1]."</th><th>".$linsum[1]."</th></tr><tr>".$string11."<th>".$lin_fail[1]."</th><th>".$linsumtarget2[1]."</th></tr>";
$tbl.= $string2."<th>".$lin_fail[2]."</th><th>".$linsum[2]."</th></tr><tr>".$string12."<th>".$lin_fail[2]."</th><th>".$linsumtarget2[2]."</th></tr>";
$tbl.= $string3."<th>".$lin_fail[3]."</th><th>".$linsum[3]."</th></tr><tr>".$string13."<th>".$lin_fail[3]."</th><th>".$linsumtarget2[3]."</th></tr>";
$tbl.= $string4."<th>".$lin_fail[4]."</th><th>".$linsum[4]."</th></tr><tr>".$string14."<th>".$lin_fail[4]."</th><th>".$linsumtarget2[4]."</th></tr>";
$tbl.= $string5."<th>".$lin_fail[5]."</th><th>".$linsum[5]."</th></tr><tr>".$string15."<th>".$lin_fail[5]."</th><th>".$linsumtarget2[5]."</th></tr>";
$tbl.= $string6."<th>".$lin_fail[6]."</th><th>".$linsum[6]."</th></tr><tr>".$string16."<th>".$lin_fail[6]."</th><th>".$linsumtarget2[6]."</th></tr>";

$tbl.= "</table>";

mysql_select_db("admx");
$plans="<br><table  class='plan'><tr><th>План</th><th>Целевой</th></tr><tr><th>";
$sql="SELECT SUM(  `plan` ) FROM  `db_plancell` WHERE  `faculty_id` = ".$fc;
$celev= mysql_result(mysql_query($sql),0);
$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =1 AND  `edu_form_id` =1 AND `faculty_id` = ".$fc;
$plan= mysql_result(mysql_query($sql),0);
$plans.=$plan."</th><th>".$celev."</th></tr></table>";
$tbl.=$plans;


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}else{
if(isset($line)){
	for ($i = 0; $i < count($line); $i++) {
		for  ($n = 400; $n > 90; $n=$n-10) {
			$temp=$n;
			if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==3 && $line[$i]['target_type']==1 && $line[$i]['target_cell']==0){
				$lin[$n][0]++;
				$linsum[0]++;
			}
			if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==1 ){
				$lin[$n][$line[$i]['region_cell']]++;
				$linsum[$line[$i]['region_cell']]++;
			}
			if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==2 ){
				$bezisp++;
			}
			if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==5 ){
				$mo++;
			}
		}
		if($line[$i]['total']<90 && $line[$i]['target']==3 && $line[$i]['target_type']==1 && $line[$i]['target_cell']==0){
			$lin_fail[0]++;
			$linsum[0]++;
		}
		if($line[$i]['total']<90 && $line[$i]['target']==1 ){
			$lin_fail[$line[$i]['region_cell']]++;
			$linsum[$line[$i]['region_cell']]++;
		}

	}	

}


		


$tbl="<style>th{border:1px solid black;border-collapse: collapse; width:auto;padding:5px; text-align:center;}table{width:100%;border-collapse: collapse;}</style>";
for  ($n = 400; $n > 90; $n=$n-10) {
	if($lin[$n][0]==0){$lin[$n][0]='';}	
	if($lin[$n][1]==0){$lin[$n][1]='';}	
	if($lin[$n][2]==0){$lin[$n][2]='';}	
	if($lin[$n][3]==0){$lin[$n][3]='';}	
	if($lin[$n][4]==0){$lin[$n][4]='';}	
	if($lin[$n][5]==0){$lin[$n][5]='';}	
	if($lin[$n][6]==0){$lin[$n][6]='';}	
}
	if($lin_fail[0]==0){$lin_fail[0]='';}	
	if($lin_fail[1]==0){$lin_fail[1]='';}	
	if($lin_fail[2]==0){$lin_fail[2]='';}	
	if($lin_fail[3]==0){$lin_fail[3]='';}	
	if($lin_fail[4]==0){$lin_fail[4]='';}	
	if($lin_fail[5]==0){$lin_fail[5]='';}	
	if($lin_fail[6]==0){$lin_fail[6]='';}	

$tbl.="<table>";
$stringfirs="<tr><th colspan='2'>Балл</th><th>БИ</th><th>МО</th>";
$stringm="<tr><th colspan='2'>Общий конкурс</th><th>".$bezisp."</th><th>".$mo."</th>";
$string1="<tr><th rowspan='6' colspan='0'>Целевой приём</th><th>Бр</th><th>-</th><th>-</th>";
$string2="<tr><th>Вт</th><th>-</th><th>-</th>";
$string3="<tr><th>Го</th><th>-</th><th>-</th>";
$string4="<tr><th>Гр</th><th>-</th><th>-</th>";
$string5="<tr><th>Мн</th><th>-</th><th>-</th>";
$string6="<tr><th>Мг</th><th>-</th><th>-</th>";

for  ($n = 400; $n > 90; $n=$n-10) {
	$d=$n-9;
	$stringfirs.="<th>".$d."-".$n."</th>";
	$stringm.="<th>".$lin[$n][0]."</th>";
	$string1.="<th>".$lin[$n][1]."</th>";
	$string2.="<th>".$lin[$n][2]."</th>";
	$string3.="<th>".$lin[$n][3]."</th>";
	$string4.="<th>".$lin[$n][4]."</th>";
	$string5.="<th>".$lin[$n][5]."</th>";
	$string6.="<th>".$lin[$n][6]."</th>";

}

$linsum[0]=$linsum[0]+$bezisp+$mo;
$tbl.= $stringfirs."<th> < 90 </th><th>Всего</th></tr>";
$tbl.= $stringm."<th>".$lin_fail[0]."</th><th>".$linsum[0]."</th></tr>";
if($fc<>5){ 
$tbl.= $string1."<th>".$lin_fail[1]."</th><th>".$linsum[1]."</th></tr>";
$tbl.= $string2."<th>".$lin_fail[2]."</th><th>".$linsum[2]."</th></tr>";
$tbl.= $string3."<th>".$lin_fail[3]."</th><th>".$linsum[3]."</th></tr>";
$tbl.= $string4."<th>".$lin_fail[4]."</th><th>".$linsum[4]."</th></tr>";
$tbl.= $string5."<th>".$lin_fail[5]."</th><th>".$linsum[5]."</th></tr>";
$tbl.= $string6."<th>".$lin_fail[6]."</th><th>".$linsum[6]."</th></tr>";}
$tbl.= "</table>";
mysql_select_db("admx");
$plans="<br><table class='plan'><tr><th>План</th><th>Целевой</th></tr><tr><th>";
$sql="SELECT SUM(  `plan` ) FROM  `db_plancell` WHERE  `faculty_id` = ".$fc;
$celev= mysql_result(mysql_query($sql),0);
$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =1 AND  `edu_form_id` =1 AND `faculty_id` = ".$fc;
$plan= mysql_result(mysql_query($sql),0);
$plans.=$plan."</th><th>".$celev."</th></tr></table>";
$tbl.=$plans;

$dt = date('H:i');
$dd = date('d.m.Y');


}
if ($fc ==1){$fc="<h3>Лечебный факультет</h3>";}
if ($fc ==2){$fc="<h3>Медико-профилактический факультет</h3>";}
if ($fc ==3){$fc="<h3>Педиатрический факультет</h3>";}
if ($fc ==4){$fc="<h3>Стоматологический факультет</h3>";}
if ($fc ==5){$fc="<h3>Военно-медицинский факультет</h3>";}
if ($fc ==6){$fc="<h3>Фармацевтический факультет</h3>";}
$head="Данные на:  ".$dt." ".$dd;

echo $fc;
echo $head;
echo $tbl;

}else{




$sql="SELECT    `total` ,`faculty`,  `target`,`time_form_id` FROM  `db_fixed_target` WHERE  `fixation_id` =".$AUTOFIXATION." AND  `edu_form` =2 AND  `state_id` =1 ORDER BY  `total` DESC ";
$result= mysql_query($sql);
$i=0;
while ($row = mysql_fetch_assoc($result)) {
	$line[$i]['total']=$row['total'];
	$line[$i]['faculty']=$row['faculty'];
	$line[$i]['target']=$row['target'];
	$line[$i]['time_form_id']=$row['time_form_id'];
	$i++;
}

for  ($n = 400; $n > 20; $n=$n-10) {
	$lin[$n][0]=0;
	$lin[$n][1]=0;
	$lin[$n][2]=0;
	$lin[$n][3]=0;
	$lin[$n][4]=0;
	$lin[$n][5]=0;
}
$linsum[0]=0;
$linsum[1]=0;
$linsum[2]=0;
$linsum[3]=0;
$linsum[4]=0;
$linsum[5]=0;
$linfail[0]=0;
$linfail[1]=0;
$linfail[2]=0;
$linfail[3]=0;
$linfail[4]=0;
$linfail[5]=0;
$pvk[0]=0;
$pvk[1]=0;
$pvk[2]=0;
$pvk[3]=0;
$pvk[4]=0;
$pvk[5]=0;
$psk[0]=0;
$psk[1]=0;
$psk[2]=0;
$psk[3]=0;
$psk[4]=0;
$psk[5]=0;

for ($d = 0; $d <4; $d++) {
$dd=$d+1;
if(isset($line)){
for ($i = 0; $i < count($line); $i++) {
	for  ($n = 400; $n > 20; $n=$n-10) {
		$temp=$n;
		if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==3 && $line[$i]['faculty']==$dd){
			$lin[$n][$d]++;
			$linsum[$d]++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==6 && $line[$i]['faculty']==$dd ){
			$psk[$d]++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==4 && $line[$i]['faculty']==$dd ){
			$pvk[$d]++;
		}
	}
			if($line[$i]['total']<90 && $line[$i]['target']==3 && $line[$i]['faculty']==$dd){
			$linfail[$d]++;
			$linsum[$d]++;
			}

}


}
}if(isset($line)){
for ($i = 0; $i < count($line); $i++) {
	for  ($n = 400; $n > 20; $n=$n-10) {
		$temp=$n;
		if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==3 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==1){
			$lin[$n][4]++;
			$linsum[4]++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==6 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==1 ){
			$psk[4]++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==4 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==1 ){
			$pvk[4]++;
		}

	}
			if($line[$i]['total']<90 && $line[$i]['target']==3 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==1){
			$linfail[4]++;
			$linsum[4]++;
			}

}


}if(isset($line)){
for ($i = 0; $i < count($line); $i++) {
	for  ($n = 400; $n > 20; $n=$n-10) {
		$temp=$n;
		if($line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==3 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==2){
			$lin[$n][5]++;
			$linsum[5]++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==6 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==2 ){
			$psk[5]++;
		}
		if( $line[$i]['total']<=$temp && $line[$i]['total']>=($temp-9) && $line[$i]['target']==4 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==2 ){
			$pvk[5]++;
		}
	}
		if($line[$i]['total']<90 && $line[$i]['target']==3 && $line[$i]['target']==3 && $line[$i]['faculty']==6 && $line[$i]['time_form_id']==2){
			$linfail[5]++;
			$linsum[5]++;
			}
}
}
$tbl="<style>th{border:1px solid black;border-collapse: collapse; width:auto;padding:5px; text-align:center;}table{width:100%;border-collapse: collapse;}</style>";
for  ($n = 400; $n > 90; $n=$n-10) {
	if($lin[$n][0]==0){$lin[$n][0]='';}	
	if($lin[$n][1]==0){$lin[$n][1]='';}	
	if($lin[$n][2]==0){$lin[$n][2]='';}	
	if($lin[$n][3]==0){$lin[$n][3]='';}	
	if($lin[$n][4]==0){$lin[$n][4]='';}	
	if($lin[$n][5]==0){$lin[$n][5]='';}	

}
	if($linfail[0]==0){$linfail[0]='';}	
	if($linfail[1]==0){$linfail[1]='';}	
	if($linfail[2]==0){$linfail[2]='';}	
	if($linfail[3]==0){$linfail[3]='';}	
	if($linfail[4]==0){$linfail[4]='';}	
	if($linfail[5]==0){$linfail[5]='';}	
		
$tbl.="<table>";
$stringfirs="<tr><th colspan='2'>Балл</th><th>ПВК</th><th>ПСК</th>";
$string1="<tr><th colspan='2'>Лечебный факультет</th><th>".$pvk[0]."</th><th>".$psk[0]."</th>";
$string2="<tr><th colspan='2'>Медико-профилактический факультет</th><th>".$pvk[1]."</th><th>".$psk[1]."</th>";
$string3="<tr><th colspan='2'>Педиатрический факультет</th><th>".$pvk[2]."</th><th>".$psk[2]."</th>";
$string4="<tr><th colspan='2'>Стоматологический факультет</th><th>".$pvk[3]."</th><th>".$psk[3]."</th>";
$string5="<tr><th colspan='2'>Фармацевтический факультет</th><th>".$pvk[4]."</th><th>".$psk[4]."</th>";
$string6="<tr><th colspan='2'>Фармацевтический факультет(Заочное)</th><th>".$pvk[5]."</th><th>".$psk[5]."</th>";



for  ($n = 400; $n > 90; $n=$n-10) {
	$d=$n-9;
	$stringfirs.="<th>".$d."-".$n."</th>";
	$string1.="<th>".$lin[$n][0]."</th>";
	$string2.="<th>".$lin[$n][1]."</th>";
	$string3.="<th>".$lin[$n][2]."</th>";
	$string4.="<th>".$lin[$n][3]."</th>";
	$string5.="<th>".$lin[$n][4]."</th>";
	$string6.="<th>".$lin[$n][5]."</th>";
	

}
$linsum[0]=$linsum[0]+$pvk[0];
$linsum[1]=$linsum[1]+$pvk[1];
$linsum[2]=$linsum[2]+$pvk[2];
$linsum[3]=$linsum[3]+$pvk[3];
$linsum[4]=$linsum[4]+$pvk[4];
$linsum[5]=$linsum[5]+$pvk[5];
$tbl.= $stringfirs."<th> < 90 </th><th>Всего</th></tr>";
$tbl.= $string1."<th>".$linfail[0]."</th><th>".$linsum[0]."</th></tr>";
$tbl.= $string2."<th>".$linfail[1]."</th><th>".$linsum[1]."</th></tr>";
$tbl.= $string3."<th>".$linfail[2]."</th><th>".$linsum[2]."</th></tr>";
$tbl.= $string4."<th>".$linfail[3]."</th><th>".$linsum[3]."</th></tr>";
$tbl.= $string5."<th>".$linfail[4]."</th><th>".$linsum[4]."</th></tr>";
$tbl.= $string6."<th>".$linfail[5]."</th><th>".$linsum[5]."</th></tr>";
$tbl.= "</table>";

mysql_select_db("admx");
$plans="<br><table  class='plan'><tr>
<th>План</th>
<th>Лечебный факультет</th>
<th>Медико-профилактический факультет</th>
<th>Педиатрический факультет</th>
<th>Стоматологический факультет</th>
<th>Фармацевтический факультет</th>
<th>Фармацевтический факультет(Заочное)</th>
</tr><tr><th>Мест</th>";

$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =1 AND  `edu_form_id` =2 and `faculty_id` <5 ORDER BY `faculty_id`";
$result= mysql_query($sql);
while ($plan = mysql_fetch_row($result)) {
$plans.="<th>".$plan[0]."</th>";
}
$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =1 AND  `edu_form_id` =2 and `faculty_id` =6";
$plans.="<th>".mysql_result( mysql_query($sql),0)."</th>";
$sql="SELECT  `total` FROM  `db_planform` WHERE `time_form_id` =2 AND  `edu_form_id` =2 and `faculty_id` =6";
$plans.="<th>".mysql_result( mysql_query($sql),0)."</th>";
$plans.="</tr></table>";


$tbl.=$plans;


$dt = date('H:i');
$dd = date('d.m.Y');

$head="Данные на:  ".$dt." ".$dd;


echo $head;
echo $tbl;



}