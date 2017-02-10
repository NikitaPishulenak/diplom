<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.php';

define('PAGE_SEC', 'person.groupedit');
cr_logic();

if(!empty($_POST))
{
    $w= cr_tempwhere('id');
    $reg=$_POST['reg'];
    $proto_date=(isset($_POST['date']['proto_date']))?$_POST['date']['proto_date']:array('d'=>0,'m'=>0,'y'=>0);
    $order_date=(isset($_POST['date']['order_date']))?$_POST['date']['order_date']:array('d'=>0,'m'=>0,'y'=>0);
    $arrive_date=(isset($_POST['date']['arrive_date']))?$_POST['date']['arrive_date']:array('d'=>0,'m'=>0,'y'=>0);
    
    $reg['proto_date']=db_mkdate($proto_date);
    $reg['order_date']=db_mkdate($order_date);
    $reg['arrive_date']=db_mkdate($arrive_date);
    $res=db_update_values($reg);
    $sql="UPDATE `db_person` SET $res WHERE $w";
    
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    
    ui_redirect('index.php');
}

ui_sp('��������� ��������������');
ui_sf();
ui_stfs();

    ui_sfs();
        
    ui_efs();
    
    ui_sptfs();
    
    ui_sfs();
    ui_text('reg','proto_num', '����� ���������', '', 10);
    ui_date_edit('reg', 'proto_date', '���� ���������', '');
    ui_text('reg','order_num', '����� �������', '', 10);
    ui_date_edit('reg', 'order_date', '���� �������', '');
    ui_date_edit('reg', 'arrive_date', '���� ��������', '');
    ui_text('reg','arrive_time', '����� ��������', '', 5);
    ui_text('reg','arrive_room','��������','',10);
    ui_efs();
    
ui_etfs();
ui_ef();
ui_ep();