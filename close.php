<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'core/libtargethistory.php';

include 'form/options.php';

define('PAGE_SEC','person.close');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('noaccess.php');
}

if(!empty ($_POST))
{
//    die('Пока я не приду -  дела не закрывать');
    $reg=$_POST['reg'];
    
    if(isset($reg['close']))
    {
        $u=cr_userid();
        $sql="UPDATE `db_person` SET `xtime`=NOW(),`xuid`='$u',`auid`='$u',`state_id`='2' WHERE (`id`='$id') LIMIT 1";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        
        /* TARGET HISTORY */
        th_close($id, 1);
                
    }
    if(isset ($reg['move']))
    {
        ui_redirect("move.php?id=$id");
    }
    if(isset ($reg['kanc']))
    {
        ui_redirect("kanckill.php");
    }
    ui_redirect("close.php?id=$id");
}

$p=db_single_record('db_person', 'id', "$id");

$opt['tf']=db_kv('db_time_form','id_time_form','abbr');
$opt['ef']=db_kv('db_ef','id_ef','abbr');
$opt['t_']=db_kv('db_target','id_target','abbr');
$opt['tt']=db_kv('db_targettype','id_targettype','abbr');

ui_sp('Закрытие дела');
$opt=array();
$opt['tf']=db_kv('db_time_form','id_time_form','abbr');
$opt['ef']=db_kv('db_ef','id_ef','abbr');
$opt['t_']=db_kv('db_target','id_target','abbr');
$opt['tt']=db_kv('db_targettype','id_targettype','abbr');
$opt['rc']=db_kv('db_region', 'id_region', 'abbr');
$opt['tc']=db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p,$opt);
    ui_stfs();
            ui_view_links($id);
    ui_etfs();
ui_stfs();
ui_sfs();
        ui_select_view('Состояние',$options['state_id'],$p['state_id']);
        ui_text_view('reg','surname','Фамилия',$p['surname'],50);
        ui_text_view('reg','name','Имя',$p['name'],50);
	ui_text_view('reg','midname','Отчество',$p['midname'],50);
ui_efs();
ui_sptfs();
ui_sfs();
        ui_text_view('','','Дата создания',$p['ctime']);
        ui_text_view('','','Дата валидации',$p['vtime']);
        ui_text_view('','','Дата модификации',$p['atime']);
        ui_text_view('','','Дата удаления',$p['xtime']);
ui_sfs();
ui_efs();

ui_etfs();
ui_sf();
if($p['state_id']==1)
{
    
    ui_submit('reg', 'close', 'Закрыть', 'Закрыть', '');
}
if($p['state_id']==2)
{
    if(cr_check('person.move')) ui_submit('reg', 'move', 'Перевести', 'Перевод', '');
    if(cr_check('person.close')) ui_submit('reg', 'kanc', 'Канцелярия', 'Канцелярия', '');
}
ui_ef0();
ui_ep();
