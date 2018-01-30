$(document).ready(function () {
    /**
     * Show delete confimation when click button delete
     */
    $('.btn-delete-item').bind('click', function (e) {
        var form = $(this.form);
        var title = $(this).attr('data-title');
        var body = '<i>' + $(this).attr('data-confirm') + '</i>';
        $('#title-content').html(title);
        $('#body-content').html(body);
        $('#confirm').modal('show');
        $('#delete-btn').one('click', function () {
            form.submit();
        })
    });

    /**
     * Show form add category when click button add category
     */
    $('#btn-add-category').bind('click', function (e) {
        $('#add-category').modal('show');
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
          .height(200);
      };
      reader.readAsDataURL(this.files[0]);
    }
  })
});

$(document).on('click', '.btn-role', function(e) {
    var id = $(this).data('id');
    var role_user_id = '#' + $(this).attr('id');
    $.ajax({
        url: '/admin/users/' + id + '/updateRole',
        type: 'get',
        data: {'id': id},
        success: function (data) {
            if (data.is_admin == 0) {
                $(role_user_id).attr('class', 'btn btn-flat btn-xs btn-role');
                $(role_user_id).html($role.user);
            } else {
                $(role_user_id).attr('class', 'btn btn-danger btn-flat btn-xs btn-role');
                $(role_user_id).html($role.admin);
            }
        },
        error: function () {
        }
    });
});

$(document).on('click', '#category-add', function(e) {
    var form = $(this.form);
    var title = $('#title').val()
    var errorMessage = $('#add-category').find('span');
    $.ajax({
        url: '/admin/categories',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        data: {'title' : title},
        success: function (data) {
            form.submit();
        },
        error: function (error) {
            errorMessage.html(typeof error.responseJSON.errors !== 'undefined' ?
            error.responseJSON.errors.title :
            categories.edit_failure);
            $('#title').focus();
        }
    });
});
