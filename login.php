<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/login.php';
include 'ldaptest/index.php';

define('PAGE_SEC','login');
cr_logic();

if(!empty($_POST))
{
	$reg=$_POST['reg'];

	$username = db_esc(trim($reg['username']));
	$password = db_esc(trim($reg['password']));
    $domain = db_esc($reg['domain']);

        if(empty($password))
        {
            ui_redirect('login.php');
        }
//
//        if($domain==2)
//        {
//            if(pk_ldap($username, $password))
//                $sql="SELECT id from `db_users` WHERE (`username`='$username' ) LIMIT 1;";
//            else
//                ui_redirect ('login.php');
//
//        }
//        else
        //{
            $sql="SELECT id from `db_users` WHERE (`username`='$username' AND `password`=MD5('$password') AND `password`<>'') LIMIT 1;";
        //}
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
	ui_redirect('login.php');

}



ui_sp('Authorization');
//print_r($_SESSION);
	form_draw();
        ui_par("USE FIREFOX 11 OR LATER!");
ui_ep();
