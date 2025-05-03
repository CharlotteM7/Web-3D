/**
 * Stores gallery image paths for each drink brand.
 * Used to populate modal previews and manage image sets.
 */
const groupedImages = {
  coke: [],
  sprite: [],
  pepper: [],
};

/**
 * Loads gallery images for a specific drink brand using AJAX.
 * Injects <img> elements into the corresponding Bootstrap grid.
 *
 * @param {string} drink - The drink brand ID (e.g. 'coke', 'sprite', 'pepper').
 */
function loadDrinkGallery(drink) {
  const container = $(`#gallery-${drink} .row`);
  container.empty();
  groupedImages[drink] = [];

  $.getJSON(`index.php?route=apiGetGallery&drink=${drink}`, function (images) {
    if (images.length === 0) {
      container.append(
        `<p class="text-muted text-center">No images found for ${drink}.</p>`
      );
      return;
    }

    images.forEach((imgPath, index) => {
      groupedImages[drink].push(imgPath);
      const img = $("<img>")
      .attr("src", imgPath)
      .attr("alt", `${drink} image ${index + 1}`)
      .attr("loading", "lazy")
      .attr("data-bs-toggle", "modal")
      .attr("data-bs-target", "#galleryModal")
      .attr("data-group", drink)
      .attr("data-index", index)
      .addClass("img-fluid gallery-thumb m-2");
    

      const col = $("<div>")
        .addClass("col-6 col-md-3 d-flex justify-content-center")
        .append(img);

        img.on("click", function () {
          showGalleryModal(drink, index);
        });
        

      container.append(col);

      setTimeout(() => img.css("opacity", 1), 50); // fade in effect
    });
  });
}

// Expose to global scope so swapContent() and other modules can access it
window.loadDrinkGallery = loadDrinkGallery;
