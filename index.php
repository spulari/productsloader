<?php include 'includes/header.php'; ?>

<div class="container my-5">
  <h1 class="mb-4">Our Products</h1>
  <p class="mb-5">Browse our latest prescription offerings. Images will load as you scroll.</p>

  <h3>New Prescriptions</h3>
  <div class="row" id="new-prescriptions"></div>

  <h3 class="mt-5">Old Prescriptions</h3>
  <div class="row" id="old-prescriptions"></div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function renderProducts(products, containerId) {
  const container = document.getElementById(containerId);
  container.innerHTML = '';

  products.forEach(p => {
    const card = document.createElement('div');
    card.className = 'col-md-12 mb-4 product-card';

    card.innerHTML = `
      <div class="card d-flex flex-row p-3 align-items-center">
        <div class="image-wrapper me-3" 
             style="width: 150px; height: 100px; flex-shrink: 0; position: relative; overflow: hidden; border-radius: 8px;">
          <div class="skeleton-image" 
               data-product-id="${p.id}" 
               data-loaded="false"
               style="width: 150px; height: 100px; background-color: #ddd;">
          </div>
        </div>
        <div class="flex-grow-1">
          <h5>${p.title}</h5>
          <p style="margin-bottom: 0;">${p.description}</p>
          <div class="mt-2">
            ${p.eligible ? '<button class="btn btn-primary btn-sm me-2">Add to Cart</button>' : ''}
            ${p.autorefilleligible ? '<button class="btn btn-secondary btn-sm">Auto Refill</button>' : ''}
          </div>
        </div>
      </div>
    `;
    container.appendChild(card);
  });

  initLazyLoad();
}

function initLazyLoad() {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const id = el.dataset.productId;
        if (el.dataset.loaded === "true") return;

        $.get(`fetch-image.php?id=${id}`, function(url) {
          const img = document.createElement('img');
          img.src = url;
          img.alt = 'Product Image';
          img.style.width = '150px';
          img.style.height = '100px';
          img.style.objectFit = 'cover';
          img.style.borderRadius = '8px';
          img.onload = function () {
            el.replaceWith(img);
          };
        });

        el.dataset.loaded = "true";
        observer.unobserve(el);
      }
    });
  }, { rootMargin: "50px" });

  document.querySelectorAll('.skeleton-image').forEach(el => observer.observe(el));
}

$(document).ready(function () {
  $.getJSON("fetch-products.php", function (data) {
    renderProducts(data.new, 'new-prescriptions');
    renderProducts(data.old, 'old-prescriptions');
  });
});
</script>
