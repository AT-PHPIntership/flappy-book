<div class="modal" id="add-language">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="{{ route('languages.store') }}" class="inline">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{ __('languages.add_language') }}</h4>
            </div>
            <div class="modal-body">
                <p><strong>{{ __('languages.language') }}:</strong></p>
                <input type="text" class="form-control" name="language" id="language" placeholder="{{ __('languages.language') }}" autofocus>
                <span class="text-danger"></span>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-flat btn-primary" id="language-add">&nbsp;&nbsp;{{ __('languages.add') }}&nbsp;&nbsp;</button>
                <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">{{ __('languages.close') }}</button>
            </div>
        </form> 
    </div>
  </div>
</div>
