<?php                                                                    
function ui_sp($title = '', $inpage = true) {
    $realname = (cr_logged()) ? cr_realname() : '<a href="login.php">Авторизация</a>';
    $h = (cr_logged()) ? '' : 'hide';
    $m = ui_menu();

    $cin = ($inpage) ? '' : '<!--';
    $cout = ($inpage) ? '' : '-->';

    $page_time= date('H:i');
    $q_arr=array(0=>'Не участвую','Свободно','Занято');
    $queue = $q_arr[cr_status()];
    $d_arr=array('admx'=>'Текущая','admx25'=>'За 25 число');
    $s_arr=array('admx'=>'screen.css','admx25'=>'screen25.css');
    $dbtitle=(isset($_SESSION['dbname']))?$d_arr[$_SESSION['dbname']]:'???';
    $style=(isset($_SESSION['dbname']))?$s_arr[$_SESSION['dbname']]:'screen.css';
    $lg= (cr_logged()) ? '| <a href="logout.php">Выход</a>' : '';
    print<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<meta http-equiv="Content-type" content="text/html;charset=windows-1251" />
		<title>$title</title>
		<link rel="stylesheet" type="text/css" href="css/$style?2" />
                <link rel="stylesheet" type="text/css" href="css/printer.css" media="print"/>
                <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
                <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.21.custom.css" />
    		  <link rel="stylesheet" type="text/css" href="css/codemirror.css" />
                <!-- <link rel="shortcut icon" href="favicon.ico" /> -->
                <link rel="shortcut icon" href="fav.png" />
                <script type="text/javascript" src="js/jquery-1.7.2.min.js" ></script>
                <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js" ></script>
    
                <script type="text/javascript" src="js/jquery.autocomplete.pack.js" ></script>
                <script type="text/javascript" src="js/chainscroll.js?2" ></script>
                <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" ></link><![endif]-->
	</head>
	<body>
<div class="fixed-menu $h">
$m
</div>
<div style="padding-top:5px"></div>
		<div class="ground">
			<div class="page">
				<div class="right">
                                        <!--<a href="api.php?m=status">$queue</a> |
                                        <a href="help.php" onclick="window.open('help.php', 'help', 'height=300,width=400');return false;" target="help">Помощь</a> |
					<a href="index.php">Главная</a>|-->
					<a href="javascript:calc_ui_use()">Калькулятор</a> |
					 $page_time |
					<a href="profile.php">$realname </a> $lg
				</div>
                                <p>&nbsp;</p>
                                <div class="right">
                                        <!--<a href="switch.php">$dbtitle</a>-->
                                </div>
				<div class="center">
					<h2>$cin $title $cout</h2>
				</div>

EOF;
}

function ui_ep() {
    $h = (cr_logged()) ? '' : 'hide';
    $id = (isset($_GET['id'])) ? (int) $_GET['id'] : 0;
    $tc = cr_tempcount();
    $rc = cr_chaincount();
    $ta = cr_temparr();
    $ra = cr_chainarr();
    
    array_walk($ta, 'ui_mklink', $id);
    array_walk($ra, 'ui_mklink', $id);
    $tl = implode('', $ta);
    $rl = implode('', $ra);
    
    print<<<EOF
			</div>
		</div>
<div class="quick_form $h">
    <form action="qs.php" method="get">
        <input type="text" class="elem" name="q" />
    </form>
</div>
<div class="temp_chain $h">
    <a style="float:left;" href="api.php?m=temp.cls">x</a><a href="temp_chain.php">$tc</a> 
    <hr />
    $tl
    <div style="height:97%"></div>
</div>
    <!--
<div class="real_chain $h">
    <a href="real_chain.php">$rc</a> <a href="api.php?m=real.cls">x</a>
    <hr />
    $rl
</div>-->
	</body>
</html>
EOF;
    define('UI_PAGE', '');
}

function tr($str = '') {
    return $str;
}

/*
  function ui_text_req($tag,$name,$title,$value,$m)
  {
  $vname=(empty($tag))?$name:"${tag}[${name}]";
  $value=htmlspecialchars($value, ENT_QUOTES);
  print<<<EOF
  <tr>
  <td class="elemtt"><nobr>$title:</nobr></td>
  <td class="elemtd"><input class="elem" type="text" id="$name" name="$vname" maxlength="$m" value="$value"></td>
  <td>&nbsp;*&nbsp;</td>
  </tr>
  EOF;
  }
 */

function ui_text($tag, $name, $title, $value, $m) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $value = htmlspecialchars($value, ENT_QUOTES, 'cp1251');
    print<<<EOF
	<tr>
		<td class="elemtt"><nobr>$title:</nobr></td>
		<td class="elemtd"><input class="elem" type="text" id="$name" name="$vname" maxlength="$m" value="$value"></td>
		<td>&nbsp;</td>
	</tr>
EOF;
}

/*
  function ui_select_req($tag,$name,$title,$values,$selected)
  {
  $vname=(empty($tag))?$name:"${tag}[${name}]";
  $options='';

  $s=($selected=="0")?'selected="selected"':"";
  $options.="<option $s value=\"0\">-- $title --</option>\n";
  foreach($values as $k=>$v)
  {
  $s=($selected==$k)?'selected="selected"':'';
  $options.="<option $s value=\"$k\">$v</option>\n";
  }
  print<<<EOF
  <tr>
  <td class="elemtt"><nobr>$title:</nobr></td>
  <td class="elemtd"><select class="elem" id="$name" name="$vname">$options</select></td>
  <td>&nbsp;*&nbsp;</td>
  </tr>
  EOF;
  }
 */

function ui_select($tag, $name, $title, $values, $selected) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $options = '';
    $s = ($selected == "0") ? 'selected="selected"' : "";
    $options.="<option $s value=\"0\">-- $title --</option>\n";
    foreach ($values as $k => $v) {
        if (is_int($selected)) {
            $s = ("$selected" == $k) ? 'selected="selected"' : '';
        } else {
            $s = ($selected == "$k") ? 'selected="selected"' : '';
        }
        $options.="<option $s value=\"$k\">$v</option>\n";
    }
    print<<<EOF
	<tr>
		<td class="elemtt"><nobr>$title:</nobr></td>
		<td class="elemtd"><select class="elem" id="$name" name="$vname">$options</select></td>
		<td>&nbsp;</td>
	</tr>
