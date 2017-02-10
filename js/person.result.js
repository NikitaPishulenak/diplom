$(document).ready(function(){

$('div.ssfs  tr  th').each(function(a,b) {console.log(this.width=$(this).width())});
var header=$('div.ssfs tr').first().html();
$('#header tr').html(header);
$('#header').width($('div.ssfs table').width());
$('div.ssfs').height($(document).height()-$('div.ssfs').offset().top-30);

});