document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelector('.slides');
    const slideElements = document.querySelectorAll('.slide');
    const navButtons = document.querySelectorAll('.manual-btn');
    let currentSlide = 0;
    const totalSlides = slideElements.length;

    // Function to update the slider position
    function updateSlider() {
        slides.style.transform = `translateX(-${currentSlide * 100}%)`;
        // Update active button
        navButtons.forEach((btn, index) => {
            btn.classList.toggle('active', index === currentSlide);
        });
    }

    // Event listeners for navigation buttons
    navButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            currentSlide = index;
            updateSlider();
        });
    });

  
    updateSlider();
    
    setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }, 5000); 
    
});