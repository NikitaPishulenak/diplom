<?php

function form_view($p, $t) {
    require 'form/options.php';
    require 'core/libtargetacl.php';
    if (!checkTargetAcl($p['faculty'], $p['time_form_id'], $p['edu_form'], $p['target'], $p['target_type'], $p['target_cell'], $p['region_cell'])) {
        ui_cm("����� ������� ����������.");
    }
    if (db_cv('db_person','uq',"state_id=1 and uq='${p['uq']}'")>1)
    {
	ui_cm('�������� �����.');
    }
    if (db_cv('db_person','serial',"state_id=1 and serial='${p['serial']}'")>1)
    {
	ui_cm('�������� �����.');
    }

    ui_stabs();
    ui_tabh(
            array(
                '�������',
                '�������',
                '��������',
                '�����������/��',
                '�����/������',
                '�������/�������',
            )
    );
    ui_stds();
    ui_stfs('����������� ����������');
    ui_sfs();
    ui_text_view('', '', '���� ��������', $p['ctime']);
    ui_text_view('', '', '���� ���������', $p['vtime']);
    ui_text_view('', '', '���� �����������', $p['atime']);
    ui_text_view('', '', '���� ��������', $p['xtime']);
    ui_efs();
    ui_sptfs();
    ui_sfs();



    ui_select_view('�����������', $options['users_by_name'], $p['cuid']);
    ui_select_view('���������', $options['users_by_name'], $p['vuid']);
    ui_select_view('��������', $options['users_by_name'], $p['auid']);
    ui_select_view('������', $options['users_by_name'], $p['xuid']);

    ui_efs();
    ui_etfs();
    ui_stfs('�������');
    ui_sfs('�����������');

    ui_select_view('���������', $options['faculty'], $p['faculty']);
    ui_select_view('����� ���������', $options['time_form'], $p['time_form_id']);
    ui_select_view('����� ��������', $options['ef'], $p['edu_form']);
    ui_select_view('�������', $options['target'], $p['target']);
    ui_select_view('��� ��������', $options['target_type'], $p['target_type']);
    ui_select_view('��� ��������', $options['target_cell'], $p['target_cell']);
    ui_select_view('������� �������', $options['region_by'], $p['region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('����������');
    ui_select_view('���������', $options['state_id'], $p['state_id']);
    ui_select_view('����� ��������', $options['time_form'], $p['out_time_form_id']);
    ui_select_view('����� ����������', $options['ef'], $p['out_edu_form']);
    ui_select_view('������� ����������', $options['target'], $p['out_target']);
    ui_select_view('��� � ����������', $options['target_type'], $p['out_target_type']);
    ui_select_view('��� � ����������', $options['target_cell'], $p['out_target_cell']);
    ui_select_view('���. ���. ����������', $options['region_cell'], $p['out_region_cell']);
	ui_text_view('','','<a href="add_stud.php?id='.$p['id'].'&type=add">���������</a>','');
    ui_text_view('','','<a href="add_stud.php?id='.$p['id'].'&type=kill">�� ���������</a>','');

    ui_efs();
    ui_sptfs3();
    ui_sfs('������');
    ui_select_view('��� ���������', $options['dual_mode_id'], $p['dual_mode_set']);
    ui_efs();
    ui_sfs('');
    ui_bit_set('wb', 'wouldbe_id', '', $options['wouldbe_id'], $p['wouldbe_id']);
    ui_bit_set('xc', 'xclass_id', '', $options['xclass_id'], $p['xclass_id']);
    ui_bit_set('st', 'student_id', '', $options['student_id'], $p['student_id']);


    ui_efs();
    ui_sfs();
    ui_text_view('', '', '���������� ���������', $p['uq']);
    ui_select_view('������� �������',$options['target_use_id'],$p['target_use_id']);
    ui_efs();

    ui_etfs();
    ui_stfs('��');
    ui_sfs();
    ui_select_view('����',$options['po_base_id'],$p['po_base_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_bit_set('po','po_lang_id','',$options['po_lang_id'],$p['po_lang_set']);
    ui_efs();
    ui_etfs();

    
    ui_etds();
    ui_stds();

    ui_stfs('������ � ���������� ������');
    ui_sfs();
    ui_text_view('reg', 'surname', '�������', $p['surname'], 50);
    ui_text_view('reg', 'name', '���', $p['name'], 50);
    ui_text_view('reg', 'midname', '��������', $p['midname'], 50);
    ui_select_view('���', $options['sex'], $p['sex']);
    ui_text_view('reg', 'birthday', '���� ��������', ui_date4view($p['birthday']));
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
    ui_text_view('reg', 'serial', '<span style="' . $mark_serial . '">����� � �����</span>', $p['serial'], 50);
    $mark_private='';
    if(strlen($p['private'])!=14 && $p['natio']==1)
    {
	$mark_private='color:red';
    }
    if(strlen($p['private'])>0 && $p['natio']==2)
    {
	$mark_private='color:red';
    }

    ui_text_view('reg', 'private', '<span style="' . $mark_private . '">������ �����</span>', $p['private'], 50);
    ui_select_view('�����������', $options['natio'], $p['natio']);
    // ����
    ui_text_view('reg', 'birthday', '�����', $p['authority']);
    ui_text_view('reg', 'birthday', '���� ������', ui_date4view($p['authority_date']));
    ui_efs();
    ui_etfs();
    ui_stfs('����� ����������');
    ui_sfs();
    ui_select_view('������', $options['country'], $p['country']);
    ui_select_view('�������', $options['region_by'], $p['region_by']);
    ui_text_view('reg', 'region_text', '�������(�����)', $p['region_text'], 50);
    ui_text_view('reg', 'area', '�����', $p['area'], 50);
    ui_select_view('��� ��', $options['subdiv'], $p['subdiv']);
    ui_text_view('reg', 'city_name', '�������� ��', $p['city_name'], 50);
    ui_text_view('reg', 'zip', '������', $p['zip'], 50);
    ui_text_view('reg', 'microarea', '����������', $p['microarea'], 50);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text_view('reg', 'street', '�����', $p['street'], 50);
    ui_text_view('reg', 'house', '���', $p['house'], 50);
    ui_text_view('reg', 'house_part', '������', $p['house_part'], 50);
    ui_text_view('reg', 'room', '��������', $p['room'], 50);
    ui_text_view('reg', 'phone', '��������', $p['phone'], 50);
    ui_text_view('reg', 'mobile', '���������', $p['mobile'], 50);
    ui_text_view('reg', 'email', 'E-mail', $p['email'], 50);
    ui_text_view('reg', 'real_addr', '����� ��������', $p['real_addr'], 50);
    ui_efs();
    ui_etfs();
    ui_par($p['live_addr']);
    ui_etds();
    ui_stds();
    ui_stfs('��������');
    ui_sfs('����');
    ui_text_view('reg', 'f_surname', '�������', $p['f_surname'], 50);
    ui_text_view('reg', 'f_name', '���', $p['f_name'], 50);
    ui_text_view('reg', 'f_midname', '��������', $p['f_midname'], 50);
    ui_text_view('reg', 'f_addr', '�����', $p['f_addr'], 200);
    ui_text_view('reg', 'f_org','����� ������',$p['f_org'],200);
    ui_text_view('reg', 'f_pos','���������',$p['f_pos'],200);
    ui_text_view('reg', 'f_phone','�������',$p['f_phone'],200);

    ui_efs();
    ui_sptfs();
    ui_sfs('����');
    ui_text_view('reg', 'm_surname', '�������', $p['m_surname'], 50);
    ui_text_view('reg', 'm_name', '���', $p['m_name'], 50);
    ui_text_view('reg', 'm_midname', '��������', $p['m_midname'], 50);
    ui_text_view('reg', 'm_addr', '�����', $p['m_addr'], 200);
    ui_text_view('reg', 'm_org','����� ������',$p['m_org'],200);
    ui_text_view('reg', 'm_pos','���������',$p['m_pos'],200);
    ui_text_view('reg', 'm_phone','�������',$p['m_phone'],200);

    ui_efs();
    ui_etfs();
    ui_etds();
    ui_stds();
    ui_stfs('�����������');
    ui_sfs();
    ui_select_view('���� ��', $options['inst_rank_id'], $p['inst_rank_id']);
    ui_select_view('��� ��', $options['institution_id'], $p['institution_id']);
    ui_text_view('reg', 'institution_name', '��������', $p['institution_name'], 50);
    ui_select_view('��� ��', $options['subdiv'], $p['inst_city_type']);
    ui_text_view('reg', 'inst_city_name', '�������� �.�.', $p['inst_city_name'], 50);
    ui_select_view('��������', $options['certificate_id'], $p['certificate_id']);
    ui_text_view('reg', 'certificate_name', '����� �����', $p['certificate_name'], 50);
    ui_text_view('reg', 'cert_date', '���� ������', ui_date4view($p['cert_date']));
    ui_text_view('reg', 'certificate_sum', '����', $p['certificate_sum'], 3);

    ui_efs();
    ui_sptfs();
    ui_sfs();

    ui_bit_set('edu', 'education', '�����������', $options['education_id'], $p['education_id']);
    ui_tv('reg', 'institution_name_full', '������ �������� ��', $p['institution_name_full']);
    
    ui_efs();
    ui_etfs();
    
    ui_stfs('������� �� ���������');
    ui_sfs();
    ui_select_view('����',$options['subgrade_id'],$p['subgrade_l_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select_view('��������',$options['subgrade_id'],$p['subgrade_b_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select_view('�����',$options['subgrade_id'],$p['subgrade_c_id']);
    ui_efs();
    ui_etfs();

    
    ui_stfs('���������������� ������������ / �����');
    ui_sfs('����');
    ui_select_view('���', $options['ct_id'], $p['lct_id']);
    ui_text_view('reg', 'lct_sum', '����', $p['lct_sum'], 50);
    ui_text_view('reg', 'lct_sn', '�����', $p['lct_sn'], 50);
    ui_text_view('reg', 'lct_xn', '�����', $p['lct_xn'], 50);
    ui_efs();
    ui_sptfs3();
    ui_sfs('��������');
    ui_select_view('���', $options['ct_id'], $p['bct_id']);
    ui_text_view('reg', 'bct_sum', '����', $p['bct_sum'], 50);
    ui_text_view('reg', 'bct_sn', '�����', $p['bct_sn'], 50);
    ui_text_view('reg', 'bct_xn', '�����', $p['bct_xn'], 50);
    ui_efs();


    ui_sptfs3();
    ui_sfs('�����');
    ui_select_view('���', $options['ct_id'], $p['cct_id']);
    ui_text_view('reg', 'cct_sum', '����', $p['cct_sum'], 50);
    ui_text_view('reg', 'cct_sn', '�����', $p['cct_sn'], 50);
    ui_text_view('reg', 'cct_xn', '�����', $p['cct_xn'], 50);
    ui_efs();


    ui_etfs();
    ui_etds();
    ui_stds();
    ui_stfs('����� �������');
    ui_sfs('�����');
    ui_select_view('��������', $options['language_id'], $p['cur_lang_id']);
    ui_select_view('�������', $options['cur_lang_level'], $p['cur_lang_level']);
    ui_text_view('reg','lang_grade','������',$p['lang_grade'],3);
    ui_efs();
    ui_sfs();

    ui_bit_set('lang', 'language_set', '�����', $options['language_id'], $p['language_set']);

    ui_efs();
    ui_sptfs4();
    ui_sfs('������');


    ui_bit_set('bnf', 'benefit_set', '������', $options['benefit_id'], $p['benefit_set']);

    ui_efs();
    ui_sptfs4();
    ui_sfs('��������');


    ui_bit_set('com', 'community_set', '�����������', $options['community_id'], $p['community_set']);

    ui_efs();
    ui_sptfs4();
    ui_sfs('������');


    ui_bit_set('oth', 'other_set', '���������', $options['other_id'], $p['other_set']);

    ui_efs();
    ui_etfs();
    ui_etds();
    ui_stds();
    ui_stfs('����� �������');
    ui_sfs();
    ui_select_view('����', $options['experience_id'], $p['experience_id']);
    ui_select_view('�������', $options['try_id'], $p['try_id']);
    //ui_select_view('������', $options['military_id'], $p['military_id']);
    ui_select_view('������������', $options['invalid_id'], $p['invalid_id']);
    ui_select_view('���������', $options['hostel_id'], $p['hostel_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select_view('�����', $options['course_id'], $p['course_id']);
    ui_select_view('�������', $options['grade_id'], $p['grade_id']);
    ui_efs();
    ui_etfs();

    ui_stfs('�������');
    ui_sfs('');
    ui_text_view('reg', 'live_num', '������� ��', $p['live_num'], 100);
    ui_text_view('reg', 'live_date', '���� ������', ui_date4view($p['live_date']));
    ui_text_view('reg', 'live_data', '�����', $p['live_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs('');
    ui_text_view('reg', 'aes_num', '��. ����', $p['aes_num'], 100);
    ui_text_view('reg', 'aes_date', '���� ������', ui_date4view($p['aes_date']));
    ui_text_view('reg', 'aes_date', '���� ���������', ui_date4view($p['aes_end_date']));
    ui_text_view('reg', 'aes_data', '�����', $p['aes_data'], 100);
    ui_efs();
    ui_etfs();

    ui_stfs();
    ui_sfs();
    ui_text_view('reg', 'uzo_num', '���', $p['uzo_num'], 100);
    ui_text_view('reg', 'uzo_date', '���� ������', ui_date4view($p['uzo_date']));
    ui_text_view('reg', 'uzo_data', '�����', $p['uzo_data'], 100);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_text_view('reg', 'inv_num', '���.', $p['inv_num'], 100);
    ui_text_view('reg', 'inv_date', '���� ������', ui_date4view($p['inv_date']));
    ui_text_view('reg', 'inv_date', '���� ���������', ui_date4view($p['inv_end_date']));
    ui_text_view('reg', 'inv_data', '�����', $p['inv_data'], 100);
    ui_efs();
    ui_etfs();
    ui_etds();
    ui_etabs();
}
