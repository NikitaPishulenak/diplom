<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC', 'report.discrete');
cr_logic();

$plan_paid = array();
$view_paid = array();
$summ_paid = array();

$fc_arr = db_kv('db_faculty', 'id', 'name');
$tf_arr = db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr = db_kv('db_ef', 'id_ef', 'name');

foreach ($fc_arr as $k => $v) {
    foreach ($tf_arr as $kk => $vv) {
        $plan_paid[$k][$kk] = 0;
        $view_paid[$k][$kk] = false;
        $summ_paid[$k][$kk] = 0;
    }
}

$sql = "SELECT * FROM `db_planform` WHERE `edu_form_id`=2";
$r = mysql_query($sql) or debug($sql, mysql_error());
while ($l = mysql_fetch_object($r)) {
    $plan_paid[$l->faculty_id][$l->time_form_id] = $l->total;
    if (((int) $l->total) > 0)
        $view_paid[$l->faculty_id][$l->time_form_id] = true;
}

$tf = isset($_GET['tf']) ? (int) $_GET['tf'] : 0;
$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 0;
$ef = isset($_GET['ef']) ? (int) $_GET['ef'] : 0;
$raw = isset($_GET['raw']) ? (int) $_GET['raw'] : 1;

if($tf && $fc){
	foreach ($fc_arr as $k => $v) {
    		foreach ($tf_arr as $kk => $vv) {
        		$view_paid[$k][$kk] = false;
		}
	}
	$view_paid[$fc][$tf]=true;
}
$afx = isset($_GET['afx']) ? (int) $_GET['afx'] : 0;
$mfx = isset($_GET['mfx']) ? (int) $_GET['mfx'] : 0;

$afx_arr= db_kv('afx`.`db_fixation','id_fixation','name');
$mfx_arr= db_kv('mfx`.`db_fixation','id_fixation','name');

if($afx<0) $afx=end(array_keys($afx_arr));
$target_table=($afx)?'`afx`.`db_fixed_target`':'`db_person`';
$target_table=($mfx)?'`mfx`.`db_fixed_target`':$target_table;


$fid=($afx)?"`fixation_id`=$afx AND ":'';
$fid=($mfx)?"`fixation_id`=$mfx AND ":$fid;

if($raw)
{
    ui_sp('Аналог (Платная сводная)');
    ui_gf();
    ui_stfs();
    ui_sfs();
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs();
    ui_select('', 'fc', 'Факультет', $fc_arr, $fc);
    ui_select('', 'tf', 'Отделение', $tf_arr, $tf);
    ui_select('','afx','Автоматическая',$afx_arr,$afx);
    ui_select('','mfx','Ручная',$mfx_arr,$mfx);
    ui_check('', 'raw', 'для вставки', 0);
    ui_submit('', '', '', 'Показать', '');
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs();
    ui_efs();
    ui_etfs();
    ui_ef0();
}
$dt = date('H:i');
$dd = date('d.m.Y');
ui_par("Данные на   $dt $dd");

ui_sfs();
ui_rep_row();
ui_rep_th('Факультет');
foreach ($fc_arr as $k => $v) {
    foreach ($tf_arr as $kk => $vv) {
        if ($view_paid[$k][$kk])
            ui_rep_th($v);
    }
}
ui_end_row();
ui_rep_row();
ui_rep_th('Форма');
foreach ($fc_arr as $k => $v) {
    foreach ($tf_arr as $kk => $vv) {
        if ($view_paid[$k][$kk])
            ui_rep_th($vv);
    }
}
ui_end_row();
ui_rep_row();
ui_rep_th('План');
foreach ($fc_arr as $k => $v) {
    foreach ($tf_arr as $kk => $vv) {
        if ($view_paid[$k][$kk])
            ui_rep_th($plan_paid[$k][$kk]);
    }
}
ui_end_row();

$sqlcolumns = array();
$sqlnulls = array();
foreach ($fc_arr as $k => $v) {
    foreach ($tf_arr as $kk => $vv) {
        if ($view_paid[$k][$kk]) {
            $sqlcolumns[] = "COUNT(IF(`faculty`='$k' AND `time_form_id`='$kk' AND `target`=3,total,null)) as c$k$kk";
            $sqlnulls[] = "COUNT(IF(`faculty`='$k' AND `time_form_id`='$kk' AND `target`=4,total,null)) as c$k$kk";
            $sqlouters[] = "COUNT(IF(`faculty`='$k' AND `time_form_id`='$kk' AND `target`=6,total,null)) as c$k$kk";
        }
    }
}

$sqlc = implode(',', $sqlcolumns);

$sqln = implode(', ', $sqlnulls);

$sqlo = implode(', ', $sqlouters);

$sql = <<<EOF
    (SELECT 900  as  `t`,
    
        $sqln
    FROM $target_table WHERE  $fid `state_id`=1 AND `edu_form`=2 group by `t` order by `t` desc)
    UNION
    (SELECT DISTINCT total as t,
        $sqlc
    FROM $target_table WHERE  $fid `state_id`=1 AND `edu_form`=2 group by `t` order by `t` desc)
    
    
    order by t desc

EOF;
$r = mysql_query($sql) or debug($sql, mysql_error());
$c = mysql_num_fields($r);
$summ_summ=array();
for ($i = 1; $i < $c; $i++) $summ_summ[$i]=0;
while ($l = mysql_fetch_row($r)) {
    ui_rep_row();
    
    $l_int=(int)$l[0];
//    if($l_int>0)
//    {
//	$lx=$l[0]-9;
//	$l_text="$lx-${l[0]}";
//    }
//    else
//    {
	$l_text="${l[0]}";
	if($l_int==900) $l_text="ПВК";
//    }
    
//    ui_rep_th($l[0]);
    ui_rep_th($l_text);
    for ($i = 1; $i < $c; $i++) {
        ui_rep_td(ui_nd($l[$i]));
        $summ_summ[$i]+=$l[$i];
    }
    ui_end_row();
}
ui_rep_row();
ui_rep_th('Всего');
for($i=1;$i<$c;$i++)
{
	ui_rep_th($summ_summ[$i]);
}


ui_end_row();

$sql=<<<EOF
    SELECT 'ПСК'  as  `t`,
    
        $sqlo
    FROM $target_table WHERE  $fid `state_id`=1 AND `edu_form`=2 group by `t` order by `t` desc

EOF;
$r = mysql_query($sql) or debug($sql, mysql_error());
while ($l = mysql_fetch_row($r)) {
    ui_rep_row();
    ui_rep_th($l[0]);
    for ($i = 1; $i < $c; $i++) {
        ui_rep_td(ui_nd($l[$i]));
        $summ_summ[$i]+=$l[$i];
    }
    ui_end_row();
}

ui_efs();

if($raw)
ui_ep();
