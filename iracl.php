<?php
session_start();
include 'config.php';
include 'core/db.php';
include 'core/core.php';
include 'core/ui.php';

include 'form/person.column.php';

define('PAGE_SEC', 'control.iracl');
cr_logic();

$id=(isset($_GET['id']))?$_GET['id']:0;
settype($id,'integer');
if($id<0)
{
    ui_redirect('create.php');
}


if(!empty($_POST))
{
    if($id)
    {
        
    }
    else
    {
        $reg=$_POST['reg'];
        $res=db_field_values($reg);
        $sql="INSERT INTO `db_ir_relation` (${res[0]}) VALUES (${res[1]})";
        $r=mysql_query($sql) or debug($sql,  mysql_error());
    }
    ui_redirect("iracl.php");
}



$options=array();
$options['institution_id']=db_kv('db_institution', 'id_institution', 'name');
$options['inst_rank_id']=db_kv('db_inst_rank', 'id_inst_rank', 'name');



if($id)
    $p=db_single_record('db_ir_relation', 'id_ir_relation',$id );
else
    $p=db_default_record ('db_ir_relation');

ui_sp('Сопостовление УО');

$sql="SELECT * FROM `db_ir_relation";
$r=mysql_query($sql) or debug($sql,  mysql_error());
ui_sfs('','w100');
ui_rep_row();
    ui_rep_th('#');
    ui_rep_th($pcolumns['inst_rank_id']);
    ui_rep_th($pcolumns['institution_id']);
    ui_end_row();

while($l=mysql_fetch_object($r))
{
    ui_rep_row();
    ui_rep_th('#');
    ui_rep_td(ui_sap($options['inst_rank_id'],$l->inst_rank_id));
    ui_rep_td(ui_sap($options['institution_id'],$l->institution_id));
    ui_rep_td('<a href="api.php?m=iracl.del&amp;i='.$l->id_ir_relation.'">x</a>');
    ui_end_row();
}
ui_efs();


ui_sf();
    ui_sfs();
    ui_select('reg', 'inst_rank_id', 'Ранг УО', $options['inst_rank_id'], $p['inst_rank_id']);
    ui_select('reg', 'institution_id', 'Тип УО', $options['institution_id'], $p['institution_id']);
    
    ui_efs();
ui_ef();

ui_ep();