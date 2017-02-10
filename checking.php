<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();

set_time_limit(0);

ui_sp('Ñëîâàğíàÿ ïğîâåğêà');

ui_cm('Äîïóñòèìûé Êîíêóğñ');
ui_hr();

/* ------------------- */
ui_cm('Èìåíà');
$sql="select `id`,`delo_name`,`surname`,`name`,`midname` from `db_person` where `name` not in (select `n1` from spfw.db_person_names)";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs();
while($l=  mysql_fetch_object($r))
{
    ui_rowlink($l->id,$l->surname.' '.$l->name.' '.$l->midname , 'view.php?id='.$l->id);
}
ui_efs();
ui_hr();

/* ------------------- */
ui_cm('Îò÷åñòâà');
$sql="select `id`,`delo_name`,`surname`,`name`,`midname` from `db_person` where `midname` not in (select `n1` from spfw.db_person_midname)";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs();
while($l=  mysql_fetch_object($r))
{
    ui_rowlink($l->id,$l->surname.' '.$l->name.' '.$l->midname , 'view.php?id='.$l->id);
}
ui_efs();
ui_hr();

/* ------------------- */
ui_cm('Ãîğîäà(àäğåñ)');
$sql="select `id`,`delo_name`,`surname`,`name`,`midname` from `db_person` where `city_name` not in (select `n1` from spfw.db_city_name)";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs();
while($l=  mysql_fetch_object($r))
{
    ui_rowlink($l->id,$l->surname.' '.$l->name.' '.$l->midname , 'view.php?id='.$l->id);
}
ui_efs();
ui_hr();

/* ------------------- */
ui_cm('Ãîğîäà(óî)');

$sql="select `id`,`delo_name`,`surname`,`name`,`midname` from `db_person` where `inst_city_name` not in (select `n1` from spfw.db_city_name)";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs();
while($l=  mysql_fetch_object($r))
{
    ui_rowlink($l->id,$l->surname.' '.$l->name.' '.$l->midname , 'view.php?id='.$l->id);
}
ui_efs();
ui_hr();


/* ------------------- */
ui_ep();