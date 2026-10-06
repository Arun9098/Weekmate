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
    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-PB2N7KHM');
    </script>
    <!-- End Google Tag Manager -->

</head>

<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PB2N7KHM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php wp_body_open(); ?>
    <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'weekmate' ); ?></a>
    <div class="mainCvr">
        <!-- ===== WeekMate EPF Ticker ===== -->
        <div class="wm-ticker" role="region" aria-label="HR news announcement">

            <div class="wm-ticker__inner">

                <!-- Desktop Icon -->
                <span class="wm-ticker__icon" aria-hidden="true">

                    <svg
                        class="wm-ticker__rays"
                        viewBox="0 0 14 14"
                        fill="none"
                        stroke="#22BEEE"
                        stroke-width="1.6"
                        stroke-linecap="round"
                    >
                        <path d="M7 1v3.2M1.5 3.5l2.4 2M1 8.5h3"></path>
                    </svg>

                    <svg
                        class="doc"
                        viewBox="0 0 26 26"
                        fill="none"
                        stroke="#fff"
                        stroke-width="1.6"
                        stroke-linejoin="round"
                        stroke-linecap="round"
                    >
                        <rect
                            x="2.5"
                            y="3.5"
                            width="21"
                            height="19"
                            rx="2.5"
                        ></rect>

                        <rect
                            x="6"
                            y="7.5"
                            width="6"
                            height="6"
                            rx="1"
                            fill="#22BEEE"
                            stroke="none"
                        ></rect>

                        <path d="M14.5 8h5M14.5 11h5M6 16.5h13.5M6 19h9"></path>
                    </svg>

                </span>


                <!-- HR News -->
                <span class="wm-ticker__pill">
                    HR News
                </span>


                <!-- Divider -->
                <span
                    class="wm-ticker__divider"
                    aria-hidden="true"
                ></span>


                <!-- News Text -->
                <p class="wm-ticker__text">

                    <strong>
                        EPF Withdrawal Rules 2026
                    </strong>

                    <span class="wm-ticker__description">
                        : Eligibility, Claims &amp; Latest Updates
                    </span>

                </p>


                <!-- Divider -->
                <span
                    class="wm-ticker__divider"
                    aria-hidden="true"
                ></span>


                <!-- CTA -->
                <a
                    class="wm-ticker__cta"
                    href="https://weekmate.in/blog/epfo-3-0-withdrawal-rules-update-whats-changed-in-epf-claims-and-pension-rules/"
                    aria-label="Read the latest updates"
                >
                    <span class="wm-ticker__cta-text">
                        Read the Latest Updates
                    </span>

                    <svg
                        viewBox="0 0 16 16"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M2.5 8h11M9.5 4l4 4-4 4"></path>
                    </svg>
                </a>

            </div>


            <!-- ===== Desktop Decorative Art ===== -->
            <div
                class="wm-ticker__art"
                aria-hidden="true"
            >

                <!-- Spark 1 -->
                <svg
                    class="spark s1"
                    viewBox="0 0 12 12"
                >
                    <path
                        d="M6 0l1.3 4.7L12 6l-4.7 1.3L6 12l-1.3-4.7L0 6l4.7-1.3z"
                        fill="#22BEEE"
                    ></path>
                </svg>


                <!-- Spark 2 -->
                <svg
                    class="spark s2"
                    viewBox="0 0 12 12"
                >
                    <path
                        d="M6 0l1.3 4.7L12 6l-4.7 1.3L6 12l-1.3-4.7L0 6l4.7-1.3z"
                        fill="#ffffff"
                        opacity=".8"
                    ></path>
                </svg>


                <!-- Spark 3 -->
                <svg
                    class="spark s3"
                    viewBox="0 0 12 12"
                >
                    <path
                        d="M6 0l1.3 4.7L12 6l-4.7 1.3L6 12l-1.3-4.7L0 6l4.7-1.3z"
                        fill="#22BEEE"
                    ></path>
                </svg>


                <!-- Documents -->
                <svg
                    class="docs"
                    viewBox="0 0 92 70"
                    fill="none"
                >

                    <!-- Back document -->
                    <g
                        transform="rotate(-12 50 35)"
                        opacity=".35"
                    >
                        <rect
                            x="34"
                            y="6"
                            width="40"
                            height="52"
                            rx="4"
                            fill="#22BEEE"
                        ></rect>
                    </g>


                    <!-- Front document -->
                    <g transform="rotate(8 50 35)">

                        <rect
                            x="30"
                            y="8"
                            width="42"
                            height="54"
                            rx="4"
                            fill="#0e6aa3"
                            stroke="rgba(255,255,255,.35)"
                            stroke-width="1.2"
                        ></rect>

                        <path
                            d="M38 20h26M38 27h26M38 34h18"
                            stroke="rgba(255,255,255,.55)"
                            stroke-width="2"
                            stroke-linecap="round"
                        ></path>


                        <!-- Rupee Coin -->
                        <circle
                            cx="62"
                            cy="50"
                            r="9"
                            fill="#22BEEE"
                        ></circle>

                        <text
                            x="62"
                            y="54"
                            text-anchor="middle"
                            font-family="Inter, Arial, sans-serif"
                            font-size="11"
                            font-weight="700"
                            fill="#085484"
                        >
                            ₹
                        </text>

                    </g>

                </svg>

            </div>

        </div>
        <header>
            <nav class="header-nav navbar navbar-expand-lg">
                <div class="container">
                    <div class="header-wrap">
                        <?php $logo = get_field('site_logo', 'option'); ?>
                        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img
                                src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>"></a>
                        <?php /* <ul class="navbar-nav ms-auto header-ctaCvr mobile-cta">
								<li class="header-cta phone-btn"><a href="tel:+919726810206" ><i class="fa fa-phone"></i></a></li>
								<li class="header-cta cta-btn"><a href="#" target="_blank">Contact us</a></li>
							</ul> */ ?>
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
                                        target="_blank" rel="noopener">Sign Up for Free</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="contentCvr">