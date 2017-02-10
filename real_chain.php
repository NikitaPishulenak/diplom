<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.php';

define('PAGE_SEC','real_chain.view');
cr_logic();

if(!empty($_POST))
{
    
    $reg=(isset($_POST['reg']))?$_POST['reg']:array();
    
    cr_tempclear();
    foreach($reg as $k=>$v)
    {
        cr_temppush($k);
        
    }
    cr_popchain();
    ui_redirect('real_chain.php');
}

ui_sp('Öåïî÷êà');
$f=cr_chainwhere('id');
$f=(empty($f))?'0':$f;
$sql="SELECT * FROM `db_person` WHERE ($f)";
$r=mysql_query($sql) or debug($sql,  mysql_error());
//print $sql;
ui_sf();
ui_ssfs();
ui_sfs();
ui_hidden('fix', 'me', 'tender');
while($l=  mysql_fetch_object($r))
{
    $ch=ui_chain_check('reg',$l->id,'',1);
    
    ui_rowlink($l->id, "$l->surname", "view.php", array("id=$l->id"),array(),array($ch,));
}
ui_efs();
ui_esfs();
ui_ef();

ui_ep();