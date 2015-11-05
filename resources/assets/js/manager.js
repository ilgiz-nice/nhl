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
    $('.submitNewsUpdate').click(function(e) {
        e.preventDefault();
        var el = $('.news.settings .newsBlock');
        for (var i = 0; i < el.length; i++) {
            var id = el[i].id;
            var title = $('#'+id+' .title').val();
            var description = $('#'+id+' .description').val();
            var main = $('#'+id+' .main').is(':checked');
            var banner = $('#'+id+' .banner').is(':checked');
            $.ajax({
                url: '/news/'+id+'/update',
                type: 'get',
                data: {title:title,description:description,main:main,banner:banner},
                success: function(response) {
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }
    });
});