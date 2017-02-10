<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', 'Название', $p['name'], 60);
    ui_text('reg', 'sname', 'Название', $p['sname'], 60);
    ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    //ui_text('reg', 'idelo', 'Подано', $p['idelo'], 60);
    ui_text('reg', 'spec', 'Специальность', $p['spec'], 60);
    ui_text('reg', 'speccode', 'Код', $p['speccode'], 60);
    ui_text('reg', 'place', 'Где расположен деканат', $p['place'], 60);
    ui_text('reg', 'chief', 'Декан', $p['chief'], 60);
    ui_text('reg', 'chief_phone', 'Телефон', $p['chief_phone'], 60);
    ui_text('reg', 'order_extract', 'Выписка', $p['order_extract'], 60);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_faculty` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "facultys.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id, $l->name, "facultys.php", array("id=$l->id"),array($l->sname,$l->abbr,$l->idelo,$l->spec,$l->speccode));
    }
    ui_efs();
    ui_esfs();
}