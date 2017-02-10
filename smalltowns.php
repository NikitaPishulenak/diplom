<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/smalltowns.php';

define('PAGE_SEC', 'control.smalltowns');
cr_logic();

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');

if (!empty($_POST)) {
    if ($id > 0) {
        
          $reg= $_POST['reg'];
          $ret= db_update_values($reg);
          $sql="UPDATE `db_smalltown` SET $ret WHERE `id_smalltown`='$id' LIMIT 1 ";
          $r=mysql_query($sql) or debug($sql,mysql_error());
         
        
    }
    else {
        /*
        $reg = $_POST['reg'];
        $ret = db_field_values($reg);
        $sql = "INSERT INTO `db_smalltown` (${ret[0]}) values (${ret[1]}) ";
        $r = mysql_query($sql) or debug($sql, mysql_error());
        $id = mysql_insert_id();

        */
        //var_dump($_FILES);
        //die();
        if (isset($_FILES['reg']['tmp_name']['data'])) {
            $t = $_FILES['reg']['tmp_name']['data'];
            //die($t);
            $c = file_get_contents($t);
            $data = explode("\n", $c);

            foreach ($data as $line) {
                if (!strlen(trim($line)))
                    continue;
                $columns = explode(',', $line);
                $region = db_esc($columns[0]);
                $town = db_esc($columns[1]);
                $sql = "INSERT INTO `db_smalltown`
                (`region_by`,`town`)
                values
                ('$region','$town');
                ";
                $r = mysql_query($sql) or debug($sql, mysql_error());
            }
        }
    }
    ui_redirect("smalltowns.php?id=$id");
}



ui_sp("Малые города");
list_draw();
if ($id) {
    $p = db_single_record('db_smalltown', 'id_smalltown', "$id");
    form_draw($p, 'edit');
} else {
    $p = db_empty_record('db_smalltown');
    form_draw($p, 'create');
}
ui_ep();