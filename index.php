<?php include 'includes/header.php'; ?>

<div class="container my-5">
  <h1 class="mb-4">Our Products</h1>
  <p class="mb-5">Browse our latest prescription offerings. Images will load as you scroll.</p>



  <?php include 'fetch-products.php'; ?>
</div>
<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
document.addEventListener("DOMContentLoaded", function() {
  const skeletons = document.querySelectorAll(".skeleton-image");
  const queue = Array.from(skeletons);
  let concurrentFetches = 0;
  const MAX_CONCURRENT = 5;

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        // Mark as observed so we don't repeatedly enqueue
        if (!el.dataset.enqueued) {
          el.dataset.enqueued = "true";
          enqueueFetch(el);
        }
        obs.unobserve(el);
      }
    });
  }, {
    rootMargin: "100px",
    threshold: 0.1
  });

  queue.forEach(el => observer.observe(el));

  function enqueueFetch(el) {
    if (concurrentFetches < MAX_CONCURRENT) {
      loadImage(el);
    } else {
      // Wait until we have a slot
      const interval = setInterval(() => {
        if (concurrentFetches < MAX_CONCURRENT) {
          clearInterval(interval);
          loadImage(el);
        }
      }, 100);
    }
  }

  function loadImage(el) {
    concurrentFetches++;
    const productId = el.dataset.productId;

    fetch(`fetch_product_image.php?product_id=${productId}`)
      .then(res => res.json())
      .then(data => {
        if (data.image_url) {
          const img = document.createElement("img");
          img.src = data.image_url;
          img.alt = "Product Image";
          img.style.width = "100%";
          img.style.height = "100%";
          img.style.objectFit = "cover";
          el.innerHTML = "";
          el.appendChild(img);
          el.dataset.loaded = "true";
        }
      })
      .catch(err => console.error("Image fetch error:", err))
      .finally(() => {
        concurrentFetches--;
      });
  }
});
</script>