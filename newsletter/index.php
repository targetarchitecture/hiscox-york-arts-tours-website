<?php
$page        = 'newsletter';
$title       = 'Newsletter — Hiscox York Arts Tours';
$description = 'Subscribe to our newsletter to receive updates about the tours and the collection.';
require '../includes/header.php';
?>


<main>

<?php require '../includes/mailchimp.php'; ?>


<!-- STAY INFORMED BOX -->
<section class="section on-dark" style="padding-top: 0;">
  <div class="container container--narrow reveal">
    <div class="price-card featured">
      <p class="label">Stay Informed</p>
      <p style="font-family: var(--font-head); font-size: 1.5rem; color: var(--gold); margin-top: 6px;">New dates announced on Facebook</p>
      <ul>
        <li>New tour dates posted as soon as they’re confirmed</li>
        <li>Dates typically announced two months in advance</li>
        <li>Tours fill quickly — worth following the Facebook page</li>
      </ul>
      <a href="https://www.facebook.com/HiscoxYorkFundraisingArtsTours" target="_blank" rel="noopener" class="btn btn--gold" style="margin-top: 24px;">
        Follow on Facebook →
      </a>
    </div>
  </div>
</section>

</main>

<?php require '../includes/footer.php'; ?>
