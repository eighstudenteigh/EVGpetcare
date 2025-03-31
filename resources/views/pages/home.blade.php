@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="flex flex-col flex-grow relative"> 
    <!-- Image container -->
    <div class="relative h-1/2 md:h-[60vh] overflow-hidden" id="hero-container">
        <div class="absolute inset-0" id="cat-image-wrapper">
            <img
                src="{{ asset('images/peeking-cat.webp') }}"
                alt="Peeking Cat"
                id="cat-image"
                class="w-full h-full object-cover object-center"
            />
        </div>
    </div>

    <!-- Text container -->
    <div class="relative flex flex-col md:flex-row overflow-hidden items-center justify-center" id="text-container">
        <!-- First text section -->
        <div id="first-text-section" class="bg-orange-500 text-white opacity-0 h-0 w-full md:w-2/3 flex items-center justify-center rounded-lg shadow-lg">
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-bold px-4 py-2 text-center">Caring Hands for Your Beloved Pets</h1>
        </div>

        <!-- Second text section -->
        <div id="second-text-section" class="bg-gray-500 text-white opacity-0 h-0 w-full md:w-1/3 flex items-center justify-center rounded-lg shadow-lg">
            <h2 class="text-lg sm:text-xl md:text-3xl px-4 py-2 text-center">Where Pets Are Family</h2>
        </div>
    </div>
</div>

<!-- Running Dog Container -->
<div class="relative overflow-hidden h-28 bg-white">
    <img src="{{ asset('images/running-dog.gif') }}" alt="Running Dog" id="running-dog" class="absolute bottom-0 hidden" />
</div>
@endsection

@section('scripts')
<script>
    // Global variables
    let gsapTimeline;

    window.addEventListener('load', function () {
        // Detect if mobile
        const isMobile = window.innerWidth < 768;
        
        if (isMobile) {
            // Use CSS animations for mobile
            initMobileAnimations();
        } else {
            // Use GSAP for desktop
            if (typeof gsap === 'undefined') {
                loadGSAP();
            } else {
                initDesktopAnimations();
            }
        }
        
        // Listen for resize events to switch animation methods
        window.addEventListener('resize', function() {
            const nowMobile = window.innerWidth < 768;
            
            if (nowMobile !== isMobile) {
                // Reload the page to switch animation methods
                window.location.reload();
            }
        });
    });
    
    function initMobileAnimations() {
        // Clean up any existing GSAP animations
        if (typeof gsap !== 'undefined' && gsapTimeline) {
            gsapTimeline.kill();
        }
        
        // Set initial state for mobile
        document.getElementById('hero-container').style.height = '50%';
        document.getElementById('cat-image').classList.add('mobile-cat-animation');
        
        // Setup text containers with staggered fade animations
        const firstText = document.getElementById('first-text-section');
        const secondText = document.getElementById('second-text-section');
        const runningDog = document.getElementById('running-dog');
        
        // Clear any inline styles from GSAP
        firstText.removeAttribute('style');
        secondText.removeAttribute('style');
        runningDog.removeAttribute('style');
        
        // Add mobile animation classes with staggered delays
        firstText.classList.add('mobile-slide-up');
        firstText.style.animationDelay = '600ms';
        firstText.style.height = '18vh';
        firstText.style.opacity = '0';
        
        secondText.classList.add('mobile-slide-up');
        secondText.style.animationDelay = '1200ms';
        secondText.style.height = '12vh';
        secondText.style.opacity = '0';
        
        // Setup dog animation for mobile
        runningDog.classList.remove('hidden');
        runningDog.classList.add('mobile-dog-run');
        runningDog.style.animationDelay = '900ms';

        // Force a reflow to ensure animations start
        void document.getElementById('hero-container').offsetWidth;
        
        // Now set the opacity to trigger animations
        setTimeout(() => {
            firstText.style.opacity = '1';
            secondText.style.opacity = '1';
        }, 100);
    }

    function loadGSAP() {
        const gsapScript = document.createElement('script');
        gsapScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js';
        gsapScript.onload = initDesktopAnimations;
        document.body.appendChild(gsapScript);
    }

    function initDesktopAnimations() {
        const viewportHeight = window.innerHeight;
        const heroHeightDesktop = Math.min(viewportHeight * 0.8, 600);

        gsap.set("#cat-image", { scale: 1.1, y: "0%" });
        gsap.set("#hero-container", { height: heroHeightDesktop + "px" });
        gsap.set("#first-text-section", { opacity: 0, height: 0, width: "100%" });
        gsap.set("#second-text-section", { opacity: 0, width: 0, height: "0%" });
        gsap.set("#running-dog", { x: "-200px", display: "none" });

        gsapTimeline = gsap.timeline({ defaults: { ease: "power2.inOut" }, delay: 0.5 });

        gsapTimeline
            .to("#cat-image", { y: "4%", duration: 1.5 })
            .to("#hero-container", { height: "50vh", duration: 1.5 }, "-=1")
            .to("#first-text-section", { height: "20vh", opacity: 1, duration: 1 }, "-=0.5")
            .to("#second-text-section", { width: "30%", height: "15vh", opacity: 1, duration: 1 }, "-=0.2")
            .to("#first-text-section", { width: "70%", height: "15vh", duration: 0.8 }, "-=0.8")
            .set("#running-dog", { display: "block" })
            .fromTo("#running-dog", 
                { x: "-200px" }, 
                { x: "100vw", duration: 8, repeat: -1, ease: "linear" }
            );
    }
