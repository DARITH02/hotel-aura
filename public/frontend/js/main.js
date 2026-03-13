/**
 * Luxury Hotel Main JS
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Toggle Navbar on Scroll
    const navbar = document.querySelector('.navbar-main');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // 2. Smooth Scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // 3. Simple Gallery Lightbox
    window.openGalleryLightbox = function(imagePath) {
        // Implement as needed or use a library
        console.log("Opening gallery image: ", imagePath);
    };

    // 4. Booking Summary
    window.showBookingSummary = function() {
        const checkIn = document.getElementById('heroCheckIn').value;
        const checkOut = document.getElementById('heroCheckOut').value;
        const guests = document.getElementById('heroGuests').value;
        const roomType = document.getElementById('heroRoomType').value;

        if (checkIn && checkOut) {
            alert(`Searching availability for ${roomType} room from ${checkIn} to ${checkOut} for ${guests} guests.`);
        } else {
            alert("Please select dates first.");
        }
    };

    // 5. Scroll Reveal Animation Trigger
    const revealOnScroll = function() {
        const reveals = document.querySelectorAll('.slide-up, .fade-in');
        reveals.forEach(el => {
            const windowHeight = window.innerHeight;
            const elementTop = el.getBoundingClientRect().top;
            const elementVisible = 150;
            if (elementTop < windowHeight - elementVisible) {
                // Animation is handled by CSS, we just need the element in view
            }
        });
    };
    window.addEventListener("scroll", revealOnScroll);

});
