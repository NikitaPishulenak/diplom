<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC','control.macro');
cr_logic();
if(!empty($_POST))
{
    $sql=<<<EOF
    CREATE TABLE IF NOT EXISTS `db_sex` (
  `id_sex` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(60) NOT NULL,
    `sname` varchar(60) NOT NULL,
    `abbr` varchar(50) NOT NULL,
    PRIMARY KEY (`id_sex`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=cp1251  ;
EOF;
    
    $a=file_get_contents('sexs.php');
    $b=file_get_contents('form/sexs.php');
    $reg=$_POST['reg'];
    $c=str_replace('Пол',$reg['title'] , $a);
    $c=str_replace('sex',$reg['table'] , $c);
    $d=str_replace('sex',$reg['table'], $b);
    file_put_contents($reg['table'].'s.php', $c);
    file_put_contents('form/'.$reg['table'].'s.php', $d);
    $sql=str_replace('sex',$reg['table'] , $sql);
    $r=mysql_query($sql ) or debug($sql,  mysql_error());
    ui_redirect('macro_dict.php');
    
            
}
ui_sp("Macro");
ui_sf();
ui_text('reg', 'title', 'title', '', 50);
ui_text('reg', 'table', 'table', '', 50);
ui_submit('', '', 'Go','Go', '');
ui_ef0();
ui_ep();