EOF;
}

function ui_select_check($tag, $name, $title, $values, $selected) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $options = '';
    $s = ($selected == "0") ? 'selected="selected"' : "";
    $options.="<option $s value=\"0\">-- $title --</option>\n";
    foreach ($values as $k => $v) {
        if (is_int($selected)) {
            $s = ("$selected" == $k) ? 'selected="selected"' : '';
        } else {
            $s = ($selected == "$k") ? 'selected="selected"' : '';
        }
        $options.="<option $s value=\"$k\">$v</option>\n";
    }
    print<<<EOF
	<tr>
		<td class="elemtt"><nobr>$title:</nobr></td>
		<td class="elemtd"><select class="elem" id="$name" name="$vname">$options</select></td>
		<td class="elemtt"><input  type="checkbox" id="${name}_check" name="check_${vname}" /></td>
	</tr>
EOF;
}

function ui_pass($tag, $name, $title, $value, $m) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    print<<<EOF
	<tr>
		<td class="elemtt"><nobr>$title:</nobr></td>
		<td class="elemtd"><input class="elem" type="password" id="$name" name="$vname" maxlength="$m" value="$value"></td>
		<td>&nbsp;</td>
	</tr>
EOF;
}

/* function ui_pass($tag,$name,$title,$value,$m)
  {

  } */

function ui_stfs($title = '', $c = '',$idt='') {
    
    if($idt) $idt="id=\"$idt\"";
/*    print<<<EOF
    
	<table class="stfs $c" $idt>
	if ($title) <caption>$title</caption>
	<tr>
		<td>
EOF;*/
print('<table class="stfs $c" $idt >');
if ($title<>'') print('	<caption>'.$title.'</caption>');
print('<tr><td>');   
}

function ui_etfs() {
    print<<<EOF
		</td>
	</tr>
	</table>
        
	<hr />
    

EOF;
}

function ui_sptfsn($class = '') {
    print<<<EOF
		</td>
		<td class="">
EOF;
}

function ui_sptfs($class = '') {
    print<<<EOF
		</td>
		<td class="vsplitter $class">
EOF;
}

function ui_sptfs3($class = '') {
    print<<<EOF
		</td>
		<td class="vsplitter3 $class">
EOF;
}

function ui_sfs($title = '', $class = '',$idt='') {
    if($idt) $idt="id=\"$idt\"";
	print('<table class="$class" $idt>');
if($title <> '')
	print('<caption>'.$title.'</caption>');

}

function ui_efs() {
    print<<<EOF
	</table>
EOF;
}

function ui_check($tag, $name, $title, $value) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $value = ($value) ? 'checked="checked"' : '';
    print<<<EOF
	<tr>

		<td class="elemch"><input  type="checkbox" id="$name" name="$vname"  $value></td>
		<td class="elemtd"><nobr>$title</nobr></td>
                <td>&nbsp;</td>
	</tr>
EOF;
}

function ui_chain_check($tag, $name, $title, $value) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $v = ($value) ? 'checked="checked"' : '';
    return<<<EOF
    <input type="checkbox" name="$vname" id="$name" $v />$title
EOF;
}

function ui_hidden($tag, $name, $value) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    print<<<EOF
   <input type="hidden" name="$vname" id="$name" value="$value">
EOF;
}

function ui_sf($action = '') {
    $uiq = uniqid(null, true);
    print<<<EOF
	<form action="$action" method="post" id="frm">
            <!--<input type="hidden" name="highjack" value="$uiq"/>-->

EOF;
}

function ui_sfmp() {
    $uiq = uniqid(null, true);
    print<<<EOF
	<form action="" method="post" id="frm" enctype="multipart/form-data">
            <!--<input type="hidden" name="highjack" value="$uiq"/>-->

EOF;
}

function ui_gf() {
    print<<<EOF
	<form action="" method="get" id="frm">

EOF;
}

function ui_ef($title = '') {


    ui_sc($title);
    print<<<EOF
</form>
EOF;
}

function ui_sc($title = '') {
    $a = (!empty($title)) ? "value=\"$title\"" : '';
    print<<<EOF
 <div class="center">  
    <input class="btn elem" type="submit" $a/>   
 </div>
EOF;
}

function ui_ef0() {
    print<<<EOF
</form>
EOF;
}

function ui_submit($tag, $name, $title, $value, $m) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    print<<<EOF
	<tr>
		<td><!--<nobr>$title:</nobr>--></td>
		<td class="elemtd"><input class="elem btn" type="submit" id="$name" name="$vname" maxlength="$m" value="$value"></td>
		<td>&nbsp;</td>
	</tr>
EOF;
}

function ui_redirect($file) {
    $host = $_SERVER['HTTP_HOST']; //($_SERVER['SERVER_PORT']==80)?$_SERVER['HTTP_HOST']:$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    if (headers_sent()) {
        print<<<EOF
<html><meta http-equiv="refresh" content="2; url=http://$host/$file"></meta></html>
EOF;
    } else {


        header("Location:http://$host$uri/$file");
        exit();
    }
}

function ui_blink($title, $href) {
    print<<<EOF
<a href="$href" title="$title">$title</a>

EOF;
}

function ui_vlink($title, $href) {
    print<<<EOF
<a class="vlink" href="$href" title="$title">$title</a><br />

EOF;
}

function ui_text_view($tag, $name, $title, $value = "") {
    $value = htmlspecialchars($value, ENT_QUOTES, 'cp1251');
    print <<<EOF
	<tr>
		<td class="vt elemtt">
			$title:
		</td>
		<td class="elemtv">
				$value
		</td>

	</tr>

EOF;
}

function ui_select_view($title, $options, $value) {
    $options[0] = "Нет";
    $options[''] = 'Нет';
    if (!isset($options[$value])) {
        $options[$value] = "<span style=\"color:red;font-weight:bold\">/N/D:$value/</span>";
    }
    print <<<EOF
	<tr>
		<td class="vt elemtt">
			$title:
		</td>
		<td class="elemtv">
			{$options[$value]}

		</td>

	</tr>

EOF;
}

function ui_check_view($title, $value) {
    
}

