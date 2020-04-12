<div class="modal" id="{{ $id }}" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="{{ $id . '-title' }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @isset($title)
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id . '-title' }}">{{ $title }}</h5>
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>--}}
                </div>
            @endisset
            @isset($body)
                <div class="modal-body">
                    {{ $body }}
                </div>
            @endisset
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger"
                        onclick="$('#{{ $form }}').submit();">{{ $action }}</button>
            </div>
        </div>
    </div>
</div>
