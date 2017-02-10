<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'core/libtargethistory.php';
include 'core/libtargetacl.php';


define('PAGE_SEC','person.move');
cr_logic();


$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
   ui_redirect('noaccess.php');
}

$p=db_single_record('db_person', 'id', $id);
$fc=db_kv('db_faculty', 'id', 'name');
$tf=db_kv('db_time_form','id_time_form','name');
if($p['state_id']=='1')  die('А дело закрывать кто будет?');
//ui_redirect ('noaccess.php');
if(!empty($_POST))
{
    $reg=$_POST['reg'];
    $f=(isset($reg['faculty_id']))?(int)$reg['faculty_id']:0;
    $t=(isset($reg['time_form_id']))?(int)$reg['time_form_id']:0;
    if($f==0) ui_redirect ("noaccess.php");
    if($t==0) ui_redirect ("noaccess.php");
    
    
        
   // $pool=db_single_record('db_pool', 'faculty_id', $f);
    $pool=db_single_record_a('db_pool', array('faculty_id'=> $f,'time_form_id'=>$t));
        
        
        if(is_array($pool))
        {
            $pool_int=$pool['delo_id'];
            $sql="DELETE FROM `db_pool` WHERE `id_pool`='${pool['id_pool']}' LIMIT 1";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
        }
        else
        {
            //$sql="UPDATE `db_faculty` SET `idelo`=`idelo`+1 WHERE `id`='$f' LIMIT 1;";
            $sql="UPDATE `db_submitted` SET `total`=`total`+1 WHERE `faculty_id`='$f' AND `time_form_id`='$t' LIMIT 1;";
            $r=mysql_query($sql) or debug($sql,mysql_error());
            $pool_int = 0;
        }
        /*
        $sql="SELECT `abbr`,`idelo` FROM `db_faculty` WHERE `id`='$f' LIMIT 1";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $l=mysql_fetch_object($r);
        if(!$pool_int) $pool_int=$l->idelo;
        $p['delo_name']=$l->abbr.'-'.$pool_int;
        $p['delo_int']=$pool_int;
    */
        $sql="SELECT `total` FROM `db_submitted` WHERE `faculty_id`='$f' AND `time_form_id`='$t' LIMIT 1";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $l=mysql_fetch_object($r);
        if(!$pool_int) $pool_int=$l->total;
        $fk=db_single_record('db_faculty', 'id', $f);
        $tk=db_single_record('db_time_form', 'id_time_form', $t);
        $p['delo_name']="${fk['abbr']}${tk['abbrdelo']}-$pool_int";
        $p['delo_int']=$pool_int;
        
    $p['faculty']=$f;
    $p['time_form_id']=$t;
    $p['ctime']='__ctime__';
    $p['vtime']='0';
    $p['xtime']='0';
    $p['atime']='__ctime__';
    $p['cuid']=cr_userid();
    $p['auid']=cr_userid();
    $p['xuid']='0';
    $p['vuid']='0';
    $p['state_id']='1';
    $p['target_use_id']=0;
    unset($p['id']);
    $res=db_field_values($p);
    $res[1] = str_replace("'__ctime__'",' NOW() ' , $res[1]);
    $sql="INSERT INTO `db_person` (${res[0]}) VALUES ($res[1])";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    $nid=mysql_insert_id() or debug($sql,  mysql_error());
    
    /* TARGET HISTORY */
    th_create($nid, '3',$p);
    $uid=cr_userid();
    $sql="INSERT INTO `db_move_journal` (`prev_person_id`,`next_person_id`,`mover_id`) VALUES ('$id','$nid','$uid')";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_redirect("view.php?id=$nid");
}



ui_sp('Перевод Дела');
$opt=array();
$opt['tf']=db_kv('db_time_form','id_time_form','abbr');
$opt['ef']=db_kv('db_ef','id_ef','abbr');
$opt['t_']=db_kv('db_target','id_target','abbr');
$opt['tt']=db_kv('db_targettype','id_targettype','abbr');
$opt['rc']=db_kv('db_region', 'id_region', 'abbr');
$opt['tc']=db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p,$opt);
ui_sf();
ui_sfs();
ui_select('reg', 'faculty_id', 'Факультет', $fc, 0);
ui_select('reg', 'time_form_id', 'Отделение', $tf, 0);
ui_efs();        
ui_ef('Перевести');
jsTargetAcl();
ui_script('js/person.move.js');

ui_script_start();
    $def_faculty = cr_ukey('faculty');
    $def_time_form = cr_ukey('time_form');
    $plus = ($def_time_form)?"\$('#time_form_id').val($def_time_form);":'';
    print<<<EOF
            $(document).ready(function(){
            $('#faculty_id').val($def_faculty);
            $('#time_form_id').val($def_time_form);
             facultyChange();
            $plus
            });
EOF;
    ui_script_end();
ui_ep();