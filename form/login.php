<?php

function form_draw()
{

	ui_stfs();// ������� �������������� ����� ��������������
        ui_sfs('','vsplitter3_none');
        ui_efs();
	ui_sptfs3('vsplitter3_none');

		ui_sf();//�������� ������ ������� post
		ui_sfs();
		ui_text('reg','username','������������','',50);
		ui_pass('reg','password','������','',50);
                ui_hidden('reg', 'domain', 2);//'�����', array(1=>'���������','bsmu.by'), 2);
		ui_submit('btn','auth','�����������','�����������',50);
		ui_efs();
		ui_ef0();
	ui_sptfs3('vsplitter3_none');
	ui_etfs();

}
