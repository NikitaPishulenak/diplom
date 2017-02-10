<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','person.qs');
cr_logic();


//setlocale(LC_ALL, 'Russian_Russia.1251');
//echo setlocale(LC_ALL,'ru_RU.CP1251','CP1251','ru_RU.cp1251','rus_RUS.CP1251','Russian_Russian.1251');

ui_sp('Быстрый поиск');
$q=(isset($_GET['q']))?trim($_GET['q']):'';
if(empty($q))
{
    ui_cm ('there is no cow level yet =(');
    $sql="";
}
$subject=ui_en2ru($q);
$subjecten = ui_ru2en($q);
$subject=strtoupper($subject);



//ui_par($q);
if(preg_match('/^[A-ZА-Я]{1,4}\-[0-9]{1,4}$/i', $subjecten))
{
    $subject=db_esc($subject);
    $sql="SELECT * FROM `db_person` Where `delo_name`='$subject'";
    ui_cm('Номер дела');
}

if(preg_match('/^[A-ZА-Я\[\]\;\'\,\.\\\]+$/i', $subjecten))
{
    $subject=db_esc($subject);
    $sql="SELECT * FROM `db_person` Where `surname`='$subject'";
    ui_cm('Фамилия');
}
if(preg_match('/^[0-9]{1,3}$/', $subjecten))
{
    $subject=db_esc($subject);
    $sql="SELECT * FROM `db_person` Where `total`='$subject'";
    ui_cm('Сумма баллов');
}
if(empty($sql))
{
    ui_ep();
    exit();
}

$r=mysql_query($sql) or debug($sql,  mysql_error());
/*while($l= mysql_fetch_object($r))
{
    ui_par($l->surname);
}
 * *
 */
ui_ssfs();
        ui_sfs('','w100');
        $i=0;
        $e_temp=(cr_check('person.edit'))?'edit.php':'';
        $c_temp=(cr_check('person.close'))?'close.php':'';
        $tf_ak=db_kv('db_time_form', 'id_time_form', 'abbr');
        $ef_ak=db_kv('db_ef','id_ef','abbr');
        $t__ak=db_kv('db_target','id_target','abbr');
        $tt_ak=db_kv('db_targettype','id_targettype','abbr');
        $rc_ak=db_kv('db_region','id_region','abbr');
        $colors=db_kv('db_state','id_state','color');
        $bf_set = db_bits2arr('db_benefit', 'id_benefit', 'abbr');
        ui_rep_row();
        ui_rep_th('#');
        ui_rep_th('Дело');
        ui_rep_th('Балл');
        ui_rep_th('Абитуриент');
        ui_rep_th('Льготы');
        ui_rep_th('ФП');
        ui_rep_th('ФО');
        ui_rep_th('К');
        ui_rep_th('ТК');
        ui_end_row();
	while($l=mysql_fetch_object($r))
	{   
            
            $color=(isset($colors[$l->state_id]))?$colors[$l->state_id]:'#FF0000';
            $rowclass="style=\"background-color:$color\"";
            $ch=ui_chain_check('reg',$l->id,'',1);
            $tf=ui_sap($tf_ak,$l->time_form_id);
            $ef=ui_sap($ef_ak,$l->edu_form);
            $t_=ui_sap($t__ak,$l->target);
            $tt=ui_sap($tt_ak,$l->target_type);
            $t_=($l->target==1)?$t_.'('.ui_sap($rc_ak,$l->region_cell).')':$t_;
            $e_link=(!empty($e_temp))?"<a href=\"$e_temp?id=$l->id\">e</a>":'';
            $c_link=(!empty($c_temp))?"<a href=\"$c_temp?id=$l->id\">c</a>":'';
            $bf=ui_sap($bf_set,$l->benefit_set,'');
            ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php",array("id=$l->id"),array($bf,$tf,$ef,$t_,$tt,$e_link,$c_link),array($l->delo_name,$l->total),$rowclass );
            
            
            
            
	}
        ui_efs();
        ui_esfs();

ui_ep();