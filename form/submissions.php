<?php

function form_draw($p,$t)
{
    $user_id=db_kv('db_users','id','realname');
    ui_sf();
    ui_stfs();
    ui_text('reg', 'name', '��������', $p['name'], 60);
    //ui_text('reg', 'sname', '��������', $p['sname'], 60);
    //ui_text('reg', 'abbr', '������������', $p['abbr'], 60);
    ui_select('reg', 'parent_id', '���������', $user_id, $p['parent_id']);
    ui_select('reg', 'child_id', '����������', $user_id, $p['child_id']);
    ui_submit('what', 'create', '���������', '���������','');
    ui_etfs();
    ui_ef0();
}

function list_draw()
{
    $sql="SELECT * FROM `db_submission` ";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    ui_ssfs();
    ui_sfs();
    ui_rowlink(0, '�������', "submissions.php", array("id=0"));
    while($l=  mysql_fetch_object($r))
    {
        ui_rowlink($l->id_submission, $l->name, "submissions.php", array("id=$l->id_submission"),array($l->sname,$l->abbr));
    }
    ui_efs();
    ui_esfs();
}