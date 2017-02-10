<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.php';

define('PAGE_SEC','api');
cr_logic();

$m=(isset($_GET['m']))?$_GET['m']:'';

$ref=(isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';

$id=(isset($_GET['i']))?$_GET['i']:0;
$id2=(isset($_GET['j']))?$_GET['j']:0;



switch ($m)
{
    case 'real.add':
        
        break;
    case 'real.del':
        
        break;
    case 'real.cls':
        cr_chainclear();
        break;
    case 'real.rep':
        cr_popchain();
        break;
    case 'temp.add':
        cr_temppush($i);
        break;
    case 'temp.del':
        
        break;
    case 'temp.cls':
        cr_tempclear();
        break;
    case 'tacl.cls':
        break;
    case 'tacl.del':
        $sql="DELETE FROM `db_target_allowable` WHERE `id_target_allowable`='$id'";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        break;
    case 'facl.cls':
        break;
    case 'facl.del':
        $sql="DELETE FROM `db_target_formable` WHERE `id_target_formable`='$id'";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        break;
    case 'iracl.del':
        $sql="DELETE FROM `db_ir_relation` WHERE `id_ir_relation`='$id'";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        break;
    case 'status':
        $c=cr_status();
        if(!$c)
        {
            cr_set_status (1);
            $uid = cr_userid();
            $qid = cr_ukey('queue_id');
            $sql="INSERT INTO `db_queue_list` (`queue_id`,`user_id`) VALUES ('$qid','$uid')";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
            $lid=mysql_insert_id();
            $_SESSION['ukey']['qlid']=$lid;
        }
        else
        {
            cr_set_status (($c==1)?2:1);
            $lid= cr_ukey('qlid');
            $sql="UPDATE `db_queue_list` SET `closed`=1 WHERE `id_queue_list`='$lid' LIMIT 1";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
        }
        break;
    case 'rem.tag':
        $sql="DELETE FROM `db_tag_relation` where `id_tag_relation`='$id'";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        break;
    case 'chain.item.add':
        $uid=cr_userid();
        $id=db_esc($id);
        $id2=db_esc($id2);
        $sql="INSERT INTO `db_chid` (`owner_id`,`chain_id`,`person_id`) VALUES ('$uid','$id','$id2')";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        break;
    case 'chain.item.del':
        $uid=cr_userid();
        $id=db_esc($id);
        $id2=db_esc($id2);
        $sql="UPDATE `db_chid` SET `chain_id`=0 WHERE `chain_id`='$id' AND `person_id`='$id2' LIMIT 1";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        break;
    default:
        ui_redirect('noaccess.php');
}

ui_redirect_ref($ref);