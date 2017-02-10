<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();


$addr=array();

if(!empty($_POST))
{
    $reg=$_POST['reg'];
    $c=db_esc($reg['city_name']);
    $s=db_esc($reg['street_name']);
    $sql="SELECT * FROM `db_zip_by` WHERE (`city_name` LIKE '$c' AND `street_name` LIKE '$s')";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
}

ui_sdlg('Адреса почтовых отделений');
ui_sf();
ui_sfs();
ui_text('reg', 'city_name', 'НП', '', 50);
ui_text('reg', 'street_name', 'Улица', '', 50);
ui_efs();
ui_ef0();
ui_hr();
ui_sfs();
foreach($addr as $v)
{
    ui_rep_row();
    ui_rep_td($v->zipcode);
    ui_rep_td($v->street_name);
    ui_end_row();
}
ui_efs();

ui_edlg();

