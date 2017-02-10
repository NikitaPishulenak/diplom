<?php


session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC','report.ball');
cr_logic();

$raw = isset($_GET['raw']) ? (int) $_GET['raw'] : 1;
$afx = isset($_GET['afx']) ? (int) $_GET['afx'] : 0;
$mfx = isset($_GET['mfx']) ? (int) $_GET['mfx'] : 0;

$afx_arr= db_kv('afx`.`db_fixation','id_fixation','name');
$mfx_arr= db_kv('mfx`.`db_fixation','id_fixation','name');

if($afx<0) $afx=end(array_keys($afx_arr));
$target_table=($afx)?'`afx`.`db_fixed_target`':'`db_person`';
$target_table=($mfx)?'`mfx`.`db_fixed_target`':$target_table;

$fid=($afx)?"`fixation_id`=$afx AND ":'';
$fid=($mfx)?"`fixation_id`=$mfx AND ":$fid;

$target_key=($afx || $mfx)?'`person_id`':'`id`';

$fc_arr=db_kv('db_faculty','id','name');
$tf_arr=db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr=db_kv('db_ef', 'id_ef', 'name');



ui_sp("Проходной балл (за оплату)");

if($raw)
{
ui_gf();
    ui_stfs('Фиксационная выборка');
    ui_sfs();
    ui_select('','afx','Автоматическая',$afx_arr,$afx);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_select('','mfx','Ручная',$mfx_arr,$mfx);    
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_check('', 'raw', 'для печати', 0);
    ui_efs();
    ui_sptfs4();
    ui_sfs();
    ui_submit('', '', '', 'Показать', '');
    ui_efs();
    ui_etfs();
ui_ef0();
}

ui_sfs('','w100');

/* ++ HEADER ++ */
ui_rep_row();
ui_rep_th('Факультет','',2);
ui_rep_th('План приёма','',2);
ui_rep_th('Подано ','',2);
ui_rep_th('Забрали','',2);
ui_rep_th('Участвуют','',2);
ui_rep_th('Из них',3);
ui_rep_th('Балл -1','',2);
ui_rep_th('Балл','',2);
ui_rep_th('П/п балл ','',2);
ui_rep_th('Кол-во п/п/б','',2);
ui_end_row();
ui_rep_row();
ui_rep_th('ПВК');
ui_rep_th('ПСК');
ui_rep_th('Общий');
ui_end_row();
/* -- HEADER -- */
$sql=<<<EOF
(SELECT 
    faculty as  faculty_id,
    time_form_id,
    (SELECT name from db_faculty WHERE id=faculty) as faculty,
    (SELECT sum(db_planform.total)  FROM db_planform  WHERE (db_planform.faculty_id=faculty AND `time_form_id`=1 AND `edu_form_id` =2)) as  plan,
    count(if(`state_id`<>0,$target_key,null)) as pall,
    count(if(`state_id`=2,$target_key,null)) as pclosed,
    count(if(`state_id`=1 ,$target_key,null)) as popen,
    count(if(`state_id`=1 AND `target`=4,$target_key,null)) as pvk,
    count(if(`state_id`=1 AND `target`=6,$target_key,null)) as psk,
    count(if(`state_id`=1 AND `target`=3,$target_key,null)) as pgen
    FROM $target_table WHERE ($fid `faculty` in (SELECT `id` FROM `db_faculty`) AND `time_form_id`=1 AND `edu_form`=2) 
    GROUP BY `faculty`
)
UNION
(SELECT
    faculty as  faculty_id,
    time_form_id,
    (SELECT CONCAT(name,'(з)') from db_faculty WHERE id=faculty) as faculty,
    (SELECT sum(db_planform.total)  FROM db_planform  WHERE (db_planform.faculty_id=faculty AND `time_form_id`=2 AND `edu_form_id`=2)) as  plan,
    count(if(`state_id`<>0,$target_key,null)) as pall,
    count(if(`state_id`=2,$target_key,null)) as pclosed,
    count(if(`state_id`=1 ,$target_key,null)) as popen,
    count(if(`state_id`=1 AND `target`=4,$target_key,null)) as pvk,
    count(if(`state_id`=1 AND `target`=6,$target_key,null)) as psk,
    count(if(`state_id`=1 AND `target`=3,$target_key,null)) as pgen
    FROM $target_table WHERE ($fid `faculty` in (SELECT `id` FROM `db_faculty`) AND `time_form_id`=2 AND `edu_form`=2) 
    GROUP BY `faculty`
    )


EOF;

$t_pall=0;
$t_plan=0;
$t_pclosed=0;
$t_popen=0;
$t_pvk=0;
$t_psk=0;
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
    ui_rep_td($l->psk);
    ui_rep_td($l->pgen);
    $lim=($l->plan)?$l->plan-1-$l->pvk:0;
    $lim=($lim>0)?$lim:0;
    $x_mest=($l->plan)?$l->plan-$l->pvk:0;
    $sql="SELECT `total` FROM $target_table WHERE $fid `edu_form`=2 AND `faculty`=$l->faculty_id AND `time_form_id`=$l->time_form_id AND `state_id`=1 AND `target`=3 ORDER BY `total` DESC ";
    $rr=mysql_query($sql) or debug($sql,  mysql_error());
    $x_ball=0;
    $xp_ball='';
    $t1_ball=0;
    $t2_ball=0;
    $i_c=0;
    $p_c=0;
    $m_c=0;
    while($ll=  mysql_fetch_object($rr))
    {
        $i_c++;
        if($i_c>$x_mest)
        {
            if($x_ball==$ll->total)
            {
                $xp_ball="($ll->total)";
                $p_c++;
            }
        }
        else
        {
            /*
            
            $t2_ball=($t2_ball==$t1_ball)?$t2_ball:$t1_ball;
            $p_c=($t1_ball==$x_ball)?$p_c+1:1;
            $t1_ball=($t1_ball==$x_ball)?$t1_ball:$x_ball;
            */
            $x_ball=$ll->total;
            $t2_ball=($t1_ball==$x_ball)?$t2_ball:$t1_ball;
            $p_c = ($t1_ball==$x_ball) ?$p_c+1:1;
            $m_c = ($t1_ball==$x_ball) ?$m_c+1:1;
            $t1_ball=$x_ball;
        }
    }
    
    ui_rep_td($t2_ball);
    ui_rep_td($x_ball);
    ui_rep_td($xp_ball);
    ui_rep_td("$p_c/$m_c");
    
    ui_end_row();
    
    $t_pall+=$l->pall;
    $t_plan+=$l->plan;
    $t_pclosed+=$l->pclosed;
    $t_popen+=$l->popen;
    $t_pvk+=$l->pvk;
    $t_pgen+=$l->pgen;
    $t_psk+=$l->psk;
}

/* ++ FOOTER ++ */
    ui_rep_row();
    ui_rep_th('Всего:');
    ui_rep_th($t_plan);
    ui_rep_th($t_pall);
    ui_rep_th($t_pclosed);
    ui_rep_th($t_popen);
    ui_rep_th($t_pvk);
    ui_rep_th($t_psk);
    ui_rep_th($t_pgen);
    ui_rep_th('');
    ui_rep_th('');
    ui_rep_th('');
    ui_rep_th('');
    ui_end_row();
/* ++ FOOTER ++ */

ui_efs();


ui_ep();

