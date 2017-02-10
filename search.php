<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.search.php';


define('PAGE_SEC', 'person.search');
cr_logic();

$r = null;

$request_title = '';
$fixation_title = '';

if (!empty($_POST)) {
    require 'form/person.column.php';
    require 'form/options.php';

    
    // Check data
    // Save person
    $timecut = '1';
    $tvw = isset($_POST['tvw']['at']) ? $_POST['tvw']['at'] : '';
    $wfix_where='';

    $xcr = $_POST['xcr'];
    settype($xcr['inst_city_rang'], 'integer');
    settype($xcr['addr_city_rang'], 'integer');
    $icrwhere = ($xcr['inst_city_rang']) ? " AND `inst_city_type` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='${xcr['inst_city_rang']}')  " : '';
    $acrwhere = ($xcr['addr_city_rang']) ? " AND `subdiv` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='${xcr['addr_city_rang']}')  " : '';


    $fix=(isset($_POST['fix']))?$_POST['fix']:array();
    if(!empty($fix))
    {
        $fid=$fix['x_id'];
        $options['manualid']=db_kv('mfx`.`db_fixation','id_fixation','name');
        if($fid)
        {
            $wfix['state_id']=$fix['xstate_id'];
            $wfix['faculty']=$fix['xfaculty'];
            $wfix['time_form_id']=$fix['xtime_form_id'];
            $wfix['edu_form']=$fix['xedu_form'];
            $wfix['target']=$fix['xtarget'];
            $wfix['target_type']=$fix['xtarget_type'];
            $wfix['target_cell']=$fix['xtarget_cell'];
            $wfix['region_cell']=$fix['xregion_cell'];
            $wfix= db_unset_empty($wfix);
            $wfix_params =db_where_values($wfix);
            
            $wfix_where = " AND  `id` in (SELECT `person_id` from `mfx`.`db_fixed_target` WHERE (`fixation_id`='$fid' $wfix_params ) )";
            
            $fixation_title.='Фиксированный конкурс /'.$options['manualid'][$fid].'/: ';
            $request_title.='Текущий конкурс: ';
            foreach ($wfix as $k => $v) {
            if ($v) {
            $fixation_title.=$pcolumns[$k] . ' = ';
            $fixation_title.=(isset($options[$k][$v])) ? $options[$k][$v] : $v;
            $fixation_title.='; ';
            }
    }
        }
    }

    $rangeitems = array('eq' => '=', 'gt' => '>', 'lt' => '<');
    $total_where = '';
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
    //$validless=(empty($tvw))?'':" AND `vtime`<='$tvw' AND `vtime`<>0 ";
    //$tlw=$_POST['tlw']['at'];
    //$validless=(empty($tlw))?'':" AND `vtime`<='$tlw' AND `vtime`<>0 AND (`xtime`>'$tlw' OR `xtime`=0 )";


    $zxc = isset($_POST['zxc']['created']) ? $_POST['zxc']['created'] : '';
    $zxcd = $zxc;
    $zxc = ($zxc != '0') ? " AND DAY(`ctime`)='$zxc' " : '';
    if(!empty($zxc)){
        $request_title.='Подано за '.$zxcd.' число;';
    }
    
    $zxd = isset($_POST['zxc']['closed']) ? $_POST['zxc']['closed'] : '';
    $zxdd = $zxd;
    $zxd = ($zxd != '0') ? " AND DAY(`xtime`)='$zxd' " : '';
    if(!empty($zxd)){
        $request_title.='Забраны '.$zxdd.' числом;';
    }
    

    $birthday_where = db_date_where('birthday');
    $cert_date_where = db_date_where('cert_date');
    $live_date_where = db_date_where('live_date');
    $uzo_date_where = db_date_where('uzo_date');
    $aes_date_where = db_date_where('aes_date');
    $inv_date_where = db_date_where('inv_date');
    $aes_end_date_where = db_date_where('aes_end_date');
    $inv_end_date_where = db_date_where('inv_end_date');
    $authority_date_where = db_date_where('authority_date');


    $edu_where = db_bit_where('edu', 'education_id');
    $lang_where = db_bit_where('lang', 'language_set');
    $bnf_where = db_bit_where('bnf', 'benefit_set');
    $com_where = db_bit_where('com', 'community_set');
    $oth_where = db_bit_where('oth', 'other_set');
    $dm_where = ''; //db_bit_where('dm', 'dual_mode_set');
    $st_where = db_bit_where('st', 'student_id');
    $xc_where = db_bit_where('xc', 'xclass_id');
    $wb_where = db_bit_where('wb', 'wouldbe_id');
    $po_where = db_bit_where('po', 'po_lang_set');

    $reg = $_POST['reg'];
    
    $reg['delo_name'] = ui_en2ru($reg['delo_name']);
    
    /* ++ REQUEST TITLE ++ */
    foreach ($reg as $k => $v) {
        if ($v) {
            $request_title.=$pcolumns[$k] . ' = ';
            $request_title.=(isset($options[$k][$v])) ? $options[$k][$v] : $v;
            $request_title.='; ';
        }
    }
    $temp_title=ui_bit_where('po', $options['po_lang_id']);
    if($temp_title!='[]') $request_title.="Предметы:$temp_title; ";

    $temp_title=ui_bit_where('lang', $options['language_id']);
    if($temp_title!='[]') $request_title.="Языки:$temp_title; ";
    
    $temp_title=ui_bit_where('bnf', $options['benefit_id']);
    if($temp_title!='[]') $request_title.="Льготы:$temp_title; ";
    
    $temp_title=ui_bit_where('com', $options['community_id']);
    if($temp_title!='[]') $request_title.="Членство:$temp_title; ";
    
    $temp_title=ui_bit_where('oth', $options['other_id']);
    if($temp_title!='[]') $request_title.="Другое:$temp_title; ";
    
    $temp_title=ui_bit_where('edu', $options['education_id']);
    if($temp_title!='[]') $request_title.="Образование:$temp_title; ";
    
    
    $temp_title=ui_bit_where('st', $options['student_id']);
    if($temp_title!='[]') $request_title.="Студент:$temp_title; ";
    
    $temp_title=ui_bit_where('wb', $options['wouldbe_id']);
    if($temp_title!='[]') $request_title.="Потенциальность:$temp_title; ";
    
    $temp_title=ui_bit_where('xc', $options['xclass_id']);
    if($temp_title!='[]') $request_title.="Казусы реформ:$temp_title; ";
    
    $temp_title=ui_date_where('birthday');
    if($temp_title!='[]') $request_title.="Дата рождения:$temp_title; ";
    
    $temp_title=ui_date_where('authority_date');
    if($temp_title!='[]') $request_title.="Дата выдачи:$temp_title; ";
    
    $temp_title=ui_date_where('cert_date');
    if($temp_title!='[]') $request_title.="Дата аттестата:$temp_title; ";
    
    $temp_title=ui_date_where('live_date');
    if($temp_title!='[]') $request_title.="Дата МЖ:$temp_title; ";
    
    $temp_title=ui_date_where('aes_date');
    if($temp_title!='[]') $request_title.="Дата ЧАЭС:$temp_title; ";
    
    $temp_title=ui_date_where('inv_date');
    if($temp_title!='[]') $request_title.="Дата инв:$temp_title; ";
    
    $temp_title=ui_date_where('aes_end_date');
    if($temp_title!='[]') $request_title.="Дата x ЧАЭС:$temp_title; ";
    
    $temp_title=ui_date_where('inv_end_date');
    if($temp_title!='[]') $request_title.="Дата x инв:$temp_title; ";
    
    
    $temp_title=ui_date_where('uzo_date');
    if($temp_title!='[]') $request_title.="Дата ЦД:$temp_title; ";
    
    $request_title.=($xcr['addr_city_rang'])?'Ранг НП МЖ='.$options['city_rang'][$xcr['addr_city_rang']].'; ':'';
    $request_title.=($xcr['inst_city_rang'])?'Ранг НП УО='.$options['city_rang'][$xcr['inst_city_rang']].'; ':'';
    
    
    
    /* -- REQUEST TITLE -- */
    //$pcolumns['(delo_name,delo_int)']='Номер дела';
    $order = array();
    $sort_x = $_POST['sort']['x'];
    $check_x = (isset($_POST['check_sort']['x'])) ? 'DESC' : 'ASC';

    $order[] = (isset($pcolumns[$sort_x])) ? "`$sort_x` $check_x " : '';

    $sort_y = $_POST['sort']['y'];
    $check_y = (isset($_POST['check_sort']['y'])) ? 'DESC' : 'ASC';
    $order[] = (isset($pcolumns[$sort_y])) ? "`$sort_y` $check_y " : '';

    $sort_z = $_POST['sort']['z'];
    $check_z = (isset($_POST['check_sort']['z'])) ? 'DESC' : 'ASC';
    $order[] = (isset($pcolumns[$sort_z])) ? "`$sort_z` $check_z " : '';

    $order_f = implode(',', array_filter($order, 'strlen'));

    $order_by = (empty($order_f)) ? '' : "ORDER BY $order_f";


    $opt = (isset($_POST['opt'])) ? $_POST['opt'] : array();
    
    $dropnovice = (isset($opt['dropnovice'])) ? ' AND `state_id`<>4 ' : '';
    $dropinvalid = (isset($opt['dropinvalid'])) ? ' AND `state_id`<>0 ' : '';
    $droppdp = (isset($opt['droppdp'])) ? ' AND `faculty`<> 7 ':'';
    /* TARGET HISTORY */
    $reg = db_unset_empty($reg);
    $reg = db_replace_nill($reg, 'пусто');
	
    $cth='';
    $rth = db_th_util($reg);
    $jth ='';
    if (!empty($tvw)) {
        $reg = db_th_unset($reg);
        $tvw = db_esc($tvw);
        $rthres = db_where_values($rth);
	$cth = ',th.faculty faculty,th.edu_form edu_form, th.target target, th.target_type target_type';
	$timecut = "`id` in (SELECT `person_id` FROM `db_target_history` th WHERE `vtime`<'$tvw' AND (`xtime`>'$tvw' OR `xtime`=0) $rthres )";
	//$timecut = '1';
	
	$jth="left join db_target_history th on (th.person_id=db_person.id AND th.`vtime`<'$tvw' AND (th.`xtime`>'$tvw' OR th.`xtime`=0) $rthres)";

	$request_title="Срез:$tvw;".$request_title;
    }

    $cin = $_POST['cin'];
    $querycut = '';
    $chaincut = '';
    $stickcut = '';
    settype($cin['queryid'], 'integer');
    settype($cin['chainid'], 'integer');
    settype($cin['stickid'], 'integer');
    if ($cin['queryid'] > 0) {
        $querysql = db_single_record('db_query', 'id_query', $cin['queryid']);
        $temp_title=$querysql['name'];
        $strrc=1;
        $querysql = str_replace('*', '`id`', $querysql['query'],$strrc);
        $querycut = "AND `id` in ($querysql)";
        $request_title="Источник:запрос=($temp_title);".$request_title;
    }
    if ($cin['chainid'] > 0) {
        $chainsql = "SELECT `person_id` FROM `db_chid` WHERE `chain_id`='${cin['chainid']}'";
        $chaincut = "AND `id` in ($chainsql)";
        $request_title="Источник:Цепочка;".$request_title;
    }
    if ($cin['stickid'] > 0) {
        $sticksql = "SELECT `person_id` FROM `db_tag_relation` WHERE `tag_id`='${cin['stickid']}'";
        $stickcut = "AND `id` in ($sticksql)";
        $request_title="Источник:Стикер;".$request_title;
    }
    
    /*
      var_dump($reg);
      die();
     * 
     */
    $res = db_where_values($reg);

    $sql = "SELECT * $cth FROM `db_person` $jth " .
#	"LEFT JOIN db_n ON db_person.id=db_n.person_id" .
            " WHERE ($timecut $wfix_where $querycut $chaincut $stickcut $icrwhere $acrwhere $res $zxc $zxd $total_where $st_where $xc_where $wb_where $edu_where $lang_where $bnf_where $com_where $oth_where $dm_where $birthday_where $cert_date_where $live_date_where $uzo_date_where $aes_date_where $inv_date_where $aes_end_date_where $inv_end_date_where  $authority_date_where $dropinvalid $droppdp $po_where) $order_by";
    $r = mysql_query($sql) or debug($sql, mysql_error());

    //ui_redirect("view.php?id=$id");
}

