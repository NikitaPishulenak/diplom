<?php

session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';
include 'core/libreport.php';



define('PAGE_SEC', 'report.ball');
cr_logic();

die('bye');
$fc_arr = db_kv('db_faculty', 'id', 'name');
$tf_arr = db_kv('db_time_form', 'id_time_form', 'name');
$ef_arr = db_kv('db_ef', 'id_ef', 'name');
$cr_arr = db_kv('db_region', 'id_region', 'abbr');
$tc_arr = db_kv('db_targetcell', 'id_targetcell', 'abbr');
$tt_arr = db_kv('db_targettype', 'id_targettype', 'abbr');

$cell_rows = array();
$cell_plan = array();
$cell_live = array();
$cell_diff = array();
$cell_ball = array();
$cell_mest = array();
$cell_xout = array();
$pgv__live = array();
$pgc__live = array();
$mo___mest = array();
$bi___mest = array();
$prop_mest = array();
$cell_tout = array();
$cell_warn = array();
$cout_summ = array();

foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        foreach ($cr_arr as $kkk => $vvv) {
            $cell_plan[$k][$kk][$kkk] = 0;
            $cell_live[$k][$kk][$kkk] = 0;
            $cell_diff[$k][$kk][$kkk] = 0;
            $cell_ball[$k][$kk][$kkk] = 0;
            $cell_xout[$k][$kk][$kkk] = array();
            $cell_tout[$k][$kk][$kkk] = array();
        }
        $cell_rows[$k][$kk] = false;
    }
    $cell_mest[$k] = 0;
    $mo___mest[$k] = 0;
    $bi___mest[$k] = 0;
    $prop_mest[$k] = 0;
    $pgv__mest[$k] = 0;
    $pgc__mest[$k] = 0;
    $cell_warn[$k] = false;
    $cout_summ[$k] = 0;
}
ui_sp("Проходной балл (бюджет)");

$dt = date('H:i');
$dd = date('d.m.Y');

$cut = isset($_GET['cut']) ? $_GET['cut'] : '';
$cut=db_esc($cut);
$wct = ($cut)? " `id` in (SELECT `person_id` FROM `db_target_history` WHERE (`vtime`<'$cut' AND (`xtime`>'$cut' OR `xtime`=0))) AND `state_id`<>0 ":"`state_id`='1'";
$last = isset($_GET['last']) ? (int) 1 : 0;

    

    ui_gf();
    ui_stfs();
    
    ui_sfs();
    /*
    ui_text('','cut','Срез',$cut,'');
     * 
     */
    ui_check('', 'last', 'Использовать текущий конкурс дел(откр/закр). Снятая галка выбирает всех, кто помечен 25 числом. ', $last);
    
    ui_submit('', '', '', 'Показать', '');
    ui_efs();
    
    ui_etfs();
    ui_ef0();
    
if($cut)
    ui_par("Данные на срез $cut ");
else
    ui_par("Данные на  $dt $dd ");

/** @link  ++ ROUND 1 ++ * */
$sql = "SELECT * FROM `db_plancell`";
$r = mysql_query($sql) or debug($sql, mysql_error());
while ($l = mysql_fetch_object($r)) {
    $cell_plan[$l->faculty_id][$l->targetcell_id][$l->region_id] = $l->plan;
}
ui_sfs('План целевого набора', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!array_sum($cell_plan[$k][$kk]))
            continue; else
            $cell_rows[$k][$kk] = true;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);
        $s = 0;
        foreach ($cr_arr as $kkk => $vvv) {
            ui_rep_td($cell_plan[$k][$kk][$kkk]);
            $s+=$cell_plan[$k][$kk][$kkk];
        }
        ui_rep_th($s);
        ui_end_row();
    }
}
ui_efs();

$sql = "TRUNCATE table `db_ball_temp`";
$r = mysql_query($sql) or debug($sql, mysql_error());

