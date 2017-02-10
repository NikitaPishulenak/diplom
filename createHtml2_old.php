<?php
chdir(dirname(__FILE__));
error_reporting(0);
ini_set( "display_errors", "0" );

include 'config.php';
include 'core/db.php';
include 'core/ui.php';


if (isset($_GET['MODE'])){

	if ($_GET['MODE'] != 'DISPLAY')
		ui_redirect('index.php');
}
else
	ui_redirect('index.php');

$facult_list="1,2,3,4,5";
$facult_new_tables="6";
$facult_ignore = "7";
$no_contest_budget_target_ids	= "2,5";
$no_contest_paid_target_ids	= "4";
$BUDGET = '1';
$PAID = '2';

	printHead();
	echoTable($facult_ignore);
	echoTableForTarget($facult_ignore.',5','6', '1,2,3,4,5,6');
	//echoTable($facult_ignore.','.$facult_list);
	echo '<br><br><hr style="color: red">';
	echoTable($facult_ignore, false);
	echoTablePaidFarm();
	//echoTable($facult_ignore.','.$facult_list, false);
	//echoTableForTarget($facult_ignore,'','');
//	echoTableForTarget($facult_ignore.',1,2,3,4,5','6', '1,2,3,4,5,6');




function printHeadStat(){
$date = date("d-m-Y  G:")."00";
echo <<< EOF
<!DOCTYPE html>
<HTML>
<HEAD>
<style>

.export_table {
	border: 5px double gray;
	border-collapse: collapse;
}

.export_table thead td {
	border: 1px solid black;
	padding: 5px;
	text-align: center;
	font-weight: bold;
}

.export_table tbody td {
	border-bottom: 1px dashed black;
	text-align: center;
	font-size: 1.1em;
	padding: 10px 3px;
}

.export_table tbody tr td:first-child {
	font-weight: bold;
}

.export_table tbody tr:last-child td {
	border-bottom: 2px double black
}

.export_table tbody tr td:nth-child(2n+10){
	background: #e0e0e0;	
}

.export_table tbody td {
	border: 1px dashed black;
}


.export_table_c {
	border: 5px double gray;
	border-collapse: collapse;
}

.export_table_c thead td {
	border: 1px solid black;
	padding: 5px;
	text-align: center;
	font-weight: bold;
}

.export_table_c tbody td {
	border-bottom: 1px dashed black;
	text-align: center;
	font-size: 1.1em;
	padding: 10px 3px;
}

.export_table_c tbody tr td:first-child {
	font-weight: bold;
}

.export_table_c tbody tr:last-child td {
	border-bottom: 2px double black
}

.export_table_c tbody tr td:nth-child(2n+5){
	//background: #e0e0e0;	
}

.export_table_c tbody td {
	border: 1px solid black;
}


</style>

<TITLE>Контрольные цифры</TITLE>
</HEAD>
<BODY>
<h1>Данные за $date</h1>
EOF;
}


function printHead()
{
$date = date("d-m-Y  G:")."00";
echo <<< EOF
<!DOCTYPE html>
<HTML>
<HEAD>
<style>

.export_table {
	border: 5px double gray;
	border-collapse: collapse;
}

.export_table thead td {
	border: 1px solid black;
	padding: 5px;
	text-align: center;
	font-weight: bold;
}

.export_table tbody td {
	border-bottom: 1px dashed black;
	text-align: center;
	font-size: 1.1em;
	padding: 10px 3px;
}

.export_table tbody tr td:first-child {
	font-weight: bold;
}

.export_table tbody tr:last-child td {
	border-bottom: 2px double black
}

.export_table tbody tr td:nth-child(2n+10){
	background: #e0e0e0;	
}

.export_table tbody td {
	border: 1px dashed black;
}


.export_table_c {
	border: 5px double gray;
	border-collapse: collapse;
}

.export_table_c thead td {
	border: 1px solid black;
	padding: 5px;
	text-align: center;
	font-weight: bold;
}

.export_table_c tbody td {
	border-bottom: 1px dashed black;
	text-align: center;
	font-size: 1.1em;
	padding: 10px 3px;
}

.export_table_c tbody tr td:first-child {
	font-weight: bold;
}

.export_table_c tbody tr:last-child td {
	border-bottom: 2px double black
}

.export_table_c tbody tr td:nth-child(2n+5){
	//background: #e0e0e0;	
}

.export_table_c tbody td {
	border: 1px solid black;
}


</style>

<TITLE>Контрольные цифры</TITLE>
</HEAD>
<BODY>
<h1>Данные за $date</h1>
EOF;
}

