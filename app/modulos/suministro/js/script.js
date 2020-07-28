$( document ).ready(function()
{
  
  var regis_pro =  $('.register_pro');
  var regis_provee =  $('.register_provee');
  var data_distrib = $('.data_dis');


  $('.pr').click( function ()
  {
      $(regis_pro).show("slow");
  });

  $('.fa-arrow-up').click ( function ()
  {
    $(regis_pro).slideUp();
  });

  ///////
  $('.provee').click( function ()
  {
      $(regis_provee).show("slow");
  });

  $('.fa-arrow-up').click ( function ()
  {
    $(regis_provee).slideUp();
  });

  /////

  $('.dis').click ( function ()
  {
    $(data_distrib).show("slow");
  });

  $('.fa-arrow-up').click ( function ()
  {
    $(data_distrib).slideUp();
  });

});

