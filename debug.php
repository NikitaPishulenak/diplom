<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC', 'debug');
cr_logic();

ui_sp('���������� �������');
$menuitems = array();
$menuitems[] = '<a class="ctl_lnk" href="applog.php">���</a>';
$menuitems[] = '<a class="ctl_lnk" href="secviolation.php">���������</a>';
$menuitems[] = '<a class="ctl_lnk" href="moved_journal.php">������ ���������</a>';
$menuitems[] = '<a class="ctl_lnk" href="sheet.php">���������</a>';

$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="conv11to12.php">2011 ���</a>';
$menuitems[] = '<a class="ctl_lnk" href="crttmp.php">�����</a>';
$menuitems[] = '<a class="ctl_lnk" href="plug-abby.php">����������.by</a>';
$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="desql.php">SQL</a>';
$menuitems[] = '<a class="ctl_lnk" href="dict_dump.php">���� ��������</a>';
$menuitems[] = '<a class="ctl_lnk" href="checking.php">�������� �� ��������</a>';
$menuitems[] = '<a class="ctl_lnk" href="vcard.php">VCARD</a>';
$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="delive.php">������� ������ ��</a>';
$menuitems[] = '<a class="ctl_lnk" href="decell.php">�������� �������</a>';
$menuitems[] = '<a class="ctl_lnk" href="depf.php">�-��</a>';
$menuitems[] = '<a class="ctl_lnk" href="depool.php">���</a>';
$menuitems[]='<hr style="clear:both;" />';
$menuitems[] = '<a class="ctl_lnk" href="freeballws.php">������� �����������</a>';

print implode('',  array_filter($menuitems,'strlen'));
ui_ep();
