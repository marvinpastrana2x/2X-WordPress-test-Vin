<?php
/*
Template Post Type: expert
*/
get_header();

$id = get_queried_object_id();
$expert = get_expert($id);

$profile_image = get_field('profile_image', $id);
$position = get_field('title', $id);
$location = get_field('location', $id);
$industry_expertises = get_field('industry_expertise', $id);
$email = get_field('email', $id);
$phone = get_field('contact_no', $id);
$linkedin = get_field('linkedin', $id);

if (!is_array($industry_expertises)) {
    $industry_expertises = [];
}

$teams_page = get_page_by_path('team', OBJECT, 'page');
$teams_page_url = $teams_page instanceof WP_Post
    ? get_permalink($teams_page->ID)
    : home_url('/team/');
?>


<section>
    <div class="container no-pad-gutters">
        <div class="back mb-4 mb-md-5">
            <i class="fa fa-caret-left align-bottom" style="font-size: 22px;" aria-hidden="true"></i> <a
                href="<?php echo esc_url($teams_page_url); ?>" class="btn-outline-success text-uppercase px-0 ml-2">Back to team</a>
        </div>
        <!--May implement the expert's profile here -->
        <div class="row">
            <div class="col-md-4 team-left">
                <div class="team-bg-img">
                    <?php if (is_array($profile_image) && !empty($profile_image['ID'])) : ?>
                        <?php
                        echo wp_get_attachment_image(
                            (int) $profile_image['ID'],
                            'full',
                            false,
                            ['class' => 'single-expert-img img-fluid']
                        );
                        ?>
                    <?php else : ?>
                        <div class="bg-light text-dark text-center p-5"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-8 team-right">
                <div class="profile-title">
                    <h1><?php echo esc_html(get_the_title($id)); ?></h1>
                </div>

                <?php if ($position) : ?>
                    <div class="profile-designation">
                        <p><?php echo esc_html($position); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($location instanceof WP_Post) : ?>
                    <div class="city-title">
                        <p>
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <?php echo esc_html($location->post_title); ?>
                        </p>
                    </div>
                <?php endif; ?>
                <div class="social-icon">
                    <ul class="experts-socials list-unstyled d-flex gap-2 my-3">
                        <?php if ($email) : ?>
                            <li>
                                <a
                                    class="btn btn-success rounded-circle d-inline-flex align-items-center justify-content-center p-0"
                                    style="width: 40px; height: 40px;"
                                    href="<?php echo esc_url('mailto:' . sanitize_email($email)); ?>"
                                    aria-label="<?php echo esc_attr('Email ' . get_the_title($id)); ?>">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($phone) : ?>
                            <li>
                                <a
                                    class="btn btn-success rounded-circle d-inline-flex align-items-center justify-content-center p-0"
                                    style="width: 40px; height: 40px;"
                                    href="<?php echo esc_url('tel:' . preg_replace('/[^0-9+]/', '', $phone)); ?>"
                                    aria-label="<?php echo esc_attr('Call ' . get_the_title($id)); ?>">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($linkedin) : ?>
                            <li>
                                <a
                                    class="btn btn-success rounded-circle d-inline-flex align-items-center justify-content-center p-0"
                                    style="width: 40px; height: 40px;"
                                    href="<?php echo esc_url($linkedin); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="<?php echo esc_attr('LinkedIn profile for ' . get_the_title($id) . ' (opens in a new tab)'); ?>">
                                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="team-profile-con">
                    <?php echo apply_filters('the_content', $expert->post_content); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="text-bg-dark py-5 px-3 px-md-5">
    <div class="container no-pad-gutters">
        <h2 class="text-white text-center pb-5">Industry Expertise</h2>
        <div class="row justify-content-center align-items-center">
            <?php foreach ($industry_expertises as $expertise) : ?>
                <div class="col-12 col-md-6 industry_icon text-center mb-4">
                    <?php
                    $icon = get_field('icon', $expertise->ID);
                    $icon_id = attachment_url_to_postid($icon);
                    $expertise_name = get_the_title($expertise->ID);
                    echo wp_get_attachment_image(
                        $icon_id,
                        'full',
                        false,
                        [
                            "loading" => "lazy",
                            "alt" => esc_attr($expertise_name),
                            'class' => 'img-fluid'
                        ]
                    );
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
get_footer();
