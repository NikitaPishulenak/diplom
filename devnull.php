<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC','control.devnull');
cr_logic();

if(!empty($_POST))
{

    $sql="show tables;";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=mysql_fetch_array($r))
    {
        $table=$l[0];
        $tsql="truncate `$table`;";
        $rr=mysql_query($tsql) or debug($tsql,  mysql_error());
    }
    $sql="INSERT INTO `db_users` (`username`,`realname`,`password`,`group_id`) VALUES ('root','administrator','1234','1');";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="INSERT INTO `db_keys` (`keystring`,`keyname`) VALUES ('*','WILDCARD');";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="INSERT INTO `db_groups` (`groupname`) VALUES ('Admins')";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="INSERT INTO `db_acl` (`group_id`,`key_id`,`value`) VALUES (1,1,1)";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_redirect('devnull.php');
    
}

ui_sp('Отчистить всё');
ui_sf();
ui_cm("При нажатии этой кнопки отчищаются все таблицы и создаётся пользователь root с паролем 1234");
ui_hidden('reg', 'null', '1');
ui_sc("Отчистить?");
ui_ef0();
ui_ep();