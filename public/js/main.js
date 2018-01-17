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
    let sort = params.get('sort');
    let order = params.get('order');

    $('.sort-element').each(function(){
        let attrName = $(this).attr('name');
        params.set('sort', attrName);
        
        if (sort == attrName) {
            if (order == 'desc') {
                $(this).children().attr('class', 'fa fa-sort-desc');
                params.set('order', 'asc');
            } else {
                $(this).children().attr('class', 'fa fa-sort-asc');
                params.set('order', 'desc');
            }
        } else {
            params.set('order', 'asc');
        }
        $(this).attr('href', url);
    });
});
$(document).ready(function() {
 // change display picture after select
  $('#picture').change(function (){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#picture-display')
          .attr('src', e.target.result)
          .width(150)
          .height(200);
      };
      reader.readAsDataURL(this.files[0]);
    }
  })
});
