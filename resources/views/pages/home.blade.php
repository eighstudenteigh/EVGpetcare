@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="flex flex-col flex-grow relative"> 
    <!-- Image container -->
    <div class="relative h-[50vh] md:h-[60vh] overflow-hidden" id="hero-container">
        <div class="absolute inset-0 flex items-center justify-center" id="cat-image-wrapper">
            <img
                src="{{ asset('images/peeking-cat.webp') }}"
                alt="Peeking Cat"
                id="cat-image"
                class="w-full h-auto max-h-[60vh] object-contain"
            />
        </div>
    </div>

    <!-- Text container -->
    <div class="relative flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-4 px-4" id="text-container">
        <!-- First text section -->
        <div id="first-text-section" class="bg-orange-500 text-white opacity-0 h-0 w-full md:w-2/3 flex items-center justify-center rounded-lg shadow-lg px-4 py-3 text-center transition-all">
            <h1 class="text-xl sm:text-2xl md:text-4xl font-bold">Caring Hands for Your Beloved Pets</h1>
        </div>

        <!-- Second text section -->
        <div id="second-text-section" class="bg-gray-500 text-white opacity-0 h-0 w-full md:w-1/3 flex items-center justify-center rounded-lg shadow-lg px-4 py-3 text-center transition-all">
            <h2 class="text-lg sm:text-xl md:text-2xl">Where Pets Are Family</h2>
        </div>
    </div>
</div>

<!-- Running Dog Container -->
<div class="relative overflow-hidden h-24 bg-white">
    <img src="{{ asset('images/running-dog.gif') }}" alt="Running Dog" id="running-dog" class="absolute bottom-0 hidden" />
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isMobile = window.innerWidth < 768;
        
        if (isMobile) {
            initMobileAnimations();
        } else {
            if (typeof gsap === 'undefined') {
                loadGSAP();
            } else {
                initDesktopAnimations();
            }
        }
    });

    function initMobileAnimations() {
        document.getElementById('cat-image').classList.add('mobile-cat-animation');

        setTimeout(() => {
            document.getElementById('first-text-section').style.opacity = '1';
            document.getElementById('first-text-section').style.height = 'auto';
            document.getElementById('second-text-section').style.opacity = '1';
            document.getElementById('second-text-section').style.height = 'auto';

            const runningDog = document.getElementById('running-dog');
            runningDog.classList.remove('hidden');
            runningDog.classList.add('mobile-dog-run');
        }, 500);
    }

    function loadGSAP() {
        const gsapScript = document.createElement('script');
        gsapScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js';
        gsapScript.onload = initDesktopAnimations;
        document.body.appendChild(gsapScript);
    }

    function initDesktopAnimations() {
        gsap.timeline({ defaults: { ease: "power2.inOut" }, delay: 0.5 })
            .to("#cat-image", { y: "4%", duration: 1.5 })
            .to("#hero-container", { height: "50vh", duration: 1.5 }, "-=1")
            .to("#first-text-section", { opacity: 1, height: "auto", duration: 1 }, "-=0.5")
            .to("#second-text-section", { opacity: 1, height: "auto", duration: 1 }, "-=0.5")
            .set("#running-dog", { display: "block" })
            .fromTo("#running-dog", { x: "-200px" }, { x: "100vw", duration: 8, repeat: -1, ease: "linear" });
    }
</script>

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    #hero-container {
        transition: height 0.3s ease;
    }

    #text-container {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
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
            width: 100%;
            pointer-events: auto;
        }
    }

    .mobile-cat-animation {
        animation: moveDown 1s ease-out forwards;
    }

    .mobile-dog-run {
        opacity: 0;
        animation: fadeIn 0.5s ease-out forwards, dogRun 10s linear infinite 0.5s;
    }

    @keyframes moveDown {
        from { transform: translateY(-58px); }
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
</style>
@endsection
