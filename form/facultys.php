<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', '��������', $p['name'], 60);
    ui_text('reg', 'sname', '��������', $p['sname'], 60);
    ui_text('reg', 'abbr', '������������', $p['abbr'], 60);
    //ui_text('reg', 'idelo', '������', $p['idelo'], 60);
    ui_text('reg', 'spec', '�������������', $p['spec'], 60);
    ui_text('reg', 'speccode', '���', $p['speccode'], 60);
    ui_text('reg', 'place', '��� ���������� �������', $p['place'], 60);
    ui_text('reg', 'chief', '�����', $p['chief'], 60);
    ui_text('reg', 'chief_phone', '�������', $p['chief_phone'], 60);
    ui_text('reg', 'order_extract', '�������', $p['order_extract'], 60);
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_faculty` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "facultys.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id, $l->name, "facultys.php", array("id=$l->id"),array($l->sname,$l->abbr,$l->idelo,$l->spec,$l->speccode));
    }
    ui_efs();
    ui_esfs();
}