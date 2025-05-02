function loadDrinkGallery(drink) {
  const container = $(`#gallery-${drink} .row`);
  container.empty();

  $.getJSON(`index.php?route=apiGetGallery&drink=${drink}`, function (images) {
    if (images.length === 0) {
      container.append(`<p class="text-muted text-center">No images found for ${drink}.</p>`);
      return;
    }

    images.forEach((imgPath) => {
      const img = $("<img>")
        .attr("src", imgPath)
        .addClass("img-thumbnail m-2")
        .css({ maxWidth: "150px", opacity: 0 });
      container.append(img);
      img.animate({ opacity: 1 }, 400);
    });
  });

}
  window.loadDrinkGallery = loadDrinkGallery;


