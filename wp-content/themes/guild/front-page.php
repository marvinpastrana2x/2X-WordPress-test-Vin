<?php
get_header();

$roster_page = get_page_by_path('team', OBJECT, 'page');
$roster_url = $roster_page instanceof WP_Post
  ? get_permalink($roster_page->ID)
  : home_url('/team/');
?>

<main class="bg-dark-blue text-white">
  <section class="py-5">
    <div class="container text-center py-md-5">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
          <h1 class="mb-4">Precision. Power. Paws.</h1>

          <p class="lead mb-4">
            The Ironclaw Syndicate provides elite, multi-realm
            feline operatives for high-stakes contracts.
            No questions asked. No scratching posts left unturned.
          </p>

          <a
            class="btn btn-cta home-roster-link"
            href="<?php echo esc_url($roster_url); ?>">
            View Operative Roster
          </a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>