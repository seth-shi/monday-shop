@if (session()->has('status'))
    <div class="alert alert-success alert-dismissible am-alert am-alert-success" role="alert">
        <button type="button" class="close am-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('status') }}
    </div>
@endif
