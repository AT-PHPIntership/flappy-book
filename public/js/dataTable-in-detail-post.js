var dataTable;
var id;

$(function () {
  dataTable = $('#list-comments').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : false,
    'ordering'    : false,
    'info'        : true,
    'autoWidth'   : false
  })
});

$('.confirm-delete').click(function(e){
    e.preventDefault();
    id = $(this).data('id');
})

$('#delete-btn').click(function(){
  token = $('meta[name="csrf_token"]').attr('content');
  
	$.ajax({
    url : '/admin/comments/'+ id,
		type : 'DELETE',
		headers: { 'X-CSRF-TOKEN': token },
		success: function (data) {
      dataTable.row('#comment-item-' + id).remove();
      dataTable.rows('.parent-comment-' + id).remove();
      dataTable.draw(false);
      messageSuccess(data);
    },
    error: function(error){
      messageFail(error);
    }
	});
	$('#confirm').modal('hide');
})

function messageSuccess(message) {
  $('#message').html('').show();
  $('#message').append('<div class="alert alert-success">' + message + '</div>').fadeOut(5000);
}

function messageFail(message) {
  $('#message').append('<div class="alert alert-danger">' + message + '</div>').fadeOut(5000);
}
