<?php

function form_draw($p,$t)
{
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', '��������', $p['name'], 60);
    ui_text('reg', 'sname', '��������', $p['sname'], 60);
    ui_text('reg', 'abbr', '������������', $p['abbr'], 60);
    ui_text('reg', 'page', '��������', $p['page'], 60);
    ui_ta('reg', 'par', '��������', $p['par'],60);
    
            
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_help` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "helps.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_help, $l->name, "helps.php", array("id=$l->id_help"),array($l->sname,$l->abbr,$l->page));
    }
    ui_efs();
    ui_esfs();
}