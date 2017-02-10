/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $("#frm select").each(function(k,v){
        v.onchange=function(){
            if(v.value>0)
            {
               $(v).addClass('sfh');
            }
            else
            {
               $(v).removeClass('sfh');
            }
        }
    });
    $("#frm input[type=text]").each(function(k,v){
        v.onchange=function(){
            if(v.value.length>0)
            {
               $(v).addClass('sfh');
            }
            else
            {
               $(v).removeClass('sfh');
            }
        }
    });
});