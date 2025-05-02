const groupedImages = {
  coke: [],
  sprite: [],
  pepper: [],
};

function loadDrinkGallery(drink) {
  const container = $(`#gallery-${drink} .row`);
  container.empty();
  groupedImages[drink] = [];

  $.getJSON(`index.php?route=apiGetGallery&drink=${drink}`, function (images) {
    if (images.length === 0) {
      container.append(`<p class="text-muted text-center">No images found for ${drink}.</p>`);
      return;
    }

    images.forEach((imgPath, index) => {
      groupedImages[drink].push(imgPath); 

      const img = $("<img>")
        .attr("src", imgPath)
        .addClass("img-fluid gallery-thumb m-2")
        .attr("data-bs-toggle", "modal")
        .attr("data-bs-target", "#galleryModal")
        .attr("data-group", drink)
        .attr("data-index", index)
        .css({
          maxWidth: "350px",  
          maxHeight: "180px",
          objectFit: "cover",
          borderRadius: "10px",
          opacity: 0,
          boxShadow: "0 4px 12px rgba(0,0,0,0.15)",
        })
        

      container.append(img);
      img.animate({ opacity: 1 }, 400);
    });
  });
}
window.loadDrinkGallery = loadDrinkGallery;

