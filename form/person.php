<?php

function form_draw($p, $t) {
    require 'options.php';
    require 'person.column.php';
    ui_sf();


    if ($t == 'search')
        ui_sc('�����');
    if ($t == 'default')
        ui_sc('���������');
    ui_hr();
    ui_stfs();
    ui_sfs();
    if ($t != 'create' && $t != 'search') {
        ui_text_view('', '', '���� ��������', $p['ctime']);
        ui_text_view('', '', '���� ���������', $p['vtime']);
        ui_text_view('', '', '���� �����������', $p['atime']);
        ui_text_view('', '', '���� ��������', $p['xtime']);
    }
    if ($t == 'search') {
        ui_text('reg', 'delo_name', '����� ����', $p['delo_name'], 13);
        ui_text('reg', 'uq', '���������� ���������', $p['uq'], 13);
        ui_text('tvw', 'at', '�������� ����', '', 50);
        ui_text('tlw', 'at', '����� ����', '', 50);
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
      ui_select_view('�����������', $options['users_by_name'], $p['cuid']);
      ui_select_view('���������', $options['users_by_name'], $p['vuid']);
      ui_select_view('��������', $options['users_by_name'], $p['auid']);
      ui_select_view('������', $options['users_by_name'], $p['xuid']);
     */
    if ($t == 'search') {
        ui_select('reg', 'cuid', '�����������', $options['users_by_name'], $p['cuid']);
        ui_select('reg', 'vuid', '���������', $options['users_by_name'], $p['vuid']);
        ui_select('reg', 'auid', '��������', $options['users_by_name'], $p['auid']);
        ui_select('reg', 'xuid', '������', $options['users_by_name'], $p['xuid']);
    }
    ui_efs();
    ui_etfs();
    ui_stfs('�������');
    ui_sfs();
    if ($t == 'edit' && $p['state_id'] != 4) {
        ui_select_view('���������', $options['faculty'], $p['faculty']);
        ui_select_view('����� ��������', $options['time_form'], $p['time_form_id']);
        ui_select_view('����� ��������', $options['ef'], $p['edu_form']);
        ui_select_view('�������', $options['target'], $p['target']);
        ui_select_view('��� ��������', $options['target_type'], $p['target_type']);
        ui_select_view('��� ��������', $options['target_cell'], $p['target_cell']);
        ui_select_view('������� �������', $options['region_by'], $p['region_cell']);
    } else {
        ui_select('reg', 'faculty', '���������', $options['faculty'], $p['faculty']);
        ui_select('reg', 'time_form_id', '����� ��������', $options['time_form'], $p['time_form_id']);
        ui_select('reg', 'edu_form', '����� ��������', $options['ef'], $p['edu_form']);
        ui_select('reg', 'target', '�������', $options['target'], $p['target']);
        ui_select('reg', 'target_type', '��� ��������', $options['target_type'], $p['target_type']);
        ui_select('reg', 'target_cell', '��� ��������', $options['target_cell'], $p['target_cell']);
        ui_select('reg', 'region_cell', '������� �������', $options['region_by'], $p['region_cell']);
    }
    ui_efs();
    ui_sptfs();
    ui_sfs();
    if ($t == 'search') {
        ui_select('reg', 'state_id', '���������', $options['state_id'], $p['state_id']);
        ui_select('reg', 'out_time_form_id', '����� ��������', $options['time_form'], $p['out_time_form_id']);
        ui_select('reg', 'out_edu_form', '����� ����������', $options['ef'], $p['out_edu_form']);
        ui_select('reg', 'out_target', '������� ����������', $options['target'], $p['out_target']);
        ui_select('reg', 'out_target_type', '��� � ����������', $options['target_type'], $p['out_target_type']);

        ui_check('opt', 'dropnovice', '������ ���������������', 1);
        ui_check('opt', 'dropinvalid', '������ �������������', 1);
    } else {
        ui_hidden('reg', 'state_id', $p['state_id']);
    }
    ui_efs();
    ui_etfs();

    ui_stfs('������ � ���������� ������');
    ui_sfs();
    ui_text('reg', 'surname', '�������', $p['surname'], 50);
    ui_text('reg', 'name', '���', $p['name'], 50);
    ui_text('reg', 'midname', '��������', $p['midname'], 50);
    ui_select('reg', 'sex', '���', $options['sex'], $p['sex']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'serial', '����� � �����', $p['serial'], 50);
    ui_text('reg', 'private', '������ �����', $p['private'], 50);
    ui_select('reg', 'natio', '�����������', $options['natio'], $p['natio']);
    // ����
    ui_date_edit('reg', 'birthday', '���� ��������', $p['birthday']);
    ui_efs();
    ui_etfs();
    ui_stfs('����� ����������');
    ui_sfs();
    ui_select('reg', 'country', '������', $options['country'], $p['country']);
    ui_select('reg', 'region_by', '�������', $options['region_by'], $p['region_by']);
    ui_text('reg', 'region_text', '�������(�����)', $p['region_text'], 50);
    ui_text('reg', 'area', '�����', $p['area'], 50);
    ui_select('reg', 'subdiv', '��� ��', $options['subdiv'], $p['subdiv']);
    ui_text('reg', 'city_name', '�������� ��', $p['city_name'], 50);
    ui_text('reg', 'zip', '������', $p['zip'], 50);
    ui_text('reg', 'microarea', '����������', $p['microarea'], 50);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'street', '�����', $p['street'], 50);
    ui_text('reg', 'house', '���', $p['house'], 50);
    ui_text('reg', 'house_part', '������', $p['house_part'], 50);
    ui_text('reg', 'room', '��������', $p['room'], 50);
    ui_text('reg', 'phone', '��������', $p['phone'], 50);
    ui_text('reg', 'mobile', '���������', $p['mobile'], 50);
    ui_text('reg', 'email', 'E-mail', $p['email'], 50);
    ui_text('reg', 'real_addr', '�����', $p['real_addr'], 50);
    ui_efs();
    ui_etfs();
    ui_stfs('�����������');
    ui_sfs();
    ui_select('reg', 'institution_id', '��� ��', $options['institution_id'], $p['institution_id']);
    ui_text('reg', 'institution_name', '��������', $p['institution_name'], 50);

    ui_select('reg', 'inst_city_type', '��� ��', $options['subdiv'], $p['inst_city_type']);
    ui_text('reg', 'inst_city_name', '�������� ��', $p['inst_city_name'], 50);
    ui_select('reg', 'certificate_id', '��������', $options['certificate_id'], $p['certificate_id']);
    ui_text('reg', 'certificate_name', '����� �����', $p['certificate_name'], 50);
    ui_date_edit('reg', 'cert_date', '���� ������', $p['cert_date']);
    ui_text('reg', 'certificate_sum', '����', $p['certificate_sum'], 3);

    ui_efs();
    ui_sptfs();
    ui_sfs();
    if ($t == 'search') {
        ui_bit_sel('edu', 'education', '�����������', $options['education_id'], $p['education_id']);
    } else {
        ui_bit_set('edu', 'education', '�����������', $options['education_id'], $p['education_id']);
    }

    ui_efs();
    ui_etfs();
    ui_stfs('���������������� ������������');
    ui_sfs();
    ui_select('reg', 'lct_id', '���', $options['ct_id'], $p['lct_id']);
    ui_text('reg', 'lct_sum', '����', $p['lct_sum'], 50);
    ui_text('reg', 'lct_sn', '�����', $p['lct_sn'], 50);
    ui_text('reg', 'lct_xn', '�����', $p['lct_xn'], 50);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg', 'cct_id', '���', $options['ct_id'], $p['cct_id']);
    ui_text('reg', 'cct_sum', '����', $p['cct_sum'], 50);
    ui_text('reg', 'cct_sn', '�����', $p['cct_sn'], 50);
    ui_text('reg', 'cct_xn', '�����', $p['cct_xn'], 50);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg', 'bct_id', '���', $options['ct_id'], $p['bct_id']);
    ui_text('reg', 'bct_sum', '����', $p['bct_sum'], 50);
    ui_text('reg', 'bct_sn', '�����', $p['bct_sn'], 50);
    ui_text('reg', 'bct_xn', '�����', $p['bct_xn'], 50);
    ui_efs();
    ui_etfs();
    ui_stfs('����� �������');
    ui_sfs();
    if ($t == 'search') {
        ui_bit_sel('lang', 'language_set', '�����', $options['language_id'], $p['language_set']);
    } else {
        ui_bit_set('lang', 'language_set', '�����', $options['language_id'], $p['language_set']);
    }
    ui_efs();
    ui_sptfs4();
    ui_sfs();

    if ($t == 'search') {
        ui_bit_sel('bnf', 'benefit_set', '������', $options['benefit_id'], $p['benefit_set']);
    } else {
        ui_bit_set('bnf', 'benefit_set', '������', $options['benefit_id'], $p['benefit_set']);
    }
    ui_efs();
    ui_sptfs4();
    ui_sfs();

    if ($t == 'search') {
        ui_bit_sel('com', 'community_set', '�����������', $options['community_id'], $p['community_set']);
    } else {
        ui_bit_set('com', 'community_set', '�����������', $options['community_id'], $p['community_set']);
    }
    ui_efs();
    ui_sptfs4();
    ui_sfs();

    if ($t == 'search') {
        ui_bit_sel('oth', 'other_set', '���������', $options['other_id'], $p['other_set']);
    } else {
        ui_bit_set('oth', 'other_set', '���������', $options['other_id'], $p['other_set']);
    }
    ui_efs();
    ui_etfs();
    ui_stfs('�������������� ������');
    ui_sfs();
    ui_select('reg', 'experience_id', '����', $options['experience_id'], $p['experience_id']);
    ui_select('reg', 'try_id', '�������', $options['try_id'], $p['try_id']);
    ui_select('reg', 'military_id', '������', $options['military_id'], $p['military_id']);
    ui_select('reg', 'hostel_id', '������', $options['hostel_id'], $p['hostel_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select('reg', 'course_id', '�����', $options['course_id'], $p['course_id']);
    ui_select('reg', 'grade_id', '�������', $options['grade_id'], $p['grade_id']);
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text('reg', 'live_num', '������� ��', $p['live_num'], 100);
    ui_date_edit('reg', 'live_date', '���� ������', $p['live_date']);
    ui_text('reg', 'live_data', '�����', $p['live_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'aes_num', '��. ����', $p['aes_num'], 100);
    ui_date_edit('reg', 'aes_date', '���� ������', $p['aes_date']);
    ui_text('reg', 'aes_data', '�����', $p['aes_data'], 100);
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text('reg', 'uzo_num', '���', $p['uzo_num'], 100);
    ui_date_edit('reg', 'uzo_date', '���� ������', $p['uzo_date']);
    ui_text('reg', 'uzo_data', '�����', $p['uzo_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text('reg', 'inv_num', '���.', $p['inv_num'], 100);
    ui_date_edit('reg', 'inv_date', '���� ������', $p['inv_date']);
    ui_text('reg', 'inv_data', '�����', $p['inv_data'], 100);
    ui_efs();
    ui_etfs();
    if ($t == 'search')
        ui_sc('�����');
    if ($t == 'create')
        ui_sc('�������');
    if ($t == 'default')
        ui_sc('���������');
    if ($t == 'edit')
        ui_sc('��������');
    ui_ef0();
}
