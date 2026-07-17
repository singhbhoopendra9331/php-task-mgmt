$(function () {
    var path = window.location.pathname.replace(/\/$/, '') || '/';

    $('.js-nav-link').each(function () {
        var href = $(this).attr('href');
        if (!href) {
            return;
        }

        var normalized = href.replace(/\/$/, '') || '/';
        if (path === normalized || (normalized !== '/dashboard' && path.indexOf(normalized) === 0)) {
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
});
