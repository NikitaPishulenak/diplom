/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function()
{
    
    });

$('#frm').submit(function()
{
    var ret=true;
    var rqt=Array('surname','name','serial','city_name','zip','institution_name','inst_city_name','certificate_name','certificate_sum','lct_sum','lct_sn','lct_xn','bct_sum','bct_sn','bct_xn','cct_sum','cct_sn','cct_xn','institution_name_full');
    var rqs=Array('faculty','time_form_id','edu_form','target','sex','country','subdiv','institution_id','inst_city_type','certificate_id','natio','inst_rank_id','hostel_id','experience_id','try_id');
    var rqd=Array('birthday','cert_date');
    
    var fc=document.getElementById('faculty').value;
    var tf=document.getElementById('time_form_id').value;
    var ef=document.getElementById('edu_form').value;
    var t_=document.getElementById('target').value;
    var tt=document.getElementById('target_type').value;
    var tc=document.getElementById('target_cell').value;
    var rc=document.getElementById('region_cell').value;
    
    ret=false;
    for(i in tacl)
    {
        if(
            tacl[i][0] == fc &&
            tacl[i][1] == tf &&    
            tacl[i][2] == ef &&
            tacl[i][3] == t_ &&
            tacl[i][4] == tt &&
            tacl[i][5] == tc &&
            tacl[i][6] == rc 
            )
            {
            ret=true;
            break;
        }
    }
    if(!ret)
        alert('Плохой конкурс!');
    
    
    
    
    
    for(i in rqt)
    {
        var obj=$('#'+rqt[i]);
        if(obj.val()=="" && !obj.is(':hidden'))
        {
            obj.parent().addClass('hil');
            ret=ret && false;
        //console.log(rqt[i]);
        }
        else
        {
            obj.parent().removeClass('hil');
        }
                
    }
    for(i in rqs)
    {
        var obj=$('#'+rqs[i]);
        if(obj.val()=="0" && !obj.is(':hidden'))
        {
            obj.parent().addClass('hil');
            ret=ret && false;
        //console.log(rqs[i]);
        }
        else
        {
            obj.parent().removeClass('hil');
        }
                
    }
    for(i in rqd)
    {
        var obj_d=$('#'+rqd[i]+"_d");
        var obj_m=$('#'+rqd[i]+"_m");
        var obj_y=$('#'+rqd[i]+"_y");
        if(obj_d.val()=="0" || obj_m.val()=="0" || obj_y.val()=="0")
        {
            obj_d.parent().addClass('hil');
            ret=ret && false;
        }
        else
        {
            obj_d.parent().removeClass('hil');
        }
    }
    
    
    //+++2013
	if(fc==7) ret=true;
    //---2013 
    
    useValues();
    return ret;
});

function Stress(id,regexp)
{
    cid='#'+id;
    if($(cid).val().match(regexp))
    {
        
        $(cid).parent().removeClass('hil');
    }
    else
    {
        $(cid).parent().addClass('hil');
    }
}


