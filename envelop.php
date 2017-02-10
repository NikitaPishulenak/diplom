<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'core/libpdf.php';
include 'fpdf/fpdf.php';
define('PAGE_SEC','person.envelop');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0) ui_redirect ('noaccess.php');
if(!$id)
{
    $obf=cr_order_in('id');
    $where=cr_tempwhere('id');
}
else
{
    $where="`id`='$id' LIMIT 1";
    $obf='';
}

if(empty($where )) ui_redirect ('noacccess.php');

$options=array();
$options['subdiv']=db_kv('db_subdiv','id_subdiv','abbr');
$options['region_by']=db_kv('db_region','id_region','name');
$options['country']=db_kv('db_country','id_country','name');


$sql="SELECT * FROM `db_person` WHERE $where $obf";
$r=mysql_query($sql) or debug($sql,  mysql_error());
if(mysql_num_rows($r))
{
    $pdf= new FPDF('L','mm',array(230,160));
    $pdf->AddFont('TimesNRCyrMT', '', 'TIMCYR.php');    
}
while($l=mysql_fetch_object($r))
{
    envelop($pdf, $l, $options);
}
$pdf->Output();



