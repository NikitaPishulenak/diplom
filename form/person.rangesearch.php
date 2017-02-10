<?php
function form_draw($p,$t)
{
    include 'options.php';
    ui_sf();
    ui_sc('Поиск');
    ui_stfs('Технические Даты');
    ui_sfs('Начиная(>)');
    ui_date_edit('reg', 'ctime_from','Создано' , '');
    ui_date_edit('reg', 'vtime_from','Проверено' , '');
    ui_date_edit('reg', 'atime_from','Редактировано' , '');
    ui_date_edit('reg', 'xtime_from','Закрыто' , '');
    ui_text_view('', '', 'Примичание','Время: 00:00');
    ui_efs();
    ui_sptfs3();
    ui_sfs('Заканчивая(<)');
    
    ui_date_edit('reg', 'ctime_less','Создано' , '');
    ui_date_edit('reg', 'vtime_less','Проверено' , '');
    ui_date_edit('reg', 'atime_less','Редактировано' , '');
    ui_date_edit('reg', 'xtime_less','Закрыто' , '');
    ui_text_view('', '', 'Примичание','Время: 00:00');
    ui_efs();
    ui_sptfs3();
    ui_sfs('А также');
    ui_select('reg', 'cuid', 'Регистратор', $options['users_by_name'], $p['cuid']);
    ui_select('reg', 'vuid', 'Валидатор', $options['users_by_name'], $p['vuid']);
    ui_select('reg', 'auid', 'Редактор', $options['users_by_name'], $p['auid']);
    ui_select('reg', 'xuid', 'Закрыт', $options['users_by_name'], $p['xuid']);
    ui_select_range('rng','total','Балл');
    ui_efs();
    ui_etfs();
    
    ui_stfs('Персональная');
    ui_sfs('Начиная(>)');
    ui_date_edit('reg', 'birthday_from', 'Дата рождения', '');
    ui_date_edit('reg', 'authority_date_from', 'Дата выдачи (п)', '');
    ui_date_edit('reg', 'cert_date_from', 'Дата выдачи (уо)', '');
    ui_date_edit('reg', 'live_date_from', 'Дата выдачи (мж)', '');
    ui_date_edit('reg', 'aes_date_from', 'Дата выдачи (ч)', '');
    ui_date_edit('reg', 'uzo_date_from', 'Дата выдачи (цд)', '');
    ui_date_edit('reg', 'inv_date_from', 'Дата выдачи (и)', '');
    ui_date_edit('reg', 'order_date_from', 'Дата приказа ', '');
    ui_date_edit('reg', 'proto_date_from', 'Дата протокола', '');
    ui_date_edit('reg', 'arrive_date_from', 'Дата прибытия', '');
    ui_efs();
    ui_sptfs3();
    ui_sfs('Заканчивая(<)');
    ui_date_edit('reg', 'birthday_less', 'Дата рождения', '');
    ui_date_edit('reg', 'authority_date_less', 'Дата выдачи(п)', '');
    ui_date_edit('reg', 'cert_date_less', 'Дата выдачи (уо)', '');
    ui_date_edit('reg', 'live_date_less', 'Дата выдачи (мж)', '');
    ui_date_edit('reg', 'aes_date_less', 'Дата выдачи (ч)', '');
    ui_date_edit('reg', 'uzo_date_less', 'Дата выдачи (цд)', '');
    ui_date_edit('reg', 'inv_date_less', 'Дата выдачи (и)', '');
    ui_date_edit('reg', 'order_date_less', 'Дата приказа ', '');
    ui_date_edit('reg', 'proto_date_less', 'Дата протокола', '');
    ui_date_edit('reg', 'arrive_date_less', 'Дата прибытия', '');
    ui_efs();
    ui_sptfs3();
    ui_sfs('Баллы');
    ui_select_range('rng','certificate_sum','Балл (a)');
    ui_select_range('rng','lct_sum','Балл (я)');
    ui_select_range('rng','cct_sum','Балл (х)');
    ui_select_range('rng','bct_sum','Балл (б)');
    ui_efs();
    ui_etfs();
    
    ui_sc('Поиск');
    ui_ef0();
}