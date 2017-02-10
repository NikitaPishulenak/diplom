<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/users.php';

define('PAGE_SEC','control.vcard');
cr_logic();

$sql='SELECT * FROM `db_users`';
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    $fn=iconv('cp1251', 'utf-8', $l->realname);
    
    print<<<EOF
BEGIN:VCARD
VERSION:3.0
FN: PK-$fn
N: $fn
ORG: PK-STAFF
TEL:$l->phones
END:VCARD

EOF;

}