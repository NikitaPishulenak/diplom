<?php

function form_draw($p, $t) {
    require 'options.php';
    require 'person.column.php';
    ui_sf();


    if ($t == 'search')
        ui_sc('Поиск');
    if ($t == 'default')
        ui_sc('Сохранить');
    ui_hr();
    ui_stfs();
    ui_sfs();
    if ($t != 'create' && $t != 'search') {
        ui_text_view('', '', 'Дата создания', $p['ctime']);
        ui_text_view('', '', 'Дата валидации', $p['vtime']);
        ui_text_view('', '', 'Дата модификации', $p['atime']);
        ui_text_view('', '', 'Дата удаления', $p['xtime']);
    }
    if ($t == 'search') {
        ui_text('reg', 'delo_name', 'Номер дела', $p['delo_name'], 13);
        ui_text('reg', 'uq', 'Уникальный отпечаток', $p['uq'], 13);
        ui_text('tvw', 'at', 'Валидный срез', '', 50);
        ui_text('tlw', 'at', 'Живой срез', '', 50);
    }
    ui_efs();
    ui_sptfs();
    ui_sfs();

    if ($t == 'create' || $t == 'edit') {
        ui_hidden('reg', 'uq', $p['uq']);
        ui_hidden('reg', 'auid', $p['auid']);
        ui_hidden('reg', 'cuid', $p['cuid']);
        ui_hidden('reg', 'vuid', $p['vuid']);
        ui_hidden('reg', 'xuid', $p['xuid']);
        ui_hidden('reg', 'filltime', $p['filltime']);
    }
    /*
      ui_select_view('Регистратор', $options['users_by_name'], $p['cuid']);
      ui_select_view('Валидатор', $options['users_by_name'], $p['vuid']);
      ui_select_view('Редактор', $options['users_by_name'], $p['auid']);
      ui_select_view('Закрыт', $options['users_by_name'], $p['xuid']);
     */
    if ($t == 'search') {
        ui_select('reg', 'cuid', 'Регистратор', $options['users_by_name'], $p['cuid']);
        ui_select('reg', 'vuid', 'Валидатор', $options['users_by_name'], $p['vuid']);
        ui_select('reg', 'auid', 'Редактор', $options['users_by_name'], $p['auid']);
        ui_select('reg', 'xuid', 'Закрыт', $options['users_by_name'], $p['xuid']);
    }
    ui_efs();
    ui_etfs();
    ui_stfs('Конкурс');
    ui_sfs();
    if ($t == 'edit' && $p['state_id'] != 4) {
        ui_select_view('Факультет', $options['faculty'], $p['faculty']);
        ui_select_view('Форма обучения', $options['time_form'], $p['time_form_id']);
        ui_select_view('Форма обучения', $options['ef'], $p['edu_form']);
        ui_select_view('Конкурс', $options['target'], $p['target']);
        ui_select_view('Тип Конкурса', $options['target_type'], $p['target_type']);
        ui_select_view('Тип Целевого', $options['target_cell'], $p['target_cell']);
        ui_select_view('Целевая область', $options['region_by'], $p['region_cell']);
    } else {
        ui_select('reg', 'faculty', 'Факультет', $options['faculty'], $p['faculty']);
        ui_select('reg', 'time_form_id', 'Форма обучения', $options['time_form'], $p['time_form_id']);
        ui_select('reg', 'edu_form', 'Форма обучения', $options['ef'], $p['edu_form']);
        ui_select('reg', 'target', 'Конкурс', $options['target'], $p['target']);
        ui_select('reg', 'target_type', 'Тип Конкурса', $options['target_type'], $p['target_type']);
        ui_select('reg', 'target_cell', 'Тип Целевого', $options['target_cell'], $p['target_cell']);
        ui_select('reg', 'region_cell', 'Целевая область', $options['region_by'], $p['region_cell']);
    }
    ui_efs();
    ui_sptfs();
    ui_sfs();
    if ($t == 'search') {
        ui_select('reg', 'state_id', 'Состояние', $options['state_id'], $p['state_id']);
        ui_select('reg', 'out_time_form_id', 'Форма обучения', $options['time_form'], $p['out_time_form_id']);
        ui_select('reg', 'out_edu_form', 'Форма зачисления', $options['ef'], $p['out_edu_form']);
        ui_select('reg', 'out_target', 'Конкурс зачисления', $options['target'], $p['out_target']);
        ui_select('reg', 'out_target_type', 'Тип К Зачисления', $options['target_type'], $p['out_target_type']);

        ui_check('opt', 'dropnovice', 'Убрать неподтверждённые', 1);
        ui_check('opt', 'dropinvalid', 'Убрать недействующие', 1);
    } else {
        ui_hidden('reg', 'state_id', $p['state_id']);
    }
    ui_efs();
    ui_etfs();

    ui_stfs('Личные и паспортные данные');
    ui_sfs();
    ui_text('reg', 'surname', 'Фамилия', $p['surname'], 50);
    ui_text('reg', 'name', 'Имя', $p['name'], 50);
    ui_text('reg', 'midname', 'Отчество', $p['midname'], 50);
    ui_select('reg', 'sex', 'Пол', $options['sex'], $p['sex']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'serial', 'Серия и номер', $p['serial'], 50);
    ui_text('reg', 'private', 'Личный номер', $p['private'], 50);
    ui_select('reg', 'natio', 'Гражданство', $options['natio'], $p['natio']);
    // дата
    ui_date_edit('reg', 'birthday', 'Дата рождения', $p['birthday']);
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
    ui_text('reg', 'real_addr', 'Адрес', $p['real_addr'], 50);
    ui_efs();
    ui_etfs();
    ui_stfs('Образование');
    ui_sfs();
    ui_select('reg', 'institution_id', 'Тип УО', $options['institution_id'], $p['institution_id']);
    ui_text('reg', 'institution_name', 'Название', $p['institution_name'], 50);

    ui_select('reg', 'inst_city_type', 'Тип нп', $options['subdiv'], $p['inst_city_type']);
    ui_text('reg', 'inst_city_name', 'Название нп', $p['inst_city_name'], 50);
    ui_select('reg', 'certificate_id', 'Документ', $options['certificate_id'], $p['certificate_id']);
    ui_text('reg', 'certificate_name', 'Серия Номер', $p['certificate_name'], 50);
    ui_date_edit('reg', 'cert_date', 'Дата выдачи', $p['cert_date']);
    ui_text('reg', 'certificate_sum', 'Балл', $p['certificate_sum'], 3);

    ui_efs();
    ui_sptfs();
    ui_sfs();
    if ($t == 'search') {
        ui_bit_sel('edu', 'education', 'Образование', $options['education_id'], $p['education_id']);
    } else {
        ui_bit_set('edu', 'education', 'Образование', $options['education_id'], $p['education_id']);
    }

    ui_efs();
    ui_etfs();
    ui_stfs('Централизованное тестирование');
    ui_sfs();
    ui_select('reg', 'lct_id', 'Тип', $options['ct_id'], $p['lct_id']);
    ui_text('reg', 'lct_sum', 'Балл', $p['lct_sum'], 50);
    ui_text('reg', 'lct_sn', 'Серия', $p['lct_sn'], 50);
    ui_text('reg', 'lct_xn', 'Номер', $p['lct_xn'], 50);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg', 'cct_id', 'Тип', $options['ct_id'], $p['cct_id']);
    ui_text('reg', 'cct_sum', 'Балл', $p['cct_sum'], 50);
    ui_text('reg', 'cct_sn', 'Серия', $p['cct_sn'], 50);
    ui_text('reg', 'cct_xn', 'Номер', $p['cct_xn'], 50);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg', 'bct_id', 'Тип', $options['ct_id'], $p['bct_id']);
    ui_text('reg', 'bct_sum', 'Балл', $p['bct_sum'], 50);
    ui_text('reg', 'bct_sn', 'Серия', $p['bct_sn'], 50);
    ui_text('reg', 'bct_xn', 'Номер', $p['bct_xn'], 50);
    ui_efs();
    ui_etfs();
    ui_stfs('Общие отметки');
    ui_sfs();
    if ($t == 'search') {
        ui_bit_sel('lang', 'language_set', 'Языки', $options['language_id'], $p['language_set']);
    } else {
        ui_bit_set('lang', 'language_set', 'Языки', $options['language_id'], $p['language_set']);
    }
    ui_efs();
    ui_sptfs4();
    ui_sfs();

    if ($t == 'search') {
        ui_bit_sel('bnf', 'benefit_set', 'Льготы', $options['benefit_id'], $p['benefit_set']);
    } else {
        ui_bit_set('bnf', 'benefit_set', 'Льготы', $options['benefit_id'], $p['benefit_set']);
    }
    ui_efs();
    ui_sptfs4();
    ui_sfs();

    if ($t == 'search') {
        ui_bit_sel('com', 'community_set', 'Организации', $options['community_id'], $p['community_set']);
    } else {
        ui_bit_set('com', 'community_set', 'Организации', $options['community_id'], $p['community_set']);
    }
    ui_efs();
    ui_sptfs4();
    ui_sfs();

    if ($t == 'search') {
        ui_bit_sel('oth', 'other_set', 'Документы', $options['other_id'], $p['other_set']);
    } else {
        ui_bit_set('oth', 'other_set', 'Документы', $options['other_id'], $p['other_set']);
    }
    ui_efs();
    ui_etfs();
    ui_stfs('Дополнительные данные');
    ui_sfs();
    ui_select('reg', 'experience_id', 'Опыт', $options['experience_id'], $p['experience_id']);
    ui_select('reg', 'try_id', 'Попытки', $options['try_id'], $p['try_id']);
    ui_select('reg', 'military_id', 'Военка', $options['military_id'], $p['military_id']);
    ui_select('reg', 'hostel_id', 'Общага', $options['hostel_id'], $p['hostel_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select('reg', 'course_id', 'Курсы', $options['course_id'], $p['course_id']);
    ui_select('reg', 'grade_id', 'Награды', $options['grade_id'], $p['grade_id']);
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
    ui_text('reg', 'inv_data', 'Выдан', $p['inv_data'], 100);
    ui_efs();
    ui_etfs();
    if ($t == 'search')
        ui_sc('Поиск');
    if ($t == 'create')
        ui_sc('Создать');
    if ($t == 'default')
        ui_sc('Сохранить');
    if ($t == 'edit')
        ui_sc('Изменить');
    ui_ef0();
}
