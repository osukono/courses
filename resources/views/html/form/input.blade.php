<div class="form-group">
    @isset($label)<label for="{{ $name }}">{{ $label }}</label>@endisset
    <input type="{{ isset($type) ? $type : 'text' }}"
           class="form-control {{ !empty($lg) ? 'form-control-lg' : '' }} @error(Str::of($name)->replace('[', '.')->replace(']', '')->__toString()) is-invalid @enderror"
           id="{{ $name }}" name="{{ $name }}" @isset($label) placeholder="{{ $label }}" @endisset
           @isset($lang) lang="{{ $lang }}" @endisset
           value="{{ isset($default) ? old(Str::of($name)->replace('[', '.')->replace(']', '')->__toString(), $default) : old(Str::of($name)->replace('[', '.')->replace(']', '')->__toString()) }}"
        {{ !empty($autofocus) ? ' autofocus' : '' }}
        {{ !empty($required) ? ' required' : '' }}
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

