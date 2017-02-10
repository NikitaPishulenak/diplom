<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'groupkey', 'Ключ группы', $p['groupkey'], 60);
    ui_text('reg', 'groupname', 'Название', $p['groupname'], 60);
    
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_vlink('Политики', "acls.php?id=${p['id_group']}");
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_groups` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "groups.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_group, $l->groupname, "groups.php", array("id=$l->id_group"));
    }
    ui_efs();
    ui_esfs();
}