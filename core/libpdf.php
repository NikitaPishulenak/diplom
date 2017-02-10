<?php

function receipt($pdf, $p, $options) {

    $faculty = ui_pdf_sap($options['faculty'], $p->faculty);
    $spec =ui_pdf_sap($options['speccode'], $p->faculty).' '.ui_pdf_sap($options['spec'], $p->faculty);
    $cert_type = ui_pdf_sap($options['certificate_id'], $p->certificate_id);
    $cert_name = $p->certificate_name;
    $executor = ui_pdf_sap($options['settings'],'executor');
    $cert_date = db_d2arr($p->cert_date);
    $cert_d = $cert_date['d'];
    $cert_m = ui_pdf_sap($options['issued'],$cert_date['m']);;
    $cert_y = $cert_date['y'];
    $inst_type = ui_pdf_sap($options['institution_id'], $p->institution_id);
    $inst_name = $p->institution_name;
    $inst_city_type = ui_pdf_sap($options['inst_city_type'], $p->inst_city_type);
    $inst_city_name = $p->inst_city_name;

    $lct='';
    $cct='';
    $bct='';
    
    if($p->grade_id>0)
    {
	$ct_text='����� ������� ���������� ���������';
        //$lct='����� ������� ���������� ���������';
    }
    else
    {
	$ct_text='����������� ����������������� ������������ �� ���������';
        $lct = ($p->lct_id == 1) ? "���������� �� (����) ����� $p->lct_sn � $p->lct_xn" : "����� ������� ���������� ��������� �� �����";
        $cct = ($p->cct_id == 1) ? "���������� �� (�����) ����� $p->cct_sn � $p->cct_xn" : "����� ������� ���������� ��������� �� �����";
        $bct = ($p->bct_id == 1) ? "���������� �� (��������) ����� $p->bct_sn � $p->bct_xn" : "����� ������� ���������� ��������� �� ��������";
    }
    
    
    $ctime=  db_dt2arr($p->ctime);
    $ctime_d = $ctime['d'];
    $ctime_m = ui_pdf_sap($options['issued'],$ctime['m']);
    $ctime_y = $ctime['y'];
    
    $pdf->SetMargins(10, 30, 10);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->AddFont('TimesNRCyrMT', '', 'TIMCYR.php');
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(58, 5, '�������� �', 0, 0, 'R');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5, $p->delo_name, 'B', 1, 'L');
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(10, 5, '');
    $pdf->SetFontSize(8);
    $pdf->Cell(0, 5, '(�� ������� ����������� ���������� ������������)', 0, 1, 'R');
    $pdf->SetFontSize(9);
    $pdf->Ln();
    $pdf->Cell(60, 5, '� ����� ���������� �� ���������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5, $faculty, 'B', 1, 'L');
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(60, 5, '�� ������������� (�������������)', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->MultiCell(0, 5, $spec, 'B', 1, FALSE);
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    //$pdf->Cell(0, 5, '', 'B', 1, 'R');
    $pdf->Cell(7, 5, '��', 0, 0, 'B');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5, $p->surname . ' ' . $p->name . ' ' . $p->midname, 'B', 1, 'L');
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->SetFontSize(8);
    $pdf->Cell(00, 5, '(�������, ����������� ���, �������� (���� ������� �������))', 0, 1, 'C');
    $pdf->SetFontSize(9);
    $pdf->Cell(0, 5, '������� ���������:', 0, 1, 'L');
    $pdf->Cell(0, 5, '1. ���������', 0, 1, 'L');
    $pdf->Cell(0, 5, '2. ����������', 0, 1, 'L');
    $pdf->Cell(75, 5, '3. �������� �� ����������� (� �����������)', 0, 0, 'L');
    $pdf->Cell(0, 5, "$cert_type � $cert_name ", 'B', 1, 'L');
    $pdf->MultiCell(0, 5, "�� \"$cert_d\" $cert_m $cert_y ����, ����� $inst_type $inst_name $inst_city_type. $inst_city_name", 'B', 1, false);
    $i=3;
    if($p->faculty!=5) $pdf->Cell(0, 5, ++$i. '. ����������� ������� � ��������� ��������', 0, 1, 'L');
    $pdf->Cell(0, 5, ++$i. '. '. $ct_text, 0, 1, 'L');
    $pdf->Cell(10, 5, '', '0', 0, 'L');
    $pdf->Cell(0, 5, $lct, '0', 1, 'L');
    $pdf->Cell(10, 5, '', '0', 0, 'L');
    $pdf->Cell(0, 5, $bct, '0', 1, 'L');
    $pdf->Cell(10, 5, '', '0', 0, 'L');
    $pdf->Cell(0, 5, $cct, '0', 1, 'L');
    
    if($p->experience_id>1){
        $pdf->Cell(0, 5, ++$i . '. ������� �� �������� ������, ����� �������� ������, ����� ��������� ��������, ', 0, 1, 'L');
        $pdf->Cell(0, 5,'����� ����������-��������� ��������, ������������� � ����������� ', 0, 1, 'L');
        $pdf->Cell(0, 5,'��������������� ��������������� (������ �����������)',0,1,'L');
    }
    if($p->target==1){
        $pdf->Cell(0, 5, ++$i .'. ������� � ������� ���������� ����������� (��������, ���������)', 0, 1, 'L');
    }
 
    $pdf->Cell(35, 5, ++$i.'. ���� ���������', 0, 0, 'L');
    $pdf->Cell(0, 5, '', 'B', 1, 'R');
    $pdf->Cell(0, 5, '', 'B', 1, 'R');
    $pdf->Cell(0, 5, '', 'B', 1, 'R');
    $pdf->Cell(0, 5, '', 'B', 1, 'R');
    $pdf->Ln();
    $pdf->Cell(0, 5, '������ ������������� ���������', 0, 1, 'L');
    $pdf->Cell(0, 5, '(����������� ��������������� ���������)', 0, 1, 'L');
    $pdf->Cell(35, 5, '������� ��������', 0, 0, 'L');
//    $pdf->Cell(0, 5, '������ ������������� ���������', 0, 1, 'L');
    $pdf->Cell(35, 5, '', 'B', 0, 'R');
    $pdf->Cell(23, 5, '', '', 0, 'R');
    $pdf->Cell(0, 5, $executor, 'B', 1, 'R');
    $pdf->SetFontSize(8);
    $pdf->Cell(35, 5, '', '', 0, 'R');
    $pdf->Cell(35, 5, '(�������)', '', 0, 'C');
    $pdf->Cell(23, 5, '', '', 0, 'R');
    $pdf->Cell(35, 5, '(��������, �������)', '', 0, 'C');
    $pdf->Ln();
    $pdf->Cell(35, 5, '', '', 0, 'R');
    $pdf->Cell(0, 5, '�.�.', 0, 1, 'L');

    $pdf->Cell(25, 5, "\"$ctime_d\" $ctime_m $ctime_y �. ", 'B', 0, 'L');
    $pdf->Cell(0, 5, "$p->private", '', 1, 'R');
    $pdf->Cell(6, 5, '', 0, 0, 'L');
    $pdf->Cell(0, 5, '(����)', 0, 1, 'L');
    $pdf->Cell(0, 5, '����������. � ������ ����� �������� ���������� ������ ������� �� ���� � �������� ��������', 0, 1, 'L');
    $pdf->Cell(0, 5, '���������� �����������.', '', 1, 'L');
}

