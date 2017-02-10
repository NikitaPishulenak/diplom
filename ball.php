<?php


session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC','report.ball');
cr_logic();


$fc_arr=db_kv('db_faculty','id','name');
$tf_arr=db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr=db_kv('db_ef', 'id_ef', 'name');



ui_sp("Проходной балл (за оплату)");

ui_sfs('','w100');

/* ++ HEADER ++ */
ui_rep_row();
ui_rep_th('Факультет','',2);
ui_rep_th('План приёма','',2);
ui_rep_th('Подано ','',2);
ui_rep_th('Забрали','',2);
ui_rep_th('Участвуют','',2);
ui_rep_th('Из них',2);
ui_rep_th('Балл','',2);
ui_end_row();
ui_rep_row();
ui_rep_th('ПВК');
ui_rep_th('Общий');
ui_end_row();
/* -- HEADER -- */
$sql=<<<EOF
(SELECT 
    faculty as  faculty_id,
    time_form_id,
    (SELECT name from db_faculty WHERE id=db_person.faculty) as faculty,
    (SELECT sum(db_planform.total)  FROM db_planform  WHERE (db_planform.faculty_id=db_person.faculty AND `time_form_id`=1)) as  plan,
    count(`id`) as pall,
    count(if(`state_id`=2,`id`,null)) as pclosed,
    count(if(`state_id`=1 ,`id`,null)) as popen,
    count(if(`state_id`=1 AND `target`=4,`id`,null)) as pvk,
    count(if(`state_id`=1 AND `target`=3,`id`,null)) as pgen
    FROM `db_person` WHERE (`faculty` in (SELECT `id` FROM `db_faculty`) AND `time_form_id`=1 AND `edu_form`=2) 
    GROUP BY `faculty`
)
UNION
(SELECT
    faculty as  faculty_id,
    time_form_id,
    (SELECT CONCAT(name,'(з)') from db_faculty WHERE id=db_person.faculty) as faculty,
    (SELECT sum(db_planform.total)  FROM db_planform  WHERE (db_planform.faculty_id=db_person.faculty AND `time_form_id`=2)) as  plan,
    count(`id`) as pall,
    count(if(`state_id`=2,`id`,null)) as pclosed,
    count(if(`state_id`=1 ,`id`,null)) as popen,
    count(if(`state_id`=1 AND `target`=4,`id`,null)) as pvk,
    count(if(`state_id`=1 AND `target`=3,`id`,null)) as pgen
    FROM `db_person` WHERE (`faculty` in (SELECT `id` FROM `db_faculty`) AND `time_form_id`=2 AND `edu_form`=2) 
    GROUP BY `faculty`
    )


EOF;

$t_pall=0;
$t_plan=0;
$t_pclosed=0;
$t_popen=0;
$t_pvk=0;
$t_pgen=0;

$r=mysql_query($sql) or debug($sql,  mysql_error());
while ($l=  mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th($l->faculty);
    ui_rep_td($l->plan);
    ui_rep_td($l->pall);
    ui_rep_td($l->pclosed);
    ui_rep_td($l->popen);
    ui_rep_td($l->pvk);
    ui_rep_td($l->pgen);
    $lim=($l->plan)?$l->plan-1-$l->pvk:0;
    $lim=($lim>0)?$lim:0;
    $sql="SELECT `total` FROM `db_person` WHERE `edu_form`=2 AND `faculty`=$l->faculty_id AND `time_form_id`=$l->time_form_id AND `state_id`=1 AND`target`=3 ORDER BY `total` DESC LIMIT $lim,2";
    $rr=mysql_query($sql) or debug($sql,  mysql_error());
    $l1=mysql_fetch_object($rr);
    $l2=mysql_fetch_object($rr);
    if(!$l1) $l1->total='-';
    if(!$l2) $l2->total='-';
    $out=($l1->total==$l2->total)?"($l2->total)":$l1->total;
    ui_rep_td($out);
    
    ui_end_row();
    
    $t_pall+=$l->pall;
    $t_plan+=$l->plan;
    $t_pclosed+=$l->pclosed;
    $t_popen+=$l->popen;
    $t_pvk+=$l->pvk;
    $t_pgen+=$l->pgen;
}

/* ++ FOOTER ++ */
    ui_rep_row();
    ui_rep_th('Всего:');
    ui_rep_th($t_plan);
    ui_rep_th($t_pall);
    ui_rep_th($t_pclosed);
    ui_rep_th($t_popen);
    ui_rep_th($t_pvk);
    ui_rep_th($t_pgen);
    ui_rep_th('');
    ui_end_row();
/* ++ FOOTER ++ */

ui_efs();


ui_ep();

