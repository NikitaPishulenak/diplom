<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'keystring', 'Ключ', $p['keystring'], 60);
    ui_text('reg', 'keyname', 'Название', $p['keyname'], 60);
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_keys` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "keys.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_keys, $l->keyname, "keys.php", array("id=$l->id_keys"),array($l->keystring));
    }
    ui_efs();
    ui_esfs();
}