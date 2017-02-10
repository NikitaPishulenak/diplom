<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.rangesearch.php';


define('PAGE_SEC', 'person.search');
cr_logic();

$r = null;

$request_title = '';

if(!empty($_POST))
{
    $reg=$_POST['reg'];
    
    $ctime_from = db_date_where_f('ctime_from');
    $vtime_from = db_date_where_f('vtime_from');
    $atime_from = db_date_where_f('atime_from');
    $xtime_from = db_date_where_f('xtime_from');
    
    $ctime_less = db_date_where_f('ctime_less');
    $vtime_less = db_date_where_f('vtime_less');
    $atime_less = db_date_where_f('atime_less');
    $xtime_less = db_date_where_f('xtime_less');
    
    $birthday_from = db_date_where_f('birthday_from');
    $cert_date_from = db_date_where_f('cert_date_from');
    $live_date_from = db_date_where_f('live_date_from');
    $uzo_date_from = db_date_where_f('uzo_date_from');
    $aes_date_from = db_date_where_f('aes_date_from');
    $inv_date_from = db_date_where_f('inv_date_from');
    $authority_date_from = db_date_where_f('authority_date_from');
    $order_from = db_date_where_f('order_date_from');
    $proto_from = db_date_where_f('proto_date_from');
    $arrive_from = db_date_where_f('arrive_date_from');
    
    $birthday_less = db_date_where_f('birthday_less');
    $cert_date_less = db_date_where_f('cert_date_less');
    $live_date_less = db_date_where_f('live_date_less');
    $uzo_date_less = db_date_where_f('uzo_date_less');
    $aes_date_less = db_date_where_f('aes_date_less');
    $inv_date_less = db_date_where_f('inv_date_less');
    $authority_date_less = db_date_where_f('authority_date_less');
    $order_less = db_date_where_f('order_date_less');
    $proto_less = db_date_where_f('proto_date_less');
    $arrive_less = db_date_where_f('arrive_date_less');
    
    $ctime_from = str_replace('_from`=', '`>', $ctime_from);
    $vtime_from = str_replace('_from`=', '`>', $vtime_from);
    $atime_from = str_replace('_from`=', '`>', $atime_from);
    $xtime_from = str_replace('_from`=', '`>', $xtime_from);
    
    
    $ctime_less = str_replace('_less`=', '`<', $ctime_less);
    $vtime_less = str_replace('_less`=', '`<', $vtime_less);
    $atime_less = str_replace('_less`=', '`<', $atime_less);
    $xtime_less = str_replace('_less`=', '`<', $xtime_less);
    
    $birthday_from = str_replace('_from`=', '`>', $birthday_from);
    $cert_date_from = str_replace('_from`=', '`>', $cert_date_from);
    $live_date_from = str_replace('_from`=', '`>', $live_date_from);
    $uzo_date_from = str_replace('_from`=', '`>', $uzo_date_from);
    $aes_date_from = str_replace('_from`=', '`>', $aes_date_from);
    $inv_date_from = str_replace('_from`=', '`>', $inv_date_from);
    $authority_date_from = str_replace('_from`=', '`>', $authority_date_from);
    $order_from = str_replace('_from`=', '`>', $order_from);
    $proto_from = str_replace('_from`=', '`>', $proto_from);
    $arrive_from = str_replace('_from`=', '`>', $arrive_from);
    
    $birthday_less = str_replace('_less`=', '`<', $birthday_less);
    $cert_date_less = str_replace('_less`=', '`<', $cert_date_less);
    $live_date_less = str_replace('_less`=', '`<', $live_date_less);
    $uzo_date_less = str_replace('_less`=', '`<', $uzo_date_less);
    $aes_date_less = str_replace('_less`=', '`<', $aes_date_less);
    $inv_date_less = str_replace('_less`=', '`<', $inv_date_less);
    $authority_date_less = str_replace('_less`=', '`<', $authority_date_less);
    $order_less = str_replace('_less`=', '`<', $order_less);
    $proto_less = str_replace('_less`=', '`<', $proto_less);
    $arrive_less = str_replace('_less`=', '`<', $arrive_less);
    
    $rangeitems = array('eq' => '=', 'gt' => '>', 'lt' => '<');
    $total_where = '';
    $lct_where = '';
    $cct_where = '';
    $bct_where = '';
    $crt_where = '';

    if($ctime_from)
    $request_title.=str_replace('AND `ctime`>DATE','Создано начиная с ',$ctime_from).';';
    if($ctime_less)
    $request_title.=str_replace('AND `ctime`<DATE','Создано заканчивая ',$ctime_less).';';

    if($vtime_from)
    $request_title.=str_replace('AND `vtime`>DATE','Проверено начиная с ',$vtime_from).';';
    if($vtime_less)
    $request_title.=str_replace('AND `vtime`<DATE','Проверено заканчивая ',$vtime_less).';';

    if($atime_from)
    $request_title.=str_replace('AND `atime`>DATE','Правилось начиная с ',$atime_from).';';
    if($atime_less)
    $request_title.=str_replace('AND `atime`<DATE','Правилось заканчивая ',$atime_less).';';

    if($xtime_from)	    
    $request_title.=str_replace('AND `xtime`>DATE','Закрыто начиная с ',$xtime_from).';';
    if($xtime_less)
    $request_title.=str_replace('AND `xtime`<DATE','Закрыто заканчивая ',$xtime_less).';';

    if($birthday_from)    
    $request_title.=str_replace('AND `birthday`>DATE','Дата рождения начиная с ',$birthday_from).';';
    if($birthday_less)
    $request_title.=str_replace('AND `birthday`<DATE','Дата рождения заканчивая ',$birthday_less).';';

    if($cert_date_from)    
    $request_title.=str_replace('AND `cert_date`>DATE','Дата док. обр. начиная с ',$cert_date_from).';';
    if($cert_date_less)
    $request_title.=str_replace('AND `cert_date`<DATE','Дата док. обр. заканчивая ',$cert_date_less).';';

    if($live_date_from)    
    $request_title.=str_replace('AND `live_date`>DATE','Дата справки МЖ начиная с ',$live_date_from).';';
    if($live_date_less)
    $request_title.=str_replace('AND `live_date`<DATE','Дата справки МЖ заканчивая ',$live_date_less).';';

    if($uzo_date_from)    
    $request_title.=str_replace('AND `uzo_date`>DATE','Дата целевого договора начиная с ',$uzo_date_from).';';
    if($uzo_date_less)
    $request_title.=str_replace('AND `uzo_date`<DATE','Дата целевого договора заканчивая ',$uzo_date_less).';';

    if($aes_date_from)    
    $request_title.=str_replace('AND `aes_date`>DATE','Дата ЧАЭС начиная с ',$aes_date_from).';';
    if($aes_date_less)
    $request_title.=str_replace('AND `aes_date`<DATE','Дата ЧАЭС заканчивая ',$aes_date_less).';';

    if($inv_date_from)    
    $request_title.=str_replace('AND `inv_date`>DATE','Дата инв. начиная с ',$inv_date_from).';';
    if($inv_date_less)
    $request_title.=str_replace('AND `inv_date`<DATE','Дата инв. заканчивая ',$inv_date_less).';';

    if($authority_date_from)    
    $request_title.=str_replace('AND `authority_date`>DATE','Дата выдачи паспорта начиная с ',$authority_date_from).';';
    if($authority_date_less)
    $request_title.=str_replace('AND `authority_date`<DATE','Дата выдачи паспорта заканчивая ',$authority_date_less).';';


    if($order_from)    
    $request_title.=str_replace('AND `order_date`>DATE','Дата приказа начиная с ',$order_from).';';
    if($order_less)
    $request_title.=str_replace('AND `order_date`<DATE','Дата приказа заканчивая ',$order_less).';';

    if($proto_from)    
    $request_title.=str_replace('AND `proto_date`>DATE','Дата приказа начиная с ',$proto_from).';';
    if($proto_less)
    $request_title.=str_replace('AND `proto_date`<DATE','Дата приказа заканчивая ',$proto_less).';';

    if($arrive_from)    
    $request_title.=str_replace('AND `arrive_date`>DATE','Дата прибытия начиная с ',$arrive_from).';';
    if($arrive_less)
    $request_title.=str_replace('AND `arrive_date`<DATE','Дата прибытия заканчивая ',$arrive_less).';';



    $rng = $_POST['rng'];
    if ($rng['total']['fexpr']) {
        $rt = db_esc($rng['total']['r1']);
        $rs = $rangeitems[$rng['total']['fexpr']];
        $total_where = " AND `total` $rs '$rt'";

        $request_title.="Балл $rs $rt";

        if ($rng['total']['sexpr']) {
            $rt = db_esc($rng['total']['r2']);
            $rs = $rangeitems[$rng['total']['sexpr']];
            $total_where.=" AND `total` $rs '$rt'";

            $request_title.=" и $rs $rt";
        }
        $request_title.=';';
    }
    if ($rng['certificate_sum']['fexpr']) {
        $rt = db_esc($rng['certificate_sum']['r1']);
        $rs = $rangeitems[$rng['certificate_sum']['fexpr']];
        $crt_where = " AND `certificate_sum` $rs '$rt'";

        $request_title.="Балл(а) $rs $rt";

        if ($rng['certificate_sum']['sexpr']) {
            $rt = db_esc($rng['certificate_sum']['r2']);
            $rs = $rangeitems[$rng['certificate_sum']['sexpr']];
            $total_where.=" AND `certificate_sum` $rs '$rt'";

            $request_title.=" и $rs $rt";
        }
        $request_title.=';';
    }
    if ($rng['lct_sum']['fexpr']) {
        $rt = db_esc($rng['lct_sum']['r1']);
        $rs = $rangeitems[$rng['lct_sum']['fexpr']];
        $lct_where = " AND `lct_sum` $rs '$rt'";

        $request_title.="Балл(я) $rs $rt";

        if ($rng['lct_sum']['sexpr']) {
            $rt = db_esc($rng['lct_sum']['r2']);
            $rs = $rangeitems[$rng['lct_sum']['sexpr']];
            $total_where.=" AND `lct_sum` $rs '$rt'";

            $request_title.=" и $rs $rt";
        }
        $request_title.=';';
    }
    if ($rng['cct_sum']['fexpr']) {
        $rt = db_esc($rng['cct_sum']['r1']);
        $rs = $rangeitems[$rng['cct_sum']['fexpr']];
        $cct_where = " AND `cct_sum` $rs '$rt'";

        $request_title.="Балл(х) $rs $rt";

        if ($rng['cct_sum']['sexpr']) {
            $rt = db_esc($rng['cct_sum']['r2']);
            $rs = $rangeitems[$rng['cct_sum']['sexpr']];
            $total_where.=" AND `cct_sum` $rs '$rt'";

            $request_title.=" и $rs $rt";
        }
        $request_title.=';';
    }
    if ($rng['bct_sum']['fexpr']) {
        $rt = db_esc($rng['bct_sum']['r1']);
        $rs = $rangeitems[$rng['bct_sum']['fexpr']];
        $bct_where = " AND `bct_sum` $rs '$rt'";

        $request_title.="Балл(б) $rs $rt";

        if ($rng['bct_sum']['sexpr']) {
            $rt = db_esc($rng['bct_sum']['r2']);
            $rs = $rangeitems[$rng['bct_sum']['sexpr']];
            $total_where.=" AND `bct_sum` $rs '$rt'";

            $request_title.=" и $rs $rt";
        }
        $request_title.=';';
    }
    
    $reg = db_unset_empty($reg);
    $reg = db_replace_nill($reg, 'пусто');
    $res = db_where_values($reg);
    
    $sql="SELECT *  FROM `db_person` WHERE " 
            ."(1 $res $total_where $crt_where $lct_where $cct_where $bct_where $ctime_from  $vtime_from $atime_from $xtime_from $ctime_less $vtime_less $atime_less $xtime_less $birthday_from $birthday_less $cert_date_from $cert_date_less $live_date_from $live_date_less $uzo_date_from $uzo_date_less $aes_date_from $aes_date_less $inv_date_from $inv_date_less $authority_date_from $authority_date_less $order_from $order_less $proto_from $proto_less $arrive_from $arrive_less ) " ;
    $r=mysql_query($sql) or debug($sql,  mysql_error());
}





$p=db_empty_record('db_person');

ui_sp('Диапазоны');
if(!$r)
{
    form_draw($p,'');
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
    while ($l = mysql_fetch_object($r)) {

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
        $bf = ui_sap($bf_set,$l->benefit_set,'');
        ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php", array("id=$l->id"), array($bf,$tf, $ef, $t_, $tt, $e_link, $c_link), array($l->delo_name, $l->total), $rowclass);
        /* ui_rep_row('lh24',$rowcolor);
          ui_rep_td_l(++$i, 'elemkv');
          ui_rep_td_l($l->delo_name);
          ui_rep_td_l($l->total);
          ui_rep_td_l("$l->surname $l->name $l->midname",'elemsv');
          ui_rep_td_l($tf);
          ui_rep_td_l($ef);
          ui_rep_td_l($t_);
          ui_rep_td_l($tt);


          ui_end_row();
         * *
         */

        cr_temppush($l->id, $l->delo_name);
    }
    ui_efs();
    ui_esfs();
}
ui_ep();
