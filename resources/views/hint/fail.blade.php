@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible am-alert am-alert-danger" role="alert">
        <button type="button" class="close am-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('error') }}
    </div>
@endif
