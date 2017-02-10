<?php

function form_draw($p, $t) {
    require 'options.php';
    require 'person.column.php';
    
    $sql="SELECT DISTINCT DAY(`ctime`) ctime,MONTH(`ctime`) m FROM `db_person`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $options['created']=array();
    while($l= mysql_fetch_object($r))
    {
        $options['created'][$l->ctime]="$l->ctime.$l->m";
    }
    
    $options['queryid']=db_kv('db_query','id_query','name');
    $options['chainid']=db_kv('db_chain','id_chain','name');
    $options['stickid']=db_kv('db_tag','id_tag','name');
    $options['manualid']=db_kv('mfx`.`db_fixation','id_fixation','name');
    ui_sf();
    if ($t == 'search')
        ui_sc('Поиск');
    print '<a style="margin-top:0;float:right" href="javascript:form_reset()">Сбросить</a>';
    print '<a style="margin-top:0;float:left" href="javascript:form_last()">Последний запрос</a>';
    ui_hr();

    ui_stfs();
    ui_sfs('&nbsp');
    ui_text('reg', 'delo_name', 'Номер дела', $p['delo_name'], 13);
    ui_text('reg', 'uq', 'Уникальный отпечаток', $p['uq'], 13);
    //ui_text('tvw', 'at', '<a style="margin: 0pt;" href="javascript:cut_use();">Cрез</a>', '', 50);
   // ui_text('tlw', 'at', 'Живой срез', '', 50);
    ui_select('zxc', 'created', 'Поданы за день', $options['created'], 0);
    ui_select('zxc', 'closed', 'Закрыты за день', $options['created'], 0);
    ui_select('cin', 'queryid', 'Источник - запрос',$options['queryid'],0);
    ui_select('cin', 'chainid', 'Источник - цепочка',$options['chainid'],0);
    ui_select('cin', 'stickid', 'Источник - стикер',$options['stickid'],0);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Конкурсы фиксации');
    ui_select('fix', 'x_id', 'Фиксация', $options['manualid'], 0);
    ui_select('fix', 'xstate_id', 'Состояние', $options['state_id'], $p['state_id']);
    ui_select('fix', 'xfaculty', 'Факультет', $options['faculty'], $p['faculty']);
    ui_select('fix', 'xtime_form_id', 'Форма получения', $options['time_form'], $p['time_form_id']);
    ui_select('fix', 'xedu_form', 'Форма обучения', $options['ef'], $p['edu_form']);
    ui_select('fix', 'xtarget', 'Конкурс', $options['target'], $p['target']);
    ui_select('fix', 'xtarget_type', 'Тип Конкурса', $options['target_type'], $p['target_type']);
    ui_select('fix', 'xtarget_cell', 'Тип Целевого', $options['target_cell'], $p['target_cell']);
    ui_select('fix', 'xregion_cell', 'Целевая область', $options['region_by'], $p['region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Тех. данные');
    ui_select('reg', 'cuid', 'Регистратор', $options['users_by_name'], $p['cuid']);
    ui_select('reg', 'vuid', 'Валидатор', $options['users_by_name'], $p['vuid']);
    ui_select('reg', 'auid', 'Редактор', $options['users_by_name'], $p['auid']);
    ui_select('reg', 'xuid', 'Закрыт', $options['users_by_name'], $p['xuid']);
    ui_select_range('rng','total','Балл');
    ui_check('opt', 'dropinvalid', 'Не показывать бронь', 1);
    ui_check('opt', 'droppdp', 'Не показывать ПДП', (int)(cr_ukey('faculty')!=7));
    //ui_select('reg', 'target_use_id','Конкурс участия',$options['target_use_id'],$p['target_use_id']);
    ui_efs();
    ui_etfs();
    
    unset($pcolumns['delo_name']);
    $pcolumns['delo_int']='Номер дела';
    
    ui_stfs('Сортировка');
    ui_blink('№Д', "javascript:sort_use('x','delo_int')");
    ui_blink('&sum;', "javascript:sort_use('x','total')");
    ui_blink('Ф', "javascript:sort_use('x','faculty')");
    ui_blink('О', "javascript:sort_use('x','time_form_id')");
    ui_blink('Фо', "javascript:sort_use('x','edu_form')");
    ui_blink('К', "javascript:sort_use('x','target')");
    ui_blink('ТК', "javascript:sort_use('x','target_type')");
    ui_blink('ТЦ', "javascript:sort_use('x','target_cell')");
    ui_blink('Цо', "javascript:sort_use('x','region_cell')");
    ui_blink('Фам', "javascript:sort_use('x','surname')");
    ui_sfs();
    ui_select_check('sort', 'x', 'X', $pcolumns, 0);
    ui_efs();
    ui_sptfs3();
    ui_blink('№Д', "javascript:sort_use('y','delo_int')");
    ui_blink('&sum;', "javascript:sort_use('y','total')");
    ui_blink('Ф', "javascript:sort_use('y','faculty')");
    ui_blink('О', "javascript:sort_use('y','time_form_id')");
    ui_blink('Фо', "javascript:sort_use('y','edu_form')");
    ui_blink('К', "javascript:sort_use('y','target')");
    ui_blink('ТК', "javascript:sort_use('y','target_type')");
    ui_blink('ТЦ', "javascript:sort_use('y','target_cell')");
    ui_blink('Цо', "javascript:sort_use('y','region_cell')");
    ui_blink('Фам', "javascript:sort_use('y','surname')");
    ui_sfs();
    ui_select_check('sort', 'y', 'Y', $pcolumns, 0);
    ui_efs();
    ui_sptfs3();
    ui_blink('№Д', "javascript:sort_use('z','delo_int')");
    ui_blink('&sum;', "javascript:sort_use('z','total')");
    ui_blink('Ф', "javascript:sort_use('z','faculty')");
    ui_blink('О', "javascript:sort_use('z','time_form_id')");
    ui_blink('Фо', "javascript:sort_use('z','edu_form')");
    ui_blink('К', "javascript:sort_use('z','target')");
    ui_blink('ТК', "javascript:sort_use('z','target_type')");
    ui_blink('ТЦ', "javascript:sort_use('z','target_cell')");
    ui_blink('Цо', "javascript:sort_use('z','region_cell')");
    ui_blink('Фам', "javascript:sort_use('z','surname')");
    ui_sfs();
    ui_select_check('sort', 'z', 'Z', $pcolumns, 0);
    ui_efs();
    ui_etfs();

    ui_stfs('Конкурс');
    ui_sfs('Поступление');
    ui_select('reg', 'faculty', 'Факультет', $options['faculty'], $p['faculty']);
    ui_select('reg', 'time_form_id', 'Форма получения', $options['time_form'], $p['time_form_id']);
    ui_select('reg', 'edu_form', 'Форма обучения', $options['ef'], $p['edu_form']);
    ui_select('reg', 'target', 'Конкурс', $options['target'], $p['target']);
    ui_select('reg', 'target_type', 'Тип Конкурса', $options['target_type'], $p['target_type']);
    ui_select('reg', 'target_cell', 'Тип Целевого', $options['target_cell'], $p['target_cell']);
    ui_select('reg', 'region_cell', 'Целевая область', $options['region_by'], $p['region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Зачисление');
    ui_select('reg', 'state_id', 'Состояние', $options['state_id'], $p['state_id']);
    ui_select('reg', 'out_time_form_id', 'Форма обучения', $options['time_form'], $p['out_time_form_id']);
    ui_select('reg', 'out_edu_form', 'Форма зачисления', $options['ef'], $p['out_edu_form']);
    ui_select('reg', 'out_target', 'Конкурс зачисления', $options['target'], $p['out_target']);
    ui_select('reg', 'out_target_type', 'Тип К Зачисления', $options['target_type'], $p['out_target_type']);
    ui_select('reg', 'out_target_cell', 'Тип Ц Зачисления', $options['target_cell'], $p['out_target_cell']);
    ui_select('reg', 'out_region_cell', 'Цел. обл. Зачисления', $options['region_cell'], $p['out_region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Статус');
    ui_select('reg', 'dual_mode_set', 'Доп Заявления', $options['dual_mode_id'], $p['dual_mode_set']);
    ui_bit_sel('st', 'student_id', '', $options['student_id'], $p['student_id']);
    ui_bit_sel('xc', 'xclass_id', '', $options['xclass_id'], $p['xclass_id']);
    ui_bit_sel('wb', 'wouldbe_id', '', $options['wouldbe_id'], $p['wouldbe_id']);
    ui_efs();
    ui_etfs();
    
    if(cr_ukey('faculty')==7)
    {
	ui_stfs('ПО');
        ui_sfs();
	ui_select('reg','po_base_id','База',$options['po_base_id'],$p['po_base_id']);
        ui_efs();
        ui_sptfs();
        ui_sfs();
        ui_bit_sel('po','po_lang_id','',$options['po_lang_id'],$p['po_lang_set']);
        ui_efs();
        ui_etfs();


    }

    ui_stfs('Личные и паспортные данные');
    ui_sfs();
    ui_text('reg', 'surname', 'Фамилия', $p['surname'], 50);
    ui_text('reg', 'name', 'Имя', $p['name'], 50);
    ui_text('reg', 'midname', 'Отчество', $p['midname'], 50);
    ui_select('reg', 'sex', 'Пол', $options['sex'], $p['sex']);
    ui_date_edit('reg', 'birthday', 'Дата рождения', $p['birthday']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select('reg', 'natio', 'Гражданство', $options['natio'], $p['natio']);
    ui_text('reg', 'serial', 'Серия и номер', $p['serial'], 50);
    ui_text('reg', 'private', 'Личный номер', $p['private'], 50);
    
    
    ui_text('reg','authority','Выдан',$p['authority'],50);
    ui_date_edit('reg', 'authority_date', 'Дата выдачи', $p['authority_date']);
    ui_efs();
    ui_etfs();


    ui_stfs('Место жительства');
    ui_sfs();
    ui_select('reg', 'country', 'Страна', $options['country'], $p['country']);
    ui_select('reg', 'region_by', 'Область', $options['region_by'], $p['region_by']);
    ui_text('reg', 'region_text', 'Область(текст)', $p['region_text'], 50);
    ui_text('reg', 'area', 'Район', $p['area'], 50);
    ui_select('xcr', 'addr_city_rang', 'Ранг нп', $options['city_rang'], 0);
    ui_select('reg', 'subdiv', 'Тип нп', $options['subdiv'], $p['subdiv']);
    ui_text('reg', 'city_name', 'Название нп', $p['city_name'], 50);
    ui_text('reg', 'zip', 'Индекс', $p['zip'], 50);
    ui_text('reg', 'microarea', 'Микрорайон', $p['microarea'], 50);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'street', 'Улица', $p['street'], 50);
    ui_text('reg', 'house', 'Дом', $p['house'], 50);
    ui_text('reg', 'house_part', 'Корпус', $p['house_part'], 50);
    ui_text('reg', 'room', 'Квартира', $p['room'], 50);
    ui_text('reg', 'phone', 'Домашний', $p['phone'], 50);
    ui_text('reg', 'mobile', 'Мобильный', $p['mobile'], 50);
    ui_text('reg', 'email', 'E-mail', $p['email'], 50);
    ui_text('reg', 'real_addr', 'Адрес прописки', $p['real_addr'], 50);
    ui_efs();
    ui_etfs();

    ui_stfs('Родители');
    ui_sfs('Отец');
    ui_text('reg', 'f_surname', 'Фамилия', $p['f_surname'], 50);
    ui_text('reg', 'f_name', 'Имя', $p['f_name'], 50);
    ui_text('reg', 'f_midname', 'Отчество', $p['f_midname'], 50);
    ui_text('reg', 'f_addr', 'Адрес', $p['f_addr'], 200);
    ui_text('reg', 'f_org','Место работы',$p['f_org'],200);
    ui_text('reg', 'f_pos','Должность',$p['f_pos'],200);
    ui_text('reg', 'f_phone','Телефон',$p['f_phone'],200);
    ui_efs();
    ui_sptfs();
    ui_sfs('Мать');
    ui_text('reg', 'm_surname', 'Фамилия', $p['m_surname'], 50);
    ui_text('reg', 'm_name', 'Имя', $p['m_name'], 50);
    ui_text('reg', 'm_midname', 'Отчество', $p['m_midname'], 50);
    ui_text('reg', 'm_addr', 'Адрес', $p['m_addr'], 200);
    ui_text('reg', 'm_org','Место работы',$p['m_org'],200);
    ui_text('reg', 'm_pos','Должность',$p['m_pos'],200);
    ui_text('reg', 'm_phone','Телефон',$p['m_phone'],200);
    ui_efs();
    ui_etfs();


    ui_stfs('Образование');
    ui_sfs();
    ui_select('reg', 'inst_rank_id', 'Ранг УО', $options['inst_rank_id'], $p['inst_rank_id']);
    ui_select('reg', 'institution_id', 'Тип УО', $options['institution_id'], $p['institution_id']);
    ui_text('reg', 'institution_name', 'Название', $p['institution_name'], 50);
    ui_select('xcr', 'inst_city_rang', 'Ранг нп', $options['city_rang'], 0);
    ui_select('reg', 'inst_city_type', 'Тип нп', $options['subdiv'], $p['inst_city_type']);
    ui_text('reg', 'inst_city_name', 'Название нп', $p['inst_city_name'], 50);
    ui_select('reg', 'certificate_id', 'Документ', $options['certificate_id'], $p['certificate_id']);
    ui_text('reg', 'certificate_name', 'Серия Номер', $p['certificate_name'], 50);
    ui_date_edit('reg', 'cert_date', 'Дата выдачи', $p['cert_date']);
    ui_text('reg', 'certificate_sum', 'Балл', $p['certificate_sum'], 3);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_bit_sel('edu', 'education', 'Образование', $options['education_id'], $p['education_id']);
    ui_efs();
    ui_etfs();
    
    ui_stfs();
    ui_sfs();
    ui_select('reg', 'course_id', 'Курсы', $options['course_id'], $p['course_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select('reg', 'grade_id', 'Награды', $options['grade_id'], $p['grade_id']);
    ui_efs();
    ui_etfs();
    
    ui_stfs('Награды по предметам');
    ui_sfs();
    ui_select('reg','subgrade_l_id','Язык',$options['subgrade_id'],$p['subgrade_l_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg','subgrade_b_id','Биология',$options['subgrade_id'],$p['subgrade_b_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg','subgrade_c_id','Химия',$options['subgrade_id'],$p['subgrade_c_id']);
    ui_efs();
    ui_etfs();
    
    ui_stfs('Централизованное тестирование');
    ui_sfs('Язык');
    ui_select('reg', 'lct_id', 'Тип', $options['ct_id'], $p['lct_id']);
    ui_text('reg', 'lct_sum', 'Балл', $p['lct_sum'], 3);
    ui_text('reg', 'lct_sn', 'Серия', $p['lct_sn'], 8);
    ui_text('reg', 'lct_xn', 'Номер', $p['lct_xn'], 7);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Биология');
    ui_select('reg', 'bct_id', 'Тип', $options['ct_id'], $p['bct_id']);
    ui_text('reg', 'bct_sum', 'Балл', $p['bct_sum'], 3);
    ui_text('reg', 'bct_sn', 'Серия', $p['bct_sn'], 8);
    ui_text('reg', 'bct_xn', 'Номер', $p['bct_xn'], 7);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Химия');
    ui_select('reg', 'cct_id', 'Тип', $options['ct_id'], $p['cct_id']);
    ui_text('reg', 'cct_sum', 'Балл', $p['cct_sum'], 3);
    ui_text('reg', 'cct_sn', 'Серия', $p['cct_sn'], 8);
    ui_text('reg', 'cct_xn', 'Номер', $p['cct_xn'], 7);
    ui_efs();
    ui_etfs();
    
    ui_stfs('Общие отметки');
    ui_sfs('Языки');
    ui_select('reg', 'cur_lang_id', 'Основной', $options['language_id'], $p['cur_lang_id']);
    ui_select('reg', 'cur_lang_level', 'Уровень', $options['cur_lang_level'], $p['cur_lang_level']);
    ui_text('reg', 'lang_grade', 'Оценка', $p['lang_grade'], 5);
    ui_efs();
    ui_sfs();
    ui_bit_sel('lang', 'language_set', 'Языки', $options['language_id'], $p['language_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('Льготы');
    ui_bit_sel('bnf', 'benefit_set', 'Льготы', $options['benefit_id'], $p['benefit_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('Членство');
    ui_bit_sel('com', 'community_set', 'Организации', $options['community_id'], $p['community_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('Другое');
    ui_bit_sel('oth', 'other_set', 'Документы', $options['other_id'], $p['other_set']);
    ui_efs();
    ui_etfs();
    
    
    ui_stfs('Дополнительные данные');
    ui_sfs();
    ui_select('reg', 'experience_id', 'Стаж', $options['experience_id'], $p['experience_id']);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_select('reg', 'try_id', 'Попытки', $options['try_id'], $p['try_id']);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    //ui_select('reg', 'military_id', 'Военка', $options['military_id'], $p['military_id']);
    ui_select('reg', 'invalid_id', 'Инвалидность', $options['invalid_id'], $p['invalid_id']);
    
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_select('reg', 'hostel_id', 'Общага', $options['hostel_id'], $p['hostel_id']);
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text('reg', 'live_num', 'Справка МЖ', $p['live_num'], 100);
    ui_date_edit('reg', 'live_date', 'Дата выдачи', $p['live_date']);
    ui_text('reg', 'live_data', 'Выдан', $p['live_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'aes_num', 'Уд. ЧАЭС', $p['aes_num'], 100);
    ui_date_edit('reg', 'aes_date', 'Дата выдачи', $p['aes_date']);
    ui_date_edit_future('reg', 'aes_end_date','Дата окончания',$p['aes_end_date']);
    ui_text('reg', 'aes_data', 'Выдан', $p['aes_data'], 100);
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text('reg', 'uzo_num', 'УЗО', $p['uzo_num'], 100);
    ui_date_edit('reg', 'uzo_date', 'Дата выдачи', $p['uzo_date']);
    ui_text('reg', 'uzo_data', 'Выдан', $p['uzo_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'inv_num', 'Инв.', $p['inv_num'], 100);
    ui_date_edit('reg', 'inv_date', 'Дата выдачи', $p['inv_date']);
    ui_date_edit_future('reg', 'inv_end_date', 'Дата окончания', $p['inv_end_date']);
    ui_text('reg', 'inv_data', 'Выдан', $p['inv_data'], 100);
    ui_efs();
    ui_etfs();
    if ($t == 'search')
        ui_sc('Поиск');
ui_script('js/edit.js?2');


    ui_ef0();
}