/*
if ($last or empty($cut)){
    $sql = "INSERT INTO `db_ball_temp` (`faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`person_id`) SELECT `faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`id` from db_person WHERE $wct";
}
else
{
    $sql = "INSERT INTO `db_ball_temp` (`faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`person_id`) SELECT `faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,(select `delo_name` from db_person where `id`=`person_id`) dn,`person_id` from db_target_history where (`vtime`<'$cut' AND (`xtime`>'$cut' OR `xtime`=0) AND (SELECT 1 from db_person where id=person_id AND state_id=1))";
}
*/
if($last)
    $wct="`state_id`=1";    
else
    $wct="`target_use_id`=1";
$sql = "INSERT INTO `db_ball_temp` (`faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`person_id`) SELECT `faculty`,`time_form_id`,`edu_form`,`target`,`target_type`,`target_cell`,`region_cell`,`total`,`delo_name`,`id` from db_person WHERE $wct";
$r = mysql_query($sql) or debug($sql, mysql_error());

$sql= "update db_person set out_time_form_id=0,out_edu_form=0,out_target=0,out_target_type=0,out_target_cell=0,out_region_cell=0,student_id=0 WHERE edu_form=1 and time_form_id=1";
$r = mysql_query($sql) or debug($sql, mysql_error());



/** @link  ++ ROUND 2 ++ * */
$sql = "SELECT `faculty`,`target_cell`,`region_cell` from `db_ball_temp` WHERE  `time_form_id`=1 AND `edu_form`=1  AND `target`=1";
$r = mysql_query($sql) or debug($sql, mysql_error());
while ($l = mysql_fetch_object($r))
    $cell_live[$l->faculty][$l->target_cell][$l->region_cell]++;

ui_sfs('Количество поданных целевых', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!$cell_rows[$k][$kk])
            continue;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);
        $s = 0;
        foreach ($cr_arr as $kkk => $vvv) {
            if($cell_plan[$k][$kk][$kkk]==0)
    	    {
    		ui_rep_td('-');
    	    }
    	    else
    	    {
        	ui_rep_td($cell_live[$k][$kk][$kkk]);
    	    }
            $s+=$cell_live[$k][$kk][$kkk];
        }
        ui_rep_th($s);
        ui_end_row();
    }
}
ui_efs();

/** @link ++ ROUND 3 ++ * */
foreach ($fc_arr as $k => $v)
    foreach ($tc_arr as $kk => $vv)
        foreach ($cr_arr as $kkk => $vvv)
            $cell_diff[$k][$kk][$kkk] = $cell_plan[$k][$kk][$kkk] - $cell_live[$k][$kk][$kkk];

ui_sfs('Нехватка целевых договоров', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!$cell_rows[$k][$kk])
            continue;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);
        $s = 0;
        foreach ($cr_arr as $kkk => $vvv) {
            $t=($cell_diff[$k][$kk][$kkk]<0)?'K+'.abs($cell_diff[$k][$kk][$kkk]):$cell_diff[$k][$kk][$kkk];
            //ui_rep_td($cell_diff[$k][$kk][$kkk]);
            $t=($cell_diff[$k][$kk][$kkk]==0)?'К':$t;;
            //ui_rep_td($cell_diff[$k][$kk][$kkk]);
            if($cell_plan[$k][$kk][$kkk]==0)
    	    {
    		ui_rep_td('-');
    	    }
    	    else
    	    {
        	ui_rep_td($t);
            }
            $s+=($cell_diff[$k][$kk][$kkk]>0)?$cell_diff[$k][$kk][$kkk]:0;
            $cell_mest[$k]+=($cell_diff[$k][$kk][$kkk] < 0) ? $cell_plan[$k][$kk][$kkk] : $cell_live[$k][$kk][$kkk];
        }
        ui_rep_th($s);
        ui_end_row();
    }
}
ui_efs();

