<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC','control.acls');
cr_logic();


$id=(isset($_GET['id']))?(int)$_GET['id']:0;
if($id<1) ui_redirect ('noaccess.php');

if(!empty($_POST))
{
    $keys=isset($_POST['key'])?$_POST['key']:array();
    $sql="UPDATE db_acl SET `value`=0 WHERE `group_id`='$id'";
    $r=mysql_query($sql) or debug($sql,  mysql_error() );
    foreach($keys as $k=>$v)
    {
        $sql="INSERT INTO `db_acl` (`key_id`,`group_id`,`value`) VALUES ('$k','$id','1') ON DUPLICATE KEY UPDATE `value`='1'";
        $r=mysql_query($sql) or debug($sql,  mysql_error() );
    }
    ui_redirect("acls.php?id=$id");
}


$p=db_single_record('db_groups', 'id_group', "$id");
ui_sp('Политики группы '.$p['groupname']);

$gr=db_kv('db_groups', 'id_group', 'groupname');

ui_gf();
ui_stfs();
ui_sfs();
ui_select('','id', 'Группа',$gr , $id);
ui_submit('', '', '', 'Выбрать', '');
ui_efs();
ui_etfs();
ui_ef0();

ui_sf();
ui_stfs();
ui_sfs();

#$sql="SELECT * FROM `db_keys` left JOIN  `db_acl` ON (key_id=id_keys) WHERE (group_id='$id' or isnull(group_id))";
$sql="SELECT *,(SELECT value from db_acl where (key_id=id_keys AND group_id='$id')) value  FROM `db_keys`";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=mysql_fetch_object($r))
{
    $ch=ui_chain_check('key',$l->id_keys,'',$l->value);
    ui_rowlink($l->id_keys, $l->keyname, '#',array("id=$l->id_keys"),array($ch,$l->keystring));
}
ui_efs();
ui_etfs();
ui_sfs();
ui_submit('reg', 'save', '', 'Save', '');
ui_efs();


ui_ef0();
ui_ep();