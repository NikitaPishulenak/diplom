<?php

function form_draw($p,$t)
{
    ui_sfmp();
    ui_stfs();
    //ui_text('reg', 'name', '��������', $p['name'], 60);
    //ui_text('reg', 'sname', '��������', $p['sname'], 60);
    //ui_text('reg', 'abbr', '������������', $p['abbr'], 60);
    if($t=='create')
    {
        ui_file('reg', 'data', 'CSV');
    }
    else if($t=='edit')
    {
        ui_text('reg', 'surname', '�������', $p['surname'], 60);
    }
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_voenmed` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "voenmeds.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_voenmed, $l->surname, "voenmeds.php", array("id=$l->id_voenmed"),array($l->name,$l->midname));
    }
    ui_efs();
    ui_esfs();
}