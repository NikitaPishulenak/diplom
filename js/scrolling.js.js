$(document).ready(function () {  
  var top = $('#viewmenu').offset().top - parseFloat($('#viewmenu').css('marginTop').replace(/auto/, 0));
//  console.log('scrolling');
  $(window).scroll(function (event) {
    // what the y position of the scroll is
    var y = $(this).scrollTop();
  
    // whether that's below the form
    if (y >= top) {
      // if so, ad the fixed class
      $('#viewmenu').css('position','fixed');
      $('#viewmenu').css('top','5px');
//      $('#viewmenu').css('border','1px solid rgb(60, 179, 113)');
      
      document.getElementById('editlink').hash='#'+y;
    } else {
      // otherwise remove it
      $('#viewmenu').css('position','static');
      $('#viewmenu').css('border','0px');
      document.getElementById('editlink').hash="";
    }
  });
});