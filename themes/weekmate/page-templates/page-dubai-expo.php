<?php

/**
 * Template Name: Dubai Expo Landing Page
 * Description: Flexible-content driven landing page (Hero, Stats, Media+Schedule,
 * Team+Booking, Platform Features, Industries Carousel, Closing CTA)
 */

if (! defined('ABSPATH')) {
	exit;
}

get_header('dubai-expo');
?>

<main class="dubai-expo-page">

	<?php if (have_rows('page_builder')) : ?>
		<?php while (have_rows('page_builder')) : the_row(); ?>

			<?php if (get_row_layout() === 'hero') :
				$bg           = get_sub_field('background_image');
				$heading      = get_sub_field('heading');
				$description  = get_sub_field('description');
				$cta_label    = get_sub_field('cta_label');
				$cta_url      = get_sub_field('cta_url');
				$pass_card = get_sub_field('pass_card');
				$pass_highlight = get_sub_field('pass_highlight');
				$booth_no     = get_sub_field('booth_no');
				$pass_logo    = get_sub_field('pass_logo');
				$logos        = get_sub_field('partner_logos');
		
			?>
				<section class="dubai-hero-section" <?php if (! empty($bg['url'])) : ?> style="background-image:url('<?php echo esc_url($bg['url']); ?>');" <?php endif; ?>>
					<div class="de-hero__overlay"></div>
					<div class="container">
						<div class="row dubai-hero-section-wrapper">
							<div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12 de-hero__content">
								<?php if ($heading) : ?><h1 class="de-hero__heading"><?php echo wp_kses_post(nl2br(esc_html($heading))); ?></h1><?php endif; ?>
								<?php if ($description) : ?><p class="de-hero__desc"><?php echo esc_html($description); ?></p><?php endif; ?>
								<?php if ($cta_label) : ?>
									<a class="de-btn de-btn--light" href="<?php echo esc_url($cta_url ?: '#book-meeting'); ?>"><?php echo esc_html($cta_label); ?></a>
								<?php endif; ?>
							</div>

							<?php if ($pass_card || $booth_no) : ?>
								<div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12 de-hero__pass">
									<div class="de-hero__pass-card">
										<?php if ($pass_card) : ?><img src="<?php echo esc_url($pass_card); ?>" alt="" class="de-hero__pass-graphic"><?php endif; ?>
									</div>	
								</div>
							<?php endif; ?>


						</div>
													<?php if ($logos) : ?>
    <div class="de-hero__logos">
      
            <div class="row">
                <div class="col-12">
                    <div class="de-hero__logos-row">

                        <?php foreach ($logos as $l) :
                            $img = $l['logo'];

                            if (empty($img['url'])) {
                                continue;
                            }
                        ?>

                            <div class="de-hero__logo-slide">
                                <img
                                    src="<?php echo esc_url($img['url']); ?>"
                                    alt="<?php echo esc_attr($img['alt'] ?? ''); ?>"
                                    class="de-hero__logo"
                                >
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        
    </div>
