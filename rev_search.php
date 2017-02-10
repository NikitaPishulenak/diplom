<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.search.php';


define('PAGE_SEC', 'person.search');
cr_logic();

$r=null;

$request_title='Поиск по делам: ';


if (!empty($_POST)) {
    require 'form/options.php';
    $reg=$_POST['reg'];
    $x=preg_split('/[\r\n\s,]+/', $reg['numa'],-1,PREG_SPLIT_NO_EMPTY);
    $y=array_map('db_esc', $x);
    $w=implode("','",$y);
    $request_title.=implode(', ', $y);
    $sql="SELECT * FROM `db_person` WHERE (`delo_name` in ('$w'))";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    
    
}

ui_sp('Поиск по делам');

if(!$r)
{
    ui_sf();
    ui_sfs('','w100');
    //ui_text('neg','ncount','Количество','','');
    ui_ta('reg','numa','Номера дел','','');
    ui_efs();
    ui_ef();
    ui_script('js/codemirror.js');
    
    ui_script_start();
    /** @todo js count fix needed **/
print<<<EOF
    $(document).ready(function(){
        /*$('#numa').bind('input propertychange focus', function() {
            var t=$('#numa').val();
            $('#ncount').val(t.split(/[\\r\\n\\s,]+/).length);
            });*/
        var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('numa'),{lineNumbers:true});    
        });
   
EOF;
    ui_script_end();
}
else
{
    cr_set_sql($sql);
    cr_set_rqt($request_title);
    //print "$sql<br />";
    ui_par($request_title);
    //ui_par($sql);
    cr_tempclear();
    ui_hr();
    ui_chain_links();
    ui_hr();
    ui_ssfs();
    ui_sfs('', 'w100');
    $i = 0;
    $e_temp = (cr_check('person.edit')) ? 'edit.php' : '';
    $c_temp = (cr_check('person.close')) ? 'close.php' : '';
    $tf_ak = db_kv('db_time_form', 'id_time_form', 'abbr');
    $ef_ak = db_kv('db_ef', 'id_ef', 'abbr');
    $t__ak = db_kv('db_target', 'id_target', 'abbr');
    $tt_ak = db_kv('db_targettype', 'id_targettype', 'abbr');
    $rc_ak = db_kv('db_region', 'id_region', 'abbr');
    $colors = db_kv('db_state', 'id_state', 'color');
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
    while ($l = mysql_fetch_object($r)) {

        $color = (isset($colors[$l->state_id])) ? $colors[$l->state_id] : '#FF0000';
        $rowclass = "style=\"background-color:$color\"";
        $ch = ui_chain_check('reg', $l->id, '', 1);
        $tf = ui_sap($tf_ak, $l->time_form_id);
        $ef = ui_sap($ef_ak, $l->edu_form);
        $t_ = ui_sap($t__ak, $l->target);
        $tt = ui_sap($tt_ak, $l->target_type);
        $t_ = ($l->target == 1) ? $t_ . '(' . ui_sap($rc_ak, $l->region_cell) . ')' : $t_;
        $bf = ui_sap($options['benefit_set'],$l->benefit_set,'');
        $e_link = (!empty($e_temp)) ? "<a href=\"$e_temp?id=$l->id\">e</a>" : '';
        $c_link = (!empty($c_temp)) ? "<a href=\"$c_temp?id=$l->id\">c</a>" : '';
        ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php", array("id=$l->id"), array($bf,$tf, $ef, $t_, $tt, $e_link, $c_link), array($l->delo_name, $l->total), $rowclass);


        cr_temppush($l->id, $l->delo_name);
    }
    ui_efs();
    ui_esfs();
}

ui_ep();
