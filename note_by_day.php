<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC', 'report.note');
cr_logic();

$tf = isset($_GET['tf']) ? (int) $_GET['tf'] : 0;
$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 0;
$ef = isset($_GET['ef']) ? (int) $_GET['ef'] : 0;
$byday = isset($_GET['byday']) ? (int) $_GET['byday']: 0;
$raw = isset($_GET['raw']) ? (int) $_GET['raw'] : 1;

$fc_arr = db_kv('db_faculty', 'id', 'name');
$tf_arr = db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr = db_kv('db_ef', 'id_ef', 'name');
$cr_arr = db_kv('db_region', 'id_region', 'abbr');

unset($cr_arr[7]);

$wfc = ($fc) ? " AND `faculty`='$fc'" : '';
$wtf = ($tf) ? " AND `time_form_id`='$tf'" : '';
$wef = ($ef) ? " AND `edu_form`='$ef'" : '';
$byday = ($byday) ? "AND ( DAY(`ctime`)='$byday' OR DAY(`xtime`)='$byday') ":'';
/* ++ BYDAY ++ */
$options=array();
$sql = "SELECT DISTINCT DAY(`ctime`) ctime,MONTH(`ctime`) m FROM `db_person`";
$r = mysql_query($sql) or debug($sql, mysql_error());
$options['created'] = array();
while ($l = mysql_fetch_object($r)) {
    $options['created'][$l->ctime] = "$l->ctime.$l->m";
}
/* -- BYDAY -- */

if ($raw) {
    ui_sp('Справка за день');
    ui_gf();
    ui_stfs();
    ui_sfs();
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs();
#ui_select('', 'fc', 'Факультет', $fc_arr, $fc);
    ui_select('', 'tf', 'Отделение', $tf_arr, $tf);
    ui_select('', 'ef', 'Форма обучения', $ef_arr, $ef);
    ui_select('','byday','За день',$options['created'],$byday);
    ui_submit('', '', '', 'Показать', '');
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs();
    ui_efs();
    ui_etfs();
    ui_ef0();
}
$sql = <<<EOF
    SELECT faculty,
    (SELECT sum(db_planform.total)  FROM db_planform  WHERE (db_planform.faculty_id=db_person.faculty $wtf $wef)) as  planform,
    (SELECT sum(db_plancell.plan)  FROM db_plancell  WHERE (db_plancell.faculty_id=db_person.faculty)) as  plancell,
    count(if(`state_id`=1,`id`,null)) as pall,
    count(if(`state_id`=1 AND `target`=3 AND `target_type`=2,`id`,null)) as pgc,
    count(if(`state_id`=1 AND `target`=3 AND `target_type`=1,`id`,null)) as pgv,
    count(if(`state_id`=1 AND `target`=5,`id`,null)) as pmo,
    count(if(`state_id`=1 AND `target`=4,`id`,null)) as pvk,
    count(if(`state_id`=1 AND `target`=2,`id`,null)) as pbi,
    count(if(`state_id`=1 AND `target`=1 AND `region_cell`=1,`id`,null)) as c1,
    count(if(`state_id`=1 AND `target`=1 AND `region_cell`=2,`id`,null)) as c2,
    count(if(`state_id`=1 AND `target`=1 AND `region_cell`=3,`id`,null)) as c3,
    count(if(`state_id`=1 AND `target`=1 AND `region_cell`=4,`id`,null)) as c4,
    count(if(`state_id`=1 AND `target`=1 AND `region_cell`=5,`id`,null)) as c5,
    count(if(`state_id`=1 AND `target`=1 AND `region_cell`=6,`id`,null)) as c6,
    count(if(`state_id`=1 AND `target`=1,`id`,null)) as ca,
    count(if(`state_id`=2,`id`,null)) as pclo
    FROM `db_person` WHERE (`faculty` in (SELECT `id` FROM `db_faculty`) $byday $wtf $wef) 
    GROUP BY `faculty`

EOF;

$r = mysql_query($sql) or debug($sql, mysql_error());

