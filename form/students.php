<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', '��������', $p['name'], 60);
    ui_text('reg', 'sname', '��������', $p['sname'], 60);
    ui_text('reg', 'abbr', '������������', $p['abbr'], 60);
    ui_text('reg', 'style', '����', $p['style'], 60);
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_student` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "students.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_student, $l->name, "students.php", array("id=$l->id_student"),array($l->sname,$l->abbr,$l->style));
    }
    ui_efs();
    ui_esfs();
}