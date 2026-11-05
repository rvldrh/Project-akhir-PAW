import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import { gsap } from 'gsap';

/**
 * Coming Soon Page Animation
 */
function initComingSoonAnimation() {
    const page = document.querySelector('[data-coming-soon]');

    // Do not execute if this page is not the Coming Soon page.
    if (!page) return;

    const mediaQuery = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    );

    // Respect accessibility preferences.
    if (mediaQuery.matches) {
        gsap.set(page.querySelectorAll('[data-animate]'), {
            opacity: 1,
            clearProps: 'all',
        });

        return;
    }

    const ctx = gsap.context(() => {
        const intro = gsap.timeline({
            defaults: {
                ease: 'power3.out',
            },
        });

        // Header entrance
        intro.from('[data-animate="header"]', {
            y: -25,
            opacity: 0,
            duration: 0.9,
        });

        // Hero text entrance
        intro.from(
            '[data-animate="content"] > *',
            {
                y: 35,
                opacity: 0,
                duration: 0.9,
                stagger: 0.13,
            },
            '-=0.45'
        );

        // Visual entrance
        intro.from(
            '[data-animate="visual"]',
            {
                x: 70,
                opacity: 0,
                scale: 0.92,
                duration: 1.3,
                ease: 'power4.out',
            },
            '-=0.8'
        );

        // Footer entrance
        intro.from(
            '[data-animate="footer"]',
            {
                y: 20,
                opacity: 0,
                duration: 0.8,
            },
            '-=0.4'
        );

        // Floating elements
        const floatElements = page.querySelectorAll('[data-float]');

        floatElements.forEach((element) => {
            const speed = element.dataset.float;

            const settings = {
                slow: {
                    y: 18,
                    x: 8,
                    rotation: 3,
                    duration: 5.5,
                },
                medium: {
                    y: 25,
                    x: -10,
                    rotation: -4,
                    duration: 4.5,
                },
                fast: {
                    y: 14,
                    x: 12,
                    rotation: 5,
                    duration: 3.5,
                },
            };

            const config = settings[speed] ?? settings.medium;

            gsap.to(element, {
                x: config.x,
                y: config.y,
                rotation: config.rotation,
                duration: config.duration,
                ease: 'sine.inOut',
                repeat: -1,
                yoyo: true,
                delay: Math.random() * 1.5,
            });
        });

    }, page);

    // Cleanup when navigating away or reinitializing.
    return () => ctx.revert();
}

initComingSoonAnimation();