ui_sfs('', 'w100');
ui_rep_row();
ui_rep_th('Факультет', '', '4');
ui_rep_th('План приёма', '2');
ui_rep_th('Подано заявлений', 5 + count($cr_arr) + 2);
ui_rep_th('Забрали документы', '', '4');
ui_end_row();

ui_rep_row();
ui_rep_th('Всего', '', '3');
ui_rep_th('Целевой', '', '3');
ui_rep_th('Всего', '', '3');
ui_rep_th('В том числе', 4 + count($cr_arr) + 2);
ui_end_row();

ui_rep_row();
ui_rep_th("Общий\nгородской\nконкурс", '', '2');

ui_rep_th("Общий\nсельский\nконкурс", '', '2');
ui_rep_th('Без исп.', '', '2');
ui_rep_th('ПВК.', '', '2');
ui_rep_th('МО', '', '2');
ui_rep_th('Целевой', count($cr_arr) + 1);
ui_end_row();

ui_rep_row();
foreach ($cr_arr as $v) {
    ui_rep_th($v);
}
ui_rep_th('Всего');
ui_end_row();

$sum = array(
    'planform' => 0,
    'plancell' => 0,
    'pall' => 0,
    'pbi' => 0,
    'pgc' => 0,
    'pgv' => 0,
    'pvk' => 0,
    'pmo' => 0,
    'c1' => 0,
    'c2' => 0,
    'c3' => 0,
    'c4' => 0,
    'c5' => 0,
    'c6' => 0,
    'ca' => 0,
    'pclo' => 0,
);

while ($l = mysql_fetch_object($r)) {
    ui_rep_row();
    ui_rep_th($fc_arr[$l->faculty]);
    ui_rep_td(ui_nd($l->planform));
    ui_rep_td(ui_nd($l->plancell));
    ui_rep_td(ui_nd($l->pall));
    ui_rep_td(ui_nd($l->pgc));
    ui_rep_td(ui_nd($l->pgv));
    ui_rep_td(ui_nd($l->pbi));
    ui_rep_td(ui_nd($l->pvk));
    ui_rep_td(ui_nd($l->pmo));
    ui_rep_td(ui_nd($l->c1));
    ui_rep_td(ui_nd($l->c2));
    ui_rep_td(ui_nd($l->c3));
    ui_rep_td(ui_nd($l->c4));
    ui_rep_td(ui_nd($l->c5));
    ui_rep_td(ui_nd($l->c6));
    ui_rep_td(ui_nd($l->ca));
    ui_rep_td(ui_nd($l->pclo));
    ui_end_row();

    $sum['planform']+=$l->planform;
    $sum['plancell']+=$l->plancell;
    $sum['pall']+=$l->pall;
    $sum['pgc']+=$l->pgc;
    $sum['pvk']+=$l->pvk;
    $sum['pbi']+=$l->pbi;
    $sum['pvk']+=$l->pvk;
    $sum['pmo']+=$l->pmo;
    $sum['c1']+=$l->c1;
    $sum['c2']+=$l->c2;
    $sum['c3']+=$l->c3;
    $sum['c4']+=$l->c4;
    $sum['c5']+=$l->c5;
    $sum['c6']+=$l->c6;
    $sum['ca']+=$l->ca;
    $sum['pclo']+=$l->pclo;
}
ui_rep_row();
ui_rep_th('Всего');
ui_rep_th($sum['planform']);
ui_rep_th($sum['plancell']);
ui_rep_th($sum['pall']);
ui_rep_th($sum['pgc']);
ui_rep_th($sum['pvk']);
ui_rep_th($sum['pbi']);
ui_rep_th($sum['pvk']);
ui_rep_th($sum['pmo']);
ui_rep_th($sum['c1']);
ui_rep_th($sum['c2']);
ui_rep_th($sum['c3']);
ui_rep_th($sum['c4']);
ui_rep_th($sum['c5']);
ui_rep_th($sum['c6']);
ui_rep_th($sum['ca']);
ui_rep_th($sum['pclo']);
ui_end_row();
ui_efs();

if ($raw)
    ui_ep();