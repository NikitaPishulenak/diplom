<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

$sql="truncate db_person;";
$r=mysql_query($sql) or debug($sql,  mysql_error());

$sql="truncate db_target_history;";
$r=mysql_query($sql) or debug($sql,  mysql_error());

$sql="truncate db_history;";
$r=mysql_query($sql) or debug($sql,  mysql_error());

$sql=<<<EOF
insert into db_person (
    surname,
    name,
    midname,
    sex,
    state_id,
    faculty,
    time_form_id,
    edu_form,
    target,
    target_type,
    target_cell,
    region_cell,
    total,
    delo_name,
    delo_int,
    country,
    region_by,
    region_text,
    area,
    subdiv,
    city_name,
    zip,
    street,
    house,
    house_part,
    room,
    ctime,
    phone,
    mobile,
    email,
    real_addr,
    serial,
    private,
    institution_id,
    institution_name,
    certificate_id,
    certificate_name,
    certificate_sum,
    cert_date,
    lct_sum,
    lct_xn,
    lct_sn,
    cct_sum,
    cct_xn,
    cct_sn,
    bct_sum,
    bct_xn,
    bct_sn,
    lct_id,
    cct_id,
    bct_id,
    language_set,
    benefit_set,
    birthday,
    natio,
    live_num,
    live_date,
    live_data,
    aes_num,
    aes_date,
    aes_data,
    uzo_num,
    uzo_date,
    uzo_data,
    inv_num,
    inv_date,
    inv_data,
    uq
    
    ) 
select 
    surname,
    name,
    patronymic,
    sex,
    closed+1,
    faculty,
    1,
    edu_form,
    target,
    target_type,
    IF(target=1,1,0),
    if(cell_obl>0,cell_obl-1,0),
    total,
    delo,
    delo_int,
    country,
    if(region=1,5,region-1),
    region_text,
    area,
    city_type,
    city_name,
    post_index,
    street,
    house,
    house_part,
    room,
    date,
    phone,
    mobile,
    email,
    real_addr,
    SN,
    PN,
    edu_type,
    edu_title,
    edu_doc_type,
    edu_doc_sn,
    edu_doc_sum,
    edu_doc_date,
    test_ln_sum,
    test_ln_xn,
    test_ln_sn,
    test_ch_sum,
    test_ch_xn,
    test_ch_sn,
    test_bio_sum,
    test_bio_xn,
    test_bio_sn,
    if(length(test_ln_xn),1,2),
    if(length(test_ch_xn),1,2),
    if(length(test_bio_xn),1,2),
    langs,
    benefits,
    BD,
    natio,
    live_num,
    live_date,
    live_data,
    aes_num,
    aes_date,
    aes_data,
    uzo_num,
    uzo_date,
    uzo_data,
    inv_num,
    inv_date,
    inv_data,
    md5(concat(surname,sn))
    from adm.db_stable order by `id`;
EOF;
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_redirect('debug.php');