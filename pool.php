<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.php';

define('PAGE_SEC','person.pool');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('noaccess.php');
}

$p=db_single_record('db_person', 'id', "$id");

if(!empty($_POST))
{
    $n=$p['delo_int'];
    $f=$p['faculty'];
    $t=$p['time_form_id'];
    $u=cr_userid();
    $sql="UPDATE `db_person` SET `auid`='$u',`delo_name`='',`delo_int`='0',`state_id`='0' WHERE `id`='$id' LIMIT 1";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="INSERT INTO `db_pool` VALUES ('','$f','$t','$n');";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_redirect("view.php?id=$id");
}

ui_sp('Бронировать этот номер');
$opt=array();
$opt['tf']=db_kv('db_time_form','id_time_form','abbr');
$opt['ef']=db_kv('db_ef','id_ef','abbr');
$opt['t_']=db_kv('db_target','id_target','abbr');
$opt['tt']=db_kv('db_targettype','id_targettype','abbr');
$opt['rc']=db_kv('db_region', 'id_region', 'abbr');
$opt['tc']=db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm']=db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p,$opt);
ui_sf();
ui_hidden('reg', 'pool', 'yes');
ui_sc('Бронировать');
ui_ef0();
ui_ep();
