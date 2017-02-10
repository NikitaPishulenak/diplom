<?php

function form_draw($p,$t)
{
    $users=db_kv('db_users','id','realname');
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', 'Название', $p['name'], 60);
    ui_text('reg', 'sname', 'Название', $p['sname'], 60);
    ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    ui_text('reg', 'query', 'Запрос', $p['query'], '');
    ui_select('reg', 'owner_id', 'Владелец', $users, $p['owner_id']);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_query` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "querys.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_query, $l->name, "querys.php", array("id=$l->id_query"),array($l->sname,$l->abbr));
    }
    ui_efs();
    ui_esfs();
}