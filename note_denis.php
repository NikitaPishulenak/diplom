<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC', 'report.note');
cr_logic();

$raw = isset($_GET['raw']) ? (int) $_GET['raw'] : 1;
$afx = isset($_GET['afx']) ? (int) $_GET['afx'] : 0;
$mfx = isset($_GET['mfx']) ? (int) $_GET['mfx'] : 0;

$afx_arr= db_kv('afx`.`db_fixation','id_fixation','name');
$mfx_arr= db_kv('mfx`.`db_fixation','id_fixation','name');

if($afx<0) $afx=end(array_keys($afx_arr));
$target_table=($afx)?'`afx`.`db_fixed_target`':'`db_person`';
$target_table=($mfx)?'`mfx`.`db_fixed_target`':$target_table;

$fid=($afx)?"`fixation_id`=$afx AND ":'';
$fid=($mfx)?"`fixation_id`=$mfx AND ":$fid;

$target_key=($afx || $mfx)?'`person_id`':'`id`';

ui_sp('Справка / Ректорат');

if($raw)
{
ui_gf();
    ui_stfs('Фиксационная выборка');
    ui_sfs();
    ui_select('','afx','Автоматическая',$afx_arr,$afx);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_select('','mfx','Ручная',$mfx_arr,$mfx);    
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_check('', 'raw', 'для печати', 0);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_submit('', '', '', 'Показать', '');
    ui_efs();
    ui_etfs();
ui_ef0();
}

$dt = date('H:i');
$dd = date('d.m.Y');
ui_par("Данные на   $dt $dd");



$sql=<<<EOF
(select 
faculty,
time_form_id,
(select name from db_faculty where id=$target_table.faculty) faculty_name,
(select name from db_time_form where id_time_form=$target_table.time_form_id) tf_name,
(select sum(total) from db_planform where faculty_id=$target_table.faculty and edu_form_id=1 and time_form_id=1) plan_free,
(select sum(plan) from db_plancell where faculty_id=$target_table.faculty ) plan_cell,
(select sum(total) from db_planform where faculty_id=$target_table.faculty and edu_form_id=2 and time_form_id=1) plan_paid,
count(if(`state_id`=1,$target_key,null) ) have_all,
count(if(`state_id`=1 and edu_form=1,$target_key,null) ) have_free_all,
count(if(`state_id`=1 and edu_form=1 and `target`=3 and `target_type`=1,$target_key,null)) have_city,
count(if(`state_id`=1 and edu_form=1 and `target`=3 and `target_type`=2,$target_key,null)) have_vile,
count(if(`state_id`=1 and edu_form=1 and `target`=2,$target_key,null)) have_bi,
count(if(`state_id`=1 and edu_form=1 and `target`=5,$target_key,null)) have_mo,
count(if(`state_id`=1 and edu_form=1 and `target`=1 ,$target_key,null)) have_cell,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1,$target_key,null)) have_cell1,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2,$target_key,null)) have_cell2,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=1,$target_key,null)) have_cell_c1,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=2,$target_key,null)) have_cell_c2,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=3,$target_key,null)) have_cell_c3,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=4,$target_key,null)) have_cell_c4,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=5,$target_key,null)) have_cell_c5,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=6,$target_key,null)) have_cell_c6,

count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=1,$target_key,null)) have_cell_c11,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=2,$target_key,null)) have_cell_c12,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=3,$target_key,null)) have_cell_c13,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=4,$target_key,null)) have_cell_c14,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=5,$target_key,null)) have_cell_c15,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=6,$target_key,null)) have_cell_c16,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=7,$target_key,null)) have_cell_c17,

count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=1,$target_key,null)) have_cell_c21,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=2,$target_key,null)) have_cell_c22,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=3,$target_key,null)) have_cell_c23,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=4,$target_key,null)) have_cell_c24,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=5,$target_key,null)) have_cell_c25,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=6,$target_key,null)) have_cell_c26,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=7,$target_key,null)) have_cell_c27,


