$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    /**
    * Show delete confimation when click button delete
    */
    $('.btn-delete-item').bind('click',function(e){
        e.preventDefault();
        var form = $(this.form);
        var title = $(this).attr('data-title');
        var body = '<i>' + $(this).attr('data-confirm') + '</i>';
        $('#title-content').html(title);
        $('#body-content').html(body);
        $('#confirm').modal('show');
        $('#delete-btn').one('click', function(){
            form.submit();
        })
    });
});

$(document).ready(function(){
    let url = new URL(document.location);
    let params = url.searchParams;
    let sort = params.get('sort');
    let order = params.get('order');

    $('.sort-element').each(function(){
        let attrName = $(this).attr('name');
        params.set('sort', attrName);
        
        if (sort == attrName) {
            if (order == 'desc') {
                $(this).children().attr('class', 'fa fa-sort-amount-desc');
                params.set('order', 'asc');
            } else {
                $(this).children().attr('class', 'fa fa-sort-amount-asc');
                params.set('order', 'desc');
            }
        } else {
            params.set('order', 'asc');
        }
        $(this).attr('href', url);
    });
});
