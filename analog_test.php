<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC','analog.test');
cr_logic();


$tf=isset($_GET['tf'])?(int)$_GET['tf']:0;
$fc=isset($_GET['fc'])?(int)$_GET['fc']:0;

$sql="SELECT DISTINCT total from db_person WHERE `edu_form`=1 ORDER by `total` DESC;";
$r=mysql_query($sql) or debug($sql,  mysql_error());
$balls=array();
$cr=db_kv('db_region', 'id_region', 'abbr');
while($l=  mysql_fetch_object($r))
{
    $balls[]=$l->total;
}

ui_sp('Аналоговая таблица');


$fc_arr=db_kv('db_faculty','id','name');
$tf_arr=db_kv('db_time_form', 'id_time_form', 'name');

ui_gf();
ui_stfs();
ui_sptfs3('vsplitter3_none');
ui_sfs();
ui_select('', 'fc', 'Факультет', $fc_arr, $fc);
ui_select('', 'tf', 'Отделение', $tf_arr, $tf);
ui_submit('', '', '', 'Показать', '');
ui_efs();
ui_sptfs3('vsplitter3_none');
ui_etfs();
ui_ef0();

ui_sfs();
ui_rep_row();
ui_rep_th('Балл',0,2);
ui_rep_th('Общий конкурс',2);
ui_rep_th('Целевой приём',count($cr));
ui_end_row();

ui_rep_row();
ui_rep_th('Город');
ui_rep_th('Село');
foreach($cr as $v)
{
    ui_rep_th($v);
}
ui_end_row();


ui_rep_row();
ui_rep_th('Без испытаний');
ui_rep_td(report_count($fc, $tf, 1, 2, 0, 0, 0, 1));
ui_rep_td(report_count($fc, $tf, 1, 2, 0, 0, 0, 1));
foreach($cr as $v)
{
        ui_rep_td(0);
}
ui_end_row();

foreach($balls as $v)
{
    ui_rep_row();
    ui_rep_th($v);
    ui_rep_td(report_count_by_total($fc, $tf, 1, 3, 1, 0, 0, 1, $v));
    ui_rep_td(report_count_by_total($fc, $tf, 1, 3, 2, 0, 0, 1, $v));
    foreach($cr as $k=>$vv)
    {
        ui_rep_td(report_count_by_total($fc, $tf, 1, 1, 0, 0, $k, 1, $v));
    }
    ui_end_row();
}
ui_rep_row();
ui_rep_th('Всего');
ui_rep_th('');
ui_rep_th('');
foreach($cr as $v)
{
    ui_rep_th($v);
}
ui_end_row();

ui_efs();


ui_ep();