<?php

$fid= isset($_REQUEST['fid']) ? $_REQUEST['fid'] : 0;

$hour=Date("H");


if ($hour<12)
  $hour = 9;
  else if ($hour<15)
    $hour = 12;
    else if ($hour<18)
      $hour=15;
        else 
          $hour=18;

$day = Date("d");
$mon = Date("m");

$day = 25;
$mon = 7;
$hour = 15;


$content = file_get_contents('http://172.20.0.22/rep_discrete.php?fid='.$fid.'&hour='.$hour.'&day='.$day.'&mon='.$mon);
preg_match('/<!-- START TABLE -->.*<!-- END TABLE -->/imsU',$content,$matches);

//$str='<TEXTAREA cols=20 rows=10>'.$content.'</TEXTAREA>';//matches[0];
$str=$matches[0];
?>
<style type="text/css">

th {
        font-size: 9pt;
	background-color:#f9fdfb;
	color:#444444;
  /*  border-top: 1px solid #aaaaaa;  */
  /*  border-left: 1px solid #aaaaaa; */
	border:0.5pt solid #aaaaaa;
}

 .stat {  
       font-size: 9pt;
       text-align: center;
    /*   border-top: 1px solid #aaaaaa; */
    /*   border-left: 1px solid #aaaaaa; */
	border: 0.5pt solid #aaaaaa;
       font-weight: normal;
}
.ender {
        border-bottom: 1px solid #aaaaaa;
}
table {
	border-collapse:collapse;
}

</style>
<!-- <h3><marquee style="color:red;height:20;width:500" scrollamount="500" scrolldelay="500">���� ���������� ���������� � 16 ����.</marquee></h3>-->
<!--<p style="font-size:14pt;color:red;font-weight:bold;">�����������, ����������� � �������� ��� ���������, �� ������� �� ��������� � �������� �������, � ���������� �� �������� ��������� ����.</p>-->
<?php
/*
if($fid==1)
{
print '<p style="font-size:14pt;font-weight:bold;">�� �������������� ����������, ��� ��������� ��������� �������� 1 ����� �� �������� ����������.</p>';
}
if($fid==3)
{
print '<p style="font-size:14pt;font-weight:bold;">�� �������������� ����������, ��� ��������� ��������� �������� 1 ����� �� �������������� ����������.</p>';
}
if($fid==4)
{
print '<p style="font-size:14pt;font-weight:bold;">�� �������������� ����������, ��� ��������� ��������� �������� 1 ����� �� ����������������� ����������.</p>';
}*/ 

  echo($str);
?>