function listcase($pdf, $p, $options) {
    $faculty = ui_pdf_sap($options['faculty'], $p->faculty);
    $spec = ui_pdf_sap($options['speccode'], $p->faculty).' '.ui_pdf_sap($options['spec'], $p->faculty);
    $cert_type = ui_pdf_sap($options['certificate_id'], $p->certificate_id);
    $cert_name = $p->certificate_name;
    $cert_date = db_d2arr($p->cert_date);
    $cert_d = $cert_date['d'];
    $cert_m = ui_pdf_sap($options['issued'],$cert_date['m']);;
    $cert_y = $cert_date['y'];
    $inst_type = ui_pdf_sap($options['institution_id'], $p->institution_id);
    $inst_name = $p->institution_name;
    $inst_city_type = ui_pdf_sap($options['inst_city_type'], $p->inst_city_type);
    $inst_city_name = $p->inst_city_name;

    $lct='';
    $cct='';
    $bct='';
    
    if($p->grade_id>0)
    {
        //$lct='����� ������� ���������� ���������';
        $ct_text='����� ������� ���������� ���������';
    }
    else
    {
	$ct_text='����������� ����������������� ������������ �� ���������';
        $lct = ($p->lct_id == 1) ? "���������� �� (����) ����� $p->lct_sn � $p->lct_xn" : "����� ������� ���������� ��������� �� �����";
        $cct = ($p->cct_id == 1) ? "���������� �� (�����) ����� $p->cct_sn � $p->cct_xn" : "����� ������� ���������� ��������� �� �����";
        $bct = ($p->bct_id == 1) ? "���������� �� (��������) ����� $p->bct_sn � $p->bct_xn" : "����� ������� ���������� ��������� �� ��������";
    }
    $ctime=  db_dt2arr($p->ctime);
    $ctime_d = $ctime['d'];
    $ctime_m = $ctime['m'];
    $ctime_y = $ctime['y'];
    
    
    $pdf->SetMargins(10, 15, 10);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(0,5,'�����',0,1,'C');
    $pdf->Cell(65, 5, '������� (��������) ���� �����������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5, $p->delo_name, 0,1, 'L');
    
    $pdf->Ln();
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
/*    $pdf->Cell(65, 5, '������� ��� ��������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5, $p->surname . ' ' . $p->name . ' ' . $p->midname, 0, 1, 'L');
*/
    $pdf->Cell(65, 5, '�������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5, $p->surname, 0, 1, 'L');
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(65, 5, '����������� ���', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5,$p->name, 0, 1, 'L');
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(65, 5, '�������� (���� ������� �������)', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5,$p->midname, 0, 1, 'L');
  
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(65, 5, '���������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->Cell(0, 5, $faculty, 0, 1, 'L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(65, 5, '�������������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '12');
    $pdf->MultiCell(0, 5, $spec, 0, 1, false);

    $pdf->SetFont('TimesNRCyrMT', '', 10);
    
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(10, 7.5, '� �/�', 1);

    $pdf->SetY($y);
    $pdf->SetX(20);
    $pdf->MultiCell(40, 15, '�������� ����������', 1, '�');

    $pdf->SetY($y);
    $pdf->SetX(60);
    $pdf->MultiCell(40, 7.5, '���� ������ � ����� ���������� ���������', 1, '�');
    $pdf->Ln();

    $pdf->SetY($y);
    $pdf->SetX(100);
    $pdf->MultiCell(40, 5, '���� �������� ���������� � ������ (�������) ����', 1, '�');
    $pdf->Cell(10, 5, '1.', 0, 0, 'L');
    $pdf->Cell(0, 5, '���������', 0, 1, 'L');
    $pdf->Cell(10, 5, '2.', 0, 0, 'L');
    $pdf->Cell(0, 5, '����������', 0, 1, 'L');
    $pdf->Cell(10, 5, '3.', 0, 0, 'L');
    $pdf->Cell(75, 5, '�������� �� ����������� (� �����������)', 0, 1, 'L');
    $pdf->Cell(0, 5, "$cert_type  � $cert_name �� \"$cert_d\" $cert_m $cert_y ����, ", 0, 1, 'L');
    $pdf->MultiCell(0, 5, "����� $inst_type  $inst_name $inst_city_type. $inst_city_name", 0, 1, false);
    $i=3;
    if($p->faculty!=5){
        $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
        $pdf->Cell(0, 5, '����������� ������� � ��������� ��������', 0, 1, 'L');
    }
    $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
    $pdf->Cell(0, 5, $ct_text, 0, 1, 'L');
    //$pdf->Cell(10, 5, '', 0, 0, 'L');
    $pdf->Cell(0, 5, $lct, 0, 1, 'L');
    //$pdf->Cell(10, 5, '', 0, 0, 'L');
    $pdf->Cell(0, 5, $bct, 0, 1, 'L');
    //$pdf->Cell(10, 5, '', 0, 0, 'L');
    $pdf->Cell(0, 5, $cct, 0, 1, 'L');
    
    if($p->experience_id>1 ){
        $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
        $pdf->Cell(0, 5, '������� �� �������� ������, ����� �������� ������, ����� ��������� ', 0, 1, 'L');
        $pdf->Cell(0, 5,'��������, ����� ����������-��������� ��������, ������������� � ����������� ', 0, 1, 'L');
        $pdf->Cell(0, 5,'��������������� ��������������� (������ �����������)',0,1,'L');

    }
    if($p->target==1){
        $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
        $pdf->Cell(0, 5, '������� � ������� ���������� ����������� (��������, ���������)', 0, 1, 'L');
    }
/*    if($p->target==1 || $p->target_type==2 || (($p->benefit_set & 2)==2) || (($p->benefit_set & 4)==4)){
        $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
        $pdf->Cell(0, 5, '������� � ����� ����������', 0, 1, 'L');
    }
*/
    if(($p->other_set & 2)==2){
    $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
    // ������ �������� �� ������� � �� ������
    $pdf->Cell(0, 5, '������� � ���������� ����������� �� ���� �������', 0, 1, 'L');
    }
    if(($p->other_set &4)==4)
    {
        $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
    // ������ �������� �� ������� � �� ������
    $pdf->Cell(0, 5, '������� � ���������� ����������� �� ������� ������', 0, 1, 'L');
    
    }
    $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
    $pdf->Cell(80, 5, '��������� (�����), �������������� ����� �� ������', 0, 1, 'L');
    
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    $pdf->Cell(10, 5, ++$i.'.', 0, 0, 'L');
    $pdf->Cell(35, 5, '���� ���������', 0, 1, 'L');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(30, 7.5, '��������� �������', 1, 'L');

    $pdf->SetY($y);
    $pdf->SetX(40);
    $pdf->MultiCell(30, 5, '��������� ���������� � ����� � �������', 1, 'L');

    $pdf->SetY($y);
    $pdf->SetX(70);
    $pdf->MultiCell(30, 5, '��������� ���������� ��_______', 1, 'L');

    $pdf->SetY($y);
    $pdf->SetX(100);
    $pdf->MultiCell(30, 15, '��������������', 1, 'L');
    $pdf->Cell(15, 5, '����', 1, 0, 'L');
    $pdf->Cell(15, 5, '�������', 1, 0, 'L');
    $pdf->Cell(15, 5, '����', 1, 0, 'L');
    $pdf->Cell(15, 5, '�������', 1, 0, 'L');
    $pdf->Cell(15, 5, '����', 1, 0, 'L');
    $pdf->Cell(15, 5, '�������', 1, 0, 'L');
    $pdf->Cell(15, 5, '����', 1, 0, 'L');
    $pdf->Cell(15, 5, '�������', 1, 1, 'L');
    $pdf->Cell(15, 5, "$ctime_d.$ctime_m.$ctime_y", 1, 0, 'L');
    $pdf->Cell(15, 5, '', 1, 0, 'L');
    $pdf->Cell(15, 5, '', 1, 0, 'L');
    $pdf->Cell(15, 5, '', 1, 0, 'L');
    $pdf->Cell(15, 5, '', 1, 0, 'L');
    $pdf->Cell(15, 5, '', 1, 0, 'L');
    $pdf->Cell(15, 5, '', 1, 0, 'L');
    $pdf->Cell(15, 5, '', 1, 1, 'L');
}

function average($pdf, $p, $options) {

    $faculty = ui_pdf_sap($options['faculty'], $p->faculty);
    $time_form_id = ui_pdf_sap($options['time_form'], $p->time_form_id);
//    $spec = ui_pdf_sap($options['spec'], $p->faculty);
    $spec = ui_pdf_sap($options['speccode'], $p->faculty).' '.ui_pdf_sap($options['spec'], $p->faculty);

    $executor = ui_pdf_sap($options['settings'],'executor');
    
    
    $ctime=  db_dt2arr($p->ctime);
    $ctime_d = $ctime['d'];
    $ctime_m = ui_pdf_sap($options['issued'],$ctime['m']);
    $ctime_y = $ctime['y'];
    
    
    $pdf->SetMargins(30, 15, 10);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage('L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 12);
    $pdf->Cell(0, 7, '', 0, 1, 'C');
    
    $pdf->Cell(60, 7, '����� ����', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->delo_name, 0, 1, 'L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(60, 7, '�������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->surname, 0, 1, 'L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(60, 7, '���', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->name, 0, 1, 'L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(60, 7, '��������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->midname, 0, 1, 'L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(60, 7, '���������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $faculty, 0, 1, 'L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(60, 7, '���������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $time_form_id, 0, 1, 'L');
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(60, 7, '�������������', 0, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $spec, 0, 1, 'L');

    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(10, 7, '� �/�', 1, 0, 'C');
    $pdf->Cell(60, 7, '������������ ��������', 1, 0, 'C');
    $pdf->Cell(80, 7, '����������', 1, 0, 'C');
    $pdf->Cell(0, 7, '����', 1, 1, 'C');

    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(10, 7, '1.', 1, 0, 'C');
    $pdf->Cell(60, 7, '����', 1, 0, 'L');
    $pdf->Cell(80, 7, "����� $p->lct_sn � $p->lct_xn", 1, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->lct_sum, 1, 1, 'C');

    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(10, 7, '2.', 1, 0, 'C');
    $pdf->Cell(60, 7, '��������', 1, 0, 'L');
    $pdf->Cell(80, 7, "����� $p->bct_sn � $p->bct_xn", 1, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->bct_sum, 1, 1, 'C');

    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(10, 7, '3.', 1, 0, 'C');
    $pdf->Cell(60, 7, '�����', 1, 0, 'L');
    $pdf->Cell(80, 7, "����� $p->cct_sn � $p->cct_xn", 1, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->cct_sum, 1, 1, 'C');       


    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(10, 7, '4.', 1, 0, 'C');
    $pdf->Cell(140, 7, '������� ���� ��������� �� �����������', 1, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->certificate_sum, 1, 1, 'C');

    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(150, 7, '����� ��������� ������', 1, 0, 'L');
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '14');
    $pdf->Cell(0, 7, $p->total, 1, 1, 'C');
    $pdf->Ln(5);
    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    
    $pdf->Cell(0, 5, '������������� ���������', 0, 1, 'L');
    $pdf->Cell(35, 5, '������� ��������', 0, 0, 'L');
    $pdf->Cell(35, 5, '', 'B', 0, 'R');
    $pdf->Cell(46, 5, '', '', 0, 'R');
    
    $pdf->Cell(0, 5, $executor, 'B', 1, 'R');
    $pdf->SetFontSize(8);
    $pdf->Cell(35, 5, '', '', 0, 'R');
    $pdf->Cell(35, 5, '(�������)', '', 0, 'C');
    $pdf->Cell(55, 5, '', '', 0, 'R');
    
    $pdf->Cell(35, 5, '(��������, �������)', '', 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0, 5, '�.�.', 0, 1, 'L');

    
    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->Cell(100, 7, "\"$ctime_d\" $ctime_m $ctime_y �. ", 0, 0, 'C');
    $pdf->Cell(0, 7, $p->private.'  '.$p->serial, 0, 1, 'C');
}

function envelop($pdf, $p, $options) {
    
    $komu = mk_komu($p);
    $kuda =  mk_addr($p, $options);
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT', '', 14);


    $pdf->SetY(100);
    $pdf->SetX(120);
    $pdf->Cell(15, 6, '����:');
    $pdf->Cell(100, 6, $komu, 0, 1);
    $pdf->SetX(120);
    
    $pdf->Cell(15, 6, '����:');
    $x = $pdf->GetX();
    foreach ($kuda as $v) {
        $pdf->SetX($x);
        $pdf->Cell(100, 6, $v, 0, 1);
    }
}

function inventory($pdf, $p, $options, $documents = array(),$cnt=array()) {
    $title = "�����";
    $subtitle = "����������, ������� ���� � ������ ����";
    $unline = "(�������, ���, ��������)";

    $cert_flag=false;
    $certs = array();
    $certs[] = 'return \'����������� ��:\';';
    $cert_flag=($p->lct_id==2)?true:$cert_flag;
    $cert_flag=($p->cct_id==2)?true:$cert_flag;
    $cert_flag=($p->bct_id==2)?true:$cert_flag;
    
    if($p->lct_id==1)
    {
	$certs[] = "return '���� $p->lct_sn $p->lct_xn';";
    }
    if($p->bct_id==1)
    {
	$certs[] = "return '���. $p->bct_sn $p->bct_xn';";
    }
    if($p->cct_id==1)
    {
	$certs[] = "return '���. $p->cct_sn $p->cct_xn';";
    }
    if($cert_flag)
    {
	$certs[] = 'return \'����� �������\';';
	$certs[] = 'return \'���������� ���������\';';
    }
    

    $edu_doc = ui_pdf_sap($options['certificate_id'],$p->certificate_id);
  
 


    $c = array();
    $c[1] = "�\n�/�";
    $c[2] = "�������� ���������\n ";
    $c[3] = "����������\n������";
    $c[4] = "��\n������";
    $c[5] = "��� ������ ��������\n� �� ����� �������";
    $w = array(1 => 13, 51, 31, 20, 54);

    $row_index = 0;

    $npp = 0;

    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '16');
    $pdf->SetLeftMargin(29);
    $pdf->SetTopMargin(21);

    $pdf->Cell(0, 10, $title, 0, 1, 'C');
    $pdf->SetFont('TimesNRCyrMT', '', '14');
    $pdf->Cell(0, 10, $subtitle, 0, 1, 'C');
    $pdf->Cell(0, 4, "$p->surname $p->name $p->midname", 0, 1, 'C');
    $pdf->Cell(0, 0.1, '', 1, 1, 'C', 1);
    $pdf->Cell(0, 10, $unline, 0, 1, 'C');
    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->SetFont('TimesNRCyrMT', '', '12');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    foreach ($c as $k => $v) {
        $x = $pdf->GetX();
        $pdf->MultiCell($w[$k], 5, $v, 1, 'C');
        $pdf->SetY($y);
        $pdf->SetX($x + $w[$k]);
    }
    $pdf->Cell(1, 10, '', 0, 1);
    foreach ($documents as $v) {
        $npp++;
        $f = true;
        foreach ($v as $line) {
            $xnpp = ($f) ? $npp : '';
            
	    $ccnt = (isset($cnt[$npp]))?$cnt[$npp]:'1';
            $xcnt = ($f) ? $ccnt : '';
            
            $f = false;
            $line = eval($line);
            //if($line=='����� ��������') $xcnt=3;
            //if($line=='������� �������') $xcnt=3;
            //if($line=='������� � �����') $xcnt=2;
            $pdf->Cell($w[1], 6, $xnpp, 1, 0, 'C');
            $pdf->Cell($w[2], 6, $line, 1, 0, 'L');
            $pdf->Cell($w[3], 6, $xcnt, 1, 0, 'C');
            $pdf->Cell($w[4], 6, '', 1);
            $pdf->Cell($w[5], 6, '', 1, 1);
            $row_index++;
        }
    }

    for ($i = $row_index; $i < 35; $i++) {
        $pdf->Cell($w[1], 6, '', 1, 0, 'C');
        $pdf->Cell($w[2], 6, '', 1, 0, 'L');
        $pdf->Cell($w[3], 6, '', 1);
        $pdf->Cell($w[4], 6, '', 1);
        $pdf->Cell($w[5], 6, '', 1, 1);
    }

    $pdf->SetFont('TimesNRCyrMT', '', '6');
    $pdf->Cell(0, 3, "BSMU 2012 $p->id-{$p->faculty}-{$p->time_form_id}-{$p->edu_form}-{$p->target}-{$p->target_type}-{$p->delo_int}", 0, 1, 'R');
}

function notification($pdf, $p, $options) {
    $komu = mk_komu($p);
    $kuda =  mk_addr($p, $options);
    
    $arrive_date = $p->arrive_date;
    $arrive_time = substr($p->arrive_time,0,5);
    $arrive_room = $p->arrive_room;
    $order_date = $p->order_date;
    $order_num  = $p->order_num;
    $out_course = $p->out_course;
    
    $a=array();
    $a=  db_d2arr($order_date);
    $order_date = $a['d'] .' '. ui_pdf_sap($options['issued'],$a['m']). ' '.$a['y'].' ����';
    $a= db_d2arr($arrive_date);
    $arrive_date = $a['d'] .' '. ui_pdf_sap($options['issued'],$a['m']). ' '.$a['y'].' ����';
    
    
    $faculty = ui_pdf_sap($options['faculty'], $p->faculty);
    $time_form_id = ui_pdf_sap($options['time_form'], $p->time_form_id);
    $spec = ui_pdf_sap($options['spec'], $p->faculty);
    $speccode = ui_pdf_sap($options['speccode'], $p->faculty);
    $place = ui_pdf_sap($options['place'],$p->faculty);
    $chief = ui_pdf_sap($options['chief'],$p->faculty);
    $chief_phone = ui_pdf_sap($options['chief_phone'],$p->faculty);
    
    $pdf->SetMargins(10, 30, 10);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT', '', 12);


    //$pdf->SetY(40);
    $pdf->SetY(30);
    $pdf->SetX(130);
    $pdf->Cell(15, 5, '����:');
    $pdf->Cell(100, 5, $komu, 0, 1);
    $pdf->SetX(110);
    //$pdf->Cell(15, 5, '����:');
    $x = $pdf->GetX();
    
    //$pdf->SetX($x);
    //$pdf->MultiCell(80, 5, implode("\n",$kuda), 0, 1);

//    $arrive_date = '"__" ������� 2012 ����';
//    $arrive_time = '__:__';

    //$pdf->SetY(50);
    $pdf->SetY(40);
    $pdf->SetFont('TimesNRCyrMT', '', '12');
    $pdf->Cell(0,7,'���������',0,1,'C');
//    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."������� �������� ��������, ��� �������� �� ���������� ����������� ������������ ��������������� ����������� ����������� � $order_num �� $order_date �� ��������� � ����� ��������� ������� ����� �� $time_form_id ��������� ����������: �${faculty}� �� ������������� (�������������) $speccode �${spec}�  � ������ ������� �� �������������� � ������� ����������. ���������� � ������� � ����� ���������� ������������� ��������� �� ����� www.bsmu.by � ������� '����������'-'����������� ����� � �����'.",0,'J');
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."������� �������� ��������, ��� �������� �� ���������� ����������� ������������ ��������������� ����������� ����������� � 1050-C �� 03.08.16 �� ��������� � ����� ��������� ������� ����� �� $time_form_id ��������� ����������: �${faculty}� �� ������������� (�������������) $speccode �${spec}�  � ������ ������� �� �������������� � ������� ����������. ���������� � ������� � ����� ���������� ������������� ��������� �� ����� www.bsmu.by � ������� '����������'-'����������� ����� � �����'.",0,'J');
//    $pdf->Cell(0,7,"�� $time_form_id ��������� ����������: $faculty �� ������������� (�������������) $speccode �${spec}�",0,1,'L');
//    $pdf->Cell(0,7,'����������: '.$faculty,0,0,'L');
//    $pdf->Cell(0,7,'�� ������������� (�������������) ' . $speccode .' �'.$spec.'�',0,1,'L');
//    $pdf->MultiCell(0,7,"� ������ ������� � ���������� ����������� $arrive_date � $arrive_time � ��������� � $arrive_room �������� �������.",0,'J');
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."������� ���������� ���������� $place. ����� $chief (���. $chief_phone). ����������� ��� ��������� ����� � ��������� ���������� ������������ ���������, ������� � ������� ����� � ������� � ������� ������ ����� �� 12 �������. ",0,'J');
//    $pdf->SetFont('TimesNRCyrMT', '', 10);
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."��������� �������� ������� �����, �� �������� � ������� ������ ���� ���������� ����� ����� ����. ��� ���������� � ���� ���� - 2 ���������� 3*4.",0,'J');
//    $pdf->SetFont('TimesNRCyrMT', '', 12);
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160),0,'J');
    $pdf->SetY(125);//$pdf->SetY(135);
    $pdf->Cell(0,5,'������������� ���������',0,1,'L');
    $pdf->Cell(100,7,'������� ��������',0,0,'L');
    $pdf->Cell(0,7,$options['settings']['executor'],0,1,'R');
//    $pdf->Cell(0,5,$order_date,0,1,'L');
    $pdf->Cell(0,5,"03.08.16",0,1,'L');
}
function notification_z($pdf, $p, $options) {
    $komu = mk_komu($p);
    $kuda =  mk_addr($p, $options);
    
    $arrive_date = $p->arrive_date;
    $arrive_time = substr($p->arrive_time,0,5);
    $arrive_room = $p->arrive_room;
    $order_date = $p->order_date;
    $order_num  = $p->order_num;
    $out_course = $p->out_course;
    
    $a=array();
    $a=  db_d2arr($order_date);
    $order_date = $a['d'] .' '. ui_pdf_sap($options['issued'],$a['m']). ' '.$a['y'].' ����';
    $a= db_d2arr($arrive_date);
    $arrive_date = $a['d'] .' '. ui_pdf_sap($options['issued'],$a['m']). ' '.$a['y'].' ����';
    
    
    $faculty = ui_pdf_sap($options['faculty'], $p->faculty);
    $time_form_id = ui_pdf_sap($options['time_form'], $p->time_form_id);
    $edu_form = ui_pdf_sap($options['edu_form'],$p->edu_form);
    $spec = ui_pdf_sap($options['spec'], $p->faculty);
    $speccode = ui_pdf_sap($options['speccode'], $p->faculty);
    $place = ui_pdf_sap($options['place'],$p->faculty);
    $chief = ui_pdf_sap($options['chief'],$p->faculty);
    $chief_phone = ui_pdf_sap($options['chief_phone'],$p->faculty);
    
    $pdf->SetMargins(10, 30, 10);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT', '', 12);


    $pdf->SetY(40);
    $pdf->SetX(130);
    $pdf->Cell(15, 5, '����:');
    $pdf->Cell(100, 5, $komu, 0, 1);
    $pdf->SetX(110);
    //$pdf->Cell(15, 5, '����:');
    $x = $pdf->GetX();
    
    //$pdf->SetX($x);
    //$pdf->MultiCell(80, 5, implode("\n",$kuda), 0, 1);

//    $arrive_date = '"__" ������� 2012 ����';
//    $arrive_time = '__:__';

    $pdf->SetY(50);
    $pdf->SetFont('TimesNRCyrMT', '', '12');
    $pdf->Cell(0,7,'���������',0,1,'C');
//    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."������� �������� ��������, ��� �������� �� ���������� ����������� ������������ ��������������� ����������� ����������� � $order_num �� $order_date. �� ��������� � ����� ��������� ������� ����� �� $time_form_id $edu_form ��������� ����������: �${faculty}� �� ������������� (�������������) $speccode �${spec}� � ������ ������� �� �������������� � ������� ����������. ���������� � ������� � ����� ���������� ������������� ��������� �� ����� www.bsmu.by � ������� '����������'-'����������� ����� � �����'.",0,'J');
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."������� �������� ��������, ��� �������� �� ���������� ����������� ������������ ��������������� ����������� ����������� � 1050-� �� 03.08.2016 �. �� ��������� � ����� ��������� ������� ����� �� $time_form_id $edu_form ��������� ����������: �${faculty}� �� ������������� (�������������) $speccode �${spec}� � ������ ������� �� �������������� � ������� ����������. ���������� � ������� � ����� ���������� ������������� ��������� �� ����� www.bsmu.by � ������� '����������'-'����������� ����� � �����'.",0,'J');
//    $pdf->Cell(0,7,"�� $time_form_id ��������� ����������: $faculty �� ������������� (�������������) $speccode �${spec}�",0,1,'L');
//    $pdf->Cell(0,7,'����������: '.$faculty,0,0,'L');
//    $pdf->Cell(0,7,'�� ������������� (�������������) ' . $speccode .' �'.$spec.'�',0,1,'L');
//    $pdf->MultiCell(0,7,"� ������ ������� � ���������� ����������� $arrive_date � $arrive_time � ��������� � $arrive_room �������� �������.",0,'J');
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."������� ���������� ���������� $place. ����� $chief (���. $chief_phone). ",0,'J');
//    $pdf->SetFont('TimesNRCyrMT', '', 10);
//    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."��������� �������� ������� �����, �� �������� � ������� ������ ���� ���������� ����� ����� ����. ��� ���������� � ���� ���� - 2 ���������� 3*4.",0,'J');
//    $pdf->SetFont('TimesNRCyrMT', '', 12);
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."������������ ���� http://student.bsmu.by/",0,'J');
    $pdf->SetY(135);
    $pdf->Cell(0,4,'������������� ���������',0,1,'L');
    $pdf->Cell(100,4,'������� ��������',0,0,'L');
    $pdf->Cell(0,0,$options['settings']['executor'],0,1,'R');
