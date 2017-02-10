<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','files');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0)
{
    ui_redirect('create.php');
}

if(!empty($_POST))
{
    if(isset($_FILES['data']))
    {
        $name=$_FILES['data']['name'];
        $tmpn=$_FILES['data']['tmp_name'];
        $fize=$_FILES['data']['size'];
        $uid=cr_userid();
        $blob=addslashes(fread(fopen($tmpn,'r'), filesize($tmpn)));
        $sql="INSERT INTO `db_files` (`name`,`cuid`,`ctime`,`size` ,`block`)
                            VALUES   ('$name','$uid',NOW(), '$fize' ,'$blob')";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        ui_redirect('files.php');
    }
}

if($id)
{
    $l=db_single_record('db_files', 'id_files', "$id");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: inline; filename=\"${l['name']}\"");
    echo $l['block'];
    exit();
}
ui_sp('Файлы');
ui_sfs('','w100');
ui_rep_row();
ui_rep_th('Имя файла','','','w100');
ui_rep_th('Размер');
ui_rep_th('Дата');
ui_rep_th('Автор');
ui_end_row();
$sql="SELECT * FROM `db_files`";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_td_l("<a href=\"?id=$l->id_files\">$l->name</a>");
    ui_rep_td_r($l->size);
    ui_rep_td_l($l->ctime,'nw');
    ui_rep_td_l($l->cuid);
    ui_end_row();
}
ui_efs();

ui_hr();
ui_sfmp();
ui_sfs('','w100');
ui_hidden('reg', 'tag', '');
ui_file('', 'data', 'Файл');
ui_efs();
ui_sc('Загрузить');
ui_ef0();
ui_ep();