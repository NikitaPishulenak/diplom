<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'core/libpdf.php';
include 'fpdf/fpdf.php';
define('PAGE_SEC','person.order_extract');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0) ui_redirect ('noaccess.php');
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

if(empty($where )) ui_redirect ('noacccess.php');

$options=array();
$options['time_form_id']=db_kv('db_time_form','id_time_form','order_extract');
$options['faculty']=db_kv('db_faculty','id','order_extract');
$options['edu_form']=db_kv('db_ef','id_ef','order_extract');
$options['settings']=db_kv('db_settings', 'hashkey', 'value');
$options['spec']=db_kv('db_faculty','id','spec');
$options['speccode']=db_kv('db_faculty','id','speccode');
$options['issued']=db_kv('db_month','id_month','issued');


$sql="SELECT * FROM `db_person` WHERE $where $obf";
$r=mysql_query($sql) or debug($sql,  mysql_error());
if(mysql_num_rows($r))
{
    $pdf= new FPDF('L','mm',array(230,160));
    $pdf->AddFont('TimesNRCyrMT', '', 'TIMCYR.php');    
}
while($l=mysql_fetch_object($r))
{
    order_extract($pdf, $l, $options);
}
$pdf->Output();