//    $pdf->Cell(0,5,$order_date,0,1,'L');
    $pdf->Cell(0,16,"03 ������� 2016 ����",0,1,'L');
}

function order_extract($pdf, $p, $options) {
    $ef=ui_pdf_sap($options['edu_form'],$p->edu_form);
    $fc=ui_pdf_sap($options['faculty'],$p->faculty);
    $fio =$p->surname . ' ' . $p->name . ' ' . $p->midname;
    setlocale(LC_ALL, 'be_BY.CP1251');
    $spec = ucfirst(ui_pdf_sap($options['spec'], $p->faculty));
    $speccode = ui_pdf_sap($options['speccode'], $p->faculty);
    $tf=ui_pdf_sap($options['time_form_id'],$p->time_form_id);    
    $a=array();
//    $a=  db_d2arr($p->order_date);
    $a=  db_d2strarr(date("Y-n-d"));
    $order_date = $a['d'] .' '. ui_pdf_sap($options['issued'],$a['m']). ' '.$a['y'].' ����';
    
    //$a=  db_d2strarr($p->proto_date);
    $a=  db_d2strarr(date("Y-m-d"));
    $proto_date = $a['d'] .'.'. $a['m']. '.'.$a['y'].'';
    
    
    $pdf->SetMargins(20, 20, 5);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT', '', 14);
    //$pdf->Cell(0,7,'������� �� ������� � 1002-C' .$p->order_num,0,1,'C');
    $pdf->Cell(0,7,'������� �� ������� � 1050-C' .$p->order_num,0,1,'C');
    $pdf->Cell(0,7,'������� ������������ ���������������� ������������ ������������',0,1,'C');
    $pdf->Cell(100,7,'�. �����',0,0,'L');
//    $pdf->Cell(0,7,$order_date,0,1,'R');
    $pdf->Cell(0,7,"03 ������� 2016 �.",0,1,'R');
    ///$pdf->SetX(20);
//    $pdf->Cell(10,7,'',0,0,'C');
//    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."� ������������ � ��������� ������ � ������ ������� ���������, ������������� ������ ���������� ���������� �������� �� 07.02.2006 � 80, �������� ������������ ��������������� ���������� �������� �� 04.03.2015 � 201, �������� ������������ ��������������� ���������� �������� �� 20.03.2015 � 280 � ���������� ������� �������� ���������� ����������� ������������ ��������������� ����������� ����������� �� 18.07.2015 $proto_date � $p->proto_num 1020-C",'','J');
    //$pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."� ������������ � ��������� ������ � ������ ������� ���������, ������������� ������ ���������� ���������� �������� �� 07.02.2006 � 80, ������� ������������ ����������� ���������� �������� �� 12.05.2016 �08-19/1260 � ���������� ������� �������� ���������� ����������� ������������ ��������������� ����������� ����������� �� 18.07.2016 � 8",'','J');
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."� ������������ � ��������� ������ ��� ��� ��������� ������� ����������� I �������, ������������� ������ ���������� ���������� �������� �� 07.02.2006 � 80, �������� ������������ ��������������� ���������� �������� �� 26.02.2016 �155, �������� ������������ ��������������� ���������� �������� �� 21.03.2016 �224 � ���������� ������� �������� ���������� ����������� ������������ ��������������� ����������� ����������� �� 03.08.2016 � 13",'','J');
    $pdf->Cell(0,7,'����������:',0,1,'L');
