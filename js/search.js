
// NOVICE
$('#state_id option[value=4]').hide();
$('#dropnovice').change(function(){
    var i=$('#dropnovice').is(":checked");
    console.log(i);
    if(i)
    {
       $('#state_id option[value=4]').hide();
    }
    else
    {
       $('#state_id option[value=4]').show();         
    }
});

// INVALID
$('#state_id option[value=3]').hide();
$('#dropinvalid').change(function(){
    var i=$('#dropinvalid').is(":checked");
    console.log(i);
    if(i)
    {
       $('#state_id option[value=3]').hide();
    }
    else
    {
       $('#state_id option[value=3]').show();         
    }
});

$('#frm').submit(function(){
    var ret = true;
    if(typeof(sessionStorage) == 'undefined' ) { return true;}   
    sessionStorage.clear();
    $('#frm input[type="text"]').each(function(k,v){
         sessionStorage.setItem(v.id,v.value);
        });
    $('#frm select').each(function(k,v){
         sessionStorage.setItem(v.id,v.value);
        });
    $('#frm input[type="checkbox"]').each(function(k,v){
         sessionStorage.setItem(v.id,v.checked);
        }); 
      return true;  
});