count(if(`state_id`=1 and edu_form=2,$target_key,null) ) have_paid_all,
count(if(`state_id`=1 and edu_form=2 and `target`=3, $target_key,null)) have_paid_gen,
count(if(`state_id`=1 and edu_form=2 and `target`=4, $target_key,null)) have_paid_pvk,
count(if(`state_id`=1 and edu_form=2 and `target`=6, $target_key,null)) have_paid_psk,
count(if(`state_id`=2,$target_key,null) ) have_closed
from $target_table where ( $fid  faculty in (select id from db_faculty where id NOT IN (7))) and time_form_id=1
group by faculty)
union
(select 
faculty,
time_form_id,
(select name from db_faculty where id=$target_table.faculty) faculty_name,
(select name from db_time_form where id_time_form=$target_table.time_form_id) tf_name,
(select sum(total) from db_planform where faculty_id=$target_table.faculty and edu_form_id=1 and time_form_id=2) plan_free,
0 plan_cell,
(select sum(total) from db_planform where faculty_id=$target_table.faculty and edu_form_id=2 and time_form_id=2) plan_paid,
count(if(`state_id`=1,$target_key,null) ) have_all,
count(if(`state_id`=1 and edu_form=1,$target_key,null) ) have_free_all,
count(if(`state_id`=1 and edu_form=1 and `target`=3 and `target_type`=1,$target_key,null)) have_city,
count(if(`state_id`=1 and edu_form=1 and `target`=3 and `target_type`=2,$target_key,null)) have_vile,
count(if(`state_id`=1 and edu_form=1 and `target`=2,$target_key,null)) have_bi,
count(if(`state_id`=1 and edu_form=1 and `target`=5,$target_key,null)) have_mo,
count(if(`state_id`=1 and edu_form=1 and `target`=1 ,$target_key,null)) have_cell,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1,$target_key,null)) have_cell1,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2,$target_key,null)) have_cell2,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=1,$target_key,null)) have_cell_c1,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=2,$target_key,null)) have_cell_c2,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=3,$target_key,null)) have_cell_c3,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=4,$target_key,null)) have_cell_c4,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=5,$target_key,null)) have_cell_c5,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and region_cell=6,$target_key,null)) have_cell_c6,


count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=1,$target_key,null)) have_cell_c11,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=2,$target_key,null)) have_cell_c12,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=3,$target_key,null)) have_cell_c13,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=4,$target_key,null)) have_cell_c14,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=5,$target_key,null)) have_cell_c15,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=6,$target_key,null)) have_cell_c16,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=1 and region_cell=7,$target_key,null)) have_cell_c17,

count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=1,$target_key,null)) have_cell_c21,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=2,$target_key,null)) have_cell_c22,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=3,$target_key,null)) have_cell_c23,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=4,$target_key,null)) have_cell_c24,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=5,$target_key,null)) have_cell_c25,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=6,$target_key,null)) have_cell_c26,
count(if(`state_id`=1 and edu_form=1 and `target`=1 and target_cell=2 and region_cell=7,$target_key,null)) have_cell_c27,


count(if(`state_id`=1 and edu_form=2,$target_key,null) ) have_paid_all,
count(if(`state_id`=1 and edu_form=2 and `target`=3, $target_key,null)) have_paid_gen,
count(if(`state_id`=1 and edu_form=2 and `target`=4, $target_key,null)) have_paid_pvk,
count(if(`state_id`=1 and edu_form=2 and `target`=6, $target_key,null)) have_paid_psk,
count(if(`state_id`=2,$target_key,null) ) have_closed
from $target_table where ( $fid faculty in (select id from db_faculty where id<7)) and time_form_id=2
group by faculty)
EOF;

$r=mysql_query($sql) or debug($sql,mysql_error());

ui_sfs('','w100','t1');
    ui_rep_row();
	ui_rep_th('Факультет',0,4);
//	ui_rep_th('Форма',0,4);
	ui_rep_th('План приёма',3,2);
	ui_rep_th('Подано заявлений',16);
	ui_rep_th('Забрали',0,4);
    ui_end_row();
    
    ui_rep_row();
    ui_rep_th('Всего',0,3);
    ui_rep_th('Бюджет',11);
    ui_rep_th('За оплату',4);
    ui_end_row();

    
    ui_rep_row();
//    ui_rep_th('Факультет');
//    ui_rep_th('Форма');
    ui_rep_th('Бюджет',0,2);
    ui_rep_th('в т.ч. Целевой',0,2);
    ui_rep_th('Платно',0,2);
//    ui_rep_th('Всего');
    ui_rep_th('Бюджет всего',0,2);
    ui_rep_th('Общий ',1,2);
 //   ui_rep_th('Общий Сель.',0,2);
    ui_rep_th('МО',0,2);
    ui_rep_th('БИ',0,2);
    ui_rep_th('&sum;Ц',0,2);
    ui_rep_th('Целевой конкурс',6);
    ui_rep_th('Платно всего',0,2);
    ui_rep_th('Общий',0,2);
    ui_rep_th('ПВК',0,2);
    ui_rep_th('ПСК',0,2);
//    ui_rep_th('Забрали');
    ui_end_row();
    
    ui_rep_row();
