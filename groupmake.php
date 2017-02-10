<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC', 'person.groupmake');
cr_logic();

if(!empty($_POST))
{
    $w= cr_tempwhere('id');
    $reg=$_POST['reg'];
    
    $st=isset($_POST['st'])?$_POST['st']:array();
    if(!isset($_POST['ignore']['st']))
    {
        $reg['student_id']=db_bit_array($st);
    }
    
    if(isset($_POST['ignore']['ot']))
    {
        unset($reg['out_time_form_id']);
        unset($reg['out_edu_form']);
        unset($reg['out_target']);
        unset($reg['out_target_type']);
        unset($reg['out_target_cell']);
        unset($reg['out_region_cell']);
        
    }
    else{
    /*++ inheritance --*/
    if (isset($_POST['check_reg']['out_time_form_id'])) $reg['out_time_form_id']='___time_form_id___';
    if (isset($_POST['check_reg']['out_edu_form'])) $reg['out_edu_form']='___edu_form___';
    if (isset($_POST['check_reg']['out_target'])) $reg['out_target']='___target___';
    if (isset($_POST['check_reg']['out_target_type'])) $reg['out_target_type']='___target_type___';
    if (isset($_POST['check_reg']['out_target_cell'])) $reg['out_target_cell']='___target_cell___';
    if (isset($_POST['check_reg']['out_region_cell'])) $reg['out_region_cell']='___region_cell___';

    /*-- inhertance --*/
    }
    $res=db_update_values($reg);
    $res=str_replace("'___", '`', $res);
    $res=str_replace("___'", '`', $res);
    
    $sql="UPDATE `db_person` SET $res WHERE $w";
    
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    
    ui_redirect('index.php');
}
$options=array();
$options['ef']=db_kv('db_ef','id_ef','name');
$options['target']=db_kv('db_target','id_target','name');
$options['target_type']=db_kv('db_targettype','id_targettype','name');
$options['time_form']=db_kv('db_time_form','id_time_form','name');
$options['region_cell']=db_kv('db_region','id_region','name');
$options['target_cell']=db_kv('db_targetcell', 'id_targetcell', 'name');
$options['student_id']=db_kv('db_student', 'id_student', 'name');

ui_sp('Групповое зачисление');
ui_sf();
ui_stfs();

    ui_sfs('Статус абитуриента');
       ui_bit_set('st', 'student_id', '', $options['student_id'], 0);
       ui_check('ignore','st' ,'Игнорировать' , 0);
    ui_efs();
    
    ui_sptfs();
    
    ui_sfs('Конкурс зачисления');
    
    ui_select_check('reg', 'out_time_form_id', 'Форма обучения', $options['time_form'], 0);
    ui_select_check('reg', 'out_edu_form', 'Форма зачисления', $options['ef'], 0);
    ui_select_check('reg', 'out_target', 'Конкурс зачисления', $options['target'], 0);
    ui_select_check('reg', 'out_target_type', 'Тип К Зачисления', $options['target_type'], 0);
    ui_select_check('reg', 'out_target_cell', 'Тип Ц Зачисления', $options['target_cell'], 0);
    ui_select_check('reg', 'out_region_cell', 'Цел. обл. Зачисления', $options['region_cell'], 0);
    
    ui_efs();
    ui_sfs();
    ui_check('ignore','ot' ,'Игнорировать' , 0);
    ui_efs();
        
ui_etfs();
ui_ef();
ui_ep();