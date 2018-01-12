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
$(document).ready(function() {
 // change display picture after select
  $('#picture').change(function (){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#picture-display')
          .attr('src', e.target.result);
          .width(150);
          .height(200);
      };
      reader.readAsDataURL(this.files[0]);
    }
  })
});
