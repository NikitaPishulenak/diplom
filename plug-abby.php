<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','plug-abby');
cr_logic();

$settings = db_kv('db_settings', 'hashkey', 'value');

$login=$settings['abby_login'];
$pass=md5(md5($settings['abby_pass']));
$monid='';

$tf=isset($_GET['tf'])?(int)$_GET['tf']:0;
$fc=isset($_GET['fc'])?(int)$_GET['fc']:0;

$wfc=($fc)?" AND `faculty`='$fc'":'';
$wfcp=($fc)?" AND `faculty_id`='$fc'":'';
$wtf=($tf)?" AND `time_form_id`='$tf'":'';

$fc_arr=db_kv('db_faculty','id','name');
$tf_arr=db_kv('db_time_form', 'id_time_form', 'name');

$afx = isset($_GET['afx']) ? (int) $_GET['afx'] : 0;
$mfx = isset($_GET['mfx']) ? (int) $_GET['mfx'] : 0;

$afx_arr= db_kv('afx`.`db_fixation','id_fixation','name');
$mfx_arr= db_kv('mfx`.`db_fixation','id_fixation','name');

if($afx<0) $afx=end(array_keys($afx_arr));
$target_table=($afx)?'`afx`.`db_fixed_target`':'`db_person`';
$target_table=($mfx)?'`mfx`.`db_fixed_target`':$target_table;


$fid=($afx)?"`fixation_id`=$afx AND ":'';
$fid=($mfx)?"`fixation_id`=$mfx AND ":$fid;

ui_sp('Плагин для Абитуриент.by');




ui_gf();
ui_stfs();
ui_sfs();
ui_efs();
ui_sptfs3('vsplitter3_none');
ui_sfs();
ui_select('', 'fc', 'Факультет', $fc_arr, $fc);
ui_select('', 'tf', 'Отделение', $tf_arr, $tf);
ui_select('','afx','Автоматическая',$afx_arr,$afx);
ui_select('','mfx','Ручная',$mfx_arr,$mfx);
ui_submit('', '', '', 'Показать', '');
ui_efs();
ui_sptfs3('vsplitter3_none');
ui_sfs();
ui_efs();
ui_etfs();
ui_ef0();


$sql=<<<EOF
select
    (select sum(total) from db_planform where (edu_form_id=1 $wtf $wfcp)) plan_free,
    (select sum(plan) from db_plancell where (1 $wfcp )) plan_cell,
    (select sum(total) from db_planform where (edu_form_id=2 $wtf $wfcp)) plan_paid
EOF;
$r=mysql_query($sql) or debug($sql,mysql_error());

$l= mysql_fetch_object($r);
$plan_free = $l->plan_free;
$plan_cell = $l->plan_cell;
$plan_paid = $l->plan_paid;

if($tf == 2) $plan_cell = 0;



$sql=<<<EOF
    (SELECT 700 as t,
    count(if(`edu_form`=1 AND `target`=4 ,`total`,null)) as t1,
    0 as t2,
    count(if(`edu_form`=2 AND `target`=4 ,`total`,null)) as t3,
    0 as t4,
    0 as  t5
    FROM $target_table WHERE ( $fid `state_id`=1 AND `target`=4 $wfc $wtf ) GROUP BY `t` ) 
    UNION 
    (SELECT 600 as t,
    count(if(`edu_form`=1 AND `target`=5,`total`,null)) as t1,
    0 as t2,
    count(if(`edu_form`=2 AND `target`=5,`total`,null)) as t3,
    0 as t4,
    0 as t5
    FROM $target_table WHERE ( $fid `state_id`=1 AND `target`=5 $wfc $wtf ) GROUP BY `t` ) 
    UNION 
    (SELECT 500 as t,
    count(if(`edu_form`=1 AND `target`=2,`total`,null)) as t1,
    0 as t2,
    count(if(`edu_form`=2 AND `target`=2,`total`,null)) as t3,
    0 as t4,
    0 as t5
    FROM $target_table WHERE ( $fid `state_id`=1 AND `target`=2 $wfc $wtf ) GROUP BY `t` ) 
    UNION 
    (SELECT DISTINCT (ceil(total/10))*10 as t,
    count(if(`edu_form`=1 AND `target`=3 AND `target_type`=1,`total`,null)) as t1,
    count(if(`edu_form`=1 AND `target`=3 AND `target_type`=2,`total`,null)) as t2,
    count(if(`edu_form`=2 AND `target`=3,`total`,null)) as t3,
    0 as t4,
    count(if(`edu_form`=1 AND `target`=1,`total`,null)) as t5
    FROM $target_table WHERE ( $fid `state_id`=1 AND (`target`=3 or `target`=1) $wfc $wtf ) GROUP BY `t` ) ORDER BY `t` DESC;
EOF;

