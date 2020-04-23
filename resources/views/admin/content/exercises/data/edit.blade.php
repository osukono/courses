<form class="mb-3" action="{{ route('admin.exercise.data.update', $data) }}" method="post" autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @input(['name' => 'value', 'label' => '', 'default' => Arr::get($data->content, 'value'), 'autofocus' => true, 'lg' => true])

    @isset($data->content['audio'])
        <span class="mr-3">
            @include('admin.components.audio.play', ['audio' => $data->content['audio']])
            @include('admin.components.audio.download', ['audio' => $data->content['audio']])
        </span>

        <span>
            <a href="#"
               data-toggle="confirmation"
               data-btn-ok-label="{{ __('admin.form.delete') }}"
               data-title="{{ __('admin.form.delete_confirmation', ['object' => 'Audio']) }}"
               data-form="delete-audio-{{ $data->id }}">
                <icon-delete></icon-delete>
            </a>
        </span>
        @push('forms')
            <form class="d-none" id="delete-audio-{{ $data->id }}"
                  action="{{ route('admin.exercise.data.audio.delete', $data) }}"
                  method="post">
                @method('patch')
                @csrf
            </form>
        @endpush
    @endisset
    <span id="audio-duration" class="ml-3 text-secondary"></span>
    @file(['name' => 'audio', 'label' => 'Audio'])
    <input type="hidden" name="duration" id="duration">
    @checkbox(['name' => 'translatable', 'label' => 'Translatable', 'default' => $data->translatable])

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.exercises.show', $exercise)])
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
