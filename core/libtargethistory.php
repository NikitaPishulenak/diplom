<?php

$ron=array(1=>'create',2=>'change',3=>'move');
$roff=array(1=>'close',2=>'change');

function th_create($id,$r,$reg=array())
{
        $th_fc=db_esc($reg['faculty']);
        $th_tf=db_esc($reg['time_form_id']);
        $th_ef=db_esc($reg['edu_form']);
        $th_t_=db_esc($reg['target']);
        $th_tt=db_esc($reg['target_type']);
        $th_tc=db_esc($reg['target_cell']);
        $th_rc=db_esc($reg['region_cell']);
        $th_tl=db_esc($reg['total']);
        $vuid=cr_userid();
        $sql="INSERT `db_target_history` (`person_id`,`vtime`,`vuid`,`faculty`,`time_form_id`, `edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`reason`) 
                                        VALUES ('$id', NOW() ,'$vuid','$th_fc', '$th_tf'      , '$th_ef'  ,'$th_t_','$th_tt'     ,'$th_tc'     ,'$th_rc'     ,'$th_tl','$r');";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
}
function th_close($id,$r)
{
    $xuid=cr_userid();
    $sql="UPDATE `db_target_history` SET `xtime`=NOW(),`reasoff`='$r',`xuid`='$xuid' WHERE `person_id`='$id' AND `xtime`=0 LIMIT 1";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
}