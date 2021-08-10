<table class="table">
    <thead>
    <tr>
        <th class="col-12"></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($assignedTranslations as $translation)
        <tr>
            <td>{{ $translation }}</td>
            <td>
                <form
                    action="{{ route('admin.users.translations.access.remove', [$user, $translation])}}"
                    method="post">
                    @csrf
                    @method('patch')
                    <button type="submit" class="btn btn-link btn-sm">Remove</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
