
var arr = new Array(
    'uq','auid','cuid','vuid','xuid','filltime','state_id','surname','name','midname','serial','private','authority','region_text','area','city_name','zip','microarea','street','house','house_part','room','phone','mobile','email','real_addr','f_surname','f_name','f_midname','f_addr','m_surname','m_name','m_midname','m_addr','institution_name','inst_city_name','certificate_name','certificate_sum','lct_sum','lct_sn','lct_xn','cct_sum','cct_sn','cct_xn','bct_sum','bct_sn','bct_xn','live_num','live_data','aes_num','aes_data','uzo_num','uzo_data','inv_num','inv_data',
    'faculty','time_form_id','edu_form','target','target_type','target_cell','region_cell','dual_mode_set','sex','birthday_d','birthday_m','birthday_y','natio','authority_date_d','authority_date_m','authority_date_y','country','region_by','subdiv','inst_rank_id','institution_id','inst_city_type','certificate_id','cert_date_d','cert_date_m','cert_date_y','course_id','grade_id','lct_id','cct_id','bct_id','cur_lang_id','cur_lang_level','experience_id','try_id','invalid_id','hostel_id','live_date_d','live_date_m','live_date_y','aes_date_d','aes_date_m','aes_date_y','uzo_date_d','uzo_date_m','uzo_date_y','inv_date_d','inv_date_m','inv_date_y','inv_end_date_d','inv_end_date_m','inv_end_date_y','aes_end_date_d','aes_end_date_m','aes_end_date_y',
    'f_org','f_pos','f_phone','m_org','m_pos','m_phone','lang_grade','po_base_id'
    
    
    
    );

var chk = new Array(
    'xc[1]','wb[1]','lang[1]','lang[2]','lang[3]','lang[4]','lang[5]','lang[6]','lang[7]','bnf[1]','bnf[2]','bnf[3]','bnf[4]','bnf[5]','bnf[6]','bnf[7]','bnf[8]','bnf[9]','bnf[10]','com[1]','com[2]','com[3]',
    'po[1]','po[2]','po[3]'
    );

    
$(document).ready(function(){
    if(typeof(localStorage) == 'undefined' ) { return;}    
    for(i in arr)
    {
        gss(arr[i]);
      
    }
    for(i in chk)
    {
        var cid=chk[i];
        var elm=localStorage.getItem(cid);
       // console.log(cid,elm);
        var exm=(elm==='true');
        if(elm!==null)
            document.getElementById(cid).checked=exm;
    }
    
    
    localStorage.clear();
})

function fuseValues()
{
    if(typeof(localStorage) == 'undefined' ) { return;}
    useValues();
    
    window.location.reload(true);
}
function useValues()
{
    if(typeof(localStorage) == 'undefined' ) { return;}
    for(i in arr)
    {
        lss(arr[i]);
    }
    for(i in chk)
    {
        cid=chk[i];
        if(document.getElementById(cid))
            localStorage.setItem(cid,document.getElementById(cid).checked);
    }
}
function lss(id)
{
    if(typeof(localStorage) == 'undefined' ) { return;}
    localStorage.setItem(id,$('#'+id).val());
}

function gss(id)
{
    if(typeof(localStorage) == 'undefined' ) { return;}
    if(localStorage.getItem(id)!==null)
        $('#'+id).val(localStorage.getItem(id));
    //console.log(id,localStorage.getItem(id));
}

