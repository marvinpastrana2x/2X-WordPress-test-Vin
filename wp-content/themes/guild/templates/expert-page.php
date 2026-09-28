<?php
/* Template Name: Expert Page */
get_header();
$id = get_the_ID();
$page = get_post($id);
?>

<section class="bg-dark-blue">
    <div class="container text-white no-pad-gutters">
        <h1 class="h3 text-uppercase mb-4"><?php echo esc_html(get_the_title($id)); ?></h1>
        <div class="row">
            <div class="col-md-8 mb-4">
                <?php echo apply_filters('the_content', $page->post_content); ?>
            </div>
        </div>

        <!--May implement the search and filter here-->
        <?php
        $industries = get_industries();
        $locations = get_locations();
        ?>

        <h2 class="fs-6 text-uppercase mb-4">Filters</h2>

        <div class="roster-filters d-flex flex-wrap align-items-center gap-3 pb-4">
            <?php
            $filter_groups = [
                [
                    'id' => 'industry-filter',
                    'label' => 'Sector',
                    'posts' => $industries,
                    'class' => 'sector-control',
                ],
                [
                    'id' => 'location-filter',
                    'label' => 'Locations',
                    'posts' => $locations,
                    'class' => '',
                ],
            ];
            ?>

            <?php foreach ($filter_groups as $filter_group) : ?>
                <div class="<?php echo esc_attr($filter_group['class']); ?>">
                    <div class="dropdown roster-dropdown">
                        <input
                            type="hidden"
                            id="<?php echo esc_attr($filter_group['id']); ?>"
                            value="">

                        <button
                            type="button"
                            id="<?php echo esc_attr($filter_group['id'] . '-toggle'); ?>"
                            class="roster-filter-toggle"
                            data-bs-toggle="dropdown"
                            data-bs-display="static"
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr($filter_group['id'] . '-menu'); ?>">
                            <span class="visually-hidden">
                                <?php echo esc_html($filter_group['label']); ?>:
                            </span>
                            <span class="filter-label">
                                <?php echo esc_html($filter_group['label']); ?>
                            </span>
                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </button>

                        <ul
                            id="<?php echo esc_attr($filter_group['id'] . '-menu'); ?>"
                            class="dropdown-menu roster-filter-menu"
                            aria-labelledby="<?php echo esc_attr($filter_group['id'] . '-toggle'); ?>">
                            <li>
                                <button
                                    type="button"
                                    class="dropdown-item"
                                    data-value=""
                                    aria-pressed="true">
                                    <?php echo esc_html($filter_group['label']); ?>
                                </button>
                            </li>

                            <?php foreach ($filter_group['posts'] as $filter_post) : ?>
                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-value="<?php echo esc_attr($filter_post->ID); ?>"
                                        aria-pressed="false">
                                        <?php echo esc_html(get_the_title($filter_post->ID)); ?>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="roster-search d-flex align-items-stretch ms-md-auto">
                <label for="expert-search" class="visually-hidden">
                    Search by name
                </label>
                <input
                    type="search"
                    id="expert-search"
                    class="form-control"
                    placeholder="Search">

                <span class="search-icon d-flex align-items-center justify-content-center"
                    aria-hidden="true">
                    <i class="fa fa-search"></i>
                </span>
            </div>
        </div>
    </div>
</section>

<!--May implement the experts profile list here-->
<div class="page-center py-5">

    <div class="container">
        <div class="row" id="expert-list">
            <?php
            // Calls the helper already supplied in functions.php. It retrieves published Expert entries.
            $experts = get_experts();
            ?>
            <?php if (!empty($experts)) : ?>
                <?php foreach ($experts as $expert) : ?>
                    <?php
                    $position = get_field('title', $expert->ID);
                    $location = get_field('location', $expert->ID);
                    $profile_image = get_field('profile_image', $expert->ID);
                    $profile_url = get_permalink($expert->ID);
                    $email = get_field('email', $expert->ID);
                    $phone = get_field('contact_no', $expert->ID);
                    $linkedin = get_field('linkedin', $expert->ID);
                    $expert_industries = get_field('industry_expertise', $expert->ID);
                    $industry_ids = [];

                    if (is_array($expert_industries)) {
                        foreach ($expert_industries as $expert_industry) {
                            if ($expert_industry instanceof WP_Post) {
                                $industry_ids[] = (string) $expert_industry->ID;
                            }
                        }
                    }

                    $location_id = $location instanceof WP_Post
                        ? $location->ID
                        : '';
                    ?>

                    <div
                        class="col-md-4 mb-5 expert-card text-center"
                        data-name="<?php echo esc_attr(get_the_title($expert->ID)); ?>"
                        data-location="<?php echo esc_attr($location_id); ?>"
                        data-industries="<?php echo esc_attr(implode(',', $industry_ids)); ?>">
                        <a href="<?php echo esc_url($profile_url); ?>"
                            class="d-inline-block"
                            aria-label="<?php echo esc_attr('View profile for ' . get_the_title($expert->ID)); ?>">

                            <?php if (is_array($profile_image) && !empty($profile_image['ID'])) : ?>
                                <?php
                                echo wp_get_attachment_image(
                                    (int) $profile_image['ID'],
                                    'medium',
                                    false,
                                    [
                                        'class' => 'rounded-circle mb-3',
                                        'style' => 'width: 200px; height: 200px; object-fit: cover;'
                                    ]
                                );
                                ?>
                            <?php else : ?>
                                <div class="bg-light text-dark text-center p-4 mb-3"></div>
                            <?php endif; ?>

                        </a>
                        <h2 class="fs-6 mb-1">
                            <a class="expert-name" href="<?php echo esc_url($profile_url); ?>">
                                <?php echo esc_html(get_the_title($expert->ID)); ?>
                            </a>
                        </h2>

                        <?php if ($position) : ?>
                            <p class="mb-1">
                                <?php echo esc_html($position); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($location instanceof WP_Post) : ?>
                            <p class="fst-italic mb-0">
                                <?php echo esc_html($location->post_title); ?>
                            </p>
                        <?php endif; ?>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <?php if ($email) : ?>
                                <a href="<?php echo esc_url('mailto:' . sanitize_email($email)); ?>"
                                    class="btn btn-success rounded-circle d-inline-flex align-items-center justify-content-center p-0"
                                    style="width: 40px; height: 40px;"
                                    aria-label="<?php echo esc_attr('Email ' . get_the_title($expert->ID)); ?>">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ($phone) : ?>
                                <a href="<?php echo esc_url('tel:' . preg_replace('/[^0-9+]/', '', $phone)); ?>"
                                    class="btn btn-success rounded-circle d-inline-flex align-items-center justify-content-center p-0"
                                    style="width: 40px; height: 40px;"
                                    aria-label="<?php echo esc_attr('Call ' . get_the_title($expert->ID)); ?>">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ($linkedin) : ?>
                                <a href="<?php echo esc_url($linkedin); ?>"
                                    class="btn btn-success rounded-circle d-inline-flex align-items-center justify-content-center p-0"
                                    style="width: 40px; height: 40px;"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="<?php echo esc_attr('LinkedIn profile for ' . get_the_title($expert->ID)); ?>">
                                    <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No operatives available yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>