function ui_date_view($title, $value = "") {
    if (!empty($value)) {

        //$arr=split("[/.,-]",$value);
        $arr = explode("/", $value);
        if (count($arr) < 3)
            $arr = explode(".", $value);
        if (count($arr) < 3)
            $arr = explode(",", $value);
        if (count($arr) < 3)
            $arr = explode("-", $value);


        settype($arr[1], "integer");
    }
    else {
        $arr = array(0, 0, 0);
    }
//$id=subs$name,4,strlen($name-5);

    $mons = array(0 => 'Месяц', 1 => "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");

    $texted = $arr[2] . " " . $mons[$arr[1]] . " " . $arr[0];


    print <<<EOF
	<tr>
		<td class="elemtt">
			<nobr><b>$title:</b></nobr>
		</td>
		<td class="elemtv">
			$texted
		</td>

	</tr>

EOF;
}

function ui_rowlink($index, $title, $href, $a = array(), $o = array(), $b = array(), $c = '') {
    $p = implode('&', $a);
    $phr = (empty($p)) ? $href : "$href?$p";
    $other = '';
    if (!empty($o)) {
        foreach ($o as $v)
            $other.="<td class=\"elemkv\">$v</td>\n";
    }
    $pre = '';

    if (!empty($b)) {
        foreach ($b as $v) {
            $pre.="<td class=\"elemkv\">$v</td>\n";
        }
    }
    print<<<EOF
    <tr class="elemtr " $c>
            <td class="elemkv">
                <nobr>$index</nobr>
            </td>
            $pre
            <td class="elemsv">
                <a href="$phr">$title</a>
            </td>
            $other
    </tr>
EOF;
}

function ui_ssfs() {
    print<<<EOF
   <!--<a href="#" onclick="javascript:{ document.getElementsByClassName('ssfs')[0].style.overflow='visible';;return false;}">Expand</a>-->
   <div class="w100">
    <div class="ssfs" >

EOF;
}

function ui_esfs() {
    print<<<EOF
    </div>
        </div>
EOF;
}

function ui_script($script) {
    print<<<EOF
<script type="text/javascript" src="$script"></script>
EOF;
}

function ui_menu() {

    $menuitems = array();
    $menugroups = array();

    $menuitems[] = (cr_check('index')) ? '<a href="index.php">Главная</a>' : '';
    $menugroups[] = $menuitems;
    $menuitems = array();


    $menuitems[] = (cr_check('person.precreate')) ? '<a href="precreate.php">Предсоздание</a>' : '';
    $menuitems[] = (cr_check('person.create')) ? '<a href="create.php">Создать</a>' : '';
    $menuitems[] = (cr_check('person.rakeup')) ? '<a href="rakeup.php">Переданные</a>' : '';
    $menuitems[] = (cr_check('person.search')) ? '<a href="search.php">Поиск</a>' : '';
    $menuitems[] = (cr_check('person.search')) ? '<a href="rangesearch.php">Диапазоны</a>' : '';
    $menuitems[] = (cr_check('person.search')) ? '<a href="rev_search.php">По делам</a>' : '';
    $menugroups[] = $menuitems;
    $menuitems = array();
    $menuitems[] = (cr_check('person.chain')) ? '<a href="chain.php">Цепочки</a>' : '';
    $menuitems[] = (cr_check('person.query')) ? '<a href="query.php">Запросы</a>' : '';
    $menuitems[] = (cr_check('person.chain')) ? '<a href="sticker.php">Стикеры</a>' : '';
    $menugroups[] = $menuitems;
    $menuitems = array();
    $menuitems[] = (cr_check('report.ball')) ? '<a href="freebig.php">Балл (бюджет)</a>' : '';
    $menuitems[] = (cr_check('report.ball')) ? '<a href="paidball.php">Балл (платное)</a>' : '';
    //    $menuitems[] = (cr_check('report.note')) ? '<a href="note.php">Справка</a>' : '';
    $menuitems[] = (cr_check('report.note')) ? '<a href="note_denis.php">Ректорат</a>' : '';
    //$menuitems[] = (cr_check('report.note')) ? '<a href="note_by_day.php">Справка за день</a>' : '';
    $menuitems[] = (cr_check('report.analog')) ? '<a href="analog.php">Aналог</a>' : '';
    $menuitems[] = (cr_check('report.analog')) ? '<a href="analog_raw.php">Aналог(дела)</a>' : '';
    $menuitems[] = (cr_check('report.analog')) ? '<a href="analog_paid.php">Аналог(платное)</a>' : '';
    $menuitems[] = (cr_check('report.discrete')) ? '<a href="discrete.php">Дискрет</a>' : '';
    $menuitems[] = (cr_check('report.discrete')) ? '<a href="discrete_paid.php">Дискрет(платное)</a>' : '';
    $menuitems[] = (cr_check('report.discrete_raw')) ? '<a href="discrete_raw.php">Дискрет(дела)</a>' : '';
    $menugroups[] = $menuitems;
    $menuitems = array();
    $menuitems[] = (cr_check('control')) ? '<a href="control.php">Управление</a>' : '';
    $menuitems[] = (cr_check('control')) ? '<a href="debug.php">Отладка</a>' : '';
    $menugroups[] = $menuitems;
    $menuitems = array();
    $menuitems[] = (cr_check('kanckill')) ? '<a href="kanckill.php">Канцелярия</a>' : '';
    $menuitems[] = (cr_check('secretary')) ? '<a href="secretary.php">Секретарская</a>' : '';
    //$menuitems[] = (cr_check('poollist')) ? '<a href="poollist.php">Пул брони</a>' : '';
    $menuitems[] = (cr_check('phones')) ? '<a href="phones.php">Телефоны</a>' : '';
    $menuitems[] = (cr_check('files')) ? '<a href="files.php">Файлы</a>' : '';
    $menugroups[] = $menuitems;
    $menuitems = array();
    /*$menuitems[] = (cr_check('logout')) ? '<a href="logout.php">Выход</a>' : '';
    $menugroups[] = $menuitems;
    $menuitems = array();      */
    foreach ($menugroups as $v) {
        $menuitems[] = implode('', array_filter($v, 'strlen'));
    }
    return implode('<hr />', array_filter($menuitems, 'strlen'));
}

