<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC', 'report.discrete');
cr_logic();

$tf = isset($_GET['tf']) ? (int) $_GET['tf'] : 0;
$fc = isset($_GET['fc']) ? (int) $_GET['fc'] : 0;
$ef = isset($_GET['ef']) ? (int) $_GET['ef'] : 0;


$wfc = ($fc) ? " AND `faculty`='$fc'" : '';
$wtf = ($tf) ? " AND `time_form_id`='$tf'" : '';
$wef = ($ef) ? " AND `edu_form`='$ef'" : '';
$wfcp = ($fc) ? " AND `faculty_id`='$fc'" : '';
$wtfp = ($tf) ? " AND `time_form_id`='$tf'" : '';
$wefp = ($ef) ? " AND `edu_form_id`='$ef'" : '';

$fc_arr = db_kv('db_faculty', 'id', 'name');
$tf_arr = db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr = db_kv('db_ef', 'id_ef', 'name');
$cr_arr = db_kv('db_region', 'id_region', 'abbr');

$sql = <<<EOF
    SELECT
        (count(distinct IF(`target_id`>0,`target_id`,null))) as t__count,
        (count(distinct IF(`target_type_id`>0,`target_type_id`,null))) as tt_count,
        (count(distinct IF(`target_cell_id`>0,`target_cell_id`,null))) as tc_count,
        (count(distinct IF(`region_cell_id`>0,`region_cell_id`,null))) as rc_count
        FROM `db_target_allowable` WHERE 1 $wfcp $wtfp $wefp

EOF;

$r = mysql_query($sql) or debug($sql, mysql_error());
if($l=mysql_fetch_object($r))
{
    $t__count=$l->t__count;
    $tt_count=$l->tt_count;
    $tc_count=$l->tc_count;
    $rc_count=$l->rc_count;
}
else
{
    $t__count=0;
    $tt_count=0;
    $tc_count=0;
    $rc_count=0;
}
        

ui_sp('Приём документов');

ui_gf();
ui_stfs();
ui_sfs();
ui_efs();
ui_sptfs3('vsplitter3_none');
ui_sfs();
ui_select('', 'fc', 'Факультет', $fc_arr, $fc);
ui_select('', 'tf', 'Отделение', $tf_arr, $tf);
ui_select('', 'ef', 'Форма обучения', $ef_arr, $ef);
ui_submit('', '', '', 'Показать', '');
ui_efs();
ui_sptfs3('vsplitter3_none');
ui_sfs();
ui_efs();
ui_etfs();
ui_ef0();
var_dump($l);
ui_hr();

$tk=3;
$row_columns=array();
if($tt_count==0)
{
    $row_columns[]='DISTINCT (ceil(total/10))*10 as t';
    $row_columns[]="COUNT(IF(`target`='$tk',`total`,null)) as t_";
}
else
{
    $row_columns[]='DISTINCT (ceil(total/10))*10 as t';
    $wt_p=" AND `target_id`='$tk'";
    $sql="SELECT DISTINCT `target_type_id` FROM `db_target_allowable` WHERE 1 $wfcp $wtfp $wefp";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=mysql_fetch_object($r))
    {
        $row_columns[]="COUNT(IF(`target`='$tk' AND `target_type`='$l->target_type_id',`total`,null)) as `tt[$l->target_type_id]`";
    }
    if($tc_count==1)
    {
        
    }else if($tc_count>1)
    {
        
    }
}

$row_of_columns=implode(",\n",$row_columns);
$sql=<<<EOF
    SELECT
        $row_of_columns
            
            FROM `db_person` WHERE (`state_id`=1 AND (`target`=3 or `target`=1) $wfc $wtf $wef) GROUP BY `t` ORDER BY `t` DESC
EOF;
var_dump($sql);
ui_hr();
ui_sfs();
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l= mysql_fetch_row($r))
{
    $j=0;
    ui_rep_row();
    ui_rep_th($l[$j]);
    if(!$tt_count) ui_rep_td ($l[++$j]);
    for($i=0;$i<$tt_count;$i++)
    {
        $j++;
        ui_rep_td($l[$j]);
    }
    
    ui_end_row();
    
}
ui_efs();
ui_ep();