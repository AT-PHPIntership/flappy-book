<div class="modal" id="confirm-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="title-content">{{ __('categories.confirm_edit') }}</h4>
        </div>
        <div class="modal-body" id="body-content"></div>
        <div class="modal-footer popup-edit-categories">
            <button type="button" class="btn btn-sm btn-flat btn-primary" id="edit-btn" data-dismiss="modal">{{ __('categories.edit') }}</button>
            <button type="button" class="btn btn-sm btn-flat btn-warning" id="reset-btn" data-dismiss="modal">{{ __('categories.reset') }}</button>
            <button type="button" class="btn btn-sm btn-flat btn-default" id="cancel-btn" data-dismiss="modal">{{ __('categories.cancel') }}</button>
        </div>
    </div>
  </div>
</div>
