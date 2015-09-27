$(document).ready(function() {
    //Инфо сыгранных игр - показать первую, скрыть остальные
    $('.games .timeline .block:first-child').addClass('active');
    $('.games .info .block').hide();
    $('.games .info .block:first-child').show();

    //Показ при нажатии на timeline
    $('.games .timeline .block').click(function() {
        $('.games .timeline .block').removeClass('active');
        $(this).addClass('active');
        var target = $(this).attr('data-timeline');
        $('.games .info .block').hide();
        $('.games .info .block[data-info='+target+']').show();
    });
});