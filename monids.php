<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';


define('PAGE_SEC', 'control.monids');
cr_logic();

if(!empty ($_POST))
{
    $reg=$_POST['reg'];
    foreach($reg as $k=>$v)
    {
        foreach($v as $kk=>$vv)
        {
            
                
                $sql=" INSERT INTO `db_abby_monid` (`faculty_id`,`time_form_id`,`monid`) ".
                        " VALUES ('$k','$kk','$vv') ".
                        "  ON DUPLICATE KEY UPDATE `monid`='$vv'";
                $r=mysql_query($sql) or debug($sql,  mysql_error());
            
        }
    }
    ui_redirect('monids.php');
}

ui_sp('ID Мониторинга');

$fc=db_kv('db_faculty', 'id', 'name');
$tf=db_kv('db_time_form', 'id_time_form', 'name');


$single=array();

foreach($fc as $a=>$x)
{
    foreach ($tf as $b=>$y)
    {
        $single[$a][$b] = '';
    }
}

$sql="SELECT * FROM db_abby_monid";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    $single[$l->faculty_id][$l->time_form_id]=$l->monid;
}

ui_sf();
ui_stfs();
ui_rep_row();
ui_rep_th('Факультеты');
//ui_rep_th('Форма обучения');
foreach ($tf as $k=>$v)
{
    ui_rep_th($v);
}

ui_end_row();
foreach ($fc as $k_fc=>$v_fc)
{
    ui_rep_row();
    
    ui_rep_th($v_fc);
    foreach($tf as $k_tf=>$v_tf)
    {
        //ui_rep_th($v_tf);
        
            $x=$single[$k_fc][$k_tf];
            ui_rep_th('<input type="text" name="'."reg[$k_fc][$k_tf]".'" class="elem" value="'.$x.'"/>');
        
        
    }
    ui_end_row();
    
    
}


ui_etfs();
ui_sfs();
ui_submit('', '', '', 'Сохранить', '');
ui_efs();
ui_ef0();

ui_ep();