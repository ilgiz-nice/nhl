$(document).ready(function() {
    $('.shown').hide();
    $('.show').click(function() {
        var tab = $(this).attr('data-tab');
        var action = $(this).attr('data-action');
        $('.shown').hide();
        $('.'+tab+'.'+action).show();
    });
    $('.block .edit').click(function() {
        var id = $(this).attr('data-id');
        $('.subblock[data-id='+id+']').show();
    });
    $('.subblock input[type=submit]').click(function(e) {
        e.preventDefault();

    });
});