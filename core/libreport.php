<?php

#select * from db_person where vtime<from_unixtime(1331527739) and (xtime>from_unixtime(1331527739) or xtime=0);
function report_small($edu_form)
{
    
    
}

function report_plain($edu_form)
{
    
}

function report_discrete($edu_form)
{
    
}

function report_count($fc,$tf,$ef,$t_,$tt,$tc,$cr,$st)
{
    $w=array();
    $w[]=($fc)?"`faculty`='$fc'":'';
    $w[]=($tf)?"`time_form_id`='$tf'":'';
    $w[]=($ef)?"`edu_form`='$ef'":'';
    $w[]=($t_)?"`target`='$t_'":'';
    $w[]=($tt)?"`target_type`='$tt'":'';
    $w[]=($tc)?"`target_cell`='$tc'":'';
    $w[]=($cr)?"`region_cell`='$cr'":'';
    $w[]=($st)?"`state_id`='$st'":'';
    
    $where=implode(' AND ', array_filter($w,'strlen'));
    
    $sql="SELECT count(`id`)  c  from `db_person` WHERE ( $where );";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    if($l= mysql_fetch_object($r))
        return $l->c;
    else
        return 'e';
}

function report_count_by_total($fc,$tf,$ef,$t_,$tt,$tc,$cr,$st,$total)
{
    $w=array();
    $w[]=($fc)?"`faculty`='$fc'":'';
    $w[]=($tf)?"`time_form_id`='$tf'":'';
    $w[]=($ef)?"`edu_form`='$ef'":'';
    $w[]=($t_)?"`target`='$t_'":'';
    $w[]=($tt)?"`target_type`='$tt'":'';
    $w[]=($tc)?"`target_cell`='$tc'":'';
    $w[]=($cr)?"`region_cell`='$cr'":'';
    $w[]=($st)?"`state_id`='$st'":'';
    $w[]="`total`='$total'";
    
    $where=implode(' AND ', array_filter($w,'strlen'));
    
    $sql="SELECT count(`id`)  c  from `db_person` WHERE ( $where );";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    if($l= mysql_fetch_object($r))
        return $l->c;
    else
        return 'e';
}