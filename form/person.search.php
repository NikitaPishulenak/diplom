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
        ui_sc('�����');
    print '<a style="margin-top:0;float:right" href="javascript:form_reset()">��������</a>';
    print '<a style="margin-top:0;float:left" href="javascript:form_last()">��������� ������</a>';
    ui_hr();

    ui_stfs();
    ui_sfs('&nbsp');
    ui_text('reg', 'delo_name', '����� ����', $p['delo_name'], 13);
    ui_text('reg', 'uq', '���������� ���������', $p['uq'], 13);
    //ui_text('tvw', 'at', '<a style="margin: 0pt;" href="javascript:cut_use();">C���</a>', '', 50);
   // ui_text('tlw', 'at', '����� ����', '', 50);
    ui_select('zxc', 'created', '������ �� ����', $options['created'], 0);
    ui_select('zxc', 'closed', '������� �� ����', $options['created'], 0);
    ui_select('cin', 'queryid', '�������� - ������',$options['queryid'],0);
    ui_select('cin', 'chainid', '�������� - �������',$options['chainid'],0);
    ui_select('cin', 'stickid', '�������� - ������',$options['stickid'],0);
    ui_efs();
    ui_sptfs3();
    ui_sfs('�������� ��������');
    ui_select('fix', 'x_id', '��������', $options['manualid'], 0);
    ui_select('fix', 'xstate_id', '���������', $options['state_id'], $p['state_id']);
    ui_select('fix', 'xfaculty', '���������', $options['faculty'], $p['faculty']);
    ui_select('fix', 'xtime_form_id', '����� ���������', $options['time_form'], $p['time_form_id']);
    ui_select('fix', 'xedu_form', '����� ��������', $options['ef'], $p['edu_form']);
    ui_select('fix', 'xtarget', '�������', $options['target'], $p['target']);
    ui_select('fix', 'xtarget_type', '��� ��������', $options['target_type'], $p['target_type']);
    ui_select('fix', 'xtarget_cell', '��� ��������', $options['target_cell'], $p['target_cell']);
    ui_select('fix', 'xregion_cell', '������� �������', $options['region_by'], $p['region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('���. ������');
    ui_select('reg', 'cuid', '�����������', $options['users_by_name'], $p['cuid']);
    ui_select('reg', 'vuid', '���������', $options['users_by_name'], $p['vuid']);
    ui_select('reg', 'auid', '��������', $options['users_by_name'], $p['auid']);
    ui_select('reg', 'xuid', '������', $options['users_by_name'], $p['xuid']);
    ui_select_range('rng','total','����');
    ui_check('opt', 'dropinvalid', '�� ���������� �����', 1);
    ui_check('opt', 'droppdp', '�� ���������� ���', (int)(cr_ukey('faculty')!=7));
    //ui_select('reg', 'target_use_id','������� �������',$options['target_use_id'],$p['target_use_id']);
    ui_efs();
    ui_etfs();
    
    unset($pcolumns['delo_name']);
    $pcolumns['delo_int']='����� ����';
    
    ui_stfs('����������');
    ui_blink('��', "javascript:sort_use('x','delo_int')");
    ui_blink('&sum;', "javascript:sort_use('x','total')");
    ui_blink('�', "javascript:sort_use('x','faculty')");
    ui_blink('�', "javascript:sort_use('x','time_form_id')");
    ui_blink('��', "javascript:sort_use('x','edu_form')");
    ui_blink('�', "javascript:sort_use('x','target')");
    ui_blink('��', "javascript:sort_use('x','target_type')");
    ui_blink('��', "javascript:sort_use('x','target_cell')");
    ui_blink('��', "javascript:sort_use('x','region_cell')");
    ui_blink('���', "javascript:sort_use('x','surname')");
    ui_sfs();
    ui_select_check('sort', 'x', 'X', $pcolumns, 0);
    ui_efs();
    ui_sptfs3();
    ui_blink('��', "javascript:sort_use('y','delo_int')");
    ui_blink('&sum;', "javascript:sort_use('y','total')");
    ui_blink('�', "javascript:sort_use('y','faculty')");
    ui_blink('�', "javascript:sort_use('y','time_form_id')");
    ui_blink('��', "javascript:sort_use('y','edu_form')");
    ui_blink('�', "javascript:sort_use('y','target')");
    ui_blink('��', "javascript:sort_use('y','target_type')");
    ui_blink('��', "javascript:sort_use('y','target_cell')");
    ui_blink('��', "javascript:sort_use('y','region_cell')");
    ui_blink('���', "javascript:sort_use('y','surname')");
    ui_sfs();
    ui_select_check('sort', 'y', 'Y', $pcolumns, 0);
    ui_efs();
    ui_sptfs3();
    ui_blink('��', "javascript:sort_use('z','delo_int')");
    ui_blink('&sum;', "javascript:sort_use('z','total')");
    ui_blink('�', "javascript:sort_use('z','faculty')");
    ui_blink('�', "javascript:sort_use('z','time_form_id')");
    ui_blink('��', "javascript:sort_use('z','edu_form')");
    ui_blink('�', "javascript:sort_use('z','target')");
    ui_blink('��', "javascript:sort_use('z','target_type')");
    ui_blink('��', "javascript:sort_use('z','target_cell')");
    ui_blink('��', "javascript:sort_use('z','region_cell')");
    ui_blink('���', "javascript:sort_use('z','surname')");
    ui_sfs();
    ui_select_check('sort', 'z', 'Z', $pcolumns, 0);
    ui_efs();
    ui_etfs();

    ui_stfs('�������');
    ui_sfs('�����������');
    ui_select('reg', 'faculty', '���������', $options['faculty'], $p['faculty']);
    ui_select('reg', 'time_form_id', '����� ���������', $options['time_form'], $p['time_form_id']);
    ui_select('reg', 'edu_form', '����� ��������', $options['ef'], $p['edu_form']);
    ui_select('reg', 'target', '�������', $options['target'], $p['target']);
    ui_select('reg', 'target_type', '��� ��������', $options['target_type'], $p['target_type']);
    ui_select('reg', 'target_cell', '��� ��������', $options['target_cell'], $p['target_cell']);
    ui_select('reg', 'region_cell', '������� �������', $options['region_by'], $p['region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('����������');
    ui_select('reg', 'state_id', '���������', $options['state_id'], $p['state_id']);
    ui_select('reg', 'out_time_form_id', '����� ��������', $options['time_form'], $p['out_time_form_id']);
    ui_select('reg', 'out_edu_form', '����� ����������', $options['ef'], $p['out_edu_form']);
    ui_select('reg', 'out_target', '������� ����������', $options['target'], $p['out_target']);
    ui_select('reg', 'out_target_type', '��� � ����������', $options['target_type'], $p['out_target_type']);
    ui_select('reg', 'out_target_cell', '��� � ����������', $options['target_cell'], $p['out_target_cell']);
    ui_select('reg', 'out_region_cell', '���. ���. ����������', $options['region_cell'], $p['out_region_cell']);
    ui_efs();
    ui_sptfs3();
    ui_sfs('������');
    ui_select('reg', 'dual_mode_set', '��� ���������', $options['dual_mode_id'], $p['dual_mode_set']);
    ui_bit_sel('st', 'student_id', '', $options['student_id'], $p['student_id']);
    ui_bit_sel('xc', 'xclass_id', '', $options['xclass_id'], $p['xclass_id']);
    ui_bit_sel('wb', 'wouldbe_id', '', $options['wouldbe_id'], $p['wouldbe_id']);
    ui_efs();
    ui_etfs();
    
    if(cr_ukey('faculty')==7)
    {
	ui_stfs('��');
        ui_sfs();
	ui_select('reg','po_base_id','����',$options['po_base_id'],$p['po_base_id']);
        ui_efs();
        ui_sptfs();
        ui_sfs();
        ui_bit_sel('po','po_lang_id','',$options['po_lang_id'],$p['po_lang_set']);
        ui_efs();
        ui_etfs();


    }

    ui_stfs('������ � ���������� ������');
    ui_sfs();
    ui_text('reg', 'surname', '�������', $p['surname'], 50);
    ui_text('reg', 'name', '���', $p['name'], 50);
    ui_text('reg', 'midname', '��������', $p['midname'], 50);
    ui_select('reg', 'sex', '���', $options['sex'], $p['sex']);
    ui_date_edit('reg', 'birthday', '���� ��������', $p['birthday']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select('reg', 'natio', '�����������', $options['natio'], $p['natio']);
    ui_text('reg', 'serial', '����� � �����', $p['serial'], 50);
    ui_text('reg', 'private', '������ �����', $p['private'], 50);
    
    
    ui_text('reg','authority','�����',$p['authority'],50);
    ui_date_edit('reg', 'authority_date', '���� ������', $p['authority_date']);
    ui_efs();
    ui_etfs();


    ui_stfs('����� ����������');
    ui_sfs();
    ui_select('reg', 'country', '������', $options['country'], $p['country']);
    ui_select('reg', 'region_by', '�������', $options['region_by'], $p['region_by']);
    ui_text('reg', 'region_text', '�������(�����)', $p['region_text'], 50);
    ui_text('reg', 'area', '�����', $p['area'], 50);
    ui_select('xcr', 'addr_city_rang', '���� ��', $options['city_rang'], 0);
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
    ui_text('reg', 'real_addr', '����� ��������', $p['real_addr'], 50);
    ui_efs();
    ui_etfs();

    ui_stfs('��������');
    ui_sfs('����');
    ui_text('reg', 'f_surname', '�������', $p['f_surname'], 50);
    ui_text('reg', 'f_name', '���', $p['f_name'], 50);
    ui_text('reg', 'f_midname', '��������', $p['f_midname'], 50);
    ui_text('reg', 'f_addr', '�����', $p['f_addr'], 200);
    ui_text('reg', 'f_org','����� ������',$p['f_org'],200);
    ui_text('reg', 'f_pos','���������',$p['f_pos'],200);
    ui_text('reg', 'f_phone','�������',$p['f_phone'],200);
    ui_efs();
    ui_sptfs();
    ui_sfs('����');
    ui_text('reg', 'm_surname', '�������', $p['m_surname'], 50);
    ui_text('reg', 'm_name', '���', $p['m_name'], 50);
    ui_text('reg', 'm_midname', '��������', $p['m_midname'], 50);
    ui_text('reg', 'm_addr', '�����', $p['m_addr'], 200);
    ui_text('reg', 'm_org','����� ������',$p['m_org'],200);
    ui_text('reg', 'm_pos','���������',$p['m_pos'],200);
    ui_text('reg', 'm_phone','�������',$p['m_phone'],200);
    ui_efs();
    ui_etfs();


    ui_stfs('�����������');
    ui_sfs();
    ui_select('reg', 'inst_rank_id', '���� ��', $options['inst_rank_id'], $p['inst_rank_id']);
    ui_select('reg', 'institution_id', '��� ��', $options['institution_id'], $p['institution_id']);
    ui_text('reg', 'institution_name', '��������', $p['institution_name'], 50);
    ui_select('xcr', 'inst_city_rang', '���� ��', $options['city_rang'], 0);
    ui_select('reg', 'inst_city_type', '��� ��', $options['subdiv'], $p['inst_city_type']);
    ui_text('reg', 'inst_city_name', '�������� ��', $p['inst_city_name'], 50);
    ui_select('reg', 'certificate_id', '��������', $options['certificate_id'], $p['certificate_id']);
    ui_text('reg', 'certificate_name', '����� �����', $p['certificate_name'], 50);
    ui_date_edit('reg', 'cert_date', '���� ������', $p['cert_date']);
    ui_text('reg', 'certificate_sum', '����', $p['certificate_sum'], 3);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_bit_sel('edu', 'education', '�����������', $options['education_id'], $p['education_id']);
    ui_efs();
    ui_etfs();
    
    ui_stfs();
    ui_sfs();
    ui_select('reg', 'course_id', '�����', $options['course_id'], $p['course_id']);
    ui_efs();
    ui_sptfs();
    ui_sfs();
    ui_select('reg', 'grade_id', '�������', $options['grade_id'], $p['grade_id']);
    ui_efs();
    ui_etfs();
    
    ui_stfs('������� �� ���������');
    ui_sfs();
    ui_select('reg','subgrade_l_id','����',$options['subgrade_id'],$p['subgrade_l_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg','subgrade_b_id','��������',$options['subgrade_id'],$p['subgrade_b_id']);
    ui_efs();
    ui_sptfs3();
    ui_sfs();
    ui_select('reg','subgrade_c_id','�����',$options['subgrade_id'],$p['subgrade_c_id']);
    ui_efs();
    ui_etfs();
    
    ui_stfs('���������������� ������������');
    ui_sfs('����');
    ui_select('reg', 'lct_id', '���', $options['ct_id'], $p['lct_id']);
    ui_text('reg', 'lct_sum', '����', $p['lct_sum'], 3);
    ui_text('reg', 'lct_sn', '�����', $p['lct_sn'], 8);
    ui_text('reg', 'lct_xn', '�����', $p['lct_xn'], 7);
    ui_efs();
    ui_sptfs3();
    ui_sfs('��������');
    ui_select('reg', 'bct_id', '���', $options['ct_id'], $p['bct_id']);
    ui_text('reg', 'bct_sum', '����', $p['bct_sum'], 3);
    ui_text('reg', 'bct_sn', '�����', $p['bct_sn'], 8);
    ui_text('reg', 'bct_xn', '�����', $p['bct_xn'], 7);
    ui_efs();
    ui_sptfs3();
    ui_sfs('�����');
    ui_select('reg', 'cct_id', '���', $options['ct_id'], $p['cct_id']);
    ui_text('reg', 'cct_sum', '����', $p['cct_sum'], 3);
    ui_text('reg', 'cct_sn', '�����', $p['cct_sn'], 8);
    ui_text('reg', 'cct_xn', '�����', $p['cct_xn'], 7);
    ui_efs();
    ui_etfs();
    
    ui_stfs('����� �������');
    ui_sfs('�����');
    ui_select('reg', 'cur_lang_id', '��������', $options['language_id'], $p['cur_lang_id']);
    ui_select('reg', 'cur_lang_level', '�������', $options['cur_lang_level'], $p['cur_lang_level']);
    ui_text('reg', 'lang_grade', '������', $p['lang_grade'], 5);
    ui_efs();
    ui_sfs();
    ui_bit_sel('lang', 'language_set', '�����', $options['language_id'], $p['language_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('������');
    ui_bit_sel('bnf', 'benefit_set', '������', $options['benefit_id'], $p['benefit_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('��������');
    ui_bit_sel('com', 'community_set', '�����������', $options['community_id'], $p['community_set']);
    ui_efs();
    ui_sptfs4();
    ui_sfs('������');
    ui_bit_sel('oth', 'other_set', '���������', $options['other_id'], $p['other_set']);
    ui_efs();
    ui_etfs();
    
    
    ui_stfs('�������������� ������');
    ui_sfs();
    ui_select('reg', 'experience_id', '����', $options['experience_id'], $p['experience_id']);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_select('reg', 'try_id', '�������', $options['try_id'], $p['try_id']);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    //ui_select('reg', 'military_id', '������', $options['military_id'], $p['military_id']);
    ui_select('reg', 'invalid_id', '������������', $options['invalid_id'], $p['invalid_id']);
    
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_select('reg', 'hostel_id', '������', $options['hostel_id'], $p['hostel_id']);
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
    ui_date_edit_future('reg', 'aes_end_date','���� ���������',$p['aes_end_date']);
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
    ui_date_edit_future('reg', 'inv_end_date', '���� ���������', $p['inv_end_date']);
    ui_text('reg', 'inv_data', '�����', $p['inv_data'], 100);
    ui_efs();
    ui_etfs();
    if ($t == 'search')
        ui_sc('�����');
ui_script('js/edit.js?2');


    ui_ef0();
}
