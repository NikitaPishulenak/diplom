<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.column.php';

define('PAGE_SEC', 'person.walking');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<=0)
{
    ui_redirect('noaccess.php');
}

$p=db_single_record('db_person', 'id', $id);
ui_sp('Движение');

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




$i=0;
        $e_temp=(cr_check('person.edit'))?'edit.php':'';
        $c_temp=(cr_check('person.close'))?'close.php':'';
        $tf_ak=db_kv('db_time_form', 'id_time_form', 'abbr');
        $ef_ak=db_kv('db_ef','id_ef','abbr');
        $t__ak=db_kv('db_target','id_target','abbr');
        $tt_ak=db_kv('db_targettype','id_targettype','abbr');
        $rc_ak=db_kv('db_region','id_region','abbr');
        $colors=db_kv('db_state','id_state','color');
ui_sfs();
ui_rep_row();
ui_rep_th('#');
ui_rep_th('Дело');
ui_rep_th('Балл');
ui_rep_th('Абитуриент');
ui_rep_th('Проверено');
ui_rep_th('Прекращено');
ui_rep_th('ФП');
ui_rep_th('ФО');
ui_rep_th('К');
ui_rep_th('ТК');
ui_end_row();

$sql="SELECT * FROM `db_person` WHERE `uq`='${p['uq']}'";
$r=mysql_query($sql) or debug($sql,  mysql_error());

while($l=mysql_fetch_object($r))
{
    
    
    $color = (isset($colors[$l->state_id])) ? $colors[$l->state_id] : '#FF0000';
    $rowclass = "style=\"background-color:$color\"";
    $ch = ui_chain_check('reg', $l->id, '', 1);
    $tf = ui_sap($tf_ak, $l->time_form_id);
    $ef = ui_sap($ef_ak, $l->edu_form);
    $t_ = ui_sap($t__ak, $l->target);
    $tt = ui_sap($tt_ak, $l->target_type);
    $t_ = ($l->target == 1) ? $t_ . '(' . ui_sap($rc_ak, $l->target_cell) . ')' : $t_;
    $e_link = (!empty($e_temp)) ? "<a href=\"$e_temp?id=$l->id\">e</a>" : '';
    $c_link = (!empty($c_temp)) ? "<a href=\"$c_temp?id=$l->id\">c</a>" : '';
    ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php", array("id=$l->id"), array($l->vtime,$l->xtime,$tf, $ef, $t_, $tt), array($l->delo_name, $l->total), $rowclass);
     
     
}
ui_efs();
ui_ep();