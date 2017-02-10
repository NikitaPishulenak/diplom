<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', 'Название', $p['name'], 60);
    ui_text('reg', 'sname', 'Название', $p['sname'], 60);
    ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_natio` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "natios.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_natio, $l->name, "natios.php", array("id=$l->id_natio"),array($l->sname,$l->abbr));
    }
    ui_efs();
    ui_esfs();
}