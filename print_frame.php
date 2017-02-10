<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
define('PAGE_SEC','person.listcase');
cr_logic();
$id=(isset($_GET['id']))?$_GET['id']:0;

/** @todo FIXME */ 
ui_sp("Печать",false);
//print<<<EOF
//<iframe class="ground" border="0" src="print.php?id=$id"></iframe>
//EOF;
print '<div id="menu-ground" class="menu-ground">';
ui_view_links($id);
print '</div><!-- menu-ground -->';
ui_script_start();
print<<<EOF
 $(document).ready(function(){
     var m=$('#menu-ground');
     $('.ground').remove();
     $('body').append(m);
     $('body').append('<iframe class="ground" border="0" src="print.php?id=$id"></iframe>' );
     $('.ground').css('min-height','94%');
     });
EOF;
ui_script_end();

ui_ep();