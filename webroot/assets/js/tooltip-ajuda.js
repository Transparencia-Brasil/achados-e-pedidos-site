$(document).ready(function() {
    InitTooltipsAjuda();
});

function InitTooltipsAjuda() {
    // Tooltips
    $('.tooltip-ajuda-action').each(function() {
        $(this).tooltip({
            html: true,
            title: function() {
                var tooltipId = $(this).data("tooltip");
                return $("#" + tooltipId).html();
            },
            placement: 'right',
            boundary: 'window',
            container: 'body'
        });
    });
}