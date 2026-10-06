<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

 get_header(); ?>
<?php
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

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- 📌 Blog Hero Section -->
<section class="sectionCvr blog-hero-sec border-btm">
    <div class="container">
        <div class="row align-items-center">

            <!-- Left Column: Title + Meta -->
            <div class="col-lg-6 col-md-12 order-1 order-lg-0">
                <div class="blog-hero-wrap">
                    <!-- Breadcrum -->
                    <?php custom_blog_breadcrumb(); ?>
                    <!-- 📅 Meta -->
                    <div class="blog-meta">
                        <div class="post-single-meta-button-content">
                        <div class="post-single-meta">
                            <?php
                             $author_id   = get_the_author_meta('ID');
                             $author_url  = get_author_posts_url($author_id);
                            ?>
                        <div class="post-meta post-single-meta-author-container">
                            <a class="post-single-meta-author-container-link" href="<?php echo esc_url($author_url); ?>" class="author-link">
                                <div class="post-single-meta-author-container-image">
                                    <?php
                                        $author_id = get_the_author_meta('ID');
                                        $profile_image = get_field('profile_image', 'user_' . $author_id);

                                        if ($profile_image) {
                                            echo wp_get_attachment_image(
                                                is_array($profile_image) ? $profile_image['ID'] : $profile_image,
                                                'medium',
                                                false,
                                                [
                                                    'alt'    => 'Profile Image'
                                                ]
                                            );
                                        } else {
                                            echo '<img src="' . get_template_directory_uri() . '/images/test-img-avatar.png" width="160" height="160">';
                                        }
                                    ?>
                                </div>
                            </a>

                            <div class="author-name post-single-meta-author-name">
                                <div class="read-time-and-author">
                                    <a class="post-single-meta-author-container-link author-link" href="<?php echo esc_url($author_url); ?>"><strong>Author</strong>: <?php echo get_the_author(); ?></a>
                                        <p class="blog-reading-time">
                                        <span class="readtime-title">Read Time:</span>
                                        <?php
                                            $post_id = get_the_ID();
                                            $reading_time = do_shortcode(
                                                '[rt_reading_time label="" postfix="Minutes" postfix_singular="Minutes" post_id="' . absint($post_id) . '"]'
                                            );
                                            echo str_replace('< 1', '1', $reading_time);
                                        ?>
                                    </p>
                                </div>
                            <div class="post-single-meta-description-container">
                                <p class="post-meta post-single-meta-descripiton">
                                    <strong>Published:</strong> <?php echo get_the_date('F j, Y'); ?>
                                </p>

                                <?php if (get_the_modified_time('U') > get_the_time('U')) : ?>
                                    <p class="post-meta post-single-meta-descripiton">
                                        <strong>Updated:</strong> <?php echo get_the_modified_date('F j, Y'); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            </div>
                            
                            </div>
                            </div>
                            <a href="https://app.weekmate.in/register-company" class="side-btn btn btn-primary mt-3 post-single-meta-button" target="">Start free Trial</a>
                            </div>
                        
                            <!-- 🏷 Title -->
                        <h1 class="fw-bold blog-hero-title"><?php the_title(); ?></h1>
                    </div>

                    <!-- 🔗 Social Share -->
                    <!-- <ul class="blog-share ftrsocialLinks">
                        <li>
                            <a href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-x-twitter"></i></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-whatsapp"></i></a>
                        </li>
                    </ul> -->

                </div>
            </div>

            <!-- Right Column: Featured Image -->
            <div class="col-lg-6 col-md-12">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="blog-hero-image text-center">
                    <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- End Blog Hero Section -->
