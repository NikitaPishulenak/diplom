<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.column.php';

define('PAGE_SEC', 'control.targetacl');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0)
{
    ui_redirect('create.php');
}


if(!empty($_POST))
{
    if($id)
    {
        
    }
    else
    {
        $reg=$_POST['reg'];
        $res=db_field_values($reg);
        $sql="INSERT INTO `db_target_allowable` (${res[0]}) VALUES (${res[1]})";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
    }
    ui_redirect("targetacl.php");
}



$options=array();
$options['faculty']=db_kv('db_faculty','id','name');
$options['ef']=db_kv('db_ef','id_ef','name');
$options['time_form_id']=db_kv('db_time_form', 'id_time_form', 'name');
$options['target']=db_kv('db_target','id_target','name');
$options['target_type']=db_kv('db_targettype','id_targettype','name');
$options['target_cell']=db_kv('db_targetcell', 'id_targetcell', 'name');
$options['region_cell']=db_kv('db_region', 'id_region', 'name');



if($id)
    $p=db_single_record('db_target_allowable', 'id_target_allowable',$id );
else
    $p=db_default_record ('db_target_allowable');

ui_sp('Допустимый конкурс');

$sql="SELECT * FROM `db_target_allowable";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs('','w100');
ui_rep_row();
    ui_rep_th('#');
    ui_rep_th($pcolumns['faculty']);
    ui_rep_th($pcolumns['time_form_id']);
    ui_rep_th($pcolumns['edu_form']);
    ui_rep_th($pcolumns['target']);
    ui_rep_th($pcolumns['target_type']);
    ui_rep_th($pcolumns['target_cell']);
    ui_rep_th($pcolumns['region_cell']);
    ui_end_row();

while($l=mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th('#');
    ui_rep_td(ui_sap($options['faculty'],$l->faculty_id));
    ui_rep_td(ui_sap($options['time_form_id'],$l->time_form_id));
    ui_rep_td(ui_sap($options['ef'],$l->edu_form_id));
    ui_rep_td(ui_sap($options['target'],$l->target_id));
    ui_rep_td(ui_sap($options['target_type'],$l->target_type_id));
    ui_rep_td(ui_sap($options['target_cell'],$l->target_cell_id));
    ui_rep_td(ui_sap($options['region_cell'],$l->region_cell_id));
    ui_rep_td('<a href="api.php?m=tacl.del&amp;i='.$l->id_target_allowable.'">x</a>');
    ui_end_row();
}
ui_efs();


ui_sf();
    ui_sfs();
    ui_select('reg', 'faculty_id', 'Факультет', $options['faculty'], $p['faculty_id']);
    ui_select('reg', 'time_form_id', 'Форма получения', $options['time_form_id'], $p['time_form_id']);
    ui_select('reg', 'edu_form_id', 'Форма обучения', $options['ef'], $p['edu_form_id']);
    ui_select('reg', 'target_id', 'Конкурс', $options['target'], $p['target_id']);
    ui_select('reg', 'target_type_id', 'Тип Конкурса', $options['target_type'], $p['target_type_id']);
    ui_select('reg', 'target_cell_id', 'Тип Целевого', $options['target_cell'], $p['target_cell_id']);
    ui_select('reg', 'region_cell_id', 'Целевая область', $options['region_cell'], $p['region_cell_id']);
    ui_efs();
ui_ef();

ui_ep();