<div class="modal" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id . '-label' }}"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id . '-label' }}">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="{{ $id . '-form' }}" action="{{ $route }}"
                      method="post" class="my-3">
                    @csrf
                    @method('patch')
                    @select(['name' => $field, 'label' => $label, 'options' => $options])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info"
                        onclick="event.preventDefault(); document.getElementById('{{ $id . '-form' }}').submit();">
                    {{ $submitLabel }}
                </button>
            </div>
        </div>
    </div>
</div>
