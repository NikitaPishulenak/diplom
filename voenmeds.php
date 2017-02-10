<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/voenmeds.php';

define('PAGE_SEC', 'control.voenmeds');
cr_logic();

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');

if (!empty($_POST)) {
    if ($id > 0) {
        $reg = $_POST['reg'];
        $ret = db_update_values($reg);
        $sql = "UPDATE `db_voenmed` SET $ret WHERE `id_voenmed`='$id' LIMIT 1 ";
        $r = mysql_query($sql) or debug($sql, mysql_error());
    } else {
        /*
          $reg= $_POST['reg'];
          $ret=db_field_values($reg);
          $sql="INSERT INTO `db_voenmed` (${ret[0]}) values (${ret[1]}) ";
          $r=mysql_query($sql) or debug($sql,mysql_error());
          $id = mysql_insert_id();
         */
        if (isset($_FILES['reg']['tmp_name']['data'])) {
            $t = $_FILES['reg']['tmp_name']['data'];
            //die($t);
            $c = file_get_contents($t);
            $data = explode("\n", $c);

            foreach ($data as $line) {
                if (!strlen(trim($line)))
                    continue;
                $columns = explode(',', $line);
                $surname = db_esc($columns[0]);
                $name = db_esc($columns[1]);
                $midname = db_esc($columns[2]);
                $sql = "INSERT INTO `db_voenmed`
                (`surname`,`name`,`midname`)
                values
                ('$surname','$name','$midname');
                ";
                $r = mysql_query($sql) or debug($sql, mysql_error());
            }
        }
    }
    ui_redirect("voenmeds.php?id=$id");
}



ui_sp("Абитуриенты Военно-медицинского факультета");
list_draw();
if ($id) {
    $p = db_single_record('db_voenmed', 'id_voenmed', "$id");
    form_draw($p, 'edit');
} else {
    $p = db_empty_record('db_voenmed');
    ui_par('ФОРМАТ: /* ФАМИЛИЯ / ИМЯ / ОТЧЕСТВО */');
    form_draw($p, 'create');
}
ui_ep();