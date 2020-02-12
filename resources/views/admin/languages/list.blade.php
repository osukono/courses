<table class="table">
    <thead>
    <tr>
        <th class="col-9">Name</th>
        <th>Code</th>
        <th class="text-nowrap">Text to Speech</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($languages as $language)
        <tr>
            <td class="text-nowrap">{{ $language->name }}</td>
            <td class="text-nowrap">{{ $language->code }}</td>
            <td class="text-nowrap">
                {{ optional($language->textToSpeechSettings)->voice_name }}
                {{ optional($language->textToSpeechSettings)->speaking_rate }}
                {{ optional($language->texttoSpeechSettings)->pitch }}
            </td>
            <td>
                <a href="{{ route('admin.languages.edit', $language) }}">
                    @include('admin.components.svg.edit')
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
