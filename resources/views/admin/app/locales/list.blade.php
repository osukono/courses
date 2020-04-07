<table class="table">
    <thead>
    <tr>
        <th>Group</th>
        <th>Key</th>
        <th class="col-9">Values</th>
        <th></th>
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
                <a href="#"
                        data-toggle="confirmation"
                        data-btn-ok-label="{{ __('admin.form.delete') }}"
                        data-title="{{ __('admin.form.delete_confirmation', ['object' => $appLocale]) }}"
                        data-form="appLocale-{{ $appLocale }}-delete">
                    <icon-delete></icon-delete>
                </a>
                <form class="d-none" id="appLocale-{{ $appLocale }}-delete"
                      action="{{ route('admin.app.locales.delete', $appLocale) }}" method="post">
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
