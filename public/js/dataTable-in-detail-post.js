var commentTable;
var id;

$(function () {
  commentTable = $('#list-comments').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : false,
    'ordering'    : false,
    'info'        : true,
    'autoWidth'   : false
  })
});

$('.confirm-delete').on('click',function(e){
    e.preventDefault();
    id = $(this).data('id');
})

$('#delete-btn').click(function(){
  token = $('meta[name="csrf_token"]').attr('content');
  
	$.ajax({
    url : '/admin/comments/'+ id,
		type : 'DELETE',
		headers: { 'X-CSRF-TOKEN': token },
		success: function(data){
      commentTable.row('#comment-item-' + id).remove().draw(false);
    },
    error: function(error){
      console.log('helo: '+error);
    }
	});
	$('#confirm').modal('hide');
})
