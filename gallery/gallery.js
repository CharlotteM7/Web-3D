$(document).ready(function() {
  $.getJSON('gallery/hook.php', function(images) {
    let gallery = $('#gallery'); // Target the main gallery div

    $.each(images, function(index, imgPath) {
      let img = $('<img>')
        .attr('src', imgPath.replace('../', '')) // Clean path if needed
        .addClass('img-thumbnail m-2')
        .css('max-width', '150px');

      gallery.append(img);
    });
  }).fail(function(jqxhr, textStatus, error) {
    console.error('Error loading gallery: ', textStatus, error);
  });
});
