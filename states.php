<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/states.php';

define('PAGE_SEC','control.states');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

if(!empty($_POST))
{
    if($id>0)
    {
        $reg= $_POST['reg'];
        $ret= db_update_values($reg);
        $sql="UPDATE `db_state` SET $ret WHERE `id_state`='$id' LIMIT 1 ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
    }
    else
    {
        $reg= $_POST['reg'];
        $ret=db_field_values($reg);
        $sql="INSERT INTO `db_state` (${ret[0]}) values (${ret[1]}) ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $id = mysql_insert_id();
    }
    ui_redirect("states.php?id=$id");
    
}



ui_sp("Состояния");
list_draw();
if($id)
{
    $p=db_single_record('db_state', 'id_state', "$id");
    form_draw($p,'edit');
}
else
{
    $p=db_empty_record('db_state');
    form_draw($p, 'create');
}
ui_ep();