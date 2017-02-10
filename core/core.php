<?php
function debug($e,$t)
{
	// if(defined(UI_SP)) ...
    print<<<EOF
    <pre>
$e
$t
    </pre>
EOF;
    if(defined('UI_PAGE')) ui_ep();
        
    
    die();
    
}

function cr_create($id)
{

	$_SESSION['id'] = $id;

	cr_update();

}

function cr_anon()
{
	$_SESSION['id'] = 0;
	$_SESSION['username'] = 'anonymous';
	$_SESSION['realname'] = 'unknown';
	$_SESSION['acl']['login']='Авторизация';
        $_SESSION['acl']['report.discrete']='Дискрет';
        $_SESSION['chain'] = array();
        $_SESSION['temp_chain']=array();

}

function cr_update()
{
        $k = db_kv('db_klik','id_klik','sname');
	$id=$_SESSION['id'];
	$sql="SELECT * FROM `db_users` Where (`id`='$id') LIMIT 1";
	$r=mysql_query($sql) or debug($sql, mysql_error());
	$l=mysql_fetch_assoc($r);
	unset($_SESSION['acl']['report.discrete']);
	$_SESSION['username'] = $l['username'];
	$_SESSION['realname'] = $l['realname'];
	$_SESSION['group_id'] = $l['group_id'];
        $_SESSION['ukey']['tabs'] = $l['use_tabs'];
        $_SESSION['ukey']['faculty'] = $l['def_faculty'];
        $_SESSION['ukey']['queue_id'] = $l['queue_id'];
        $_SESSION['ukey']['time_form'] = $l['def_time_form'];
        $_SESSION['ukey']['action'] = $l['def_action'];
        $_SESSION['ukey']['klik'] = ui_sap($k,$l['def_action'],'view.php');
        $_SESSION['ukey']['use_last']=$l['use_last'];
        $_SESSION['ukey']['def_state_id']=$l['def_state_id'];
	$gi = $l['group_id'];
	//groups
	$sql="SELECT (select keystring from db_keys where id_keys=key_id) as p FROM `db_acl` WHERE ( `group_id` = '$gi' and value=1)";
	$r=mysql_query($sql) or debug($sql,mysql_error());
	while($l=mysql_fetch_object($r))
	{
		$_SESSION['acl'][$l->p]=$l->p;
	}
	$_SESSION['acl']['logout']='Выход';
	$_SESSION['acl']['index']='Главная';
        
        unset($_SESSION['cc']);
	//var_dump($_SESSION);
	//die();
	//permissions
}

function cr_logged()
{
	$r= (isset($_SESSION['id']) && $_SESSION['id']>0)?true:false;
	//var_dump($r);
	//var_dump($_SESSION);
	return $r;
}

function cr_logic()
{
        /** ++ DOUBLE POST HIGHJACK ++ **/
        /*if(!empty($_POST))
        {
                $pfx=isset($_POST['highjack'])?$_POST['highjack']:'';
                $afx=(isset($_SESSION['highjack']))?$_SESSION['highjack']:'';
                if($afx==$pfx)
                {
                    die('DOUBLE POST HIGHJACK');
                }
                $_SESSION['highjack']=$pfx;
        }*/   
        /** -- DOUBLE POST HIGHJACK -- **/
        $what=(defined('PAGE_SEC'))?PAGE_SEC:'-';
        cr_log($what);
	if(!cr_logged())
	{
		cr_anon();
		//var_dump($_SESSION);
		if(defined('PAGE_SEC') and !cr_check(PAGE_SEC)) ui_redirect('login.php');
	}
	else
	{
		cr_update();
                
                
		if(defined('PAGE_SEC') and !cr_check(PAGE_SEC)) ui_redirect('noaccess.php');
	}
}

function cr_username()
{
	return (isset($_SESSION['username']))?$_SESSION['username']:'!notset';
}
function cr_realname()
{
	return (isset($_SESSION['realname']))?$_SESSION['realname']:'!notset';
}


