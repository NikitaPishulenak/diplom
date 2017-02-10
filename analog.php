<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC', 'report.analog');
cr_logic();

$tf = isset($_GET['tf']) ? (int) $_GET['tf'] : 0;
$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 0;
$ef = isset($_GET['ef']) ? (int) $_GET['ef'] : 0;
$cut = isset($_GET['cut']) ? $_GET['cut'] : '';
$raw = isset($_GET['raw']) ? (int) $_GET['raw'] : 1;

$fc_arr = db_kv('db_faculty', 'id', 'name');
$tf_arr = db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr = db_kv('db_ef', 'id_ef', 'name');
$cr_arr = db_kv('db_region', 'id_region', 'abbr');
$tc_arr = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$cut=db_esc($cut);
unset($cr_arr[7]);

$wfc = ($fc) ? " AND `faculty`='$fc'" : '';
$wtf = ($tf) ? " AND `time_form_id`='$tf'" : '';
$wef = ($ef) ? " AND `edu_form`='$ef'" : '';
$wct = ($cut)? " `id` in (SELECT `person_id` FROM `db_target_history` WHERE (`vtime`<'$cut' AND (`xtime`>'$cut' OR `xtime`=0))) AND `state_id`<>0 ":"`state_id`='1'";

$afx = isset($_GET['afx']) ? (int) $_GET['afx'] : 0;
$mfx = isset($_GET['mfx']) ? (int) $_GET['mfx'] : 0;

$afx_arr= db_kv('afx`.`db_fixation','id_fixation','name');
$mfx_arr= db_kv('mfx`.`db_fixation','id_fixation','name');

if($afx<0) $afx=end(array_keys($afx_arr));
$target_table=($afx)?'`afx`.`db_fixed_target`':'`db_person`';
$target_table=($mfx)?'`mfx`.`db_fixed_target`':$target_table;


$fid=($afx)?"`fixation_id`=$afx AND ":'';
$fid=($mfx)?"`fixation_id`=$mfx AND ":$fid;

if ($raw) {
    ui_sp('Аналоговая таблица');
    ui_gf();
    ui_stfs();
    ui_sfs('Бюджет','w100');
    ui_trlink('','Лечебный','analog.php?fc=1&tf=1&ef=1');
    ui_trlink('','Мед-проф','analog.php?fc=2&tf=1&ef=1');
    ui_trlink('','Педиатрический','analog.php?fc=3&tf=1&ef=1');
    ui_trlink('','Стоматология','analog.php?fc=4&tf=1&ef=1');
    ui_trlink('','Фарма','analog.php?fc=6&tf=1&ef=1');
    ui_trlink('','Воен-мед ВС','analog.php?fc=8&tf=1&ef=1');
    ui_trlink('','Воен-мед ВВ','analog.php?fc=9&tf=1&ef=1');
    
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs('Фильтр','w100');
    ui_select('', 'fc', 'Факультет', $fc_arr, $fc);
    ui_select('', 'tf', 'Отделение', $tf_arr, $tf);
    ui_select('', 'ef', 'Форма обучения', $ef_arr, $ef);
    ui_select('','afx','Автоматическая',$afx_arr,$afx);
    ui_select('','mfx','Ручная',$mfx_arr,$mfx);
    ui_check('', 'raw', 'для вставки', 0);
    ui_submit('', '', '', 'Показать', '');
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs('За оплату','w100');
    ui_trlink('','Лечебный','analog.php?fc=1&tf=1&ef=2');
    ui_trlink('','Мед-проф','analog.php?fc=2&tf=1&ef=2');
    ui_trlink('','Педиатрический','analog.php?fc=3&tf=1&ef=2');
    ui_trlink('','Стоматология','analog.php?fc=4&tf=1&ef=2');
    ui_trlink('','Фарма дневная','analog.php?fc=6&tf=1&ef=2');
    ui_trlink('','Фарма заочная','analog.php?fc=6&tf=2&ef=2');
    ui_trlink('','Профориентации','analog.php?fc=7&tf=1&ef=2');
    ui_trlink('','МФИУ (Леч., рус.)','analog.php?fc=10&tf=1&ef=2');
    ui_trlink('','МФИУ (Леч., англ.)','analog.php?fc=11&tf=1&ef=2');
    ui_trlink('','МФИУ (Стом., рус.)','analog.php?fc=12&tf=1&ef=2');
    ui_trlink('','МФИУ (Стом., англ.)','analog.php?fc=13&tf=1&ef=2');
    ui_trlink('','МФИУ (Мед-проф., рус.)','analog.php?fc=14&tf=1&ef=2');
    ui_trlink('','МФИУ (Фарм., рус.)','analog.php?fc=15&tf=1&ef=2');
    ui_trlink('','МФИУ (Фарм., англ.)','analog.php?fc=16&tf=1&ef=2');
    
    ui_efs();
    ui_etfs();
    ui_ef0();
}
ui_sfs('', 'w100');
ui_rep_row();
ui_rep_th('Балл', 0, 2);
ui_rep_th('Общий конкурс');
if ($fc == 6)
    ui_rep_th('Целевой приём', count($cr_arr) * 2);
