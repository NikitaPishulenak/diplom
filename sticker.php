<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC', 'person.stick');
cr_logic();


$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');
if ($id < 0)
    ui_redirect('noaccess.php');

if (!empty($_POST)) {
    if (isset($_GET['new'])) {
    /*    set_time_limit(0);
        $reg = $_POST['reg'];
        $reg['owner_id'] = cr_userid();
        $res = db_field_values($reg);
        $sql = "INSERT INTO `db_chain` (${res[0]}) VALUES (${res[1]})";
        $r = mysql_query($sql) or debug($sql, mysql_error());
        $nid = mysql_insert_id();
        $arr = array_keys(cr_temparr());
        $sqlv = array();
        $uid=cr_userid();
        foreach ($arr as $v) {
            $sqlv[] = "('$nid','$v','$uid')";
        }
        if (!empty($sqlv)) {
            $sql = "INSERT INTO `db_chid` (`chain_id`,`person_id`,`owner_id`) VALUES " . implode(',', $sqlv);
            $r = mysql_query($sql) or debug($sql, mysql_error());
        }
        ui_redirect("chain.php?id=$id");
        */
    } else {
	/*
        $sql = "UPDATE `db_chid` SET `chain_id`=0 WHERE `chain_id`='$id' ";
        $r = mysql_query($sql) or debug($sql, mysql_error());
        $reg = (isset($_POST['reg'])) ? $_POST['reg'] : array();
        $arr = array_keys($reg);
        $sqlv = array();
        $uid=cr_userid();
        foreach ($arr as $v) {
            $v = db_esc($v);
            $sqlv[] = "('$id','$v','$uid')";
        }
        if (!empty($sqlv)) {
            $sql = "INSERT INTO `db_chid` (`chain_id`,`person_id`,`owner_id`) VALUES " . implode(',', $sqlv);
            $r = mysql_query($sql) or debug($sql, mysql_error());
        }
        ui_redirect("chain.php?id=$id");
        */
    }
    ui_redirect("sticker.php");
}


if ($id > 0) {

    $p = db_single_record('db_tag', 'id_tag', $id);
    ui_sp('Стикер: ' . $p['name']);
    $sql = "SELECT * FROM `db_person` WHERE (`id` in (SELECT `person_id` FROM `db_tag_relation` WHERE(`tag_id`='$id')))";
    $r = mysql_query($sql) or debug($sql, mysql_error());
    $tf_ak = db_kv('db_time_form', 'id_time_form', 'abbr');
    $ef_ak = db_kv('db_ef', 'id_ef', 'abbr');
    $t__ak = db_kv('db_target', 'id_target', 'abbr');
    $tt_ak = db_kv('db_targettype', 'id_targettype', 'abbr');
    $rc_ak = db_kv('db_region', 'id_region', 'abbr');
    $colors = db_kv('db_state', 'id_state', 'color');
    $bf_set = db_bits2arr('db_benefit', 'id_benefit', 'abbr');
    ui_chain_links();
    ui_hr();
    ui_sf();
    /*
    print<<<EOF
    <a href="#" onclick="\$('input[type=checkbox]').attr('checked',true); return false;">Выделить всё</a> | 
        <a href="#" onclick="\$('input[type=checkbox]').attr('checked',false); return false;"> Снять всё</a> |
        <a href="#" onclick="\$(\$('input[type=checkbox]').splice(\$('#sel_from').val()-1,\$('#sel_to').val())).attr('checked',true); return false;">Выделить</a>
        <a href="#" onclick="\$(\$('input[type=checkbox]').splice(\$('#sel_from').val()-1,\$('#sel_to').val())).attr('checked',false); return false;">Снять</a>
        c <input type="text" id="sel_from" />
        сколько <input type="text" id="sel_to"  />
        
    <hr />    
EOF;
    */
    ui_ssfs();
    ui_sfs();
    ui_rep_row();
    ui_rep_th('#');
//    ui_rep_th('Выбор');
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
    $i = 0;
    cr_tempclear();
    while ($l = mysql_fetch_object($r)) {
        $ch = ui_chain_check('reg', $l->id, '', 1);
        $color = (isset($colors[$l->state_id])) ? $colors[$l->state_id] : '#FF0000';
        $rowclass = "style=\"background-color:$color\"";
        $ch = ui_chain_check('reg', $l->id, '', 1);
        $tf = ui_sap($tf_ak, $l->time_form_id);
        $ef = ui_sap($ef_ak, $l->edu_form);
        $t_ = ui_sap($t__ak, $l->target);
        $tt = ui_sap($tt_ak, $l->target_type);
        $t_ = ($l->target == 1) ? $t_ . '(' . ui_sap($rc_ak, $l->region_cell) . ')' : $t_;
        $bf = ui_sap($bf_set,$l->benefit_set,'');
        // ui_rowlink($l->id, "$l->surname", "view.php", array("id=$l->id"), array(), array($ch,));
        ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php", array("id=$l->id"), array($bf, $tf, $ef, $t_, $tt), array( $l->delo_name, $l->total), $rowclass);
        cr_temppush($l->id, $l->delo_name);
    }
    ui_efs();
    ui_esfs();
    //ui_sc('Выбранные - оставить');
    ui_ef0();
    ui_ep();
} else {
    if (isset($_GET['new'])) {
        ui_sp('Новая цепочка');
        ui_sf();
        ui_stfs();
        ui_sfs();
        ui_text('reg', 'name', 'Имя Цепочки', cr_rqt(), 50);
        ui_submit('', '', '', 'Сохранить', 50);
        ui_efs();
        ui_etfs();
        ui_ef0();
        ui_ep();
    } else {
        ui_sp('Стикеры');
        $uid = cr_userid();
        $sql = "SELECT *,(SELECT COUNT(`person_id`) FROM `db_tag_relation` WHERE `tag_id`=id_tag) ch_cnt FROM `db_tag` ";
        $r = mysql_query($sql) or debug($sql, mysql_error());
        ui_sf('cop.php');

        ui_sfs('', 'w100');
        ui_rep_row();
        ui_rep_th('#');
        ui_rep_th('^');

        ui_rep_th('Название');
        ui_rep_th('Кол-во');
        //ui_rep_th('Дата');

        ui_end_row();
        $i = 0;
        while ($l = mysql_fetch_object($r)) {
            $el = "<a href=\"sticker.php?id=$l->id_tag\">$l->name</a>";
            ui_rep_row();
            ui_rep_th(++$i);
            ui_rep_th('<input type="checkbox" name="reg[' . $l->id_tag . ']"/>');

            ui_rep_td_l($el,'w100');
            ui_rep_td($l->ch_cnt);
            //ui_rep_td_l($l->save_date,'nw');
            ui_end_row();
        }
        ui_efs();
        $cop_values = array('1' => 'Удалить', '2' => 'Объединение');
//        ui_stfs();
//        ui_sfs();
//        ui_select('cop', 'cop', 'Операция', $cop_values, 0);
//        ui_efs();
//        ui_etfs();
//        ui_sc('Получить');
//        ui_ef0();
        ui_ep();
    }
}