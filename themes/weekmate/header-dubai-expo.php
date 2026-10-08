<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/bootstrap.min.css?ver=<?php echo filemtime( get_template_directory() . '/css/bootstrap.min.css' ); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/all.min.css?ver=<?php echo filemtime( get_template_directory() . '/css/all.min.css' ); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/owl-min.css?ver=<?php echo filemtime( get_template_directory() . '/css/owl-min.css' ); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/slick.min.css?ver=<?php echo filemtime( get_template_directory() . '/css/slick.min.css' ); ?>" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/style.css?ver=<?php echo filemtime( get_template_directory() . '/css/style.css' ); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/fancybox.css?ver=<?php echo filemtime( get_template_directory() . '/css/fancybox.css' ); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&display=swap"
        rel="stylesheet">
    <?php wp_head(); ?>
   
</head>

<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PB2N7KHM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php wp_body_open(); ?>
    <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'weekmate' ); ?></a>
    <div class="mainCvr">
        <header class="dubai-expo-header">
            <?php
            //  get_template_part('template-parts/header-top-bar');
              ?>
            <nav class="header-nav navbar navbar-expand-lg">
                <div class="container">
                    <div class="header-wrap">
                        <?php $logo = get_field('site_logo', 'option'); ?>
                        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" class="blue-logo">
                            <img src="https://weekmate.in/wp-content/uploads/2026/09/image-74-1.png" alt="white-logo" class="white-logo">
                        </a>
                        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <div class="navbar-collapse collapse" id="navbarSupportedContent">
                            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                            <nav id="site-navigation" class="main-navigation ms-auto" role="navigation"
                                aria-label="<?php esc_attr_e( 'Primary Menu', 'weekmate' ); ?>">
                                <?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_class' => 'header-nav-links navbar-nav ms-auto justify-content-center',
									)
								);
								?>
                            </nav>
                            <?php endif; ?>
                            <ul class="navbar-nav ms-auto header-ctaCvr align-items-center">
                                <li class="header-cta"><a href="#">Log In</a></li>
                                <li class="header-cta cta-btn"><a href="https://app.weekmate.in/register-company"
                                        target="_blank" rel="noopener">Get A Free Trial</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="contentCvr">