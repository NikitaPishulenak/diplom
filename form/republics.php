<?php

function form_draw($p,$t)
{
    ui_sfmp();
    ui_stfs();
    if($t=='edit')
    {
    ui_text('reg', 'surname', 'Фамилия', $p['surname'], 60);
    ui_text('reg', 'name', 'Имя', $p['name'], 60);
    ui_text('reg', 'midname', 'Отчество', $p['midname'], 60);
    }
    else
    {
        ui_file('reg', 'data', 'CSV');
    }
    ui_submit('what', 'create', 'Сохранить', 'Сохранить','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_republic` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, 'Создать', "republics.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_republic, $l->surname, "republics.php", array("id=$l->id_republic"),array($l->name,$l->midname));
    }
    ui_efs();
    ui_esfs();
}