<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';


include 'form/person.column.php';
define('PAGE_SEC','person.export');
cr_logic();

if(!empty($_POST))
{
    $reg=$_POST['reg'];
    //$fields=explode('|', $reg['fields']);
    if(isset($reg['save']))
    {
        $u=(isset($reg['user']))?cr_userid():'0';
        $t=$reg['title'];
        $sql="INSERT INTO `db_savefield` (`user_id`,`name`,`fields`) VALUES ('$u','$t','${reg['fields']}')";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
    }
    
    ui_redirect('export.php?fields='.$reg['fields']);
}

ui_sp('Экспорт выбранных полей');
ui_blink('Сброс', 'fields.php');
ui_hr();
ui_sf();
ui_stfs();
ui_sfs();
#ui_hidden('reg', 'fields', '');
ui_select('x', 'saved', 'Cохранённые', db_kv('db_savefield','fields','name'), 0);

//ui_text_req('reg', 'fields', 'Поля', '', '');
ui_hidden('reg', 'fields', '');
ui_text('reg', 'title', 'Название', '', '');
ui_efs();
ui_sptfs();
ui_sfs();
ui_check('reg', 'save', 'Сохранить', '');
ui_check('reg', 'user', 'Только для себя', '');
ui_efs();
ui_etfs();
ui_ef();
$i=0;
ui_hr();
ui_stfs();
ui_sfs();
print '<p id="fields_v"></p>';
ui_efs();
ui_sptfs3();
ui_stfs();
ui_sfs();
$sql="SHOW FULL COLUMNS FROM `db_person`";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r)){
    $i++;
    $c =(isset($pcolumns[$l->Field]))?$pcolumns[$l->Field]:$l->Field;
    $a="<a id=\"src_$l->Field\" href=\"javascript:fpush('$l->Field','$c')\">$c</a>";
    ui_rep_row();        
    print "<td style=\"white-space:nowrap;padding:1px;\">$a</td>";
    ui_end_row();
    if($i>25)
    {
        $i=0;
        ui_efs();
        ui_sptfsn();
        ui_sfs();
    }
}
ui_efs();
ui_etfs();
ui_sptfs3();

ui_sfs();
$sql="SELECT * from db_field_macro";
$r=mysql_query($sql) or debug($sql,mysql_error());
while($l=  mysql_fetch_object($r)){
    $i++;
    //ui_rowlink('', $l->name,"javascript:fpush('$l->abbr','$l->name')");
    $a="<a id=\"src_$l->abbr\" href=\"javascript:fpush('$l->abbr','$l->name')\">$l->name</a>";
    ui_rep_row();        
    print "<td style=\"white-space:nowrap;padding:1px;\">$a</td>";
    ui_end_row();
}
ui_efs();
ui_etfs();
ui_script('js/field.js');
ui_ep();