<?php
/**
 * carousel.php
 * Reusable image carousel component.
 *
 * USAGE — include in any page:
 *   <?php
 *     $carousel_folder = 'images';          // folder relative to this file
 *     $carousel_json   = 'carousel.json';   // JSON manifest filename inside that folder
 *     include 'carousel.php';
 *   ?>
 *
 * JSON FORMAT (images/carousel.json):
 *   [
 *     { "filename": "photo.jpg", "caption": "Caption text here" },
 *     ...
 *   ]
 *
 * Captions are optional — omit the key or leave the value empty to show no caption.
 *
 * Folder layout expected:
 *   htdocs/
 *     carousel.php          ← this file
 *     images/
 *       carousel.json
 *       artwork1.jpg
 *       artwork2.jpg
 *       ...
 */

// ── Configuration ──────────────────────────────────────────────────────────────
// These defaults are overridden if the calling page sets them before including.

// if (!isset($carousel_folder)) $carousel_folder = 'images';
// if (!isset($carousel_json))   $carousel_json   = 'carousel.json';

// // Auto-advance interval in milliseconds (set to 0 to disable auto-advance)
// if (!isset($carousel_interval)) $carousel_interval = 0;

// ── Load and validate the JSON manifest ────────────────────────────────────────

$json_path  = rtrim($carousel_folder, '/') . '/' . $carousel_json;
$slides     = [];
$load_error = null;

if (!file_exists($json_path)) {
    $load_error = "Carousel manifest not found: <code>" . htmlspecialchars($json_path) . "</code>";
} else {
    $raw = file_get_contents($json_path);
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $load_error = "Invalid JSON in manifest: " . json_last_error_msg();
    } elseif (!is_array($data) || count($data) === 0) {
        $load_error = "Carousel manifest is empty or not an array.";
    } else {
        foreach ($data as $entry) {
            if (empty($entry['filename'])) continue;

            $img_path = rtrim($carousel_folder, '/') . '/' . $entry['filename'];

            // Only include slides whose image file actually exists on disk
            if (!file_exists($img_path)) continue;

            $slides[] = [
                'src'     => htmlspecialchars($img_path),
                'caption' => htmlspecialchars($entry['caption'] ?? ''),
                'alt'     => htmlspecialchars($entry['alt'] ?? $entry['caption'] ?? $entry['filename']),
            ];
        }

        if (count($slides) === 0) {
            $load_error = "No valid images found. Check that image files exist in <code>"
                        . htmlspecialchars($carousel_folder) . "/</code> and match the filenames in the JSON.";
        }
    }
}

// Unique ID so multiple carousels can live on the same page
$uid = 'hac_carousel_' . substr(md5($carousel_folder . $carousel_json), 0, 8);
$count = count($slides);
?>

<?php if ($load_error): ?>
<!-- Carousel error (visible only to admins / during development) -->
<div class="hac-carousel-error">
    <p>⚠ Carousel could not load: <?= $load_error ?></p>
</div>

<?php else: ?>
<!-- ═══════════════════════════════════════════════════════════════
     CAROUSEL MARKUP
     ═══════════════════════════════════════════════════════════════ -->
<div class="hac-carousel" id="<?= $uid ?>" role="region" aria-label="Image carousel" aria-roledescription="carousel">

    <!-- Track: slides scroll horizontally inside this -->
    <div class="hac-carousel__track-wrapper">
        <div class="hac-carousel__track" aria-live="polite">
            <?php foreach ($slides as $i => $slide): ?>
            <div class="hac-carousel__slide<?= $i === 0 ? ' is-active' : '' ?>"
                 role="group"
                 aria-roledescription="slide"
                 aria-label="<?= ($i + 1) ?> of <?= $count ?>"
                 aria-hidden="<?= $i === 0 ? 'false' : 'true' ?>">
                <img src="<?= $slide['src'] ?>"
                     alt="<?= $slide['alt'] ?>"
                     loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
                <?php if ($slide['caption']): ?>
                <p class="hac-carousel__caption"><?= $slide['caption'] ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if ($count > 1): ?>
    <!-- Navigation arrows -->
    <button class="hac-carousel__btn hac-carousel__btn--prev"
            aria-label="Previous slide" title="Previous">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15.5 5L8.5 12l7 7"/></svg>
    </button>
    <button class="hac-carousel__btn hac-carousel__btn--next"
            aria-label="Next slide" title="Next">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8.5 5l7 7-7 7"/></svg>
    </button>

    <!-- Dot indicators -->
    <div class="hac-carousel__dots" role="tablist" aria-label="Carousel slides">
        <?php foreach ($slides as $i => $slide): ?>
        <button class="hac-carousel__dot<?= $i === 0 ? ' is-active' : '' ?>"
                role="tab"
                aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                aria-label="Go to slide <?= ($i + 1) ?>"
                data-index="<?= $i ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div><!-- /.hac-carousel -->
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     STYLES  (injected once per page via a flag)
     ═══════════════════════════════════════════════════════════════ -->
