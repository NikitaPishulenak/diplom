<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'view/person.php';

define('PAGE_SEC', 'person.view');
cr_logic();



$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');
if ($id <= 0) {
    ui_redirect('noaccess.php');
}
if(!empty($_POST))
{
    $reg=$_POST['reg'];
        set_time_limit(0);
        $reg = $_POST['reg'];
        $reg['owner_id'] = cr_userid();
        $uid=cr_userid();
        $res = db_field_values($reg);
        $sql = "INSERT INTO `db_chain` (${res[0]}) VALUES (${res[1]})";
        $r = mysql_query($sql) or debug($sql, mysql_error());
        $nid = mysql_insert_id();
        $sql="INSERT INTO `db_chid` (`owner_id`,`chain_id`,`person_id`) VALUES ('$uid','$nid','$id')";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        ui_redirect("viewchains.php?id=$id");
}

$p = db_single_record('db_person', 'id', $id);


ui_sp('Дело ' . $p['delo_name'], false);
$opt = array();
$opt['tf'] = db_kv('db_time_form', 'id_time_form', 'abbr');
$opt['ef'] = db_kv('db_ef', 'id_ef', 'abbr');
$opt['t_'] = db_kv('db_target', 'id_target', 'abbr');
$opt['tt'] = db_kv('db_targettype', 'id_targettype', 'abbr');
$opt['rc'] = db_kv('db_region', 'id_region', 'abbr');
$opt['tc'] = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p, $opt);
ui_stfs();
ui_view_links($id);
ui_etfs();
ui_stfs();
ui_sticker_view($id);
ui_etfs();

$uid=cr_userid();

ui_stfs();
ui_sfs('Удалить дело из цепочки','w100');
$sql="SELECT * from db_chain where id_chain in (SELECT `chain_id` FROM db_chid where `person_id`=$id AND `owner_id`=$uid)";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    ui_trlink('', $l->name, "api.php?m=chain.item.del&i=$l->id_chain&j=$id");
}
ui_efs();
ui_sptfs3();
ui_sfs('Добавить дело в цепочку','w100');
$sql="SELECT * from db_chain where id_chain not in (SELECT `chain_id` FROM db_chid where `person_id`=$id AND `owner_id`=$uid)";
$r=mysql_query($sql) or debug($sql,  mysql_error());
while($l=  mysql_fetch_object($r))
{
    ui_trlink('', $l->name, "api.php?m=chain.item.add&i=$l->id_chain&j=$id");
}
ui_efs();
ui_sptfs3();
ui_sf();
ui_sfs('Создать цепочку из этого дела','w100');
ui_text('reg', 'name', 'Имя новой цепочки', '', '');
ui_submit('', '', '', 'Создать', '');
ui_ef0();
ui_efs();
ui_etfs();


ui_ep();