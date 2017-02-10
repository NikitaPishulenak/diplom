/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {  
    var i = parseInt(window.location.hash.substr(1))+200;
    if(i<1) i=0;
        window.scrollTo(0,i);
});