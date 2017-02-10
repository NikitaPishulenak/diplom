<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC', 'phones');
cr_logic();

ui_sp('Телефоны');

ui_blink('Работники ПК', 'phones.php?phonegroup=1');
ui_blink('Узошники', 'phones.php?phonegroup=2');
ui_blink('БГМУ', 'phones.php?phonegroup=3');
ui_blink('Коды городов', 'phones.php?phonegroup=4');
ui_hr();

$id = (isset($_GET['phonegroup'])) ? $_GET['phonegroup'] : 1;

if ($id == 1) {
    ui_sfs('Работники ПК', 'w100');
    ui_rep_row();
    ui_rep_th('ФИО');
    ui_rep_th('Телефон(ы)');
    ui_end_row();
    $sql = "SELECT `realname`,`phones` FROM `db_users` ORDER BY `realname`";
    $r = mysql_query($sql) or debug($sql, mysql_error());
    while ($l = mysql_fetch_object($r)) {
        ui_rep_row();
        ui_rep_td_l($l->realname);
        ui_rep_td_r($l->phones);
        ui_end_row();
    }
    ui_efs();
}
elseif($id==2)
{
    ui_sfs('УЗО', 'w100');
    ui_rep_row();
    ui_rep_th('ФИО');
    ui_rep_th('Телефон(ы)');
    ui_end_row();
    $sql = "SELECT `realname`,`phones` FROM `db_phones_uzo` ORDER BY `realname`";
    $r = mysql_query($sql) or debug($sql, mysql_error());
    while ($l = mysql_fetch_object($r)) {
        ui_rep_row();
        ui_rep_td_l($l->realname);
        ui_rep_td_r($l->phones);
        ui_end_row();
    }
    ui_efs();
}  elseif ($id==3) {
    ui_sfs('БГМУ', 'w100');
    ui_rep_row();
    ui_rep_th('ФИО');
    ui_rep_th('Телефон(ы)');
    ui_end_row();
    $sql = "SELECT `realname`,`phones` FROM `db_phones_bsmu` ORDER BY `realname`";
    $r = mysql_query($sql) or debug($sql, mysql_error());
    while ($l = mysql_fetch_object($r)) {
        ui_rep_row();
        ui_rep_td_l($l->realname);
        ui_rep_td_r($l->phones);
        ui_end_row();
    }
    ui_efs();
} elseif ($id==4) {
    ui_sfs('Коды городов', 'w100');
    ui_rep_row();
    ui_rep_th('Город');
    ui_rep_th('Код',2);
    ui_end_row();
    $sql = "SELECT `realname`,`phones` FROM `db_phone_codes` ORDER BY `realname`";
    $r = mysql_query($sql) or debug($sql, mysql_error());
    while ($l = mysql_fetch_object($r)) {
        ui_rep_row();
        ui_rep_td_l($l->realname);
        ui_rep_td_r($l->phones);
        ui_rep_td_l('','w100');
        ui_end_row();
    }
    ui_efs();
}
ui_ep();