//    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."��������� �� ������ ���� $fc ���������� ���������� ����������� ������������ ��������������� ����������� ����������� ��� �������� $ef � $tf ����� ��������� ����������� �� ������������� $speccode  �${spec}� c 01.09.2016:",0,'J');    
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."��������� �� ������ ���� $fc ���������� ���������� ����������� ������������ ��������������� ����������� ����������� ��� �������� �� ������� ������ � $tf ����� ��������� ����������� �� ������������� $speccode  �${spec}� c 01.09.2016:",0,'J');
//    $pdf->Cell(0,7,$ef,0,1,'L');
//    $pdf->Cell(0,7,'�� ������������� '. $speccode .' �'.$spec.'� c 1.09.2012' ,0,1,'L');
    $pdf->Cell(0,7,$fio,0,1,'L');
    $pdf->SetY(130);
    $pdf->Cell(100,7,'������',0,0,'L');
    $pdf->Cell(0,7,$options['settings']['rector'],0,1,'R');
    $pdf->Cell(0,7,'������� �����:',0,1,'L');
    
}

function order_extract_paid($pdf, $p, $options) {
    $ef=ui_pdf_sap($options['edu_form'],$p->edu_form);
    $fc=ui_pdf_sap($options['faculty'],$p->faculty);
    $fio =$p->surname . ' ' . $p->name . ' ' . $p->midname;
    setlocale(LC_ALL, 'be_BY.CP1251');
    $spec = ucfirst(ui_pdf_sap($options['spec'], $p->faculty));
    $speccode = ui_pdf_sap($options['speccode'], $p->faculty);
    $tf=ui_pdf_sap($options['time_form_id'],$p->time_form_id);    
    $a=array();
    $a=  db_d2arr($p->order_date);
    $order_date = $a['d'] .' '. ui_pdf_sap($options['issued'],$a['m']). ' '.$a['y'].' ����';
    
    $a=  db_d2strarr($p->proto_date);
    $proto_date = $a['d'] .'.'. $a['m']. '.'.$a['y'].'';
    
    
    $pdf->SetMargins(20, 20, 5);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT', '', 14);
//    $pdf->Cell(0,7,'������� �� ������� � ' .$p->order_num,0,1,'C');
    $pdf->Cell(0,7,'������� �� ������� � 1050-C',0,1,'C');
    $pdf->Cell(0,7,'������� ������������ ���������������� ������������ ������������',0,1,'C');
    $pdf->Cell(100,7,'�. �����',0,0,'L');
//    $pdf->Cell(0,7,$order_date,0,1,'R');
    $pdf->Cell(0,7,'3 ������� 2016 �.',0,1,'R');
    ///$pdf->SetX(20);
//    $pdf->Cell(10,7,'',0,0,'C');
//    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."� ������������ � ��������� ������ � ������ ������� ���������, ������������� ������ ���������� ���������� �������� �� 07.02.2006 � 80, �������� ������������ ��������������� ���������� �������� �� 13.02.2014 � 122 � ���������� ������� �������� ���������� ����������� ������������ ��������������� ����������� ����������� �� $proto_date � $p->proto_num",'','J');
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."� ������������ � ��������� ������ � ������ ������� ���������, ������������� ������ ���������� ���������� �������� �� 07.02.2006 � 80, �������� ������������ ��������������� ���������� �������� �� 26.02.2016 � 155 � ���������� ������� �������� ���������� ����������� ������������ ��������������� ����������� ����������� �� 03.08.2016 � 13",'','J');
    $pdf->Cell(0,7,'����������:',0,1,'L');
    
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."��������� �� ������ ���� $fc ���������� ���������� ����������� ������������ ��������������� ����������� ����������� ��� �������� $ef � $tf ����� ��������� ����������� �� ������������� $speccode  �${spec}� c 01.09.2016:",0,'J');
//    $pdf->Cell(0,7,$ef,0,1,'L');
//    $pdf->Cell(0,7,'�� ������������� '. $speccode .' �'.$spec.'� c 1.09.2012' ,0,1,'L');
    $pdf->Cell(0,7,$fio,0,1,'L');
    $pdf->SetY(130);
    $pdf->Cell(100,7,'������',0,0,'L');
    $pdf->Cell(0,7,$options['settings']['rector'],0,1,'R');
    $pdf->Cell(0,7,'������� �����:',0,1,'L');
    
}

