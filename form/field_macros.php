<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', 'Название', $p['name'], '');
    ui_text('reg', 'sname', 'Название', $p['sname'], '');
    ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_field_macro` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "field_macros.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_field_macro, $l->name, "field_macros.php", array("id=$l->id_field_macro"),array($l->sname,$l->abbr));
    }
    ui_efs();
    ui_esfs();
}