<?php endif; ?>
					</div>
				</section>

				<?php elseif (get_row_layout() === 'stats_bar') :
				$stats = get_sub_field('stats');
				if ($stats) : ?>
					<section class="dubai-stats-section">
						<div class="container">
							<div class="row justify-content-center align-items-center dubai-stats-section-wrapper">
								<?php foreach ($stats as $s) : ?>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 de-stats__item">
										<span class="de-stats__number"><?php echo esc_html($s['number']); ?></span>
										<span class="de-stats__label"><?php echo esc_html($s['label']); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</section>
				<?php endif;

			elseif (get_row_layout() === 'media_schedule') :
				$media        = get_sub_field('media_image');
				$card_title   = get_sub_field('schedule_title');
				$month_label  = get_sub_field('month_label');
				$dates        = get_sub_field('highlighted_dates');
				$location     = get_sub_field('location');
				$stand_no     = get_sub_field('stand_no');
				$cta_label    = get_sub_field('cta_label');
				$cta_url      = get_sub_field('cta_url');

				// Split "September 2026" into a cyan month name + white year,
				// matching the two-tone month badge in the design.
				$month_name = trim((string) $month_label);
				$month_year = '';
				$month_bits = preg_split('/\s+/', $month_name);
				if (count($month_bits) > 1) {
					$month_year = array_pop($month_bits);
					$month_name = implode(' ', $month_bits);
				}

				// Align the day grid to real weekdays (Sunday-first) instead of
				// always starting day 1 under Sunday regardless of the month.
				// Force day-of-month to the 1st explicitly — 'F Y' alone leaves
				// the day defaulted to *today's* day-of-month, which silently
				// shifts the whole weekday alignment off by however many days
				// into the current month "today" happens to be.
				$month_dt = DateTime::createFromFormat('F Y d', trim((string) $month_label) . ' 01');
				if ($month_dt) {
					$days_in_month  = (int) $month_dt->format('t');
					$leading_empty  = (int) $month_dt->format('w');
				} else {
					$days_in_month = 31;
					$leading_empty = 0;
				}
				$trailing_empty = (7 - (($leading_empty + $days_in_month) % 7)) % 7;
				?>
				<section class="dubai-media-schedule-section">
					<div class="container">
						<div class="row dubai-media-schedule-section-wrapper">
							<?php if (! empty($media['url'])) : ?>
								<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 ">
									<div class="de-media-schedule__media">

									<img src="<?php echo esc_url($media['url']); ?>" alt="<?php echo esc_attr($media['alt'] ?? ''); ?>">
							</div>
								</div>
							<?php endif; ?>

							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 ">
								<div class="de-schedule-card">
								<div class="de-schedule-card__header">
									<span><?php echo esc_html($card_title); ?></span>
									<span class="de-schedule-card__month">
										<?php if ($month_name) : ?><span class="de-schedule-card__month-name"><?php echo esc_html($month_name); ?></span><?php endif; ?>
										<?php if ($month_year) : ?><span class="de-schedule-card__month-year"><?php echo esc_html($month_year); ?></span><?php endif; ?>
									</span>
								</div>

								<div class="de-schedule-card__divider"></div>

								<div class="de-schedule-card__weekdays">
									<span>SUN</span><span>MON</span><span>TUE</span><span>WED</span><span>THU</span><span>FRI</span><span>SAT</span>
								</div>

								<div class="de-schedule-card__divider"></div>

								<?php if ($dates) :
									$highlighted = wp_list_pluck($dates, 'date_number');
								?>
									<div class="de-schedule-card__calendar">
										<?php for ($i = 0; $i < $leading_empty; $i++) : ?>
											<span class="de-day is-empty"></span>
										<?php endfor; ?>
										<?php for ($day = 1; $day <= $days_in_month; $day++) :
											$is_active = in_array($day, array_map('intval', $highlighted), true);
										?>
											<?php if ($is_active) : ?>
												<a class="de-day is-active" href="https://calendar.google.com/calendar/u/0/appointments/schedules/AcZssZ1KLwfJMSR1omLR41Wg4ABoISiQ0wRT8iyPR2zE1yuGs3wJxBpfi-1pxlNRA6xQw3monuJNKbmq" target="_blank" rel="noopener">
													<?php echo esc_html($day); ?>
												</a>
											<?php else : ?>
												<span class="de-day">
													<?php echo esc_html($day); ?>
												</span>
											<?php endif; ?>
										<?php endfor; ?>
										<?php for ($i = 0; $i < $trailing_empty; $i++) : ?>
											<span class="de-day is-empty"></span>
										<?php endfor; ?>
									</div>
								<?php endif; ?>

								<div class="de-schedule-card__list">
									<?php if ($location) : ?>
										<p class="de-schedule-card__meta"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
<path d="M28.8 14.4135C28.8 22.8135 18 30.0135 18 30.0135S7.2 22.8135 7.2 14.4135A10.8 10.8 0 0 1 28.8 14.4135Z" stroke="white" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"></path>
<path d="M21.5966 14.4135C21.5966 16.4017 19.9848 18.0135 17.9966 18.0135C16.0084 18.0135 14.3966 16.4017 14.3966 14.4135C14.3966 12.4253 16.0084 10.8135 17.9966 10.8135C19.9848 10.8135 21.5966 12.4253 21.5966 14.4135Z" stroke="white" stroke-width="3" stroke-linejoin="round"></path>
</svg><?php echo esc_html($location); ?></p>
									<?php endif; ?>
									<?php if ($stand_no) : ?>
										<p class="de-schedule-card__meta"><svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