function ui_rep_th($a, $c = '', $r = '', $cl = '') {
    $cs = ($c) ? "colspan=\"$c\"" : '';
    $rs = ($r) ? "rowspan=\"$r\"" : '';
    print "<th class=\"rep_th $cl\" $cs $rs>$a</th>";
}

function ui_rep_td_l($a, $cl = '') {
    print "<th class=\"rep_td legh $cl\" >$a</th>";
}

function ui_rep_td($a) {
    print "<th class=\"rep_td\">$a</th>";
}

function ui_rep_td_r($a) {
    print "<th class=\"rep_td righ\" >$a</th>";
}

function ui_rep_row($c = '', $ex = '') {
    print "<tr class=\"rep_tr $c\" $ex>";
}

function ui_end_row() {
    print '</tr>';
}

function ui_bit_set($tag, $name, $title, $options, $values) {
    foreach ($options as $k => $v) {
        $m = 1 << ($k - 1);
        $c = ($values & $m) ? '1' : '';
        ui_check('', $tag . '[' . $k . ']', $v, $c);
    }
}

function ui_bit_sel($tag, $name, $title, $options, $values) {
    foreach ($options as $k => $v) {
        $ap = array(1 => "Отмечен", 2 => "Не отмечен");
        ui_select('', $tag . '[' . $k . ']', $v, $ap, 0);
    }
}

function ui_sptfs4($class = '') {
    print<<<EOF
		</td>
		<td class="vsplitter4 $class">
EOF;
}

function ui_date_edit($tag, $name, $title, $value) {

    if ($value == 0)
        $value = '0000-00-00';
    $vdate = explode('-', $value);

    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $m = db_kv('db_month', 'id_month', 'name');
    $d = range(1, 31);
    $y = range(2016, 1960);
    array_walk($d, 'ui_mkoption', $vdate[2]);
    array_walk($m, 'ui_mkoption_kv', $vdate[1]);
    array_walk($y, 'ui_mkoption', $vdate[0]);
    $do = implode("\n", $d);
    $mo = implode("\n", $m);
    $yo = implode("\n", $y);
    $cl = '--';
    ui_mkoption_kv($cl2, 0, $vdate[2]);
    ui_mkoption_kv($cl1, 0, $vdate[1]);
    ui_mkoption_kv($cl0, 0, $vdate[0]);
    print<<<EOF
    <tr>
		<td class="elemtt"><nobr>$title:</nobr></td>
		<td class="elemtd">
                    <select class="elemde" id="${name}_d" name="date[$name][d]">
                        $cl0
                        $do
                    </select>
                    <select class="elemde" id="${name}_m" name="date[$name][m]">
                        $cl1
                        $mo
                    </select>
                    <select class="elemde" id="${name}_y" name="date[$name][y]">
                        $cl2
                        $yo
                    </select>
                </td>
		<td></td>
	</tr>
EOF;
}

function ui_date_edit_future($tag, $name, $title, $value) {

    if ($value == 0)
        $value = '0000-00-00';
    $vdate = explode('-', $value);

    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $m = db_kv('db_month', 'id_month', 'name');
    $d = range(1, 31);
    $y = range(2025, 2012);
    array_walk($d, 'ui_mkoption', $vdate[2]);
    array_walk($m, 'ui_mkoption_kv', $vdate[1]);
    array_walk($y, 'ui_mkoption', $vdate[0]);
    $do = implode("\n", $d);
    $mo = implode("\n", $m);
    $yo = implode("\n", $y);
    $cl = '--';
    ui_mkoption_kv($cl2, 0, $vdate[2]);
    ui_mkoption_kv($cl1, 0, $vdate[1]);
    ui_mkoption_kv($cl0, 0, $vdate[0]);
    print<<<EOF
    <tr>
		<td class="elemtt"><nobr>$title:</nobr></td>
		<td class="elemtd">
                    <select class="elemde" id="${name}_d" name="date[$name][d]">
                        $cl0
                        $do
                    </select>
                    <select class="elemde" id="${name}_m" name="date[$name][m]">
                        $cl1
                        $mo
                    </select>
                    <select class="elemde" id="${name}_y" name="date[$name][y]">
                        $cl2
                        $yo
                    </select>
                </td>
		<td></td>
	</tr>
EOF;
}

function ui_mkoption(&$v, $k, $s) {
    $ss = ($s == $v) ? 'selected="selected"' : "";
    $v = "<option $ss value=\"$v\">$v</option>";
}

function ui_mkoption_kv(&$v, $k, $s) {
    $ss = ($s == $k) ? 'selected="selected"' : "";
    $v = "<option $ss  value=\"$k\">$v</option>";
}

function ui_mklink(&$v, $k, $c = '') {
    
    $c = ($c == $k) ? 'class="chain_active"' : '';
    $v = "<a $c title=\"$v\" href=\"view.php?id=$k\">$v</a>";
}

function ui_redirect_ref($file) {
    header("Location: $file");
    exit();
}

function ui_hr() {
    print '<hr />';
}

function ui_par($t) {
    $t = htmlspecialchars($t, ENT_QUOTES, 'cp1251');
    print "<p>$t</p>";
}

function ui_sap($options = array(), $value='',$def='Нет') {
    $options[0] = $def;
    $options[''] = $def;
    if (!isset($options[$value]))
        $options[$value] = "<span style=\"color:red;font-weight:bold\">/N/D:$value/</span>";
    return $options[$value];
}

function ui_pdf_sap($options = array(), $value) {
    $options[0] = "Нет";
    $options[''] = 'Нет';
    if (!isset($options[$value]))
        $options[$value] = "/N/D:$value/";
    return $options[$value];
}

function ui_ta($tag, $name, $title, $value, $m) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $value = htmlspecialchars($value, ENT_QUOTES, 'cp1251');
    print<<<EOF
        <tr><td colspan="3" class="elemtt">$title</td></tr>
        <tr><td colspan="3" class="elemtd"><textarea style="width:100%" id="$name" name="$vname">$value</textarea></td></tr>
        
EOF;
}

function ui_tv($tag, $name, $title, $value, $m='') {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $value = htmlspecialchars($value, ENT_QUOTES, 'cp1251');
    print<<<EOF
        <tr><td colspan="3" class="vt elemtt">$title:</td></tr>
        <tr><td colspan="3" class="elemtd">$value</td></tr>
        
EOF;
}

