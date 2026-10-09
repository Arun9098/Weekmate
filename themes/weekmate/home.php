<?php

/**
 * Blog Archive / Posts Page
 */
get_header();

// ACF Blog Page fields
$blog_page = get_field('blog_page', 'option');
$colorClasses = [
    "light-mint-bg-clr",
    "soft-peach-bg-clr",
    "light-ivory-bg-clr",
    "sky-blue-bg-clr",
    "lavender-mist-bg-clr",
    "off-white-bg-clr",
    "light-lavender-bg-clr"
];

?>

<?php
$wm_search_query = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';
$wm_latest_articles = new WP_Query([
    'post_type'           => 'post',
    'posts_per_page'      => 5,
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
]);
if ($wm_latest_articles->have_posts()) :
    $wm_posts = $wm_latest_articles->posts;
    // First post = featured article
    $wm_featured_post = $wm_posts[0];
    if (!empty($wm_search_query)) {
        $wm_search_results = new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => 4,
            'post_status'         => 'publish',
            's'                   => $wm_search_query,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
            'post__not_in'        => [
                $wm_featured_post->ID
            ],
        ]);
        $wm_side_posts = $wm_search_results->posts;
    } else {
        $wm_side_posts = array_slice($wm_posts, 1);
    }
?>
<!-- LATEST ARTICLES SECTION -->
<section class="wm-latest-articles sectionCvr">
    <!-- =====================================================
         TOP HEADER / SEARCH
    ====================================================== -->
    <div class="wm-latest-articles-searchbar container">
        <form
            id="wp-latest-article-search-form-id"
            class="wm-latest-article-search-form"
            method="get"
            action=""
        >
            <h2 class="wm-latest-articles-search-title">
                Featured Blog
            </h2>
            <div class="wm-latest-article-search-section">
                <button type="submit" class="btn btn-primary" id="latest-aritcle-all-btn">All Blogs</button>
            </div>
        </form>
    </div>
    <!-- =====================================================
         ARTICLES GRID
    ====================================================== -->
    <div class="wm-latest-articles__container container">
        <!-- =================================================
             FEATURED ARTICLE
        ================================================== -->
        <article class="wm-latest-articles__featured">
            <?php
            $featured_id = $wm_featured_post->ID;
            $featured_image = get_the_post_thumbnail_url($featured_id, 'large');
            $featured_categories = get_the_category($featured_id);
            $featured_author_id = get_post_field('post_author', $featured_id);
            $featured_permalink = get_permalink($featured_id);
            ?>
            <?php if ($featured_image) : ?>
                <a
                    class="wm-latest-articles__featured-image"
                    href="<?php echo esc_url($featured_permalink); ?>"
                >
                    <img
                        src="<?php echo esc_url($featured_image); ?>"
                        alt="<?php echo esc_attr(get_the_title($featured_id)); ?>"
                        loading="eager"
                    >
                </a>
            <?php endif; ?>
            <div class="wm-latest-articles__featured-content">
                <!-- Category -->
                <?php if (!empty($featured_categories)) : ?>

                    <div class="wm-latest-articles__category">
                        <?php echo esc_html($featured_categories[0]->name); ?>
                    </div>
                <?php endif; ?>
                <!-- Title -->
                <h2 class="wm-latest-articles__featured-title">
                    <a href="<?php echo esc_url($featured_permalink); ?>">
                        <?php echo esc_html(get_the_title($featured_id)); ?>
                    </a>
                </h2>
                <!-- Excerpt -->
                <div class="wm-latest-articles__excerpt">
                    <?php
                    echo esc_html(wp_trim_words(get_the_excerpt($featured_id), 24, '...'));
                    ?>
                </div>
                <!-- Footer -->
                <div class="wm-latest-articles__featured-footer">
                    <div class="wm-latest-articles__meta">
                        <?php
                        echo get_avatar($featured_author_id, 28, '', '', ['class' => 'wm-latest-articles__avatar']);
                        ?>
                        <span>
                            <?php
                            echo esc_html(get_the_author_meta('display_name', $featured_author_id));?>
                        </span>
                        <span class="wm-latest-articles__separator">
                            •
                        </span>
                        <span>
                            <?php
                            echo esc_html(
                                get_the_date(
                                    'M d, Y',
                                    $featured_id
                                )
                            );
                            ?>
                        </span>
                        <span class="wm-latest-articles__separator">•</span>
                        <span>
                            <?php
                            $reading_time = do_shortcode(
                                '[rt_reading_time label="" postfix="Min Read Time" postfix_singular="Min Read Time" post_id="' . absint($featured_id) . '"]'
                            );
                            echo esc_html(str_replace('< 1', '1', wp_strip_all_tags($reading_time)));?>
                        </span>
                    </div>
                    <a
                        class="btn btn-primary"
                        href="<?php echo esc_url($featured_permalink); ?>"
                    >
                        Read Blog
                    </a>
                </div>
            </div>
        </article>
        <!-- =================================================
             RIGHT SIDE / LATEST ARTICLES
        ================================================== -->
        <aside class="wm-latest-articles__sidebar">
            <div class="wm-latest-articles__sidebar-header">
                        Latest Blogs
            </div>
            <div class="wm-latest-articles__list">
                <?php foreach ($wm_side_posts as $wm_post) : ?>
                    <?php
                        $post_id = $wm_post->ID;
                        $post_image = get_the_post_thumbnail_url($post_id, 'medium');
                        $categories = get_the_category($post_id);
                        $author_id = get_post_field('post_author', $post_id);
                        $post_permalink = get_permalink($post_id);
                    ?>
                    <article class="wm-latest-articles__item">
                        <!-- Thumbnail -->
                        <a
                            class="wm-latest-articles__item-image"
                            href="<?php echo esc_url($post_permalink); ?>"
                        >
                            <?php if ($post_image) : ?>
                                <img
                                    src="<?php echo esc_url($post_image); ?>"
                                    alt="<?php echo esc_attr(get_the_title($post_id)); ?>"
                                    loading="lazy"
                                >
                            <?php endif; ?>
                        </a>
                        <!-- Content -->
                        <div class="wm-latest-articles__item-content">
                            <!-- Category -->
                            <?php if (!empty($categories)) : ?>
                                <div class="wm-latest-articles__category">
                                    <?php echo esc_html($categories[0]->name);?>
                                </div>
                            <?php endif; ?>
                            <!-- Title -->
                            <h3 class="wm-latest-articles__item-title">
                                <a href="<?php echo esc_url($post_permalink); ?>">
                                    <?php echo esc_html(get_the_title($post_id));?>
                                </a>
                            </h3>
                            <!-- Meta -->
                            <div class="wm-latest-articles__meta">
                                <span>
                                    <?php echo esc_html(get_the_author_meta('display_name', $author_id));?>                    </span>
                                <span>•</span>
                                <span>
                                    <?php echo esc_html(get_the_date('M d, Y', $post_id));?>
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>
</section>
<?php
endif;
wp_reset_postdata();
?>