function order_extract_paid2p($pdf, $p, $options) {
    $ef=ui_pdf_sap($options['edu_form'],$p->edu_form);
    $fc=ui_pdf_sap($options['faculty'],$p->faculty);
    $fio =$p->surname . ' ' . $p->name . ' ' . $p->midname;
    setlocale(LC_ALL, 'be_BY.CP1251');
    $spec = ucfirst(ui_pdf_sap($options['spec'], $p->faculty));
    $speccode = ui_pdf_sap($options['speccode'], $p->faculty);
    $tf=ui_pdf_sap($options['time_form_id'],$p->time_form_id);    
    $a=array();
    $a=  db_d2arr($p->order_date);
    $order_date = $a['d'] .' '. ui_pdf_sap($options['issued'],$a['m']). ' '.$a['y'].' ����';
    
    $a=  db_d2strarr($p->proto_date);
    $proto_date = $a['d'] .'.'. $a['m']. '.'.$a['y'].'';
    
    
    $pdf->SetMargins(20, 20, 5);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT', '', 14);
    $pdf->Cell(0,7,'������� �� ������� � ' .$p->order_num,0,1,'C');
    $pdf->Cell(0,7,'������� ������������ ���������������� ������������ ������������',0,1,'C');
    $pdf->Cell(100,7,'�. �����',0,0,'L');
    $pdf->Cell(0,7,$order_date,0,1,'R');
    ///$pdf->SetX(20);
//    $pdf->Cell(10,7,'',0,0,'C');
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."� ������������ � ��������� ������ � ������ ������� ���������, ������������� ������ ���������� ���������� �������� �� 07.02.2006 � 80, �������� ������������ ��������������� ���������� �������� �� 13.02.2014 � 122 � � ���������� ������� �������� ���������� ����������� ������������ ��������������� ����������� ����������� �� 01.08.2014 � 11",'','J');
    $pdf->Cell(0,7,'����������:',0,1,'L');
    
    $pdf->MultiCell(0,7,chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160).chr(160)."��������� �� ������ ���� $fc ���������� ���������� ����������� ������������ ��������������� ����������� ����������� ��� �������� $ef � $tf ����� ��������� ����������� �� ������������� $speccode  �${spec}� c 01.09.2014:",0,'J');
