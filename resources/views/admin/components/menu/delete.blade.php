<form class="d-none" id="delete" action="{{ $route }}"
      method="post">
    @method('delete')
    @csrf
</form>
<a class="btn btn-info" href="#"
   data-toggle="confirmation"
   data-btn-ok-label="{{ __('admin.form.delete') }}"
   data-title="{{ __('admin.form.delete_confirmation', ['object' => $object]) }}"
   data-form="delete">
    @include('admin.components.svg.delete')
</a>
