<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC', 'control.dict_dump');
cr_logic();

$dt = array(
    'db_abby_monid',
    'db_acl',
    'db_applog',
    'db_balls',
    'db_benefit',
    'db_call',
    'db_certificate',
    'db_chain',
    'db_chid',
    'db_city_rang',
    'db_community',
    'db_country',
    'db_course',
    'db_ct',
    'db_ct_info',
    'db_dicttemp',
    'db_dual_mode',
    'db_education',
    'db_ef',
    'db_experience',
    'db_faculty',
    'db_field_macro',
    'db_files',
    'db_grade',
    'db_groups',
    'db_history',
    'db_hostel',
    'db_inst_rank',
    'db_institution',
    'db_inventory_doc',
    'db_keys',
    'db_lang_level',
    'db_language',
    'db_military',
    'db_month',
    'db_move_journal',
    'db_n',
    'db_nametown',
    'db_other',
    'db_person',
    'db_pipeline',
    'db_plancell',
    'db_planform',
    'db_pool',
    'db_president',
    'db_query',
    'db_reasoff',
    'db_reason',
    'db_region',
    'db_republic',
    'db_savefield',
    'db_selog',
    'db_settings',
    'db_sex',
    'db_smalltown',
    'db_stalker',
    'db_state',
    'db_student',
    'db_subdiv',
    'db_submission',
    'db_submitted',
    'db_target',
    'db_target_allowable',
    'db_target_history',
    'db_targetcell',
    'db_targettype',
    'db_task',
    'db_time_form',
    'db_try',
    'db_users',
    'db_voenmed',
    'db_wouldbe',
    'db_xclass',
    'db_zip_by'
);

if (!empty($_POST)) {
    
    @mkdir('/tmp/csv', '0777', true);
    $z= new ZipArchive();
    $z->open("/tmp/dict.zip",  ZipArchive::OVERWRITE) or die('zip');
    foreach ($dt as $v)
    {
        unlink("/tmp/csv/$v.csv");
        $sql=<<<EOF
SELECT *
INTO OUTFILE '/tmp/csv/$v.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
FROM $v
EOF;
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        $z->addFile("/tmp/csv/$v.csv","$v.csv");
        
        
    }
    $z->close();

    copy('/tmp/dict.zip', 'backup/dict.zip');
    
    
    ui_redirect('dict_dump.php');
}


ui_sp('Дамп словарей');
ui_sf();
ui_hidden('reg', 'null', '1');
ui_cm('При нажатии этой кнопки словари будут записаны по адресу /tmp/csv/....');
ui_sc('Дамп?');
ui_ef0();
ui_blink('Архив', 'backup/dict.zip');
ui_ep();
