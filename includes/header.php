<?php
/**
 * includes/header.php
 * Shared page header. Expects these variables to be set by the including page:
 *   $page        — string key: 'home' | 'video' | 'visit'
 *   $title       — <title> tag content
 *   $description — <meta description> content
 */
$title       = $title       ?? 'Hiscox York Arts Tours';
$description = $description ?? 'Volunteer-led guided tours of the Hiscox art collection in York — raising money for York charities since 2018.';
$page        = $page        ?? '';

$nav = [
    'home'       => ['index.php',      'Home',  '_self'],
    'video'      => ['video.php',      'Film',  '_self'],
    'newsletter' => ['newsletter.php', 'Newsletter', '_self'],
    // 'visit'      => ['https://www.ticketsource.com/hiscox-arts-tours',      'Book Your Place', '_blank'],    
];

function navClass(string $key, string $current): string {
    return $current === $key ? ' class="active"' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title) ?></title>
<meta name="description" content="<?= htmlspecialchars($description) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Source+Serif+4:ital,wght@0,400;1,400&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="styles.css">
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HH7E8X5S3D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HH7E8X5S3D');
</script>
<body data-page="<?= htmlspecialchars($page) ?>">

<header class="site-header" id="siteHeader">
  <div class="header-inner">
    <a class="brand" href="/">
      <img src="assets/logo.svg" height="30" />
      <span class="brand-name">Hiscox York Arts Tours</br>RAISING MONEY FOR YORK CHARITIES</span>   
    </a>
      <a href="https://www.ticketsource.com/hiscox-arts-tours" target="_blank" class="brand btn btn--gold btn--sm">Book your place</a>
    <nav class="site-nav" id="siteNav" role="navigation" aria-label="Main navigation">
<?php foreach ($nav as $key => [$href, $label, $target]): ?>
      <a href="<?= $href ?>"<?= navClass($key, $page) ?> target="<?= $target ?>"><?= htmlspecialchars($label) ?></a>
<?php endforeach; ?>

    </nav>
           <!-- <a href="https://www.ticketsource.com/hiscox-arts-tours" target="_blank" class="btn btn--gold btn--sm">Book your place</a> -->
    <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="siteNav" aria-label="Open navigation">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>