//    ui_rep_th('&sum;');
    ui_rep_th('Бр');
    ui_rep_th('Вт');
    ui_rep_th('Го');
    ui_rep_th('Гр');
    ui_rep_th('Мн');
    ui_rep_th('Мг');
    //ui_rep_th('Минск');    /// Минск
    
    ui_end_row();


    $sum_plan_free=0;
    $sum_plan_cell=0;
    $sum_plan_paid=0;
    $sum_have_all=0;
    $sum_have_free_all=0;
    $sum_have_city=0;
    $sum_have_vile=0;
    $sum_have_bi=0;
    $sum_have_mo=0;
    $sum_have_cell=0;
    $sum_have_cell_c1=0;
    $sum_have_cell_c2=0;
    $sum_have_cell_c3=0;
    $sum_have_cell_c4=0;
    $sum_have_cell_c5=0;
    $sum_have_cell_c6=0;
    $sum_have_cell_c11=0;
    $sum_have_cell_c12=0;
    $sum_have_cell_c13=0;
    $sum_have_cell_c14=0;
    $sum_have_cell_c15=0;
    $sum_have_cell_c16=0;
    $sum_have_cell_c21=0;
    $sum_have_cell_c22=0;
    $sum_have_cell_c23=0;
    $sum_have_cell_c24=0;
    $sum_have_cell_c25=0;
    $sum_have_cell_c26=0;

    $sum_have_cell_c27=0;
    $sum_have_cell_с17=0;
    

    $sum_have_paid_all=0;
    $sum_have_paid_gen=0;
    $sum_have_paid_pvk=0;
    $sum_have_paid_psk=0;
    $sum_have_closed=0;


while($l=mysql_fetch_object($r))
{
    ui_rep_row();
    if($l->time_form_id==1)
    {
	ui_rep_th($l->faculty_name);
    }
    else
    {
	ui_rep_th($l->faculty_name.' (заочное)');
    }
    
//    ui_rep_th($l->tf_name);
    ui_rep_td($l->plan_free);
    ui_rep_td($l->plan_cell);
    ui_rep_td($l->plan_paid);
    ui_rep_td(ui_nd($l->have_all));
    ui_rep_td(ui_nd($l->have_free_all));
    ui_rep_td(ui_nd($l->have_city+$l->have_vile));
    //ui_rep_td(ui_nd($l->have_vile));
    ui_rep_td(ui_nd($l->have_mo));
    ui_rep_td(ui_nd($l->have_bi));
    ui_rep_td(ui_nd($l->have_cell));
    ui_rep_td(ui_nd($l->have_cell_c1));
    ui_rep_td(ui_nd($l->have_cell_c2));
    ui_rep_td(ui_nd($l->have_cell_c3));
    ui_rep_td(ui_nd($l->have_cell_c4));
    ui_rep_td(ui_nd($l->have_cell_c5));
    ui_rep_td(ui_nd($l->have_cell_c6));
//    ui_rep_th('');
    ui_rep_td(ui_nd($l->have_paid_all));
    ui_rep_td(ui_nd($l->have_paid_gen));
    ui_rep_td(ui_nd($l->have_paid_pvk));
    ui_rep_td(ui_nd($l->have_paid_psk));
    ui_rep_td(ui_nd($l->have_closed));
    ui_end_row();

    if($l->faculty==6 && $l->time_form_id==1)
    {
	ui_rep_row();
	ui_rep_th('-//-');
	ui_rep_th('УЗО',8);
	ui_rep_td(ui_nd($l->have_cell1));
	ui_rep_td(ui_nd($l->have_cell_c11));
	ui_rep_td(ui_nd($l->have_cell_c12));
	ui_rep_td(ui_nd($l->have_cell_c13));
	ui_rep_td(ui_nd($l->have_cell_c14));
	ui_rep_td(ui_nd($l->have_cell_c15));
	ui_rep_td(ui_nd($l->have_cell_c16));
//	ui_rep_td(ui_nd($l->have_cell_c17));   /// Минск
	ui_rep_th('',5);
	ui_end_row();
	ui_rep_row();
	ui_rep_th('-//-');
	ui_rep_th('ТПРУП "Фармация"',8);
	ui_rep_td(ui_nd($l->have_cell2));
	ui_rep_td(ui_nd($l->have_cell_c21));
	ui_rep_td(ui_nd($l->have_cell_c22));
	ui_rep_td(ui_nd($l->have_cell_c23));
	ui_rep_td(ui_nd($l->have_cell_c24));
	ui_rep_td(ui_nd($l->have_cell_c25));
	ui_rep_td(ui_nd($l->have_cell_c26));
//	ui_rep_td(ui_nd($l->have_cell_c27));   /// Минск
	ui_rep_th('',5);
	ui_end_row();

	ui_rep_row();
	ui_rep_th("Фармацевтический");
	ui_rep_th('На 2-ой курс',2);
	$plan_nd = mysql_result(mysql_query("select sum(total) from admx.db_planform where faculty_id=6 and time_form_id=5"),0); 
	$paid_nd = mysql_result(mysql_query("select count(".$target_key.") from ".$target_table." where time_form_id=5 AND state_id=1"),0); 
	ui_rep_td(ui_nd($plan_nd));
	ui_rep_td(ui_nd($paid_nd));
	ui_rep_th(' ',12);
	ui_rep_td(ui_nd(($paid_nd) ? $paid_nd : '-'));
	ui_rep_th(' ',4);
	ui_end_row();



    }             

    
    $sum_plan_free+=$l->plan_free;
    $sum_plan_cell+=$l->plan_cell;
    $sum_plan_paid+=$l->plan_paid;
    $sum_have_all+=$l->have_all;
    $sum_have_free_all+=$l->have_free_all;
    $sum_have_city+=$l->have_city+$l->have_vile;
    $sum_have_bi+=$l->have_bi;
    $sum_have_mo+=$l->have_mo;
    $sum_have_cell+=$l->have_cell;
    $sum_have_cell_c1+=$l->have_cell_c1;
    $sum_have_cell_c2+=$l->have_cell_c2;
    $sum_have_cell_c3+=$l->have_cell_c3;
    $sum_have_cell_c4+=$l->have_cell_c4;
    $sum_have_cell_c5+=$l->have_cell_c5;
    $sum_have_cell_c6+=$l->have_cell_c6;

    $sum_have_paid_all+=$l->have_paid_all;
    $sum_have_paid_gen+=$l->have_paid_gen;
    $sum_have_paid_pvk+=$l->have_paid_pvk;
    $sum_have_paid_psk+=$l->have_paid_psk;
    $sum_have_closed+=$l->have_closed;
    
    
    
}
    ui_rep_row();
    ui_rep_th('Всего');
