<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.edit.php';

define('PAGE_SEC', 'person.rawedit');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('create.php');
}



$p=db_single_record('db_person', 'id', $id);


if(!empty($_POST))
{
    $reg=$_POST['reg'];
        $reg=array_merge($p,$reg);
        $reg['total']=$reg['certificate_sum']+$reg['lct_sum']+$reg['cct_sum']+$reg['bct_sum'];
	$res=db_update_values($reg);
        
        $u=cr_userid();
        $diff=array_diff_assoc($p,$reg);
        
        $d=array();
        foreach ($diff as $k=>$v)
        {
            $d[]="('$id','$u','$k','$v','${reg[$k]}')";
        }
        
        
	$sql="UPDATE `db_person` SET $res WHERE (`id`='$id') LIMIT 1;";
	$r=mysql_query($sql) or debug($sql,mysql_error());

        if(!empty($d))
        {
            $sql="INSERT INTO `db_history` (`person_id`,`user_id`,`field`,`value_old`,`value_new`) VALUES ".implode(',',$d);
            $r=mysql_query($sql) or debug($sql,mysql_error());
        }
	ui_redirect("view.php?id=$id");
}



ui_sp('RAW Правка');
ui_sf();
ui_sfs();
foreach($p as $k=>$v)
{
    ui_text('reg',$k,$k,$v,'');
}
ui_efs();
ui_ef();
ui_ep();