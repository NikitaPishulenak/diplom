<?php
error_reporting(E_ALL);
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
if(!isset($_SESSION['dbname']))
{
    define('DB_NAME','admx');
    $_SESSION['dbname']='admx';
}
else
{
    define('DB_NAME',$_SESSION['dbname']);
}
define('DB_PAGE','cp1251');
