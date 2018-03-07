<div class="modal" id="confirm-edit-language">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="title-edit-content">{{ __('languages.confirm_edit') }}</h4>
        </div>
        <div class="modal-body" id="body-edit-content"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-flat btn-primary btn-confirm-edit" id="edit-btn" data-dismiss="modal">{{ __('languages.edit') }}</button>
            <button type="button" class="btn btn-sm btn-flat btn-warning btn-confirm-edit" id="reset-btn" data-dismiss="modal">{{ __('languages.reset') }}</button>
            <button type="button" class="btn btn-sm btn-flat btn-default btn-confirm-edit" id="cancel-btn" data-dismiss="modal">{{ __('languages.cancel') }}</button>
        </div>
    </div>
  </div>
</div>
