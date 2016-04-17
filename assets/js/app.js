$(function(){
   var text = '';

   $('em').hover(function(){
       var original = $(this).data('original');
       // Save the last value
       text = $(this).text();

       $(this).text(original);
   }, function(){
       $(this).text(text);
   });
});