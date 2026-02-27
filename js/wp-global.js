jQuery(document).ready(function($) {
  $('details').on('toggle', function() {
    $(this).find('summary').first().attr('aria-expanded', this.open);
  });
});