function echoTablePaidFarm()
{
echo <<<EOF
<h2>Платная форма, Фармация (2-ое высшее, 2-ой курс)</h2>
	<table class="export_table">
	<thead>
	<tr>
		<td>План</td>
		<td>Подано</td>
	</tr>
	</thead>
	<tbody>
EOF;
 mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
mysql_select_db('admx');
$plan =  mysql_result(mysql_query("SELECT total FROM db_planform WHERE time_form_id=5  AND edu_form_id=2 AND faculty_id = 6"),0);
mysql_select_db('afx');
$income = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty IN (6) AND state_id = 1 AND time_form_id = 5"),0);
echo <<<EOF
	<tr>
		<td>$plan</td>
		<td>$income</td>
	</tr>
</tbody>
</table>
EOF;
}

function echoTableForTarget($facult_ignore = null, $needDetail = '', $needRegion = 'all')
{
//....................... ЗАНЧЕНИЯ ПЕРЕДАВАЕМЫХ ПАРАМЕТРОВ В ФУНКЦИЮ .....................//
// needDetail - с разбивкой по типу целевых, указать факультеты, например '1, 2'          //
//		пока нужно только для Фармы, т.е. '6' (УЗО/ФАРМ)                          //
//                                                                                        //
// needRegion                                                                             //
//	all - (по умолчанию) разбивает по регионам все факультеты                         //
//	1,2,3 - указывает факультеты с разбивкой                                          //
//	 -1   - без разбивки                                                              //
//........................................................................................//

mysql_select_db("admx");


$detail = Array();
	if ($needDetail)
		$detail = explode(',', $needDetail);

$needRegions = Array();
if ($needRegion == 'all')
	{
	//$needRegion = '';
	$result = mysql_query("SELECT id FROM db_faculty WHERE id NOT IN (".$facult_ignore.") ORDER BY id");
	while($as = mysql_fetch_array($result))
		array_push($needRegions, $as[0]);
	$needRegion = implode(',', $needRegions);
	}
else
	{

	if($needRegion == '-1') {
		$needRegion = '';
	}
	else

	if ($needRegion)
		$needRegions = explode(',',$needRegion);

	}


$facult_rowspan = sizeOf($needRegions);

	$count=0;

	for ($i=400; $i>90; $i=$i-10)
	{
		$count++;
	}
	$count++;
	echo <<<EOF

<h1 style="text-align:right; color: red;">Целевая подготовка</h1>
<table class="export_table_c">
<thead>
	<tr>
		<td rowspan="2" colspan="3">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="2">План</td>
		<td colspan="$count">Подано заявлений от абитуриентов с суммой набранных баллов на условии целевой подготовки</td>
	</tr>
	<tr>
		<td>Всего</td>
EOF;
for ($i=400; $i>90; $i=$i-10)
{

 echo '<td>'.$i.' - '.($i-9).'</td>';
}

echo <<<EOF
	</tr>
</thead>
<tbody>
EOF;

$dbRegions = Array();
$dbCellTypes = Array();
$dbFaculty = Array();


 mysql_select_db("admx");
 $result = mysql_query('SELECT id_region, abbr FROM db_region');
 while ($row = mysql_fetch_array($result))
	$dbRegions[$row[0]] = $row[1];

 $result = mysql_query('SELECT id_targetcell, abbr FROM db_targetcell');
 while ($row = mysql_fetch_array($result))
	$cellTypes[$row[0]] = $row[1];

 $result = mysql_query('SELECT id_targetcell, abbr FROM db_targetcell');
 while ($row = mysql_fetch_array($result))
	$dbCellTypes[$row[0]] = $row[1];


mysql_select_db("admx");

 $where = ($facult_ignore) ? " WHERE id NOT IN(".$facult_ignore.")" : "";
 $result = mysql_query('SELECT id, name FROM db_faculty'.$where);
 while ($row = mysql_fetch_array($result))
	$dbFaculty[$row[0]] = $row[1];

/*
print_r($dbRegions);
print_r($dbcellTypes);
print_r($dbFaculty);
  */

 mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);