<!-- 📑 Single Blog Content -->
<section class="single-blog sectionCvr">
    <?php
        $post_content = apply_filters( 'the_content', get_the_content() );
    ?>
    <div class="mobile-tablet-toc-wrap">
        <?php render_blog_toc(); ?>
    </div>
    <div class="container">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php
                    // Run content through filter first (invisibly) to populate TOC — 
                    // WordPress caches this so calling the_content() later still works fine
                    $post_content = apply_filters( 'the_content', get_the_content() );
                ?>
                <?php render_blog_toc(); ?>
                 <?php
                    $blog_side_section = get_field('blog_side_section', 'option');
                    if( $blog_side_section ) : 
                    $heading      = $blog_side_section['heading'];
                    $detail_block = $blog_side_section['detail_block'];
                    $button       = $blog_side_section['button'];
                 ?>
                <aside class="blog-side-section">
                    <?php if( $heading ): ?>
                    <h3 class="side-heading"><?php echo esc_html($heading); ?></h3>
                    <?php endif; ?>

                    <?php if( $detail_block ): ?>
                    <ul class="side-detail-block">
                        <?php foreach( $detail_block as $item ): ?>
                        <?php if( !empty($item['text']) ): ?>
                        <li><?php echo esc_html($item['text']); ?></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php if( $button ): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="side-btn btn btn-primary mt-3"
                        target="<?php echo esc_attr($button['target']); ?>">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                    <?php endif; ?>
                </aside>
                <div class="blogpage__social-link">
                <p class="blogpage__social-link-title">Share: </p>
                <ul class="blog-share ftrsocialLinks">
                        <li>
                            <a href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-x-twitter"></i></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>"
                                target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>" target="_blank"><i
                                    class="fab fa-whatsapp"></i></a>
                        </li>
                    </ul>
                </div>
                
                <?php endif; ?>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="blog-content">
                    <?php the_content(); ?>
                    <!-- Faq from ACF  -->
                    <?php
                    $faq_heading = get_field( 'faq_heading' );
                    $faq_items   = get_field( 'faq_items' );
                    if ( $faq_items ) : ?>
                        <div class="faq-section">
                            <?php if ( $faq_heading ) : ?>
                                <h2 class="faq-heading"><?php echo esc_html( $faq_heading ); ?></h2>
                            <?php endif; ?>
                            <div class="faq-list">
                                <?php foreach ( $faq_items as $index => $item ) : ?>
                                    <div class="faq-item">
                                        <button class="faq-question" aria-expanded="false">
                                            <h3 class="post-question-faq"><?php echo esc_html( $item['question'] ); ?></h3>
                                            <span class="faq-icon">
                                                <span class="icon-plus">+</span>
                                                <span class="icon-minus">−</span>
                                            </span>
                                        </button>
                                        <div class="faq-answer">
                                            <p class="faq-answer-inner">
                                                <?php echo wp_kses_post( $item['answer'] ); ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="author-bio-section sectionCvr pt-0">
    <div class="container">
        <div class="blog_footer author-profile-about-section">
            <div class="author_thumbnail">
                <div class="thumb_cover author-profile-image-single-page">
                    <?php
                    $author_id = get_the_author_meta('ID');
                    $profile_image = get_field('profile_image', 'user_' . $author_id);

                    if ($profile_image) {
                        echo wp_get_attachment_image(
                            is_array($profile_image) ? $profile_image['ID'] : $profile_image,
                            'medium',
                            false,
                            [
                                'alt'    => 'Profile Image'
                            ]
                        );
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/images/test-img-avatar.png" width="160" height="160">';
                    }
                    ?>
                    </div>


                <div class="author-desc">
                <h4 class="heading-bold about-author">About Author</h4>
                
                <?php 
                // Get the current user's ID
                $user_id = get_current_user_id(); 

                // Fetch the first and last name using ACF custom fields
                $first_name = get_user_meta($author_id, 'first_name', true); 
                $last_name = get_user_meta($author_id, 'last_name', true); 
                
                // Combine first and last name
                $full_name = $first_name . ' ' . $last_name; 
                ?>
                
                <h5 class="heading-bold"><?php echo esc_html($full_name); ?> - <?php echo esc_html(get_user_meta($author_id, 'designation', true)); ?></h5>
                <p><?php echo esc_html(get_the_author_meta('description', $author_id)); ?></p>

                <div class="blog-footer-social-links">
                    <div class="blog-share ftrsocialLinks">
                        <li>
                            <a href="<?php echo esc_url(get_user_meta($author_id, 'linkedin_url', true)); ?>" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </li>
                    </div>
                    <div class="bookbtn">
                        <a href="https://app.weekmate.in/register-company" class="btn btn-secondary">Let's Connect</a>
                    </div>
                </div>

               
            </div>



            </div>
        </div>
    </div>
</section>
<!-- 📑 Related Posts -->
<?php if ( strpos($_SERVER['REQUEST_URI'], '/news-events/') === false ) { ?>
<section class="related-posts blog-listing sectionCvr pt-0">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="heading-bold h1">Related Posts</h2>
        </div>
        <div class="blog-grid">
            <?php
            $current_categories = wp_get_post_categories(get_the_ID());
            $related = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post__not_in'   => [get_the_ID()],
                'category__in'   => $current_categories,
                'orderby'        => 'date',
                'order'          => 'DESC'
            ]);

      if ( $related->have_posts() ) :
          $i = 0; // counter
          while ( $related->have_posts() ) : $related->the_post(); 
              $classIndex   = $i % count($colorClasses);
              $currentClass = $colorClasses[$classIndex];
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
                                    <?php the_post_thumbnail('large',array('class' => 'blog-featured-hero__img',));?>
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
                                <!-- <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="18" viewBox="0 0 11 18"
                                        fill="none">
                                        <path
                                            d="M1.54941 17.33C1.92702 17.33 2.30464 17.1909 2.60276 16.8927L9.61851 9.877C10.1949 9.30063 10.1949 8.34665 9.61851 7.77029L2.60276 0.754539C2.0264 0.178175 1.07241 0.178175 0.49605 0.754539C-0.0803146 1.3309 -0.0803146 2.28489 0.49605 2.86125L6.45844 8.82364L0.49605 14.786C-0.0803146 15.3624 -0.0803146 16.3164 0.49605 16.8927C0.774295 17.1909 1.15191 17.33 1.54941 17.33Z"
                                            fill="black"></path>
                                    </svg>
                                </div> -->
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
              $i++; // increment inside loop
          endwhile; 
          wp_reset_postdata();
      else :
        echo '<p>No related posts.</p>';
      endif;
      ?>
        </div>
    </div>
</section>
<?php } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>