<path d="M15 7.25C15 7.94035 15.5596 8.5 16.25 8.5C16.9404 8.5 17.5 7.94035 17.5 7.25H16.25H15ZM17.5 1.25C17.5 0.559644 16.9404 0 16.25 0C15.5596 0 15 0.559644 15 1.25H16.25H17.5ZM15 31.25C15 31.9404 15.5596 32.5 16.25 32.5C16.9404 32.5 17.5 31.9404 17.5 31.25H16.25H15ZM17.5 25.25C17.5 24.5596 16.9404 24 16.25 24C15.5596 24 15 24.5596 15 25.25H16.25H17.5ZM25.25 15C24.5596 15 24 15.5596 24 16.25C24 16.9404 24.5596 17.5 25.25 17.5V16.25V15ZM31.25 17.5C31.9404 17.5 32.5 16.9404 32.5 16.25C32.5 15.5596 31.9404 15 31.25 15V16.25V17.5ZM1.25 15C0.559644 15 0 15.5596 0 16.25C0 16.9404 0.559644 17.5 1.25 17.5V16.25V15ZM7.25 17.5C7.94035 17.5 8.5 16.9404 8.5 16.25C8.5 15.5596 7.94035 15 7.25 15V16.25V17.5ZM28.25 16.2499H27C27 22.187 22.1871 26.9999 16.25 26.9999V28.2499V29.4999C23.5678 29.4999 29.5 23.5677 29.5 16.2499H28.25ZM16.25 28.2499V26.9999C10.3129 26.9999 5.5 22.187 5.5 16.2499H4.25H3C3 23.5677 8.93223 29.4999 16.25 29.4999V28.2499ZM4.25 16.2499H5.5C5.5 10.3129 10.3129 5.49991 16.25 5.49991V4.24991V2.99991C8.93223 2.99991 3 8.93214 3 16.2499H4.25ZM16.25 4.24991V5.49991C22.1871 5.49991 27 10.3129 27 16.2499H28.25H29.5C29.5 8.93214 23.5678 2.99991 16.25 2.99991V4.24991ZM16.25 7.25H17.5V1.25H16.25H15V7.25H16.25ZM16.25 31.25H17.5V25.25H16.25H15V31.25H16.25ZM25.25 16.25V17.5H31.25V16.25V15H25.25V16.25ZM1.25 16.25V17.5H7.25V16.25V15H1.25V16.25ZM20.75 16.25H19.5C19.5 18.0449 18.0449 19.5 16.25 19.5V20.75V22C19.4256 22 22 19.4256 22 16.25H20.75ZM16.25 20.75V19.5C14.4551 19.5 13 18.0449 13 16.25H11.75H10.5C10.5 19.4256 13.0744 22 16.25 22V20.75ZM11.75 16.25H13C13 14.4551 14.4551 13 16.25 13V11.75V10.5C13.0744 10.5 10.5 13.0744 10.5 16.25H11.75ZM16.25 11.75V13C18.0449 13 19.5 14.4551 19.5 16.25H20.75H22C22 13.0744 19.4256 10.5 16.25 10.5V11.75Z" fill="white"/>
</svg><?php echo esc_html($stand_no); ?></p>
									<?php endif; ?>
								</div>

								<?php if ($cta_label) : ?>
									<a class="de-schedule-card__btn" href="<?php echo esc_url($cta_url ?: 'https://calendar.google.com/calendar/u/0/appointments/schedules/AcZssZ1KLwfJMSR1omLR41Wg4ABoISiQ0wRT8iyPR2zE1yuGs3wJxBpfi-1pxlNRA6xQw3monuJNKbmq'); ?>"><?php echo esc_html($cta_label); ?></a>
								<?php endif; ?>
							</div>
								</div>
						</div>
					</div>
				</section>

			<?php elseif (get_row_layout() === 'team') :
				    $backgraund_image = get_sub_field('backgraund_image');
				$heading         = get_sub_field('heading');
				$subheading      = get_sub_field('subheading');
				$members         = get_sub_field('team_members');
				$booking_heading = get_sub_field('booking_heading');
				$booking_desc    = get_sub_field('booking_description');
				$bullets         = get_sub_field('booking_bullets');
				$form_shortcode  = get_sub_field('booking_form_shortcode');
			?>
				<section class="dubai-team-section"     style="background-image: url('<?php echo esc_url($backgraund_image); ?>');">
					<div class="container">
						<div class="row dubai-team-section-wrapper">
							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<?php if ($heading) : ?><h2 class="de-section-heading de-section-heading--light"><?php echo esc_html($heading); ?></h2><?php endif; ?>
								<?php if ($subheading) : ?><p class="de-section-sub de-section-sub--light"><?php echo esc_html($subheading); ?></p><?php endif; ?>
							</div>
						</div>

						<?php if ($members) : ?>
							<div class="row justify-content-center de-team__grid">
								<?php foreach ($members as $m) :
									$photo = $m['photo'];
								?>
									<div class="col-lg-4 col-md-12">
										<div class=" de-team__card">
										<?php if (! empty($photo['url'])) : ?>
											<img src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($m['name']); ?>">
										<?php endif; ?>
										<div class="de-team__info">
											<p class="de-team__name"><?php echo esc_html($m['name']); ?></p>
											<p class="de-team__designation"><?php echo esc_html($m['designation']); ?></p>
										</div>
									</div>
										</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<div class="row de-team__booking">
							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
								<div class="de-team__booking-copy">
								<?php if ($booking_heading) : ?><h3><?php echo esc_html($booking_heading); ?></h3><?php endif; ?>
								<?php if ($booking_desc) : ?><p><?php echo wp_kses_post($booking_desc); ?></p><?php endif; ?>
								<?php if ($bullets) : ?>
									<ul class="de-team__bullets">
										<?php foreach ($bullets as $b) : ?>
											<li><?php echo esc_html($b['text']); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
										</div>
							<div id="book-meeting" class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
								<div class=" de-team__booking-form meeting-form">
								<?php if ($form_shortcode) : ?>
									<?php echo do_shortcode($form_shortcode); ?>
								<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</section>

			<?php elseif (get_row_layout() === 'platform_features') :
				$heading    = get_sub_field('heading');
				$desc       = get_sub_field('description');
				$features   = get_sub_field('features');
				$ai_heading = get_sub_field('ai_heading');
				$ai_desc    = get_sub_field('ai_description');
				$ai_graphic = get_sub_field('ai_graphic');
			?>
				<section class="dubai-features-section">
					<div class="container">
						<div class="row dubai-features-section-wrapper">
							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
								<?php if ($heading) : ?><h2 class="de-section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
								<?php if ($desc) : ?><p class="de-section-sub"><?php echo wp_kses_post($desc); ?></p><?php endif; ?>
							</div>
						</div>

						<?php if ($features) : ?>
							<div class="row de-features__grid">
								<?php foreach ($features as $f) :
									$icon = $f['icon'];
								?>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 card-warpper ">
										<div class="de-features__card">
										<?php if (! empty($icon['url'])) : ?>
											<span class="de-features__icon-badge">
												<img src="<?php echo esc_url($icon['url']); ?>" alt="" class="de-features__icon">
											</span>
										<?php endif; ?>
										<p class="de-features__title"><?php echo esc_html($f['title']); ?></p>
										<p class="de-features__desc"><?php echo esc_html($f['description']); ?></p>
									</div>
										</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<?php if ($ai_heading) : ?>
							<div class="de-ai-banner">
								<div class="row align-items-center de-ai-banner__row">
									<div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12 col-sm-12 de-ai-banner__copy">
										<h3><?php echo esc_html($ai_heading); ?></h3>
										<?php if ($ai_desc) : ?><p><?php echo esc_html($ai_desc); ?></p><?php endif; ?>
									</div>
								</div>
								<?php if (! empty($ai_graphic['url'])) : ?>
									<img src="<?php echo esc_url($ai_graphic['url']); ?>" alt="" class="de-ai-banner__graphic">
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</section>

			<?php elseif (get_row_layout() === 'industries_carousel') :
				$heading    = get_sub_field('heading');
				$subheading = get_sub_field('subheading');
				$industries = get_sub_field('industries');
			?>
				<section class="dubai-industries-section">
				
						<div class="row dubai-industries-section-wrapper">
							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<?php if ($heading) : ?><h2 class="de-section-heading"><?php echo esc_html($heading); ?></h2><?php endif; ?>
								<?php if ($subheading) : ?><p class="de-section-sub"><?php echo esc_html($subheading); ?></p><?php endif; ?>
							</div>

							<?php if ($industries) : ?>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
									<div class="de-industries__track-wrap">

										<div class="de-industries__track">
											<?php foreach ($industries as $ind) :
												$img = $ind['image'];
											?>
												<div class="de-industries__slide">
													<?php if (! empty($img['url'])) : ?>
														<img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($ind['label']); ?>">
													<?php endif; ?>
													<span><?php echo esc_html($ind['label']); ?></span>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					
				</section>

			<?php elseif (get_row_layout() === 'cta_banner') :
				$eyebrow  = get_sub_field('eyebrow');
				$heading  = get_sub_field('heading');
				$bullets  = get_sub_field('bullets');
				$location = get_sub_field('location');
				$dates    = get_sub_field('dates');
				$btn_label = get_sub_field('button_label');
				$btn_url   = get_sub_field('button_url');
				$logo      = get_sub_field('logo_graphic');
				$cta_banner     = get_sub_field('cta_banner');
			?>
				<section class="dubai-cta-section">
					<div class="container">
						<div class="de-cta__card"  style="background-image: url('<?php echo esc_url($cta_banner); ?>');">
							<div class="row align-items-center dubai-cta-section-wrapper">
								<div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12 col-sm-12 de-cta__copy">
									<?php if ($eyebrow) : ?><p class="de-cta__eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
									<?php if ($heading) : ?><h2><?php echo esc_html($heading); ?></h2><?php endif; ?>

									<?php if ($bullets) : ?>
										<ul class="de-cta__bullets">
											<?php foreach ($bullets as $b) : ?>
												<li><?php echo esc_html($b['text']); ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>

									<div class="de-cta__meta">
										<?php if ($location) : ?>
											<span class="de-cta__meta-item"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
