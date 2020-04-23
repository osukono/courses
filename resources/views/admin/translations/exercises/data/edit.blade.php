<form class="mb-3" action="{{ route('admin.translations.exercise.data.update', $translation) }}" method="post"
      autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @input(['name' => 'value', 'label' => '', 'default' => Arr::get($translation->content, 'value'), 'autofocus' => true, 'lg' => true, 'lang' => $translation->language->code])

    @isset($translation->content['audio'])
        <span class="mr-3">
            @include('admin.components.audio.play', ['audio' => $translation->content['audio']])
            @include('admin.components.audio.download', ['audio' => $translation->content['audio']])
        </span>

        <span>
            <a href="#"
               data-toggle="confirmation"
               data-btn-ok-label="{{ __('admin.form.delete') }}"
               data-title="{{ __('admin.form.delete_confirmation', ['object' => 'Audio']) }}"
               data-form="delete-audio-{{ $translation->id }}">
                <icon-delete></icon-delete>
            </a>
        </span>
        @push('forms')
            <form class="d-none" id="delete-audio-{{ $translation->id }}"
                  action="{{ route('admin.translations.audio.delete', $translation) }}"
                  method="post">
                @method('patch')
                @csrf
            </form>
        @endpush
    @endisset
    <span id="audio-duration" class="ml-3 text-secondary"></span>
    @file(['name' => 'audio', 'label' => 'Audio'])
    <input type="hidden" name="duration" id="duration">

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.translations.exercise.show', [$language, $exercise])])
</form>

@push('scripts')
    <script>
        $(document).ready(function () {
            document.getElementById("audio").addEventListener('change', function (event) {
                let target = event.currentTarget;

                if (target.files.length > 0) {
                    let file = target.files[0];
                    let reader = new FileReader();
                    reader.addEventListener('load', function () {

                        let data = reader.result;
                        // Create a Howler sound
                        let sound = new Howl({
                            src: data,
                            format: file.name.split('.').pop().toLowerCase(),
                        });

                        sound.once('load', function () {
                            let duration = sound.duration();
                            document.getElementById('duration').value = Math.trunc(duration * 1000);
                            document.getElementById('audio-duration').innerHTML = Math.trunc(duration * 1000) + " ms";

                            sound.unload();
                        });
                    });
                    reader.readAsDataURL(file);
                }
            }, false);
        });
    </script>
@endpush
