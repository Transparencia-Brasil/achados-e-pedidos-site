$(document).ready(function() {
    InitTooltipsAjuda();

    var tooltip = '';
    $(document).on("click", ".tooltip-ajuda-action" , function(){
        tooltip = $(this);
        tooltip.tooltip('toggle');
    })

    $(document).on("click", ".close-tooltip" , function(){
        tooltip.tooltip('hide');
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
