<div class="modal" id="confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="title-content"></h4>
      </div>
      <div class="modal-body" id="body-content">
      </div>
      <div class="modal-footer">
        <div class="text-center">
          <i class="fa fa-spinner fa-pulse fa-3x fa-fw hidden" id="loading" ></i>
        </div>
        <button type="button" class="btn btn-sm btn-flat btn-success" id="send-btn">{{ __('borrows.send') }}</button>
        <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">{{ __('borrows.close') }}</button>
      </div>
    </div>
  </div>
</div>

