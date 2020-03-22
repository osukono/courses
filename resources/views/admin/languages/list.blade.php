<table class="table">
    <thead>
    <tr>
        <th class="col-6"></th>
        <th>Native</th>
        <th>Code</th>
        <th class="text-nowrap">Firestore ID</th>
        <th class="text-nowrap">Player Settings</th>
        <th class="text-nowrap">Icon</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($languages as $language)
        <tr>
            <td class="text-nowrap">{{ $language->name }}</td>
            <td class="text-nowrap">{{ $language->native }}</td>
            <td class="text-nowrap">{{ $language->code }}</td>
            <td>
                @if(isset($language->firebase_id))
                    {{ $language->firebase_id }}
                @else
                    <div class="text-center">
                        <a href="#" onclick="$('#language-{{ $language->id }}-sync').submit();">
                            @include('admin.components.svg.refresh-cw')
                        </a>
                    </div>
                    <form class="d-none" id="language-{{ $language->id }}-sync"
                          action="{{ route('admin.languages.firestore.sync', $language) }}" method="post"
                          autocomplete="off">
                        @csrf
                    </form>
                @endif
            </td>
            <td>
                @if($language->playerSettings !== null)
                    @include('admin.components.properties', [
    'route' => route("admin.player.settings.edit", $language),
    'properties' => [
        ['name' => 'Pause after exercise', 'value' => $language->playerSettings->pause_after_exercise],
        ['name' => 'Pause between fields', 'value' => $language->playerSettings->pause_between],
        ['name' => 'Pause in practice 1', 'value' => $language->playerSettings->pause_practice_1],
        ['name' => 'Pause in practice 2', 'value' => $language->playerSettings->pause_practice_2],
        ['name' => 'Pause in practice 3', 'value' => $language->playerSettings->pause_practice_3]
]
])
                @else
                    <div class="text-center">
                        <a class="btn btn-info btn-sm"
                           href="{{ route('admin.player.settings.create', $language) }}">Create</a>
                    </div>
                @endif
            </td>
            <td class="text-center">
                @if($language->icon !== null)
                    <img alt="Icon" src="{{ $language->icon }}" width="24" height="24"
                         onclick="$('#icon-input-{{ $language->id }}').click();" style="cursor: pointer">
                @else
                    <button type="button" class="btn btn-info btn-sm"
                            onclick="$('#icon-input-{{ $language->id }}').click();">
                        Upload
                    </button>
                @endif
                <form id="icon-form-{{ $language->id }}" class="d-none"
                      action="{{ route('admin.languages.icon.upload', $language) }}"
                      method="post" enctype="multipart/form-data" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="icon-input-{{ $language->id }}" name="icon" accept="image/png"
                           onchange="$('#icon-form-{{ $language->id }}').submit()">
                </form>
            </td>
            <td class="text-right">
                <a href="{{ route('admin.languages.edit', $language) }}">
                    @include('admin.components.svg.edit')
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
