<?php

function checkTargetAcl($fc,$tf,$ef,$t_,$tt,$tc,$rc)
{
    $fc=db_esc($fc);
    $tf=db_esc($tf);
    $ef=db_esc($ef);
    $t_=db_esc($t_);
    $tt=db_esc($tt);
    $tc=db_esc($tc);
    $rc=db_esc($rc);
    $sql=<<<EOF
    SELECT
        (
            (
                SELECT `id_target_allowable` id FROM `db_target_allowable` WHERE
                `faculty_id`='$fc' AND 
                `time_form_id`='$tf' AND
                `edu_form_id`='$ef' AND
                `target_id`='$t_' AND
                `target_type_id`='$tt' AND
                `target_cell_id`='$tc' AND
                `region_cell_id`='$rc' 
                LIMIT 1
            ) 
        or
            (
                SELECT  0
            )
        ) id
EOF;
$r=mysql_query($sql) or debug($sql,  mysql_error());
$l=mysql_fetch_object($r);
return ($l->id)?true:false;
    
}
function jsTargetAcl()
{
    ui_script_start();
    print<<<EOF
    var tacl = new Array (
        

EOF;
    $sql="SELECT * FROM `db_target_allowable`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=  mysql_fetch_object($r))
    {
        print<<<EOF
        new Array($l->faculty_id,$l->time_form_id,$l->edu_form_id,$l->target_id,$l->target_type_id,$l->target_cell_id,$l->region_cell_id),
            
EOF;
    }
    print<<<EOF
    new Array(0,0,0,0,0,0,0)
   );
EOF;
    ui_script_end();
}

function jsTargetAclFormable()
{
    ui_script_start();
    print<<<EOF
    var tacl = new Array (
        

EOF;
    $sql="SELECT * FROM `db_target_formable`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=  mysql_fetch_object($r))
    {
        print<<<EOF
        new Array($l->faculty_id,$l->time_form_id,$l->edu_form_id,$l->target_id,$l->target_type_id,$l->target_cell_id,$l->region_cell_id),
            
EOF;
    }
    print<<<EOF
    new Array(0,0,0,0,0,0,0)
   );
EOF;
    ui_script_end();
}

function jsInstRankAcl()
{
    $t=array();
    ui_script_start();
    print<<<EOF
    var iracl = new Array (
EOF;
    $sql="SELECT * FROM `db_ir_relation`";
    $r=mysql_query($sql) or debug($sql,  mysql_error());
    while($l=  mysql_fetch_object($r))
    {
        print "new Array($l->inst_rank_id,$l->institution_id),\n";
    }
    $arr=implode(',',$t);
    print<<<EOF
    
        new Array(0,0)
    );
EOF;
    ui_script_end();
}