<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();

if(isset($_SESSION['dbname']))
{
    if($_SESSION['dbname']=='admx')
        $_SESSION['dbname']='admx25';
    else
        $_SESSION['dbname']='admx';
}
else
{
    $_SESSION['dbname']='admx';
}

$ref=(isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
ui_redirect_ref($ref);