<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();

if(!empty($_POST))
{
    $reg=$_POST['reg'];
    $reg['use_tabs'] = (isset($_POST['ut']['use_tabs']))?1:0;
    $reg['use_last'] = (isset($_POST['ut']['use_last']))?1:0;
    $uid=cr_userid();
    $res=db_update_values($reg);
    $sql=" UPDATE `db_users` SET $res WHERE (`id`='$uid') LIMIT 1";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_redirect('profile.php');
}

$options = array();
$options['faculty']=db_kv('db_faculty','id','name');
$options['time_form']=db_kv('db_time_form','id_time_form','name');
$options['queues']=db_kv('db_queue','id_queue','name');
$options['actions']=db_kv('db_klik','id_klik','name');
$options['state_id']=db_kv('db_state','id_state','name');
ui_sp('Профиль пользователя');

$p=db_single_record('db_users', 'id', cr_userid());
ui_sf();
ui_stfs();
ui_sfs();
ui_select('reg', 'def_faculty', 'Факультет по умолчанию', $options['faculty'], $p['def_faculty']);
ui_select('reg', 'def_time_form', 'Отделение по умолчанию', $options['time_form'], $p['def_time_form']);
ui_select('reg', 'def_state_id', 'Состояние по умолчанию', $options['state_id'],$p['def_state_id']);
ui_select('reg', 'queue_id', 'Очередь', $options['queues'], $p['queue_id']);
ui_select('reg', 'def_action', 'Клик', $options['actions'], $p['def_action']);
ui_efs();
ui_sptfs();
ui_sfs();
ui_check('ut', 'use_tabs', 'Использовать вкладки', $p['use_tabs']);
ui_check('ut', 'use_last', 'Последний день поиск', $p['use_last']);
ui_efs();
ui_etfs();
ui_sc('Сохранить');
ui_ef0();
ui_ep();
