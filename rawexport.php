<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/options.php';
include 'form/person.column.php';

define('PAGE_SEC','person.export');
cr_logic();

header("Content-type: application/csv");
header("Content-Disposition: inline; filename=rawlist.csv");


$fields=(isset($_GET['fields']))?$_GET['fields']:'*';
$fields=(empty($fields))?'*':$fields;

$macro=db_kv('db_field_macro', 'abbr', 'sname');
if($fields=='*')
{
    $columns='*';
}
else
{
$h=explode('|', $fields);
$c=array();

foreach ($h as $v)
{
    
    $x="`$v`";
    $x=(isset($macro[$v]))?$macro[$v]:$x;
    $c[]=$x;
}
$columns=join(',',$c);
}


$where =cr_tempwhere('id');
$where=trim($where);
if(empty($where))
{
    ui_redirect('noaccess.php');
}
$cols=array();
$sql="SELECT $columns FROM `db_person` WHERE ( $where )";
$r=mysql_query($sql) or debug($sql,mysql_error());
$i=0;
while($l=  mysql_fetch_field($r))
{
    
     $cols[$i++]=$l->name;
}
print join(";",array_map('kvch',$cols))."\r\n";
$i=0;
while($l=  mysql_fetch_assoc($r))
{
    
    
    print join(";",array_map('kvch',$l))."\r\n";
    
}


function kvch($x)
{
    $x=str_replace('"', '""', $x);
    return "\"$x\"";
}