$(document).ready(function() {
    InitTooltipsAjuda();

    var tooltip = '';
    $(document).on("click", ".tooltip-ajuda-action", function() {
        $(".tooltip-ajuda-action").tooltip('hide');
        tooltip = $(this);
        tooltip.tooltip('toggle');
    })

    $(document).on("click", ".close-tooltip", function() {
        tooltip.tooltip('hide');
        $(this).data("tooltipstate", false);
    });

    $(document).mouseup(function(e) {
        var container = $(".tooltip");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.tooltip('hide');
        }
    });
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
            container: 'body',
            trigger: "manual"
        });
    });
}