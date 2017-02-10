<?php

function form_draw()
{

	ui_stfs();// создает форматирование формы аутинтификации
        ui_sfs('','vsplitter3_none');
        ui_efs();
	ui_sptfs3('vsplitter3_none');

		ui_sf();//посылает запрос серверу post
		ui_sfs();
		ui_text('reg','username','Пользователь','',50);
		ui_pass('reg','password','Пароль','',50);
                ui_hidden('reg', 'domain', 2);//'Домен', array(1=>'Локальный','bsmu.by'), 2);
		ui_submit('btn','auth','Авторизация','Авторизация',50);
		ui_efs();
		ui_ef0();
	ui_sptfs3('vsplitter3_none');
	ui_etfs();

}
