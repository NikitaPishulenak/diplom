<?php

$pgroups=array();
$tgroups=array();

$tgroups['000top-group']='Титул';
$tgroups['001drive-in-group']='Поступление';
$tgroups['002drive-out-group']='Зачисление';
$tgroups['003private-group']='ФИО, паспорт';
$tgroups['004live-addr-group']='Адрес';
$tgroups['005edu_group']='Аттестат';
$tgroups['006cert-group']='ЦТ';
$tgroups['007check-group']='Галочки';
$tgroups['008append-group']='Доп.данные';
$tgroups['009note-group']='Справки';
$tgroups['010parent-group']='Родители';
$tgroups['owner-group']='Тех. данные';
$tgroups['data-out-group']='Приказы';
$tgroups['last-group']='Остальное';




$pgroups = array();
$pgroups['surname'] = '003private-group';
$pgroups['name'] = '003private-group';
$pgroups['midname'] = '003private-group';
$pgroups['serial'] = '003private-group';
$pgroups['private'] = '003private-group';
$pgroups['natio'] = '003private-group';
$pgroups['birthday'] = '003private-group';
$pgroups['sex'] = '003private-group';

$pgroups['time_form_id'] = '001drive-in-group';
$pgroups['edu_form'] = '001drive-in-group';
$pgroups['faculty'] = '001drive-in-group';
$pgroups['target'] = '001drive-in-group';
$pgroups['target_type'] = '001drive-in-group';
$pgroups['target_cell'] = '001drive-in-group';
$pgroups['region_cell'] = '001drive-in-group';

$pgroups['out_time_form_id'] = '002drive-out-group';
$pgroups['out_edu_form'] = '002drive-out-group';
$pgroups['out_faculty'] = '002drive-out-group';
$pgroups['out_target'] = '002drive-out-group';
$pgroups['out_target_type'] = '002drive-out-group';
$pgroups['out_target_cell'] = '002drive-out-group';

$pgroups['country'] = '004live-addr-group';
$pgroups['region_by'] = '004live-addr-group';
$pgroups['region_text'] = '004live-addr-group';
$pgroups['area'] = '004live-addr-group';
$pgroups['subdiv'] = '004live-addr-group';
$pgroups['city_name'] = '004live-addr-group';
$pgroups['zip'] = '004live-addr-group';
$pgroups['microarea'] = '004live-addr-group';
$pgroups['street'] = '004live-addr-group';
$pgroups['house'] = '004live-addr-group';
$pgroups['house_part'] = '004live-addr-group';
$pgroups['room'] = '004live-addr-group';
$pgroups['phone'] = '004live-addr-group';
$pgroups['mobile'] = '004live-addr-group';
$pgroups['email'] = '004live-addr-group';
$pgroups['real_addr'] = '004live-addr-group';

$pgroups['auid'] = 'owner-group';
$pgroups['cuid'] = 'owner-group';
$pgroups['vuid'] = 'owner-group';
$pgroups['xuid'] = 'owner-group';

$pgroups['atime'] = 'owner-group';
$pgroups['ctime'] = 'owner-group';
$pgroups['vtime'] = 'owner-group';
$pgroups['xtime'] = 'owner-group';

$pgroups['lct_id'] = '006cert-group';
$pgroups['lct_sum'] = '006cert-group';
$pgroups['lct_sn'] = '006cert-group';
$pgroups['lct_xn'] = '006cert-group';
$pgroups['cct_id'] = '006cert-group';
$pgroups['cct_sum'] = '006cert-group';
$pgroups['cct_sn'] = '006cert-group';
$pgroups['cct_xn'] = '006cert-group';
$pgroups['bct_id'] = '006cert-group';
$pgroups['bct_sum'] = '006cert-group';
$pgroups['bct_sn'] = '006cert-group';
$pgroups['bct_xn'] = '006cert-group';

$pgroups['language_set'] = '007check-group';
$pgroups['benefit_set'] = '007check-group';
$pgroups['community_set'] = '007check-group';
$pgroups['other_set'] = '007check-group';

$pgroups['education_id'] = '005edu_group';

$pgroups['live_num'] = '009note-group';
$pgroups['live_date'] = '009note-group';
$pgroups['live_data'] = '009note-group';

$pgroups['aes_num'] = '009note-group';
$pgroups['aes_date'] = '009note-group';
$pgroups['aes_data'] = '009note-group';

$pgroups['uzo_num'] = '009note-group';
$pgroups['uzo_date'] = '009note-group';
$pgroups['uzo_data'] = '009note-group';

$pgroups['inv_num'] = '009note-group';
$pgroups['inv_date'] = '009note-group';
$pgroups['inv_data'] = '009note-group';

$pgroups['institution_id'] = '005edu_group';
$pgroups['institution_name'] = '005edu_group';
$pgroups['certificate_id'] = '005edu_group';
$pgroups['certificate_name'] = '005edu_group';
$pgroups['certificate_sum'] = '005edu_group';
$pgroups['cert_date'] = '005edu_group';

$pgroups['delo_name'] = '000top-group';
$pgroups['delo_int'] = '000top-group';
$pgroups['course_id'] = '008append-group';
$pgroups['grade_id'] = '008append-group';

$pgroups['try_id'] = '008append-group';
$pgroups['military_id'] = '008append-group';
$pgroups['hostel_id'] = '008append-group';
$pgroups['experience_id'] = '008append-group';

$pgroups['total'] = '000top-group';
$pgroups['region_cell'] = '001drive-in-group';
$pgroups['state_id'] = '000top-group';
$pgroups['inst_city_name'] = '005edu_group';
$pgroups['inst_city_type'] = '005edu_group';
$pgroups['filltime'] = 'owner-group';
$pgroups['order_num'] = 'data-out-group';
$pgroups['order_date'] = 'data-out-group';
$pgroups['arrive_date'] = 'data-out-group';
$pgroups['arrive_time'] = 'data-out-group';
$pgroups['arrive_room'] = 'data-out-group';
$pgroups['dual_mode_set'] = '001drive-in-group';
$pgroups['student_id'] = '000top-group';
$pgroups['xclass_id'] = '001drive-in-group';
$pgroups['authority'] = '003private-group';
$pgroups['authority_date'] = '003private-group';
$pgroups['inst_rank_id'] = '005edu_group';
$pgroups['wouldbe_id'] = '001drive-in-group';

$pgroups['f_surname'] = '010parent-group';
$pgroups['f_name'] = '010parent-group';
$pgroups['f_midname'] = '010parent-group';

$pgroups['m_surname'] = '010parent-group';
$pgroups['m_name'] = '010parent-group';
$pgroups['m_midname'] = '010parent-group';

$pgroups['f_addr'] = '010parent-group';
$pgroups['m_addr'] = '010parent-group';

$pgroups['cur_lang_id'] = '007check-group';
$pgroups['cur_lang_level'] = '007check-group';

$pgroups['in_course'] = '001drive-in-group';
$pgroups['out_course'] = '002drive-out-group';

$pgroups['proto_num'] = 'data-out-group';
$pgroups['proto_date'] = 'data-out-group';

$pgroups['uq'] = 'last-group';
$pgroups['out_region_cell'] ='002drive-out-group';
$pgroups['invalid_id']='008append-group';
$pgroups['aes_end_date']='009note-group';
$pgroups['inv_end_date']='009note-group';
$pgroups['live_addr']='004live-addr-group';
$pgroups['target_use_id']='002drive-out-group';
//$pgroups['']='';
//$pgroups['']='';

