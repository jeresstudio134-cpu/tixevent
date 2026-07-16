// assets/js/script.js
// Logika interaktif TIXEVENT: autoplay jingle & countdown event yang berjalan live.

document.addEventListener('DOMContentLoaded', function () {
    initJingleAutoplay();
    initCountdown();
});

/**
 * Memulai audio jingle dari detik ke-14 dan mencoba autoplay.
 * Browser modern sering memblokir autoplay, jadi error ditangkap secara aman.
 */
function initJingleAutoplay() {
    const audio = document.getElementById('jingle');
    if (!audio) return;

    audio.addEventListener('loadedmetadata', function () {
        audio.currentTime = 14; // mulai dari detik ke-14
        audio.play().catch(function (error) {
            console.log('Autoplay diblokir oleh browser:', error);
        });
    });
}

/**
 * Menjalankan countdown menuju EVENT_DATE secara live (update tiap detik).
 * EVENT_DATE_ISO disuntikkan dari index.php lewat tag <script> inline.
 * Elemen target ditandai dengan attribute data-countdown="days|hours|minutes|seconds".
 */
function initCountdown() {
    if (typeof EVENT_DATE_ISO === 'undefined') return;

    const eventDate = new Date(EVENT_DATE_ISO);

    function setValue(unit, value) {
        const el = document.querySelector('[data-countdown="' + unit + '"]');
        if (el) el.textContent = value;
    }

    function tick() {
        let diff = Math.floor((eventDate.getTime() - Date.now()) / 1000);
        if (diff < 0) diff = 0;

        setValue('days', Math.floor(diff / 86400));
        setValue('hours', Math.floor((diff % 86400) / 3600));
        setValue('minutes', Math.floor((diff % 3600) / 60));
        setValue('seconds', diff % 60);
    }

    tick();
    setInterval(tick, 1000);
}
