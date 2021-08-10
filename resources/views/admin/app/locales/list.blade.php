<table class="table">
    <thead>
    <tr>
        <th class="col-auto">Group</th>
        <th class="col-auto">Key</th>
        <th class="col">Values</th>
        <th class="col-auto"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($appLocales as $appLocale)
        <tr id="locale-{{ $appLocale->id }}">
            <td class="text-nowrap">
                {{ optional($appLocale->localeGroup)->name }}
            </td>
            <td class="text-nowrap">{{ $appLocale->key }}</td>
            <td>
                @isset($appLocale->description)
                    <div class="mb-2">{{ $appLocale->description }}</div>
                @endisset
                @foreach($appLocale->values as $key => $value)
                    <div>
                        <span class="font-weight-bold">{{ $key }}:</span>
                        <span>{!! nl2br(e($value)) !!}</span>
                    </div>
                @endforeach
            </td>
            <td>
                <a href="{{ route('admin.app.locales.edit', $appLocale) }}">
                    <icon-edit></icon-edit>
                </a>
                <a href="#appLocale-{{ $appLocale->id }}-modal-delete" data-bs-toggle="modal">
                    <icon-delete></icon-delete>
                </a>
                @include('admin.components.modals.confirmation', ['id' => 'appLocale-' . $appLocale->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $appLocale]), 'form' =>  'appLocale-' . $appLocale->id . '-delete', 'action' => 'Delete'])
                <form class="d-none" id="appLocale-{{ $appLocale->id }}-delete"
                      action="{{ route('admin.app.locales.delete', $appLocale) }}" method="post">
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
