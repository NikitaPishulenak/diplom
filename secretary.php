<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','secretary');
cr_logic();

ui_sp('������������');
$options=array();
$options['fc']=db_kv('db_faculty','id','abbr');
$options['tf']=db_kv('db_time_form', 'id_time_form', 'abbrdelo');

$filter=(cr_ukey('faculty'))?"?fc=".cr_ukey('faculty'):'';
echo '<p><a href="note_secr.php'.$filter.'">������� ��� ����������</a> </p><hr />';
echo '<p>��� ������������:';
$sql="SELECT * FROM `db_pool` ";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    echo $options['fc'][$l->faculty_id].$options['tf'][$l->time_form_id].'-'.$l->delo_id.';';
}
echo '</p>';

ui_hr();
ui_gf();
ui_stfs();
ui_sfs('�������');
ui_text('reg','surname','�������','','');
ui_efs();
ui_sptfs();
ui_sfs('�����/����');
ui_text('reg','town','��������� �����','','');
ui_efs();
ui_etfs();
ui_sc('�����');
ui_ef0();


if(isset($_GET['reg']))
{
    ui_hr();
    $reg=$_GET['reg'];
    $region_by=db_kv('db_region','id_region','name');
    if(isset($reg['surname']))
    {
        $s=db_esc($reg['surname']);
        
//        $sql="SELECT * FROM `db_ct_info` WHERE `surname` LIKE '%$s%';";
//        $r=mysql_query($sql) or debug($sql,  mysql_error());
//        if(mysql_num_rows($r))
//        {
//            ui_sfs('�������� � ���������������� ������������','w100');
//            while($l= mysql_fetch_object($r))
//            {
//                ui_rep_row();
//                ui_rep_td($l->surname);
//                ui_rep_td($l->name);
//                ui_rep_td($l->midname);
//                ui_end_row();
//            }
//            ui_efs();
//        }
        
        
        $sql="SELECT * FROM `db_voenmed` WHERE `surname` LIKE '%$s%'";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        if(mysql_num_rows($r))
        {
            ui_sfs('������ ����������� ������-������������ ����������','w100');
            while($l= mysql_fetch_object($r))
            {
                ui_rep_row();
                ui_rep_td($l->surname);
                ui_rep_td($l->name);
                ui_rep_td($l->midname);
                ui_end_row();
            }
            
            ui_efs();
        }
        
//        $sql="SELECT * FROM `db_vized_cell` WHERE `surname` LIKE '%$s%'";
//        $r=mysql_query($sql) or debug($sql,  mysql_error());
//        if(mysql_num_rows($r))
//        {
//            ui_sfs('������ ����������� ����������� ������� ��������','w100');
//            while($l= mysql_fetch_object($r))
//            {
//                ui_rep_row();
//                ui_rep_td($l->surname);
//                ui_rep_td($l->name);
//                ui_rep_td($l->midname);
//                ui_rep_td(ui_sap($region_by,$l->region_id));
//                ui_end_row();
//            }
//            
//            ui_efs();
//        }
        
//        $sql="SELECT * FROM `db_po_bsmu` WHERE `surname` LIKE '%$s%'";
//        $r=mysql_query($sql) or debug($sql,  mysql_error());
//        if(mysql_num_rows($r))
//        {
//            ui_sfs('������ ���������� ���������������� ������ ���� (������� ���������)','w100');
//            while($l= mysql_fetch_object($r))
//            {
//                ui_rep_row();
//                ui_rep_td($l->surname);
//                ui_rep_td($l->name);
//                ui_rep_td($l->midname);
//                ui_end_row();
//            }
//            
//            ui_efs();
//        }
        
        
        $sql="SELECT * FROM `db_republic` WHERE `surname` LIKE '%$s%'";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        if(mysql_num_rows($r))
        {
            ui_sfs('������ ����������� ��������������� ����� ��������������� ���������','w100');
            while($l= mysql_fetch_object($r))
            {
                ui_rep_row();
                ui_rep_td($l->surname);
                ui_rep_td($l->name);
                ui_rep_td($l->midname);
                ui_rep_td($l->subject);
                ui_rep_td($l->rank);
                ui_end_row();
            }
            ui_efs();
        }
        
        $sql="SELECT * FROM `db_president` WHERE `surname` LIKE '%$s%'";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        if(mysql_num_rows($r))
        {
            ui_sfs('������ ������� ������������ ����� ���������� ���������� ��������','w100');
            while($l= mysql_fetch_object($r))
            {
                ui_rep_row();
                ui_rep_td($l->surname);
                ui_rep_td($l->name);
                ui_rep_td($l->midname);
                ui_end_row();
            }
            ui_efs();
        }
        
    }
    if(isset($reg['town']))
    {
        $t=db_esc($reg['town']);
        $sql="SELECT * FROM `db_stalker` WHERE `town` LIKE '%$t%';";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        if(mysql_num_rows($r))
        {
            ui_sfs('������ ����','w100');
            while($l=  mysql_fetch_object($r))
            {
                ui_rep_row();
                ui_rep_td($region_by[$l->region_by]);
                ui_rep_td($l->area);
                ui_rep_td($l->ssname);
                ui_rep_td($l->town);
                ui_end_row();
            }
            ui_efs();
        }
        
        $sql="SELECT * FROM `db_smalltown` WHERE `town` LIKE '%$t%';";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        if(mysql_num_rows($r))
        {
            ui_sfs('������ �� 20','w100');
            while($l=  mysql_fetch_object($r))
            {
                ui_rep_row();
                ui_rep_td($region_by[$l->region_by]);
                ui_rep_td($l->town);
                ui_end_row();
            }
            ui_efs();
        }
        
        $sql="SELECT * FROM `db_nametown` WHERE `town` LIKE '%$t%';";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        if(mysql_num_rows($r))
        {
            ui_sfs('������ (����������)','w100');
            while($l=  mysql_fetch_object($r))
            {
                ui_rep_row();
                ui_rep_td($region_by[$l->region_by]);
                ui_rep_td($l->town);
                ui_end_row();
            }
            ui_efs();
        }
    }
}

ui_ep();
