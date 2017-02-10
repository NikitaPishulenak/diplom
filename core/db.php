<?php
function db_cv($from,$value,$where)
{
    $sql="SELECT COUNT(`$value`) as vx FROM `$from` WHERE $where ";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $l= mysql_fetch_row($r);
    return $l[0];
    
}
function db_gv($from,$value,$where)
{
    $sql="SELECT `$value` as vx FROM `$from` WHERE $where ";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    $l= mysql_fetch_row($r);
    return $l[0];
    
}
function db_bit_where($tag,$name)
{
        $afx=(isset($_POST[$tag]))?$_POST[$tag]:array();
        $afxisset=0;
        $afxnoset=0;
        foreach($afx as $k=>$v)
        {
            if(!$v)                continue;;
            if($v==2) $afxnoset+=pow(2,$k-1);
            if($v==1) $afxisset+=pow(2,$k-1);
        }
        $afxw1=($afxisset)?"AND ((`$name` & $afxisset)=$afxisset)":'';
        $afxw2=($afxnoset)?"AND ((`$name` & $afxnoset)=0)":'';
        return " $afxw1 $afxw2 ";
}
function db_date_where($name)
{
        $afx_date=$_POST['date'][$name];
        $afx_date_d=isset($afx_date['d'])?(int)$afx_date['d']:0;
        $afx_date_m=isset($afx_date['m'])?(int)$afx_date['m']:0;
        $afx_date_y=isset($afx_date['y'])?(int)$afx_date['y']:0;
        $afx_date_dw=($afx_date_d)?" AND (DAY(`$name`)='$afx_date_d') ":'';
        $afx_date_mw=($afx_date_m)?" AND (MONTH(`$name`)='$afx_date_m') ":'';
        $afx_date_yw=($afx_date_y)?" AND (YEAR(`$name`)='$afx_date_y') ":'';
        return " $afx_date_dw  $afx_date_mw $afx_date_yw ";
}

function db_date_where_f($name)
{
        $afx_date=$_POST['date'][$name];
        $afx_date_d=isset($afx_date['d'])?(int)$afx_date['d']:0;
        $afx_date_m=isset($afx_date['m'])?(int)$afx_date['m']:0;
        $afx_date_y=isset($afx_date['y'])?(int)$afx_date['y']:0;
        //$afx_date_dw=($afx_date_d)?" AND (DAY(`$name`)='$afx_date_d') ":'';
        //$afx_date_mw=($afx_date_m)?" AND (MONTH(`$name`)='$afx_date_m') ":'';
        //$afx_date_yw=($afx_date_y)?" AND (YEAR(`$name`)='$afx_date_y') ":'';
        return ($afx_date_d && $afx_date_m && $afx_date_y)?" AND `$name`=DATE('$afx_date_y-$afx_date_m-$afx_date_d') ":'';
}

function db_th_unset($a=array())
{
    
    if(isset($a['faculty'])) unset($a['faculty']);
    if(isset($a['time_form_id'])) unset($a['time_form_id']);
    if(isset($a['edu_form'])) unset($a['edu_form']);
    if(isset($a['target'])) unset($a['target']);
    if(isset($a['target_type'])) unset($a['target_type']);
    if(isset($a['target_cell'])) unset($a['target_cell']);
    return $a;
}
function db_th_util($a=array())
{
    $b=array();
    if(isset($a['faculty'])) $b['th`.`faculty']=$a['faculty'];
    if(isset($a['time_form_id'])) $b['th`.`time_form_id']=$a['time_form_id'];
    if(isset($a['edu_form'])) $b['th`.`edu_form']=$a['edu_form'];
    if(isset($a['target'])) $b['th`.`target']=$a['target'];
    if(isset($a['target_type'])) $b['th`.`target_type']=$a['target_type'];
    if(isset($a['target_cell'])) $b['th`.`target_cell']=$a['target_cell'];
    return $b;
}
function db_bits2arr($table,$id,$field)
{
    $a=array();
    $b=array();
    $c=0;
    $sql="SELECT `$id`,`$field` FROM `$table`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=  mysql_fetch_object($r))
    {
        $i=$l->$id-1;
        
        $j=pow(2,$i);
        $x=pow(2,$l->$id);
        $a[$i]=$l->$field;
        $c++;
        $b[$j]=$a[$i];
        
        for($k=$j+1;$k<$x;$k++)
        {
            $b[$k]='';
            foreach ($a as $kk=>$vv)
            {
                $t=(int)pow(2,$kk);
                if(($k & $t) == $t)
                {
                    
                    $b[$k].=' '.$vv;
                }
            }
        }
    }
    
    
    return $b;
}
function db_dt2arr($v)
{
    $a=array();
    $b=array();
    $dx=array();
    $dx=explode(' ', $v);
    $a=explode('-', $dx[0]);
    $b=  explode(':', $dx[1]);
    $res=array();
    $res['d']=(int)$a[2];
    $res['m']=(int)$a[1];
    $res['y']=(int)$a[0];
    $res['h']=(int)$b[0];
    $res['i']=(int)$b[1];
    $res['s']=(int)$b[2];
    return $res;
}
function db_d2arr($v)
{
    $a=array();
    $a=  explode('-', $v);
    $res=array();
    $res['d']=(int)$a[2];
    $res['m']=(int)$a[1];
    $res['y']=(int)$a[0];
    
    return $res;
}