<path d="M28.8 14.4135C28.8 22.8135 18 30.0135 18 30.0135S7.2 22.8135 7.2 14.4135A10.8 10.8 0 0 1 28.8 14.4135Z" stroke="white" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"/>
<path d="M21.5966 14.4135C21.5966 16.4017 19.9848 18.0135 17.9966 18.0135C16.0084 18.0135 14.3966 16.4017 14.3966 14.4135C14.3966 12.4253 16.0084 10.8135 17.9966 10.8135C19.9848 10.8135 21.5966 12.4253 21.5966 14.4135Z" stroke="white" stroke-width="3" stroke-linejoin="round"/>
</svg><?php echo esc_html($location); ?></span>
										<?php endif; ?>
										<?php if ($dates) : ?>
											<span class="de-cta__meta-item"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
<path d="M7.125 13.3714H28.125M9.83929 4.5V6.81456M25.125 4.5V6.81427M25.125 6.81427H10.125C7.63972 6.81427 5.625 8.88655 5.625 11.4428V26.8715C5.625 29.4277 7.63972 31.5 10.125 31.5H25.125C27.6103 31.5 29.625 29.4277 29.625 26.8715L29.625 11.4428C29.625 8.88654 27.6103 6.81427 25.125 6.81427Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
</svg><?php echo esc_html($dates); ?></span>
										<?php endif; ?>
									</div>

									<?php if ($btn_label) : ?>
										<a class="de-schedule-card__btn" href="<?php echo esc_url($btn_url ?: '#book-meeting'); ?>"><?php echo esc_html($btn_label); ?></a>
									<?php endif; ?>
								</div>

								<?php if (! empty($logo['url'])) : ?>
									<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12 de-cta__logo">
										<img src="<?php echo esc_url($logo['url']); ?>" alt="">
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</section>

			<?php endif; ?>

		<?php endwhile; ?>
	<?php endif; ?>



</main>


<?php wp_footer(); ?>





<?php get_footer("dubai-expo");  ?>

</script>
</body>
</html>
