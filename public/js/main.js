$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
        type: 'post',
        data: {'title' : title},
        success: function (data) {
            form.submit();
        },
        error: function (error) {
            var errors = error.responseJSON.errors;
            errorMessage.html(typeof errors !== 'undefined' ? errors.title : '');
            $('#title').focus();
        }
    });
});

$(document).on('click', '.btn-edit-category', function(e) {
    resetCategoriesInput();
    const PRESS_ENTER = 13;
    let selectedRow = $(this).closest('tr').find('.category-title-field');
    let textField = selectedRow.find('p');
    let inputField = selectedRow.find('input');
    let errorMessage = selectedRow.find('span');

    inputField.val(textField.hide().html()).show().focus().keypress(function(event) {
        if (event.which == PRESS_ENTER) {
            confirmEditCategory(textField, inputField, errorMessage);
        }
    });
});

function resetCategoriesInput() {
    let allRows = $('tbody').find('.category-title-field');
    allRows.find('span').html('');
    allRows.find('p').show();
    allRows.find('input').hide();
}

function confirmEditCategory(textField, inputField, errorMessage) {
    let title = textField.html();
    let titleEdited = inputField.val();
    let dataConfirm = categories.you_want_edit
                +' <strong> ' + title + ' </strong> '
                + categories.to
                +' <strong> ' + titleEdited +' </strong> ?';

    $('#body-edit-content').html(dataConfirm);
    $('#confirm-edit').modal('show');

    $('#edit-btn').one('click', function () {
        let id = inputField.attr('category-id');
        $.ajax({
            url: '/admin/categories/' + id,
            type: 'put',
            data: {
                'title': titleEdited,
                'id': id,
            },
            success: function (data) {
                if (data.result) {
                    errorMessage.html('');
                    textField.html(titleEdited).show();
                    inputField.hide();
                } else {
                    errorMessage.html(categories.error_when_edit_category);
                    inputField.focus();
                }
            },
            error: function (error) {
                let errors = error.responseJSON.errors;
                errorMessage.html(typeof errors !== 'undefined' ? errors.title : categories.error_when_edit_category);
                inputField.focus();
            }
        });
    });

    $('#reset-btn').one('click', function () {
        errorMessage.html('');
        textField.show();
        inputField.hide();
    });

    $('#cancel-btn').one('click', function () {
        inputField.focus();
    });
}
