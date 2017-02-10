<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';


include 'fpdf/fpdf.php';
include 'core/libpdf.php';
define('PAGE_SEC','person.listcase');
cr_logic();



$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0) ui_redirect ('noaccess.php');
if(!$id)
{
    $where=cr_tempwhere('id');
}
else
{
    $where="`id`='$id' LIMIT 1";
}

if(empty($where )) ui_redirect ('noacccess.php');

$options=array();
$options['faculty']=db_kv('db_faculty','id','name');
$options['spec']=db_kv('db_faculty','id','spec');
$options['speccode']=db_kv('db_faculty','id','speccode');
$options['certificate_id']=db_kv('db_certificate','id_certificate','name');
$options['institution_id']=db_kv('db_institution', 'id_institution', 'issued');
$options['subdiv']=db_kv('db_subdiv','id_subdiv','envelop_abbr');
$options['inst_city_type']=$options['subdiv'];
$options['settings']=db_kv('db_settings', 'hashkey', 'value');
$options['issued']=db_kv('db_month','id_month','issued');

$sql="SELECT * FROM `db_person` WHERE $where";
$r=mysql_query($sql) or debug($sql,  mysql_error());
if(mysql_num_rows($r))
{
    $pdf= new FPDF('P','mm','A5');
    $pdf->AddFont('TimesNRCyrMT', '', 'TIMCYR.php');
    $pdf->AddFont('TimesNRCyrMT-Bold', '', 'TIMCYRB.php');

}
while($l=mysql_fetch_object($r))
{
    listcase($pdf, $l, $options);
}
$pdf->Output();