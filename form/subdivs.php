<?php

function form_draw($p,$t)
{
    $options=array();
    $options['city_rang']=db_kv('db_city_rang','id_city_rang','name');
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', '��������', $p['name'], 60);
    ui_text('reg', 'sname', '��������', $p['sname'], 60);
    ui_text('reg', 'abbr', '������������', $p['abbr'], 60);
    ui_text('reg', 'envelop_abbr', '���� �������', $p['envelop_abbr'], 10);
    ui_select('reg', 'city_rang_id', '���� ��', $options['city_rang'], $p['city_rang_id']);
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_subdiv` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "subdivs.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_subdiv, $l->name, "subdivs.php", array("id=$l->id_subdiv"),array($l->sname,$l->abbr));
    }
    ui_efs();
    ui_esfs();
}