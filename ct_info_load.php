<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

$subj=array('lang'=>'Язык','chem'=>'Химия','bio'=>'Биология');

define('PAGE_SEC','control.ct_info_load');
cr_logic();
set_time_limit(0);
if(!empty($_POST))
{
    $reg=$_POST['reg'];
    $sub=$reg['subject'];
    if(isset($_FILES['reg']['tmp_name']['data']))
    {
        $t=$_FILES['reg']['tmp_name']['data'];
        //die($t);
        $c=file_get_contents($t);
    }
    else
    {
        ui_redirect ('ct_info_load.php');
    }
    if($sub=="0") ui_redirect ('ct_info_load.php');
    
    $data=explode("\n", $c);
    $sql=array();
    foreach($data as $row)
    {
        if(!strlen(trim($row))) continue;
        $cols_src=explode(',', $row);
        $cols = array_map('db_esc', $cols_src);
        $surname=$cols[0];
        $name=$cols[1];
        $midname=$cols[2];
        $serial=$cols[3];
        $number=$cols[4];
        $sn="$cols[5]-$cols[6]-1";
        $xn="$cols[7]";
        $sum="$cols[9]";
        $sql[]="INSERT IGNORE INTO `db_ct_info`
            (`surname`,`name`,`midname`,`serial`,`number`)
            VALUES
            ('$surname','$name','$midname','$serial','$number');";
        //$r=mysql_query($sql) or debug($sql,  mysql_error());
        if($sub=="lang")
        {
            $sql[]="UPDATE `db_ct_info` SET
                `lct_sum`='$sum',`lct_sn`='$sn',`lct_xn`='$xn'
                WHERE (`serial`='$serial' AND `number`='$number') LIMIT 1;";
                
            //$r=mysql_query($sql) or debug($sql,  mysql_error());
        }
        if($sub=="chem")
        {
            $sql[]="UPDATE `db_ct_info` SET
                `cct_sum`='$sum',`cct_sn`='$sn',`cct_xn`='$xn'
                WHERE (`serial`='$serial' AND `number`='$number') LIMIT 1;";
                
            //$r=mysql_query($sql) or debug($sql,  mysql_error());
        }
        if($sub=="bio")
        {
            $sql[]="UPDATE `db_ct_info` SET
                `bct_sum`='$sum',`bct_sn`='$sn',`bct_xn`='$xn'
                WHERE (`serial`='$serial' AND `number`='$number') LIMIT 1;";
                
            //$r=mysql_query($sql) or debug($sql,  mysql_error());
        }
        
    }
    foreach($sql as $h)
    {
        $r=mysql_query($h) or debug($h,  mysql_error());
    }
    ui_redirect('ct_info_load.php');
}

ui_sp("Загрузка данных о ЦТ");
ui_ssfs();
$sql="SELECT * FROM `db_ct_info`";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs();
$i=0;
while($l=mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th(++$i);
    ui_rep_td_l($l->surname);
    ui_rep_td_l($l->name);
    ui_rep_td_l($l->midname);
    ui_rep_td_l($l->serial);
    ui_rep_td_l($l->number);
    ui_rep_td_l($l->lct_sum);
    ui_rep_td_l($l->lct_sn);
    ui_rep_td_l($l->lct_xn);
    ui_rep_td_l($l->cct_sum);
    ui_rep_td_l($l->cct_sn);
    ui_rep_td_l($l->cct_xn);
    ui_rep_td_l($l->bct_sum);
    ui_rep_td_l($l->bct_sn);
    ui_rep_td_l($l->bct_xn);
    ui_end_row();
}
ui_efs();
ui_esfs();
ui_sfmp();
ui_stfs();
ui_sptfs3();
ui_sfs();
ui_select('reg', 'subject', 'Предмет', $subj, 0);
ui_file('reg','data','CSV');
ui_efs();
ui_sptfs3();
ui_etfs();
ui_stfs('','w100');

ui_sfs();
//ui_ta('reg', 'csv', 'CSV', '','');
ui_efs();
ui_etfs();
ui_ef();
ui_ep();