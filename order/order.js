
// Simple interactive elements
document.addEventListener('DOMContentLoaded', function() {
  // Category tabs
  const categoryBtns = document.querySelectorAll('.category-btn');
  categoryBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      categoryBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      // Here you would filter the menu items based on category
    });
  });
  
  // Add to cart buttons
  const addToCartBtns = document.querySelectorAll('.add-to-cart');
  addToCartBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const foodCard = btn.closest('.food-card');
      const foodName = foodCard.querySelector('.food-title').textContent;
      const foodPrice = foodCard.querySelector('.food-price').textContent;
      
      alert(`Added ${foodName} (${foodPrice}) to your cart!`);
      // In a real app, you would update the cart count and store the selection
    });
  });
  
  // Cart icon click
  const cartIcon = document.querySelector('.cart-icon');
  cartIcon.addEventListener('click', () => {
    alert('Your cart is empty!'); // This would open a cart modal in a real app
  });
});