<?php

function form_view($p, $t) {
    require 'form/options.php';
    require 'core/libtargetacl.php';
    if (!checkTargetAcl($p['faculty'], $p['time_form_id'], $p['edu_form'], $p['target'], $p['target_type'], $p['target_cell'], $p['region_cell'])) {
        ui_cm("Такой конкурс недопустим.");
    }
    if (db_cv('db_person','uq',"state_id=1 and uq='${p['uq']}'")>1)
    {
	ui_cm('Возможен дубль.');
    }
    if (db_cv('db_person','serial',"state_id=1 and serial='${p['serial']}'")>1)
    {
	ui_cm('Возможен дубль.');
    }

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
    ui_stds();
    ui_stfs('Техническая информация');
    ui_sfs();
    ui_text_view('', '', 'Дата создания', $p['ctime']);
    ui_text_view('', '', 'Дата валидации', $p['vtime']);
    ui_text_view('', '', 'Дата модификации', $p['atime']);
    ui_text_view('', '', 'Дата удаления', $p['xtime']);
    ui_efs();
    ui_sptfs();
    ui_sfs();



    ui_select_view('Регистратор', $options['users_by_name'], $p['cuid']);
    ui_select_view('Валидатор', $options['users_by_name'], $p['vuid']);
    ui_select_view('Редактор', $options['users_by_name'], $p['auid']);
    ui_select_view('Закрыт', $options['users_by_name'], $p['xuid']);

    ui_efs();
    ui_etfs();
    ui_stfs('Конкурс');
    ui_sfs('Поступление');

    ui_select_view('Факультет', $options['faculty'], $p['faculty']);
    ui_select_view('Форма получения', $options['time_form'], $p['time_form_id']);
    ui_select_view('Форма обучения', $options['ef'], $p['edu_form']);
    ui_select_view('Конкурс', $options['target'], $p['target']);
    ui_select_view('Тип Конкурса', $options['target_type'], $p['target_type']);
    ui_select_view('Тип Целевого', $options['target_cell'], $p['target_cell']);
    ui_select_view('Целевая область', $options['region_by'], $p['region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Зачисление');
    ui_select_view('Состояние', $options['state_id'], $p['state_id']);
    ui_select_view('Форма обучения', $options['time_form'], $p['out_time_form_id']);
    ui_select_view('Форма зачисления', $options['ef'], $p['out_edu_form']);
    ui_select_view('Конкурс зачисления', $options['target'], $p['out_target']);
    ui_select_view('Тип К Зачисления', $options['target_type'], $p['out_target_type']);
    ui_select_view('Тип Ц Зачисления', $options['target_cell'], $p['out_target_cell']);
    ui_select_view('Цел. обл. Зачисления', $options['region_cell'], $p['out_region_cell']);
	ui_text_view('','','<a href="add_stud.php?id='.$p['id'].'&type=add">Зачислить</a>','');
    ui_text_view('','','<a href="add_stud.php?id='.$p['id'].'&type=kill">НЕ Зачислить</a>','');

    ui_efs();
    ui_sptfs3();
    ui_sfs('Статус');
    ui_select_view('Доп заявления', $options['dual_mode_id'], $p['dual_mode_set']);
    ui_efs();
    ui_sfs('');
    ui_bit_set('wb', 'wouldbe_id', '', $options['wouldbe_id'], $p['wouldbe_id']);
    ui_bit_set('xc', 'xclass_id', '', $options['xclass_id'], $p['xclass_id']);
    ui_bit_set('st', 'student_id', '', $options['student_id'], $p['student_id']);


    ui_efs();
    ui_sfs();
    ui_text_view('', '', 'Уникальный отпечаток', $p['uq']);
    ui_select_view('Конкурс участия',$options['target_use_id'],$p['target_use_id']);
    ui_efs();

    ui_etfs();
    ui_stfs('ПО');
    ui_sfs();
    ui_select_view('База',$options['po_base_id'],$p['po_base_id']);
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
    ui_text_view('reg', 'surname', 'Фамилия', $p['surname'], 50);
    ui_text_view('reg', 'name', 'Имя', $p['name'], 50);
    ui_text_view('reg', 'midname', 'Отчество', $p['midname'], 50);
    ui_select_view('Пол', $options['sex'], $p['sex']);
    ui_text_view('reg', 'birthday', 'Дата рождения', ui_date4view($p['birthday']));
    ui_efs();
    ui_sptfs();
    ui_sfs();
    $mark_serial='';
    if(strlen($p['serial'])!=9 && $p['natio']==1)
    {
	$mark_serial='color:red';
    }
    if(strlen($p['serial'])!=11 && $p['natio']==2)
    {
	$mark_serial='color:red';
    }
    ui_text_view('reg', 'serial', '<span style="' . $mark_serial . '">Серия и номер</span>', $p['serial'], 50);
    $mark_private='';
    if(strlen($p['private'])!=14 && $p['natio']==1)
    {
	$mark_private='color:red';
    }
    if(strlen($p['private'])>0 && $p['natio']==2)
    {
	$mark_private='color:red';
    }

    ui_text_view('reg', 'private', '<span style="' . $mark_private . '">Личный номер</span>', $p['private'], 50);
    ui_select_view('Гражданство', $options['natio'], $p['natio']);
    // дата
    ui_text_view('reg', 'birthday', 'Выдан', $p['authority']);
    ui_text_view('reg', 'birthday', 'Дата выдачи', ui_date4view($p['authority_date']));
    ui_efs();
    ui_etfs();
    ui_stfs('Место жительства');
    ui_sfs();
    ui_select_view('Страна', $options['country'], $p['country']);
    ui_select_view('Область', $options['region_by'], $p['region_by']);
    ui_text_view('reg', 'region_text', 'Область(текст)', $p['region_text'], 50);
    ui_text_view('reg', 'area', 'Район', $p['area'], 50);
    ui_select_view('Тип нп', $options['subdiv'], $p['subdiv']);
    ui_text_view('reg', 'city_name', 'Название нп', $p['city_name'], 50);
    ui_text_view('reg', 'zip', 'Индекс', $p['zip'], 50);
    ui_text_view('reg', 'microarea', 'Микрорайон', $p['microarea'], 50);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text_view('reg', 'street', 'Улица', $p['street'], 50);
    ui_text_view('reg', 'house', 'Дом', $p['house'], 50);
    ui_text_view('reg', 'house_part', 'Корпус', $p['house_part'], 50);
    ui_text_view('reg', 'room', 'Квартира', $p['room'], 50);
    ui_text_view('reg', 'phone', 'Домашний', $p['phone'], 50);
    ui_text_view('reg', 'mobile', 'Мобильный', $p['mobile'], 50);
    ui_text_view('reg', 'email', 'E-mail', $p['email'], 50);
    ui_text_view('reg', 'real_addr', 'Адрес прописки', $p['real_addr'], 50);
    ui_efs();
    ui_etfs();
    ui_par($p['live_addr']);
    ui_etds();
    ui_stds();
    ui_stfs('Родители');
    ui_sfs('Отец');
    ui_text_view('reg', 'f_surname', 'Фамилия', $p['f_surname'], 50);
    ui_text_view('reg', 'f_name', 'Имя', $p['f_name'], 50);
    ui_text_view('reg', 'f_midname', 'Отчество', $p['f_midname'], 50);
    ui_text_view('reg', 'f_addr', 'Адрес', $p['f_addr'], 200);
    ui_text_view('reg', 'f_org','Место работы',$p['f_org'],200);
    ui_text_view('reg', 'f_pos','Должность',$p['f_pos'],200);
    ui_text_view('reg', 'f_phone','Телефон',$p['f_phone'],200);

    ui_efs();
    ui_sptfs();
    ui_sfs('Мать');
    ui_text_view('reg', 'm_surname', 'Фамилия', $p['m_surname'], 50);
    ui_text_view('reg', 'm_name', 'Имя', $p['m_name'], 50);
    ui_text_view('reg', 'm_midname', 'Отчество', $p['m_midname'], 50);
    ui_text_view('reg', 'm_addr', 'Адрес', $p['m_addr'], 200);
    ui_text_view('reg', 'm_org','Место работы',$p['m_org'],200);
    ui_text_view('reg', 'm_pos','Должность',$p['m_pos'],200);
    ui_text_view('reg', 'm_phone','Телефон',$p['m_phone'],200);

    ui_efs();
    ui_etfs();
    ui_etds();
    ui_stds();
    ui_stfs('Образование');
    ui_sfs();
    ui_select_view('Ранг УО', $options['inst_rank_id'], $p['inst_rank_id']);
    ui_select_view('Тип УО', $options['institution_id'], $p['institution_id']);
    ui_text_view('reg', 'institution_name', 'Название', $p['institution_name'], 50);
    ui_select_view('Тип нп', $options['subdiv'], $p['inst_city_type']);
    ui_text_view('reg', 'inst_city_name', 'Название н.п.', $p['inst_city_name'], 50);
    ui_select_view('Документ', $options['certificate_id'], $p['certificate_id']);
    ui_text_view('reg', 'certificate_name', 'Серия Номер', $p['certificate_name'], 50);
    ui_text_view('reg', 'cert_date', 'Дата выдачи', ui_date4view($p['cert_date']));
    ui_text_view('reg', 'certificate_sum', 'Балл', $p['certificate_sum'], 3);

    ui_efs();
    ui_sptfs();
    ui_sfs();

    ui_bit_set('edu', 'education', 'Образование', $options['education_id'], $p['education_id']);
    ui_tv('reg', 'institution_name_full', 'Полное название УО', $p['institution_name_full']);
    
    ui_efs();
    ui_etfs();
    
    ui_stfs('Награды по предметам');
    ui_sfs();
    ui_select_view('Язык',$options['subgrade_id'],$p['subgrade_l_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select_view('Биология',$options['subgrade_id'],$p['subgrade_b_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select_view('Химия',$options['subgrade_id'],$p['subgrade_c_id']);
    ui_efs();
    ui_etfs();

    
    ui_stfs('Централизованное тестирование / Баллы');
    ui_sfs('Язык');
    ui_select_view('Тип', $options['ct_id'], $p['lct_id']);
    ui_text_view('reg', 'lct_sum', 'Балл', $p['lct_sum'], 50);
    ui_text_view('reg', 'lct_sn', 'Серия', $p['lct_sn'], 50);
    ui_text_view('reg', 'lct_xn', 'Номер', $p['lct_xn'], 50);
    ui_efs();
    ui_sptfs3();
    ui_sfs('Биология');
    ui_select_view('Тип', $options['ct_id'], $p['bct_id']);
    ui_text_view('reg', 'bct_sum', 'Балл', $p['bct_sum'], 50);
    ui_text_view('reg', 'bct_sn', 'Серия', $p['bct_sn'], 50);
    ui_text_view('reg', 'bct_xn', 'Номер', $p['bct_xn'], 50);
    ui_efs();


    ui_sptfs3();
    ui_sfs('Химия');
    ui_select_view('Тип', $options['ct_id'], $p['cct_id']);
    ui_text_view('reg', 'cct_sum', 'Балл', $p['cct_sum'], 50);
    ui_text_view('reg', 'cct_sn', 'Серия', $p['cct_sn'], 50);
    ui_text_view('reg', 'cct_xn', 'Номер', $p['cct_xn'], 50);
    ui_efs();


    ui_etfs();
    ui_etds();
    ui_stds();
    ui_stfs('Общие отметки');
    ui_sfs('Языки');
    ui_select_view('Основной', $options['language_id'], $p['cur_lang_id']);
    ui_select_view('Уровень', $options['cur_lang_level'], $p['cur_lang_level']);
    ui_text_view('reg','lang_grade','Оценка',$p['lang_grade'],3);
    ui_efs();
    ui_sfs();

    ui_bit_set('lang', 'language_set', 'Языки', $options['language_id'], $p['language_set']);

    ui_efs();
    ui_sptfs4();
    ui_sfs('Льготы');


    ui_bit_set('bnf', 'benefit_set', 'Льготы', $options['benefit_id'], $p['benefit_set']);

    ui_efs();
    ui_sptfs4();
    ui_sfs('Членство');


    ui_bit_set('com', 'community_set', 'Организации', $options['community_id'], $p['community_set']);

    ui_efs();
    ui_sptfs4();
    ui_sfs('Другие');


    ui_bit_set('oth', 'other_set', 'Документы', $options['other_id'], $p['other_set']);

    ui_efs();
    ui_etfs();
    ui_etds();
    ui_stds();
    ui_stfs('Общие отметки');
    ui_sfs();
    ui_select_view('Стаж', $options['experience_id'], $p['experience_id']);
    ui_select_view('Попытки', $options['try_id'], $p['try_id']);
    //ui_select_view('Военка', $options['military_id'], $p['military_id']);
    ui_select_view('Инвалидность', $options['invalid_id'], $p['invalid_id']);
    ui_select_view('Общежитие', $options['hostel_id'], $p['hostel_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select_view('Курсы', $options['course_id'], $p['course_id']);
    ui_select_view('Награды', $options['grade_id'], $p['grade_id']);
    ui_efs();
    ui_etfs();

    ui_stfs('Справки');
    ui_sfs('');
    ui_text_view('reg', 'live_num', 'Справка МЖ', $p['live_num'], 100);
    ui_text_view('reg', 'live_date', 'Дата выдачи', ui_date4view($p['live_date']));
    ui_text_view('reg', 'live_data', 'Выдан', $p['live_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs('');
    ui_text_view('reg', 'aes_num', 'Уд. ЧАЭС', $p['aes_num'], 100);
    ui_text_view('reg', 'aes_date', 'Дата выдачи', ui_date4view($p['aes_date']));
    ui_text_view('reg', 'aes_date', 'Дата окончания', ui_date4view($p['aes_end_date']));
    ui_text_view('reg', 'aes_data', 'Выдан', $p['aes_data'], 100);
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text_view('reg', 'uzo_num', 'УЗО', $p['uzo_num'], 100);
    ui_text_view('reg', 'uzo_date', 'Дата выдачи', ui_date4view($p['uzo_date']));
    ui_text_view('reg', 'uzo_data', 'Выдан', $p['uzo_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text_view('reg', 'inv_num', 'Инв.', $p['inv_num'], 100);
    ui_text_view('reg', 'inv_date', 'Дата выдачи', ui_date4view($p['inv_date']));
    ui_text_view('reg', 'inv_date', 'Дата окончания', ui_date4view($p['inv_end_date']));
    ui_text_view('reg', 'inv_data', 'Выдан', $p['inv_data'], 100);
    ui_efs();
    ui_etfs();
    ui_etds();
    ui_etabs();
}
