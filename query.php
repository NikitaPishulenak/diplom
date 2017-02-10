<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';



define('PAGE_SEC','person.query');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0) ui_redirect ('noaccess.php');

if(!empty($_POST))
{
    if($id)
    {
        
    }
    else 
    {
        $reg=$_POST['reg'];
        $res=db_field_values($reg);
        $u=cr_userid();
        $a=db_esc(cr_sql());
        $sql="INSERT INTO `db_query` (${res[0]},`query`,`owner_id`) VALUES (${res[1]},'$a','$u' )";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        $lid=mysql_insert_id();
        ui_redirect("query.php?id=$lid");
    }
}


$u=cr_userid();

if($id)
{
    
    $sql="SELECT * FROM `db_query` WHERE `owner_id`='$u' AND `id_query`='$id' LIMIT 1";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $l=mysql_fetch_object($r);
    ui_sp('Запрос: '.$l->name);
    ui_stfs();
        ui_chain_links();
    ui_etfs();
    /*
    $l->query=str_replace('*', ' delo_name,total,surname,name,midname ', $l->query);
    $sql="$l->query";
    //print $sql;
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_sfs('','w100');
    ui_rep_row();
    ui_rep_th('#');
    include 'form/person.column.php';
    while($l=  mysql_fetch_field($r))
    {
        
        ui_rep_th($pcolumns[$l->name]);
    }
    ui_end_row();
    $i=0;
    while($l=  mysql_fetch_assoc($r))
    {
        ui_rep_row();
      //  print_r($l);
      ui_rep_th($i++);
        array_map('ui_rep_td_l', $l);
        ui_end_row();
    }
    ui_efs();
    */
    cr_tempclear();
    $sql="$l->query";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_ssfs();
        ui_sfs('','w100');
        $i=0;
        $e_temp=(cr_check('person.edit'))?'edit.php':'';
        $c_temp=(cr_check('person.close'))?'close.php':'';
        $tf_ak=db_kv('db_time_form', 'id_time_form', 'abbr');
        $ef_ak=db_kv('db_ef','id_ef','abbr');
        $t__ak=db_kv('db_target','id_target','abbr');
        $tt_ak=db_kv('db_targettype','id_targettype','abbr');
        $rc_ak=db_kv('db_region','id_region','abbr');
        $colors=db_kv('db_state','id_state','color');
        $bf_set = db_bits2arr('db_benefit', 'id_benefit', 'abbr');
        ui_rep_row();
        ui_rep_th('#');
        ui_rep_th('Дело');
        ui_rep_th('Балл');
        ui_rep_th('Абитуриент');
        ui_rep_th('Льготы');
        ui_rep_th('ФП');
        ui_rep_th('ФО');
        ui_rep_th('К');
        ui_rep_th('ТК');
        ui_end_row();
	while($l=mysql_fetch_object($r))
	{   
            
            $color=(isset($colors[$l->state_id]))?$colors[$l->state_id]:'#FF0000';
            $rowclass="style=\"background-color:$color\"";
            $ch=ui_chain_check('reg',$l->id,'',1);
            $tf=ui_sap($tf_ak,$l->time_form_id);
            $ef=ui_sap($ef_ak,$l->edu_form);
            $t_=ui_sap($t__ak,$l->target);
            $tt=ui_sap($tt_ak,$l->target_type);
            $t_=($l->target==1)?$t_.'('.ui_sap($rc_ak,$l->region_cell).')':$t_;
            $e_link=(!empty($e_temp))?"<a href=\"$e_temp?id=$l->id\">e</a>":'';
            $c_link=(!empty($c_temp))?"<a href=\"$c_temp?id=$l->id\">c</a>":'';
            $bf = ui_sap($bf_set,$l->benefit_set,'');
            ui_rowlink(++$i, "$l->surname $l->name $l->midname", "view.php",array("id=$l->id"),array($bf,$tf,$ef,$t_,$tt,$e_link,$c_link),array($l->delo_name,$l->total),$rowclass );
            /*ui_rep_row('lh24',$rowcolor);
                ui_rep_td_l(++$i, 'elemkv');
                ui_rep_td_l($l->delo_name);
                ui_rep_td_l($l->total);
                ui_rep_td_l("$l->surname $l->name $l->midname",'elemsv');
                ui_rep_td_l($tf);
                ui_rep_td_l($ef);
                ui_rep_td_l($t_);
                ui_rep_td_l($tt);
                
                
            ui_end_row();
             * *
             */
            
            cr_temppush($l->id,$l->delo_name);
            
	}
        ui_efs();
        ui_esfs();
}
else
{
    ui_sp('Запросы');
    if(isset($_GET['new']))
    {
    ui_sf();
    ui_stfs();
    ui_sfs();
    ui_text('reg', 'name', 'Имя Запроса', cr_rqt(), 50);
    ui_submit('', '', '', 'Сохранить', 50);
    ui_efs();
    ui_etfs();
    ui_ef0();
    
    }
    else
    {
    $sql="SELECT * FROM `db_query` WHERE `owner_id`='$u'";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    ui_sf('qop.php');
    ui_sfs('','w100');
    ui_rep_row();
        ui_rep_th('#');
        ui_rep_th('^');
        
        ui_rep_th('Название');
        ui_rep_th('Дата');
        
        ui_end_row();
    $i=1;
    while($l=  mysql_fetch_object($r))
    {
        $el="<a href=\"query.php?id=$l->id_query\">$l->name</a>";
        ui_rep_row();
        ui_rep_th($i++);
        ui_rep_th('<input type="checkbox" name="reg['.$l->id_query.']"/>');
        //ui_rep_td_l($el);
        
        ui_rep_td_l($el, 'w100');
        ui_rep_td_l($l->save_date,'nw');
        ui_end_row();
        
    }
    ui_efs();
    //print ("&#8746; 	&#8745; &#8710; 	 	");
    $qop_values=array('1'=>'Удалить','2'=>'Объединение');
    ui_stfs();
    ui_sfs();
    ui_select('qop','qop','Операция',$qop_values,0);
    ui_efs();
    ui_etfs();
    ui_sc('Получить');
    ui_ef0();
    }
}
ui_ep();