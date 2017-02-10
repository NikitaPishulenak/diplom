<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','person.inventory');
cr_logic();

//$id=''

$inv=db_kv('db_inventory_doc', 'id_inventory_doc', 'name');
$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

    
ui_sp('Мастер описи');
if(!$id)
{
    ui_sf('inventory.php');
}
else
{
    ui_sf("inventory.php?id=$id");
}
    ui_stfs();
    ui_sfs();
    for($i=1;$i<21;$i++)
    {
        ui_select('row', $i, $i, $inv, '0');
    }
    ui_efs();
    ui_etfs();
ui_ef();
ui_ep();