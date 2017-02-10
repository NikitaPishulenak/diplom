<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';


include 'fpdf/fpdf.php';
include 'core/libpdf.php';
define('PAGE_SEC','person.listcase');
cr_logic();



$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0) ui_redirect ('noaccess.php');
if(!$id)
{
    $where=cr_tempwhere('id');
}
else
{
    $where="`id`='$id' LIMIT 1";
}

if(empty($where )) ui_redirect ('noacccess.php');
ui_sp('Опись папки',false);
print '<div id="menu-ground" class="menu-ground">';
ui_view_links($id);
print '</div><!-- menu-ground -->';
ui_script_start();
print<<<EOF
 $(document).ready(function(){
     
     var m=$('#menu-ground');
     $('.ground').remove();
     $('body').append(m);
     $('body').append('<iframe class="ground" border="0" src="listcase.php?id=$id" width="100%"></iframe>' );
     $('.ground').css('min-height','94%');
     });
EOF;
ui_script_end();
ui_ep();