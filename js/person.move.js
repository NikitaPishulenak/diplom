function facultyChange()
{
    var fc=document.getElementById('faculty_id').value;
    if(fc>0)
    {
        
        $('#time_form_id option').attr('disabled','disabled');;
        
    }
    else
    {
               
        $('#time_form_id option').removeAttr('disabled');
           
    }
    
    for(i in tacl)
    {
        if(
            tacl[i][0] == fc
            )
            {
            $('#time_form_id option[value='+tacl[i][1]+']').removeAttr('disabled','');
            
        }
    }
    $('#time_form_id option:not(:disabled):first').attr('selected','selected');
    
    
 
}

$('#faculty_id').change(facultyChange);

