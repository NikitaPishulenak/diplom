<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();

$person_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($_person_id, 'integer');
if ($person_id <= 0) {
    ui_redirect('noaccess.php');
}

if(!empty($_POST))
{
    $reg=$_POST['reg'];
    $h=array();
    if($reg['name'])
    {
        $tag_id=$reg['name'];
    }
    else
    {
        $name=db_esc($reg['new']);
        $sql="INSERT INTO `db_tag` (`name`) VALUES ('$name')";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        $tag_id=mysql_insert_id();
    }
    $sql="INSERT INTO `db_tag_relation` (`person_id`,`tag_id`) VALUES ('$person_id','$tag_id')";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_redirect("view.php?id=$person_id");
}

$stk_arr=db_kv('db_tag','id_tag','name');
ui_sp('Стикеры');
$p = db_single_record('db_person', 'id', $person_id);
$opt = array();
$opt['tf'] = db_kv('db_time_form', 'id_time_form', 'abbr');
$opt['ef'] = db_kv('db_ef', 'id_ef', 'abbr');
$opt['t_'] = db_kv('db_target', 'id_target', 'abbr');
$opt['tt'] = db_kv('db_targettype', 'id_targettype', 'abbr');
$opt['rc'] = db_kv('db_region', 'id_region', 'abbr');
$opt['tc'] = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p, $opt);
ui_stfs();
ui_view_links($person_id);
ui_etfs();
ui_stfs();
ui_sticker_view($person_id);
ui_etfs();
ui_sf();
ui_stfs();
ui_sfs();
ui_efs();
ui_sptfs3();
ui_sfs('Выберите соществующий или создайте новый стикер.');
ui_select('reg', 'name', 'Существующие', $stk_arr, 0);
ui_text('reg','new','Новый','','50');
ui_efs();
ui_sptfs3();
ui_sfs();
ui_efs();
ui_etfs();
ui_sc('Добавить');
ui_ef0();
ui_ep();