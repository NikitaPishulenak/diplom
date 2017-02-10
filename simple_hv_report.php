<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();


function local_uniq_days($field)
{
    $result=array();
    $sql="SELECT DISTINCT DAY(`$field`) d FROM `db_person` ORDER BY d";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=mysql_fetch_object($r))
    {
        $result[$l->d]=$l->d;
    }
    if(isset($result[0])) {
        unset($result[0]);
        }
   return $result;
}

function local_uniq_flags($field)
{
    $result=array();
    $sql="SELECT DISTINCT `$field` d FROM `db_person` ORDER by d ";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=mysql_fetch_object($r))
    {
        $result[$l->d]=$l->d;
    }
    if(isset($result[0])) {
        unset($result[0]);
        }
    return $result;
}





$options=array();
$options['faculty']=db_kv('db_faculty','id','name');
$options['state_id']=db_kv('db_state','id_state','name');
$options['time_form_id']=db_kv('db_time_form','id_time_form','name');
$options['edu_form']=db_kv('db_ef','id_ef','name');
$options['target']=db_kv('db_target','id_target','name');
$options['target_type']=db_kv('db_targettype','id_targettype','name');
$options['sex']=db_kv('db_sex','id_sex','name');
$options['city_name']=local_uniq_flags('city_name');
$options['surname']=local_uniq_flags('surname');
$options['name']=local_uniq_flags('name');
$options['midname']=local_uniq_flags('midname');
$options['institution_name']=local_uniq_flags('institution_name');
$options['experience_id']=db_kv('db_experience','id_experience','name');

//Дни создания
$options['ctime']=  local_uniq_days('ctime');
$options['atime']=  local_uniq_days('atime');
$options['xtime']=  local_uniq_days('xtime');

//ЛЬготы
//Перебор
$options['benefit_set']=db_bits2arr('db_benefit', 'id_benefit', 'abbr');
$temp=local_uniq_flags('benefit_set');
foreach($options['benefit_set'] as $k=>$v)
{
    if(!isset($temp[$k]))
        unset($options['benefit_set'][$k]);
}
//Вхождение
$options['benefit_id']=db_kv('db_benefit','id_benefit','name');


$titles=array();
$titles['faculty']='Факультеты';
$titles['state_id']='Состояние';
$titles['time_form_id']='Отделение';
$titles['edu_form']='Форма обучения';
$titles['target']='Конкурс';
$titles['target_type']='Тип конкурса';
$titles['sex']='Пол';
$titles['ctime']='Создано(дни)';
$titles['atime']='Правлено(дни)';
$titles['xtime']='Закрыто(дни)';
$titles['benefit_set']='Льготы - перебор';
$titles['benefit_id']='Льготы - Наличие';
$titles['surname']='Фамилия (уник)';
$titles['name']='Имена (уник)';
$titles['midname']='Отчества (уник)';
$titles['city_name']='Название НП (уник)';
$titles['institution_name']='Название УО';
$titles['experience_id']='Стаж';



$funcs=array();
$funcs['ctime']='DAY';
$funcs['atime']='DAY';
$funcs['xtime']='DAY';

$flags['benefit_id']='benefit_set';

$rows=array();
$cols=array();

$v=0;
$h=0;
$d=0;

if(!empty($_POST))
{
    $reg=(isset($_POST['reg']))?$_POST['reg']:array('v'=>0,'h'=>0);
    $v=$reg['v'];
    $h=$reg['h'];
    $where=(isset($_POST['reg']['temp']))?cr_tempwhere('id'):'1';
    $d=(isset($reg['d']))?1:0;
    if(isset($titles[$v]) && isset($titles[$h]))
    {
        $rows[0][0]="#";
        $rows[0]=$rows[0]+$options[$h];
        $sqln=array();
        foreach($options[$v] as $k=>$w)
        {
            $xv=(isset($funcs[$v]))?$funcs[$v]."(`$v`)":"`$v`";
            $xk=(isset($flags[$v]))?pow(2,$k-1):$k;
            $xv=(isset($flags[$v]))?"(`$flags[$v]` & $xk)":$xv;
            
            foreach($options[$h] as $kk=>$vv)
            {
                $xh=(isset($funcs[$h]))?$funcs[$h]."(`$h`)":"`$h`";
                $xkk=(isset($flags[$h]))?pow(2,$kk-1):$kk;
                $xh=(isset($flags[$h]))?"(`$flags[$h]` & $xkk)":$xh;;
            if(!$d)    $sqln[]="COUNT(IF($xv='$xk' AND $xh='$xkk',`id`,null)) as `r${k}c${kk}`";
            if($d)     $sqln[]="group_concat(IF($xv='$xk' AND $xh='$xkk',`delo_name`,null) SEPARATOR '<br />') as `r${k}c${kk}`";
            }
        }
        $sql="SELECT ". implode(',',$sqln)." FROM `db_person` WHERE $where";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
        while($l=mysql_fetch_object($r))
        {
            foreach($options[$v] as $k=>$w)
            {
                $rows[$k][0]=$w;
                 foreach($options[$h] as $kk=>$vv)
                 {
                     $fn="r${k}c${kk}";
                     $rows[$k][$kk]=$l->$fn;
                 }
            }
        }
        
    }
}

ui_sp();
ui_sf();
ui_stfs();
ui_sfs('Вертикаль');
ui_select('reg','v','v',$titles,$v);
ui_efs();
ui_sptfs4();
ui_sfs('Горизонатль');
ui_select('reg','h','h',$titles,$h);
ui_efs();
ui_sptfs4();
ui_sfs('Опции');
ui_check('reg','d','Номера дел',$d);
ui_efs();
ui_sptfs4();
ui_sfs('Брать из');
ui_check('reg','temp','Из временной',$d);
ui_efs();
ui_etfs();
ui_ef();

ui_hr();


//echo $sql;

ui_sfs('Результат','w100');
$r=0;
$c=0;
foreach($rows as $k=>$v)
{
    $c=0;
    ui_rep_row();
    foreach($v as $kk=>$vv)
    {
        //if(!$d) ui_rep_td($vv);
        //if( $d) ui_rep_td("<a href=\"qs.php?q=$vv\">$vv</a>");
        
        if($r && $c && $d)
        {
    	    $a=explode('<br />',$vv);
    	    $xxx='';
    	    foreach($a as $vvv)
    	    {
    		$xxx.="<a href=\"qs.php?q=$vvv\">$vvv</a><br />";
    	    }
    	    ui_rep_td($xxx);
        }
        else
        {
    	    ui_rep_td($vv);
        }
        $c++;
    }
    ui_end_row();
    $r++;
}

ui_efs();
ui_ep();