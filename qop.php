<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','query.operation');
cr_logic();

if(!empty($_POST))
{
    $qop=$_POST['qop'];
    $reg=$_POST['reg'];
    /* ++ operation delete --*/
    if($qop['qop']=='1')
    {
        
        $x=  implode('\',\'', array_keys($reg));
        $sql="DELETE FROM `db_query` WHERE `id_query` in ('$x')";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        ui_redirect('query.php');
    }
    if($qop['qop']=='2')
    {
        $querys=array();
        $x=  implode('\',\'', array_keys($reg));
        $sql="SELECT * FROM `db_query` WHERE `id_query` in ('$x');";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        if(mysql_num_rows($r)>1)
        {
            while($l=  mysql_fetch_object($r)){
                if(strpos($l->query, "UNION"))
                {$querys[]=db_esc("$l->query");}
                else {            $querys[]=db_esc("($l->query)");}
            }
            
            $union=  implode(' UNION ', $querys);
            $u=  cr_userid();
            $sql="INSERT INTO `db_query` (`owner_id`,`query`,`name`) VALUES ('$u','$union','UNION');";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
            $id=  mysql_insert_id();
            ui_redirect("query.php?id=$id");
        }
    }
}

ui_redirect('query.php');

