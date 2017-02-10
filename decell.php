<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','debug');
cr_logic();

ui_sp('Приёмная комиссия');


set_time_limit(0);

$sql="SELECT * from `db_person` where (TRIM(surname),LEFT(name,1)) in (select TRIM(surname),LEFT(name,1) from db_vized_cell)";
$r=mysql_query($sql) or debug($sql,mysql_error());

$opt = array();
$opt['tf'] = db_kv('db_time_form', 'id_time_form', 'abbr');
$opt['ef'] = db_kv('db_ef', 'id_ef', 'abbr');
$opt['t_'] = db_kv('db_target', 'id_target', 'abbr');
$opt['tt'] = db_kv('db_targettype', 'id_targettype', 'abbr');
$opt['rc'] = db_kv('db_region', 'id_region', 'abbr');
$opt['tc'] = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');



ui_sfs();
while($p=mysql_fetch_assoc($r))
{
    ui_rep_row();
    ui_rep_td_l($p['delo_name']);
    ui_rep_td_l($p['total']);
    ui_rep_td_l($p['surname']);
    ui_rep_td_l($p['name']);
    ui_rep_td_l($p['midname']);
    ui_rep_td_l(ui_sap($opt['t_'],$p['target']));
    ui_rep_td_l(ui_sap($opt['tt'],$p['target_type']));
    ui_rep_td_l(ui_sap($opt['tc'],$p['target_cell']));
    ui_rep_td_l(ui_sap($opt['rc'],$p['region_cell']));
    ui_rep_td_l($p['phone']);
    ui_rep_td_l($p['mobile']);
    ui_rep_td_l('');
//    ui_rep_td_l('');
    
    $pn=substr($p['name'],1,1);
    $sql="SELECT * FROM `db_vized_cell` WHERE TRIM(surname)=TRIM('${p['surname']}')";
    $rr=mysql_query($sql) or debug($sql,mysql_error());
    while($ll=mysql_fetch_object($rr))
    {
	ui_rep_row();
	ui_rep_th('',10);
	ui_rep_td_l(ui_sap($opt['rc'],$ll->region_id));
	ui_rep_td_l($ll->spec);
	ui_end_row();
    }
    ui_end_row();
    
}
ui_efs();
ui_ep();
