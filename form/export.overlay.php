<?php


$options['student_id']=db_bits2arr('db_student', 'id_student', 'name');
$options['xclass_id']=db_bits2arr('db_xclass','id_xclass','name');
$options['wouldbe_id']=db_bits2arr('db_wouldbe', 'id_wouldbe', 'name');
$options['out_time_form_id']=$options['time_form_id'];
$options['out_edu_form']=$options['edu_form'];
$options['out_target']=$options['target'];
$options['out_target_type']=$options['target_type'];
$options['out_target_cell']=$options['target_cell'];
$options['out_region_cell']=$options['region_cell'];
$options['community_set']=db_bits2arr('db_community', 'id_community', 'abbr');
$options['other_set']=db_bits2arr('db_other', 'id_other', 'abbr');
$options['cur_lang_id']=$options['language_id'];
$options['education_id']=db_bits2arr('db_education','id_education','abbr');