<?php if (!defined('HAC_CAROUSEL_CSS_LOADED')): define('HAC_CAROUSEL_CSS_LOADED', true); ?>
<style>
/* ── Carousel shell ── */
.hac-carousel {
    position: relative;
    width: 100%;
    overflow: hidden;
    background: #1a1209;           /* near-black warm base */
    border-radius: 2px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.35);
    /* Colour tokens — override these in your own stylesheet */
    --hac-gold:       #c8922a;
    --hac-gold-light: #e8b84b;
    --hac-caption-bg: rgba(26,18,9,0.82);
    --hac-dot-size:   10px;
}

/* ── Track ── */
.hac-carousel__track-wrapper {
    overflow: hidden;
    width: 100%;
}
.hac-carousel__track {
    display: flex;
    transition: none;              /* JS drives this */
}

/* ── Individual slide ── */
.hac-carousel__slide {
    min-width: 100%;
    position: relative;
    display: none;                 /* hidden by default; JS fades in active */
    flex-direction: column;
}
.hac-carousel__slide.is-active {
    display: flex;
}

/* Fade transition between slides */
.hac-carousel__slide {
    animation: none;
}
.hac-carousel__slide.is-active {
    animation: hacFadeIn 0.5s ease forwards;
}
@keyframes hacFadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}
@media (prefers-reduced-motion: reduce) {
    .hac-carousel__slide.is-active { animation: none; }
}

/* ── Image ── */
.hac-carousel__slide img {
    width: 100%;
    height: auto;
    max-height: 560px;
    object-fit: cover;
    object-position: center;
    display: block;
}

/* ── Caption ── */
.hac-carousel__caption {
    background: var(--hac-caption-bg);
    color: #f0e8d6;
    margin: 0;
    padding: 0.75rem 1.25rem;
    font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
    font-style: italic;
    font-size: clamp(0.85rem, 1.5vw, 1rem);
    letter-spacing: 0.01em;
    line-height: 1.5;
    text-align: center;
    border-top: 1px solid rgba(200, 146, 42, 0.3);
}

/* ── Prev / Next buttons ── */
.hac-carousel__btn {
    position: absolute;
    top: 50%;
    transform: translateY(calc(-50% - 1.25rem)); /* offset for caption */
    z-index: 10;
    background: rgba(26,18,9,0.65);
    border: 1px solid var(--hac-gold);
    color: var(--hac-gold-light);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, border-color 0.2s;
    padding: 0;
}
.hac-carousel__btn:hover,
.hac-carousel__btn:focus-visible {
    background: var(--hac-gold);
    border-color: var(--hac-gold-light);
    outline: 2px solid var(--hac-gold-light);
    outline-offset: 2px;
}
.hac-carousel__btn--prev { left: 0.75rem; }
.hac-carousel__btn--next { right: 0.75rem; }
.hac-carousel__btn svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
}

/* No buttons on single-slide carousels (already hidden via PHP, but just in case) */
.hac-carousel--single .hac-carousel__btn { display: none; }

/* ── Dots ── */
.hac-carousel__dots {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 0.5rem;
    background: rgba(26,18,9,0.55);
}
.hac-carousel__dot {
    width: var(--hac-dot-size);
    height: var(--hac-dot-size);
    border-radius: 50%;
    border: 1.5px solid var(--hac-gold);
    background: transparent;
    cursor: pointer;
    padding: 0;
    transition: background 0.2s, transform 0.2s;
}
.hac-carousel__dot.is-active,
.hac-carousel__dot:hover {
    background: var(--hac-gold);
    transform: scale(1.25);
}
.hac-carousel__dot:focus-visible {
    outline: 2px solid var(--hac-gold-light);
    outline-offset: 3px;
}

