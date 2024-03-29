@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.speech.settings', $language, $content) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">{{ $language->native }}</h5>
            <form action="{{ route('admin.translations.speech.settings.update', [$language, $content]) }}" method="post"
                  autocomplete="off">
                @csrf
                @input(['name' => 'voice_name', 'label' => 'Voice Name', 'default' => optional($speechSettings)->voice_name])
                {{--                @input(['name' => 'sample_rate', 'label' => 'Sample Rate', 'default' => optional($speechSettings)->sample_rate, 'helper' => 'The synthesis sample rate (in hertz): 22050, 32000, 44100, 48000.'])--}}
                @input(['name' => 'speaking_rate', 'label' => 'Speaking Rate', 'default' => optional($speechSettings)->speaking_rate, 'helper' => 'In the range [0.25, 4.0]. 1.0 is the normal native speed.'])
                @input(['name' => 'pitch', 'label' => 'Pitch', 'default' => optional($speechSettings)->pitch, 'helper' => 'In the range [-20.0, 20.0]'])
                @input(['name' => 'volume_gain_db', 'label' => 'Volume Gain dB', 'default' => optional($speechSettings)->volume_gain_db, 'helper' => 'In the range [-96.0, 16.0]'])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.translations.show', [$language, $content])])
            </form>
        </div>
    </div>
@endsection
