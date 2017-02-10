<?php

function form_draw($p, $t) {
    include 'options.php';

//    ui_blink('Обновить страницу', 'javascript:fuseValues()');
    ui_sf();
    ui_stabs();
    ui_tabh(
            array(
                'Конкурс',
                'Паспорт',
                'Родители',
                'Образование/ЦТ',
                'Языки/льготы',
                'Отметки/справки',
            )
    );
    ui_hidden('reg', 'uq', $p['uq']);
    ui_hidden('reg', 'auid', $p['auid']);
    ui_hidden('reg', 'cuid', $p['cuid']);
    ui_hidden('reg', 'vuid', $p['vuid']);
    ui_hidden('reg', 'xuid', $p['xuid']);
    ui_hidden('reg', 'filltime', $p['filltime']);
    ui_hidden('reg', 'state_id', $p['state_id']);
    ui_stds();
    ui_stfs('Конкурс');
    ui_sfs();
    ui_select('reg', 'faculty', 'Факультет', $options['faculty'], $p['faculty']);
    ui_select('reg', 'time_form_id', 'Форма получения', $options['time_form'], $p['time_form_id']);
    ui_select('reg', 'edu_form', 'Форма обучения', $options['ef'], $p['edu_form']);
    ui_select('reg', 'target', 'Конкурс', $options['target'], $p['target']);
    ui_select('reg', 'target_type', 'Тип Конкурса', $options['target_type'], $p['target_type']);
    ui_select('reg', 'target_cell', 'Тип Целевого', $options['target_cell'], $p['target_cell']);
    ui_select('reg', 'region_cell', 'Целевая область', $options['region_by'], $p['region_cell']);
    ui_efs();
    ui_sptfs();
    ui_sfs();


    ui_select('reg', 'dual_mode_set', 'Доп заявления', $options['dual_mode_id'], $p['dual_mode_set']);
    ui_efs();
    ui_sfs();
    ui_bit_set('xc', 'xclass_id', '', $options['xclass_id'], $p['xclass_id']);
    ui_bit_set('wb', 'wouldbe_id', '', $options['wouldbe_id'], $p['wouldbe_id']);
    ui_efs();
    ui_etfs();
    ui_stfs('ПО');
    ui_sfs();
    ui_select('reg','po_base_id','База',$options['po_base_id'],$p['po_base_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_bit_set('po','po_lang_id','',$options['po_lang_id'],$p['po_lang_set']);
    ui_efs();
    ui_etfs();


    ui_etds();
    ui_stds();
    
    
    ui_stfs('Личные и паспортные данные');
    ui_sfs();
    ui_text('reg', 'surname', 'Фамилия', $p['surname'], 50);
    ui_text('reg', 'name', 'Имя', $p['name'], 50);
    ui_text('reg', 'midname', 'Отчество', $p['midname'], 50);
    ui_select('reg', 'sex', 'Пол', $options['sex'], $p['sex']);
    ui_date_edit_num('reg', 'birthday', 'Дата рождения', $p['birthday']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select('reg', 'natio', 'Гражданство', $options['natio'], $p['natio']);
    ui_text('reg', 'serial', 'Серия и номер', $p['serial'], 50);
    ui_text('reg', 'private', 'Личный номер', $p['private'], 50);

    // дата

    ui_text('reg', 'authority', 'Выдан', $p['authority'], 500);
    ui_date_edit_num('reg', 'authority_date', 'Дата выдачи', $p['authority_date']);
    ui_efs();
    ui_etfs();

    ui_stfs('Место жительства');
    ui_sfs();
    ui_select('reg', 'country', 'Страна', $options['country'], $p['country']);
    ui_select('reg', 'region_by', 'Область', $options['region_by'], $p['region_by']);
    ui_text('reg', 'region_text', 'Область(текст)', $p['region_text'], 50);
    ui_text('reg', 'area', 'Район', $p['area'], 50);
    ui_select('reg', 'subdiv', 'Тип нп', $options['subdiv'], $p['subdiv']);
    ui_text('reg', 'city_name', 'Название нп', $p['city_name'], 50);
    //ui_text('reg', 'zip', '<a style="margin:0" href="javascript:zip_use()">Индекс</a>', $p['zip'], 50);
    ui_text('reg', 'zip', 'Индекс', $p['zip'], 50);
    ui_text('reg', 'microarea', 'Микрорайон', $p['microarea'], 50);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'street', 'Улица', $p['street'], 50);
    ui_text('reg', 'house', 'Дом', $p['house'], 50);
    ui_text('reg', 'house_part', 'Корпус', $p['house_part'], 50);
    ui_text('reg', 'room', 'Квартира', $p['room'], 50);
    ui_text('reg', 'phone', '<a style="margin:0" href="javascript:phone_ui_use()">Домашний</a>', $p['phone'], 50);
    ui_text('reg', 'mobile', 'Мобильный', $p['mobile'], 50);
    ui_text('reg', 'email', 'E-mail', $p['email'], 50);
    ui_text('reg', 'real_addr', '<a style="margin:0" href="javascript:addr_calc()">Адрес прописки</a>', $p['real_addr'], 200);
    ui_efs();
    ui_etfs();

    ui_etds();
    ui_stds();
    ui_stfs('Родители');
    ui_sfs('Отец');
    ui_text('reg', 'f_surname', '<a style="margin:0" href="javascript:father_use()">Фамилия</a>', $p['f_surname'], 50);
    ui_text('reg', 'f_name', 'Имя', $p['f_name'], 50);
    ui_text('reg', 'f_midname', 'Отчество', $p['f_midname'], 50);
    ui_text('reg', 'f_addr', '<a style="margin:0" href="javascript:addr_fuse()">Адрес</a>', $p['f_addr'], 200);
    ui_text('reg', 'f_org','Место работы',$p['f_org'],200);
    ui_text('reg', 'f_pos','Должность',$p['f_pos'],200);
    ui_text('reg', 'f_phone','Телефон',$p['f_phone'],200);
    ui_efs();
    ui_sptfs();
    ui_sfs('Мать');
    ui_text('reg', 'm_surname', '<a style="margin:0" href="javascript:mother_use()">Фамилия</a>', $p['m_surname'], 50);
    ui_text('reg', 'm_name', 'Имя', $p['m_name'], 50);
    ui_text('reg', 'm_midname', 'Отчество', $p['m_midname'], 50);
    ui_text('reg', 'm_addr', '<a style="margin:0" href="javascript:addr_muse()">Адрес</a>', $p['m_addr'], 200);
    ui_text('reg', 'm_org','Место работы',$p['m_org'],200);
    ui_text('reg', 'm_pos','Должность',$p['m_pos'],200);
    ui_text('reg', 'm_phone','Телефон',$p['m_phone'],200);
    ui_efs();
    ui_etfs();
    ui_etds();
    ui_stds();
    ui_stfs('Образование');
    ui_sfs();
    ui_select('reg', 'inst_rank_id', 'Ранг УО', $options['inst_rank_id'], $p['inst_rank_id']);
    ui_select('reg', 'institution_id', 'Тип УО', $options['institution_id'], $p['institution_id']);
    ui_text('reg', 'institution_name', 'Название', $p['institution_name'], 200);

    ui_select('reg', 'inst_city_type', 'Тип нп', $options['subdiv'], $p['inst_city_type']);
    ui_text('reg', 'inst_city_name', 'Название нп', $p['inst_city_name'], 50);
    ui_select('reg', 'certificate_id', 'Документ', $options['certificate_id'], $p['certificate_id']);
    ui_text('reg', 'certificate_name', 'Серия Номер*', $p['certificate_name'], 50);
    ui_date_edit('reg', 'cert_date', 'Дата выдачи', $p['cert_date']);
    ui_text('reg', 'certificate_sum', '<a style="margin:0" href="javascript:calc_use()">Балл</a>', $p['certificate_sum'], 3);

    ui_efs();
    
    ui_sptfs();
    
    ui_sfs();
    ui_bit_set('edu', 'education', 'Образование', $options['education_id'], $p['education_id']);
    ui_ta('reg', 'institution_name_full', 'Полное название УО', $p['institution_name_full'], 300);
    
    ui_efs();
    ui_etfs();
    ui_par('* Пример А 1234567; АЗ 1234567;');
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
    ui_text('reg', 'lct_sn', 'Серия*', $p['lct_sn'], 8);
    ui_text('reg', 'lct_xn', 'Номер', $p['lct_xn'], 7);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Биология');
    ui_select('reg', 'bct_id', 'Тип', $options['ct_id'], $p['bct_id']);
    ui_text('reg', 'bct_sum', 'Балл', $p['bct_sum'], 3);
    ui_text('reg', 'bct_sn', 'Серия*', $p['bct_sn'], 8);
    ui_text('reg', 'bct_xn', 'Номер', $p['bct_xn'], 7);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Химия');
    ui_select('reg', 'cct_id', 'Тип', $options['ct_id'], $p['cct_id']);
    ui_text('reg', 'cct_sum', 'Балл', $p['cct_sum'], 3);
    ui_text('reg', 'cct_sn', 'Серия*', $p['cct_sn'], 8);
    ui_text('reg', 'cct_xn', 'Номер', $p['cct_xn'], 7);
    ui_efs();
    ui_etfs();
    ui_par('* Дефис в серии ставится автоматически');
    ui_etds();
    
    ui_stds();
    ui_stfs('Общие отметки');
    ui_sfs('Языки');
    ui_select('reg', 'cur_lang_id', 'Основной', $options['language_id'], $p['cur_lang_id']);
    ui_select('reg', 'cur_lang_level', 'Уровень', $options['cur_lang_level'], $p['cur_lang_level']);
    ui_text('reg','lang_grade','Оценка',$p['lang_grade'],3);
    ui_efs();
    ui_sfs();
    ui_bit_set('lang', 'language_set', 'Языки', $options['language_id'], $p['language_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('Льготы');
    ui_bit_set('bnf', 'benefit_set', 'Льготы', $options['benefit_id'], $p['benefit_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('Организации');
    ui_bit_set('com', 'community_set', 'Организации', $options['community_id'], $p['community_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('Другое');
    ui_bit_set('oth', 'other_set', 'Документы', $options['other_id'], $p['other_set']);
    ui_efs();
    ui_etfs();
    ui_etds();
    ui_stds();
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
    ui_select('reg', 'hostel_id', 'Общежитие', $options['hostel_id'], $p['hostel_id']);
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text('reg', 'live_num', 'Справка МЖ №', $p['live_num'], 100);
    ui_date_edit('reg', 'live_date', 'Дата выдачи', $p['live_date']);
    ui_text('reg', 'live_data', 'Выдан', $p['live_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'aes_num', 'Уд. ЧАЭС №', $p['aes_num'], 100);
    ui_date_edit('reg', 'aes_date', 'Дата выдачи', $p['aes_date']);
    ui_date_edit_future('reg', 'aes_end_date','Дата окончания',$p['aes_end_date']);
    ui_text('reg', 'aes_data', 'Выдан', $p['aes_data'], 100);
    
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text('reg', 'uzo_num', 'УЗО №', $p['uzo_num'], 100);
    ui_date_edit('reg', 'uzo_date', 'Дата выдачи', $p['uzo_date']);
    ui_text('reg', 'uzo_data', 'Выдан', $p['uzo_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'inv_num', 'Инв. №', $p['inv_num'], 100);
    ui_date_edit('reg', 'inv_date', 'Дата выдачи', $p['inv_date']);
    ui_date_edit_future('reg', 'inv_end_date', 'Дата окончания', $p['inv_end_date']);
    ui_text('reg', 'inv_data', 'Выдан', $p['inv_data'], 100);
    ui_efs();
    ui_etfs();
    ui_etds();
    
    ui_etabs();
    if ($t == 'create')
        ui_sc('Создать');
    
    ui_ef0();
}