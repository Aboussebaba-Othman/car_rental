@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users Card -->
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-800">2,854</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span class="text-green-500 mr-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            7.2%
                        </span>
                        <span class="text-gray-500 text-sm">Depuis le mois dernier</span>
                    </div>
                </div>

                <!-- Companies Card -->
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Entreprises</p>
                            <p class="text-2xl font-bold text-gray-800">128</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span class="text-green-500 mr-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            3.5%
                        </span>
                        <span class="text-gray-500 text-sm">Depuis le mois dernier</span>
                    </div>
                </div>

                <!-- Vehicles Card -->
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Véhicules</p>
                            <p class="text-2xl font-bold text-gray-800">482</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H11a1 1 0 001-1v-1h3.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1v-6a1 1 0 00-.293-.707l-3-3A1 1 0 0016 3H3zm0 2h12v.586l3 3V15h-1.05a2.5 2.5 0 00-4.9 0H9a1 1 0 01-1 1v1H4a1 1 0 01-1-1V6z" />
                                t 0 0-1 1v1H4a1 1 0 01-1-1V6z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span class="text-red-500 mr-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                            </svg>
                            1.2%
                        </span>
                        <span class="text-gray-500 text-sm">Depuis le mois dernier</span>
                    </div>
                </div>

                <!-- Bookings Card -->
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Réservations</p>
                            <p class="text-2xl font-bold text-gray-800">1,543</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span class="text-green-500 mr-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            12.5%
                        </span>
                        <span class="text-gray-500 text-sm">Depuis le mois dernier</span>
                    </div>
                </div>
            </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    
    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
    
    closeMobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.add('hidden');
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = mobileMenu.contains(event.target);
        const isClickOnMenuButton = mobileMenuButton.contains(event.target);
        
        if (!isClickInsideMenu && !isClickOnMenuButton && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    });
    
    // Task checkboxes
    const taskCheckboxes = document.querySelectorAll('input[type="checkbox"]');
    
    taskCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskText = this.parentNode.querySelector('.text-gray-800') || this.parentNode.nextElementSibling.querySelector('.text-gray-800');
            
            if (this.checked) {
                taskText.classList.add('line-through', 'text-gray-400');
            } else {
                taskText.classList.remove('line-through', 'text-gray-400');
            }
        });
    });
    
    // Sticky header on scroll
    const header = document.querySelector('header');
    const sticky = header.offsetTop;
    
    function handleScroll() {
        if (window.pageYOffset > sticky) {
            header.classList.add('sticky', 'top-0', 'z-10');
        } else {
            header.classList.remove('sticky', 'top-0', 'z-10');
        }
    }
    
    window.addEventListener('scroll', handleScroll);
    
    // Animated counters for statistics
    const counterElements = document.querySelectorAll('.text-2xl.font-bold.text-gray-800');
    
    function animateCounter(el, target) {
        const duration = 1500;
        const frameDuration = 1000/60;
        const totalFrames = Math.round(duration / frameDuration);
        let frame = 0;
        const countTo = parseInt(target.replace(/,/g, ''));
        
        const counter = setInterval(() => {
            frame++;
            const progress = frame / totalFrames;
            const currentCount = Math.round(countTo * progress);
            
            if (parseInt(el.textContent) !== currentCount) {
                el.textContent = currentCount.toLocaleString();
            }
            
            if (frame === totalFrames) {
                clearInterval(counter);
            }
        }, frameDuration);
    }
    
    // Intersection Observer to trigger the animation when elements come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target, entry.target.textContent);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    counterElements.forEach(counter => {
        observer.observe(counter);
    });
});
</script>
@endsection