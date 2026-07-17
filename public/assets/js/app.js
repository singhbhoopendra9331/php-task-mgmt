$(function () {
    var path = window.location.pathname.replace(/\/$/, '') || '/';

    $('.js-nav-link').each(function () {
        var href = $(this).attr('href');
        if (!href || href === '#') {
            return;
        }

        var normalized = href.replace(/\/$/, '') || '/';
        if (path === normalized) {
            $(this).addClass('is-active');
        }
    });

    $('[data-confirm]').on('submit', function (event) {
        var message = $(this).data('confirm') || 'Are you sure?';
        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });

    $('#file').on('change', function () {
        var name = this.files && this.files[0] ? this.files[0].name : 'No file chosen';
        $('#file-name').text(name);
    });

    $('.timeline-group-toggle').on('click', function () {
        var group = $(this).closest('.timeline-group');
        var body = group.find('.timeline-group-body');
        var chevron = $(this).find('.timeline-chevron');

        body.slideToggle(180);
        chevron.toggleClass('rotate-180');
    });

    $('#timeline-today').on('click', function () {
        var scroller = $('#timeline-scroller');
        if (!scroller.length) {
            return;
        }

        var target = scroller[0].scrollWidth * 0.35;
        scroller.animate({ scrollLeft: target }, 280);
    });

    var zoomLevels = ['Days', 'Weeks', 'Months'];
    var zoomIndex = 1;

    $('.js-timeline-zoom').on('click', function () {
        var direction = $(this).data('zoom');
        if (direction === '+') {
            zoomIndex = Math.min(zoomLevels.length - 1, zoomIndex + 1);
        } else {
            zoomIndex = Math.max(0, zoomIndex - 1);
        }
        $('#timeline-zoom-label').text(zoomLevels[zoomIndex]);
    });
});