<!-- 📑 Blog Listing -->
<section class="blog-listing sectionCvr" id="all-blogs">
    <!-- 🔎 Search + Filter -->
    <div class="blog-search-filter">
        <div class="container">
            <div class="row align-items-center blog-page-main-archive-page">
                <div class="col-12 blog-page-main-title">
                    <div class="title-block-wrapper title-block ">
                        <h2 class="title h1">Our Blog</h2>
                    </div>
                </div>
                <div class="col-12 blog-page-main-search">
                    <div class="blog-tabs">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy'   => 'category',
                            'hide_empty' => false,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'exclude'    => array(66,1),
                        ));

                        $visible_tabs = 8;
                        $terms = array_slice($categories, 0, $visible_tabs);
                        $terms_drop = array_slice($categories, $visible_tabs);
                        ?>

                        <ul class="nav nav-tabs-main d-none d-lg-flex" id="nav-tabs-main">
                            <li class="nav-item">
                                <a class="nav-link active" data-cat="0" data-toggle="tab" href="#all">
                                    All Blogs
                                </a>
                            </li>

                            <?php foreach ($terms as $term) : ?>
                               
                                <li class="nav-item">
                                    <a class="nav-link"
                                        data-toggle="tab"
                                        data-cat="<?php echo esc_attr($term->term_id); ?>"
                                        href="#<?php echo esc_attr($term->slug); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                            <?php if (!empty($terms_drop)) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle-bar"
                                        data-toggle="dropdown"
                                        href="#">
                                        More
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php foreach ($terms_drop as $term) : ?>
                                            <a class="dropdown-item"
                                                data-toggle="tab"
                                                href="#<?php echo esc_attr($term->slug); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                            <div class="nav-tabs-mobile d-lg-none dropdown" id="nav-tabs-mobile">
                                <a class="mobile-dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="mobile-selected-text">All Category</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item active" data-toggle="tab" href="#all">All Category</a>

                                    <?php foreach ($terms as $term) : ?>
                                        <a class="dropdown-item" data-toggle="tab" href="#<?php echo esc_attr($term->slug); ?>">
                                            <?php echo esc_html($term->name); ?>
                                        </a>
                                    <?php endforeach; ?>

                                    <?php foreach ($terms_drop as $term) : ?>
                                        <a class="dropdown-item" data-toggle="tab" href="#<?php echo esc_attr($term->slug); ?>">
                                            <?php echo esc_html($term->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                    </div>

                    <form id="blog-filter-form" class="weekmate-blog-search-form" method="get">
                        <div class="weekmate-blog-search">

                        <span class="weekmate-blog-search__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21L15.8 15.8M18 11C18 14.866 14.866 18 11 18C7.134 18 4 14.866 4 11C4 7.134 7.134 4 11 4C14.866 4 18 7.134 18 11Z"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </span>

                        <input
                            type="search"
                            name="s"
                            id="blog-search"
                            class="weekmate-blog-search__input"
                            placeholder="Search blogs..."
                            value="<?php echo esc_attr(get_search_query()); ?>"
                        >

                        <input type="hidden" name="post_type" value="post">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        
        <div id="blog-posts" class="blog-grid-wrapper">
            
            <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'paged'          => $paged,
                'cat'            => '-11'
            );
            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()) {
                $i = 0; // counter

                echo '<div class="blog-grid">';
                while ($blog_query->have_posts()) {
                    $blog_query->the_post();
                    // $classIndex   = $i % count($colorClasses);
                    // $currentClass = $colorClasses[$classIndex];

            ?>
                    <div class="blog-grid-item">
                        <article class="blog-card">
                            <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="blog-featured-hero">
                                    <!-- Blue background -->
                                    <div class="blog-featured-hero__bg">
                                        <!-- Left content -->
                                        <div class="blog-featured-hero__info">
                                        <div class="blog-featured-hero__logo">
                                            <img
                                                src="https://weekmate.in/wp-content/uploads/2026/09/Weekmate-Logo.svg"
                                                alt="WeekMate"
                                            >
                                        </div>
                                         <p class="blog-featured-hero__title">
                                            <?php
                                            $hero_title = get_field('post_featured_image_title');
                                            if ($hero_title) {
                                                echo esc_html($hero_title);
                                            }?>
                                        </p>
                                        </div>
                                        <!-- Right featured image -->
                                        <div class="blog-featured-hero__image">
                                            <?php the_post_thumbnail('large', array('class' => 'blog-featured-hero__img'));?>
                                        </div>
                                    </div>

                                </div>
                            <?php endif; ?>
                                <div class="blog-content">
                                    <div class="blog-category-and-readtime">
                                        <p class="blog-category">
                                        <?php
                                        $categories = get_the_category();

                                        if (!empty($categories)) {
                                            echo esc_html($categories[0]->name);
                                        }
                                        ?>
                                        </p>
                                      <span class="blog-readtime">
                                        <span class="blog-readtime-clock-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M10.3725 10.1325C10.7218 10.2489 11.0993 10.0601 11.2158 9.71082C11.3322 9.36152 11.1434 8.98398 10.7941 8.86754L10.5833 9.5L10.3725 10.1325ZM8.33331 8.75H7.66665C7.66665 9.03695 7.85027 9.29171 8.12249 9.38246L8.33331 8.75ZM8.99998 5.61391C8.99998 5.24572 8.7015 4.94725 8.33331 4.94725C7.96512 4.94725 7.66665 5.24572 7.66665 5.61391H8.33331H8.99998ZM10.5833 9.5L10.7941 8.86754L8.54413 8.11754L8.33331 8.75L8.12249 9.38246L10.3725 10.1325L10.5833 9.5ZM8.33331 8.75H8.99998V5.61391H8.33331H7.66665V8.75H8.33331ZM14.3333 8H13.6666C13.6666 10.9455 11.2788 13.3333 8.33331 13.3333V14V14.6667C12.0152 14.6667 15 11.6819 15 8H14.3333ZM8.33331 14V13.3333C5.38779 13.3333 2.99998 10.9455 2.99998 8H2.33331H1.66665C1.66665 11.6819 4.65141 14.6667 8.33331 14.6667V14ZM2.33331 8H2.99998C2.99998 5.05448 5.38779 2.66667 8.33331 2.66667V2V1.33333C4.65141 1.33333 1.66665 4.3181 1.66665 8H2.33331ZM8.33331 2V2.66667C11.2788 2.66667 13.6666 5.05448 13.6666 8H14.3333H15C15 4.3181 12.0152 1.33333 8.33331 1.33333V2Z" fill="#5A6781"></path>
                                            </svg>
                                        </span>
                                        <?php
                                            $post_id = get_the_ID();
                                            $reading_time = do_shortcode(
                                                '[rt_reading_time label="" postfix="Min Read Time" postfix_singular="Min Read Time" post_id="' . absint($post_id) . '"]'
                                            );
                                            echo str_replace('< 1', '1', $reading_time);
                                        ?>
                                        </span>
                                    </div>
                                    <div class="blog-content-title">
                                        <h2 class="blog-title text-18"><?php the_title(); ?></h2>

                                    </div>
                                   <p class="blog-excerpt">
                                        <?php
                                            $excerpt = get_the_excerpt();
                                            $words = wp_trim_words($excerpt, 15);
                                            echo $words;
                                        ?>
                                    </p>
                                <p class="blog-meta">
                                    <!-- Author -->
                                    <span class="blog-meta__item">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 16 16"
                                                fill="none"
                                                aria-hidden="true">
                                            <path
                                                d="M8.00004 7.99935C9.4728 7.99935 10.6667 6.80544 10.6667 5.33268C10.6667 3.85992 9.4728 2.66602 8.00004 2.66602C6.52728 2.66602 5.33337 3.85992 5.33337 5.33268C5.33337 6.80544 6.52728 7.99935 8.00004 7.99935Z"
                                                stroke="#5A6781"
                                                stroke-width="1.33333"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                            <path
                                                d="M2.66663 14C2.66663 11.3333 5.33329 10 7.99996 10C10.6666 10 13.3333 11.3333 13.3333 14"
                                                stroke="#5A6781"
                                                stroke-width="1.33333"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>

                                        <span>
                                            <?php echo esc_html(get_the_author()); ?>
                                        </span>
                                    </span>

                                    <!-- Date -->
                                    <span class="blog-meta__item">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 16 16"
                                                fill="none"
                                                aria-hidden="true">
                                            <path
                                                d="M12.6667 3.33398H3.33333C2.59695 3.33398 2 3.93094 2 4.66732V12.6673C2 13.4037 2.59695 14.0007 3.33333 14.0007H12.6667C13.403 14.0007 14 13.4037 14 12.6673V4.66732C14 3.93094 13.403 3.33398 12.6667 3.33398Z"
                                                stroke="#5A6781"
                                                stroke-width="1.33333"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                            <path
                                                d="M2 6.66667H14M5.33333 2V4.66667M10.6667 2V4.66667"
                                                stroke="#5A6781"
                                                stroke-width="1.33333"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>

                                        <span>
                                            <?php echo esc_html(get_the_date('d F, Y')); ?>
                                        </span>
                                    </span>

                                </p>
                                </div>
                            </a>
                        </article>
                    </div>
            <?php
                    $i++;
                }
                echo '</div>';
            } else {
                echo '<p>No posts found.</p>';
            }
            if ($blog_query->max_num_pages > $paged) {
            ?>
                <div id="load-more-wrapper" class="text-center mt-4">
                    <button
                        id="load-more"
                        class="btn btn-primary"
                        data-page="<?php echo $paged + 1; ?>"
                        data-max="<?php echo $blog_query->max_num_pages; ?>">
                        Load More
                    </button>
                </div>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<!-- CTA Section -->

<?php
/**
 * Blog CTA Section
 */

$wm_blog_page_id = get_option('page_for_posts');

/**
 * CTA Fields
 */
$wm_blog_cta_background_image = get_field('wm_blog_cta_background_image', $wm_blog_page_id);
$wm_blog_cta_card_1_image = get_field('wm_blog_cta_card_1_image', $wm_blog_page_id);
$wm_blog_cta_card_2_image = get_field('wm_blog_cta_card_2_image', $wm_blog_page_id);
$wm_blog_cta_card_3_image = get_field('wm_blog_cta_card_3_image', $wm_blog_page_id);
$wm_blog_cta_heading = get_field('wm_blog_cta_heading', $wm_blog_page_id);
$wm_blog_cta_description = get_field('wm_blog_cta_description', $wm_blog_page_id);
$wm_blog_cta_button = get_field('wm_blog_cta_button', $wm_blog_page_id);
$wm_blog_cta_watch_demo = get_field('watch_demo', $wm_blog_page_id);
/**
 * Button 1
 */
$wm_blog_cta_button_url = $wm_blog_cta_button['url'] ?? '';
$wm_blog_cta_button_title = $wm_blog_cta_button['title'] ?? '';
$wm_blog_cta_button_target = $wm_blog_cta_button['target'] ?? '_self';
/**
 * Button 2
 */
$wm_blog_cta_watch_demo_url = $wm_blog_cta_watch_demo['url'] ?? '';
$wm_blog_cta_watch_demo_title = $wm_blog_cta_watch_demo['title'] ?? 'Watch Demo';
$wm_blog_cta_watch_demo_target = $wm_blog_cta_watch_demo['target'] ?? '_self';
/**
 * Show CTA only when there is CTA content/image.
 */
if (
    $wm_blog_cta_heading ||
    $wm_blog_cta_description ||
    $wm_blog_cta_button ||
    $wm_blog_cta_watch_demo ||
    $wm_blog_cta_card_1_image ||
    $wm_blog_cta_card_2_image ||
    $wm_blog_cta_card_3_image
) :
?>
<section
    class="Wm-blog-cta-section container"
    <?php if ($wm_blog_cta_background_image) : ?>
        style="background-image: url('<?php echo esc_url($wm_blog_cta_background_image); ?>');"
    <?php endif; ?>
>
    <div class="Wm-blog-cta-section__container">
        <!-- =========================
             LEFT CONTENT
        ========================== -->
        <div class="Wm-blog-cta-section__content">

            <?php if ($wm_blog_cta_heading) : ?>
                <h2 class="Wm-blog-cta-section__heading">
                    <?php echo esc_html($wm_blog_cta_heading); ?>
                </h2>
            <?php endif; ?>
            <?php if ($wm_blog_cta_description) : ?>
                <div class="Wm-blog-cta-section__description">
                    <?php echo wp_kses_post($wm_blog_cta_description); ?>
                </div>
            <?php endif; ?>
            <!-- CTA BUTTONS -->
            <?php if (
                ($wm_blog_cta_button_url && $wm_blog_cta_button_title) ||
                ($wm_blog_cta_watch_demo_url && $wm_blog_cta_watch_demo_title)
            ) : ?>
                <div class="Wm-blog-cta-section__buttons">
                    <?php if ($wm_blog_cta_button_url && $wm_blog_cta_button_title) : ?>
                        <a
                            class="Wm-blog-cta-section__button Wm-blog-cta-section__button--primary"
                            href="<?php echo esc_url($wm_blog_cta_button_url); ?>"
                            target="<?php echo esc_attr($wm_blog_cta_button_target); ?>"
                            <?php if ($wm_blog_cta_button_target === '_blank') : ?>
                                rel="noopener noreferrer"
                            <?php endif; ?>
                        >
                            <?php echo esc_html($wm_blog_cta_button_title); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($wm_blog_cta_watch_demo_url && $wm_blog_cta_watch_demo_title) : ?>
                        <a
                            class="Wm-blog-cta-section__button Wm-blog-cta-section__button--secondary"
                            href="<?php echo esc_url($wm_blog_cta_watch_demo_url); ?>"
                            target="<?php echo esc_attr($wm_blog_cta_watch_demo_target); ?>"
                            <?php if ($wm_blog_cta_watch_demo_target === '_blank') : ?>
                                rel="noopener noreferrer"
                            <?php endif; ?>
                        >
                            <?php echo esc_html($wm_blog_cta_watch_demo_title); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- =========================
             RIGHT VISUAL CARDS
        ========================== -->
        <div class="Wm-blog-cta-section__visuals">
            <?php if ($wm_blog_cta_card_1_image) : ?>
                <div class="Wm-blog-cta-section__card Wm-blog-cta-section__card--one">
                    <img
                        src="<?php echo esc_url($wm_blog_cta_card_1_image); ?>"
                        alt="Lead status"
                        loading="lazy"
                    >
                </div>
            <?php endif; ?>
            <?php if ($wm_blog_cta_card_2_image) : ?>
                <div class="Wm-blog-cta-section__card Wm-blog-cta-section__card--two">
                    <img
                        src="<?php echo esc_url($wm_blog_cta_card_2_image); ?>"
                        alt="Leave approval"
                        loading="lazy"
                    >
                </div>
            <?php endif; ?>
            <?php if ($wm_blog_cta_card_3_image) : ?>
                <div class="Wm-blog-cta-section__card Wm-blog-cta-section__card--three">
                    <img
                        src="<?php echo esc_url($wm_blog_cta_card_3_image); ?>"
                        alt="Team attendance"
                        loading="lazy"
                    >
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- Video Section -->
<?php
$wm_blog_page_id = get_option('page_for_posts');
$wm_top_videos_heading = get_field('wm_top_videos_heading', $wm_blog_page_id);
$wm_top_videos_featured_url = get_field('wm_top_videos_featured_url', $wm_blog_page_id);
$wm_top_videos_right_videos = get_field('wm_top_videos_right_videos', $wm_blog_page_id);
$wm_top_videos_watch_more_button = get_field('wm_top_videos_watch_more', $wm_blog_page_id);
/**
 * Get YouTube Video ID
 */
if (!function_exists('wm_get_youtube_video_id')) {
    function wm_get_youtube_video_id($url)
    {
        if (empty($url)) {
            return '';
        }
        $patterns = array('/youtube\.com\/watch\?v=([^&]+)/i','/youtube\.com\/embed\/([^?&]+)/i','/youtube\.com\/shorts\/([^?&]+)/i','/youtu\.be\/([^?&]+)/i');
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        return '';
    }
}
$wm_featured_video_id = wm_get_youtube_video_id($wm_top_videos_featured_url); ?>
<?php if ($wm_top_videos_heading || $wm_featured_video_id || !empty($wm_top_videos_right_videos)) : ?>
<section class="Wm-top-videos-section container sectionCvr">
    <div class="Wm-top-videos-section__container">
        <div class="Wm-top-videos-section__header">
            <?php if ($wm_top_videos_heading) : ?>
                <h2 class="Wm-top-videos-section__heading">
                    <?php echo esc_html($wm_top_videos_heading); ?>
                </h2>
            <?php endif; ?>
            <?php if ($wm_top_videos_watch_more_button) : ?>
                <?php
                $wm_top_videos_watch_more_button_url = $wm_top_videos_watch_more_button['url'] ?? '';
                $wm_top_videos_watch_more_button_title = $wm_top_videos_watch_more_button['title'] ?? '';
                ?>
                <a
                    class="btn btn-primary"
                    target="_blank"
                    href="<?php echo esc_url($wm_top_videos_watch_more_button_url); ?>"
                >
                    <span><?php echo esc_html($wm_top_videos_watch_more_button_title); ?></span>
                    <span  class="Wm-top-videos-section__watch-more-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <rect width="20" height="20" rx="10" fill="white"/>
                        <path d="M8.03128 5.82227V14.1749L14.5941 9.99858L8.03128 5.82227Z" fill="#005383"/>
                        </svg>
                    </span>
                </a>
            <?php endif; ?>
        </div>
        <!-- =============================================
             VIDEO GRID
        ============================================== -->
        <div class="Wm-top-videos-section__videos">
            <!-- =========================================
                 FEATURED VIDEO
            ========================================== -->
            <?php if ($wm_featured_video_id) : ?>
                <div class="Wm-top-videos-section__featured">
                    <a
                        class="Wm-top-videos-section__featured-link"
                        href="<?php echo esc_url($wm_top_videos_featured_url); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Watch featured video"
                    >
                        <img
                            class="Wm-top-videos-section__featured-image"
                            src="https://img.youtube.com/vi/<?php echo esc_attr($wm_featured_video_id); ?>/maxresdefault.jpg"
                            alt="Featured video"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='https://img.youtube.com/vi/<?php echo esc_attr($wm_featured_video_id); ?>/hqdefault.jpg';"
                        >
                        <span class="Wm-top-videos-section__featured-play" aria-hidden="true">
                            <span class="Wm-top-videos-section__play-icon"></span>
                        </span>
                    </a>
                </div>
            <?php endif; ?>
            <!-- =========================================
                 RIGHT VIDEO LIST
            ========================================= -->
            <?php if (!empty($wm_top_videos_right_videos)) : ?>
                <div class="Wm-top-videos-section__list">
                    <?php foreach (
                        $wm_top_videos_right_videos as $wm_video
                    ) : ?>
                        <?php
                        $wm_video_url = $wm_video['wm_top_video_url'] ?? '';
                        $wm_video_title = $wm_video['wm_top_video_title'] ?? '';
                        $wm_video_id = wm_get_youtube_video_id(
                            $wm_video_url
                        );
                        ?>
                        <?php if ($wm_video_id) : ?>
                            <article class="Wm-top-videos-section__item">
                                <a
                                    class="Wm-top-videos-section__item-link"
                                    href="<?php echo esc_url($wm_video_url); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <!-- Thumbnail -->
                                    <div class="Wm-top-videos-section__item-thumbnail">
                                        <img
                                            src="https://img.youtube.com/vi/<?php echo esc_attr($wm_video_id); ?>/hqdefault.jpg"
                                            alt="<?php echo esc_attr($wm_video_title); ?>"
                                            loading="lazy"
                                        >
                                        <!-- Play Button -->
                                        <span
                                            class="Wm-top-videos-section__item-play"
                                            aria-hidden="true"
                                        >
                                            <span class="Wm-top-videos-section__play-icon"></span>
                                        </span>
                                    </div>
                                    <!-- Title -->
                                    <?php if ($wm_video_title) : ?>
                                        <h3 class="Wm-top-videos-section__item-title">
                                            <?php echo esc_html($wm_video_title); ?>
                                        </h3>
                                    <?php endif; ?>
                                </a>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
