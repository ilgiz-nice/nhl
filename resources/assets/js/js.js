$(document).ready(function() {
    //Перехват класса link и переход по href
    $('.link').click(function() {
        var target = $(this).attr('data-href');
        document.location.href = target;
    });
    $('a[href=#]').click(function(e) {
        e.preventDefault();
    });
    $('.titleTabs .item').click(function() {
        $('.titleTabs .item').removeClass('active');
        $(this).addClass('active');
        var target = $(this).attr('data-tab');
        $('.tabContent .block').addClass('hidden');
        $('.tabContent .block[data-tab='+target+']').removeClass('hidden');
    });
});