function ui_script_start() {
    print<<<EOF
    <script type="text/javascript">
EOF;
}

function ui_script_end() {
    print<<<EOF
    //</script>
EOF;
}

function ui_file($tag, $name, $title) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    print<<<EOF
    <tr>
        <td>$title:</td>
        <td><input type="file" class="elemtd" id="$name" name="$vname"/></td>
        <td>&nbsp;</td>
    </tr>
EOF;
}

function ui_view_header($p, $options) {
    $tf = ui_sap($options['tf'], $p['time_form_id']);
    $ef = ui_sap($options['ef'], $p['edu_form']);
    $t_ = ui_sap($options['t_'], $p['target']);
    $tt = ui_sap($options['tt'], $p['target_type']);
    $tc = ui_sap($options['tc'], $p['target_cell']);
    $rc = ui_sap($options['rc'], $p['region_cell']);
    $vb = ui_sap($options['dm'], $p['dual_mode_set'],'');

    if ($rc == 'Нет')
        $rc = '&nbsp;';
    if ($tc == 'Нет')
        $tc = '&nbsp;';
    $colors = db_kv('db_state', 'id_state', 'color');
    $color_st = db_bits2arr('db_student', 'id_student', 'style');
    $bgcolor = (isset($colors[$p['state_id']])) ? $colors[$p['state_id']] : '#ff0000';
    $bgcolor_st =(isset($color_st[$p['student_id']])) ? $color_st[$p['student_id']] : '';
    print<<<EOF
    <div class="target_abs" >
        <div class="target_value" title="Форма получения">$tf</div>
        <div class="target_value" title="Форма обучения">$ef</div>
        <div class="target_value" title="Конкурс"><table ><tr><td rowspan="2">$t_</td><td style="font-size:12pt">$tc</td></tr><tr><td style="font-size:12pt">$rc</td></tr></table></div>
        <div class="target_value" title="Тип конкурса">$tt</div>
        <div class="sum_value"></div>
        <div class="sum_value" title="Аттестат"><table ><tr><td rowspan="2">${p['certificate_sum']}</td><td style="font-size:12pt">&nbsp;</td></tr><tr><td style="font-size:12pt">А</td></tr></table></div>
        <div class="sum_value" title="Язык"><table ><tr><td rowspan="2">${p['lct_sum']}</td><td style="font-size:12pt">&nbsp;</td></tr><tr><td style="font-size:12pt">Я</td></tr></table></div>
<!--        <div class="sum_value" title="Химия"><table ><tr><td rowspan="2">${p['cct_sum']}</td><td style="font-size:12pt">&nbsp;</td></tr><tr><td style="font-size:12pt">Х</td></tr></table></div>-->
        <div class="sum_value" title="Биология"><table ><tr><td rowspan="2">${p['bct_sum']}</td><td style="font-size:12pt">&nbsp;</td></tr><tr><td style="font-size:12pt">Б</td></tr></table></div>
        <div class="sum_value" title="Химия"><table ><tr><td rowspan="2">${p['cct_sum']}</td><td style="font-size:12pt">&nbsp;</td></tr><tr><td style="font-size:12pt">Х</td></tr></table></div>

        
    </div>
    <!--<br />
    <br />
    <br />-->
    <table class="view_header" style="background-color:$bgcolor">
        <tr width="100%">
            <td width="150px" style="$bgcolor_st" >${p['delo_name']}</td>
            <td width="150px">${p['total']}&nbsp;</td>
            <td>${p['surname']} ${p['name']} ${p['midname']}</td>
            <td style="color:#dd0000;text-align:right;">$vb</td>
         </tr>
    </table>
    <br />
    
    <hr/>
EOF;
}

function ui_chain_links() {
    $sec_hidden = 'style="pointer-events:none; color:gray;"';

    $sec_export = (!cr_check('person.export')) ? $sec_hidden : '';
    $sec_print = (!cr_check('person.print')) ? $sec_hidden : '';
    $sec_print = (!cr_check('person.print')) ? $sec_hidden : '';
    $sec_receipt = (!cr_check('person.receipt')) ? $sec_hidden : '';
    $sec_listcase = (!cr_check('person.listcase')) ? $sec_hidden : '';
    $sec_average = (!cr_check('person.average')) ? $sec_hidden : '';
    $sec_envelop = (!cr_check('person.envelop')) ? $sec_hidden : '';
    $sec_notification = (!cr_check('person.notification')) ? $sec_hidden : '';
    $sec_order = (!cr_check('person.order_extract')) ? $sec_hidden : '';
    $sec_inventory = (!cr_check('person.inventory')) ? $sec_hidden : '';
    $sec_groupedit = (!cr_check('person.groupedit')) ? $sec_hidden : '';
    $sec_query = (!cr_check('person.query')) ? $sec_hidden : '';
    $sec_chain = (!cr_check('person.chain')) ? $sec_hidden : '';
    $sec_groupmake =  (!cr_check('person.groupmake')) ? $sec_hidden : '';

    print<<<EOF
   
    <ul>
        <li class="ddm" ><a $sec_export href="export.php">Экспорт</a>
            <ul>
                <li><a $sec_export href="fields.new.php">С выбором полей</a></li>
                <li><a $sec_export href="rawexport.php">RAW Export</a></li>
                <li><a $sec_export href="studexport.php">Экспорт в 'Студента'</a></li>
            </ul>
        </li>
        <li class="ddm"><a  $sec_print href="print_frame.php">Печать</a>
            <ul>
                <li><a $sec_receipt href="receipt_frame.php">Расписка</a></li>
                <li><a $sec_listcase href="listcase_frame.php">Опись папки</a></li>
                <li><a $sec_average href="average.php_frame">Сведения о ЦТ и Балле</a></li>
                <li><a $sec_envelop href="envelop.php">Конверт</a></li>
                <li><a $sec_notification href="notification.php">Извещение</a></li>
                <li><a $sec_notification href="notification_z.php">Извещение(З)</a></li>
                <li><a $sec_order href="order_extract.php">Выписка</a></li>
                <li><a $sec_order href="order_extract_ng.php">Выписка(З)</a></li>
                <li><a $sec_order href="order_extract_paid.php">Выписка(П)</a></li>
                <li><a $sec_inventory href="inventory.php">Опись</a></li>
                <li><a $sec_inventory href="inventory_n.php">Опись N</a></li>
                <li><a $sec_inventory href="inventory_wizard.php">Мастер описи</a></li>
		<li><a $sec_inventory href="invw2.php">Мастер описи 2</a></li>
                <li><a $sec_inventory href="inventory_csv.php">Опись XL</a></li>
            </ul>
        </li>
        <li class="ddm"><a $sec_groupedit href="groupedit.php">Правка</a>
        <ul>
                <li><a $sec_groupmake href="groupmake.php">Зачисление</a></li>
        </ul>
        </li>
        <li class="ddm"><span>Сохранить</span>
            <ul>
                <li><a  $sec_query href="query.php?new">Запрос</a></li>
                <li><a  $sec_chain href="chain.php?new">Цепочку</a></li>
            </ul>
        </li>
    </ul>
    <div style="clear:both;"></div>
        
EOF;
}

