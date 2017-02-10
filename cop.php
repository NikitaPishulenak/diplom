<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','chain.operation');
cr_logic();

if(!empty($_POST))
{
    $cop=$_POST['cop'];
    $reg=(isset($_POST['reg']))?$_POST['reg']:array();
    if($cop['cop']=='1')
    {
               $x=  implode('\',\'', array_keys($reg));
        $sql="DELETE FROM `db_chain` WHERE `id_chain` in ('$x')";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        //$sql="DELETE FROM `db_chid` WHERE `chain_id` in ('$x')";
        $sql="UPDATE `db_chid`  SET `chain_id` =0  WHERE `chain_id` in ('$x')";
        
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        
        ui_redirect('chain.php');
 
    }
    if($cop['cop']=='2')
    {
        // via temp table;
        
    }
}
ui_redirect('chain.php');