<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.column.php';
include 'form/options.php';

define('PAGE_SEC', 'person.history');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('create.php');
}

$sql="SELECT * FROM `db_history` WHERE (`person_id`='$id')";
$r=mysql_query($sql) or debug($sql,  mysql_error());

$p=db_single_record('db_person','id',$id);
ui_sp('История');
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
ui_view_links($id);
ui_etfs();
ui_sfs('','w100');

$u=db_kv('db_users','id','realname');

while($l=  mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th($l->ts);
    ui_rep_td($u[$l->user_id]);
    ui_rep_th($pcolumns[$l->field]);
    if(isset($options[$l->field]))
    {
        ui_rep_td((isset($options[$l->field][$l->value_old]))?$options[$l->field][$l->value_old]:'-');
        ui_rep_td((isset($options[$l->field][$l->value_new]))?$options[$l->field][$l->value_new]:'-');
    }
    else
    {
        ui_rep_td($l->value_old);
        ui_rep_td($l->value_new);
    }
    ui_end_row();
}

ui_efs();
ui_ep();