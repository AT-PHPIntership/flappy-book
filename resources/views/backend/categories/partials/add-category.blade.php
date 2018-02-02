<div class="modal" id="add-category">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">{{ __('categories.add_category') }}</h4>
        </div>
        <form method="POST" action="{{ route('categories.store') }}" class="inline">
            <div class="modal-body">
                <p><strong>{{ __('categories.title') }}:</strong></p>
                <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('categories.title') }}" autofocus>
                <span class="text-danger"></span>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-flat btn-primary" id="category-add">&nbsp;&nbsp;{{ __('categories.add') }}&nbsp;&nbsp;</button>
                <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">{{ __('categories.close') }}</button>
            </div>
        </form> 
    </div>
  </div>
</div>
