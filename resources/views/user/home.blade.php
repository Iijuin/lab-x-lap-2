@extends('layouts.user')

@section('title', 'Lab x Lap - Temukan Laptop Terbaik')

@section('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes floatLaptop {
        0%, 100% {
            transform: translate(-50%, -50%) rotate(-15deg) translateY(0px);
        }
        50% {
            transform: translate(-50%, -50%) rotate(-15deg) translateY(-10px);
        }
    }

    @keyframes pulseArrow {
        0%, 100% {
            transform: scale(1) rotate(45deg);
            opacity: 0.7;
        }
        50% {
            transform: scale(1.1) rotate(45deg);
            opacity: 1;
        }
    }

    @keyframes textGlow {
        0%, 100% {
            text-shadow: 0 0 5px rgba(107, 107, 107, 0.3);
        }
        50% {
            text-shadow: 0 0 20px rgba(107, 107, 107, 0.6);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .animate-fade-in-left {
        animation: fadeInLeft 0.8s ease-out forwards;
    }

    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
    }

    .animate-float {
        animation: floatLaptop 3s ease-in-out infinite;
    }

    .animate-pulse-arrow {
        animation: pulseArrow 2s ease-in-out infinite;
    }

    .text-glow {
        animation: textGlow 3s ease-in-out infinite;
    }

    .hover-scale {
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
        color: #4a4a4a;
    }

    .laptop-container {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .laptop-container:hover {
        transform: translate(-50%, -50%) rotate(-10deg) scale(1.05);
    }

    .interactive-bg {
        background: linear-gradient(135deg, #f2f0ef 0%, #e8e6e3 100%);
        position: relative;
        overflow: hidden;
    }

    .interactive-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 20%, rgba(107, 107, 107, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(107, 107, 107, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .typewriter {
        overflow: hidden;
        border-right: 2px solid #6b6b6b;
        white-space: nowrap;
        animation: typing 2s steps(20, end), blink-caret 0.75s step-end infinite;
    }

    @keyframes typing {
        from { width: 0 }
        to { width: 100% }
    }

    @keyframes blink-caret {
        from, to { border-color: transparent }
        50% { border-color: #6b6b6b }
    }

    .initial-hidden {
        opacity: 0;
        transform: translateY(30px);
    }

    .stagger-1 { animation-delay: 0.2s; }
    .stagger-2 { animation-delay: 0.4s; }
    .stagger-3 { animation-delay: 0.6s; }
    .stagger-4 { animation-delay: 0.8s; }
</style>
@endsection

@section('content')
<div class="flex items-center max-w-[98vw] relative z-10">
    <div class="flex flex-col justify-center mr-4 sm:mr-6 initial-hidden animate-fade-in-left">
        <span class="text-[1.5rem] font-normal text-[#6b6b6b] leading-none select-none hover-scale stagger-1">
            Temukan
        </span>
        <span class="text-[9rem] font-normal text-[#6b6b6b] leading-none select-none tracking-tight text-glow hover-scale stagger-2" 
              style="line-height: 1;" 
              onclick="handleTextClick('laptop')">
            LAPTOP
        </span>
    </div>
    <div class="flex flex-col justify-center ml-4 sm:ml-6 initial-hidden animate-fade-in-right">
        <span class="text-[9rem] font-normal text-[#6b6b6b] leading-none select-none tracking-tight text-glow hover-scale stagger-3" 
              style="line-height: 1;"
              onclick="handleTextClick('terbaik')">
            TERBAIK
        </span>
        <span class="text-[1.5rem] font-normal text-[#6b6b6b] leading-none select-none self-end hover-scale typewriter stagger-4">
            Versi kamu sendiri
        </span>
    </div>
</div>

<img alt="Silver laptop open at an angle showing keyboard and screen with blue geometric wallpaper" 
     class="w-[600px] h-[375px] object-contain select-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-0 animate-float laptop-container" 
     draggable="false" 
     height="375" 
     src="{{ asset('image/laptop.png') }}" 
     width="600"
     onclick="handleLaptopClick()"/>

<div class="absolute bottom-6 right-6 text-[#6b6b6b] select-none animate-pulse-arrow cursor-pointer" 
     style="font-size: 5rem; line-height: 1;"
     onclick="handleArrowClick()">
    <i class="fas fa-arrow-right rotate-45"></i>
</div>

<!-- Floating particles -->
<div class="absolute inset-0 pointer-events-none">
    <div class="particle absolute w-2 h-2 bg-gray-400 rounded-full opacity-30" style="top: 20%; left: 10%; animation: floatLaptop 4s ease-in-out infinite;"></div>
    <div class="particle absolute w-1 h-1 bg-gray-500 rounded-full opacity-40" style="top: 60%; left: 80%; animation: floatLaptop 3s ease-in-out infinite reverse;"></div>
    <div class="particle absolute w-1.5 h-1.5 bg-gray-400 rounded-full opacity-20" style="top: 80%; left: 20%; animation: floatLaptop 5s ease-in-out infinite;"></div>
</div>

<!-- Interactive tooltip -->
<div id="tooltip" class="absolute z-20 bg-black text-white px-3 py-1 rounded-lg text-sm opacity-0 transition-all duration-300 pointer-events-none">
    Klik untuk mulai!
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize animations
        const elements = document.querySelectorAll('.initial-hidden');
        elements.forEach(el => {
            setTimeout(() => {
                el.classList.remove('initial-hidden');
            }, 100);
        });
        
        // Add mouse move effect
        document.addEventListener('mousemove', handleMouseMove);
        
        // Add click sound effect (optional)
        createClickSound();
    });

    function handleTextClick(type) {
        const element = event.target;
        
        // Add click animation
        element.style.transform = 'scale(0.95)';
        element.style.transition = 'transform 0.1s ease';
        
        setTimeout(() => {
            element.style.transform = 'scale(1.05)';
            setTimeout(() => {
                element.style.transform = 'scale(1)';
            }, 100);
        }, 100);
        
        // Show encouraging message
        showMessage(type === 'laptop' ? 'Laptop impian menanti!' : 'Temukan yang terbaik untukmu!');
        
        // Trigger laptop animation
        const laptop = document.querySelector('.laptop-container');
        laptop.style.animation = 'none';
        laptop.offsetHeight; // Trigger reflow
        laptop.style.animation = 'floatLaptop 0.5s ease-in-out';
        
        setTimeout(() => {
            laptop.style.animation = 'floatLaptop 3s ease-in-out infinite';
        }, 500);
    }

    function handleLaptopClick() {
        const laptop = event.target;
        
        // Add rotation effect
        laptop.style.transform = 'translate(-50%, -50%) rotate(0deg) scale(1.1)';
        laptop.style.transition = 'transform 0.3s ease';
        
        setTimeout(() => {
            laptop.style.transform = 'translate(-50%, -50%) rotate(-15deg) scale(1)';
        }, 300);
        
        showMessage('Siap mencari laptop terbaik?');
        
        // Redirect after animation
        setTimeout(() => {
            window.location.href = "{{ route('questions.index') }}";
        }, 1000);
    }

    function handleArrowClick() {
        const arrow = event.target;
        
        // Add pulse effect
        arrow.style.transform = 'scale(1.5) rotate(45deg)';
        arrow.style.transition = 'transform 0.2s ease';
        
        setTimeout(() => {
            arrow.style.transform = 'scale(1) rotate(45deg)';
        }, 200);
        
        showMessage('Ayo mulai perjalanan mu!');
        
        // Redirect after animation
        setTimeout(() => {
            window.location.href = "{{ route('questions.index') }}";
        }, 800);
    }

    function handleMouseMove(e) {
        const laptop = document.querySelector('.laptop-container');
        const mouseX = e.clientX;
        const mouseY = e.clientY;
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2;
        
        const rotateX = (mouseY - centerY) / centerY * 5;
        const rotateY = (mouseX - centerX) / centerX * 5;
        
        laptop.style.transform = `translate(-50%, -50%) rotate(-15deg) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        
        // Show tooltip near cursor
        const tooltip = document.getElementById('tooltip');
        if (e.target.classList.contains('laptop-container') || e.target.classList.contains('hover-scale')) {
            tooltip.style.left = mouseX + 10 + 'px';
            tooltip.style.top = mouseY - 30 + 'px';
            tooltip.style.opacity = '1';
        } else {
            tooltip.style.opacity = '0';
        }
    }

    function showMessage(text) {
        // Create floating message
        const message = document.createElement('div');
        message.textContent = text;
        message.className = 'absolute top-1/4 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-90 px-4 py-2 rounded-lg shadow-lg text-gray-700 font-medium z-30';
        message.style.animation = 'fadeInUp 0.5s ease-out forwards';
        
        document.body.appendChild(message);
        
        setTimeout(() => {
            message.style.animation = 'fadeInUp 0.5s ease-out reverse';
            setTimeout(() => {
                document.body.removeChild(message);
            }, 500);
        }, 2000);
    }

    function createClickSound() {
        // Create subtle click sound using Web Audio API
        window.playClickSound = function() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
            gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        };
    }

    // Add click sound to interactive elements
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('hover-scale') || 
            e.target.classList.contains('laptop-container') || 
            e.target.classList.contains('animate-pulse-arrow')) {
            try {
                window.playClickSound();
            } catch (error) {
                // Silently handle audio context errors
            }
        }
    });
</script>
@endsection