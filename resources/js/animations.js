/**
 * Clinic animations — GSAP + ScrollTrigger (loaded via CDN defer in layout).
 */

function initAnimations() {
    if (typeof window.gsap === 'undefined' || typeof window.ScrollTrigger === 'undefined') return;

    const gsap = window.gsap;
    const ScrollTrigger = window.ScrollTrigger;

    // Respect OS reduced-motion preference
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    gsap.registerPlugin(ScrollTrigger);

    // Shared defaults
    const EASE     = 'power2.out';
    const DURATION = 0.8;
    const FROM_Y   = 30; // px — vertical-only to prevent horizontal scroll bugs on mobile

    /* ── helper: reveal a single element on scroll ── */
    function reveal(el, extra = {}) {
        gsap.from(el, {
            opacity: 0,
            y: FROM_Y,
            duration: DURATION,
            ease: EASE,
            ...extra,
            scrollTrigger: {
                trigger: el,
                start: 'top 88%',
                once: true,
            },
        });
    }

    /* ─────────────────────────────────────────────
       1. HERO — staggered entrance (no scroll trigger)
    ───────────────────────────────────────────── */
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        const items = [
            '.hero-eyebrow',
            '.hero-title',
            '.hero-text',
            '.hero-cta',
            '.hero-status',
            '.hero-stats',
        ].flatMap(sel => Array.from(document.querySelectorAll(sel)));

        if (items.length) {
            gsap.from(items, {
                opacity: 0,
                y: FROM_Y,
                duration: DURATION,
                ease: EASE,
                stagger: 0.12,
                clearProps: 'transform', // avoid stale transforms after anim
            });
        }

        const heroImg = document.querySelector('.hero-image');
        if (heroImg) {
            gsap.from(heroImg, {
                opacity: 0,
                y: 20,
                duration: DURATION + 0.2,
                ease: EASE,
                delay: 0.2,
                clearProps: 'transform',
            });
        }
    }

    /* ─────────────────────────────────────────────
       2. PAGE HERO (inner pages)
    ───────────────────────────────────────────── */
    ['.page-hero-title', '.page-hero-description', '.page-hero-breadcrumb'].forEach(sel => {
        document.querySelectorAll(sel).forEach(el => reveal(el));
    });

    /* ─────────────────────────────────────────────
       3. STAGGERED CARD GROUPS
    ───────────────────────────────────────────── */
    document.querySelectorAll('.stagger-cards').forEach(group => {
        const cards = Array.from(group.querySelectorAll('.stagger-card'));
        if (!cards.length) return;

        gsap.from(cards, {
            opacity: 0,
            y: FROM_Y,
            duration: DURATION,
            ease: EASE,
            stagger: 0.1,
            clearProps: 'transform',
            scrollTrigger: {
                trigger: group,
                start: 'top 86%',
                once: true,
            },
        });
    });

    /* ─────────────────────────────────────────────
       4. TREATMENT ROWS (home list — separate from cards)
    ───────────────────────────────────────────── */
    document.querySelectorAll('.stagger-cards .treatment-row').forEach((row, i) => {
        // Only animate rows NOT already inside a stagger-card (treatments page wraps them)
        if (row.closest('.stagger-card')) return;

        gsap.from(row, {
            opacity: 0,
            y: 20,
            duration: DURATION,
            ease: EASE,
            delay: i * 0.09,
            clearProps: 'transform',
            scrollTrigger: {
                trigger: row,
                start: 'top 88%',
                once: true,
            },
        });
    });

    /* ─────────────────────────────────────────────
       5. STAT COUNTERS — count up once on scroll
    ───────────────────────────────────────────── */
    document.querySelectorAll('.stat-counter[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target, 10);
        if (!target) return;

        const obj = { val: 0 };

        // Fade-in the containing element
        const parent = el.closest('dd, div') ?? el;
        gsap.from(parent, {
            opacity: 0,
            y: 16,
            duration: DURATION,
            ease: EASE,
            scrollTrigger: { trigger: parent, start: 'top 88%', once: true },
        });

        ScrollTrigger.create({
            trigger: el,
            start: 'top 88%',
            once: true,
            onEnter() {
                gsap.to(obj, {
                    val: target,
                    duration: 1.4,
                    ease: 'power1.inOut',
                    onUpdate() {
                        el.textContent = Math.round(obj.val).toLocaleString();
                    },
                    onComplete() {
                        el.textContent = target.toLocaleString();
                    },
                });
            },
        });
    });

    /* ─────────────────────────────────────────────
       6. MOBILE DRAWER — smooth height slide
    ───────────────────────────────────────────── */
    const navToggle = document.querySelector('[data-site-nav-toggle]');
    const navDrawer = document.querySelector('[data-site-nav]');

    if (navToggle && navDrawer) {
        // Set initial state (hidden but renderable)
        gsap.set(navDrawer, { height: 0, overflow: 'hidden', display: 'block', opacity: 0 });
        let isNavOpen = false;

        navToggle.addEventListener('click', () => {
            isNavOpen = !isNavOpen;
            navToggle.setAttribute('aria-expanded', String(isNavOpen));

            if (isNavOpen) {
                gsap.set(navDrawer, { display: 'block' });
                gsap.to(navDrawer, {
                    height: 'auto',
                    opacity: 1,
                    duration: 0.38,
                    ease: 'power2.out',
                });
            } else {
                gsap.to(navDrawer, {
                    height: 0,
                    opacity: 0,
                    duration: 0.28,
                    ease: 'power2.in',
                    onComplete: () => gsap.set(navDrawer, { display: 'none' }),
                });
            }
        });
    }

    /* ─────────────────────────────────────────────
       7. USER-MENU DROPDOWN — fade + lift
    ───────────────────────────────────────────── */
    document.querySelectorAll('[data-user-menu]').forEach(details => {
        const panel = details.querySelector('div');
        if (!panel) return;

        details.addEventListener('toggle', () => {
            if (details.open) {
                gsap.fromTo(panel,
                    { opacity: 0, y: -6, scale: 0.97 },
                    { opacity: 1, y: 0, scale: 1, duration: 0.22, ease: 'power2.out' }
                );
            }
        });
    });
}

/* ── Wait for GSAP deferred scripts to execute ── */
function bootAnimations() {
    if (typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined') {
        initAnimations();
        return;
    }
    let tries = 0;
    const poll = setInterval(() => {
        tries++;
        if (typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined') {
            clearInterval(poll);
            initAnimations();
        } else if (tries > 40) {
            clearInterval(poll); // give up after ~2 s
        }
    }, 50);
}

document.addEventListener('DOMContentLoaded', bootAnimations);
