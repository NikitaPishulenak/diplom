function eduFormChange()
{
    var fc=document.getElementById('faculty').value;
    var tf=document.getElementById('time_form_id').value;
    var ef=document.getElementById('edu_form').value;
    
    $('#target option').attr('disabled','disabled');;
    $('#target_type option').attr('disabled','disabled');;
    $('#target_cell option').attr('disabled','disabled');;
    $('#region_cell option').attr('disabled','disabled');;
    for(i in tacl)
    {
        if(
            
            tacl[i][0] == fc &&
            tacl[i][1] == tf &&    
            tacl[i][2] == ef /*&&
            tacl[i][3] == t_ &&
            tacl[i][4] == tt &&
            tacl[i][5] == tc &&
            tacl[i][6] == rc */
            )
            {
                
            //$('#edu_form option[value='+tacl[i][2]+']').removeAttr('disabled');;
            $('#target option[value='+tacl[i][3]+']').removeAttr('disabled');;
            $('#target_type option[value='+tacl[i][4]+']').removeAttr('disabled');;
            $('#target_cell option[value='+tacl[i][5]+']').removeAttr('disabled');;
            $('#region_cell option[value='+tacl[i][6]+']').removeAttr('disabled');;
        }
    }
    
    $('#target option:not(:disabled):first').attr('selected','selected');
    $('#target_type option:not(:disabled):first').attr('selected','selected');
    $('#target_cell option:not(:disabled):first').attr('selected','selected');
    $('#region_cell option:not(:disabled):first').attr('selected','selected');
    
    targetChange();
}
function targetChange()
{
    var fc=document.getElementById('faculty').value;
    var tf=document.getElementById('time_form_id').value;
    var ef=document.getElementById('edu_form').value;
    var t_=document.getElementById('target').value;
   
    $('#target_type option').attr('disabled','disabled');;
    $('#target_cell option').attr('disabled','disabled');;
    $('#region_cell option').attr('disabled','disabled');;
    for(i in tacl)
    {
        if(
            
            tacl[i][0] == fc &&
            tacl[i][1] == tf &&    
            tacl[i][2] == ef &&
            tacl[i][3] == t_ /*&&
            tacl[i][4] == tt &&
            tacl[i][5] == tc &&
            tacl[i][6] == rc */
            )
            {
                
            //$('#edu_form option[value='+tacl[i][2]+']').removeAttr('disabled');;
            //$('#target option[value='+tacl[i][3]+']').removeAttr('disabled');;
            $('#target_type option[value='+tacl[i][4]+']').removeAttr('disabled');;
            $('#target_cell option[value='+tacl[i][5]+']').removeAttr('disabled');;
            $('#region_cell option[value='+tacl[i][6]+']').removeAttr('disabled');;
        }
    }
    $('#target_type option:not(:disabled):first').attr('selected','selected');
    $('#target_cell option:not(:disabled):first').attr('selected','selected');
    $('#region_cell option:not(:disabled):first').attr('selected','selected');
    
    
    targetTypeChange();
}
function targetTypeChange()
{
    var fc=document.getElementById('faculty').value;
    var tf=document.getElementById('time_form_id').value;
    var ef=document.getElementById('edu_form').value;
    var t_=document.getElementById('target').value;
    var tt=document.getElementById('target_type').value;
    //var tc=document.getElementById('target_cell').value;
    //var rc=document.getElementById('region_cell').value;
    //$('#edu_form option').attr('disabled','disabled');;
    //$('#target option').attr('disabled','disabled');;
    //$('#target_type option').attr('disabled','disabled');;
    $('#target_cell option').attr('disabled','disabled');;
    $('#region_cell option').attr('disabled','disabled');;
    for(i in tacl)
    {
        if(
            
            tacl[i][0] == fc &&
            tacl[i][1] == tf &&    
            tacl[i][2] == ef &&
            tacl[i][3] == t_ &&
            tacl[i][4] == tt /*&&
            tacl[i][5] == tc &&
            tacl[i][6] == rc */
            )
            {
                
            //$('#edu_form option[value='+tacl[i][2]+']').removeAttr('disabled');;
            //$('#target option[value='+tacl[i][3]+']').removeAttr('disabled');;
            //$('#target_type option[value='+tacl[i][4]+']').removeAttr('disabled');;
            $('#target_cell option[value='+tacl[i][5]+']').removeAttr('disabled');;
            $('#region_cell option[value='+tacl[i][6]+']').removeAttr('disabled');;
        }
    }
    $('#target_cell option:not(:disabled):first').attr('selected','selected');
    $('#region_cell option:not(:disabled):first').attr('selected','selected');
    
    targetCellChange();
}
function targetCellChange()
{
    var fc=document.getElementById('faculty').value;
    var tf=document.getElementById('time_form_id').value;
    var ef=document.getElementById('edu_form').value;
    var t_=document.getElementById('target').value;
    var tt=document.getElementById('target_type').value;
    var tc=document.getElementById('target_cell').value;
    //var rc=document.getElementById('region_cell').value;
    //$('#edu_form option').attr('disabled','disabled');;
    //$('#target option').attr('disabled','disabled');;
    //$('#target_type option').attr('disabled','disabled');;
    //$('#target_cell option').attr('disabled','disabled');;
    $('#region_cell option').attr('disabled','disabled');;
    for(i in tacl)
    {
        if(
            
            tacl[i][0] == fc &&
            tacl[i][1] == tf &&    
            tacl[i][2] == ef &&
            tacl[i][3] == t_ &&
            tacl[i][4] == tt &&
            tacl[i][5] == tc /*&&
            tacl[i][6] == rc */
            )
            {
                
            //$('#edu_form option[value='+tacl[i][2]+']').removeAttr('disabled');;
            //$('#target option[value='+tacl[i][3]+']').removeAttr('disabled');;
            //$('#target_type option[value='+tacl[i][4]+']').removeAttr('disabled');;
            //$('#target_cell option[value='+tacl[i][5]+']').removeAttr('disabled');;
            $('#region_cell option[value='+tacl[i][6]+']').removeAttr('disabled');;
        }
    }
    //$('#target_cell option:not(:disabled):first').attr('selected','selected');
    $('#region_cell option:not(:disabled):first').attr('selected','selected');
    
    
}

$('#edu_form').change(eduFormChange);
$('#target').change(targetChange);
$('#target_type').change(targetTypeChange);
$('#target_cell').change(targetCellChange);