function ui_view_links($id) {
    $uid = cr_userid();
    $call_count = db_cv('db_call', 'person_id', "`person_id`='$id'");
    $fax_count = db_cv('db_fax', 'person_id', "`person_id`='$id'");
    $mail_count = db_cv('db_mail', 'person_id', "`person_id`='$id'");
    $cht__count = db_cv('db_target_history', 'person_id', "`person_id`='$id'");
    $chid_count = db_cv('db_chid', 'person_id', "`person_id`='$id' AND `chain_id`>0 ");
    $sec_hidden = 'style="pointer-events:none; color:gray;"';
    $sec_edit = (!cr_check('person.edit')) ? $sec_hidden : '';
    $sec_print = (!cr_check('person.print')) ? $sec_hidden : '';
    $sec_receipt = (!cr_check('person.receipt')) ? $sec_hidden : '';
    $sec_listcase = (!cr_check('person.listcase')) ? $sec_hidden : '';
    $sec_average = (!cr_check('person.average')) ? $sec_hidden : '';
    $sec_envelop = (!cr_check('person.envelop')) ? $sec_hidden : '';
    $sec_notification = (!cr_check('person.notification')) ? $sec_hidden : '';
    $sec_order = (!cr_check('person.order_extract')) ? $sec_hidden : '';
    $sec_inventory = (!cr_check('person.inventory')) ? $sec_hidden : '';
    $sec_close = (!cr_check('person.close')) ? $sec_hidden : '';
    $sec_move = (!cr_check('person.move')) ? $sec_hidden : '';
    $sec_change = (!cr_check('person.change')) ? $sec_hidden : '';
    $sec_history = (!cr_check('person.history')) ? $sec_hidden : '';
    $sec_walking = (!cr_check('person.walking')) ? $sec_hidden : '';
    $sec_transmit = (!cr_check('person.transmit')) ? $sec_hidden : '';
    $sec_pool = (!cr_check('person.pool')) ? $sec_hidden : '';
    $sec_call = (!cr_check('person.call')) ? $sec_hidden : '';
    $sec_chain = (!cr_check('person.chain')) ? $sec_hidden : '';
    $sec_stick = (!cr_check('person.stick')) ? $sec_hidden : '';
    print<<<EOF
   
        
    <ul id="viewmenu">
        <li class="ddm"><a $sec_edit title="Просмотр" href="view.php?id=$id">#</a>

        <li class="ddm"><a $sec_edit id="editlink" href="edit.php?id=$id">Правка</a>
        
<!--        <li class="ddm"><a $sec_print href="print_frame.php?id=$id">Печать</a>
//-->
        <li class="ddm"><a $sec_print href="print.php?id=$id" target="blank">Печать</a>
            <ul>
<!--                <li><a $sec_receipt href="receipt_frame.php?id=$id">Расписка</a></li>//-->
                <li><a $sec_receipt href="receipt.php?id=$id" target="blank">Расписка</a></li>
<!--                <li><a $sec_listcase href="listcase_frame.php?id=$id" target="blank">Опись папки</a></li>//-->
                <li><a $sec_listcase href="listcase.php?id=$id" target="blank">Опись папки</a></li>
<!--                <li><a $sec_average href="average_frame.php?id=$id">Сведения о ЦТ и Балле</a></li> //-->
                <li><a $sec_average href="average.php?id=$id" target="blank">Сведения о ЦТ и Балле</a></li>
                <li><a $sec_envelop href="envelop.php?id=$id" target="blank">Конверт</a></li>
                <li><a $sec_notification href="notification.php?id=$id" target="blank">Извещение</a></li>
                <li><a $sec_notification href="notification_z.php?id=$id" target="blank">Извещение(З)</a></li>
                <li><a $sec_order href="order_extract.php?id=$id" target="blank">Выписка</a></li>
                <li><a $sec_order href="order_extract_ng.php?id=$id" target="blank">Выписка(З)</a></li>
                <li><a $sec_order href="order_extract_paid.php?id=$id" target="blank">Выписка(П)</a></li>
                <li><a $sec_inventory href="inventory.php?id=$id" target="blank">Опись</a></li>
                <li><a $sec_inventory href="inventory_n.php?id=$id" target="blank">Опись N</a></li>
                <li><a $sec_inventory href="inventory_wizard.php?id=$id">Мастер описи</a></li>
                <li><a $sec_inventory href="invw2.php?id=$id">Мастер описи 2</a></li>
            </ul>
        </li>
        <li class="ddm"><a $sec_close href="close.php?id=$id">Закрыть</a>
            <ul>
                <li><a $sec_move href="move.php?id=$id">Перевод</a></li>
            </ul>
        </li>
        <li class="ddm"><a $sec_change href="change.php?id=$id">Смена конкурса:$cht__count</a></li>
        <li class="ddm"><a $sec_history href="history.php?id=$id">История</a></li>
        <li class="ddm"><a $sec_walking href="walking.php?id=$id">Движение</a>
            <ul>
                <li class="ddm"><a $sec_change href="infixation.php?id=$id">Фиксации</a></li>
            </ul>
        </li>
        <li class="ddm"><a $sec_transmit href="transmit.php?id=$id">Передать</a></li>
        <li class="ddm"><a $sec_pool href="pool.php?id=$id">Бронь</a></li>
        <li class="ddm"><a $sec_call href="call.php?id=$id">Звонки:$call_count</a>
    	    <ul>
    		<li><a $sec_call href="fax.php?id=$id">Факсы:$fax_count</a></li>
    		<li><a $sec_call href="mail.php?id=$id">Письма:$mail_count</a></li>
    	    </ul>
        </li>
        <li class="ddm"><a $sec_chain href="viewchains.php?id=$id">Цепочки:$chid_count</a>
            <ul>
                <!--<li class="ddm"><span>Создать</span></li>
                <li class="ddm"><span>Добавить к</span></li>
                <li class="ddm"><span>Удалить из </span></li>-->
                <li ><a $sec_stick href="stick.php?id=$id">Стикеры</a></li>
            </ul>
            </li>
        
    </ul>
    <div style="clear:both;"></div>
        
EOF;
}

