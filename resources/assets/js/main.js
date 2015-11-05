$(document).ready(function() {
    //Временная линия
    var future = $('.games .block.future');
    var today = $('.games .block.today');
    var past = $('.games .block.past');

    $('.games .block').hide(); //скрыть все
    today.show(); //показать актуальные
    var rest = 10 - today.length;
    if (rest <= future.length)
    {
        future.slice(0, rest).show(); //заполнить будущими
    }
    else if (rest > future.length)
    {
        var rest = (rest-future.length) * -1;
        future.slice(0, future.length).show(); //заполнить будущими
        past.slice(rest).show(); //заполнить прошлыми
    }
});