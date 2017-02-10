<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC','person.precreate');
cr_logic();

if(!empty($_GET))
{
    ui_sp("Поиск имеющейся информации об абитуриенте");
    $reg=$_GET['reg'];
    $a=array();
    $a['serial']=$reg['ST'];
    $a['number']=$reg['SN'];
    $w=db_where_values($a);
    $sql="SELECT * FROM `db_ct_info` WHERE (1  $w)";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    
    if(mysql_num_rows($r)==1)
    {
        $l=  mysql_fetch_object($r);
        
            ui_stfs();
            ui_sfs('ФИО');
            
            ui_text_view('', '','Фамилия',$l->surname);
            ui_text_view('', '','Имя',$l->name);
            ui_text_view('', '','Отчество',$l->midname);
            
            ui_efs();
            ui_sptfs4();
            ui_sfs('Язык');
            
            ui_text_view('', '','Балл',$l->lct_sum);
            ui_text_view('', '','Серия',$l->lct_sn);
            ui_text_view('', '','Номер',$l->lct_xn);
            
            ui_efs();
            
            ui_sptfs4();
            ui_sfs('Химия');
            
            ui_text_view('', '','Балл',$l->cct_sum);
            ui_text_view('', '','Серия',$l->cct_sn);
            ui_text_view('', '','Номер',$l->cct_xn);
            
            ui_efs();
            
            ui_sptfs4();
            ui_sfs('Биология');
            
            ui_text_view('', '','Балл',$l->bct_sum);
            ui_text_view('', '','Серия',$l->bct_sn);
            ui_text_view('', '','Номер',$l->bct_xn);
            
            ui_efs();
            
            ui_etfs();
        
        ui_script_start();
print<<<EOF

function usevalues()
{
    if(typeof(localStorage) == 'undefined' ) {
        alert('Ваш браузер не поддерживает localStorage()');
        return;
    }
    localStorage.clear();
    localStorage.setItem('surname','$l->surname');
    localStorage.setItem('name','$l->name');
    localStorage.setItem('midname','$l->midname');
    localStorage.setItem('serial','$l->serial$l->number');
    localStorage.setItem('lct_sum','$l->lct_sum');
    localStorage.setItem('lct_sn','$l->lct_sn');
    localStorage.setItem('lct_xn','$l->lct_xn');
    localStorage.setItem('cct_sum','$l->cct_sum');
    localStorage.setItem('cct_sn','$l->cct_sn');
    localStorage.setItem('cct_xn','$l->cct_xn');
    localStorage.setItem('bct_sum','$l->bct_sum');
    localStorage.setItem('bct_sn','$l->bct_sn');
    localStorage.setItem('bct_xn','$l->bct_xn');
    window.location="create.php";
}
EOF;
        ui_script_end();
        ui_blink('Использовать', 'javascript:usevalues()');
    }
    else
    {
        ui_par('Ничего не найдено.');
    }
    ui_ep();
}
else {
    


ui_sp("Поиск имеющейся информации об абитуриенте");
ui_gf();
ui_stfs();
ui_sfs();
ui_efs();
ui_sptfs3();
ui_sfs();
ui_text('reg', 'ST', 'Серия', '',4);
ui_text('reg', 'SN', 'Номер','',10);
//ui_text('reg', 'WR', 'Web-регистрация', '', 10);
ui_efs();
ui_sptfs3();
ui_sfs();
ui_efs();
ui_etfs();
ui_ef();
ui_script('js/precreate.js');
ui_ep();
}