function ui_edit_links($id,$p)
{
     $sec_hidden = 'style="pointer-events:none; color:gray;"';
    $sec_edit = (!cr_check('person.edit')) ? $sec_hidden : '';
print<<<EOF
    <ul id="viewmenu">
        <li class="ddm"><a $sec_edit id="editlink" title="Просмотр" href="view.php?id=$id">Просмотр</a></li>
        <li class="ddm"><span class="edit">${p['delo_name']}</span></li>
        <li class="ddm"><span class="edit">${p['total']}</span></li>
        <li class="ddm"><span class="edit" style="width:620px;">${p['surname']} ${p['name']} ${p['midname']}</span></li>
        <li class="ddm"><a $sec_edit href="javascript:form_save();">Сохранить</a></li>
        <li class="ddm">&nbsp;</li>
        <li style="clear:both;"></li>
    </ul>
EOF;
}

function ui_cm($m) {
    print<<<EOF
<div class="cm">
   $m
</div>    
EOF;
}

function ui_select_range($tag, $name, $title) {
    $vname = (empty($tag)) ? $name : "${tag}[${name}]";

    print<<<EOF
    <tr>
        <td class="elemtt nw">$title:</td>
        <td class="elemtd"><select class="elemde" name="${vname}[fexpr]">
            <option value='0'>--</option>
            <option value="eq">=</option>
            <option value="gt">&gt;</option>
            <option value="lt">&lt;</option>
            </select>
            <input class="elemde" style="width:50px" type="text" id="$name" name="${vname}[r1]" />
            <select class="elemde" name="${vname}[sexpr]">
            <option value='0'>--</option>
            <option value="gt">&gt;</option>
            <option value="lt">&lt;</option>
            </select>
            <input class="elemde" style="width:50px" type="text" id="$name" name="${vname}[r2]" />
            </td>
        <td>&nbsp;</td>
    </tr>    
EOF;
}

function ui_bit_where($tag, $options) {
    $res = '';

    $afx = (isset($_POST[$tag])) ? $_POST[$tag] : array();
    $afxisset = array();
    $afxnoset = array();
    foreach ($afx as $k => $v) {
        if (!$v)
            continue;;
        if ($v == 2)
            $afxnoset[] = '-' . $options[$k];
        if ($v == 1)
            $afxnoset[] = '+' . $options[$k];
    }

    $res = '[' . implode(',', $afxnoset) . ']';
    return $res;
}

function ui_date_where($name) {
    $afx_date = $_POST['date'][$name];
    $afx_date_d = isset($afx_date['d']) ? (int) $afx_date['d'] : 0;
    $afx_date_m = isset($afx_date['m']) ? (int) $afx_date['m'] : 0;
    $afx_date_y = isset($afx_date['y']) ? (int) $afx_date['y'] : 0;
    $afx_date_dw = ($afx_date_d) ? "Д=$afx_date_d " : '';
    $afx_date_mw = ($afx_date_m) ? "М=$afx_date_m " : '';
    $afx_date_yw = ($afx_date_y) ? "Г=$afx_date_y " : '';
    return "[$afx_date_dw$afx_date_mw$afx_date_yw]";
}

function ui_en2ru($text) {
    $str_replace = array(
        "й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ",
        "ф", "ы", "в", "а", "п", "р", "о", "л", "д", "ж", "э",
        "я", "ч", "с", "м", "и", "т", "ь", "б", "ю"
    );
    $str_search = array(
        "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "\[", "\]",
        "a", "s", "d", "f", "g", "h", "j", "k", "l", ";", "'",
        "z", "x", "c", "v", "b", "n", "m", ",", "."
    );
    return str_replace($str_search, $str_replace, $text);
}

function ui_nd($x)
{
    return ("$x"=='0')?'-':$x;
}

function ui_xd($x)
{
    
}

function ui_trlink($index,$title,$href)
{
    
print<<<EOF
    <tr>
        <td class="nw">$index</td>
        <td class="elemtv" ><a href="$href">$title</a></td>
        <td>&nbsp;</td>
    </tr>
                
EOF;
}

function ui_sdlg($title)
{
    print<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<meta http-equiv="Content-type" content="text/html;charset=windows-1251" />
		<title>$title</title>
		<link rel="stylesheet" type="text/css" href="css/screen.css" />
                <link rel="stylesheet" type="text/css" href="css/printer.css" media="print"/>
                <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
                <!-- <link rel="shortcut icon" href="favicon.ico" /> -->
                <link rel="shortcut icon" href="fav.png" />
                <script type="text/javascript" src="js/jquery-1.7.1.min.js" ></script>
                <script type="text/javascript" src="js/jquery.autocomplete.pack.js" ></script>
                <script type="text/javascript" src="js/chainscroll.js" ></script>
                <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" ></link><![endif]-->
	</head>
	<body>
        <div class="dlg_ground">
EOF;
}
function ui_edlg()
{
    print<<<EOF
        </div>
        </body>
        </html>
EOF;
}

function ui_stabs()
{
    print<<<EOF
    <div id="tabs">
EOF;
}

function ui_etabs()
{
    print<<<EOF
    </div><!-- /tabs -->
EOF;
}
function ui_tabh($a=array())
{
    $x=array();
    $y='';
    foreach($a  as $k=>$v)
    {
        $x[]="<li><a href=\"#tabs-$k\">$v</a></li>";
    }
    $y=implode('', $x);
    print<<<EOF
    <ul>
		$y
	</ul>
EOF;
}
function ui_stds()
{
    $i=cr_gcc('stds');
    cr_inc('stds');
    print<<<EOF
   <div id="tabs-$i">
    <!-- cc $i -->
EOF;
}