//    $pdf->Cell(0,7,$ef,0,1,'L');
//    $pdf->Cell(0,7,'�� ������������� '. $speccode .' �'.$spec.'� c 1.09.2012' ,0,1,'L');
    $pdf->Cell(0,7,$fio,0,1,'L');
    $pdf->SetY(130);
    $pdf->Cell(100,7,'������',0,0,'L');
    $pdf->Cell(0,7,$options['settings']['rector'],0,1,'R');
    $pdf->Cell(0,7,'������� �����:',0,1,'L');
    
}


function mk_addr($p, $options) {
    $str = '';
//$komu ='';
    $kuda = array();
    /*
      $komu = (strlen($p['surname']))?    $p['surname']:'';
      $komu = (strlen($p['name']))?       $komu.' '.substr($p['name'],0,1).'.':$komu;
      $komu = (strlen($p['midname']))?    $komu.' '.substr($p['name'],0,1).'.':$komu;
     */
    if (strlen($p->street))
        $kuda[] = $p->street;

    if (strlen($p->microarea))
        $kuda[] = '���-� ' . $p->microarea;

    if (strlen($p->house))
        $str = '�. ' . $p->house;
    if (strlen($p->house_part))
        $str.= ', ����. ' . $p->house_part;
    if (strlen($p->room))
        $str.= ', ��. ' . $p->room;
    if (strlen($str))
        $kuda[] = $str;
    $str = '';

    if (strlen($p->zip))
        $str = $p->zip;
    if ($p->subdiv)
        $str.=' ' . ui_pdf_sap($options['subdiv'], $p->subdiv) ;
    if (strlen($p->city_name))
        $str.=' ' . $p->city_name;
    if (strlen($str))
        $kuda[] = $str;
    $str = '';

    if (strlen($p->area))
        $kuda[] = $p->area . ' �����';

    if (strlen($p->region_text))
        $kuda[] = $p->region_text;

    if ($p->region_by)
        $kuda[] = ui_pdf_sap($options['region_by'], $p->region_by);

    if ($p->country)
        $kuda[] = ui_pdf_sap($options['country'], $p->country);

    return $kuda;
}

function mk_komu($p) {
    $komu = '';
    $komu = (strlen($p->surname)) ? $p->surname : '';
    $komu = (strlen($p->name)) ? $komu . ' ' . substr($p->name, 0, 1) . '.' : $komu;
    $komu = (strlen($p->midname)) ? $komu . ' ' . substr($p->midname, 0, 1) . '.' : $komu;

    return $komu;
}

function envelop_printed($pdf, $p, $options) {
    
    $komu = mk_komu($p);
    //$zip = $p->zip;
    //$p->zip='';
    $kuda =  mk_addr($p, $options);
    
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(0);
    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT', '', 14);


    $pdf->SetY(95);
    $pdf->SetX(117);
    $pdf->Cell(15, 6, '');
    $pdf->Cell(100, 6, $komu, 0, 1);
    $pdf->SetY(118);
    $pdf->SetX(117);
    $pdf->Cell(15, 6, '');
    $x = $pdf->GetX();
    foreach ($kuda as $v) {
        $pdf->SetX($x);
        $pdf->Cell(100, 8, $v, 0, 1);
    }
}