/* ── Error state ── */
.hac-carousel-error {
    border: 1px dashed #c0392b;
    background: #fdf2f2;
    color: #c0392b;
    padding: 1rem 1.25rem;
    border-radius: 4px;
    font-family: monospace;
    font-size: 0.9rem;
}

/* ── Responsive ── */
@media (max-width: 600px) {
    .hac-carousel__btn {
        width: 36px;
        height: 36px;
    }
    .hac-carousel__btn svg { width: 14px; height: 14px; }
    .hac-carousel__btn--prev { left: 0.4rem; }
    .hac-carousel__btn--next { right: 0.4rem; }
}
</style>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════════
     JAVASCRIPT
     Each carousel initialises itself using its unique ID.
     Multiple carousels on one page are fully independent.
     ═══════════════════════════════════════════════════════════════ -->
<script>
(function () {
    'use strict';

    function initCarousel(id, totalSlides, intervalMs) {
        if (totalSlides <= 1) return;  // nothing to do for single-image carousels

        var el       = document.getElementById(id);
        if (!el) return;

        var slides   = el.querySelectorAll('.hac-carousel__slide');
        var dots     = el.querySelectorAll('.hac-carousel__dot');
        var btnPrev  = el.querySelector('.hac-carousel__btn--prev');
        var btnNext  = el.querySelector('.hac-carousel__btn--next');
        var current  = 0;
        var timer    = null;

        // ── Activate a slide by index ──────────────────────────────────────
        function goTo(index) {
            // Wrap around
            if (index < 0)            index = totalSlides - 1;
            if (index >= totalSlides) index = 0;

            // Deactivate old
            slides[current].classList.remove('is-active');
            slides[current].setAttribute('aria-hidden', 'true');
            if (dots[current]) {
                dots[current].classList.remove('is-active');
                dots[current].setAttribute('aria-selected', 'false');
            }

            // Activate new
            current = index;
            slides[current].classList.add('is-active');
            slides[current].setAttribute('aria-hidden', 'false');
            if (dots[current]) {
                dots[current].classList.add('is-active');
                dots[current].setAttribute('aria-selected', 'true');
            }
        }

        // ── Auto-advance ───────────────────────────────────────────────────
        function startTimer() {
            if (intervalMs <= 0) return;
            timer = setInterval(function () { goTo(current + 1); }, intervalMs);
        }
        function stopTimer() {
            clearInterval(timer);
        }
        function restartTimer() {
            stopTimer();
            startTimer();
        }

        // ── Button listeners ───────────────────────────────────────────────
        btnPrev.addEventListener('click', function () {
            goTo(current - 1);
            restartTimer();
        });
        btnNext.addEventListener('click', function () {
            goTo(current + 1);
            restartTimer();
        });

        // ── Dot listeners ──────────────────────────────────────────────────
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                goTo(parseInt(dot.dataset.index, 10));
                restartTimer();
            });
        });

        // ── Keyboard navigation ────────────────────────────────────────────
        el.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft')  { goTo(current - 1); restartTimer(); }
            if (e.key === 'ArrowRight') { goTo(current + 1); restartTimer(); }
        });

        // ── Touch / swipe support ──────────────────────────────────────────
        var touchStartX = null;
        el.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].clientX;
        }, { passive: true });
        el.addEventListener('touchend', function (e) {
            if (touchStartX === null) return;
            var dx = e.changedTouches[0].clientX - touchStartX;
            if (Math.abs(dx) > 40) {
                goTo(dx < 0 ? current + 1 : current - 1);
                restartTimer();
            }
            touchStartX = null;
        }, { passive: true });

        // ── Pause on hover ─────────────────────────────────────────────────
        //el.addEventListener('mouseenter', stopTimer);
        //eel.addEventListener('mouseleave', restartTimer); // Changed from startTimer to restartTimer


        // ── Pause when tab is in background ───────────────────────────────
document.addEventListener('visibilitychange', function () {
    document.hidden ? stopTimer() : restartTimer(); // Changed from startTimer to restartTimer
});

        // ── Kick off ───────────────────────────────────────────────────────
        startTimer();
        // Make the carousel focusable for keyboard users
        el.setAttribute('tabindex', '0');
    }

    // Initialise this instance once the DOM is ready
    document.addEventListener('DOMContentLoaded', function () {
        initCarousel(
            <?= json_encode($uid) ?>,
            <?= $count ?>,
            <?= (int)$carousel_interval ?>
        );
    });
})();
</script>
