@if (count($errors) > 0)
    <div class="alert alert-danger am-alert am-alert-danger" role="alert" data-am-alert>
        <button type="button" class="close am-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ $errors->first() }}
    </div>
@endif
