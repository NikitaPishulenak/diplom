<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC','control.devzero');
cr_logic();

if(!empty($_POST))
{
    $sql="TRUNCATE `db_person`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_target_history`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="UPDATE `db_submitted` SET `total`=0";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_history`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_call`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_pool`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_move_journal`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_chain`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_chid`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_ct_info`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_fax`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_files`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_history`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_mail`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_person`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_person_talks`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_pipeline`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_pool`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_query`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_chain`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_savefield`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_secviol`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_tag`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_tag_relation`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_target_history`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_vized_cell`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_applog`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());

    $link = mysql_connect('localhost', 'root', '7781715');

    $db_selected = mysql_select_db('afx', $link);
	if (!$db_selected) {
    		die ('Не удалось выбрать базу afx: ' . mysql_error());
	}else{

    $sql="TRUNCATE `db_fixation`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_fixed_target`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
}

    $db_selected = mysql_select_db('mfx', $link);
	if (!$db_selected) {
    		die ('Не удалось выбрать базу mfx: ' . mysql_error());
	}else{


    $sql="TRUNCATE `db_fixation`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_fixed_target`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $sql="TRUNCATE `db_fixed_history`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
}


}

ui_sp('Занулить');
ui_sf();
ui_hidden('reg', 'null', '1');
ui_cm('При нажатии этой кнопки база готова к новому приёму документов.');
ui_sc('Занулить?');
ui_ef0();
ui_ep();