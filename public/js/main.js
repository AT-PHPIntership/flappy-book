$(document).ready(function () {
    /**
     * Show delete confimation when click button delete
     */
    $('.btn-delete-item').bind('click', function (e) {
        var id = $(this).data("id");
        var token = $(this).data("token");
        var form = $(this.form);
        var title = $(this).attr('data-title');
        var body = '<i>' + $(this).attr('data-confirm') + '</i>';
        $('#title-content').html(title);
        $('#body-content').html(body);
        $('#confirm').modal('show');
        $('#delete-btn').one('click', function () {
            $('#confirm').modal('hide');
            $.ajax({
                url: "books/" + id,
                type: 'POST',
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                },
                success: function () {
                    $('.item-' + id).remove();
                }
            });
        })
    });
});
$(document).ready(function () {
    let url = new URL(document.location);
    let params = url.searchParams;
    let order = params.get('order');
    let filter = params.get('filter');

    $('.sort-element').each(function () {
        if (filter == $(this).attr('name')) {
            if (order == 'desc') {
                $(this).children().attr('class', 'fa fa-sort-amount-desc');
            } else {
                $(this).children().attr('class', 'fa fa-sort-amount-asc');
                params.set('order', 'desc');
                $(this).attr('href', url);
            }
        }
    });
});
