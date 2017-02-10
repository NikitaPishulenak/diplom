<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.php';
define('PAGE_SEC','person.defaults');
cr_logic();

if(!empty($_POST))
{
    $reg=$_POST['reg'];
    unset($reg['cuid']);
    unset($reg['muid']);
    $df='$(document).ready(function(){';
    foreach($reg as $k=>$v)
    {
        $df.="\r\n\$('#$k').val('$v');";
    }
    $df.='});';
    file_put_contents('defaults/person.js', $df);
    ui_redirect("defaults.php");
}

$p=db_empty_record('db_person');
$p['cuid']=cr_userid();
$p['muid']=cr_userid();
$p['xuid']=0;
ui_sp();
form_draw($p, 'create');
ui_script('defaults/person.js');
ui_ep();