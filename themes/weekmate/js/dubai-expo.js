
(function () {
    'use strict';

    function parseStat(rawText) {
        var match = rawText.trim().match(/^([\d,]+(?:\.\d+)?)(.*)$/);
        if (!match) return null;

        var numStr = match[1].replace(/,/g, '');
        var decimals = (numStr.split('.')[1] || '').length;

        return {
            target: parseFloat(numStr),
            decimals: decimals,
            suffix: match[2]
        };
    }

    function formatValue(value, decimals) {
        return value.toLocaleString('en-US', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    function easeOutCubic(t) {
        return 1 - Math.pow(1 - t, 3);
    }

    function animateStat(el, stat, duration) {
        var start = null;

        function step(timestamp) {
            if (start === null) start = timestamp;
            var progress = Math.min((timestamp - start) / duration, 1);
            var eased = easeOutCubic(progress);
            var current = stat.target * eased;

            el.textContent = formatValue(current, stat.decimals) + stat.suffix;

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = formatValue(stat.target, stat.decimals) + stat.suffix;
            }
        }

        requestAnimationFrame(step);
    }

    function initStatsCounters() {
        var section = document.querySelector('.dubai-stats-section');
        if (!section) return;

        var numberEls = section.querySelectorAll('.de-stats__number');
        if (!numberEls.length) return;

        var stats = [];
        numberEls.forEach(function (el) {
            var stat = parseStat(el.textContent);
            if (!stat) return;
            stats.push({ el: el, stat: stat });
            el.textContent = formatValue(0, stat.decimals) + stat.suffix;
        });

        if (!stats.length) return;

        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var played = false;

        function play() {
            if (played) return;
            played = true;

            if (reduceMotion) {
                stats.forEach(function (s) {
                    s.el.textContent = formatValue(s.stat.target, s.stat.decimals) + s.stat.suffix;
                });
                return;
            }

            stats.forEach(function (s) {
                animateStat(s.el, s.stat, 1600);
            });
        }

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        play();
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.4 });

            observer.observe(section);
        } else {
            play();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStatsCounters);
    } else {
        initStatsCounters();
    }
})();

// Hero Section Slider
jQuery(function ($) {

    $('.de-hero__logos-row').each(function () {

        var $slider = $(this);

        if ($slider.hasClass('slick-initialized')) {
            return;
        }

        $slider.slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            infinite: true,

            autoplay: true,
            autoplaySpeed: 0,
            speed: 1500,

            cssEase: 'linear',

            arrows: false,
            dots: false,

            pauseOnHover: true,
            pauseOnFocus: true,

            variableWidth: false,
            centerMode: true,

            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 610,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    });
});

// Industry Section Slider

// jQuery(function ($) {
//     $('.de-industries__track').slick({
//         slidesToShow: 4,
//         slidesToScroll: 1,
//         infinite: true,
//         arrows: true,
//         centerMode: true,
//         centerPadding: '35px',
//         autoplay: true,
//         autoplaySpeed: 2000,
//         prevArrow: '<button type="button" class="slick-prev"><img src="https://weekmate.elsnerdev.com/wp-content/uploads/2026/09/Icon_1788441313248.svg"/></button>',
//         nextArrow: '<button type="button" class="slick-next"><img src="https://weekmate.elsnerdev.com/wp-content/uploads/2026/09/Icon_1_1788441327384.svg"/></button>',

//         responsive: [
//             {
//                 breakpoint: 1200,
//                 settings: {
//                     slidesToShow: 4,
//                     centerPadding: '30px'
//                 }
//             },
//             {
//                 breakpoint: 1024,
//                 settings: {
//                     slidesToShow: 3,
//                     centerPadding: '30px'
//                 }
//             },
//             {
//                 breakpoint: 768,
//                 settings: {
//                     slidesToShow: 2,
//                     centerPadding: '25px'
//                 }
//             },
//             {
//                 breakpoint: 481,
//                 settings: {
//                     slidesToShow: 1,
//                     centerPadding: '40px'
//                 }
//             }
//         ]
//     });
// });

jQuery(function ($) {

    var $track = $('.de-industries__track');
    var originalCount = $track.children().length;

    // If there are only 4 or fewer items,
    // duplicate them so Slick can create a true infinite loop.
    if (originalCount <= 4) {
        var $items = $track.children().clone();
        $track.append($items);
    }

    $track.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        centerMode: true,
        centerPadding: '35px',
        autoplay: true,
        autoplaySpeed: 2000,
        speed: 600,
        prevArrow: '<button type="button" class="slick-prev"><img src="https://weekmate.in/wp-content/uploads/2026/09/Icon_1788441313248-1.svg"/></button>',
        nextArrow: '<button type="button" class="slick-next"><img src="https://weekmate.in/wp-content/uploads/2026/09/Icon_1788441313248-1-1.svg"/></button>',
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    centerPadding: '30px'
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    centerPadding: '30px'
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    centerPadding: '25px'
                }
            },
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 1,
                    centerPadding: '40px'
                }
            }
        ]
    });

});

// Remove thankyou msg on again filling the form
document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('input', function (e) {
        const form = e.target.closest('.wpcf7-form');

        if (!form) return;

        const response = form.querySelector('.wpcf7-response-output');

        if (response) {
            response.style.display = 'none';
        }
    });

    document.addEventListener('wpcf7submit', function (event) {
        const form = event.target;
        const response = form.querySelector('.wpcf7-response-output');

        if (response) {
            response.style.display = '';
        }
    });

});

// Show loader 
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        const button = e.target.closest('.wpcf7-submit');

        if (!button) return;

        const form = button.closest('.wpcf7-form');

        if (!form) return;

        // Check whether the form is valid
        if (form.checkValidity()) {
            const spinner = form.querySelector('.wpcf7-spinner');

            if (spinner) {
                spinner.style.display = 'block';
            }
        }
    });
});

// Footer newsletter success/error message auto-dismiss. CF7 shows the
// response output until the visitor submits again; in the compact footer
// pill that message otherwise lingers over the surrounding content
// indefinitely, so hide it a few seconds after either event fires.
document.addEventListener('DOMContentLoaded', function () {
    var newsletterForm = document.querySelector('.footer-newsletter-wrapper .wpcf7 form');

    if (!newsletterForm) return;

    function scheduleResponseDismiss() {
        var responseOutput = newsletterForm.querySelector('.wpcf7-response-output');

        if (!responseOutput) return;

        setTimeout(function () {
            responseOutput.style.display = 'none';
        }, 5000);
    }

    newsletterForm.addEventListener('wpcf7mailsent', scheduleResponseDismiss);
    newsletterForm.addEventListener('wpcf7invalid', scheduleResponseDismiss);
    newsletterForm.addEventListener('wpcf7mailfailed', scheduleResponseDismiss);
});