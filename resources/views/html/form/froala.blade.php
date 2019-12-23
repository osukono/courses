<div class="form-group">
    <label for="{{ $name }}Editor">{{ $label }}</label>
    <textarea class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }} d-none"
              id="{{ $name }}Editor"
              name="{{ $name }}"
              placeholder="{{ $label }}">{!! isset($default) ? old($name, $default) : old($name) !!}</textarea>
    @error($name)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @enderror
</div>

<script>
    new FroalaEditor('#{{ $name }}Editor', {
        placeholderText: '{{ $label }}',
        pastePlain: true,
    });
</script>
