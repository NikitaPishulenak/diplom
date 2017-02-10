<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();


$fc = 1;

$fc_arr = db_kv('db_faculty','id','name');
$tt_arr = db_kv('db_targettype','id_targettype','abbr');
$bf_arr = db_bits2arr('db_benefit','id_benefit','abbr');
$st_arr = db_bits2arr('db_student','id_student','name');
$t__arr = db_kv('db_target','id_target','abbr');


ui_sp('İêçàìåíàöèîííàÿ âåäîìîñòü');

ui_sfs('','w100');
ui_rep_row();
ui_rep_th('¹ ï/ï');
ui_rep_th('Íîìåğ äåëà');
ui_rep_th('ÔÈÎ Àáèòóğèåíòà');
ui_rep_th('ßçûê');
ui_rep_th('Õèìèÿ');
ui_rep_th('Áèîëîãèÿ');
ui_rep_th('Àòòåñòàò');
ui_rep_th('Âñåãî');
ui_rep_th('Êîíêóğñ');
ui_rep_th('Ëüãîòû');
ui_rep_th('Ğåøåíèå');
ui_end_row();


$i=0;

$sql="SELECT * FROM `db_person` WHERE `faculty`='$fc' AND `out_target`='2'";
$r = mysql_query($sql) or debug($sql, mysql_error());
while($l=mysql_fetch_object($r))
{
    $i++;
    ui_rep_row();
    ui_rep_td($i);
    ui_rep_td($l->delo_name);
    ui_rep_td_l($l->surname);
    ui_rep_td($l->lct_sum);
    ui_rep_td($l->cct_sum);
    ui_rep_td($l->bct_sum);
    ui_rep_td($l->certificate_sum);
    ui_rep_td($l->total);
    ui_rep_td(ui_sap($t__arr,$l->out_target).','.ui_sap($tt_arr,$l->out_target_type));
    ui_rep_td(ui_sap($bf_arr,$l->benefit_set));
    ui_rep_td(ui_sap($st_arr,$l->student_id));
    ui_end_row();
}

$sql="SELECT * FROM `db_person` WHERE `faculty`='$fc' AND `out_target`='1'";
$r = mysql_query($sql) or debug($sql, mysql_error());
while($l=mysql_fetch_object($r))
{
    $i++;
    ui_rep_row();
    ui_rep_td($i);
    ui_rep_td($l->delo_name);
    ui_rep_td_l($l->surname);
    ui_rep_td($l->lct_sum);
    ui_rep_td($l->cct_sum);
    ui_rep_td($l->bct_sum);
    ui_rep_td($l->certificate_sum);
    ui_rep_td($l->total);
    ui_rep_td(ui_sap($t__arr,$l->out_target).','.ui_sap($tt_arr,$l->out_target_type));
    ui_rep_td(ui_sap($bf_arr,$l->benefit_set));
    ui_rep_td(ui_sap($st_arr,$l->student_id));
    ui_end_row();
}

$sql="SELECT * FROM `db_person` WHERE `faculty`='$fc' AND `out_target`='3'";
$r = mysql_query($sql) or debug($sql, mysql_error());
while($l=mysql_fetch_object($r))
{
    $i++;
    ui_rep_row();
    ui_rep_td($i);
    ui_rep_td($l->delo_name);
    ui_rep_td_l($l->surname);
    ui_rep_td($l->lct_sum);
    ui_rep_td($l->cct_sum);
    ui_rep_td($l->bct_sum);
    ui_rep_td($l->certificate_sum);
    ui_rep_td($l->total);
    ui_rep_td(ui_sap($t__arr,$l->out_target).','.ui_sap($tt_arr,$l->out_target_type));
    ui_rep_td(ui_sap($bf_arr,$l->benefit_set));
    ui_rep_td(ui_sap($st_arr,$l->student_id));
    ui_end_row();
}


ui_efs();

ui_ep();