function inventory_clear($pdf, $p, $options, $documents = array(),$cnt=array()) {
    $title = "�����";
    $subtitle = "����������, ������� ���� � ������ ����";
    $unline = "(�������, ���, ��������)";

    $cert_flag=false;
    $certs = array();
    $certs[] = 'return \'����������� ��:\';';
    $cert_flag=($p->lct_id==2)?true:$cert_flag;
    $cert_flag=($p->cct_id==2)?true:$cert_flag;
    $cert_flag=($p->bct_id==2)?true:$cert_flag;
    
    if($p->lct_id==1)
    {
	$certs[] = "return '���� $p->lct_sn $p->lct_xn';";
    }
    if($p->bct_id==1)
    {
	$certs[] = "return '���. $p->bct_sn $p->bct_xn';";
    }
    if($p->cct_id==1)
    {
	$certs[] = "return '���. $p->cct_sn $p->cct_xn';";
    }
    /*if($cert_flag)
    {
	$certs[] = 'return \'����� �������\';';
	$certs[] = 'return \'���������� ���������\';';
    }*/
    

    


    $c = array();
    $c[1] = "�\n�/�";
    $c[2] = "�������� ���������\n ";
    $c[3] = "����������\n������";
    $c[4] = "��\n������";
    $c[5] = "��� ������ ��������\n� �� ����� �������";
    $w = array(1 => 13, 51, 31, 20, 54);

    $row_index = 0;

    $npp = 0;

    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '16');
    $pdf->SetLeftMargin(29);
    $pdf->SetTopMargin(21);

    $pdf->Cell(0, 10, $title, 0, 1, 'C');
    $pdf->SetFont('TimesNRCyrMT', '', '14');
    $pdf->Cell(0, 10, $subtitle, 0, 1, 'C');
    $pdf->Cell(0, 4, "$p->surname $p->name $p->midname", 0, 1, 'C');
    $pdf->Cell(0, 0.1, '', 1, 1, 'C', 1);
    $pdf->Cell(0, 10, $unline, 0, 1, 'C');
    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->SetFont('TimesNRCyrMT', '', '12');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    foreach ($c as $k => $v) {
        $x = $pdf->GetX();
        $pdf->MultiCell($w[$k], 5, $v, 1, 'C');
        $pdf->SetY($y);
        $pdf->SetX($x + $w[$k]);
    }
    $pdf->Cell(1, 10, '', 0, 1);
    foreach ($documents as $v) {
        $npp++;
        $f = true;
        ;
        foreach ($v as $line) {
            $xnpp = ($f) ? $npp : '';
            
	    $ccnt = (isset($cnt[$npp]))?$cnt[$npp]:'1';
            $xcnt = ($f) ? $ccnt : '';
            
            $f = false;
            $line = eval($line);
            //if($line=='����� ��������') $xcnt=3;
            //if($line=='������� �������') $xcnt=3;
            //if($line=='������� � �����') $xcnt=2;
            $pdf->Cell($w[1], 6, $xnpp, 1, 0, 'C');
            $pdf->Cell($w[2], 6, $line, 1, 0, 'L');
            $pdf->Cell($w[3], 6, $xcnt, 1, 0, 'C');
            $pdf->Cell($w[4], 6, '', 1);
            $pdf->Cell($w[5], 6, '', 1, 1);
            $row_index++;
        }
    }

    for ($i = $row_index; $i < 35; $i++) {
        $pdf->Cell($w[1], 6, '', 1, 0, 'C');
        $pdf->Cell($w[2], 6, '', 1, 0, 'L');
        $pdf->Cell($w[3], 6, '', 1);
        $pdf->Cell($w[4], 6, '', 1);
        $pdf->Cell($w[5], 6, '', 1, 1);
    }

    $pdf->SetFont('TimesNRCyrMT', '', '6');
    $pdf->Cell(0, 3, "BSMU 2012 $p->id-{$p->faculty}-{$p->time_form_id}-{$p->edu_form}-{$p->target}-{$p->target_type}-{$p->delo_int}", 0, 1, 'R');
}

function inventory_csv($pdf, $p, $options, $documents = array(),$cnt=array()) {
    $title = "�����";
    $subtitle = "����������, ������� ���� � ������ ����";
    $unline = "(�������, ���, ��������)";

    $cert_flag=false;
    $certs = array();
    $certs[] = 'return \'����������� ��:\';';
    $cert_flag=($p->lct_id==2)?true:$cert_flag;
    $cert_flag=($p->cct_id==2)?true:$cert_flag;
    $cert_flag=($p->bct_id==2)?true:$cert_flag;
    
    if($p->lct_id==1)
    {
	$certs[] = "return '���� $p->lct_sn $p->lct_xn';";
    }
    if($p->bct_id==1)
    {
	$certs[] = "return '���. $p->bct_sn $p->bct_xn';";
    }
    if($p->cct_id==1)
    {
	$certs[] = "return '���. $p->cct_sn $p->cct_xn';";
    }
    /*if($cert_flag)
    {
	$certs[] = 'return \'����� �������\';';
	$certs[] = 'return \'���������� ���������\';';
    }*/
    

    $edu_doc = ui_pdf_sap($options['certificate_id'],$p->certificate_id);
    if (empty($documents)) {
        $documents[] = array('return \'���������\';');
        $documents[] = array('return \''.$edu_doc.'\';');
        if(!empty($p->live_data)){
    	    $documents[] = array('return \'������� � �����\';','return \'����������\';');
        }
        if((($p->benefit_set & 2)==2) || (($p->benefit_set & 4)==4)){
    	    $documents[] = array('return \'�����\';','return \'������������� ����\';');    	    
        }
        if(($p->benefit_set & 128)==128){
    	    $documents[] = array('return \'�����\';','return \'������������� ���\';');    	    
        }
        if(($p->benefit_set & 8)==8){
    	    $documents[] = array('return \'������� ����\';');
    	    $documents[] = array('return \'�����\';','return \'������������� ��������\';');    	    
        }
        if($p->faculty==6 && $p->time_form_id==2)
        {
    	    $documents[] = array('return \'����� �������� ������\';');
        }
        if($p->out_target==1){
    	    $documents[] = array('return \'������� �������\';');
        }
        if($p->target==2){
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');
        }
        else{
        /*
        $documents[] = array('return \'����������� ��:\';',
            "return '���� $p->lct_sn $p->lct_xn';",
            "return '���. $p->bct_sn $p->bct_xn';",
            "return '���. $p->cct_sn $p->cct_xn';");
            */
            $documents[]=$certs;
        }
        /*if($cert_flag)
        {
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');
        }*/
        $documents[] = array('return \'�������� � �����������\';',
            'return \'�� � ������� �����\';'
        );
        if((($p->benefit_set & 64)==64) || $cert_flag){
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');    	    
        }
        /*
        if(($p->benefit_set & 64)==64){
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');    	    
        }
        */
        if($p->edu_form==1){
        $documents[] = array('return \'������� � ����������\';',
            'return \'�� ���� �������\';'
        );
        }
        else
        {
        $documents[] = array('return \'�������\';' );
        }
        $documents[] = array('return \'������� �� �������\';');
        
        
        
    }
    


    $c = array();
    $c[1] = "�\n�/�";
    $c[2] = "�������� ���������\n ";
    $c[3] = "����������\n������";
    $c[4] = "��\n������";
    $c[5] = "��� ������ ��������\n� �� ����� �������";
    $w = array(1 => 13, 51, 31, 20, 54);

    $row_index = 0;

    $npp = 0;

    //$pdf->AddPage();
    //$pdf->SetFont('TimesNRCyrMT-Bold', '', '16');
    //$pdf->SetLeftMargin(29);
    //$pdf->SetTopMargin(21);

    //$pdf->Cell(0, 10, $title, 0, 1, 'C');
    //$pdf->SetFont('TimesNRCyrMT', '', '14');
    //$pdf->Cell(0, 10, $subtitle, 0, 1, 'C');
    //$pdf->Cell(0, 4, "$p->surname $p->name $p->midname", 0, 1, 'C');
    print "\"$p->surname $p->name $p->midname\";";
    //$pdf->Cell(0, 0.1, '', 1, 1, 'C', 1);
    //$pdf->Cell(0, 10, $unline, 0, 1, 'C');
    //$pdf->Cell(0, 5, '', 0, 1);
    //$pdf->SetFont('TimesNRCyrMT', '', '12');
    //$x = $pdf->GetX();
    //$y = $pdf->GetY();
    //foreach ($c as $k => $v) {
    //    $x = $pdf->GetX();
    //    $pdf->MultiCell($w[$k], 5, $v, 1, 'C');
    //    $pdf->SetY($y);
    //    $pdf->SetX($x + $w[$k]);
    //}
    //$pdf->Cell(1, 10, '', 0, 1);
    foreach ($documents as $v) {
        $npp++;
        $f = true;
        ;
        foreach ($v as $line) {
            $xnpp = ($f) ? $npp : '';
            
	    $ccnt = (isset($cnt[$npp]))?$cnt[$npp]:'1';
            $xcnt = ($f) ? $ccnt : '';
            
            $f = false;
            $line = eval($line);
            if($line=='����� ��������') $xcnt=3;
            if($line=='������� �������') $xcnt=3;
            if($line=='������� � �����') $xcnt=2;
    //        $pdf->Cell($w[1], 6, $xnpp, 1, 0, 'C');
      //      $pdf->Cell($w[2], 6, $line, 1, 0, 'L');
        //    $pdf->Cell($w[3], 6, $xcnt, 1, 0, 'C');
          //  $pdf->Cell($w[4], 6, '', 1);
            //$pdf->Cell($w[5], 6, '', 1, 1);
       //     print "\"$xnpp\";\"$line\";\"$xcnt\";";
            $row_index++;
        }
    }

    for ($i = $row_index; $i < 35; $i++) {
        //$pdf->Cell($w[1], 6, '', 1, 0, 'C');
        //$pdf->Cell($w[2], 6, '', 1, 0, 'L');
        //$pdf->Cell($w[3], 6, '', 1);
        //$pdf->Cell($w[4], 6, '', 1);
        //$pdf->Cell($w[5], 6, '', 1, 1);
        print "\"\";\"\";\"\";";
    }

    //$pdf->SetFont('TimesNRCyrMT', '', '6');
    //$pdf->Cell(0, 3, "BSMU 2012 $p->id-{$p->faculty}-{$p->time_form_id}-{$p->edu_form}-{$p->target}-{$p->target_type}-{$p->delo_int}", 0, 1, 'R');
    print "\n";
}





