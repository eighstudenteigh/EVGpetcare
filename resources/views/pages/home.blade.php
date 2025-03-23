@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section - Removed min-h-[calc(100vh-4rem)] to prevent footer issues -->
<div class="flex flex-col flex-grow relative"> 

    <!-- Image container - Adjust height on mobile -->
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

    <!-- Text container - Overlay for mobile, separate for desktop -->
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
<!-- Running Dog Container (Initially Hidden) -->
<div class="relative overflow-hidden h-28 bg-white">
    <img src="{{ asset('images/running-dog.gif') }}" alt="Running Dog" id="running-dog" class="absolute bottom-0 hidden" />
</div>

@endsection

@section('scripts')
<script>
    window.addEventListener('load', function () {
        if (typeof gsap === 'undefined') {
            loadGSAP();
        } else {
            initAnimations();
        }
    });

    function loadGSAP() {
        const gsapScript = document.createElement('script');
        gsapScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js';
        gsapScript.onload = initAnimations;
        document.body.appendChild(gsapScript);
    }

    function initAnimations() {
        const resetAnimation = () => {
            const isMobile = window.innerWidth < 768;
            const viewportHeight = window.innerHeight;
            const heroHeightDesktop = Math.min(viewportHeight * 0.8, 600);

            gsap.set("#cat-image", { scale: 1.1, y: "0%" });
            gsap.set("#hero-container", { height: isMobile ? "50%" : heroHeightDesktop + "px" });
            gsap.set("#first-text-section", { opacity: 0, height: 0, width: "100%" });
            gsap.set("#second-text-section", { opacity: 0, width: 0, height: "0%" });
            gsap.set("#running-dog", { x: "-200px", display: "none" });

            const timeline = gsap.timeline({ defaults: { ease: "power2.inOut" }, delay: 0.5 });

            if (isMobile) {
                timeline
                    .to("#cat-image", { y: "4%", duration: 1 })
                    .to("#hero-container", { height: "35%", duration: 1 }, "-=0.8")
                    .to("#first-text-section", { height: "18vh", opacity: 1, duration: 0.8 }, "-=0.3")
                    .to("#second-text-section", { height: "12vh", opacity: 1, duration: 1.2 });
            } else {
                timeline
                    .to("#cat-image", { y: "4%", duration: 1.5 })
                    .to("#hero-container", { height: "50vh", duration: 1.5 }, "-=1")
                    .to("#first-text-section", { height: "20vh", opacity: 1, duration: 1 }, "-=0.5")
                    .to("#second-text-section", { width: "30%", height: "15vh", opacity: 1, duration: 1 }, "-=0.2")
                    .to("#first-text-section", { width: "70%", height: "15vh", duration: 0.8 }, "-=0.8");
            }

            
            timeline
                .set("#running-dog", { display: "block" })
                .fromTo("#running-dog", 
                    { x: "-200px" }, 
                    { x: "100vw", duration: 8, repeat: -1, ease: "linear" }
                );
        };

        resetAnimation();
        window.addEventListener('resize', resetAnimation);
    }
</script>


<style>
    #running-dog {
    position: absolute;
    bottom: 0;
    height: 100px;
    will-change: transform;
    z-index: 10; /* Ensure it's on top */
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
        top: 49%; /* Adjusted to better center text on mobile */
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

    #first-text-section, #second-text-section {
        transition: height 0.3s ease, width 0.3s ease, opacity 0.3s ease;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Enhanced text visibility */
    }

    @media (max-width: 767px) {
        h1 {
            font-size: 1.8rem;
            padding: 0.8rem;
        }

        h2 {
            font-size: 1.6rem;
            color: #E67700; /* text-gray-700 */
            padding: 1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4); /* Slight shadow for better readability */
        }
    }
</style>
@endsection