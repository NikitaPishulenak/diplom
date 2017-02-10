/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var fields = new Array();

function fpush(c,t)
{
    fields.push(c);
    $('#fields').val(fields.join('|'));
    var l='<a style="display:block;white-space:nowrap;padding:1px;" id="idfx_'+c+'" href="javascript:fpop(\'' + c + '\');">' + t + '</a> ';
    //console.log(l);
    $('#fields_v').before(l);
    $('#src_'+c).css('background-color','#CEECDE');
}

function fpop(c)
{
   /*
   // console.log(c);
   // console.log($('#fields').val());
    $('#idfx_'+c).remove();
    var k;
    for(k in fields)
        {
            // console.log(c,k,fields[k],fields[k]==c);
            
          if(fields[k] == c)
              {
              // console.log('bingo');
              fields.splice(k, 1);
              break;
              // console.log(fields);
              }
        }
        $('#fields').val(fields.join('|'));
       // console.log('fields:'+$('#fields').val());
	*/
    $('#idfx_'+c).remove();
    var k;
    var f=false;
    var b=false;
    
    for(k in fields)
    {
        // console.log(c,k,fields[k],fields[k]==c);
            
        if(fields[k] == c)
        {
            b=true;
            if(!f){
                fields.splice(k, 1);
                f=true;
                b=(fields[k] == c);
            }
              
        }
    }
    if(!b) 
    {
        $('#src_'+c).css('background-color','transparent');
    }
    $('#fields').val(fields.join('|'));
}
function savedpush(c)
{
    var t=$('#src_'+c).text();
    fpush(c,t);
}

$(document).ready(function()
{
    $('#saved').change(function()
    {
        for(k in fields)
            {
                $('#idfx_'+fields[k]).remove();
            }
        fields.length=0;
        
        $('#field').val('');
        $('#saved').val().split('|').forEach(savedpush );
    }
)
})