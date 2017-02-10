<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.php';

define('PAGE_SEC', 'temp_chain.view');
cr_logic();

if (!empty($_POST)) {

    $reg = (isset($_POST['reg'])) ? $_POST['reg'] : array();

    cr_tempclear();

    foreach ($reg as $k => $v) {
        cr_temppush($k);
    }
    $w = cr_tempwhere('id');
    $obf=cr_order_in('id');
    $sql = "SELECT `id`,`delo_name` FROM `db_person` WHERE ($w) $obf";
    $r = mysql_query($sql) or debug($sql, mysql_error());

    cr_tempclear();
    while ($l = mysql_fetch_object($r)) {
        cr_temppush($l->id, $l->delo_name);
    }

    #cr_popchain();
    ui_redirect('temp_chain.php');
}
$tf_ak = db_kv('db_time_form', 'id_time_form', 'abbr');
$ef_ak = db_kv('db_ef', 'id_ef', 'abbr');
$t__ak = db_kv('db_target', 'id_target', 'abbr');
$tt_ak = db_kv('db_targettype', 'id_targettype', 'abbr');
$rc_ak = db_kv('db_region', 'id_region', 'abbr');
$colors = db_kv('db_state', 'id_state', 'color');
$bf_set = db_bits2arr('db_benefit', 'id_benefit', 'abbr');
ui_sp('Временная Цепочка');
$obf=cr_order_in('id');
$f = cr_tempwhere('id');
$f = (empty($f)) ? '0' : $f;
$obf = (empty($f)) ? '' : $obf;
$sql = "SELECT * FROM `db_person` WHERE ($f) $obf";
$r = mysql_query($sql) or debug($sql, mysql_error());
//print $sql;
ui_chain_links();
ui_hr();
ui_par('Внимание: На этом этапе уже нельзя сохранить запрос!');
ui_hr();
ui_sf();
print<<<EOF
    <a href="#" onclick="\$('input[type=checkbox]').attr('checked',true); return false;">Выделить всё</a> | 
        <a href="#" onclick="\$('input[type=checkbox]').attr('checked',false); return false;"> Снять всё</a> |
        <a href="#" onclick="\$(\$('input[type=checkbox]').splice(\$('#sel_from').val()-1,\$('#sel_to').val())).attr('checked',true); return false;">Выделить</a>
        <a href="#" onclick="\$(\$('input[type=checkbox]').splice(\$('#sel_from').val()-1,\$('#sel_to').val())).attr('checked',false); return false;">Снять</a>
        c <input type="text" id="sel_from" />
        сколько <input type="text" id="sel_to"  />
        
    <hr />    
EOF;
ui_ssfs();
ui_sfs();
ui_rep_row();
        ui_rep_th('#');
        ui_rep_th('Выбор');
        ui_rep_th('Дело');
        ui_rep_th('Балл');
        ui_rep_th('Абитуриент');
        ui_rep_th('Льготы');
        ui_rep_th('ФП');
        ui_rep_th('ФО');
        ui_rep_th('К');
        ui_rep_th('ТК');
        ui_end_row();
ui_hidden('fix', 'me', 'tender');
$i=0;
while ($l = mysql_fetch_object($r)) {
    $ch = ui_chain_check('reg', $l->id, '', 1);
    $color=(isset($colors[$l->state_id]))?$colors[$l->state_id]:'#FF0000';
    $rowclass="style=\"background-color:$color\"";
    $ch=ui_chain_check('reg',$l->id,'',1);
    $tf=ui_sap($tf_ak,$l->time_form_id);
    $ef=ui_sap($ef_ak,$l->edu_form);
    $t_=ui_sap($t__ak,$l->target);
    $tt=ui_sap($tt_ak,$l->target_type);
    $t_=($l->target==1)?$t_.'('.ui_sap($rc_ak,$l->region_cell).')':$t_;
    $bf = ui_sap($bf_set,$l->benefit_set,'');
    // ui_rowlink($l->id, "$l->surname", "view.php", array("id=$l->id"), array(), array($ch,));
    ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php",array("id=$l->id"),array($bf,$tf,$ef,$t_,$tt),array($ch,$l->delo_name,$l->total),$rowclass );
}
ui_efs();
ui_esfs();
ui_sc('Обновить цепочку');
ui_ef0();
ui_hr();
if(cr_check('control')){
ui_par($f);
}
//ui_blink('Перенести в постоянную','api.php?m=real.rep' );
//ui_blink('Добавить в постоянную','api.php?m=real.add' );


ui_ep();