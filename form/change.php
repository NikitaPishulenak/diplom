<?php



function form_draw($p,$t)
{
        include 'form/options.php';
        ui_sf();
        ui_stfs();
            ui_sfs();
                        ui_select_view('���������',$options['faculty'],$p['faculty']);
                        ui_select_view('����� ��������',$options['time_form'],$p['time_form_id']);
                        ui_text_view('reg','surname','�������',$p['surname'],50);
			ui_text_view('reg','name','���',$p['name'],50);
			ui_text_view('reg','midname','��������',$p['midname'],50);
                        ui_text_view('reg', 'total','�����', $p['total']);
            ui_efs();
            ui_sptfs3();
            ui_sfs('�������');
                        ui_select_view('����� ��������',$options['ef'],$p['edu_form']);
			ui_select_view('�������',$options['target'],$p['target']);
			ui_select_view('��� ��������',$options['target_type'],$p['target_type']);
                        ui_select_view('��� ��������',$options['target_cell'],$p['target_cell']);
                        ui_select_view('������� �������',$options['region_by'],$p['region_cell']);
            ui_efs();
            ui_sptfs3();
            ui_sfs('�����');
                        
			
                        if($p['state_id']=='1')
                        {
			ui_select('reg','edu_form','����� ��������',$options['ef'],$p['edu_form']);
			ui_select('reg','target','�������',$options['target'],$p['target']);
			ui_select('reg','target_type','��� ��������',$options['target_type'],$p['target_type']);
                        ui_select('reg','target_cell','��� ��������',$options['target_cell'],$p['target_cell']);
                        ui_select('reg','region_cell','������� �������',$options['region_by'],$p['region_cell']);
                        }
                        
		ui_efs();
	ui_etfs();
        ui_sfs();
        $ctime=date_parse($p['ctime']);
        
        if($p['state_id']=='1')
        {

//          	    if(cr_check('*'))
//          	    {
            		ui_submit('', '', '�������', '�������', '');
//          	    }
            	
	}
	else
	{
	    print "������ ������� ������� ��������� ����.";
	}
                            

        ui_efs();
        ui_ef0();
}