$p = db_empty_record('db_person');
$d = db_default_record('db_person');


ui_sp('Поиск');
/* ui_stfs();
  ui_blink('Поиск','search.php');
  ui_etfs(); */
if (!$r) {
    form_draw($p, 'search');
    ui_script('js/search.js?2');
    ui_script('js/person.search.js?2');
    ui_script('js/person.search.highlight.js?2');
    ui_script_start();
    $def_faculty = cr_ukey('faculty');
    $def_time_form = cr_ukey('time_form');
    $def_last = (cr_ukey('use_last'))?'':'//';
    $def_state_id = cr_ukey('def_state_id');
    print<<<EOF
            $(document).ready(function(){
            $('#faculty').val($def_faculty);
            $('#time_form_id').val($def_time_form);
            $('#state_id').val($def_state_id);
            $def_last $('#created').val($('#created option').last().val()); 
            });
EOF;
    ui_script_end();
} else {
    cr_set_sql($sql);
    cr_set_rqt($request_title);
    //    print "$sql<br />";
    ui_par($fixation_title);
    ui_par($request_title);
    if(cr_check('control')){
	ui_par($sql);
    }
    //ui_par($sql);
    cr_tempclear();
    ui_hr();
    ui_chain_links();
    ui_hr();
    ui_sfs('','w100','header');
    ui_rep_row();
    ui_end_row();
    ui_efs();
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
    $student = db_bits2arr('db_student', 'id_student', 'style');
    ui_rep_row();
    ui_rep_th('#');
    ui_rep_th('Дело');
    ui_rep_th('Балл');
    ui_rep_th('Абитуриент');
    ui_rep_th('?');
    ui_rep_th('Льготы');
    ui_rep_th('ФП');
    ui_rep_th('ФО');
    ui_rep_th('К');
    ui_rep_th('ТК');
    ui_rep_th('');
    ui_rep_th('');
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
        $s_span = ($l->student_id )?"<span style=\"${student[$l->student_id]}\">&nbsp;</span>":'';
        $e_link = (!empty($e_temp)) ? "<a href=\"$e_temp?id=$l->id\">e</a>" : '';
        $c_link = (!empty($c_temp)) ? "<a href=\"$c_temp?id=$l->id\">c</a>" : '';
        ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php", array("id=$l->id"), array($s_span,$bf,$tf, $ef, $t_, $tt, $e_link, $c_link), array($l->delo_name, $l->total), $rowclass);
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
    //ui_blink('Заменить('.cr_tempcount().')','pop_chain.php' );
    //ui_blink('Добавить('.cr_tempcount().')','add_chain.php' );
    // ui_chain_links();
	ui_script('js/person.result.js?2');
}

ui_ep();
