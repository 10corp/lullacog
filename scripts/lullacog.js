Drupal.behaviors.lullaCog = function(context) {
  //Add search text to search box
  $('#search-block-form input.form-text, #search-box input.form-text', context).val('Search').one('focus', function() {
    $(this).val('').addClass('active');
  });
};