$regionsKeys = array_keys($dbRegions);
$facultyKeys = array_keys($dbFaculty);
$cellTypesKeys = array_keys($dbCellTypes);
$countRegions = sizeOf($regionsKeys);
$countCellTypes = sizeOf($cellTypesKeys);

	for ($f = 0; $f < sizeOf($facultyKeys); $f++)
	{
		$span = "";
		if (in_array($facultyKeys[$f], $needRegions))
		{
			if (in_array($facultyKeys[$f], $detail))
			{
			$text = $dbFaculty[$facultyKeys[$f]];
			$rspan = $countRegions*$countCellTypes+1;
				echo <<<EOF
				<td rowspan="$rspan">$text</td>
EOF;
			for($r = 0; $r < $countRegions; $r++)
			{
				echo "<tr>";
				$text = $dbRegions[$regionsKeys[$r]];
				echo <<<EOF
					<td rowspan="$countCellTypes">$text</td>
EOF;
				for($t=0; $t < $countCellTypes; $t++)
				{
				$text   = $dbCellTypes[$cellTypesKeys[$t]];
				mysql_select_db("admx");
				$plan = mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$facultyKeys[$f]." AND region_id = ".$regionsKeys[$r]." AND targetcell_id = ".$cellTypesKeys[$t]),0);
				$plan = ($plan) ? $plan : ' - ';
				mysql_select_db("afx");
				$count = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$facultyKeys[$f]." AND state_id = 1 AND target = 1 AND region_cell = ".$regionsKeys[$r]." AND target_cell = ".$cellTypesKeys[$t]),0);
				$count = ($count) ? $count : ' - ';
				echo <<<EOF
				<td>$text</td>
				<td>$plan</td>
				<td>$count</td>
EOF;
			for ($i=400; $i>90; $i=$i-10)
			{
			$ii = $i-9;
			$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND target = 1 AND faculty = ".$facultyKeys[$f]." AND region_cell = ".$regionsKeys[$r]." AND target_cell = ".$cellTypesKeys[$t];
			$text = mysql_result(mysql_query($sql),0);
			$text = ($text) ? $text : ' - ';
			 echo '<td>'.$text.' </td>';
			}

			echo "</tr>";
				
				}
			}
			}
			else
			{
			echo "<tr>";
			$text = $dbFaculty[$facultyKeys[$f]];
			$rspan = $countRegions;
				echo <<<EOF
				<td clospan="2" rowspan="$rspan">$text</td>
EOF;
			for($r = 0; $r < $countRegions; $r++)
			{
				$text = $dbRegions[$regionsKeys[$r]];
				mysql_select_db("admx");
				$plan = mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$facultyKeys[$f]." AND region_id = ".$regionsKeys[$r]),0);
				$plan = ($plan) ? $plan : ' - ';
				mysql_select_db("afx");
				$count = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$facultyKeys[$f]." AND state_id = 1 AND target = 1 AND region_cell = ".$regionsKeys[$r]),0);
				$count = ($count) ? $count : ' - ';
				echo <<<EOF
				<td colspan="2">$text</td>
				<td>$plan</td>
				<td>$count</td>
EOF;
	
			for ($i=400; $i>90; $i=$i-10)
			{
			$ii = $i-9;
			$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND target = 1 AND faculty = ".$facultyKeys[$f]." AND region_cell = ".$regionsKeys[$r];
			$text = mysql_result(mysql_query($sql),0);
			$text = ($text) ? $text : ' - ';
			 echo '<td>'.$text.' </td>';
			}

			echo "</tr>";
				
			}
			}
		}
		else
		{
			echo "<tr>";
			$text = $dbFaculty[$facultyKeys[$f]];
			mysql_select_db("admx");
			$plan = mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$facultyKeys[$f]),0);
			$plan = ($plan) ? $plan : ' - ';
			mysql_select_db("afx");
			$count = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$facultyKeys[$f]." AND state_id = 1 AND target = 1"),0);
			$count = ($count) ? $count : ' - ';
			echo <<<EOF
				<td colspan="3">$text</td>
				<td>$plan</td>
				<td>$count</td>
	
