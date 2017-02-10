<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','person.change');
cr_logic();

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');
if ($id <= 0) {
    ui_redirect('noaccess.php');
}

$p = db_single_record('db_person', 'id', $id);

ui_sp('�������� �������� ���� ' .$p['delo_name']);
$opt = array();
$opt['tf'] = db_kv('db_time_form', 'id_time_form', 'abbr');
$opt['ef'] = db_kv('db_ef', 'id_ef', 'abbr');
$opt['t_'] = db_kv('db_target', 'id_target', 'abbr');
$opt['tt'] = db_kv('db_targettype', 'id_targettype', 'abbr');
$opt['rc'] = db_kv('db_region', 'id_region', 'abbr');
$opt['tc'] = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
$opt['st'] = db_kv('db_state', 'id_state', 'name');
$opt['sc'] = db_kv('db_state', 'id_state', 'color');
ui_view_header($p, $opt);
ui_stfs();
ui_view_links($id);
ui_etfs();
ui_stfs();
ui_sticker_view($id);
ui_etfs();

$sql="
 SELECT 
    mfx.db_fixation.name,mfx.db_fixed_target.*
    FROM mfx.db_fixation 
    LEFT JOIN mfx.db_fixed_target 
    ON (person_id='$id' and fixation_id=id_fixation) 
    WHERE  id_fixation 
    IN (select fixation_id from mfx.db_fixed_target where person_id='$id');
    ";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_stfs('������ ��������');
ui_sfs('','w100');
ui_rep_row();
        ui_rep_th('��������');
        ui_rep_th('�����');
        ui_rep_th('���������');
        ui_rep_th('���������');
        ui_rep_th('�����');
        ui_rep_th('�������');
        ui_rep_th('��� ��������');
        ui_rep_th('��� ��������');
        ui_rep_th('������� �������');
        ui_rep_th('���������');
        ui_rep_th('��������');
    ui_end_row();

while($l=mysql_fetch_object($r))
{
    ui_rep_row('','style="background-color:'.ui_sap($opt['sc'],$l->state_id,'#ffffff').'"');
        ui_rep_td($l->name);
        ui_rep_td($l->total);
        ui_rep_td($l->faculty);
        ui_rep_td(ui_sap($opt['tf'],$l->time_form_id,'���'));
        ui_rep_td(ui_sap($opt['ef'], $l->edu_form,'���'));
        ui_rep_td(ui_sap($opt['t_'],$l->target,'���'));
        ui_rep_td(ui_sap($opt['tt'],$l->target_type,'���'));
        ui_rep_td(ui_sap($opt['tc'],$l->target_cell,'���'));
        ui_rep_td(ui_sap($opt['rc'],$l->region_cell,'���'));
        ui_rep_td(ui_sap($opt['st'],$l->state_id,'���'));
/*        if($l->fixation_id=='3')
        {
            ui_rep_td('<a href="change_fixed.php?id='.$l->id_fixed_target.'">��������</a>');
        }
        else*/
        {
            ui_rep_td('-������-');
        }
    ui_end_row();
}
ui_efs();
ui_etfs();

$sql="
 SELECT 
    afx.db_fixation.name,afx.db_fixed_target.*
    FROM afx.db_fixation 
    LEFT JOIN afx.db_fixed_target 
    ON (person_id='$id' and fixation_id=id_fixation) 
    WHERE  id_fixation 
    IN (select fixation_id from afx.db_fixed_target where person_id='$id');
    ";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_stfs('�������������� ��������');
ui_sfs('','w100');
ui_rep_row();
        ui_rep_th('��������');
        ui_rep_th('�����');
        ui_rep_th('���������');
        ui_rep_th('���������');
        ui_rep_th('�����');
        ui_rep_th('�������');
        ui_rep_th('��� ��������');
        ui_rep_th('��� ��������');
        ui_rep_th('������� �������');
        ui_rep_th('���������');
        ui_rep_th('��������');
    ui_end_row();

while($l=mysql_fetch_object($r))
{
    ui_rep_row('','style="background-color:'.ui_sap($opt['sc'],$l->state_id,'#ffffff').'"');
        ui_rep_td($l->name);
        ui_rep_td($l->total);
        ui_rep_td($l->faculty);
        ui_rep_td(ui_sap($opt['tf'],$l->time_form_id,'���'));
        ui_rep_td(ui_sap($opt['ef'], $l->edu_form,'���'));
        ui_rep_td(ui_sap($opt['t_'],$l->target,'���'));
        ui_rep_td(ui_sap($opt['tt'],$l->target_type,'���'));
        ui_rep_td(ui_sap($opt['tc'],$l->target_cell,'���'));
        ui_rep_td(ui_sap($opt['rc'],$l->region_cell,'���'));
        ui_rep_td(ui_sap($opt['st'],$l->state_id,'���'));
        ui_rep_td('-������-');
    ui_end_row();
}
ui_efs();
ui_etfs();




ui_ep();
