<?php

function form_draw($p,$t)
{
    $options['users_by_name']=db_kv('db_users', 'id', 'realname');
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', 'Название', $p['name'], 60);
    ui_text('reg', 'sname', 'Название', $p['sname'], 60);
    ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    ui_text('reg', 'abbr', 'Срез', $p['dt'], 60);
    ui_select('reg', 'owner_id', 'Владелец', $options['users_by_name'], $p['owner_id']);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_cut` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "cuts.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_cut, $l->name, "cuts.php", array("id=$l->id_cut"),array($l->sname,$l->abbr));
    }
    ui_efs();
    ui_esfs();
}