EOF;
			for ($i=400; $i>90; $i=$i-10)
			{
			$ii = $i-9;
			$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND target = 1 AND faculty = ".$facultyKeys[$f];
			$text = mysql_result(mysql_query($sql),0);
			$text = ($text) ? $text : ' - ';
			 echo '<td>'.$text.'</td>';
			}

			echo "</tr>";
		}
	}

echo <<<EOF
</tbody>
</table>
EOF;
}

function echoTable($facult_ignore, $isBudget = true)
{                      

$edu_form = ($isBudget) ? 1 : 2;
$head_text = ($isBudget) ? 'Бюджетная форма' : 'Платная форма';
mysql_select_db("admx");

	$str="";

	$count=0;

	for ($i=400; $i>90; $i=$i-10)
	{
		$count++;
	}
	$fcount = $count + 6; // Full table colspan;
	echo <<<EOF

<h1 style="text-align:right; color: red;">$head_text</h1>
<table class="export_table">
<thead>
	<tr>
		<td rowspan="3">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="2" colspan="2">План приема</td>
		<td colspan="$fcount">Подано заявлений от абитуриентов</td>
	</tr>
	<tr>
		<td rowspan="2">всего</td>
		<td colspan="5">в том числе</td>
		<td colspan="$count">с суммой набранных баллов для конкурсного зачисления</td>
	</tr>

	<tr>
		<td>всего</td>
		<td>на условиях целевой подготовки</td>
		<td>на условиях целевой подготовки</td>
		<td>без вступительных испытаний</td>
		<td>вне конкурса</td>
		<td>сверх конкурса</td>
		<td>по конкурсу</td>
EOF;
for ($i=400; $i>90; $i=$i-10)
{

 echo '<td>'.$i.' - '.($i-9).'</td>';
}

echo <<<EOF
	</tr>
</thead>
<tbody>
EOF;

mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
//echo $AUTOFIXATION;


mysql_select_db("admx");
$sql = "SELECT id, name FROM db_faculty WHERE id NOT IN(".$facult_ignore.")";

$result = mysql_query($sql);
while ($row = mysql_fetch_array($result))
{
	mysql_select_db("admx");
	$plan_total = mysql_result(mysql_query("SELECT SUM(total) FROM db_planform WHERE faculty_id = ".$row[0]. " AND edu_form_id = ".$edu_form." AND time_form_id NOT IN (5)"),0);
//	$plan_total = mysql_result(mysql_query("SELECT SUM(total) FROM db_planform WHERE faculty_id = ".$row[0]. " AND edu_form_id = ".$edu_form),0);
	$plan_cel =   mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$row[0]),0);
	mysql_select_db("afx");
	$total = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND time_form_id NOT IN (5)"),0);
	$to_cel = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 1"),0);
	$plan_cel = ($edu_form == 2) ? " - " : $plan_cel;
	$bez_isp = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target IN (2,5)  AND time_form_id NOT IN (5)"),0);
	$vne_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 4"),0);
	$sv_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 6"),0);
	$to_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 3"),0);

	echo <<< EOF
	<tr>
		<td>$row[1]</td>
		<td>$plan_total</td>
		<td>$plan_cel</td>
		<td>$total</td>
		<td>$to_cel</td>
		<td>$bez_isp</td>
		<td>$vne_konkurs</td>
		<td>$sv_konkurs</td>
		<td>$to_konkurs</td>
EOF;
	for ($i=400; $i>90; $i=$i-10)
	{
	$str = '';
	$ii = $i-9;
	$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND edu_form = ".$edu_form." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND faculty = ".$row[0]." AND time_form_id NOT IN (5)  AND target NOT IN (2,5)";
	$str = mysql_result(mysql_query($sql),0);
	$str = ($str) ? $str : '-';
	 echo '<td>'.$str.'</td>';
	}
	echo '</tr>';
}


	echo<<<EOF

</tbody>
</table>
EOF;

}
?>