function inventory_n($pdf, $p, $options, $documents = array(),$cnt=array()) {
    $title = "�����";
    $subtitle = "����������, ������� ���� � ������ ����";
    $unline = "(�������, ���, ��������)";

    $cert_flag=false;
    $certs = array();
    $certs[] = 'return \'����������� ��:\';';
    $cert_flag=($p->lct_id==2)?true:$cert_flag;
    $cert_flag=($p->cct_id==2)?true:$cert_flag;
    $cert_flag=($p->bct_id==2)?true:$cert_flag;
    
    if($p->lct_id==1)
    {
	$certs[] = "return '���� $p->lct_sn $p->lct_xn';";
    }
    if($p->bct_id==1)
    {
	$certs[] = "return '���. $p->bct_sn $p->bct_xn';";
    }
    if($p->cct_id==1)
    {
	$certs[] = "return '���. $p->cct_sn $p->cct_xn';";
    }
 /*   if($cert_flag)
    {
	$certs[] = 'return \'����� �������\';';
	$certs[] = 'return \'���������� ���������\';';
    }
*/    

    $edu_doc = ui_pdf_sap($options['certificate_id'],$p->certificate_id);
    if (empty($documents)) {
        $documents[] = array('return \'���������\';');
        $documents[] = array('return \''.$edu_doc.'\';');
/*        if(!empty($p->live_data)){
    	    $documents[] = array('return \'������� � �����\';','return \'����������\';');
        }
        if((($p->benefit_set & 2)==2) || (($p->benefit_set & 4)==4)){
    	    $documents[] = array('return \'�����\';','return \'������������� ����\';');    	    
        }
        if(($p->benefit_set & 128)==128){
    	    $documents[] = array('return \'�����\';','return \'������������� ���\';');    	    
        }
        if(($p->benefit_set & 8)==8){
    	    $documents[] = array('return \'������� ����\';');
    	    $documents[] = array('return \'�����\';','return \'������������� ��������\';');    	    
        }                                        */
        if($p->faculty==6 && $p->time_form_id==2)
        {
    	    $documents[] = array('return \'����� �������� ������\';');
        }
        if($p->out_target==1){
    	    $documents[] = array('return \'������� �������\';');
        }
        if($p->target==2){
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');
        }
        else{
        /*
        $documents[] = array('return \'����������� ��:\';',
            "return '���� $p->lct_sn $p->lct_xn';",
            "return '���. $p->bct_sn $p->bct_xn';",
            "return '���. $p->cct_sn $p->cct_xn';");
            */
            $documents[]=$certs;
        }
        if($cert_flag)
        {
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');
        }
        $documents[] = array('return \'�������� � �����������\';',
            'return \'�� � ������� �����\';'
        );
    /*    if((($p->benefit_set & 64)==64) || $cert_flag){
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');    	    
        }
        
       if(($p->benefit_set & 64)==64){
    	    $documents[] = array('return \'����� �������\';','return \'���������� ���������\';');    	    
        }*/
        if($p->edu_form==1){
        $documents[] = array('return \'������� � ����������\';',
            'return \'�� ���� �������\';'
        );
        }
        else
        {
        $documents[] = array('return \'������� �� ��������\';','return \'�� ������� ������\';' );
        }
        $documents[] = array('return \'������� �� �������\';');
        
        
        
    }
    


    $c = array();
    $c[1] = "�\n�/�";
    $c[2] = "�������� ���������\n ";
    $c[3] = "����������\n������";
    $c[4] = "��\n������";
    $c[5] = "��� ������ ��������\n� �� ����� �������";
    $w = array(1 => 13, 51, 31, 20, 54);

    $row_index = 0;

    $npp = 0;

    $pdf->AddPage();
    $pdf->SetFont('TimesNRCyrMT-Bold', '', '16');
    $pdf->SetLeftMargin(29);
    $pdf->SetTopMargin(21);

    $pdf->Cell(0, 10, $title, 0, 1, 'C');
    $pdf->SetFont('TimesNRCyrMT', '', '14');
    $pdf->Cell(0, 10, $subtitle, 0, 1, 'C');
    $pdf->Cell(0, 4, "$p->surname $p->name $p->midname", 0, 1, 'C');
//    print "\"$p->surname $p->name $p->midname\";";
    $pdf->Cell(0, 0.1, '', 1, 1, 'C', 1);
    $pdf->Cell(0, 10, $unline, 0, 1, 'C');
    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->SetFont('TimesNRCyrMT', '', '12');
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    foreach ($c as $k => $v) {
        $x = $pdf->GetX();
        $pdf->MultiCell($w[$k], 5, $v, 1, 'C');
        $pdf->SetY($y);
        $pdf->SetX($x + $w[$k]);
    }
    $pdf->Cell(1, 10, '', 0, 1);
    foreach ($documents as $v) {
        $npp++;
        $f = true;
        ;
        foreach ($v as $line) {
            $xnpp = ($f) ? $npp : '';
            
	    $ccnt = (isset($cnt[$npp]))?$cnt[$npp]:'1';
            $xcnt = ($f) ? $ccnt : '';
            
            $f = false;
            $line = eval($line);
            if($line=='����� ��������') $xcnt=3;
            if($line=='������� �������') $xcnt=3;
            if($line=='������� � �����') $xcnt=2;
            if($line=='������� �������') $xcnt=1;
            $pdf->Cell($w[1], 6, $xnpp, 1, 0, 'C');
            $pdf->Cell($w[2], 6, $line, 1, 0, 'L');
            $pdf->Cell($w[3], 6, $xcnt, 1, 0, 'C');
            $pdf->Cell($w[4], 6, '', 1);
            $pdf->Cell($w[5], 6, '', 1, 1);
       //     print "\"$xnpp\";\"$line\";\"$xcnt\";";
            $row_index++;
        }
    }

    for ($i = $row_index; $i < 35; $i++) {
        $pdf->Cell($w[1], 6, '', 1, 0, 'C');
        $pdf->Cell($w[2], 6, '', 1, 0, 'L');
        $pdf->Cell($w[3], 6, '', 1);
        $pdf->Cell($w[4], 6, '', 1);
        $pdf->Cell($w[5], 6, '', 1, 1);
        //print "\"\";\"\";\"\";";
    }

    $pdf->SetFont('TimesNRCyrMT', '', '6');
    $pdf->Cell(0, 3, "BSMU 2012 $p->id-{$p->faculty}-{$p->time_form_id}-{$p->edu_form}-{$p->target}-{$p->target_type}-{$p->delo_int}", 0, 1, 'R');
    //print "\n";
}