$total_free=0;
$total_paid=0;
$total_cell=0;
$wo_free=0;
$wo_paid=0;
$wo_pvk=0;
$wo_mo=0;
$ars=array();
$ars['341_400'][1]=0;
$ars['341_400'][2]=0;
$ars['341_400'][3]=0;
$ars['341_400'][4]=0;
for($i=340;$i>109;$i-=10)
{
    $d=$i-9;
    $k="${d}_${i}";
    $ars[$k][1]='0';
    $ars[$k][2]='0';
    $ars[$k][3]='0';
    $ars[$k][4]='0';
}
$ars['60_100'][1]=0;
$ars['60_100'][2]=0;
$ars['60_100'][3]=0;
$ars['60_100'][4]=0;

$ars['0_59'][1]=0;
$ars['0_59'][2]=0;
$ars['0_59'][3]=0;
$ars['0_59'][4]=0;

ui_sfs();
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    /*
    ui_rep_row();
    ui_rep_th($l->t);
    ui_rep_td($l->t1);
    ui_rep_td($l->t2);
    ui_rep_td($l->t3);
    ui_rep_td($l->t4);
    ui_end_row();
    */
    $t=(int)$l->t;
    $t1=(int)$l->t1;
    $t2=(int)$l->t2;
    $t3=(int)$l->t3;
    $t4=(int)$l->t4;
    $t5=(int)$l->t5;
    $total_free+=$t1+$t2+$t5;
    $total_cell+=$t5;
    $total_paid+=$t3+$t4;
    if($t==700)
    {
        $wo_pvk=$t1+$t3;
        continue;
    }
    if($t==600)
    {
        $wo_mo=$t1+$t3;
        continue;
    }
    if($t==500)
    {
        $wo_free=$t1+$t2;
        $wo_paid=$t3+$t4;
        continue;
    }
    if($t<401 && $t>340)
    {
        $ars['341_400'][1]+=$t1;
        $ars['341_400'][2]+=$t2;
        $ars['341_400'][3]+=$t3;
        $ars['341_400'][4]+=$t4;
        continue;
    }
    if($t<341 && $t>100)
    {
        $d=$t-9;
        $k="${d}_${t}";
        $ars[$k][1]=$t1;
        $ars[$k][2]=$t2;
        $ars[$k][3]=$t3;
        $ars[$k][4]=$t4;
        continue;
    }
    if($t<101 && $t>59)
    {
        $ars['60_100'][1]=$t1;
        $ars['60_100'][2]=$t2;
        $ars['60_100'][3]=$t3;
        $ars['60_100'][4]=$t4;
        continue;
    }
    if($t<60)
    {
        $ars['0_59'][1]=$t1;
        $ars['0_59'][2]=$t2;
        $ars['0_59'][3]=$t3;
        $ars['0_59'][4]=$t4;
        continue;
    }
}
ui_efs();

$monid='';

$sql="SELECT `monid` FROM `db_abby_monid` WHERE (1 $wfcp $wtf) LIMIT 1";
$r=mysql_query($sql) or debug($sql,  mysql_error());
$l=mysql_fetch_object($r);
if($l)
{
   $monid=$l->monid; 
}

$str1=<<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/encoding/"
 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
 xmlns:xsd="http://www.w3c.org/2001/XMLSchema"
 xmlns:xsl="http://www.w3c.org/2001/XMLSchema-instance"
 xmlns:SOAP-ENC="http://shemas.xmlsoap.org/soap/encoding/"    
 xmlns:tns="urn:abiturient">
<SOAP-ENV:Body>
<tns:updateMonitoring xmlns="urn:abiturient">
<login xsi:type="xsd:string">$login</login>
<password xsi:type="xsd:string">$pass</password>
<monitoring_id xsi:type="int">$monid</monitoring_id>
<plan_budget_total xsi:type="int">$plan_free</plan_budget_total>
<plan_budget_navigation xsi:type="int">$plan_cell</plan_budget_navigation>
<total xsi:type="int">$total_free</total>
<task_training xsi:type="int">$total_cell</task_training>
<without_preliminary_examination xsi:type="int">$wo_free</without_preliminary_examination>
<without_competition>$wo_mo</without_competition>
<plan_pay xsi:type="int">$plan_paid</plan_pay>
<pay_count_real xsi:type="int">$total_paid</pay_count_real>
<wo_preex_pay xsi:type="int">$wo_paid</wo_preex_pay>
<wo_competition_pay xsi:type="int">$wo_pvk</wo_competition_pay>
EOF;


$str2='';
foreach($ars as $k=>$v)
{
    $strt=<<<EOF

<city_$k xsi:type="tns:RateCount">
    <free xsi:type="xsi:int">$v[1]</free>
    <paid xsi:type="xsi:int">$v[3]</paid>    
</city_$k>

<country_$k xsi:type="tns:RateCount">
    <free xsi:type="xsi:int">$v[2]</free>
    <paid xsi:type="xsi:int">$v[4]</paid>    
</country_$k>

EOF;
    $str2.=$strt;
}

$str3=<<<EOF

</tns:updateMonitoring>
</SOAP-ENV:Body>
</SOAP-ENV:Envelope>
EOF;

print<<<EOF
<textarea style="width:100%;" cols="80" rows="25">
    $str1
    $str2
    $str3
</textarea>        
EOF;

ui_ep();