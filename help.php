<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC', 'index');
cr_logic();


ui_sdlg('Помощь');
$ref = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';

$page = array();
$page = explode('?', $ref);
$page = explode('/', $page[0]);
$file = $page[count($page)-1];

$file = db_esc($file);
$sql="SELECT * FROM `db_help` WHERE `page`='$file'";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_ssfs();
ui_sfs('','w100');
while($l = mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th($l->name);
    ui_end_row();
    ui_rep_row();
    ui_rep_td_l($l->par);
    ui_end_row();
    
}
ui_efs();
ui_esfs();
ui_edlg();
