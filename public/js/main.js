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
     * Show send mail reminder for user confimation when click button reminder
     */
    $('.btn-reminder-item').bind('click', function (e) {
        var form = $(this.form);
        var title = $(this).attr('data-title');
        var body = '<i>' + $(this).attr('data-confirm') + '</i>';
        $('#title-content').html(title);
        $('#body-content').html(body);
        $('#confirm').modal('show');
        $('#send-btn').one('click', function () {
            $("#loading").removeClass("hidden");
            form.submit();
        })
    });

    /**
     * Show form add category when click button add category
     */
    $('#btn-add-category').bind('click', function (e) {
        $('#add-category').modal('show');
    });

    /**
     * Show form add language when click button add language
     */
    $('#btn-add-language').bind('click', function (e) {
        $('#add-language').modal('show');
    });

    /**
     * Show form import data when click button import data
     */
    $('#btn-import-data').bind('click', function (e) {
        $('#import-data').modal('show');
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

$('#add-category form').on('submit', function (event) {
    var route = $(this).attr('action')
    var title = $('#title').val()
    var errorMessage = $('#add-category').find('span');
    $.ajax({
        url: route,
        type: 'post',
        data: {'title' : title},
        success: function () {
            location.reload();
        },
        error: function (error) {
            var errors = error.responseJSON.errors;
            errorMessage.html(typeof errors !== 'undefined' ? errors.title : '');
            $('#title').focus();
        }
    });
    event.preventDefault();
});

$('#add-language form').on('submit', function (event) {
    var route = $(this).attr('action')
    var language = $('#language').val()
    var errorMessage = $('#add-language').find('span');
    $.ajax({
        url: route,
        type: 'post',
        data: {'language' : language},
        success: function () {
            location.reload();
        },
        error: function (error) {
            var errors = error.responseJSON.errors;
            errorMessage.html(typeof errors !== 'undefined' ? errors.language : '');
            $('#language').focus();
        }
    });
    event.preventDefault();
});

$('#import-data form').on('submit', function (event) {
    var route = $(this).attr('action')
    var importdata = $('#file')[0].files[0]
    var errorMessage = $('#import-data').find('span');
    var data = new FormData();
    if (importdata) {
        data.append('file', importdata);
    }

    $.ajax({
        url: route,
        type: 'post',
        processData: false,
        contentType: false,
        data: data,
        success: function (data) {
            location.reload();
        },
        error: function (error) {
            var errors = error.responseJSON.errors;
            errorMessage.html(typeof errors !== 'undefined' ? errors.file[0] : '');
        }
    });
    event.preventDefault();
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
    let dataConfirm = categories.are_you_sure_to_edit_this_category
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

$(document).on('click', '.btn-edit-language', function(e) {
    resetLanguageInput();
    const PRESS_ENTER = 13;
    let selectedRow = $(this).closest('tr').find('.language-title-field');
    let textField = selectedRow.find('p');
    let inputField = selectedRow.find('input');
    let errorMessage = selectedRow.find('span');

    inputField.val(textField.hide().html()).show().focus().keypress(function(event) {
        if (event.which == PRESS_ENTER) {
            confirmEditLanguage(textField, inputField, errorMessage);
        }
    });
});

function resetLanguageInput() {
    let allRows = $('tbody').find('.language-title-field');
    allRows.find('span').html('');
    allRows.find('p').show();
    allRows.find('input').hide();
}

function confirmEditLanguage(textField, inputField, errorMessage) {
    let language = textField.html();
    let languageEdited = inputField.val();
    let dataConfirm = languages.are_you_sure_to_edit_this_language
                +' <strong> ' + language + ' </strong> '
                + languages.to
                +' <strong> ' + languageEdited +' </strong> ?';

    $('#body-edit-content').html(dataConfirm);
    $('#confirm-edit-language').modal('show');

    $('#edit-btn').one('click', function () {
        let id = inputField.attr('language-id');
        $.ajax({
            url: '/admin/languages/' + id,
            type: 'put',
            data: {
                'language': languageEdited,
                'id': id,
            },
            success: function (data) {
                if (data.result) {
                    errorMessage.html('');
                    textField.html(languageEdited).show();
                    inputField.hide();
                } else {
                    errorMessage.html(languages.error_when_edit_language);
                    inputField.focus();
                }
            },
            error: function (error) {
                console.log(error);
                let errors = error.responseJSON.errors;
                errorMessage.html(typeof errors !== 'undefined' ? errors.language : languages.error_when_edit_language);
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

$('.textarea').wysihtml5();
