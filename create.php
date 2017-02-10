<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libtargethistory.php';
include 'form/person.create.php';
include 'core/libtargetacl.php';
define('PAGE_SEC','person.create');
cr_logic();

if(!empty($_POST))
{
	// Check data
        $edu=isset($_POST['edu'])?$_POST['edu']:array();
        $lang=isset($_POST['lang'])?$_POST['lang']:array();
        $bnf=isset($_POST['bnf'])?$_POST['bnf']:array();
        $com=isset($_POST['com'])?$_POST['com']:array();
        $oth=isset($_POST['oth'])?$_POST['oth']:array();
        //$dm=isset($_POST['dm'])?$_POST['dm']:array();
        $xc=isset($_POST['xc'])?$_POST['xc']:array();
        $wb=isset($_POST['wb'])?$_POST['wb']:array();
        $po=isset($_POST['po'])?$_POST['po']:array();
        
        $birthday=(isset($_POST['date']['birthday']))?$_POST['date']['birthday']:array('d'=>0,'m'=>0,'y'=>0);
        $cert_date=(isset($_POST['date']['cert_date']))?$_POST['date']['cert_date']:array('d'=>0,'m'=>0,'y'=>0);
        $live_date=(isset($_POST['date']['live_date']))?$_POST['date']['live_date']:array('d'=>0,'m'=>0,'y'=>0);
        $aes_date=(isset($_POST['date']['aes_date']))?$_POST['date']['aes_date']:array('d'=>0,'m'=>0,'y'=>0);
        $inv_end_date=(isset($_POST['date']['inv_end_date']))?$_POST['date']['inv_end_date']:array('d'=>0,'m'=>0,'y'=>0);
        $aes_end_date=(isset($_POST['date']['aes_end_date']))?$_POST['date']['aes_end_date']:array('d'=>0,'m'=>0,'y'=>0);
        $inv_date=(isset($_POST['date']['inv_date']))?$_POST['date']['inv_date']:array('d'=>0,'m'=>0,'y'=>0);
        $uzo_date=(isset($_POST['date']['uzo_date']))?$_POST['date']['uzo_date']:array('d'=>0,'m'=>0,'y'=>0);
        $authority_date=(isset($_POST['date']['authority_date']))?$_POST['date']['authority_date']:array('d'=>0,'m'=>0,'y'=>0);
        
	// Save person
	$reg=$_POST['reg'];
        $reg['uq']=(empty($reg['uq']))?uniqid():$reg['uq'];
        
        /*+++ NO DOUBLE +++*/
        if($reg['uq']== cr_get_uq()) ui_redirect ('nodouble.php');
        cr_set_uq($reg['uq']);
        /*--- NO DOUBLE ---*/
        $reg['ctime']='__ctime__';
        $reg['total']=$reg['certificate_sum']+$reg['lct_sum']+$reg['cct_sum']+$reg['bct_sum'];
        $reg['wouldbe_id']=db_bit_array($wb);
        //$reg['dual_mode_set']=db_bit_array($dm);
        $reg['xclass_id']=db_bit_array($xc);
        $reg['po_lang_set']=db_bit_array($po);
        $reg['education_id']=db_bit_array($edu);
        $reg['language_set']=db_bit_array($lang);
        $reg['benefit_set']=db_bit_array($bnf);
        $reg['community_set']=db_bit_array($com);
        $reg['other_set']=db_bit_array($oth);
        $reg['birthday']=db_mkdate($birthday);
        $reg['cert_date']=db_mkdate($cert_date);
        $reg['live_date']=db_mkdate($live_date);
        $reg['aes_date']=db_mkdate($aes_date);
        $reg['inv_date']=db_mkdate($inv_date);
        $reg['aes_end_date']=db_mkdate($aes_end_date);
        $reg['inv_end_date']=db_mkdate($inv_end_date);
        $reg['live_addr'] = ui_addr_calc($reg);
        $reg['uzo_date']=db_mkdate($uzo_date);
        $reg['authority_date']=db_mkdate($authority_date);
        $reg['filltime']=time()-$reg['filltime'];
        $f=(int)$reg['faculty'];
        if(!$f) ui_redirect ('noaccess.php');
        $t=(int)$reg['time_form_id'];
        if(!$t) ui_redirect ('noaccess.php');
        $pool=db_single_record_a('db_pool', array('faculty_id'=> $f,'time_form_id'=>$t));
	var_dump($pool);
        
        
        if(is_array($pool))
        {
            $pool_int=$pool['delo_id'];
            $sql="DELETE FROM `db_pool` WHERE `id_pool`='${pool['id_pool']}' LIMIT 1";
            $r=mysql_query($sql) or debug($sql,  mysql_error());
        }
        else
        {
	    	$sql="SELECT * FROM `db_submitted` WHERE `faculty_id`='$f' AND `time_form_id`='$t' LIMIT 1;";
		if (is_array(mysql_fetch_array(mysql_query($sql))))
	            $sql="UPDATE `db_submitted` SET `total`=`total`+1 WHERE `faculty_id`='$f' AND `time_form_id`='$t' LIMIT 1;";
		else
		    $sql="INSERT INTO `db_submitted` SET `total`=`total`+1, `faculty_id`='$f', `time_form_id`='$t'";
            $r=mysql_query($sql) or debug($sql,mysql_error());
            $pool_int = 0;
        }
        $sql="SELECT `total` FROM `db_submitted` WHERE `faculty_id`='$f' AND `time_form_id`='$t' LIMIT 1";
        $r=mysql_query($sql) or debug($sql,mysql_error());
        $l=mysql_fetch_object($r);
        if(!$pool_int) $pool_int=$l->total;
        $fk=db_single_record('db_faculty', 'id', $f);
        $tk=db_single_record('db_time_form', 'id_time_form', $t);
        $reg['delo_name']="${fk['abbr']}${tk['abbrdelo']}-$pool_int";
        $reg['delo_int']=$pool_int;
        
	$res=db_field_values($reg);
        $res[1] = str_replace("'__ctime__'",' NOW() ' , $res[1]);
	$sql="INSERT INTO `db_person` (${res[0]}) VALUES ($res[1])";
	$r=mysql_query($sql) or debug($sql,mysql_error());
	$id=mysql_insert_id();
        
        /* TARGET HISTORY */
        th_create($id,1,$reg);
	ui_redirect("view.php?id=$id");

}