else
    ui_rep_th('Целевой приём', count($cr_arr));
ui_end_row();

ui_rep_row();
ui_rep_th('');

foreach ($cr_arr as $v) {
    
    if ($fc == 6)
        ui_rep_th($v, 2);
    else
        ui_rep_th($v);
}
ui_end_row();
if($fc == 6)
{
    ui_rep_row();
        ui_rep_th('Целевой конкурс',2);
        foreach($cr_arr as $v)
        {
            foreach($tc_arr as $vv)
            {
                ui_rep_th($vv);
            }
        }
    ui_end_row();
}

$sql = <<<EOF
    (SELECT 800 as t,
    count(if(`target`=6,`total`,null)) as tall,
    count(if(`target`=6,`total`,null)) as t1,
    null t2,
    null c1,
    null c2,
    null c3,
    null c4,
    null c5,
    null c6,
    null c11,
    null c12,
    null c13,
    null c14,
    null c15,
    null c16,
    null c21,
    null c22,
    null c23,
    null c24,
    null c25,
    null c26
    FROM $target_table WHERE ( $fid $wct AND `target`=6 $wfc $wtf $wef) GROUP BY `t` ) 
    UNION
    (SELECT 700 as t,
    count(if(`target`=4,`total`,null)) as tall,
    count(if(`target`=4,`total`,null)) as t1,
    null t2,
    null c1,
    null c2,
    null c3,
    null c4,
    null c5,
    null c6,
    null c11,
    null c12,
    null c13,
    null c14,
    null c15,
    null c16,
    null c21,
    null c22,
    null c23,
    null c24,
    null c25,
    null c26
    FROM $target_table WHERE ( $fid $wct AND `target`=4  $wfc $wtf $wef) GROUP BY `t` ) 
    UNION 
    (SELECT 600 as t,
    count(if(`target`=5,`total`,null)) as tall,
    count(if(`target`=5 ,`total`,null)) as t1,
    null t2,
    null c1,
    null c2,
    null c3,
    null c4,
    null c5,
    null c6,
    null c11,
    null c12,
    null c13,
    null c14,
    null c15,
    null c16,
    null c21,
    null c22,
    null c23,
    null c24,
    null c25,
    null c26
    FROM $target_table WHERE ( $fid $wct AND `target`=5  $wfc $wtf $wef) GROUP BY `t` ) 
    UNION 
    (SELECT 500 as t,
    count(if(`target`=2,`total`,null)) as tall,
    count(if(`target`=2 ,`total`,null)) as t1,
    null t2,
    null c1,
    null c2,
    null c3,
    null c4,
    null c5,
    null c6,
    null c11,
    null c12,
    null c13,
    null c14,
    null c15,
    null c16,
    null c21,
    null c22,
    null c23,
    null c24,
    null c25,
    null c26
    FROM $target_table WHERE ( $fid $wct AND `target`=2  $wfc $wtf $wef) GROUP BY `t` ) 
    UNION 
    (SELECT DISTINCT total as t,
    count(if(`target`=3,`total`,null)) as tall,
    count(if(`target`=3 AND `target_type`=1,`total`,null)) as t1,
    count(if(`target`=3 AND `target_type`=2,`total`,null)) as t2,
    count(if(`target`=1 AND `region_cell`=1,`total`,null)) as c1,
    count(if(`target`=1 AND `region_cell`=2,`total`,null)) as c2,
    count(if(`target`=1 AND `region_cell`=3,`total`,null)) as c3,
    count(if(`target`=1 AND `region_cell`=4,`total`,null)) as c4,
    count(if(`target`=1 AND `region_cell`=5,`total`,null)) as c5,
    count(if(`target`=1 AND `region_cell`=6,`total`,null)) as c6,
    count(if(`target`=1 AND `region_cell`=1 AND `target_cell`=1,`total`,null)) as c11,
    count(if(`target`=1 AND `region_cell`=2 AND `target_cell`=1,`total`,null)) as c12,
    count(if(`target`=1 AND `region_cell`=3 AND `target_cell`=1,`total`,null)) as c13,
    count(if(`target`=1 AND `region_cell`=4 AND `target_cell`=1,`total`,null)) as c14,
    count(if(`target`=1 AND `region_cell`=5 AND `target_cell`=1,`total`,null)) as c15,
    count(if(`target`=1 AND `region_cell`=6 AND `target_cell`=1,`total`,null)) as c16,

    count(if(`target`=1 AND `region_cell`=1 AND `target_cell`=2,`total`,null)) as c21,
    count(if(`target`=1 AND `region_cell`=2 AND `target_cell`=2,`total`,null)) as c22,
    count(if(`target`=1 AND `region_cell`=3 AND `target_cell`=2,`total`,null)) as c23,
    count(if(`target`=1 AND `region_cell`=4 AND `target_cell`=2,`total`,null)) as c24,
    count(if(`target`=1 AND `region_cell`=5 AND `target_cell`=2,`total`,null)) as c25,
    count(if(`target`=1 AND `region_cell`=6 AND `target_cell`=2,`total`,null)) as c26
    FROM $target_table WHERE ( $fid $wct AND (`target`=3 or `target`=1) $wfc $wtf $wef) GROUP BY `t` ) ORDER BY `t` DESC;
