<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/republics.php';

define('PAGE_SEC','control.republics');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

if(!empty($_POST))
{
    if($id>0)
    {
        $reg= $_POST['reg'];
        $ret= db_update_values($reg);
        $sql="UPDATE `db_republic` SET $ret WHERE `id_republic`='$id' LIMIT 1 ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
    }
    else
    {
//        $reg= $_POST['reg'];
//        $ret=db_field_values($reg);
//        $sql="INSERT INTO `db_republic` (${ret[0]}) values (${ret[1]}) ";
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
		$subject = db_esc($columns[3]);
		$rank = db_esc($columns[4]);

                $sql = "INSERT INTO `db_republic`
                (`surname`,`name`,`midname`,`subject`,`rank`)
                values
                ('$surname','$name','$midname','$subject','$rank');
                ";
                $r = mysql_query($sql) or debug($sql, mysql_error());
            }
        }
    }
    ui_redirect("republics.php?id=$id");
    
}



ui_sp("Победители республиканской олимпиады");
list_draw();
if($id)
{
    $p=db_single_record('db_republic', 'id_republic', "$id");
    form_draw($p,'edit');
}
else
{
    $p=db_empty_record('db_republic');
    ui_par('ФОРМАТ: /* ФАМИЛИЯ / ИМЯ / ОТЧЕСТВО */');
    form_draw($p, 'create');
}
ui_ep();