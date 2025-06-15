function initLazyLoad() {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const img = document.createElement('img');
        img.src = el.dataset.src;
        img.alt = 'Product Image';
        img.className = 'img-fluid rounded';
        el.replaceWith(img);
        observer.unobserve(el);
      }
    });
  });

  document.querySelectorAll('.skeleton-image').forEach(el => observer.observe(el));
}
