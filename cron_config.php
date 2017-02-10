<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
define('PAGE_SEC','index');
cr_logic();

if(isset( $_GET['act'])){ $act=$_GET['act'];}
if(isset( $_GET['time'])){ $time=$_GET['time'];}
if(isset( $_GET['fields'])){ $fields=$_GET['fields'];}
if(isset( $_GET['date'])){ $date=$_GET['date'];}
if(isset( $_GET['delid'])){ $delid=$_GET['delid'];}


$out= "
	<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
	<script type='text/javascript'>

	$(document).ready(function(){
	$('.new').click(function(){
	$('.new').css('display','none');
	$('.addnew').css('display','block');
	});
	$('.delete').click(function(){
 		if(confirm('Вы действительно хотите удалить хэштэг?       ')){ document.location=$(this).attr('href'); }

	return false;
	


	});

	});


   
	</script>


	<style>		
	td{border:1px solid black;padding:5px;text-align:center;}
	 .addnew{display:none;}
	.new{margin:10px; padding:10px; color:blue; border: 2px solid blue; cursor:pointer; width:100px;text-align:center;}
	a.edit{cursor:pointer;text-decoration:underline;color:blue;}
	a.delete{cursor:pointer;text-decoration:underline;color:red;}
	</style>
	<h1>Рассписание выгрузки данных</h1>";






if (isset($delid)){ 
		$sql="DELETE FROM `db_cron_config` WHERE `id`='".$delid."'";
		$res=mysql_query($sql) or debug($sql,  mysql_error());
		$out.="<h2 style='color:green'>Успешно удалена запись</h2>";

}



if (isset($act) && $act=='add'){
	if (isset($time)){
		if (isset($fields)){
			if (isset($date)){
				$sql="SELECT `date`, `time`, `fields` FROM `db_cron_config` WHERE `date`='".$date."' AND `time`='".$time."' AND `fields`='".$fields."'";
				$res=mysql_query($sql) or debug($sql,  mysql_error());
				$arr=mysql_fetch_row($res);
				if($date ==$arr[0] && $time ==$arr[1] && $fields ==$arr[2]){
					$out.="<h2 style='color:red'>Такое задание уже существует</h2>";
					
				}else{
					$sql="INSERT INTO `db_cron_config`(`time`,`date`,`status`,`fields`) VALUES ('".$time."','".$date."','READY','".$fields."')";
					$res=mysql_query($sql) or debug($sql,  mysql_error());
					$out.="<h2 style='color:green'>Успешно добавлена новая запись</h2>";
				}

			}else{ $out.="<h2 style='color:red'>Не указана дата CRON</h2>";}
		}else{ $out.="<h2 style='color:red'>Не указаны поля</h2>";}
	}else{ $out.="<h2 style='color:red'>Не указано час CRON</h2>";}

}
$sql="SELECT * FROM `db_cron_config` WHERE 1 ORDER BY date , time";
$res=mysql_query($sql) or debug($sql,  mysql_error());

$out.="<table style='border:1px solid black;'><tr><td>Дата</td><td>Время</td><td>Статус</td><td>Поля</td><td>Удаление</td></tr>";

	while($arr=mysql_fetch_row($res)){
		if($arr[3]=="READY") {$status="<td style='color:blue'>".$arr[3]."</td>";}
		if($arr[3]=="OK") {$status="<td style='color:green'>".$arr[3]."</td>";}
		if($arr[3]=="ERROR") {$status="<td style='color:red'>".$arr[3]."</td>";}
		$out.="<tr><td>".$arr[1]."</td><td>".$arr[2]."</td>".$status."<td>".$arr[4]."</td><td><a   href='cron_config.php?delid=".$arr[0]."' class='delete' >Удалить</a></td></tr>";
	}

$out.="</table
><div class='new'>Добавить событие</div>
<div class='addnew'>
<form action='cron_config.php' method='get'>
<input type='hidden' name='act' value='add'/>
<p>Дата нового CRON: <input type='text' name='date' />(формат даты гггг-мм-дд)</p>
<p>Время нового CRON: <input type='text' name='time' /></p>
<p>Таблицы нового CRON: <input type='text' name='fields' />  ( budget , paid )</p>
<p><input type='submit' /></p>
</form>
</div>";



echo $out;
return;
?>