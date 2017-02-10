<?php
function form_view($p,$t)
{
    require 'form/options.php';
    require 'core/libtargetacl.php';
    if (!checkTargetAcl($p['faculty'], $p['time_form_id'], $p['edu_form'], $p['target'], $p['target_type'], $p['target_cell'], $p['region_cell'])) {
        ui_cm("����� ������� ����������.");
    }
    print ui_sap($options['benefit_set'],$p['benefit_set'],'');
    print ' ';
    print ui_sap($options['invalid_id'],$p['invalid_id'],'');
    print ' ����: ';
    print ui_sap($options['experience_id'],$p['experience_id'],'�� ���������');
    print ' ';
    print ui_sap($options['wouldbe_id'],$p['wouldbe_id'],'');
    ui_hr();
    print $p['live_addr'];
    print ' ';
    print $p['phone'];
    print ' ';
    print $p['mobile'];
    print ' ';
    ui_hr();
    print ui_sap($options['certificate_id'],$p['certificate_id']);
    print ' ';
    print $p['certificate_name'];
    print ' ';
    print ui_date4view($p['cert_date']);
    print ' ';
    print $p['certificate_sum'];
    print ' ';
    print ui_sap($options['inst_rank_id'],$p['inst_rank_id']);
    print ' ';
    print ui_sap($options['institution_id'],$p['institution_id']);
    print ' &laquo;';
    print $p['institution_name'];
    print '&raquo; ';
    print ui_sap($options['subdiv'],$p['inst_city_type']);
    print ' ';
    print $p['inst_city_name'];
//    print ' ';
//    print ui_date4view($p['cert_date']);
    ui_hr();
    print '����';
    print ' ';
    print $p['lct_sum'];
    print ' ';
    print $p['lct_sn'];
    print ' ';
    print $p['lct_xn'];
    print ' ';
    ui_hr();
    print '��������';
    print ' ';
    print $p['bct_sum'];
    print ' ';
    print $p['bct_sn'];
    print ' ';
    print $p['bct_xn'];
    print ' ';
    ui_hr();
    print '�����';
    print ' ';
    print $p['cct_sum'];
    print ' ';
    print $p['cct_sn'];
    print ' ';
    print $p['cct_xn'];
    print ' ';
    ui_hr();
    print '������� ��';
    print ' ';
    print $p['live_num'];
    print ' ';
    print $p['live_date'];
    print ' ';
    print $p['live_data'];
    print ' ';
    ui_hr();
    print '���';
    print ' ';
    print $p['uzo_num'];
    print ' ';
    print $p['uzo_date'];
    print ' ';
    print $p['uzo_data'];
    print ' ';
    ui_hr();
    print '����';
    print ' ';
    print $p['aes_num'];
    print ' ';
    print $p['aes_date'];
    print ' ';
    print $p['aes_data'];
    print ' ';
    ui_hr();
    print '��. ���.';
    print ' ';
    print $p['inv_num'];
    print ' ';
    print $p['inv_date'];
    print ' ';
    print $p['inv_data'];
    print ' ';
    ui_hr();
    print '��������: ';
    print ' ';
    print (($p['other_set'] & 2)==2 )? '�� ���� �������':'';
    print '; ';
    print (($p['other_set'] & 4)==4 )? '�� ������':'';
    print ' ';
    print ' ';
    ui_hr();
    print '���������:'. ui_sap($options['hostel_id'],$p['hostel_id'],'<span style="color:red;">������������</span>');
    
}