<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'fpdf/fpdf.php';
include 'core/libpdf.php';
define('PAGE_SEC','person.inventory');
cr_logic();

/*
ui_sp('����� ������� ����');

ui_ep();
 
 */

$docs=db_kv('db_inventory_doc', 'id_inventory_doc', 'code');
$documents=array();
$cnt=array();
if(!empty($_POST))
{
    $row=(isset($_POST['row']))?$_POST['row']:array();
    $cnt=(isset($_POST['col']))?$_POST['col']:array();
    foreach($row as $v)
    {
        if($v>0) $documents[]=explode ('\\', $docs[$v]);
    }
}

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if(!$id)
{
    $where=cr_tempwhere('id');
    $obf=cr_order_in('id');
}
else
{
    $where="`id`='$id' LIMIT 1";
    $obf='';
}
$options=array();
$options['certificate_id']=db_kv('db_certificate','id_certificate','name');
$sql="SELECT * FROM `db_person` WHERE $where $obf";
$r=mysql_query($sql) or debug($sql,  mysql_error());
if(mysql_num_rows($r))
{
    $pdf= new FPDF('P','mm','A4');
    $pdf->AddFont('TimesNRCyrMT', '', 'TIMCYR.php');
    $pdf->AddFont('TimesNRCyrMT-Bold', '', 'TIMCYRB.php');
    $pdf->SetAutoPageBreak(true,0);
}
while($l=mysql_fetch_object($r))
{
    inventory_clear($pdf, $l, $options,$documents,$cnt);
}
$pdf->Output();