function ui_etds()
{
    print<<<EOF
    </div><!-- /stds -->

EOF;
}

function ui_ru2en($text) {
    $str_replace = array(
        "й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ",
        "ф", "ы", "в", "а", "п", "р", "о", "л", "д", "ж", "э",
        "я", "ч", "с", "м", "и", "т", "ь", "б", "ю"
    );
    $str_search = array(
        "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "\[", "\]",
        "a", "s", "d", "f", "g", "h", "j", "k", "l", ";", "'",
        "z", "x", "c", "v", "b", "n", "m", ",", "."
    );
    return str_replace( $str_replace,$str_search, $text);
}

function ui_addr_calc($p)
{
        $opt['country']=db_kv('db_country', 'id_country', 'name');
        $opt['region_by']=db_kv('db_region', 'id_region', 'name');
        $opt['subdiv_abbr']=db_kv('db_subdiv', 'id_subdiv', 'envelop_abbr');
        
    
	$country 	= ui_sap($opt['country'],$p['country']);
	$region_by 	= ui_sap($opt['region_by'],$p['region_by'],'');
	$region 	= $p['region_text'];
	$area           = $p['area'];
	$subdiv_abbr	= ui_sap($opt['subdiv_abbr'],$p['subdiv']);
	$city_name	= $p['city_name'];
        $zip            = $p['zip'];
        $microarea      = $p['microarea'];
        $street         = $p['street'];
        $house          = $p['house'];
        $house_part     = $p['house_part'];
        $room           = $p['room'];
        
      
        $addr_real   = '';
        if(strlen($zip))          $addr_real = $addr_real . $zip .', ';
        $addr_real = $addr_real . $country . ', ';
        if(!strlen($region) && strlen($region_by))      $addr_real = $addr_real . $region_by . ', ';
        if(strlen($region))       $addr_real = $addr_real . $region . ', ';
        if(strlen($area))         $addr_real = $addr_real . $area . ' район, ';
        $addr_real = $addr_real . $subdiv_abbr . '. ' . $city_name . ', ';
        if(strlen($microarea))    $addr_real = $addr_real . 'мкр-н '. $microarea . ', ';
        if(strlen($street))       $addr_real = $addr_real . $street . ', ';
        if(strlen($house))        $addr_real = $addr_real . ' д.' .$house;
        if(strlen($house_part))   $addr_real = $addr_real . ' корп.' . $house_part;
        if(strlen($room))         $addr_real = $addr_real . ' кв.' . $room;
        
        
        return $addr_real;
}

function ui_sticker_view($id)
{
    $sql="SELECT *,(SELECT `name` from `db_tag` where `id_tag`=`tag_id`) tag_name  FROM `db_tag_relation` WHERE `person_id`='$id'";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=  mysql_fetch_object($r))
    {
        ui_tag_item($l->id_tag_relation,$l->tag_id,$l->tag_name);
    }
}

function ui_tag_item($id,$tag_id,$name)
{
    print<<<EOF
    <div class="tag_lnk">
        <a  href="sticker.php?id=$tag_id">$name</a><a class="rem_tag" href="api.php?m=rem.tag&i=$id">x</a>
    </div>
EOF;
}

function ui_date4view($d)
{
    $a=array();
    $a=date_parse($d);
    $month = db_kv('db_month','id_month','issued');
    return ($a['day'])?$a['day'].' '.ui_sap($month,$a['month']).' '.$a['year']:'-- Нет --';
}

function ui_date_edit_num($tag, $name, $title, $value) {

    if ($value == 0)
        $value = '0000-00-00';
    $vdate = explode('-', $value);

    $vname = (empty($tag)) ? $name : "${tag}[${name}]";
    $m = range(1,12); //db_kv('db_month', 'id_month', 'name');
    $d = range(1, 31);
    $y = range(2016, 1960);
    array_walk($d, 'ui_mkoption', $vdate[2]);
    array_walk($m, 'ui_mkoption', $vdate[1]);
    array_walk($y, 'ui_mkoption', $vdate[0]);
    $do = implode("\n", $d);
    $mo = implode("\n", $m);
    $yo = implode("\n", $y);
    $cl = '--';
    ui_mkoption_kv($cl2, 0, $vdate[2]);
    ui_mkoption_kv($cl1, 0, $vdate[1]);
    ui_mkoption_kv($cl0, 0, $vdate[0]);
    print<<<EOF
    <tr>
		<td class="elemtt"><nobr>$title:</nobr></td>
		<td class="elemtd">
                    <select class="elemde" id="${name}_d" name="date[$name][d]">
                        $cl0
                        $do
                    </select>
                    <select class="elemde" id="${name}_m" name="date[$name][m]">
                        $cl1
                        $mo
                    </select>
                    <select class="elemde" id="${name}_y" name="date[$name][y]">
                        $cl2
                        $yo
                    </select>
                </td>
		<td></td>
	</tr>
EOF;
}


// Arrays (REMOVE THE LINE BREAKS! THIS NOT WON'T BE POSTED WITH SUCH LONG LINES!)

// functions
function uppercase($s) 
{
    $chars_hi = 'ABCDEFGHIJKLMNOPQRSTUVWXYZАБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯЁЂЃЄЅІЇЈЉЊЋЌЎЏҐ';
    $chars_lo = 'abcdefghijklmnopqrstuvwxyzабвгдежзийклмнопрстуфхцчшщъыьэюяёђѓєѕіїјљњћќўџґ';
    return strtr($s, $chars_lo, $chars_hi);
}
    
function lowercase($s) 
{
	$chars_hi = 'ABCDEFGHIJKLMNOPQRSTUVWXYZАБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯЁЂЃЄЅІЇЈЉЊЋЌЎЏҐ';
	$chars_lo = 'abcdefghijklmnopqrstuvwxyzабвгдежзийклмнопрстуфхцчшщъыьэюяёђѓєѕіїјљњћќўџґ';

        return strtr($s, $chars_hi, $chars_lo);
}
function ui_hidelink()
{
    return '<a style="float:right;margin:0;" onclick="{$(this.parentElement.parentElement).hide();return false;}" href="#">x</a>';
}