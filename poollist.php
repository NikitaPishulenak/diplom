<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();

ui_sp('Пул бронирования');
$sql="SELECT * FROM `db_pool` ";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs();
ui_rep_row();
    ui_rep_th('#');
    ui_rep_th('Факультет');
    ui_rep_th('Форма получения');
    ui_rep_th('Номер дела');

ui_end_row();
while($l=  mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th($l->id_pool);
    ui_rep_td($l->faculty_id);
    ui_rep_td($l->time_form_id);
    ui_rep_td($l->delo_id);
    ui_end_row();
}
ui_efs();
ui_ep();