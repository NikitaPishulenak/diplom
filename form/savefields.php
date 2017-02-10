<?php

function form_draw($p,$t)
{
    include 'form/options.php';
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', 'Название', $p['name'], 60);
    ui_text('reg', 'sname', 'Поля', $p['fields'], 60);
//    ui_text('reg', 'abbr', 'Аббревиатура', $p[''], 60);
    ui_select('reg', 'user_id', 'ПОльзователь', $options['users_by_name'], $p['user_id']);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_savefield` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "savefields.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_savefield, $l->name, "savefields.php", array("id=$l->id_savefield"),array($l->fields));
    }
    ui_efs();
    ui_esfs();
}