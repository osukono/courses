<div class="form-group">
    @isset($label)<label for="{{ $name }}">{{ $label }}</label>@endisset
    <input type="{{ isset($type) ? $type : 'text' }}"
           class="form-control @error($name) is-invalid @enderror"
           name="{{ $name }}" @isset($label)
           placeholder="{{ $label }}" @endisset
           value="{{ isset($default) ? old($name, $default) : old($name) }}"{{ !empty($autofocus) ? ' autofocus' : '' }}>
    @isset($helperText)
        <small class="form-text text-muted">{{ $helperText }}</small>
    @endisset
    @error($name)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @enderror
</div>
