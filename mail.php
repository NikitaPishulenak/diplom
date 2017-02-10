<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC', 'person.call');
cr_logic();


$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');
if ($id < 0)
    ui_redirect('noaccess.php');

if(!empty($_POST))
{
    if($id>0)
    {
        $reg=$_POST['reg'];
        $reg['person_id']=$id;
        $reg['caller_id']=cr_userid();
        $res=db_field_values($reg);
        $sql="INSERT INTO `db_mail` (${res[0]}) VALUES (${res[1]})";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        ui_redirect("mail.php?id=$id");
    }
}


if ($id > 0) {
    $p = db_single_record('db_person', 'id', $id);


    ui_sp('Письма дела ' . $p['delo_name']);
    $opt = array();
    $opt['tf'] = db_kv('db_time_form', 'id_time_form', 'abbr');
    $opt['ef'] = db_kv('db_ef', 'id_ef', 'abbr');
    $opt['t_'] = db_kv('db_target', 'id_target', 'abbr');
    $opt['tt'] = db_kv('db_targettype', 'id_targettype', 'abbr');
    $opt['rc'] = db_kv('db_region', 'id_region', 'abbr');
    $opt['tc'] = db_kv('db_targetcell', 'id_targetcell', 'abbr');
    $opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
    $opt['uid'] = db_kv('db_users','id','realname');
    ui_view_header($p, $opt);
    ui_view_links($id);
    ui_hr();
    ui_stfs();
    ui_sfs('Связь');
    ui_text_view('', '', 'Домашний',$p['phone']);
    ui_text_view('', '', 'Мобильный',$p['mobile']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Отец');
    ui_text_view('reg', 'f_surname', 'Фамилия', $p['f_surname'], 50);
    ui_text_view('reg', 'f_name', 'Имя', $p['f_name'], 50);
    ui_text_view('reg', 'f_midname', 'Отчество', $p['f_midname'], 50);
    
    ui_efs();
    ui_sptfs3();
    ui_sfs('Мать');
    ui_text_view('reg', 'm_surname', 'Фамилия', $p['m_surname'], 50);
    ui_text_view('reg', 'm_name', 'Имя', $p['m_name'], 50);
    ui_text_view('reg', 'm_midname', 'Отчество', $p['m_midname'], 50);
    
    ui_efs();
    ui_etfs();
    
    ui_hr();
    ui_sf();
    ui_sfs('Новое письмо');
//    ui_text('reg', 'call_request', 'Причина звонка', '', '');
    ui_text('reg', 'call_response', 'Документ', '', '');
    ui_hidden('reg','name',$p['delo_name']);
    ui_efs();
    ui_ef();
    ui_hr();
    $sql="SELECT * FROM `db_mail` WHERE `person_id`='$id'";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    
    ui_sfs();
        ui_rep_row('','w100');
        ui_rep_th('#');
        ui_rep_th("Дата письма",'','','nw');
        ui_rep_th('Работник');
//        ui_rep_th('Причина','','','w50');
        ui_rep_th('Документ','','','w100');
        
        ui_end_row();
    while($l=  mysql_fetch_object($r))
    {
        ui_rep_row();
        ui_rep_th('#');
        ui_rep_td_l($l->call_date,'nw');
        ui_rep_td_l(ui_sap($opt['uid'],$l->caller_id));
//        ui_rep_td_l($l->call_request,'w50');
        ui_rep_td_l($l->call_response,'w100');
        
        ui_end_row();
    }
    ui_efs();
    ui_ep();
} else {
    ui_sp('Письма');

    ui_ep();
}