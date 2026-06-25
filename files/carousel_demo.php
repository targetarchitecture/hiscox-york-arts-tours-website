<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel Demo — Hiscox York Arts Tours</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f7f0e3;
            font-family: 'Playfair Display', Georgia, serif;
            color: #2a1f0e;
        }
        h1 {
            font-family: 'Oswald', sans-serif;
            text-align: center;
            font-size: 1.5rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #c8922a;
            padding: 2rem 1rem 0.5rem;
            margin: 0;
        }
        .demo-wrapper {
            max-width: 900px;
            margin: 1.5rem auto 3rem;
            padding: 0 1rem;
        }

        /*
         * ── Customise the carousel's gold tones to match your site ───────────
         * Override these CSS custom properties anywhere in your own stylesheet.
         */
        .hac-carousel {
            --hac-gold:       #c8922a;
            --hac-gold-light: #e8b84b;
        }
    </style>
</head>
<body>

<h1>The Hiscox Collection</h1>

<div class="demo-wrapper">
    <?php
        /*
         * ── Include the carousel ─────────────────────────────────────────────
         * Set these two variables before including to control which folder
         * and JSON manifest are used.
         *
         * $carousel_folder  : path to your images folder, relative to this file
         * $carousel_json    : filename of the JSON manifest inside that folder
         * $carousel_interval: milliseconds between auto-advances (0 = disabled)
         */
        $carousel_folder   = 'images';
        $carousel_json     = 'carousel.json';
        $carousel_interval = 5000;    // 5 seconds

        include 'carousel.php';
    ?>
</div>

<!--
    To add a SECOND carousel on the same page (different folder / JSON),
    just include it again with different $carousel_folder / $carousel_json:

    <?php
        $carousel_folder = 'images/events';
        $carousel_json   = 'events.json';
        include 'carousel.php';
    ?>
-->

</body>
</html>
