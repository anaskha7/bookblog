document.addEventListener('DOMContentLoaded', function () {
  // Tilt effect for cards
  const cards = document.querySelectorAll('.tilt-card');
  cards.forEach(card => {
    card.addEventListener('pointermove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left; // x position within the element.
      const y = e.clientY - rect.top;  // y position within the element.
      const cx = rect.width / 2;
      const cy = rect.height / 2;
      const dx = (x - cx) / cx;
      const dy = (y - cy) / cy;
      const rotX = (dy * 6).toFixed(2);
      const rotY = (dx * -6).toFixed(2);
      card.style.transform = `translateY(-8px) rotateX(${rotX}deg) rotateY(${rotY}deg)`;
      card.style.boxShadow = '0 30px 60px rgba(2,6,23,0.18)';
    });
    card.addEventListener('pointerleave', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
    });
  });

  // Simple show/hide for hero CTA focus
  const ctas = document.querySelectorAll('.btn-primary');
  ctas.forEach(btn => {
    btn.addEventListener('mouseenter', () => btn.style.opacity = '0.95');
    btn.addEventListener('mouseleave', () => btn.style.opacity = '1');
  });
});
