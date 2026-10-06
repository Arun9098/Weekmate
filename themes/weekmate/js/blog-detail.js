// jQuery(document).ready(function ($) {
//     var $toc = $('#blog-toc');
//     if ($toc.length === 0) return;
//     var $header = $toc.find('.blog-toc-header');
//     var $toggleBtn = $toc.find('.toc-toggle');
//     $header.on('click', function () {
//         $toc.toggleClass('collapsed');
//     });
//     if ($toggleBtn.length) {
//         $toggleBtn.on('click', function (e) {
//             e.stopPropagation();
//             $toc.toggleClass('collapsed');
//         });
//     }
// });
jQuery(function ($) {

    $('.blog-toc').each(function () {

        var $toc = $(this);

        var $links = $toc.find('.toc-link');
        var $list = $toc.find('.toc-list');

        if (!$links.length) {
            return;
        }

        /*
         * Desktop:
         * TOC open by default
         *
         * Tablet/Mobile:
         * TOC closed by default
         */
        function setTocState() {

            if (window.matchMedia('(max-width: 991.98px)').matches) {
                $toc.addClass('collapsed');
            } else {
                $toc.removeClass('collapsed');
            }

        }

        setTocState();


        /*
         * Toggle TOC
         */
        $toc.find('.blog-toc-header').on('click', function () {
            $toc.toggleClass('collapsed');
        });


        /*
         * Close TOC after clicking a TOC link
         * on tablet/mobile only
         */
        $links.on('click', function () {

            if (window.matchMedia('(max-width: 991.98px)').matches) {
                $toc.addClass('collapsed');
            }

        });


        /*
         * Find article headings
         */
        var headings = $links.map(function () {

            var href = $(this).attr('href');

            if (!href || href.charAt(0) !== '#') {
                return null;
            }

            return document.getElementById(href.substring(1));

        }).get();


        /*
         * Scroll spy
         */
        var observer = new IntersectionObserver(function (entries) {

            entries.forEach(function (entry) {

                if (!entry.isIntersecting) {
                    return;
                }

                var id = entry.target.id;

                var $active = $links.filter(
                    '[href="#' + id + '"]'
                );

                $links.removeClass('active');

                $active.addClass('active');


                /*
                 * Automatically scroll TOC
                 */
                if ($active.length && $list.length) {

                    var list = $list[0];
                    var link = $active[0];

                    var listRect = list.getBoundingClientRect();
                    var linkRect = link.getBoundingClientRect();

                    if (linkRect.bottom > listRect.bottom) {

                        list.scrollTop +=
                            linkRect.bottom -
                            listRect.bottom +
                            10;
                    }

                    if (linkRect.top < listRect.top) {

                        list.scrollTop -=
                            listRect.top -
                            linkRect.top +
                            10;
                    }

                }

            });

        }, {
            rootMargin: '-100px 0px -65% 0px',
            threshold: 0
        });


        headings.forEach(function (heading) {

            if (heading) {
                observer.observe(heading);
            }

        });

    });


    /*
     * If screen size changes
     * desktop <-> tablet/mobile
     */
    $(window).on('resize', function () {

        $('.blog-toc').each(function () {

            var $toc = $(this);

            if (window.matchMedia('(max-width: 991.98px)').matches) {
                $toc.addClass('collapsed');
            } else {
                $toc.removeClass('collapsed');
            }

        });

    });

});

document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(function (item) {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        question.addEventListener('click', function () {
            const isActive = item.classList.contains('active');
            // Close all other items (accordion behavior)
            faqItems.forEach(function (otherItem) {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
                    otherItem.querySelector('.faq-answer').style.maxHeight = null;
                }
            });
            // Toggle current item
            if (isActive) {
                item.classList.remove('active');
                question.setAttribute('aria-expanded', 'false');
                answer.style.maxHeight = null;
            } else {
                item.classList.add('active');
                question.setAttribute('aria-expanded', 'true');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });
});