//    ui_rep_th('Форма');
    ui_rep_th($sum_plan_free);
    ui_rep_th($sum_plan_cell);
    ui_rep_th($sum_plan_paid);
    ui_rep_th($sum_have_all);
    ui_rep_th($sum_have_free_all);
    ui_rep_th($sum_have_city);
   // ui_rep_th($sum_have_vile);
    ui_rep_th($sum_have_mo);
    ui_rep_th($sum_have_bi);
    //ui_rep_th($sum_have_mo);
    ui_rep_th($sum_have_cell);
    ui_rep_th($sum_have_cell_c1);
    ui_rep_th($sum_have_cell_c2);
    ui_rep_th($sum_have_cell_c3);
    ui_rep_th($sum_have_cell_c4);
    ui_rep_th($sum_have_cell_c5);
    ui_rep_th($sum_have_cell_c6);
//    ui_rep_th('');
    ui_rep_th($sum_have_paid_all);
    ui_rep_th($sum_have_paid_gen);
    ui_rep_th($sum_have_paid_pvk);
    ui_rep_th($sum_have_paid_psk);
    ui_rep_th($sum_have_closed);
    ui_end_row();


ui_efs();

ui_hr();

print<<<EOF
<p style="page-break-after:always;"></p>
EOF;

$fc_arr = db_kv('db_faculty', 'id', 'name');
$tf_arr = db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr = db_kv('db_ef', 'id_ef', 'name');
$cr_arr = db_kv('db_region', 'id_region', 'abbr');
$tc_arr = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$tt_arr = db_kv('db_targettype', 'id_targettype', 'abbr');

$cell_rows = array();
$cell_plan = array();
$cell_live = array();
$cell_diff = array();
$cell_ball = array();
$cell_mest = array();
$cell_xout = array();
$pgv__live = array();
$pgc__live = array();
$mo___mest = array();
$bi___mest = array();
$prop_mest = array();
$cell_tout = array();
$cell_warn = array();
$cout_summ = array();
$rell_diff = array();

foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        foreach ($cr_arr as $kkk => $vvv) {
            $cell_plan[$k][$kk][$kkk] = 0;
            $cell_live[$k][$kk][$kkk] = 0;
            $cell_diff[$k][$kk][$kkk] = 0;
            $cell_ball[$k][$kk][$kkk] = 0;
            $rell_diff[$kkk] = 0;
            $cell_xout[$k][$kk][$kkk] = array();
            $cell_tout[$k][$kk][$kkk] = array();
        }
        $cell_rows[$k][$kk] = false;
    }
    $cell_mest[$k] = 0;
    $mo___mest[$k] = 0;
    $bi___mest[$k] = 0;
    $prop_mest[$k] = 0;
    $pgv__mest[$k] = 0;
    $pgc__mest[$k] = 0;
    $cell_warn[$k] = false;
    $cout_summ[$k] = 0;
}
//ui_sp("Проходной балл (бюджет)");

