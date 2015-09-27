$(document).ready(function() {
    //Перехват класса link и переход по href
    $('.link').click(function() {
        var target = $(this).attr('data-href');
        document.location.href = target;
    });
});
