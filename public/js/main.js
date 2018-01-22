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

$('#btn-verify-employee-code').on('click', function(e) {
    let btnVerify = $('#btn-verify-employee-code');
    let btnCreate = $('#btn-create-book');
    let inputField = $('#from-person-field');
    let successInfo = $('.get-info-success');
    let failureInfo = $('.get-info-failure');

    let boolean = btnCreate.is(':disabled');
    btnCreate.attr('disabled', !boolean);
    inputField.attr('readonly', boolean);
    successInfo.attr('hidden', !boolean);
    failureInfo.attr('hidden', boolean);
});
