<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libtargethistory.php';
include 'core/libtargetacl.php';

include 'form/change_fixed.php';

define('PAGE_SEC','person.change');
cr_logic();


$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('noaccess.php');
}

$pid=db_gv('mfx`.`db_fixed_target','person_id',"id_fixed_target='$id'");
$fid=db_gv('mfx`.`db_fixed_target','fixation_id',"id_fixed_target='$id'");
$fin=db_gv('mfx`.`db_fixation','name',"id_fixation='$fid'");

$f=db_single_record('mfx`.`db_fixed_target','id_fixed_target',"$id");
if(!empty($_POST))
{
 
    $reg=$_POST['reg'];
    $p=db_single_record('db_person', 'id', "$pid");
    $f=db_single_record('mfx`.`db_fixed_target','id_fixed_target',"$id");
    unset($f['id_fixed_target']);
    
    $hres=db_field_values($f);
    $sql="INSERT INTO `mfx`.`db_fixed_history` (${hres[0]}) VALUES ($hres[1])";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    
    $f['edu_form']      = $reg['edu_form'];
    $f['target']        = $reg['target'];
    $f['target_type']   = $reg['target_type'];
    $f['target_cell']   = $reg['target_cell'];
    $f['region_cell']   = $reg['region_cell'];
    
    $hres=db_update_values($f);
    $sql="UPDATE `mfx`.`db_fixed_target` SET $hres WHERE `id_fixed_target`='$id'";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_redirect("change_fixed.php?id=$id");
}
$options=array();
$options['faculty']=db_kv('db_faculty','id','name');
$options['users_by_name']=db_kv('db_users', 'id', 'realname');
$options['ef']=db_kv('db_ef','id_ef','name');
$options['time_form_id']=db_kv('db_time_form', 'id_time_form', 'name');
$options['target']=db_kv('db_target','id_target','name');
$options['target_type']=db_kv('db_targettype','id_targettype','name');
$options['target_cell']=db_kv('db_targetcell', 'id_targetcell', 'name');
$options['region_cell']=db_kv('db_region', 'id_region', 'name');
$options['reason']=db_kv('db_reason','id_reason','name');
$options['reasoff']=db_kv('db_reasoff','id_reasoff','name');


$p=db_single_record('db_person', 'id', "$pid");

ui_sp('Смена конкурса фиксации '.$fin);

$opt=array();
$opt['tf']=db_kv('db_time_form','id_time_form','abbr');
$opt['ef']=db_kv('db_ef','id_ef','abbr');
$opt['t_']=db_kv('db_target','id_target','abbr');
$opt['tt']=db_kv('db_targettype','id_targettype','abbr');
$opt['rc']=db_kv('db_region', 'id_region', 'abbr');
$opt['tc']=db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p,$opt);
    ui_stfs();
            ui_view_links($pid);
    ui_etfs();
    
    form_draw($p,$f,'');
    ui_hr();
    
    
    $sql="SELECT * FROM `mfx`.`db_fixed_history` WHERE `person_id`='$pid' AND `fixation_id`='$fid'";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    if(mysql_num_rows($r))
    {
        ui_sfs('Смены конкурса фиксации','w100');
        ui_rep_row();
        ui_rep_th('Всего');
        ui_rep_th('Факультет');
        ui_rep_th('Отделение');
        ui_rep_th('Форма обучения');
        ui_rep_th('Конкурс');
        ui_rep_th('Тип конкурса');
        ui_rep_th('Тип целевого');
        ui_rep_th('Целевая область');
        ui_end_row();
        while($l=  mysql_fetch_object($r))
        {
            ui_rep_row();
            ui_rep_td($l->total);
            ui_rep_td(ui_sap($options['faculty'],$l->faculty));
            ui_rep_td(ui_sap($options['time_form_id'],$l->time_form_id));
            ui_rep_td(ui_sap($options['ef'],$l->edu_form));
            ui_rep_td(ui_sap($options['target'],$l->target));
            ui_rep_td(ui_sap($options['target_type'],$l->target_type));
            ui_rep_td(ui_sap($options['target_cell'],$l->target_cell));
            ui_rep_td(ui_sap($options['region_cell'],$l->region_cell));
            
            ui_end_row();
        }
        ui_efs();
    }
    jsTargetAcl();
    ui_hidden('reg', 'faculty', $p['faculty']);
    ui_hidden('reg', 'time_form_id', $p['time_form_id']);
    ui_script('js/person.change.js');
    ui_script_start();
    print<<<EOF
    $(document).ready(function(){
            
            eduFormChange();
        });
EOF;
    ui_script_end();
ui_ep();