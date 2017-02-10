/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    var t=($('div.temp_chain a.chain_active').offset()!=null)?$('div.temp_chain a.chain_active').offset().top:40;
    $('div.temp_chain').scrollTop(t-40);
    var r=($('div.real_chain a.chain_active').offset()!=null)?$('div.real_chain a.chain_active').offset().top:20;
    $('div.real_chain').scrollTop(r-20);

    
    
});

function calc_ui_use()
{
    var ball=window.open('calc.php', 'calc', 'height=200,width=200');
    //alert('not implemented');
}

function phone_ui_use()
{
    var codd=window.open('phcd.php', 'phcd', 'scrollbars=1,height=200,width=200');
}