/** @link ++ ROUND 4 ++ */
ui_sfs('Проходной балл целевого приёма', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!$cell_rows[$k][$kk])
            continue;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);
        $s = 0;
        foreach ($cr_arr as $kkk => $vvv) {
            $x = $cell_diff[$k][$kk][$kkk];
            $p = $cell_plan[$k][$kk][$kkk];
            if ($p == 0) {
                ui_rep_td('-');
                $cell_ball[$k][$kk][$kkk] = 0;
            } else {
                $i_c = 0;
                $sql = "SELECT `delo_name`,`target_type`,`id_ball_temp`,`total`,`target_cell`,`region_cell`,`person_id` FROM `db_ball_temp` WHERE `faculty`='$k' AND `time_form_id`=1 AND `edu_form`=1 AND `target`=1 AND `target_cell`='$kk' AND `region_cell`='$kkk' ORDER BY `total` DESC";
                $r = mysql_query($sql) or debug($sql, mysql_error());
                while ($l = mysql_fetch_object($r)) {
                    $i_c++;

                    if ($i_c > $p) {
                        $cell_xout[$k][$kk][$kkk][] = $l->id_ball_temp;
                        $cell_tout[$k][$kk][$kkk][] = $l->delo_name . ' ' . $tt_arr[$l->target_type] . ' ' . $l->total;
                        if ($cell_ball[$k][$kk][$kkk] == $l->total) {
                            $cell_warn[$k] = true;
                        }
                    } else {
                        $cell_ball[$k][$kk][$kkk] = $l->total;
                        $sql= "update db_person set out_time_form_id=1,out_edu_form=1,out_target=1,out_target_type=$l->target_type,out_target_cell=$l->target_cell,out_region_cell=$l->region_cell,student_id=1 WHERE id=$l->person_id";
			$rx = mysql_query($sql) or debug($sql, mysql_error());

                    }
                }
                ui_rep_td($cell_ball[$k][$kk][$kkk]);
            }
//            } else if ($x == 0 || $x > 0) {
//                $sql = "SELECT `total` FROM `db_ball_temp` WHERE `faculty`='$k' AND `target_cell`='$kk' AND `region_cell`='$kkk' ORDER BY `total` ASC LIMIT 1;";
//                $r = mysql_query($sql) or debug($sql, mysql_error());
//                $l = mysql_fetch_object($r);
//                if (isset($l->total)) {
//                    ui_rep_td($l->total);
//                    $cell_ball[$k][$kk][$kkk] = $l->total;
//                } else {
//                    ui_rep_td('нет');
//                    $cell_ball[$k][$kk][$kkk] = 0;
//                }
//            } else if ($x < 0) {
//                $dx = $p - $x;
//
//                $sql = "SELECT `total` FROM `db_ball_temp` WHERE `faculty`='$k' AND `target_cell`='$kk' AND `region_cell`='$kkk' ORDER BY `total` ASC LIMIT $dx,1;";
//                $r = mysql_query($sql) or debug($sql, mysql_error());
//                $l = mysql_fetch_object($r);
//                if (isset($l->total)) {
//                    ui_rep_td($l->total);
//                    $cell_ball[$k][$kk][$kkk] = $l->total;
//                } else {
//                    ui_rep_td('нет');
//                    $cell_ball[$k][$kk][$kkk] = 0;
//                }
//            }
        }
        ui_rep_th($s);
        ui_end_row();
    }
}
ui_efs();
/** @link ++ ROUND 5 ++ */
ui_sfs('Вылетевшие из целевого приёма', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('ТЦ');
foreach ($cr_arr as $kkk => $vvv) {
    ui_rep_th($vvv);
}
ui_rep_th('Всего');
ui_end_row();
foreach ($fc_arr as $k => $v) {
    
    foreach ($tc_arr as $kk => $vv) {
        if (!$cell_rows[$k][$kk])
            continue;
        $s = 0;
        ui_rep_row();
        ui_rep_th($fc_arr[$k]);
        ui_rep_th($tc_arr[$kk]);

        foreach ($cr_arr as $kkk => $vvv) {
            ui_rep_td_l(implode('<br />', $cell_tout[$k][$kk][$kkk]));
            $s+=count($cell_tout[$k][$kk][$kkk]);
        }
        ui_rep_th($s);
        ui_end_row();
    }
}


ui_efs();

/** @link ++ ROUND 6 ++ */
ui_stfs();
ui_sfs('Расчёт заявлений', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('Всего');
ui_rep_th('', '', count($fc_arr) + 1);
ui_rep_th('Целевой');
ui_rep_th('МО');
ui_rep_th('БИ');
ui_rep_th('Общий');
ui_rep_th('Город');
ui_rep_th('Село');
ui_end_row();
$sql = <<<EOF
   SELECT 
       faculty,
       COUNT(`id_ball_temp`) as pall,
       COUNT(IF(`target`=1,`total`,null)) as pcell,
       COUNT(IF(`target`=5,`total`,null)) as pmo,
       COUNT(IF(`target`=2,`total`,null)) as pbi,
       COUNT(IF(`target`=3,`total`,null)) as pgen,
       COUNT(IF(`target`=3 AND `target_type`=1,`total`,null)) as pgc,
       COUNT(IF(`target`=3 AND `target_type`=2,`total`,null)) as pgv
       FROM `db_ball_temp` WHERE  `time_form_id`=1 AND `edu_form`=1 GROUP BY faculty;
EOF;
$r = mysql_query($sql) or debug($sql, mysql_error());

foreach ($fc_arr as $k => $v) {
    foreach ($tc_arr as $kk => $vv) {
        if (!$cell_rows[$k][$kk])
            continue;
        foreach ($cr_arr as $kkk => $vvv) {
            if (!empty($cell_xout[$k][$kk][$kkk])) {
                $sql = "UPDATE `db_ball_temp` SET  `target`=3  WHERE `id_ball_temp` in (" . implode(',', $cell_xout[$k][$kk][$kkk]) . ")";
                $rr = mysql_query($sql) or debug($sql, mysql_error());
            }
        }
    }
}

while ($l = mysql_fetch_object($r)) {
    ui_rep_row();
    ui_rep_th($fc_arr[$l->faculty]);
    ui_rep_td($l->pall);
    ui_rep_td($l->pcell);
    ui_rep_td($l->pmo);
    ui_rep_td($l->pbi);
    ui_rep_td($l->pgen);
    ui_rep_td($l->pgc);
    ui_rep_td($l->pgv);
    ui_end_row();
}
ui_efs();
ui_sptfs();
ui_sfs('Корректировка');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('Всего');
ui_rep_th('', '', count($fc_arr) + 1);
ui_rep_th('Целевой');
ui_rep_th('МО');
ui_rep_th('БИ');
ui_rep_th('Общий');
ui_rep_th('Город');
ui_rep_th('Село');
ui_end_row();
$sql = <<<EOF
   SELECT 
       faculty,
       COUNT(`id_ball_temp`) as pall,
       COUNT(IF(`target`=1,`total`,null)) as pcell,
       COUNT(IF(`target`=5,`total`,null)) as pmo,
       COUNT(IF(`target`=2,`total`,null)) as pbi,
       COUNT(IF(`target`=3,`total`,null)) as pgen,
       COUNT(IF(`target`=3 AND `target_type`=1,`total`,null)) as pgc,
       COUNT(IF(`target`=3 AND `target_type`=2,`total`,null)) as pgv
       FROM `db_ball_temp` WHERE  `time_form_id`=1 AND `edu_form`=1 GROUP BY faculty;
EOF;
$r = mysql_query($sql) or debug($sql, mysql_error());


while ($l = mysql_fetch_object($r)) {
    ui_rep_row();
    ui_rep_th($fc_arr[$l->faculty]);
    ui_rep_td($l->pall);
    ui_rep_td($l->pcell);
    ui_rep_td($l->pmo);
    ui_rep_td($l->pbi);
    ui_rep_td($l->pgen);
    ui_rep_td($l->pgc);
    ui_rep_td($l->pgv);
    ui_end_row();
    $pgv__live[$l->faculty] = $l->pgv;
    $pgc__live[$l->faculty] = $l->pgc;
    $mo___mest[$l->faculty] = $l->pmo;
    $bi___mest[$l->faculty] = $l->pbi;
    if ($l->pgen)
        $prop_mest[$l->faculty] = $l->pgv * 100 / $l->pgen;
    else
        $prop_mest[$l->faculty] = 0.5;
}
ui_efs();
ui_etfs();

/** @link ++ ROUND 7 ++ */
ui_sfs('Расчёт мест / Балл', 'w100');
ui_rep_row();
ui_rep_th('Факультет');
ui_rep_th('План приёма');
ui_rep_th('План Целевых');
ui_rep_th('', '', count($fc_arr) + 1);
ui_rep_th('Целевых');
ui_rep_th('МО');
ui_rep_th('БИ');
ui_rep_th('', '', count($fc_arr) + 1);
ui_rep_th('Общий');
ui_rep_th('Город');
ui_rep_th('Село');
ui_rep_th('Город');
ui_rep_th('Село');
ui_rep_th('Fail');
ui_end_row();
$sql = <<<EOF
    SELECT
        faculty,
        (SELECT sum(db_planform.total)  FROM db_planform  WHERE (db_planform.faculty_id=db_ball_temp.faculty AND `time_form_id`=1 AND `edu_form_id`=1)) as  planform,
        (SELECT sum(db_plancell.plan)  FROM db_plancell  WHERE (db_plancell.faculty_id=db_ball_temp.faculty)) as  plancell
        
        FROM `db_ball_temp` group by faculty
EOF;
$r = mysql_query($sql) or debug($sql, mysql_error());
while ($l = mysql_fetch_object($r)) {
    ui_rep_row();
    $cw = ($cell_warn[$l->faculty]) ? 'cell_warn' : '';
    ui_rep_th($fc_arr[$l->faculty], '', '', $cw);
    ui_rep_td($l->planform);
    ui_rep_td($l->plancell);

    ui_rep_td($cell_mest[$l->faculty]);
    ui_rep_td($mo___mest[$l->faculty]);
    ui_rep_td($bi___mest[$l->faculty]);

    $gen_mest = $l->planform - $cell_mest[$l->faculty] - $mo___mest[$l->faculty] - $bi___mest[$l->faculty];

    ui_rep_td($gen_mest);
    if ($gen_mest < 1)
        continue;
    $v_mest = round($gen_mest * $prop_mest[$l->faculty] / 100);
    $c_mest = $gen_mest - $v_mest;

    ui_rep_td($c_mest);
    ui_rep_td($v_mest);



    /* ГОРОД */

    $k = $l->faculty;
    $sql = "SELECT `total`,`person_id`,`target_type`,`target_cell`,`region_cell` FROM `db_ball_temp` WHERE `faculty`='$k' AND `time_form_id`=1 AND `edu_form`=1 AND `target`=3 AND `target_type`=1 ORDER BY `total` DESC";
    $rr = mysql_query($sql) or debug($sql, mysql_error());
    $i_c = 0;
    $c_ball = 0;
    $cp_ball = '';
    $p_c = 0;
    $m_c = 0;
    $t1_ball = 0;
    $t2_ball = 0;
    while ($ll = mysql_fetch_object($rr)) {
        $i_c++;
        if ($i_c > $c_mest) {
            if ($c_ball == $ll->total) {
                $cp_ball = "($ll->total)";
                $p_c++;
                $c_view = "$t2_ball $cp_ball:$p_c/$m_c";
            }
        } else {
            $c_ball = $ll->total;
            $t2_ball=($t1_ball==$c_ball)?$t2_ball:$t1_ball;
            $p_c = ($t1_ball==$c_ball) ?$p_c+1:1;
            $m_c = ($t1_ball==$c_ball) ?$m_c+1:1;
            $t1_ball=$c_ball;
            $c_view = "$c_ball";
            $sql= "update db_person set out_time_form_id=1,out_edu_form=1,out_target=3,out_target_type=$ll->target_type,out_target_cell=$ll->target_cell,out_region_cell=$ll->region_cell,student_id=1 WHERE id=$ll->person_id";
	    $rx = mysql_query($sql) or debug($sql, mysql_error());

        }
    }

    /* СЕЛО */
    $sql = "SELECT `total`,`person_id`,`target_type`,`target_cell`,`region_cell` FROM `db_ball_temp` WHERE `faculty`='$k' AND `time_form_id`=1 AND `edu_form`=1 AND `target`=3 AND `target_type`=2 ORDER BY `total` DESC";
    $rr = mysql_query($sql) or debug($sql, mysql_error());
    $i_c = 0;
    $v_ball = 0;
    $vp_ball = '';
    $p_c = 0;
    $m_c = 0;
    $t1_ball = 0;
    $t2_ball = 0;
    while ($ll = mysql_fetch_object($rr)) {
        $i_c++;
        if ($i_c > $v_mest) {
            if ($v_ball == $ll->total) {
                $vp_ball = "($ll->total)";
                $p_c++;
                $v_view = "$t2_ball $vp_ball:$p_c/$m_c";
            }
        } else {
            $v_ball = $ll->total;
            $t2_ball=($t1_ball==$v_ball)?$t2_ball:$t1_ball;
            $p_c = ($t1_ball==$v_ball) ?$p_c+1:1;
            $m_c = ($t1_ball==$v_ball) ?$m_c+1:1;
            $t1_ball=$v_ball;
            $v_view = "$v_ball";
            $sql= "update db_person set out_time_form_id=1,out_edu_form=1,out_target=3,out_target_type=$ll->target_type,out_target_cell=$ll->target_cell,out_region_cell=$ll->region_cell,student_id=1 WHERE id=$ll->person_id";
	    $rx = mysql_query($sql) or debug($sql, mysql_error());

        }
    }
    
    
    /* FAIL */
    $sql = "SELECT `total` FROM `db_ball_temp` WHERE `faculty`='$k' AND `time_form_id`=1 AND `edu_form`=1 AND `target`=3 ORDER BY `total` DESC";
    $rr = mysql_query($sql) or debug($sql, mysql_error());
    $i_c = 0;
    $f_ball = 0;
    $fp_ball = '';
    $p_c = 0;
    $m_c = 0;
    $t1_ball = 0;
    $t2_ball = 0;
    while ($ll = mysql_fetch_object($rr)) {
        $i_c++;
        if ($i_c > $gen_mest) {
            if ($f_ball == $ll->total) {
                $fp_ball = "($ll->total)";
                $p_c++;
                $f_view = "$t2_ball $fp_ball:$p_c/$m_c";
            }
        } else {
            
            $f_ball = $ll->total;
            $t2_ball=($t1_ball==$f_ball)?$t2_ball:$t1_ball;
            $p_c = ($t1_ball==$f_ball) ?$p_c+1:1;
            $m_c = ($t1_ball==$f_ball) ?$m_c+1:1;
            $t1_ball=$f_ball;
            $f_view = "$f_ball";
            
        }
    }
    ui_rep_td($c_view);
    ui_rep_td($v_view);
    ui_rep_th($f_view);
    ui_end_row();
    
    

    /* БИ МО */
    $sql = "SELECT `total`,`person_id`,`target_type`,`target_cell`,`region_cell`,`target` FROM `db_ball_temp` WHERE `faculty`='$k' AND `time_form_id`=1 AND `edu_form`=1 AND `target` in (2,5) ORDER BY `total` DESC";
    $rr = mysql_query($sql) or debug($sql, mysql_error());
    while($ll= mysql_fetch_object($rr))
    {

            $sql= "update db_person set out_time_form_id=1,out_edu_form=1,out_target=$ll->target,out_target_type=$ll->target_type,out_target_cell=$ll->target_cell,out_region_cell=$ll->region_cell,student_id=1 WHERE id=$ll->person_id";
	    $rx = mysql_query($sql) or debug($sql, mysql_error());
    }
}
ui_efs();

ui_ep();

