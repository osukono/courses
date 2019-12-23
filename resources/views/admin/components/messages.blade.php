@if(session()->has('message'))
    <div class="alert alert-success my-1 mb-3" role="alert">{{ session()->get('message') }}</div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger my-1 mb-3" role="alert">{{ session()->get('error') }}</div>
@endif
