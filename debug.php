<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC', 'debug');
cr_logic();

ui_sp('Отладочные скрипты');
$menuitems = array();
$menuitems[] = '<a class="ctl_lnk" href="applog.php">Лог</a>';
$menuitems[] = '<a class="ctl_lnk" href="secviolation.php">Нарушения</a>';
$menuitems[] = '<a class="ctl_lnk" href="moved_journal.php">Журнал переводов</a>';
$menuitems[] = '<a class="ctl_lnk" href="sheet.php">Ведомость</a>';

$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="conv11to12.php">2011 год</a>';
$menuitems[] = '<a class="ctl_lnk" href="crttmp.php">Ключи</a>';
$menuitems[] = '<a class="ctl_lnk" href="plug-abby.php">Абитуриент.by</a>';
$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="desql.php">SQL</a>';
$menuitems[] = '<a class="ctl_lnk" href="dict_dump.php">Дамп словарей</a>';
$menuitems[] = '<a class="ctl_lnk" href="checking.php">Проверка по словарям</a>';
$menuitems[] = '<a class="ctl_lnk" href="vcard.php">VCARD</a>';
$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="delive.php">Подбить адреса МЖ</a>';
$menuitems[] = '<a class="ctl_lnk" href="decell.php">Нехватка целевых</a>';
$menuitems[] = '<a class="ctl_lnk" href="depf.php">П-ПД</a>';
$menuitems[] = '<a class="ctl_lnk" href="depool.php">Пул</a>';
$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="freeballws.php">Подбить зачисленных</a>';

print implode('',  array_filter($menuitems,'strlen'));
ui_ep();
