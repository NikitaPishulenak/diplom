<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC', 'debug.desql');
cr_logic();

set_time_limit(0);
$sql='';
ui_sp('SQL');
ui_sf();
ui_stfs();
ui_sfs();
ui_ta('reg','sql','Запрос',$_POST['reg']['sql'],'');
ui_submit('','','','Выполнить','');
ui_efs();
ui_etfs();
ui_ef0();
ui_ssfs();
ui_sfs();
if(!empty($_POST))
{
    $sql=$_POST['reg']['sql'];
    $r=  mysql_query($sql) or debug(mysql_error(),$sql);
    if($r)
    {
        ui_rep_row();
        while($l=  mysql_fetch_field($r))
        {
            ui_rep_th($l->name);
        }
        ui_end_row();
        while($l=  mysql_fetch_array($r))
        {
            ui_rep_row();
            for($i=0;$i<mysql_num_fields($r);$i++)
            {
                ui_rep_td_l($l[$i]);
            }
            ui_end_row();
        }
    }
}
ui_efs();
ui_esfs();
print $sql;
ui_ep();
