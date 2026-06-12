/*
 | Sekmen Zemin Tasarım — Frontend etkileşimleri
 | Scroll-reveal, öncesi/sonrası slider, accordion (SSS), mobil menü,
 | sayaç animasyonu, lightbox, galeri thumbnail, event tracking (Meta/GA4).
*/

/* ----------------------------- Scroll Reveal ----------------------------- */
function initReveal() {
    const els = document.querySelectorAll('.reveal');
    if (!els.length || !('IntersectionObserver' in window)) {
        els.forEach((el) => el.classList.add('in'));
        return;
    }
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('in');
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12 }
    );
    els.forEach((el) => io.observe(el));
}

/* ------------------------- Sayaç (Counter) animasyonu -------------------- */
function initCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;
    const animate = (el) => {
        const target = parseFloat(el.dataset.counter);
        const suffix = el.dataset.suffix || '';
        const prefix = el.dataset.prefix || '';
        const dur = 1600;
        const start = performance.now();
        const step = (now) => {
            const p = Math.min((now - start) / dur, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            const val = Math.floor(eased * target);
            el.textContent = prefix + val.toLocaleString('tr-TR') + suffix;
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = prefix + target.toLocaleString('tr-TR') + suffix;
        };
        requestAnimationFrame(step);
    };
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    animate(e.target);
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.5 }
    );
    counters.forEach((el) => io.observe(el));
}

/* ----------------------- Öncesi / Sonrası slider ------------------------- */
function initBeforeAfter() {
    document.querySelectorAll('[data-ba]').forEach((slider) => {
        const handle = slider.querySelector('.slider-handle');
        const beforeImg = slider.querySelector('[data-ba-before]');
        if (!handle || !beforeImg) return;
        let dragging = false;
        const move = (clientX) => {
            const rect = slider.getBoundingClientRect();
            let x = clientX - rect.left;
            x = Math.max(0, Math.min(x, rect.width));
            const percent = (x / rect.width) * 100;
            handle.style.left = `${percent}%`;
            beforeImg.style.width = `${percent}%`;
        };
        const start = () => (dragging = true);
        const stop = () => (dragging = false);
        handle.addEventListener('mousedown', start);
        window.addEventListener('mouseup', stop);
        window.addEventListener('mousemove', (e) => dragging && move(e.pageX));
        handle.addEventListener('touchstart', start, { passive: true });
        window.addEventListener('touchend', stop);
        window.addEventListener(
            'touchmove',
            (e) => dragging && e.touches[0] && move(e.touches[0].pageX),
            { passive: true }
        );
    });
}

/* ------------------------------ Accordion (SSS) -------------------------- */
function initAccordion() {
    document.querySelectorAll('[data-accordion] .accordion-item > button').forEach((btn) => {
        btn.addEventListener('click', () => {
            btn.closest('.accordion-item').classList.toggle('open');
        });
    });
}

/* ------------------------------- Mobil menü ------------------------------ */
function initMobileMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');
    if (!toggle || !menu) return;
    const open = () => {
        menu.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    };
    const close = () => {
        menu.classList.add('translate-x-full');
        document.body.style.overflow = '';
    };
    toggle.addEventListener('click', open);
    menu.querySelectorAll('[data-menu-close]').forEach((el) => el.addEventListener('click', close));
}

/* -------------------------- Header küçülme (sticky) ---------------------- */
function initStickyHeader() {
    const header = document.querySelector('[data-header]');
    if (!header) return;
    const onScroll = () => {
        if (window.scrollY > 40) header.classList.add('shadow-lg', 'py-2');
        else header.classList.remove('shadow-lg', 'py-2');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ------------------------------- Galeri / Lightbox ----------------------- */
function initGallery() {
    // Thumbnail -> ana görsel değişimi
    document.querySelectorAll('[data-gallery]').forEach((gal) => {
        const main = gal.querySelector('[data-gallery-main]');
        gal.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => {
            thumb.addEventListener('click', () => {
                if (main) main.src = thumb.dataset.full || thumb.querySelector('img')?.src;
                gal.querySelectorAll('[data-gallery-thumb]').forEach((t) =>
                    t.classList.remove('border-gold-light')
                );
                thumb.classList.add('border-gold-light');
            });
        });
    });

    // Lightbox
    const lb = document.querySelector('[data-lightbox]');
    if (!lb) return;
    const lbImg = lb.querySelector('img');
    document.querySelectorAll('[data-lightbox-trigger]').forEach((el) => {
        el.addEventListener('click', () => {
            const src = el.dataset.full || el.querySelector('img')?.src || el.src;
            if (lbImg && src) {
                lbImg.src = src;
                lb.classList.remove('hidden');
                lb.classList.add('flex');
                track('gallery_view');
            }
        });
    });
    lb.addEventListener('click', () => {
        lb.classList.add('hidden');
        lb.classList.remove('flex');
    });
}

/* --------------------------- Event Tracking ------------------------------ */
// Meta Pixel (fbq) + GA4 (gtag) köprüsü. Panelden gelen event_mapping ile çalışır.
export function track(action, params = {}) {
    const map = window.SEKMEN_EVENTS || {};
    const cfg = map[action];
    if (!cfg || !cfg.active) return;
    try {
        if (window.fbq && cfg.meta) {
            const t = cfg.standard ? 'track' : 'trackCustom';
            window.fbq(t, cfg.meta, params);
        }
        if (window.gtag) {
            window.gtag('event', action, params);
        }
    } catch (e) {
        /* sessiz geç */
    }
}

function initTracking() {
    document.querySelectorAll('[data-track]').forEach((el) => {
        el.addEventListener('click', () => track(el.dataset.track));
    });
}

/* ------------------------------ Şifre göster ----------------------------- */
function initPasswordToggle() {
    document.querySelectorAll('[data-pw-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.pwToggle);
            if (!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
            const icon = btn.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initReveal();
    initCounters();
    initBeforeAfter();
    initAccordion();
    initMobileMenu();
    initStickyHeader();
    initGallery();
    initTracking();
    initPasswordToggle();
});

window.track = track;
