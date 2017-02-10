<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();

ui_sdlg('Коды городов');
ui_sfs('Коды городов', 'w100');
    ui_rep_row();
    ui_rep_th('Город');
    ui_rep_th('Код');
    ui_end_row();
    $sql = "SELECT `realname`,`phones` FROM `db_phone_codes` ORDER BY `realname`";
    $r = mysql_query($sql) or debug($sql, mysql_error());
    while ($l = mysql_fetch_object($r)) {
        ui_rep_row();
        ui_rep_td_l($l->realname);
        ui_rep_td_r($l->phones);
        ui_end_row();
    }
    ui_efs();
ui_edlg();
