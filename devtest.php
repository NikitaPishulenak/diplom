<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','control.devtest');
cr_logic();

ui_sp('Тест');
ui_sfs('','w100');
$dir=getcwd();
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
           // echo "filename: $file : filetype: " .  "\n";
            if(@filetype($file)=='dir')                continue;;
            ui_rep_row();
            ui_rep_th($file);
            $c=@file_get_contents($file);
            $m=array();
            $s=preg_match('/define(.*)\n/', $c,$m);
            ui_rep_td($s);
            @ui_rep_td_r($m[1]);
            $s=preg_match('/ui_sp\((.*)\);/', $c,$m);
            ui_rep_td($s);
            @ui_rep_td_r($m[1]);
            ui_end_row();
            
        }
        closedir($dh);
    }
}
ui_efs();
ui_hr();


ui_ep();
