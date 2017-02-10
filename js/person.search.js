
function defparm()
{
    
}

function cut_use()
{
    var cutt=window.open('cut.php', 'Cut', 'height=200,width=200');
}

function calc_use()
{
    var cutt=window.open('calc.php', 'Calc', 'height=200,width=200');
}

function sort_use(id,v)
{
    $('#'+id).val(v);
}


$(document).ready(defparm);

function form_reset()
{
    document.getElementById('frm').reset();
    $("#frm .sfh").each(function(k,v){
               $(v).removeClass('sfh');
    });
    
}

function form_last()
{
    var ret = false;
    if(typeof(sessionStorage) == 'undefined' ) {
        return;
    }
    $('#frm input[type="text"]').each(function(k,v){
	if(document.getElementById(v.id) !== null ){
        document.getElementById(v.id).value=sessionStorage.getItem(v.id);
		$(v).change();
	}
    });
    $('#frm select').each(function(k,v){
	if(document.getElementById(v.id) !== null ){
            document.getElementById(v.id).value=sessionStorage.getItem(v.id);
        $(v).change();
	}
    });
    $('#frm input[type="checkbox"]').each(function(k,v){
	if(document.getElementById(v.id) !== null ){
        var exm=(sessionStorage.getItem(v.id)==='true');
        document.getElementById(v.id).checked=exm;
	}
    });
    return ;
}

$(document).ready(function(){
$('select').click(function(event){
    if(event.ctrlKey) 
        {
            var sid=this.id;
            if($('#'+sid+' option[value=0]').length)
            {
                $('#'+sid+' option[value=0]').text('пусто');
                $('#'+sid+' option[value=0]').val('пусто');
            }
            else
            {
                $('#'+sid+' option[value=пусто]').text('Не выбрано');
	        $('#'+sid+' option[value=пусто]').val(0);
            }
	}
});});