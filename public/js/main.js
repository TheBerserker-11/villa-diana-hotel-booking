(function ($) {
    "use strict";

    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    new WOW().init();


    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";

    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });


   
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 300) {
            $('.vd-backtotop').addClass('show');
        } else {
            $('.vd-backtotop').removeClass('show');
        }
    });

    $(document).on('click', '.vd-backtotop', function (e) {
        e.preventDefault();

        // ✅ Instant scroll to top (no delay)
        const doc = document.documentElement;
        if ('scrollBehavior' in doc.style) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        window.scrollTo(0, 0);
    });


    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    });


    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1,
                nav:false,
                dots:true
            },
            768:{
                items:2,
                nav:true,
                dots:false
            }
        }
    });

    $('#date1').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#date2').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $(function () {
        const $dd = $('#vdAmenitiesDropdown');
        const $toggle = $('#vdAmenitiesToggle');
        const desktopQuery = window.matchMedia('(min-width: 992px)');
        let closeTimer = null;

        function isDesktop() {
            return desktopQuery.matches;
        }

        if ($dd.length && $toggle.length) {
            function openMenu() {
                clearTimeout(closeTimer);
                if (!isDesktop()) {
                    return;
                }

                $toggle.dropdown('show');
            }

            function closeMenu(delay) {
                const closeDelay = typeof delay === 'number' ? delay : 220;
                clearTimeout(closeTimer);

                if (!isDesktop()) {
                    return;
                }

                closeTimer = setTimeout(function () {
                    $toggle.dropdown('hide');
                }, closeDelay);
            }

            $dd.on('mouseenter', openMenu);
            $dd.on('mouseleave', function () {
                closeMenu(250);
            });

            $toggle.on('click', function (e) {
                if (isDesktop()) {
                    e.preventDefault();
                }
            });

            $(window).on('resize', function () {
                clearTimeout(closeTimer);
                $toggle.dropdown('hide');
            });
        }
    });

    $(function () {
        const $reviewsPage = $('.reviews-page');
        const $deleteModal = $('#deleteModal');

        if (!$reviewsPage.length || !$deleteModal.length) {
            return;
        }

        let deleteForm = null;

        $reviewsPage.find('.read-more').on('click', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const $parent = $btn.closest('.review-content');
            const $fullText = $parent.find('.full-text').first();
            const $preview = $parent.find('.preview-text').first();

            $preview.text($fullText.text());
            $fullText.remove();
            $btn.remove();
        });

        $reviewsPage.find('.delete-btn').on('click', function () {
            const formId = $(this).data('delete-form-id');
            deleteForm = document.getElementById(formId);

            if (!deleteForm) {
                return;
            }

            $deleteModal.removeClass('d-none');
        });

        $('#cancelDelete').on('click', function () {
            $deleteModal.addClass('d-none');
            deleteForm = null;
        });

        $('#confirmDelete').on('click', function () {
            if (!deleteForm) {
                return;
            }

            const formData = new FormData(deleteForm);

            fetch(deleteForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function (res) {
                    if (!res.ok) {
                        throw new Error('delete-failed');
                    }

                    const $trigger = $('[data-delete-form-id="' + deleteForm.id + '"]').first();
                    const $card = $trigger.closest('.review-card');
                    if ($card.length) {
                        $card.remove();
                    }

                    $deleteModal.addClass('d-none');
                    deleteForm = null;
                })
                .catch(function () {
                    alert('Failed to delete review.');
                });
        });
    });
})(jQuery);
