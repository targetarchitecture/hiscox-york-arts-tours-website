<?php
$page        = 'video';
$title       = 'Watch the Film — Hiscox York Arts Tours';
$description = 'Watch our short film about the Hiscox York Arts Tours — a guided tour of one of York\'s finest private art collections.';
require '../includes/header.php';
?>

<style>
  .video-hero { position:relative; padding-top:88px; padding-bottom:0; overflow:hidden; }
  .video-hero-bg { position:absolute; inset:0; background-image:url('/assets/exterior-1600.jpg'); background-size:cover; background-position:center 40%; filter:brightness(.38) saturate(.8); }
  .video-hero-inner { position:relative; z-index:2; max-width:var(--maxw); margin-inline:auto; padding:60px 28px 0; }
  .video-hero h1 { font-family:var(--font-head); font-size:clamp(2rem,4vw,3.2rem); color:var(--warm); }
  .video-hero p { color:var(--warm-2); max-width:58ch; margin-top:14px; font-size:1.08rem; }
  .video-lift { position:relative; z-index:3; max-width:1040px; margin-inline:auto; padding-inline:28px; margin-top:48px; }
  .video-facade { position:relative; width:100%; aspect-ratio:16/9; border-radius:6px; overflow:hidden; cursor:pointer; box-shadow:0 40px 80px -20px rgba(0,0,0,.85); background:#0a0806; }
  .video-facade img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .6s cubic-bezier(.22,.61,.25,1), filter .4s; filter:brightness(.85); }
  .video-facade:hover img { transform:scale(1.025); filter:brightness(.7); }
  .video-facade::after { content:""; position:absolute; inset:0; background:radial-gradient(ellipse at 50% 50%, rgba(0,0,0,.18) 0%, rgba(0,0,0,.52) 100%); transition:background .3s; }
  .video-facade:hover::after { background:radial-gradient(ellipse at 50% 50%, rgba(0,0,0,.25) 0%, rgba(0,0,0,.6) 100%); }
  .play-btn { position:absolute; inset:0; z-index:2; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:18px; pointer-events:none; }
  .play-circle { width:clamp(64px,9vw,96px); height:clamp(64px,9vw,96px); border-radius:50%; background:rgba(228,160,18,.92); display:flex; align-items:center; justify-content:center; transition:transform .3s cubic-bezier(.22,.61,.25,1), background .3s; box-shadow:0 8px 32px rgba(0,0,0,.4); }
  .video-facade:hover .play-circle { transform:scale(1.1); background:rgba(245,200,66,1); }
  .play-circle svg { width:36%; height:36%; margin-left:8%; }
  .play-label { font-family:var(--font-label,monospace); font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; color:rgba(245,240,229,.8); text-shadow:0 1px 6px rgba(0,0,0,.6); transition:color .3s; }
  .video-facade:hover .play-label { color:#fff; }
  .video-facade.is-playing { cursor:default; }
  .video-facade.is-playing img, .video-facade.is-playing::after, .video-facade.is-playing .play-btn { display:none; }
  .video-facade iframe { display:none; position:absolute; inset:0; width:100%; height:100%; border:0; }
  .video-facade.is-playing iframe { display:block; }
  .video-frame-border { position:absolute; inset:0; z-index:3; pointer-events:none; box-shadow:inset 0 0 0 1px rgba(228,160,18,.22); border-radius:6px; }
  .video-meta { display:flex; gap:28px 40px; flex-wrap:wrap; align-items:center; margin-top:28px; padding-top:24px; border-top:1px solid var(--line); }
  .video-meta-item { font-family:var(--font-label); font-size:.72rem; letter-spacing:.08em; text-transform:uppercase; color:var(--warm-3); }
  .video-meta-item strong { display:block; font-size:.82rem; color:var(--warm-2); margin-bottom:3px; }
</style>

<main>

<section class="video-hero">
  <div class="video-hero-bg"></div>
  <div class="video-hero-inner">
    <h1>Watch the Film</h1>
    <p>A short film about the Hiscox York Arts Tours &mdash; the tour's history, the charities we've supported, and why a small group of volunteers keep coming back to do this every year.</p>
  </div>
</section>

<section class="on-dark" style="padding-bottom:0;">
  <div class="video-lift">
    <div class="video-facade" id="videoFacade" role="button" tabindex="0" aria-label="Play: Hiscox York Arts Tours film">
      <img src="/assets/YT Thumbnail.webp" alt="Hiscox York Arts Tours &mdash; film thumbnail" loading="lazy">
      <div class="play-btn">
        <div class="play-circle">
          <svg viewBox="0 0 24 24" fill="white"><polygon points="6,3 20,12 6,21"/></svg>
        </div>
        <span class="play-label">Play film</span>
      </div>
      <iframe title="Hiscox York Arts Tours &mdash; short film" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      <div class="video-frame-border" aria-hidden="true"></div>
    </div>

  </div>
</section>


</main>

<?php require '../includes/footer.php'; ?>
