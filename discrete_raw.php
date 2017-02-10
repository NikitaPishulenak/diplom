<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC', 'report.discrete_raw');
cr_logic();

$tf = isset($_GET['tf']) ? (int) $_GET['tf'] : 0;
$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 0;
$ef = isset($_GET['ef']) ? (int) $_GET['ef'] : 0;
$cut = isset($_GET['cut']) ? $_GET['cut'] : '';
$raw = isset($_GET['raw']) ? (int) $_GET['raw'] : 1;

$raw = isset($_GET['raw']) ? (int) $_GET['raw'] : 1;
$afx = isset($_GET['afx']) ? (int) $_GET['afx'] : 0;
$mfx = isset($_GET['mfx']) ? (int) $_GET['mfx'] : 0;

$afx_arr= db_kv('afx`.`db_fixation','id_fixation','name');
$mfx_arr= db_kv('mfx`.`db_fixation','id_fixation','name');

$afxk=array_keys($afx_arr);
if($afx<0) $afx=end($afxk);
$target_table=($afx)?'`afx`.`db_fixed_target`':'`db_person`';
$target_table=($mfx)?'`mfx`.`db_fixed_target`':$target_table;

$fid=($afx)?"`fixation_id`=$afx AND ":'';
$fid=($mfx)?"`fixation_id`=$mfx AND ":$fid;

$target_key=($afx || $mfx)?'`person_id`':'`id`';

$fc_arr = db_kv('db_faculty', 'id', 'name');
$tf_arr = db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr = db_kv('db_ef', 'id_ef', 'name');
$cr_arr = db_kv('db_region', 'id_region', 'abbr');
$cut=db_esc($cut);
unset($cr_arr[7]);

$wfc = ($fc) ? " AND `faculty`='$fc'" : '';
$wtf = ($tf) ? " AND `time_form_id`='$tf'" : '';
$wef = ($ef) ? " AND `edu_form`='$ef'" : '';
$wct = ($cut)? " `id` in (SELECT `person_id` FROM `db_target_history` WHERE (`vtime`<'$cut' AND (`xtime`>'$cut' OR `xtime`=0))) AND `state_id`<>0 ":"`state_id`='1'";
if ($raw) {
    ui_sp('Дискретная таблица номеров дел');
    ui_gf();
    ui_stfs();
    ui_sfs();
    /*ui_trlink('', 'Лечебный', 'discrete_raw.php?fc=1&tf=1&ef=1');
    ui_trlink('', 'Мед-проф', 'discrete_raw.php?fc=2&tf=1&ef=1');
    ui_trlink('', 'Педиатрический', 'discrete_raw.php?fc=3&tf=1&ef=1');
    ui_trlink('', 'Стоматология', 'discrete_raw.php?fc=4&tf=1&ef=1');
    ui_trlink('', 'Воен-мед', 'discrete_raw.php?fc=5&tf=1&ef=1');
    ui_trlink('', 'Фарма дневная', 'discrete_raw.php?fc=6&tf=1&ef=1');
    ui_trlink('', 'Фарма заочная', 'discrete_raw.php?fc=6&tf=2&ef=1');*/
    ui_trlink('','Лечебный','discrete_raw.php?fc=1&tf=1&ef=1');
    ui_trlink('','Мед-проф','discrete_raw.php?fc=2&tf=1&ef=1');
    ui_trlink('','Педиатрический','discrete_raw.php?fc=3&tf=1&ef=1');
    ui_trlink('','Стоматология','discrete_raw.php?fc=4&tf=1&ef=1');
    ui_trlink('','Фарма','discrete_raw.php?fc=6&tf=1&ef=1');
    ui_trlink('','Воен-мед ВС','discrete_raw.php?fc=8&tf=1&ef=1');
    ui_trlink('','Воен-мед ВВ','discrete_raw.php?fc=9&tf=1&ef=1');
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs();
    ui_select('', 'fc', 'Факультет', $fc_arr, $fc);
    ui_select('', 'tf', 'Отделение', $tf_arr, $tf);
    ui_select('', 'ef', 'Форма обучения', $ef_arr, $ef);
    ui_select('','afx','Автоматическая',$afx_arr,$afx);
    ui_select('','mfx','Ручная',$mfx_arr,$mfx);
    ui_check('', 'raw', 'для вставки', 0);
    ui_submit('', '', '', 'Показать', '');
    ui_efs();
    ui_sptfs3('vsplitter3_none');
    ui_sfs();
    /*ui_trlink('', 'Лечебный', 'discrete_raw.php?fc=1&tf=1&ef=2');
    ui_trlink('', 'Мед-проф', 'discrete_raw.php?fc=2&tf=1&ef=2');
    ui_trlink('', 'Педиатрический', 'discrete_raw.php?fc=3&tf=1&ef=2');
    ui_trlink('', 'Стоматология', 'discrete_raw.php?fc=4&tf=1&ef=2');
    ui_trlink('', 'Воен-мед', 'discrete_raw.php?fc=5&tf=1&ef=2');
    ui_trlink('', 'Фарма дневная', 'discrete_raw.php?fc=6&tf=1&ef=2');
    ui_trlink('', 'Фарма заочная', 'discrete_raw.php?fc=6&tf=2&ef=2');*/
    ui_trlink('','Лечебный','discrete_raw.php?fc=1&tf=1&ef=2');
    ui_trlink('','Мед-проф','discrete_raw.php?fc=2&tf=1&ef=2');
    ui_trlink('','Педиатрический','discrete_raw.php?fc=3&tf=1&ef=2');
    ui_trlink('','Стоматология','discrete_raw.php?fc=4&tf=1&ef=2');
    ui_trlink('','Фарма дневная','discrete_raw.php?fc=6&tf=1&ef=2');
    ui_trlink('','Фарма заочная','discrete_raw.php?fc=6&tf=2&ef=2');
    ui_trlink('','Профориентации','discrete_raw.php?fc=7&tf=1&ef=2');
    ui_trlink('','МФИУ (Леч., рус.)','discrete_raw.php?fc=10&tf=1&ef=2');
    ui_trlink('','МФИУ (Леч., англ.)','discrete_raw.php?fc=11&tf=1&ef=2');
    ui_trlink('','МФИУ (Стом., рус.)','discrete_raw.php?fc=12&tf=1&ef=2');
    ui_trlink('','МФИУ (Стом., англ.)','discrete_raw.php?fc=13&tf=1&ef=2');
    ui_trlink('','МФИУ (Мед-проф., рус.)','discrete_raw.php?fc=14&tf=1&ef=2');
    ui_trlink('','МФИУ (Фарм., рус.)','discrete_raw.php?fc=15&tf=1&ef=2');
    ui_trlink('','МФИУ (Фарм., англ.)','discrete_raw.php?fc=16&tf=1&ef=2');
    ui_efs();
    ui_etfs();
    ui_ef0();
}
ui_sfs('', 'w100');
ui_rep_row();
ui_rep_th('Балл', 0, 2);
ui_rep_th('Общий конкурс', 1);
if($tf == 1 && $fc != 5) 
{
    if($fc == 6 )
    {
	ui_rep_th('Целевой приём', count($cr_arr)*2);
    }
    else
    {
	ui_rep_th('Целевой приём', count($cr_arr));
    }
}
ui_end_row();

