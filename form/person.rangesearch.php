<?php
function form_draw($p,$t)
{
    include 'options.php';
    ui_sf();
    ui_sc('�����');
    ui_stfs('����������� ����');
    ui_sfs('�������(>)');
    ui_date_edit('reg', 'ctime_from','�������' , '');
    ui_date_edit('reg', 'vtime_from','���������' , '');
    ui_date_edit('reg', 'atime_from','�������������' , '');
    ui_date_edit('reg', 'xtime_from','�������' , '');
    ui_text_view('', '', '����������','�����: 00:00');
    ui_efs();
    ui_sptfs3();
    ui_sfs('����������(<)');
    
    ui_date_edit('reg', 'ctime_less','�������' , '');
    ui_date_edit('reg', 'vtime_less','���������' , '');
    ui_date_edit('reg', 'atime_less','�������������' , '');
    ui_date_edit('reg', 'xtime_less','�������' , '');
    ui_text_view('', '', '����������','�����: 00:00');
    ui_efs();
    ui_sptfs3();
    ui_sfs('� �����');
    ui_select('reg', 'cuid', '�����������', $options['users_by_name'], $p['cuid']);
    ui_select('reg', 'vuid', '���������', $options['users_by_name'], $p['vuid']);
    ui_select('reg', 'auid', '��������', $options['users_by_name'], $p['auid']);
    ui_select('reg', 'xuid', '������', $options['users_by_name'], $p['xuid']);
    ui_select_range('rng','total','����');
    ui_efs();
    ui_etfs();
    
    ui_stfs('������������');
    ui_sfs('�������(>)');
    ui_date_edit('reg', 'birthday_from', '���� ��������', '');
    ui_date_edit('reg', 'authority_date_from', '���� ������ (�)', '');
    ui_date_edit('reg', 'cert_date_from', '���� ������ (��)', '');
    ui_date_edit('reg', 'live_date_from', '���� ������ (��)', '');
    ui_date_edit('reg', 'aes_date_from', '���� ������ (�)', '');
    ui_date_edit('reg', 'uzo_date_from', '���� ������ (��)', '');
    ui_date_edit('reg', 'inv_date_from', '���� ������ (�)', '');
    ui_date_edit('reg', 'order_date_from', '���� ������� ', '');
    ui_date_edit('reg', 'proto_date_from', '���� ���������', '');
    ui_date_edit('reg', 'arrive_date_from', '���� ��������', '');
    ui_efs();
    ui_sptfs3();
    ui_sfs('����������(<)');
    ui_date_edit('reg', 'birthday_less', '���� ��������', '');
    ui_date_edit('reg', 'authority_date_less', '���� ������(�)', '');
    ui_date_edit('reg', 'cert_date_less', '���� ������ (��)', '');
    ui_date_edit('reg', 'live_date_less', '���� ������ (��)', '');
    ui_date_edit('reg', 'aes_date_less', '���� ������ (�)', '');
    ui_date_edit('reg', 'uzo_date_less', '���� ������ (��)', '');
    ui_date_edit('reg', 'inv_date_less', '���� ������ (�)', '');
    ui_date_edit('reg', 'order_date_less', '���� ������� ', '');
    ui_date_edit('reg', 'proto_date_less', '���� ���������', '');
    ui_date_edit('reg', 'arrive_date_less', '���� ��������', '');
    ui_efs();
    ui_sptfs3();
    ui_sfs('�����');
    ui_select_range('rng','certificate_sum','���� (a)');
    ui_select_range('rng','lct_sum','���� (�)');
    ui_select_range('rng','cct_sum','���� (�)');
    ui_select_range('rng','bct_sum','���� (�)');
    ui_efs();
    ui_etfs();
    
    ui_sc('�����');
    ui_ef0();
}