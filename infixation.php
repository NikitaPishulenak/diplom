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

ui_sp('Фиксации конкурса дела ' .$p['delo_name']);
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
ui_stfs('Ручные фиксации');
ui_sfs('','w100');
ui_rep_row();
        ui_rep_th('Фиксация');
        ui_rep_th('Всего');
        ui_rep_th('Факультет');
        ui_rep_th('Отделение');
        ui_rep_th('Форма');
        ui_rep_th('Конкурс');
        ui_rep_th('Тип конкурса');
        ui_rep_th('Тип целевого');
        ui_rep_th('Целевая область');
        ui_rep_th('Состояние');
        ui_rep_th('Операции');
    ui_end_row();

while($l=mysql_fetch_object($r))
{
    ui_rep_row('','style="background-color:'.ui_sap($opt['sc'],$l->state_id,'#ffffff').'"');
        ui_rep_td($l->name);
        ui_rep_td($l->total);
        ui_rep_td($l->faculty);
        ui_rep_td(ui_sap($opt['tf'],$l->time_form_id,'нет'));
        ui_rep_td(ui_sap($opt['ef'], $l->edu_form,'нет'));
        ui_rep_td(ui_sap($opt['t_'],$l->target,'нет'));
        ui_rep_td(ui_sap($opt['tt'],$l->target_type,'нет'));
        ui_rep_td(ui_sap($opt['tc'],$l->target_cell,'нет'));
        ui_rep_td(ui_sap($opt['rc'],$l->region_cell,'нет'));
        ui_rep_td(ui_sap($opt['st'],$l->state_id,'нет'));
/*        if($l->fixation_id=='3')
        {
            ui_rep_td('<a href="change_fixed.php?id='.$l->id_fixed_target.'">Изменить</a>');
        }
        else*/
        {
            ui_rep_td('-нельзя-');
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
ui_stfs('Автоматические фиксации');
ui_sfs('','w100');
ui_rep_row();
        ui_rep_th('Фиксация');
        ui_rep_th('Всего');
        ui_rep_th('Факультет');
        ui_rep_th('Отделение');
        ui_rep_th('Форма');
        ui_rep_th('Конкурс');
        ui_rep_th('Тип конкурса');
        ui_rep_th('Тип целевого');
        ui_rep_th('Целевая область');
        ui_rep_th('Состояние');
        ui_rep_th('Операции');
    ui_end_row();

while($l=mysql_fetch_object($r))
{
    ui_rep_row('','style="background-color:'.ui_sap($opt['sc'],$l->state_id,'#ffffff').'"');
        ui_rep_td($l->name);
        ui_rep_td($l->total);
        ui_rep_td($l->faculty);
        ui_rep_td(ui_sap($opt['tf'],$l->time_form_id,'нет'));
        ui_rep_td(ui_sap($opt['ef'], $l->edu_form,'нет'));
        ui_rep_td(ui_sap($opt['t_'],$l->target,'нет'));
        ui_rep_td(ui_sap($opt['tt'],$l->target_type,'нет'));
        ui_rep_td(ui_sap($opt['tc'],$l->target_cell,'нет'));
        ui_rep_td(ui_sap($opt['rc'],$l->region_cell,'нет'));
        ui_rep_td(ui_sap($opt['st'],$l->state_id,'нет'));
        ui_rep_td('-нельзя-');
    ui_end_row();
}
ui_efs();
ui_etfs();




ui_ep();
