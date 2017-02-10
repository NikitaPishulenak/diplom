<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/institutions.php';

define('PAGE_SEC','control.institutions');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

if(!empty($_POST))
{
    if($id>0)
    {
        $reg= $_POST['reg'];
        $ret= db_update_values($reg);
        $sql="UPDATE `db_institution` SET $ret WHERE `id_institution`='$id' LIMIT 1 ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
    }
    else
    {
        $reg= $_POST['reg'];
        $ret=db_field_values($reg);
        $sql="INSERT INTO `db_institution` (${ret[0]}) values (${ret[1]}) ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $id = mysql_insert_id();
    }
    ui_redirect("institutions.php?id=$id");
    
}



ui_sp("Типы Учебных заведений");
list_draw();
if($id)
{
    $p=db_single_record('db_institution', 'id_institution', "$id");
    form_draw($p,'edit');
}
else
{
    $p=db_empty_record('db_institution');
    form_draw($p, 'create');
}
ui_ep();