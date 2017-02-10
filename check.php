<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'view/person.check.php';

define('PAGE_SEC', 'person.view');
cr_logic();



$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
settype($id, 'integer');
if ($id <= 0) {
    ui_redirect('noaccess.php');
}


$p = db_single_record('db_person', 'id', $id);


ui_sp('���� ' . $p['delo_name'], false);
$opt = array();
$opt['tf'] = db_kv('db_time_form', 'id_time_form', 'abbr');
$opt['ef'] = db_kv('db_ef', 'id_ef', 'abbr');
$opt['t_'] = db_kv('db_target', 'id_target', 'abbr');
$opt['tt'] = db_kv('db_targettype', 'id_targettype', 'abbr');
$opt['rc'] = db_kv('db_region', 'id_region', 'abbr');
$opt['tc'] = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$opt['dm'] = db_kv('db_dual_mode', 'id_dual_mode', 'abbr');
ui_view_header($p, $opt);
ui_stfs();
ui_view_links($id);
ui_etfs();
ui_stfs();
ui_sticker_view($id);
ui_etfs();
form_view($p, 'create');
ui_script_start();
print<<<EOF
        localStorage.clear();
        
EOF;
ui_script_end();

$tabsetting = (cr_ukey('tabs')) ? "$('#tabs').tabs();" : "$('#tabs ul ').hide();";
ui_script_start();
print <<<EOF
   $tabsetting
EOF;
ui_script_end();

ui_ep();
