<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/options.php';

define('PAGE_SEC','person.validate');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('noaccess.php');
}

if(!empty ($_POST))
{
    $reg=$_POST['reg'];
    
    if(isset($reg['validate']))
    {
        $u=cr_userid();
        $sql="UPDATE `db_person` SET `vtime`=NOW(),`vuid`='$u',`auid`='$u',`state_id`='1' WHERE (`id`='$id') LIMIT 1";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        
                
    }
    
    
    ui_redirect("validate.php?id=$id");
}

$p=db_single_record('db_person', 'id', "$id");



ui_sp('Проверка дела');
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
/*
if($p['state_id']==1)
{
    
    ui_submit('reg', 'close', 'Закрыть', 'Закрыть', '');
}
if($p['state_id']==2)
{
    ui_submit('reg', 'move', 'Перевести', 'Перевод', '');
}
 
 */
if($p['state_id']==4)
{
    ui_submit('reg', 'validate', 'Проверено', 'Проверено', '');
}
ui_ef0();
ui_ep();