<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/stalkers.php';

define('PAGE_SEC','control.stalkers');
cr_logic();
set_time_limit(0);
$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');

if(!empty($_POST))
{
    /*
    if($id>0)
    {
        $reg= $_POST['reg'];
        $ret= db_update_values($reg);
        $sql="UPDATE `db_stalker` SET $ret WHERE `id_stalker`='$id' LIMIT 1 ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
    }
    else
    {
        $reg= $_POST['reg'];
        $ret=db_field_values($reg);
        $sql="INSERT INTO `db_stalker` (${ret[0]}) values (${ret[1]}) ";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $id = mysql_insert_id();
    }
*/
    //var_dump($_FILES);
    if(isset($_FILES['reg']['tmp_name']['data']))
    {
        $t=$_FILES['reg']['tmp_name']['data'];
        //die($t);
        $c=file_get_contents($t);
        $data=explode("\n",$c);
        
        foreach($data as $line)
        {
            if(!strlen(trim($line))) continue;
            $columns=explode(',', $line);
            $region = db_esc($columns[0]);
            $area   = db_esc($columns[1]);
            $ssname = db_esc($columns[2]);
            $town   = db_esc($columns[3]);
            $sql="INSERT INTO `db_stalker`
                (`region_by`,`area`,`ssname`,`town`)
                values
                ('$region','$area','$ssname','$town');
                ";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
            
        }
    
    }
    ui_redirect("stalkers.php?id=$id");
    
}



ui_sp("◊¿›—");
list_draw();
if($id)
{
    $p=db_single_record('db_stalker', 'id_stalker', "$id");
    form_draw($p,'edit');
}
else
{
    ui_par('‘Œ–Ã¿“: /* Œ¡À¿—“‹(˜ËÒÎ) / –¿…ŒÕ / —≈À‹—Œ¬≈“ / œ”Õ “ */');
    $p=db_empty_record('db_stalker');
    form_draw($p, 'create');
}
ui_ep();