EOF;

$r = mysql_query($sql) or debug($sql, mysql_error());



$sum = array(
    'tall' => 0,
    't1' => 0,
    't2' => 0,
    'c1' => 0,
    'c2' => 0,
    'c3' => 0,
    'c4' => 0,
    'c5' => 0,
    'c6' => 0,
    'c11' => 0,
    'c12' => 0,
    'c13' => 0,
    'c14' => 0,
    'c15' => 0,
    'c16' => 0,
    'c21' => 0,
    'c22' => 0,
    'c23' => 0,
    'c24' => 0,
    'c25' => 0,
    'c26' => 0,
);

while ($l = mysql_fetch_array($r)) {
    $l['t'] = ($l['t'] == '800') ? 'ПСК' : $l['t'];
    $l['t'] = ($l['t'] == '700') ? 'ПВК' : $l['t'];
    $l['t'] = ($l['t'] == '600') ? 'МО' : $l['t'];
    $l['t'] = ($l['t'] == '500') ? 'БИ' : $l['t'];

    $sum['tall']+=$l['tall'];
    $sum['t1']+=$l['t1'];
   // $sum['t2']+=$l['t2'];
    $sum['c1']+=$l['c1'];
    $sum['c2']+=$l['c2'];
    $sum['c3']+=$l['c3'];
    $sum['c4']+=$l['c4'];
    $sum['c5']+=$l['c5'];
    $sum['c6']+=$l['c6'];

    $sum['c11']+=$l['c11'];
    $sum['c12']+=$l['c12'];
    $sum['c13']+=$l['c13'];
    $sum['c14']+=$l['c14'];
    $sum['c15']+=$l['c15'];
    $sum['c16']+=$l['c16'];
    $sum['c21']+=$l['c21'];
    $sum['c22']+=$l['c22'];
    $sum['c23']+=$l['c23'];
    $sum['c24']+=$l['c24'];
    $sum['c25']+=$l['c25'];
    $sum['c26']+=$l['c26'];
    
    ui_rep_row();
    ui_rep_th($l['t']);
    
    if($ef ==1){
        ui_rep_td(ui_nd($l['t1']));
//	ui_rep_td(ui_nd($l['t2']));
    }
    else
    {
	ui_rep_td(ui_nd($l['tall']));
//	ui_rep_td(ui_nd('-'));
    }
    
    if ($fc != 6) {
        ui_rep_td(ui_nd($l['c1']));
        ui_rep_td(ui_nd($l['c2']));
        ui_rep_td(ui_nd($l['c3']));
        ui_rep_td(ui_nd($l['c4']));
        ui_rep_td(ui_nd($l['c5']));
        ui_rep_td(ui_nd($l['c6']));
    } else {
        ui_rep_td(ui_nd($l['c11']));
        ui_rep_td(ui_nd($l['c21']));
        ui_rep_td(ui_nd($l['c12']));
        ui_rep_td(ui_nd($l['c22']));
        ui_rep_td(ui_nd($l['c13']));
        ui_rep_td(ui_nd($l['c23']));
        ui_rep_td(ui_nd($l['c14']));
        ui_rep_td(ui_nd($l['c24']));
        ui_rep_td(ui_nd($l['c15']));
        ui_rep_td(ui_nd($l['c25']));
        ui_rep_td(ui_nd($l['c16']));
        ui_rep_td(ui_nd($l['c26']));
    }
    ui_end_row();
}

ui_rep_row();
ui_rep_th('Всего');
if($ef ==1){
        ui_rep_th($sum['t1']);
//	ui_rep_th($sum['t2']);
    }
    else
    {
	ui_rep_th($sum['tall']);
//	ui_rep_th(ui_nd('-'));
    }
if ($fc == 6) {
    ui_rep_th($sum['c11']);
    ui_rep_th($sum['c21']);
    ui_rep_th($sum['c12']);
    ui_rep_th($sum['c22']);
    ui_rep_th($sum['c13']);
    ui_rep_th($sum['c23']);
    ui_rep_th($sum['c14']);
    ui_rep_th($sum['c24']);
    ui_rep_th($sum['c15']);
    ui_rep_th($sum['c25']);
    ui_rep_th($sum['c16']);
    ui_rep_th($sum['c26']);
    
} else {
    ui_rep_th($sum['c1']);
    ui_rep_th($sum['c2']);
    ui_rep_th($sum['c3']);
    ui_rep_th($sum['c4']);
    ui_rep_th($sum['c5']);
    ui_rep_th($sum['c6']);
}
ui_end_row();

ui_efs();

if ($raw)
    ui_ep();