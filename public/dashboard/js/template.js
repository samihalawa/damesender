$(document).ready(function() {
    $('.step-tab').click(function() {
        var tabsId = ['#tabs-1', '#tabs-2', '#tabs-3', '#tabs-4'];

        tabsId.forEach((data) => {
            $(data).removeClass('active');
        });

        $($(this).attr('href')).addClass('active');
    });
})