function cr_check($index)
{
        /** @todo sql and file log */
	//var_dump($index);
    
        $ret=false;
	if(isset($_SESSION['acl']['*'])) $ret= true;
	if(isset($_SESSION['acl'][$index])) $ret = true;
        
//print_r($_SESSION);
//        die();
	return $ret;
}
function cr_userid()
{
    return (isset($_SESSION['id']))?$_SESSION['id']:0;
}

function cr_popchain()
{
   
    $_SESSION['chain']=$_SESSION['temp_chain'];
    $_SESSION['temp_chain']=array();
 
}
function cr_addchain()
{
   $_SESSION['chain']= array_merge($_SESSION['chain'],$_SESSION['temp_chain']);
   $_SESSION['chain']=array_unique($_SESSION['chain']);
   $_SESSION['temp_chain']=array();
}
function cr_chaincount()
{
    return count($_SESSION['chain']);
}
function cr_tempcount()
{
    return count($_SESSION['temp_chain']);
}
function cr_tempclear()
{
    $_SESSION['temp_chain']=array();;
}

function cr_chainclear()
{
    $_SESSION['chain']=array();
}
function cr_temppush($a,$v='')
{
    if(empty($v))
        $_SESSION['temp_chain'][$a]=$a;
    else
        $_SESSION['temp_chain'][$a]=$v;
}

function cr_chainwhere($index)
{
    $t=array();
    foreach($_SESSION['chain'] as $k=>$v)
    {
        $t[]=" `$index`='$k' ";
    }
    return implode(' or ', $t);
}

function cr_tempwhere($index)
{
    $t=array();
    foreach($_SESSION['temp_chain'] as $k=>$v)
    {
        $t[]=" `$index`='$k' ";
    }
    return implode(' or ', $t);
}

function cr_tempwhere_in($index)
{
    $t=array();
    
    return $index ." in (" . implode(',', array_keys($_SESSION['temp_chain'])).")";
}

function cr_order_in($index)
{
    return "ORDER BY FIELD($index," . implode(',', array_keys($_SESSION['temp_chain'])).")";
}

function cr_temparr()
{
    return $_SESSION['temp_chain'];
}
function cr_chainarr()
{
    return $_SESSION['chain'];
}

function cr_selog($k,$v)
{
    $u=cr_userid();
    $ip=$_SERVER['REMOTE_ADDR'];
    $sql="INSERT INTO `db_selog` (`ip`,`uid`,`key`,`value`) VALUES ('$ip','$u','$k','$v')";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    
}

function cr_sql()
{
    return isset($_SESSION['cr_sql'])?$_SESSION['cr_sql']:'';
}
function cr_set_sql($a='')
{
    $_SESSION['cr_sql']=$a;
}

function cr_log($what)
{
    $u = cr_userid();
    $rip = $_SERVER['REMOTE_ADDR'];
    $what=db_esc($what);
    $uri=db_esc($_SERVER['REQUEST_URI']);
    $sql="INSERT INTO `db_applog` (`action_name`,`user_id`,`uri`,`ipaddr`) VALUES ('$what','$u','$uri','$rip')";
    $r=mysql_query($sql) or debug($sql,mysql_error());
    
}

function cr_set_uq($uq)
{
    $_SESSION['unique']=$uq;
}

function cr_get_uq()
{
    return (isset($_SESSION['unique']))?$_SESSION['unique']:uniqid();
}
function  cr_set_rqt($str)
{
    $_SESSION['cr_rqt']=$str;
}
function cr_rqt()
{
    return isset($_SESSION['cr_rqt'])?$_SESSION['cr_rqt']:'';
}
function cr_gcc($id)
{
    return isset($_SESSION['cc'][$id])? (int)$_SESSION['cc'][$id]:0;
}

function cr_inc($id)
{
    if(!isset( $_SESSION['cc'][$id]))
        $_SESSION['cc'][$id]=1;
    else
        $_SESSION['cc'][$id]++;
}

function cr_ukey($id)
{
    return (isset($_SESSION['ukey'][$id]))?$_SESSION['ukey'][$id]:'';
}

function cr_set_status($s)
{
    $_SESSION['skey']=$s;
}
function cr_status()
{
    return (isset($_SESSION['skey']))?$_SESSION['skey']:0;
}