/** @link  ++ ROUND 1 ++ * */
$sql = "SELECT * FROM `db_plancell`";
$r = mysql_query($sql) or debug($sql, mysql_error());
while ($l = mysql_fetch_object($r)) {
    $cell_plan[$l->faculty_id][$l->targetcell_id][$l->region_id] = $l->plan;
}
ui_sfs(ui_hidelink().'План целевого набора', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!array_sum($cell_plan[$k][$kk]))
            continue; else
            $cell_rows[$k][$kk] = true;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);
        $s = 0;
        foreach ($cr_arr as $kkk => $vvv) {
            ui_rep_td($cell_plan[$k][$kk][$kkk]);
            $s+=$cell_plan[$k][$kk][$kkk];
        }
        ui_rep_th($s);
        ui_end_row();
    }
}
ui_efs();

$sql = "TRUNCATE table `db_ball_temp`";
$r = mysql_query($sql) or debug($sql, mysql_error());

$sql = "INSERT INTO `db_ball_temp` (`faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`person_id`) SELECT `faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,$target_key from $target_table WHERE  $fid `state_id`=1";
$r = mysql_query($sql) or debug($sql, mysql_error());


/** @link  ++ ROUND 2 ++ * */
$sql = "SELECT `faculty`,`target_cell`,`region_cell` from `db_ball_temp` WHERE  `time_form_id`=1 AND `edu_form`=1  AND `target`=1";
$r = mysql_query($sql) or debug($sql, mysql_error());
while ($l = mysql_fetch_object($r))
    $cell_live[$l->faculty][$l->target_cell][$l->region_cell]++;

ui_sfs(ui_hidelink().'Количество поданных целевых', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!$cell_rows[$k][$kk])
            continue;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);
        $s = 0;
        foreach ($cr_arr as $kkk => $vvv) {
    	    if($cell_plan[$k][$kk][$kkk]==0)
    	    {
    		ui_rep_td('-');
    	    }
    	    else
    	    {
        	ui_rep_td($cell_live[$k][$kk][$kkk]);
    	    }
            $s+=$cell_live[$k][$kk][$kkk];
        }
        ui_rep_th($s);
        ui_end_row();
    }
}
ui_efs();

/** @link ++ ROUND 3 ++ * */
foreach ($fc_arr as $k => $v)
    foreach ($tc_arr as $kk => $vv)
        foreach ($cr_arr as $kkk => $vvv)
            $cell_diff[$k][$kk][$kkk] = $cell_plan[$k][$kk][$kkk] - $cell_live[$k][$kk][$kkk];

ui_sfs(ui_hidelink().'Нехватка целевых договоров', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!$cell_rows[$k][$kk])
            continue;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);
        $s = 0;
        foreach ($cr_arr as $kkk => $vvv) {
        
            $t=($cell_diff[$k][$kk][$kkk]<0)?'K+'.abs($cell_diff[$k][$kk][$kkk]):$cell_diff[$k][$kk][$kkk];
            $t=($cell_diff[$k][$kk][$kkk]==0)?'К':$t;;
            //ui_rep_td($cell_diff[$k][$kk][$kkk]);
            if($cell_plan[$k][$kk][$kkk]==0)
    	    {
    		ui_rep_td('-');
    	    }
    	    else
    	    {
        	ui_rep_td($t);
            }
            $s+=($cell_diff[$k][$kk][$kkk]>0)?$cell_diff[$k][$kk][$kkk]:0;
            $rell_diff[$kkk]+=($cell_diff[$k][$kk][$kkk]>0)?$cell_diff[$k][$kk][$kkk]:0;
            $cell_mest[$k]+=($cell_diff[$k][$kk][$kkk] < 0) ? $cell_plan[$k][$kk][$kkk] : $cell_live[$k][$kk][$kkk];
        }
        ui_rep_th($s);
        ui_end_row();
    }
}
ui_rep_row();
    ui_rep_th('Всего не хватает:',2);
    foreach($cr_arr as $kk => $v)
    {
	ui_rep_th($rell_diff[$kk]);
    }
    ui_rep_th(array_sum($rell_diff));
ui_end_row();
ui_efs();


ui_ep();