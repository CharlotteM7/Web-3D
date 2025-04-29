function loadGallery(drink) {
  const galleryId = `#gallery-${drink}`;
  const galleryDiv = $(galleryId);
  galleryDiv.empty(); // clear old thumbnails

  // ✅ Debug line — visibly confirm gallery loaded
  galleryDiv.append(`<p class="text-muted">Gallery loaded for <strong>${drink}</strong></p>`);

  $.getJSON(`gallery/hook.php?drink=${drink}`, function(images) {
    $.each(images, function(index, imgPath) {
      const img = $('<img>')
        .attr('src', imgPath.replace('../', ''))
        .addClass('img-thumbnail m-2')
        .css('max-width', '150px');
      galleryDiv.append(img);
    });
  }).fail(function(jqxhr, textStatus, error) {
    console.error(`Error loading gallery for ${drink}:`, textStatus, error);
  });
}
