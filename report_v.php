<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/trys.php';

define('PAGE_SEC','report.discrete');
cr_logic();

ui_sp('Раздел V');

$sql=<<<EOF
SELECT
count(distinct `serial`) c1,
count(distinct if(`subdiv` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='2'), `serial`,null)) c2,
count(distinct if(`inst_rank_id`='1',`serial`,null)) c3,
count(distinct if(`inst_rank_id`='1' and year(`cert_date`)=year(now()),`serial`,null)) c4,
count(distinct if(`inst_rank_id`='1' and year(`cert_date`)=year(now()) and `inst_city_type` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='1'),`serial`,null)) c5,
count(distinct if(`inst_rank_id`='1' and year(`cert_date`)=year(now()) and `inst_city_type` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='2'),`serial`,null)) c6,
count(distinct if(`inst_rank_id`='2' or  ((`education_id` & 1)=1),`serial`,null)) c7,
count(distinct if((`inst_rank_id`='2' or  ((`education_id` & 1)=1)) and year(`cert_date`)=year(now()),`serial`,null)) c8,
count(distinct if(`inst_rank_id`='3',`serial`,null)) c9,
count(distinct if(`inst_rank_id`='4' or  ((`education_id` & 2)=2),`serial`,null)) c10,
1 c0
FROM db_person 
where state_id>0 and faculty<>7
 and time_form_id=1
and id in (select person_id from `mfx`.`db_fixed_target` where state_id=1 and fixation_id in (3,4))
;


EOF;
ui_sfs('','w100');
    ui_rep_row();

    ui_rep_th('Всего');
    ui_rep_th('Проживают в сельских');
    ui_rep_th('Всего Ш');
    ui_rep_th('В этом году');
    ui_rep_th('ГШ');
    ui_rep_th('СШ');
    ui_rep_th('Всего ССУЗ');
    ui_rep_th('В этом году');
    ui_rep_th('ПТУ');
    ui_rep_th('ВУЗ');
    ui_end_row();


$r=mysql_query($sql) or debug($sql,mysql_error());
while($l=mysql_fetch_object($r))
{
    ui_rep_row();
    
    ui_rep_th($l->c1);
    ui_rep_th($l->c2);
    ui_rep_th($l->c3);
    ui_rep_th($l->c4);
    ui_rep_th($l->c5);
    ui_rep_th($l->c6);
    ui_rep_th($l->c7);
    ui_rep_th($l->c8);
    ui_rep_th($l->c9);
    ui_rep_th($l->c10);
    ui_end_row();
}
ui_efs();


$sql=<<<EOF
SELECT
count(distinct if(`inst_rank_id`='1' and `inst_city_type` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='1'),`serial`,null)) c1,
count(distinct if(`inst_rank_id`='1' and year(`cert_date`)=year(now()) and `inst_city_type` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='1'),`serial`,null)) c2,
count(distinct if(`inst_rank_id`='1' and `inst_city_type` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='2'),`serial`,null)) c3,
count(distinct if(`inst_rank_id`='1' and year(`cert_date`)=year(now()) and `inst_city_type` in (SELECT `id_subdiv` FROM `db_subdiv` WHERE `city_rang_id`='2'),`serial`,null)) c4,
count(distinct if(`inst_rank_id`='1' and institution_id in (1,3),`serial`,null)) c5,
count(distinct if(`inst_rank_id`='2' or  ((`education_id` & 1)=1),`serial`,null)) c6,
count(distinct if((`inst_rank_id`='2' or  ((`education_id` & 1)=1)) and year(`cert_date`)=year(now()),`serial`,null)) c7,
count(distinct if(`inst_rank_id`='3',`serial`,null)) c8,
count(distinct if(`inst_rank_id`='3' and year(`cert_date`)=year(now()),`serial`,null)) c9,
count(distinct if(`inst_rank_id`='4' or  ((`education_id` & 2)=2),`serial`,null)) c10,
count(distinct if(`natio`>1,`serial`,null)) c11,
count(distinct if(`natio` in (2,3,4,5),`serial`,null)) c12,
1 c0
FROM db_person 
where state_id>0 and faculty<>7
and time_form_id=2
and student_id=1
-- and id in (select person_id from `mfx`.`db_fixed_target` where state_id=1 and fixation_id in (3,4))
;


EOF;
ui_sfs('','w100');
    ui_rep_row();

    ui_rep_th('Город');
    ui_rep_th('Г год');
    ui_rep_th('Село');
    ui_rep_th('С год');
    ui_rep_th('Л и Г');
    ui_rep_th('ССУЗ');
    ui_rep_th('С год');
    ui_rep_th('ПТУ');
    ui_rep_th('П год');
    ui_rep_th('ВУЗ');
    ui_rep_th('Ин');
    ui_rep_th('РККТ');
    ui_end_row();


$r=mysql_query($sql) or debug($sql,mysql_error());
while($l=mysql_fetch_object($r))
{
    ui_rep_row();
    
    ui_rep_th($l->c1);
    ui_rep_th($l->c2);
    ui_rep_th($l->c3);
    ui_rep_th($l->c4);
    ui_rep_th($l->c5);
    ui_rep_th($l->c6);
    ui_rep_th($l->c7);
    ui_rep_th($l->c8);
    ui_rep_th($l->c9);
    ui_rep_th($l->c10);
    ui_rep_th($l->c11);
    ui_rep_th($l->c12);
    ui_end_row();
}
ui_efs();

ui_ep();