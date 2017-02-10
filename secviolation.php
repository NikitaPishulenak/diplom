<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','debug.secviol');
cr_logic();

ui_sp('Нарушение базопастности');

$sql="SELECT * FROM `db_secviol`";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs('','w100');
ui_rep_row();
ui_rep_th('#');
ui_rep_th('ts');
ui_rep_th('ip');
ui_rep_th('rs');
ui_end_row();

while($l=  mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_td($l->id_secviol);
    ui_rep_td($l->ts);
    ui_rep_td($l->ipaddr);
    ui_rep_td_l($l->rs);    
    ui_end_row();
}
ui_efs();
ui_ep();
