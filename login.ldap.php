<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/login.php';

define('PAGE_SEC','login');
cr_logic();

if(!empty($_POST))
{
	$reg=$_POST['reg'];

	$username = db_esc($reg['username']);
	$password = db_esc($reg['password']);

/*
	$sql="SELECT id from `db_users` WHERE (`username`='$username' AND `password`='$password') LIMIT 1;";
	$r=mysql_query($sql) or debug($sql,mysql_error());
	$l=mysql_fetch_assoc($r);

	if(isset($l['id']) && $l['id']>0)
	{
			cr_create($l['id']);
			ui_redirect('index.php');
	}
        else
        {
            $rip=$_SERVER['REMOTE_ADDR'];
            $sql="insert into `db_secviol` (`ipaddr`,`rs`) VALUES ('$rip','fail password or login ($username | $password)')";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
        }
        */
        
        $ds = ldap_connect('192.168.0.249') or die('connect');
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
                        
        $rs = ldap_bind($ds,"uid=$username,dc=home,dc=local",$password) or die(ldap_error($ds));
        if(!$rs)
        {
        	die(ldap_error($ds));
        }
        $r = ldap_search($ds,'dc=home,dc=local',"(cn=*)",array('cn'));
        if(!$r)
        {
    	    die(ldap_error($ds));
        }
        
        
	ui_redirect('login.ldap.php');

}



ui_sp('Авторизация');
//print_r($_SESSION);
	form_draw();
        ui_par("USE FIREFOX 11 OR LATER!");
//        phpinfo();
ui_ep();
