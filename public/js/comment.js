var $id = '';
$('.confirm-delete').on('click',function(e){
    e.preventDefault();
    $id = $(this).data('id');
})
$('#delete-btn').click(function(){
	token = $('meta[name="csrf_token"]').attr('content');
    	
	$.ajax({
		url : '/admin/comments/'+ $id,
		type : 'DELETE',
		headers: { 'X-CSRF-TOKEN': token },
		success: function(data){
		},
	});
	$('#confirm').modal('hide');
})