ui_rep_row();
//ui_rep_th('Город');
//ui_rep_th('Село');
ui_rep_th('',1);


if($tf == 1 && $fc != 5)
{
    foreach ($cr_arr as $v) {
	if ($fc == 6)
    	    ui_rep_th($v, 2);
        else
    	    ui_rep_th($v);
    }
}
ui_end_row();


$sql = <<<EOF
    (SELECT 800 as t,
    group_concat(if(`target`=6 ,`delo_name`,null) ORDER BY `total`  SEPARATOR '<br />') as tall,
    group_concat(if(`target`=6 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />') as t1,
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
    FROM $target_table WHERE ($fid $wct  AND `target`=6 $wfc $wtf $wef) GROUP BY `t` ) 
    UNION 
    (SELECT 700 as t,
    group_concat(if(`target`=4 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />') as tall,
    group_concat(if(`target`=4 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />') as t1,
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
    FROM $target_table WHERE ($fid $wct  AND `target`=4 $wfc $wtf $wef) GROUP BY `t` ) 
    UNION 
    (SELECT 600 as t,
    group_concat(if(`target`=5 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as tall,
    group_concat(if(`target`=5 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as t1,
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
    FROM $target_table WHERE ($fid $wct  AND `target`=5 $wfc $wtf $wef) GROUP BY `t` ) 
    UNION 
    (SELECT 500 as t,
    group_concat(if(`target`=2 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as tall,
    group_concat(if(`target`=2 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as t1,
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
    FROM $target_table WHERE ($fid $wct  AND `target`=2 $wfc $wtf $wef) GROUP BY `t` ) 
    UNION 
    (SELECT DISTINCT (ceil(total/10))*10 as t,
    group_concat(if(`target`=3 ,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as tall,
    group_concat(if(`target`=3 AND `target_type`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as t1,
    group_concat(if(`target`=3 AND `target_type`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as t2,
    group_concat(if(`target`=1 AND `region_cell`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c1,
    group_concat(if(`target`=1 AND `region_cell`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c2,
    group_concat(if(`target`=1 AND `region_cell`=3,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c3,
    group_concat(if(`target`=1 AND `region_cell`=4,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c4,
    group_concat(if(`target`=1 AND `region_cell`=5,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c5,
    group_concat(if(`target`=1 AND `region_cell`=6,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c6,

    group_concat(if(`target`=1 AND `region_cell`=1 AND `target_cell`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c11,
    group_concat(if(`target`=1 AND `region_cell`=2 AND `target_cell`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c12,
    group_concat(if(`target`=1 AND `region_cell`=3 AND `target_cell`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c13,
    group_concat(if(`target`=1 AND `region_cell`=4 AND `target_cell`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c14,
    group_concat(if(`target`=1 AND `region_cell`=5 AND `target_cell`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c15,
    group_concat(if(`target`=1 AND `region_cell`=6 AND `target_cell`=1,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c16,

    group_concat(if(`target`=1 AND `region_cell`=1 AND `target_cell`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c21,
    group_concat(if(`target`=1 AND `region_cell`=2 AND `target_cell`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c22,
    group_concat(if(`target`=1 AND `region_cell`=3 AND `target_cell`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c23,
    group_concat(if(`target`=1 AND `region_cell`=4 AND `target_cell`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c24,
    group_concat(if(`target`=1 AND `region_cell`=5 AND `target_cell`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c25,
    group_concat(if(`target`=1 AND `region_cell`=6 AND `target_cell`=2,`delo_name`,null) ORDER BY `total` SEPARATOR '<br />' ) as c26

    FROM $target_table WHERE ($fid $wct  AND (`target`=3 or `target`=1) $wfc $wtf $wef) GROUP BY `t` ) ORDER BY `t` DESC;
EOF;

$r = mysql_query($sql) or debug($sql, mysql_error());



$sum = array(
    't1' => 0,
    't2' => 0,
    'c1' => 0,
    'c2' => 0,
    'c3' => 0,
    'c4' => 0,
    'c5' => 0,
    'c6' => 0,
);



$dr = 0;
$dx = 0;
$dp = 0;
while ($l = mysql_fetch_array($r)) {

    $dx = $l['t'] - 9;

    $dr++;
    


    if ((int) $dp < 400) {

        for ($i = ($dp - (int) $l['t']) / 10 - 1; $i > 0; $i--) {
            $b = (int) $l['t'] + $i * 10;
            $a = $b - 9;
            ui_rep_row();
            ui_rep_th("$a-$b");
            ui_rep_td_l('');
  //          ui_rep_td_l('');
            
            if($tf == 1 && $fc !=5){
        	ui_rep_td_l('');
        	ui_rep_td_l('');
        	ui_rep_td_l('');
        	ui_rep_td_l('');
        	ui_rep_td_l('');
        	ui_rep_td_l('');
        	if($fc == 6)
        	{
        	    ui_rep_td_l('');
        	    ui_rep_td_l('');
        	    ui_rep_td_l('');
        	    ui_rep_td_l('');
        	    ui_rep_td_l('');
        	    ui_rep_td_l('');
        	
        	}
            }
            ui_end_row();
        }
    }
    ui_rep_row();
    $dp = (int) $l['t'];
    $l['t'] = ($l['t'] == '800') ? 'ПСК' : $l['t'];
    $l['t'] = ($l['t'] == '700') ? 'ПВК' : $l['t'];
    $l['t'] = ($l['t'] == '600') ? 'МО' : $l['t'];
    $l['t'] = ($l['t'] == '500') ? 'БИ' : $l['t'];

    if ((int) $l['t'] == 0)
        ui_rep_th("${l['t']}");
    else
        ui_rep_th("$dx-${l['t']}");



    if($ef==1){
    ui_rep_td_l($l['t1']);
  //  ui_rep_td_l($l['t2']);
    }
    else
    {
    ui_rep_td_l($l['tall']);
 //   ui_rep_td_l('-');
    }
    
    if ($tf == 1 && $fc !=5) {
    
        if ($fc == 6) {
    	    ui_rep_td_l($l['c11']);
    	    ui_rep_td_l($l['c21']);
    	    ui_rep_td_l($l['c12']);
    	    ui_rep_td_l($l['c22']);
    	    ui_rep_td_l($l['c13']);
    	    ui_rep_td_l($l['c23']);
    	    ui_rep_td_l($l['c14']);
    	    ui_rep_td_l($l['c24']);
    	    ui_rep_td_l($l['c15']);
    	    ui_rep_td_l($l['c25']);
    	    ui_rep_td_l($l['c16']);
    	    ui_rep_td_l($l['c26']);
	} else {
    	    ui_rep_td_l($l['c1']);
    	    ui_rep_td_l($l['c2']);
    	    ui_rep_td_l($l['c3']);
    	    ui_rep_td_l($l['c4']);
    	    ui_rep_td_l($l['c5']);
    	    ui_rep_td_l($l['c6']);
	}
    }
    ui_end_row();



    $sum['t1']+=$l['t1'];
  //  $sum['t2']+=$l['t2'];
    $sum['c1']+=$l['c1'];
    $sum['c2']+=$l['c2'];
    $sum['c3']+=$l['c3'];
    $sum['c4']+=$l['c4'];
    $sum['c5']+=$l['c5'];
    $sum['c6']+=$l['c6'];
}


ui_efs();

if ($raw)
    ui_ep();