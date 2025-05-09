<!-- Script for gallery functionality and animations -->
<script>
    function moveGallery(gallery, direction) {
        const container = gallery.querySelector('.gallery-container');
        const currentIndex = parseInt(container.dataset.index);
        const slides = container.querySelectorAll('.gallery-slide');
        const totalSlides = slides.length;
        
        // Calculate new index
        let newIndex = currentIndex + direction;
        if (newIndex < 0) newIndex = totalSlides - 1;
        if (newIndex >= totalSlides) newIndex = 0;
        
        // Update container position
        container.style.transform = `translateX(-${newIndex * 100}%)`;
        container.dataset.index = newIndex;
        
        // Update indicators
        const indicators = gallery.querySelectorAll('.gallery-indicator');
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
            if (parseInt(indicator.dataset.index) === newIndex) {
                indicator.classList.add('active');
            }
        });
        
        // Update counter
        const counter = gallery.querySelector('.current-photo');
        if (counter) counter.textContent = newIndex + 1;
    }
    
    // Initialize mobile menu and animations
    document.addEventListener('DOMContentLoaded', function() {
        // Gallery indicators click handlers
        const indicators = document.querySelectorAll('.gallery-indicator');
        indicators.forEach(indicator => {
            indicator.addEventListener('click', function() {
                const gallery = this.closest('.vehicle-gallery');
                const container = gallery.querySelector('.gallery-container');
                const currentIndex = parseInt(container.dataset.index);
                const targetIndex = parseInt(this.dataset.index);
                
                // Move gallery to clicked indicator
                const direction = targetIndex - currentIndex;
                moveGallery(gallery, direction);
            });
        });
        
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const closeMenuButton = document.getElementById('close-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuOverlay = document.getElementById('menu-overlay');
        
        if (mobileMenuButton && closeMenuButton && mobileMenu && menuOverlay) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.add('active');
                menuOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            closeMenuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            menuOverlay.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        // Initialize date inputs with today's date and tomorrow
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const pickupDateInput = document.getElementById('pickup_date');
        const returnDateInput = document.getElementById('return_date');
        
        if(pickupDateInput && returnDateInput) {
            pickupDateInput.valueAsDate = today;
            returnDateInput.valueAsDate = tomorrow;
            
            pickupDateInput.min = today.toISOString().split('T')[0];
            returnDateInput.min = tomorrow.toISOString().split('T')[0];
            
            pickupDateInput.addEventListener('change', function() {
                const newMinReturn = new Date(this.value);
                newMinReturn.setDate(newMinReturn.getDate() + 1);
                returnDateInput.min = newMinReturn.toISOString().split('T')[0];
                
                if(new Date(returnDateInput.value) <= new Date(this.value)) {
                    returnDateInput.valueAsDate = newMinReturn;
                }
            });
        }
        
        // Animate elements on scroll
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.animate-fade-in, .animate-slide-up');
            elements.forEach(element => {
                const position = element.getBoundingClientRect();
                // If element is in viewport
                if(position.top < window.innerHeight * 0.9 && position.bottom >= 0) {
                    element.style.opacity = '1';
                }
            });
        };
        
        // Run once on load
        animateOnScroll();
        
        // Add scroll event listener
        window.addEventListener('scroll', animateOnScroll);
        
        // Header scroll effect
        const header = document.querySelector('header');
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                header.classList.add('shadow-lg');
                header.classList.add('bg-white/95');
                header.classList.add('backdrop-blur-sm');
            } else {
                header.classList.remove('shadow-lg');
                header.classList.remove('bg-white/95');
                header.classList.remove('backdrop-blur-sm');
            }
            
            lastScrollTop = scrollTop;
        });
    });
</script>
