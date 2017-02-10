<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';


define('PAGE_SEC', 'control.planform');
cr_logic();

if(!empty ($_POST))
{
    $reg=$_POST['reg'];
    foreach($reg as $k=>$v)
    {
        foreach($v as $kk=>$vv)
        {
            foreach($vv as $kkk=>$vvv)
            {
                
                $sql=" INSERT INTO `db_planform` (`faculty_id`,`time_form_id`,`edu_form_id`,`total`) ".
                        " VALUES ('$k','$kk','$kkk','$vvv') ".
                        "  ON DUPLICATE KEY UPDATE `total`='$vvv'";
                $r=mysql_query($sql) or debug($sql,  mysql_error());
            }
        }
    }
    ui_redirect('planform.php');
}

ui_sp('Планы приёма');

$fc=db_kv('db_faculty', 'id', 'name');
$tf=db_kv('db_time_form', 'id_time_form', 'name');
$ef=db_kv('db_ef', 'id_ef', 'name');

$single=array();

foreach($fc as $a=>$x)
{
    foreach ($tf as $b=>$y)
    {
        foreach($ef as $c=>$z)
        {
            $single[$a][$b][$c]=0;
        }
    }
}

$sql="SELECT * FROM db_planform";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    $single[$l->faculty_id][$l->time_form_id][$l->edu_form_id]=$l->total;
}

ui_sf();
ui_stfs();
ui_rep_row();
ui_rep_th('Факультеты');
ui_rep_th('Форма обучения');
foreach ($ef as $k=>$v)
{
    ui_rep_th($v);
}

ui_end_row();
foreach ($fc as $k_fc=>$v_fc)
{
    ui_rep_row();
    
    ui_rep_th($v_fc,'',count($tf));
    foreach($tf as $k_tf=>$v_tf)
    {
        ui_rep_th($v_tf);
        foreach ($ef as $k_ef=>$v_ef)
        {
            $x=$single[$k_fc][$k_tf][$k_ef];
            ui_rep_th('<input type="text" name="'."reg[$k_fc][$k_tf][$k_ef]".'" class="elem" value="'.$x.'"/>');
        }
        ui_end_row();
    }
    
    
}


ui_etfs();
ui_sfs();
ui_submit('', '', '', 'Сохранить', '');
ui_efs();
ui_ef0();

ui_ep();