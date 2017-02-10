<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/presidents.php';

define('PAGE_SEC','control.presidents');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

if(!empty($_POST))
{
    if($id>0)
    {
        $reg= $_POST['reg'];
        $ret= db_update_values($reg);
        $sql="UPDATE `db_president` SET $ret WHERE `id_president`='$id' LIMIT 1 ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
    }
    else
    {
//        $reg= $_POST['reg'];
//        $ret=db_field_values($reg);
//        $sql="INSERT INTO `db_president` (${ret[0]}) values (${ret[1]}) ";
//        $r=mysql_query($sql) or debug($sql,mysql_error());
//        $id = mysql_insert_id();
        
        if (isset($_FILES['reg']['tmp_name']['data'])) {
            $t = $_FILES['reg']['tmp_name']['data'];
            //die($t);
            $c = file_get_contents($t);
            $data = explode("\n", $c);

            foreach ($data as $line) {
                if (!strlen(trim($line)))  continue;
                $columns = explode(',', $line);
                $surname = db_esc($columns[0]);
                $name = db_esc($columns[1]);
                $midname = db_esc($columns[2]);
                $sql = "INSERT INTO `db_president`
                (`surname`,`name`,`midname`)
                values
                ('$surname','$name','$midname');
                ";
                $r = mysql_query($sql) or debug($sql, mysql_error());
            }
        }
    }
    ui_redirect("presidents.php?id=$id");
    
}



ui_sp("À‡ÛÂ‡Ú˚");
list_draw();
if($id)
{
    $p=db_single_record('db_president', 'id_president', "$id");
    form_draw($p,'edit');
}
else
{
    $p=db_empty_record('db_president');
    ui_par('‘Œ–Ã¿“: /* ‘¿Ã»À»ﬂ / »Ãﬂ / Œ“◊≈—“¬Œ */');
    form_draw($p, 'create');
}
ui_ep();