function db_d2strarr($v)
{
    $a=array();
    $a=  explode('-', $v);
    $res=array();
    $res['d']=$a[2];
    $res['m']=$a[1];
    $res['y']=$a[0];
    
    return $res;
}

function db_mkdate($v)
{
    $v['y']=str_pad($v['y'],4,'0', STR_PAD_LEFT);
    $v['m']=str_pad($v['m'],2,'0', STR_PAD_LEFT);
    $v['d']=str_pad($v['d'],2,'0', STR_PAD_LEFT);
    return "$v[y]-$v[m]-$v[d]";
}
function db_bit_array($a)
{
    $v=0;
    for( $i=0;$i<32;$i++)
    {
        
        if(isset($a[$i+1]))
        {
            $x=1<<$i;
            $v+=$x;
        }
    }
    return $v;
}
function db_empty_record($table)
{
	$a=array();
	$sql="DESCRIBE `$table`;";
	$r=mysql_query($sql) or debug($sql,mysql_error());
	while($l=mysql_fetch_object($r))
	{
		$a[$l->Field]='';
	}
	return $a;
}

function db_default_record($table)
{
	$a=array();
	$sql="DESCRIBE `$table`;";
	$r=mysql_query($sql) or debug($sql,mysql_error());
	while($l=mysql_fetch_object($r))
	{
		$a[$l->Field]=$l->Default;
	}
	return $a;
}

function db_single_record($table,$index,$value)
{
	$a=array();
	$sql="SELECT * FROM `$table` WHERE `$index`='$value' LIMIT 1";
	$r=mysql_query($sql) or debug($sql,mysql_error());

	return mysql_fetch_assoc($r) ;
}

function db_single_record_a($table,$a=array())
{
    	
        
            $w=db_where_values($a);
        
	$sql="SELECT * FROM `$table` WHERE (1 $w) LIMIT 1";
	$r=mysql_query($sql) or debug($sql,mysql_error());

	return mysql_fetch_assoc($r) ;
}

function db_kv($table,$index,$column)
{
	$a=array();
	$sql="SELECT `$index`,`$column` FROM `$table`";
	$r=mysql_query($sql) or debug($sql,mysql_error());
	while($l=mysql_fetch_object($r))
	{
		$a[$l->$index]=$l->$column;
	}
	return $a;
}

function db_field_values($a)
{
	foreach($a as $k=>$v)
	{
		$fields[]='`'.mysql_real_escape_string(trim($k)).'`';
		$values[]="'".mysql_real_escape_string(trim($v))."'";
	}
	$f=implode(',',$fields);
	$v=implode(',',$values);
	return array($f,$v);
}

function db_update_values($a)
{
	$r=array();
	foreach($a as $k=>$v)
	{
		$f='`'.mysql_real_escape_string(trim($k)).'`';
		$v="'".mysql_real_escape_string(trim($v))."'";
		$r[]="$f=$v";
	}


	return implode(',',$r);

}
function db_where_values($a)
{
	$r='';
	foreach($a as $k=>$v)
	{
		$f='`'.mysql_real_escape_string(trim($k)).'`';
		
                if(strpos($v, '*')!==false)
                {
                    
                    $v="'".mysql_real_escape_string(trim(str_replace('*', '%', $v)))."'";
                    $r.="AND $f LIKE $v ";
                }
                else
                {
                    $v="'".mysql_real_escape_string(trim($v))."'";
                    $r.="AND $f=$v ";
                }
	}


	return $r;

}

function db_unset_empty($a)
{
	$t=array();
	foreach($a as $k=>$v)
	{
		$z=trim($v);
		if(empty($z)) continue;
		$t[$k]=$v;
	}
	return $t;
}
function db_replace_nill($a,$w)
{
        $t=array();
	foreach($a as $k=>$v)
	{
		if($v==$w)
                    $a[$k]='';
	}
	return $a;
}
function db_esc($v)
{
	return mysql_real_escape_string(trim($v));
}



function db_debug($e,$t)
{
	die($e.$t);
}

class db_conn
{
	private $db;

	public function __construct()
	{

		$this->db=mysql_pconnect(DB_HOST,DB_USER,DB_PASS) or db_debug('connect:',mysql_error());
		$r=mysql_select_db(DB_NAME) or db_debug('select_db:',mysql_error());
		$r=mysql_query('SET NAMES '.DB_PAGE) or db_debug('codepage:',mysql_error());

	}
	public function __destruct()
	{

		mysql_close($this->db);
	}

}

$db_afx=new db_conn();
