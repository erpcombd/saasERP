
$('[data-id="model"]').on('click', function(){
  var thisModel = $(this).data('target');
  $(thisModel).show();
  $(thisModel).find('[data-close="model"]').click(function(){ 
    $(thisModel).hide();
  });
  $(window).click(function(event){
    if('#'+event.target.id == thisModel){
      $(thisModel).hide();
    }
  });
});