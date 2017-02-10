<?php

function form_draw($p,$t)
{
    ui_sfmp();
    ui_stfs();
//    ui_text('reg', 'name', 'Название', $p['name'], 60);
//    ui_text('reg', 'sname', 'Название', $p['sname'], 60);
//    ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    ui_file('reg', 'data', 'Данные');
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_stalker` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "stalkers.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_stalker, $l->town, "stalkers.php", array("id=$l->id_stalker"),array($l->region_by,$l->area,$l->ssname));
    }
    ui_efs();
    ui_esfs();
}