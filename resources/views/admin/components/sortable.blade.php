@push('scripts')
    <script>
        $(function () {
            $("#sortable").sortable({
                delay: 100,
                axis: 'y',
                scroll: true,
                update: function (event, ui) {
                    axios.post('{{ $route }}', {
                        _method: 'patch',
                        id: ui.item.attr('data-id'),
                        index: ui.item.index() + 1,
                    });
                },
                helper: function (e, ui) {
                    ui.children().each(function() {
                        $(this).width($(this).width());
                    });
                    return ui;
                }
            });
        });
    </script>
@endpush
