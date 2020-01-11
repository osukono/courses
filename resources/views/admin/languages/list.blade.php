<table class="table">
    <thead>
    <tr>
        <th class="col-10">Name</th>
        <th>Code</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($languages as $language)
        <tr>
            <td class="text-nowrap">{{ $language->name }}</td>
            <td class="text-nowrap">{{ $language->code }}</td>
            <td>
                <a href="{{ route('admin.languages.edit', $language) }}">
                    @include('admin.components.svg.edit')
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