function facultyChange()
{
    var fc=document.getElementById('faculty').value;
    if(fc>0)
    {
        
        $('#time_form_id option').attr('disabled','disabled');;
        $('#edu_form option').attr('disabled','disabled');;
        $('#target option').attr('disabled','disabled');;
        $('#target_type option').attr('disabled','disabled');;
        $('#target_cell option').attr('disabled','disabled');;
        $('#region_cell option').attr('disabled','disabled');;
    }
    else
    {
               
        $('#time_form_id option').removeAttr('disabled');
        $('#edu_form option').removeAttr('disabled');
        $('#target option').removeAttr('disabled');
        $('#target_type option').removeAttr('disabled');
        $('#target_cell option').removeAttr('disabled');
        $('#region_cell option').removeAttr('disabled');    
    }
    
    for(i in tacl)
    {
        if(
            tacl[i][0] == fc
            )
            {
            $('#time_form_id option[value='+tacl[i][1]+']').removeAttr('disabled','');
            $('#edu_form option[value='+tacl[i][2]+']').removeAttr('disabled');
            $('#target option[value='+tacl[i][3]+']').removeAttr('disabled');
            $('#target_type option[value='+tacl[i][4]+']').removeAttr('disabled');
            $('#target_cell option[value='+tacl[i][5]+']').removeAttr('disabled');
            $('#region_cell option[value='+tacl[i][6]+']').removeAttr('disabled');
        }
    }
    $('#time_form_id option:not(:disabled):first').attr('selected','selected');
    $('#edu_form option:not(:disabled):first').attr('selected','selected');
    $('#target option:not(:disabled):first').attr('selected','selected');
    $('#target_type option:not(:disabled):first').attr('selected','selected');
    $('#target_cell option:not(:disabled):first').attr('selected','selected');
    $('#region_cell option:not(:disabled):first').attr('selected','selected');
    
    timeFormChange();
}
function timeFormChange()
{
    var fc=document.getElementById('faculty').value;
    var tf=document.getElementById('time_form_id').value;
    //var ef=document.getElementById('edu_form').value;
    //var t_=document.getElementById('target').value;
    //var tt=document.getElementById('target_type').value;
    //var tc=document.getElementById('target_cell').value;
    //var rc=document.getElementById('region_cell').value;
    $('#edu_form option').attr('disabled','disabled');;
    $('#target option').attr('disabled','disabled');;
    $('#target_type option').attr('disabled','disabled');;
    $('#target_cell option').attr('disabled','disabled');;
    $('#region_cell option').attr('disabled','disabled');;
    for(i in tacl)
    {
        if(
            
            tacl[i][0] == fc &&
            tacl[i][1] == tf /*&&    
            tacl[i][2] == ef &&
            tacl[i][3] == t_ &&
            tacl[i][4] == tt &&
            tacl[i][5] == tc &&
            tacl[i][6] == rc */
            )
            {
                
            $('#edu_form option[value='+tacl[i][2]+']').removeAttr('disabled');;
            $('#target option[value='+tacl[i][3]+']').removeAttr('disabled');;
            $('#target_type option[value='+tacl[i][4]+']').removeAttr('disabled');;
            $('#target_cell option[value='+tacl[i][5]+']').removeAttr('disabled');;
            $('#region_cell option[value='+tacl[i][6]+']').removeAttr('disabled');;
        }
    }
    $('#edu_form option:not(:disabled):first').attr('selected','selected');
    $('#target option:not(:disabled):first').attr('selected','selected');
    $('#target_type option:not(:disabled):first').attr('selected','selected');
    $('#target_cell option:not(:disabled):first').attr('selected','selected');
    $('#region_cell option:not(:disabled):first').attr('selected','selected');
    
    eduFormChange();
}

