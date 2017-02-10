<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/tag_historys.php';

define('PAGE_SEC','control.tag_historys');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

if(!empty($_POST))
{
    if($id>0)
    {
        $reg= $_POST['reg'];
        $ret= db_update_values($reg);
        $sql="UPDATE `db_tag_history` SET $ret WHERE `id_tag_history`='$id' LIMIT 1 ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
    }
    else
    {
        $reg= $_POST['reg'];
        $ret=db_field_values($reg);
        $sql="INSERT INTO `db_tag_history` (${ret[0]}) values (${ret[1]}) ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $id = mysql_insert_id();
    }
    ui_redirect("tag_historys.php?id=$id");
    
}



ui_sp("История тэгов");
list_draw();
if($id)
{
    $p=db_single_record('db_tag_history', 'id_tag_history', "$id");
    form_draw($p,'edit');
}
else
{
    $p=db_empty_record('db_tag_history');
    form_draw($p, 'create');
}
ui_ep();