<div class="form-group">
    @isset($label)<label for="{{ $name }}">{{ $label }}</label>@endisset
    <input type="{{ isset($type) ? $type : 'text' }}"
           class="form-control {{ !empty($lg) ? 'form-control-lg' : '' }} @error($name) is-invalid @enderror"
           id="{{ $name }}" name="{{ $name }}" @isset($label) placeholder="{{ $label }}" @endisset
           @isset($lang) lang="{{ $lang }}" @endisset
           value="{{ isset($default) ? old($name, $default) : old($name) }}"{{ !empty($autofocus) ? ' autofocus' : '' }}
    >
    @isset($helper)
        <small class="form-text text-muted">{{ $helper }}</small>
    @endisset
    @error($name)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @enderror
</div>