function eduFormChange()
{
    var fc=document.getElementById('faculty').value;
    var tf=document.getElementById('time_form_id').value;
    var ef=document.getElementById('edu_form').value;
    //var t_=document.getElementById('target').value;
    //var tt=document.getElementById('target_type').value;
    //var tc=document.getElementById('target_cell').value;
    //var rc=document.getElementById('region_cell').value;
    //$('#edu_form option').attr('disabled','disabled');;
    $('#target option').attr('disabled','disabled');;
    if (fc!=6){$('#target_type option').attr('disabled','disabled');;}
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
    //var tt=document.getElementById('target_type').value;
    //var tc=document.getElementById('target_cell').value;
    //var rc=document.getElementById('region_cell').value;
    //$('#edu_form option').attr('disabled','disabled');;
    //$('#target option').attr('disabled','disabled');;
  if (fc!=6){$('#target_type option').attr('disabled','disabled');;}
    if(fc!=7){$('#target_cell option').attr('disabled','disabled');;
    $('#region_cell option').attr('disabled','disabled');;}
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
    
    live_trigger();
    uzo_trigger();
    grade_target_trigger();
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
    
    live_trigger();
    uzo_trigger();
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


$('#faculty').change(facultyChange);
$('#time_form_id').change(timeFormChange);
$('#edu_form').change(eduFormChange);
$('#target').change(targetChange);
$('#target_type').change(targetTypeChange);
$('#target_cell').change(targetCellChange);

/*
function targets()
{
    var f=  $('#faculty').val() ;
    var e=  $('#edu_form').val() ;
    var t=  $('#target').val() ;
    var y=  $('#target_type').val() ;
    f=parseInt(f);
    e=parseInt(e);
    t=parseInt(t);
    y=parseInt(y);
    
    $('#time_form_id option').show();
    $('#edu_form option').show();
    $('#target option').show();
    $('#target_type option').show();
    $('#target_cell').show();
    $('#target_cell option').show();
    $('#region_cell').show();
    $('#region_cell option').show();
    
    
    $('#live_num,#live_date_d,#live_date_m,#live_date_y,#live_data').hide();
    $('#uzo_num,#uzo_date_d,#uzo_date_m,#uzo_date_y,#uzo_data').hide();
    
    switch(f)
    {
        case 1:
            
            $('#time_form_id option[value=2]').hide();
            $('#target_cell option[value=2]').hide();
            $('#time_form_id').val(1);
            break;
        case 2:
            
            $('#time_form_id option[value=2]').hide();
            $('#target_cell option[value=2]').hide();
            $('#time_form_id').val(1);
            break;
        case 3:
            
            $('#time_form_id option[value=2]').hide();
            $('#target_cell option[value=2]').hide();
            $('#time_form_id').val(1);
            break;
        case 4:
            
            $('#time_form_id option[value=2]').hide();
            $('#target_cell option[value=2]').hide();
            $('#time_form_id').val(1);
            break;
        case 5:
            $('#time_form_id').val(1);
            $('#time_form_id option[value=2]').hide();
            $('#edu_form option[value=2]').hide();
            $('#target option[value=1]').hide();
            $('#target option[value=4]').hide();
            $('#target option[value=5]').hide();
            $('#target_cell').hide();
            $('#region_cell').hide();
            break;
        case 6:
            
            break;
    }
    
    switch(e)
    {
        case 1:
            $('#target option[value=4]').hide();
            break;
        case 2:
            $('#target option[value=1]').hide();
            $('#target option[value=2]').hide();
            $('#target option[value=5]').hide();
            $('#target_cell').hide();
            $('#region_cell').hide();
            break;
    }
    switch(t)
    {
        case 1:
            $('#live_num,#live_date_d,#live_date_m,#live_date_y,#live_data').show();
            $('#uzo_num,#uzo_date_d,#uzo_date_m,#uzo_date_y,#uzo_data').show();
            break;
    }
    
    switch(y)
    {
        case 1:
            break;
        case 2:
            $('#live_num,#live_date_d,#live_date_m,#live_date_y,#live_data').show();
            break;
    }
}


$('#faculty').change(targets);
$('#edu_form').change(targets);
$('#time_form_id').change(targets);
$('#target').change(targets);
$('#target_type').change(targets);
targets();

function minsk()
{
    $('#region_text').hide();
    var r=$('#region_by').val();
    var c=$('#country').val();
    r=parseInt(r);
    c=parseInt(c);
    console.log(r,c);
    if(c==1)
    {
        $('#region_by').show();
    }
    else
    {
        $('#region_by').hide();
    }
    
    if(r==0)
    {
        $('#region_text').show();
    }else
    if(r==7)
    {
        $('#region_text').show();
        $('#region_text').val('Минск');
    }else
    {
        $('#region_text').val('');
    }
    
     
    
}

$('#country').change(minsk);
$('#region_by').change(minsk);
minsk();
*/

function kirilic()
{
    var eid='#'+this.id;
    if($(eid).val().match(/^[А-Яа-яЁё \-]*$/)==null)
    {
        
        $(eid).parent().addClass('hil');
    }
    else
    {
        $(eid).parent().removeClass('hil');
    }
}

function cifr()
{
    var eid='#'+this.id;
    if($(eid).val().match(/^[0-9]*$/)==null)
    {
        
        $(eid).parent().addClass('hil');
    }
    else
    {
        $(eid).parent().removeClass('hil');
    }
}


function telephone()
{
    var eid='#'+this.id;
    if($(eid).val().match(/^[\+0-9 ]*$/)==null)
    {
        
        $(eid).parent().addClass('hil');
    }
    else
    {
        $(eid).parent().removeClass('hil');
    }
}


$('#surname').change(kirilic);
$('#region_text').change(kirilic);

//$('#phone').change(telephone);
//$('#mobile').change(telephone);

$('#lct_sum').change(cifr);
$('#cct_sum').change(cifr);
$('#bct_sum').change(cifr);
$('#certificate_sum').change(cifr);
    
    
function father_use()
{
    $('#f_surname').val($('#surname').val());
}
function mother_use()
{
    $('#m_surname').val($('#surname').val());
}

function calc_use()
{
    var ball=window.open('calc.php', 'calc', 'height=200,width=200');
    //alert('not implemented');
}

function zip_use()
{
    var zipw=window.open('zipbrowser.php','zipw','height=200,width=200');
}

function lang_level()
{
	var t=$('#cur_lang_id').val();
	var cid = 'lang\['+t+'\]';
	document.getElementById(cid).checked=true;
}
$('#cur_lang_id').change(lang_level);

function addr_calc()
{
	var country 	= $('#country :selected').text();
	var region_by 	= $('#region_by :selected').text();
	var region 	= $('#region_text').val();
	var area	= $('#area').val();
	var subdiv_abbr	= $('#subdiv :selected').text();
        var subdiv_dbbr = subdiv_dict[$('#subdiv :selected').val()];
	var city_name	= $('#city_name').val();
        var zip         = $('#zip').val();
        var microarea   = $('#microarea').val();
        var street      = $('#street').val();
        var house       = $('#house').val();
        var house_part  = $('#house_part').val();
        var room        = $('#room').val();
        
      
        var addr_real   = '';
        if(zip.length)          addr_real = addr_real + zip +', ';
        addr_real = addr_real + country +', ';
        if(!region.length)      addr_real = addr_real + region_by +', ';
        if(region.length)       addr_real = addr_real + region +', ';
        if(area.length)         addr_real = addr_real + area +' район, ';
        addr_real = addr_real + subdiv_dbbr +'. ' +city_name+ ', ';
        if(microarea.length)    addr_real = addr_real + 'мкр-н '+microarea +', ';
        if(street.length)       addr_real = addr_real + street +', ';
        if(house.length)        addr_real = addr_real + ' д.' +house;
        if(house_part.length)   addr_real = addr_real + ' корп.' +house_part;
        if(room.length)         addr_real = addr_real + ' кв.' +room;
        
        
        $('#real_addr').val(addr_real);
}

function addr_fuse()
{
    $('#f_addr').val($('#real_addr').val());
}
function addr_muse()
{
    $('#m_addr').val($('#real_addr').val());
}


function ct_logic(subj)
{
	var ct_id = $(subj+'_id').val();
	if(ct_id == 0)
	{
		$(subj+'_sum').show();
		$(subj+'_sum').val('');
		$(subj+'_xn').show();
		$(subj+'_sn').show();
	}


	if(ct_id == 1)
	{
		$(subj+'_sum').show();
		$(subj+'_sum').val('');
		$(subj+'_xn').show();
		$(subj+'_sn').show();
	}

	if(ct_id == 2)
	{
		$(subj+'_sum').show();
		$(subj+'_sum').val('100');
		$(subj+'_xn').hide();
		$(subj+'_sn').hide();
	}
	if(ct_id == 3)
	{
		$(subj+'_sum').val('');
		$(subj+'_sum').hide();
		$(subj+'_xn').hide();
		$(subj+'_sn').hide();
	}
}




$('#lct_id').change(function(){ct_logic('#lct');});
$('#cct_id').change(function(){ct_logic('#cct');});
$('#bct_id').change(function(){ct_logic('#bct');});

function grade_trigger()
{
	var t = $('#grade_id').val();
	if(t == 0)
	{
		$('#lct_id').val(1);		
		$('#cct_id').val(1);
		$('#bct_id').val(1);
		
	}
	else
	{
		$('#lct_id').val(3);		
		$('#cct_id').val(3);
		$('#bct_id').val(3);
	}
	ct_logic('#lct');
	ct_logic('#cct');
	ct_logic('#bct');
}

$('#grade_id').change(grade_trigger);

function live_trigger()
{
	var t_ 	= $('#target').val();
	var tt 	= $('#target_type').val();
        var aes1 	= $('#bnf\\\[2\\\]').attr('checked');
	var aes2 	= $('#bnf\\\[3\\\]').attr('checked');

	if( t_ == 1 || tt == 2 || aes1 || aes2)
	{

		$('#live_num').show();
		$('#live_date_d').show();
		$('#live_date_m').show();
		$('#live_date_y').show();
		$('#live_data').show();
	}
	else
	{
		$('#live_num').hide();
		$('#live_date_d').hide();
		$('#live_date_m').hide();
		$('#live_date_y').hide();
		$('#live_data').hide();
	}

}

$('#target').change(live_trigger);
$('#target_type').change(live_trigger);
$('#bnf\\\[2\\\]').change(live_trigger);
$('#bnf\\\[3\\\]').change(live_trigger);

function uzo_trigger()
{

	var t_ 	= $('#target').val();
	

	if( t_ == 1 )
	{

		$('#uzo_num').show();
		$('#uzo_date_d').show();
		$('#uzo_date_m').show();
		$('#uzo_date_y').show();
		$('#uzo_data').show();
	}
	else
	{
		$('#uzo_num').hide();
		$('#uzo_date_d').hide();
		$('#uzo_date_m').hide();
		$('#uzo_date_y').hide();
		$('#uzo_data').hide();
	}
}

$('#target').change(uzo_trigger);

function aes_trigger()
{

	var aes1 	= $('#bnf\\\[2\\\]').attr('checked');
	var aes2 	= $('#bnf\\\[3\\\]').attr('checked');
	

	if( aes1 || aes2 )
	{

		$('#aes_num').show();
		$('#aes_date_d').show();
		$('#aes_date_m').show();
		$('#aes_date_y').show();
		$('#aes_end_date_d').show();
		$('#aes_end_date_m').show();
		$('#aes_end_date_y').show();
		$('#aes_data').show();
	}
	else
	{
		$('#aes_num').hide();
		$('#aes_date_d').hide();
		$('#aes_date_m').hide();
		$('#aes_date_y').hide();
		$('#aes_end_date_d').hide();
		$('#aes_end_date_m').hide();
		$('#aes_end_date_y').hide();
		$('#aes_data').hide();
	}
}
$('#bnf\\\[2\\\]').change(aes_trigger);
$('#bnf\\\[3\\\]').change(aes_trigger);


function inv_trigger()
{
	var inv 	= $('#bnf\\\[4\\\]').attr('checked');

	if( inv )
	{

		$('#inv_num').show();
		$('#inv_date_d').show();
		$('#inv_date_m').show();
		$('#inv_date_y').show();
		$('#inv_end_date_d').show();
		$('#inv_end_date_m').show();
		$('#inv_end_date_y').show();
		$('#inv_data').show();
                $('#invalid_id').show();
	}
	else
	{
		$('#inv_num').hide();
		$('#inv_date_d').hide();
		$('#inv_date_m').hide();
		$('#inv_date_y').hide();
		$('#inv_end_date_d').hide();
		$('#inv_end_date_m').hide();
		$('#inv_end_date_y').hide();
		$('#inv_data').hide();
                $('#invalid_id').hide();
                $('#invalid_id').val(0);
	}	
}

$('#bnf\\\[4\\\]').change(inv_trigger);

//------------- form initialization ------------
//
//

live_trigger();
uzo_trigger();
aes_trigger();
inv_trigger();

function rankChange()
{
    var fc=document.getElementById('inst_rank_id').value;
    if(fc>0)
    {
        
        $('#institution_id option').attr('disabled','disabled');;
        if(fc==1)
            {
                $('#certificate_id').val(1);
            }
            else
                {
                    $('#certificate_id').val(2);
                }
    }
    else
    {
               
        $('#institution_id option').removeAttr('disabled');
        $('#certificate_id').val(0);
    }
    
    for(i in iracl)
    {
        if(
            iracl[i][0] == fc
            )
            {
            $('#institution_id option[value='+iracl[i][1]+']').removeAttr('disabled','');
            
        }
    }
    $('#institution_id option:not(:disabled):first').attr('selected','selected');
    
}
$('#inst_rank_id').change(rankChange);




function toUp(str)
{

var search = new Array(
  "q","w","e","r","t","y","u","i","o","p","[","]",
  "a","s","d","f","g","h","j","k","l",";","'",
  "z","x","c","v","b","n","m",",","."
  );

  var replace = new Array(
  "Q","W","E","R","T","Y","U","I","O","P","{","}",
  "A","S","D","F","G","H","J","K","L",":",'"',
  "Z","X","C","V","B","N","M","<",">"
);
  return str.replace(search, replace);
}

function RU2EN(str)
 {
        replacer = {
            "й":"q", "ц":"w"  , "у":"e" , "к":"r" , "е":"t", "н":"y", "г":"u",
            "ш":"i", "щ":"o", "з":"p" , "х":"[" , "ъ":"]", "ф":"a", "ы":"s",
            "в":"d" , "а":"f"  , "п":"g" , "р":"h" , "о":"j", "л":"k", "д":"l",
            "ж":";" , "э":"'"  , "я":"z", "ч":"x", "с":"c", "м":"v", "и":"b",
            "т":"n" , "ь":"m"  , "б":"," , "ю":".","\"":"@"
        };      
         
        for(i=0; i < str.length; i++){                       
            if( replacer[ str[i].toLowerCase() ] != undefined){
                                 
                if(str[i] == str[i].toLowerCase()){
                    replace = replacer[ str[i].toLowerCase() ];   
                } else if(str[i] == str[i].toUpperCase()){
                    replace = replacer[ str[i].toLowerCase() ].toUpperCase();
                }
                 
                str = str.replace(str[i], replace);
            }
        }
         
       return str;
    }


function getChar(event) {
  if (event.which == null) { // IE
    if (event.keyCode < 32) return null; // спец. символ
    return String.fromCharCode(event.keyCode)
  }

  if (event.which != 0 && event.charCode != 0) { // все кроме IE
    if (event.which < 32) return null; // спец. символ
    return String.fromCharCode(event.which); // остальные
  }

  return null; // спец. символ
}






/*document.getElementById('private').onkeydown = function(e){
	kn = e.which;
	kr = /[A-Z0-9]/;
        if(kn>95 && kn<106) kn=kn-48;
	kc = String.toUpperCase(String.fromCharCode(kn));
	if(kn<47) return true;
	if(kr.test(kc))	this.value+=kc;
	return false;
	
}*/

document.getElementById('serial').onkeydown = function(e){
	
	kn = e.which;
	
	kr = /[A-Z0-9]/;
        if(kn>95 && kn<106) kn=kn-48;
	kc = String.fromCharCode(kn);
	if(kn<47) return true;
	if(kr.test(kc)) this.value+=kc;
	
	return false;
	
}

document.getElementById('private').onkeydown = function(e){
	
	kn = e.which;
	
	kr = /[A-Z0-9]/;
        if(kn>95 && kn<106) kn=kn-48;
	kc = String.fromCharCode(kn);
	if(kn<47) return true;
	if(kr.test(kc)) this.value+=kc;
	
	return false;
	
}

document.getElementById('email').onkeyup = function(e){
	
	if(e.which<47) return true;
	this.value = RU2EN(this.value);
	return false;
	
}

function grade_target_trigger()
{
    var t_= $('#target').val();
    if ( t_ == 2)
    {
        $('#grade_id').show();
    }
    else
    {
        $('#grade_id').hide();
        $('#grade_id').val(0);
        grade_trigger();
    }
}

$('#target').change(grade_target_trigger);

function regionby_trigger()
{
    var cn = $('#country').val();
    if(cn==1)
    {
        $('#region_by').show();
        $('#region_text').hide();
        $('#region_text').val('');
    }
    else
    {
        $('#region_by').hide();
        $('#region_text').show(); 
        $('#region_by').val(0);
    }
}

$('#country').change(regionby_trigger);

function defis_trigger()
{
    var obj = $('#'+this.id);
    var x= obj.val();;
    if(x.length==2)
        obj.val(x+'-');
    if(x.length==6)
        obj.val(x+'-');
}

$('#lct_sn').keyup(defis_trigger);
$('#bct_sn').keyup(defis_trigger);
$('#cct_sn').keyup(defis_trigger);

function ball_trigger()
{
    var b = parseInt(this.value);
    var obj = $('#'+this.id);
    if(b<7 ||  b>100 || isNaN(b))
    {
        
        obj.parent().addClass('hil');
    }
    else
        {
        obj.parent().removeClass('hil');    
        }
}
$('#certificate_sum').change(ball_trigger);
$('#lct_sum').change(ball_trigger);
$('#cct_sum').change(ball_trigger);
$('#bct_sum').change(ball_trigger);