<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

$modes = array('table' => '', 'import' => '', 'export' => '', 'clear' => '');
$mode = (isset($_GET['mode'])) ? $_GET['mode'] : 'table';
$mode = (isset($modes[$mode])) ? $mode : 'table';
$id = (isset($_GET['id'])) ? $_GET['id'] : '0';
settype($id, 'integer');
if ($id < 0)
    ui_redirect('dicttemp.php');

$ts = time();

if (!empty($_POST)) {
    switch ($mode) {
        case 'table':
            if ($id == 0) {
                
            } else {
                
            }
            break;
        case 'import':
            break;
        case 'export':
            header("Content-type: application/csv");
            header("Content-Disposition: inline; filename=db_dicttemp-$ts.csv");
            $sql = "SELECT * FROM `db_dicttemp";
            $r = mysql_query($sql) or debug($sql, mysql_error());
            $c = mysql_num_fields($r);
            while ($l = mysql_fetch_assoc($r)) {
                $lc = array_map('kvch', $l);

                echo implode(',', $lc);
                print "\r\n";
            }
            exit();
            break;
        case 'clear':
            $sql = "TRUNCATE `db_dicttemp`";
            $r = mysql_query($sql) or debug($sql, mysql_error());
            break;
    }
    ui_redirect('dicttemp.php');
}

ui_sp('DICTTITLE');
ui_blink('TABLE', '');
ui_blink('IMPORT', '');
ui_blink('EXPORT', '');
ui_blink('CLEAR', '');
ui_ssfs();
ui_esfs();

ui_sf();
ui_sfs('Record', 'w100');
ui_efs();
ui_ef();

ui_sfmp();
ui_sfs('Import', 'w100');
ui_efs();
ui_ef();

ui_sf();
ui_sfs('Export', 'w100');
ui_hidden('', 'hdden', '');
ui_efs();
ui_ef();

ui_sf();
ui_sfs('Clear', 'w100');
ui_efs();
ui_ef();

ui_ep();

function kvch($x) {
    $x = str_replace('"', '""', $x);
    return "\"$x\"";
}