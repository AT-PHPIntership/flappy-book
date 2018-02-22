<div class="modal" id="import-data">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="" action="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{ __('books.import_data') }}</h4>
            </div>
            <div class="modal-body">
                <input type="file" name="import">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-flat btn-primary" id="btn-import">&nbsp;&nbsp;{{ __('books.import') }}&nbsp;&nbsp;</button>
                <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">{{ __('books.close') }}</button>
            </div>
        </form> 
    </div>
  </div>
</div>
