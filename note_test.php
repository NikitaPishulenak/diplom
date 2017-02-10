<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC','note.test');
cr_logic();

$cr=db_kv('db_region','id_region','abbr');
$fc=db_kv('db_faculty','id','name');
$count_cr=count($cr)+1;
ui_sp('Справка о ходе приёма документов');

ui_stfs();
    ui_rep_row();
    ui_rep_th('Факультет','','4');
    ui_rep_th('План приёма','2');
    ui_rep_th('Подано заявлений',5+$count_cr);
    ui_rep_th('Забрали документы','','4');
    ui_end_row();
    
    ui_rep_row();
    ui_rep_th('Всего','','3');
    ui_rep_th('Целевой','','3');
    ui_rep_th('Всего','','3');
    ui_rep_th('В том числе',4+$count_cr);
    ui_end_row();
    
    ui_rep_row();
    ui_rep_th("Общий\nгородской\nконкурс",'','2');
            
    ui_rep_th("Общий\nсельский\nконкурс",'','2');
    ui_rep_th('Без исп.','','2');
    ui_rep_th('МО','','2');
    ui_rep_th('Целевой',$count_cr);
    ui_end_row();
    
    ui_rep_row();
    foreach ($cr as $v)
    {
        ui_rep_th($v);
    }
    ui_rep_th('Всего');
    ui_end_row();
    
    foreach($fc as $k_fc=>$v_fc)
    {
        ui_rep_row();
        ui_rep_th($v_fc);
        ui_rep_td(0);
        ui_rep_td(0);
        ui_rep_td(report_count($k_fc, 1, 1, 0, 0, 0, 0, 1));
        ui_rep_td(report_count($k_fc, 1, 1, 3, 1, 0, 0, 1));
        ui_rep_td(report_count($k_fc, 1, 1, 3, 2, 0, 0, 1));
        ui_rep_td(report_count($k_fc, 1, 1, 2, 0, 0, 0, 1));
        ui_rep_td(report_count($k_fc, 1, 1, 5, 0, 0, 0, 1));
        foreach ($cr as $k_cr=>$v_cr)
        {
            ui_rep_td(report_count($k_fc, 1, 1, 1, 0, 0, $k_cr, 1));
        }
        ui_rep_td(report_count($k_fc, 1, 1, 1, 0, 0, 0, 1));
        ui_rep_td(report_count($k_fc, 1, 1, 0, 0, 0, 0, 2));
        ui_end_row();
    }
    ui_rep_row();
    ui_rep_th('Всего');
    ui_rep_th(0);
    ui_rep_th(0);
    ui_rep_th(report_count(0, 1, 1, 0, 0, 0, 0, 1));
    ui_rep_th(report_count(0, 1, 1, 3, 1, 0, 0, 1));
    ui_rep_th(report_count(0, 1, 1, 3, 2, 0, 0, 1));
    ui_rep_th(report_count(0, 1, 1, 2, 0, 0, 0, 1));
    ui_rep_th(report_count(0, 1, 1, 5, 0, 0, 0, 1));
    foreach ($cr as $k_cr=>$v_cr)
    {
            ui_rep_th(report_count(0, 1, 1, 1, 0, 0, $k_cr, 1));
    }
    ui_rep_th(report_count(0, 1, 1, 1, 0, 0, 0, 1));
    ui_rep_th(report_count(0, 1, 1, 0, 0, 0, 0, 2));
    ui_end_row();
ui_etfs();
    
ui_ep();