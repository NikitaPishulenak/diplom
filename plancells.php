<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';


define('PAGE_SEC','control.plancells');
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
                
                $sql=" INSERT INTO `db_plancell` (`faculty_id`,`targetcell_id`,`region_id`,`plan`) ".
                        " VALUES ('$k','$kk','$kkk','$vvv') ".
                        "  ON DUPLICATE KEY UPDATE `plan`='$vvv'";
                $r=mysql_query($sql) or debug($sql,  mysql_error());
            }
        }
    }
    ui_redirect('plancells.php');
}

ui_sp('План целевого набора');

$f=db_kv('db_faculty', 'id', 'name');
$c=db_kv('db_targetcell', 'id_targetcell', 'name');
$rr=db_kv('db_region','id_region','name');
ui_sf();
ui_stfs();

/* инициализация массива */
$single=array();
$summary=array();

foreach($f as $k=>$v)
{
    foreach ($c as $kk=>$vv)
    {
        
        foreach($rr as $kkk=>$vvv)
        {
            $single[$k][$kk][$kkk]=0;
            $summary[$k][$kkk]=0;
        }
    }
}
/** @todo FIXME */
/* запрос */
$sql="SELECT * FROM db_plancell";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    $single[$l->faculty_id][$l->targetcell_id][$l->region_id]=$l->plan;
    $summary[$l->faculty_id][$l->region_id]+=$l->plan;
}
/* Заголовок */
ui_rep_row();
ui_rep_th("Факультеты");
ui_rep_th("Тип целевого");
foreach($rr as $k=>$v)
{
    ui_rep_th($v);
}
ui_end_row();
/* перечесление факультетов */
foreach($f as $k=>$v)
{
    ui_rep_row();
    ui_rep_th("<nobr>$v</nobr>",'',3);
    ui_rep_th("Всего:");
    foreach ($rr as $kk=>$vv)
    {
        ui_rep_th($summary[$k][$kk]);
    }
    ui_end_row();
    foreach($c as $kk=>$vv)
    {
        ui_rep_row();
        ui_rep_th("<nobr>$vv:</nobr>");
        foreach($rr as $kkk=>$vvv)
        {
            $x=$single[$k][$kk][$kkk];
            ui_rep_th('<input type="text"  name="'."reg[$k][$kk][$kkk]".'" class="elem" value="'.$x.'"/>');
                
            /*print<<<EOF
                <td class="rep_td">
                    <input class="elem" type="text" name="reg[$k][$kk][$kkk]" value="$x" />
                        
                </td>
EOF;*/
        }
        ui_end_row();
    }
}
ui_etfs();
ui_sfs();
ui_submit('what', 'save', '', 'Update', '');
ui_efs();

ui_ef0();
ui_ep();