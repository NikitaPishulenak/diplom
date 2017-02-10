<?php

function form_draw($p,$t)
{
    $region_by = db_kv('db_region', 'id_region', 'name');
    ui_sfmp();
    ui_stfs();
    if($t=='edit')
    {
    ui_text('reg', 'town', 'Название', $p['town'], 60);
    //ui_text('reg', 'sname', 'Название', $p['sname'], 60);
    //ui_text('reg', 'abbr', 'Аббревиатура', $p['abbr'], 60);
    ui_select('reg', 'region_by', 'Область', $region_by, $p['region_by']);
    }
    if($t=='create')
    {
        ui_file('reg', 'data', 'Данные');
    }
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $region_by = db_kv('db_region', 'id_region', 'name');
    $sql="SELECT * FROM `db_smalltown` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "smalltowns.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_smalltown, $l->town, "smalltowns.php", array("id=$l->id_smalltown"),array($region_by[$l->region_by]));
    }
    ui_efs();
    ui_esfs();
}