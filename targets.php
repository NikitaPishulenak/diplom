<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/targets.php';

define('PAGE_SEC','control.targets');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

if(!empty($_POST))
{
    if($id>0)
    {
        $reg= $_POST['reg'];
        $ret= db_update_values($reg);
        $sql="UPDATE `db_target` SET $ret WHERE `id_target`='$id' LIMIT 1 ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
    }
    else
    {
        $reg= $_POST['reg'];
        $ret=db_field_values($reg);
        $sql="INSERT INTO `db_target` (${ret[0]}) values (${ret[1]}) ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $id = mysql_insert_id();
    }
    ui_redirect("targets.php?id=$id");
    
}



ui_sp("Конкурс");
list_draw();
if($id)
{
    $p=db_single_record('db_target', 'id_target', "$id");
    form_draw($p,'edit');
}
else
{
    $p=db_empty_record('db_target');
    form_draw($p, 'create');
}
ui_ep();