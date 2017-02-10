<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','person.transmit');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('create.php');
}

if(!empty($_POST))
{
    if(isset($_POST['reg']))
    {
        $uid=cr_userid();
        $p=db_single_record('db_person', 'id', $id);
        foreach($_POST['reg'] as $k=>$v)
        {
            $ki=(int)$k;
            $sql="INSERT INTO `db_pipeline` (`sender_id`,`acceptor_id`,`person_id`,`delo_name`)
                VALUES ('$uid','$ki','$id','${p['delo_name']}')";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
        }
    }
    ui_redirect('transmit.php?id='.$id);
}


$p=db_single_record('db_person','id',$id);

ui_sp('Передать дело пользователю');
$opt=array();
$opt['tf']=db_kv('db_time_form','id_time_form','abbr');
$opt['ef']=db_kv('db_ef','id_ef','abbr');
$opt['t_']=db_kv('db_target','id_target','abbr');
$opt['tt']=db_kv('db_targettype','id_targettype','abbr');
$opt['rc']=db_kv('db_region', 'id_region', 'abbr');
$opt['tc']=db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm']=db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p,$opt);
ui_stfs();
ui_view_links($id);
ui_etfs();
$uid=cr_userid();
$user_id=db_kv('db_users', 'id', 'realname');
$sql="SELECT * FROM `db_submission` WHERE `parent_id`='$uid'";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sf();
ui_stfs();
ui_sfs();
ui_efs();
ui_sptfs3();
ui_sfs();
while($l=mysql_fetch_object($r))
{
    
    ui_check('reg', $l->child_id, $user_id[$l->child_id], '');
}

ui_efs();
ui_sptfs3();
ui_sfs();
ui_efs();
ui_etfs();
ui_ef();

ui_ep();