</script>

<style>
    #running-dog {
        position: absolute;
        bottom: 0;
        height: 100px;
        will-change: transform;
        z-index: 20; /* Ensure it's on top */
    }
    
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Changed from 'hidden' to allow vertical scrolling */
    }

    #hero-container {
        transition: height 0.3s ease;
    }

    #text-container {
        position: absolute;
        top: 61%; /* Adjusted to better center text on mobile */
        left: 50%;
        transform: translate(-50%, -45%);
        z-index: 5;
        width: 80%;
        pointer-events: none;
    }

    @media (min-width: 768px) {
        #text-container {
            position: relative;
            top: unset;
            left: unset;
            transform: none;
            z-index: 1;
            width: 100%;
            pointer-events: auto;
        }

        #first-text-section {
            width: 100%;
            height: 18vh; /* Reduce the height */
            padding: 0.5rem; /* Reduce padding */
        }

        #second-text-section {
            width: 100%;
            height: 12vh; /* Reduce the height */
            padding: 0.5rem; /* Reduce padding */
        }
    }

    #first-text-section:hover, #second-text-section:hover {
        transition: height 0.3s ease, width 0.3s ease, opacity 0.3s ease;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
        letter-spacing: 1px;
    }

    @media (max-width: 767px) {
        .mobile-slide-up {
        animation: slideUp 1s ease-out forwards;
    }

    @keyframes slideUp {
        from { 
            opacity: 1; /* Keep visible */
            transform: translateY(100px); /* Start lower */
        }
        to { 
            transform: translateY(0); /* Move to normal position */
        }
    }
        h1 {
            font-size: 1.8rem;
            padding: 0.8rem;
        }

        h2 {
            font-size: 1.6rem;
            color: white; 
            padding: 1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4); /* Slight shadow for better readability */
        }
        
        /* Mobile animations */
        .mobile-cat-animation {
            animation: moveDown 1s ease-out forwards;
        }
        
        .mobile-fade-in {
            animation: fadeIn 1.2s ease-out forwards;
        }
        
        .mobile-dog-run {
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards, dogRun 10s linear infinite 0.5s;
        }
        
        @keyframes moveDown {
            from { transform: translateY(-30px); }
            to { transform: translateY(4%); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes dogRun {
            from { transform: translateX(-200px); }
            to { transform: translateX(100vw); }
        }
    }
</style>
@endsection