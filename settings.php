<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.php';

define('PAGE_SEC','control.settings');
cr_logic();

if(!empty ($_POST))
{
    $reg=$_POST['reg'];
    foreach($reg as $k=>$v)
    {
        $k=db_esc($k);
        $v=db_esc($v);
     $sql=" INSERT INTO `db_settings` (`hashkey`,`value`) ".
                        " VALUES ('$k','$v') ".
                        "  ON DUPLICATE KEY UPDATE `value`='$v'";
     $r=mysql_query($sql) or debug($sql,  mysql_error());
    }
    ui_redirect('settings.php');
}

$settings=db_kv('db_settings', 'hashkey', 'value');
ui_sp('Настройки');
ui_sf();
ui_stfs();
ui_sfs();
ui_text('reg', 'rector', 'Ректор', $settings['rector'], 50);
ui_text('reg', 'executor','Ответственный секретарь',$settings['executor'],50);
ui_text('reg', 'abby_login', 'Логин(абитериент.by)', $settings['abby_login'], 50);
ui_text('reg', 'abby_pass','Пароль(--//--)',$settings['abby_pass'],50);

ui_submit('reg', 'save', '', 'Сохранить', '');
ui_efs();
ui_etfs();

ui_ef0();

ui_ep();