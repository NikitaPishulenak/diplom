<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.edit.php';
include 'core/libtargethistory.php';

define('PAGE_SEC', 'person.edit');
cr_logic();

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');
if ($id <= 0) {
    ui_redirect('create.php');
}

if (!empty($_POST)) {
    // get previos version
    $p = db_single_record('db_person', 'id', $id);

    // Check data
    $edu = isset($_POST['edu']) ? $_POST['edu'] : array();
    $lang = isset($_POST['lang']) ? $_POST['lang'] : array();
    $bnf = isset($_POST['bnf']) ? $_POST['bnf'] : array();
    $com = isset($_POST['com']) ? $_POST['com'] : array();
    $oth = isset($_POST['oth']) ? $_POST['oth'] : array();
    //$dm=isset($_POST['dm'])?$_POST['dm']:array();
    $xc = isset($_POST['xc']) ? $_POST['xc'] : array();
    $wb = isset($_POST['wb']) ? $_POST['wb'] : array();
    $po = isset($_POST['po']) ? $_POST['po'] : array();

    $birthday = (isset($_POST['date']['birthday'])) ? $_POST['date']['birthday'] : array('d' => 0, 'm' => 0, 'y' => 0);
    $cert_date = (isset($_POST['date']['cert_date'])) ? $_POST['date']['cert_date'] : array('d' => 0, 'm' => 0, 'y' => 0);
    $live_date = (isset($_POST['date']['live_date'])) ? $_POST['date']['live_date'] : array('d' => 0, 'm' => 0, 'y' => 0);
    $aes_date = (isset($_POST['date']['aes_date'])) ? $_POST['date']['aes_date'] : array('d' => 0, 'm' => 0, 'y' => 0);
    $inv_date = (isset($_POST['date']['inv_date'])) ? $_POST['date']['inv_date'] : array('d' => 0, 'm' => 0, 'y' => 0);
    $aes_end_date = (isset($_POST['date']['aes_end_date'])) ? $_POST['date']['aes_end_date'] : array('d' => 0, 'm' => 0, 'y' => 0);
    $inv_end_date = (isset($_POST['date']['inv_end_date'])) ? $_POST['date']['inv_end_date'] : array('d' => 0, 'm' => 0, 'y' => 0);

    $uzo_date = (isset($_POST['date']['uzo_date'])) ? $_POST['date']['uzo_date'] : array('d' => 0, 'm' => 0, 'y' => 0);
    $authority_date = (isset($_POST['date']['authority_date'])) ? $_POST['date']['authority_date'] : array('d' => 0, 'm' => 0, 'y' => 0);
    

    // Save person

    $reg = $_POST['reg'];
    $reg = array_merge($p, $reg);
    $reg['total'] = $reg['certificate_sum'] + $reg['lct_sum'] + $reg['cct_sum'] + $reg['bct_sum'];
    $reg['wouldbe_id'] = db_bit_array($wb);
    //$reg['dual_mode_set']=db_bit_array($dm);
    $reg['xclass_id'] = db_bit_array($xc);
    $reg['education_id'] = db_bit_array($edu);
    $reg['language_set'] = db_bit_array($lang);
    $reg['benefit_set'] = db_bit_array($bnf);
    $reg['community_set'] = db_bit_array($com);
    $reg['other_set'] = db_bit_array($oth);
    $reg['po_lang_set'] = db_bit_array($po);
    $reg['birthday'] = db_mkdate($birthday);
    $reg['cert_date'] = db_mkdate($cert_date);
    $reg['live_date'] = db_mkdate($live_date);
    $reg['aes_date'] = db_mkdate($aes_date);
    $reg['inv_date'] = db_mkdate($inv_date);
    $reg['aes_end_date'] = db_mkdate($aes_end_date);
    $reg['inv_end_date'] = db_mkdate($inv_end_date);
    $reg['authority_date'] = db_mkdate($authority_date);
    $reg['auid']=  cr_userid();
    $reg['uzo_date'] = db_mkdate($uzo_date);
    $reg['live_addr'] = ui_addr_calc($reg);
    $res = db_update_values($reg);

    $u = cr_userid();
    $diff = array_diff_assoc($p, $reg);

    $d = array();
    foreach ($diff as $k => $v) {
        $d[] = "('$id','$u','$k','$v','${reg[$k]}')";
    }


    $sql = "UPDATE `db_person` SET $res WHERE (`id`='$id') LIMIT 1;";
    $r = mysql_query($sql) or debug($sql, mysql_error());

    if (!empty($d)) {
        $sql = "INSERT INTO `db_history` (`person_id`,`user_id`,`field`,`value_old`,`value_new`) VALUES " . implode(',', $d);
        $r = mysql_query($sql) or debug($sql, mysql_error());
    }
    if ($reg['total'] != $p['total']) {
        th_close($id, 2);
        th_create($id, 2, $reg);
    }

    ui_redirect("view.php?id=$id");
}




$p = db_single_record('db_person', 'id', $id);

$p['auid'] = cr_userid();
if ($p['state_id'] == '2')
    ui_redirect("view.php?id=$id");
ui_sp('Правка дела ' . $p['delo_name']);
ui_stfs();
//ui_blink('Просмотр', "view.php?id=$id");
ui_edit_links($id,$p);
ui_etfs();

ui_script_start();
print<<<EOF
        localStorage.clear();
EOF;
ui_script_end();

form_draw($p, 'edit');

$tabsetting = (cr_ukey('tabs')) ? "$('#tabs').tabs({select: function(event, ui) {document.getElementById('editlink').hash=ui.tab.hash;}});" : "$('#tabs ul ').hide();";
ui_script_start();
print <<<EOF
   $tabsetting

EOF;
ui_script_end();
ui_script("js/editscrolltop.js?2");
ui_script('js/scrolling.js.js?2');


ui_ep();
