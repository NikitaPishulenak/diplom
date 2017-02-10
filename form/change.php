<?php



function form_draw($p,$t)
{
        include 'form/options.php';
        ui_sf();
        ui_stfs();
            ui_sfs();
                        ui_select_view('Факультет',$options['faculty'],$p['faculty']);
                        ui_select_view('Форма обучения',$options['time_form'],$p['time_form_id']);
                        ui_text_view('reg','surname','Фамилия',$p['surname'],50);
			ui_text_view('reg','name','Имя',$p['name'],50);
			ui_text_view('reg','midname','Отчество',$p['midname'],50);
                        ui_text_view('reg', 'total','Всего', $p['total']);
            ui_efs();
            ui_sptfs3();
            ui_sfs('Текущая');
                        ui_select_view('Форма обучения',$options['ef'],$p['edu_form']);
			ui_select_view('Конкурс',$options['target'],$p['target']);
			ui_select_view('Тип Конкурса',$options['target_type'],$p['target_type']);
                        ui_select_view('Тип Целевого',$options['target_cell'],$p['target_cell']);
                        ui_select_view('Целевая область',$options['region_by'],$p['region_cell']);
            ui_efs();
            ui_sptfs3();
            ui_sfs('Смена');
                        
			
                        if($p['state_id']=='1')
                        {
			ui_select('reg','edu_form','Форма обучения',$options['ef'],$p['edu_form']);
			ui_select('reg','target','Конкурс',$options['target'],$p['target']);
			ui_select('reg','target_type','Тип Конкурса',$options['target_type'],$p['target_type']);
                        ui_select('reg','target_cell','Тип Целевого',$options['target_cell'],$p['target_cell']);
                        ui_select('reg','region_cell','Целевая область',$options['region_by'],$p['region_cell']);
                        }
                        
		ui_efs();
	ui_etfs();
        ui_sfs();
        $ctime=date_parse($p['ctime']);
        
        if($p['state_id']=='1')
        {

//          	    if(cr_check('*'))
//          	    {
            		ui_submit('', '', 'Сменить', 'Сменить', '');
//          	    }
            	
	}
	else
	{
	    print "Нельзя сменить конкурс закрытому делу.";
	}
                            

        ui_efs();
        ui_ef0();
}