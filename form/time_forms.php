<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', '��������', $p['name'], 60);
    ui_text('reg', 'sname', '��������', $p['sname'], 60);
    ui_text('reg', 'abbr', '������������', $p['abbr'], 60);
    ui_text('reg', 'abbrdelo', '����/����', $p['abbrdelo'], 60);
    ui_text('reg', 'order_extract', '�������', $p['order_extract'], 100);
    ui_text('reg', 'notification', '���������', $p['notification'], 100);
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_time_form` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "time_forms.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_time_form, $l->name, "time_forms.php", array("id=$l->id_time_form"),array($l->sname,$l->abbr,$l->order_extract));
    }
    ui_efs();
    ui_esfs();
}