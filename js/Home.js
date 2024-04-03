document.addEventListener('DOMContentLoaded', function() {
    // Define variables for the carousel, slides, and buttons
    const carouselItems = document.querySelector('.carousel-items');
    const slides = document.querySelectorAll('.carousel-items img');
    const prevButton = document.querySelector('.prev-btn');
    const nextButton = document.querySelector('.next-btn');

    // Set initial slide index and auto-run interval
    let slideIndex = 0;
    const intervalTime = 3000; 

    // Function to show the next slide
    function nextSlide() {
        // Increase the slide index by 1
        slideIndex++;

        // If the slide index exceeds the last slide, reset to 0 (loop back)
        if (slideIndex >= slides.length) {
            slideIndex = 0;
        }

        // Update the slide display
        updateSlide();
    }

    // Function to update the slide display
    function updateSlide() {
        carouselItems.style.transform = `translateX(${-slideIndex * 100}%)`;
    }

    // Set an interval to auto-run the carousel
    let autoRunInterval = setInterval(nextSlide, intervalTime);

    // Pause auto-run when hovering over the carousel
    carouselItems.addEventListener('mouseover', () => {
        clearInterval(autoRunInterval);
    });

    // Resume auto-run when mouse leaves the carousel
    carouselItems.addEventListener('mouseleave', () => {
        autoRunInterval = setInterval(nextSlide, intervalTime);
    });

    // Add event listeners to previous and next buttons
    prevButton.addEventListener('click', () => {
        // Decrease the slide index by 1
        slideIndex--;

        // If the slide index is less than 0, set it to the last slide index
        if (slideIndex < 0) {
            slideIndex = slides.length - 1;
        }

        // Update the slide display
        updateSlide();
    });

    nextButton.addEventListener('click', () => {
        // Call the nextSlide function to move to the next slide
        nextSlide();
    });
});
