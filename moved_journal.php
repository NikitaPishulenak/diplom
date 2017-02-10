<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

define('PAGE_SEC','index');
cr_logic();

$user_by_id=db_kv('db_users','id','realname');
ui_sp('Журнал переводов');
$sql="SELECT * FROM `db_move_journal`";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs('','w100');
    ui_rep_row();
    ui_rep_th('#');
    ui_rep_th('prev');
    ui_rep_th('next');
    ui_rep_th('who');
    ui_rep_th('when');
    ui_end_row();

while($l=  mysql_fetch_object($r))
{
    $mover=$user_by_id[$l->mover_id];
    ui_rep_row();
    ui_rep_th($l->id_move_journal);
    ui_rep_td($l->prev_person_id);
    ui_rep_td($l->next_person_id);
    ui_rep_td($mover);
    ui_rep_td($l->ts);
    ui_end_row();
}
ui_efs();
ui_ep();
