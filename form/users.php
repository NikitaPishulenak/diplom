<?php



function form_draw($p, $t)
{
    require_once 'form/options.php';
    ui_sf();
    ui_stfs();
        ui_sfs();
        ui_text('reg', 'username', "�����", $p['username'], 50);
        ui_text('reg', 'realname', "��� ������������", $p['realname'], 50);
        ui_pass('reg', 'password', "������", '', 50);
        ui_select('reg', 'group_id', "������", $options['group_id'],$p['group_id']);
        ui_text('reg','phones','�������',$p['phones'],50);
        ui_select('reg', 'def_faculty', '��������� �� ���������', $options['faculty'], $p['def_faculty']);
        ui_submit('what', "create", '�������',"�������" ,"" );
        ui_efs();
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_users` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "users.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id, $l->realname, "users.php", array("id=$l->id"));
    }
    ui_efs();
    ui_esfs();
}