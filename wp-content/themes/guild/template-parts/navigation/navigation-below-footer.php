<div class="d-flex flex-wrap align-items-center gap-3 mb-3">
    <?php
    wp_nav_menu([
        'theme_location' => 'below_footer',
        'menu_class' => 'list-unstyled mb-0',
        'container_class' => 'nav-pipe',
        'container_id' => 'navBelowFooter',
        'fallback_cb' => false,
    ]);
    ?>

    <p class="copy_text mb-0">
        Copyright &copy; <?php echo date('Y'); ?>
        The Ironclaw Syndicate. All rights reserved.
    </p>
</div>

<p class="fst-italic word-spacing-normal">
    Unauthorized scraping of this database will result in immediate deployment
    of a Tier 3 tracking unit. Trespassers will be scratched.
</p>