<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', 'Название', $p['name'], 60);
    ui_text('reg', 'sname', 'Название', $p['sname'], 60);
    ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    ui_text('reg', 'color', 'Цвет', $p['color'], 60);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_state` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "states.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        $rowclass="style=\"background-color:$l->color\"";
        ui_rowlink($l->id_state, $l->name, "states.php", array("id=$l->id_state"),array($l->sname,$l->abbr,$l->color),array(),$rowclass);
    }
    ui_efs();
    ui_esfs();
}