<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/options.php';

define('PAGE_SEC','index');
cr_logic();

//setlocale(LC_ALL, 'Russian_Russia.1251');

if(!empty($_GET))
{
    $dn = (isset($_GET['reg']['delo_name']))?$_GET['reg']['delo_name']:'';
    $dn=ui_en2ru($dn);
    
    
    $dn=db_esc($dn);
    $opt=array();
    $opt['tf']=db_kv('db_time_form','id_time_form','abbr');
    $opt['ef']=db_kv('db_ef','id_ef','abbr');
    $opt['t_']=db_kv('db_target','id_target','abbr');
    $opt['tt']=db_kv('db_targettype','id_targettype','abbr');
    $opt['rc']=db_kv('db_region', 'id_region', 'abbr');
    $opt['tc']=db_kv('db_targetcell', 'id_targetcell', 'abbr');
    
    $sql="SELECT * FROM `db_person` WHERE `delo_name`='$dn'";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $l=mysql_fetch_assoc($r);
    if($l){
        ui_redirect("close.php?id=${l['id']}");
        
    }
    else
    {
        ui_redirect('kanckill.php');
        
    }
    
    
}
else {
    
ui_sp('Канцелярия');
ui_gf();
ui_sfs('','w100');
ui_text('reg','delo_name','Номер дела','','');
ui_efs();
ui_ef0();

ui_script_start();
print<<<EOF
document.getElementById('delo_name').style.lineHeight='36px';
document.getElementById('delo_name').style.fontSize='36px';
EOF;
ui_script_end();
ui_ep();
} 

