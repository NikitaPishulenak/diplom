<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'groupkey', '���� ������', $p['groupkey'], 60);
    ui_text('reg', 'groupname', '��������', $p['groupname'], 60);
    
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_vlink('��������', "acls.php?id=${p['id_group']}");
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_groups` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "groups.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_group, $l->groupname, "groups.php", array("id=$l->id_group"));
    }
    ui_efs();
    ui_esfs();
}