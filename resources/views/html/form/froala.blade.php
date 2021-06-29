<div class="form-group">
    @isset($label)
    <label for="{{ $name }}_FroalaEditor">{{ $label }}</label>
    @endisset
    <textarea class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }} fr-view"
              id="{{ $name }}_FroalaEditor"
              name="{{ $name }}"
              placeholder="{{ $label }}">{!! isset($default) ? old($name, $default) : old($name) !!}</textarea>
    @isset($helper)
        <small class="form-text text-muted">{{ $helper }}</small>
    @endisset
    @error($name)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @enderror
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            new FroalaEditor('#{{ $name }}_FroalaEditor', {
                placeholderText: '{{ $label }}',
                listAdvancedTypes: true,
                pastePlain: true,
            });
        });
    </script>
@endpush
