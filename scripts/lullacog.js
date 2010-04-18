Drupal.behaviors.lullaCog = function(context) {
  //Add search text to search box
  $('#search-block-form input.form-text, #search input.form-text', context).val('Search').focus(function() {
    $(this).val('').addClass('active');
  }).blur(function() {
    if ($(this).val() == '') {
      $(this).val('Search').removeClass('active');
    }
  });
};