$p=db_empty_record('db_person');
$d=db_default_record('db_person');

$p['auid']=cr_userid();
$p['cuid']=cr_userid();
$p['vuid']=0;
$p['xuid']=0;
$p['state_id']=1;
$p['uq']=uniqid();
$p['filltime']=time();


$subdivs=db_kv('db_subdiv','id_subdiv','abbr');

$js_subdivs="var subdiv_dict=Array('','".implode("','",$subdivs)."');";


ui_sp('Новое дело');
	form_draw($p,'create');
        ui_script("js/test.js?2");
	ui_script("js/create.js");
        ui_script('defaults/person.js?2');
        ui_script('js/ac.js?2');
        ui_script('js/localCreater.js?2');
        jsTargetAclFormable();
        jsInstRankAcl();
        $def_faculty = cr_ukey('faculty');
        $tabsetting=(cr_ukey('tabs'))?"$('#tabs').tabs();":"$('#tabs ul ').hide();";
        ui_script_start();
        print <<<EOF
   $tabsetting
       
EOF;
        print<<<EOF
        $js_subdivs;
        $("#birthday_y option[value='2012']").remove();
        $("#birthday_y option[value='2011']").remove();
        $("#birthday_y option[value='2010']").remove();
        $("#birthday_y option[value='2009']").remove();
        $("#birthday_y option[value='2008']").remove();
        $("#birthday_y option[value='2007']").remove();
        $("#birthday_y option[value='2006']").remove();
        $("#birthday_y option[value='2005']").remove();
        $("#birthday_y option[value='2004']").remove();
        $("#birthday_y option[value='2003']").remove();
        $("#birthday_y option[value='2002']").remove();




EOF;
        ui_script_end();
ui_ep();
