function loadGallery(drink) {
  const galleryId = `#gallery-${drink}`;
  const galleryDiv = $(galleryId);
  galleryDiv.empty(); // clear old thumbnails

  // 🆕 Create a nicer title
  const drinkName = drink.charAt(0).toUpperCase() + drink.slice(1);
  const header = $('<h2>')
    .text(`${drinkName} Image Gallery`)
    .addClass('text-center w-100 mb-4');
  galleryDiv.append(header);

  $.getJSON(`gallery/hook.php?drink=${drink}`, function(images) {
    $.each(images, function(index, imgPath) {
      const cleanPath = imgPath.replace('../', '');
      const img = $('<img>')
        .attr('src', cleanPath)
        .addClass('img-thumbnail m-2')
        .css({
          'max-width': '150px',
          'opacity': 0 // Start hidden
        });
      
      galleryDiv.append(img);

      // 🆕 Animate the image fading in
      img.animate({opacity: 1}, 500); // 500ms fade-in
    });
  }).fail(function(jqxhr, textStatus, error) {
    console.error(`Error loading gallery for ${drink}:`, textStatus, error);
  });
}
