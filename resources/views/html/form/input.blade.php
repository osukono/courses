<div class="form-group">
    @php
        /** @var string $name */
        $arrDotName = Str::of($name)->replace('[', '.')->replace(']', '')->__toString()
    @endphp
    @isset($label)<label for="{{ $name }}">{{ $label }}</label>@endisset
    <input type="{{ isset($type) ? $type : 'text' }}"
           class="form-control {{ !empty($lg) ? 'form-control-lg' : '' }} @error($arrDotName) is-invalid @enderror"
           id="{{ $name }}" name="{{ $name }}" @isset($label) placeholder="{{ $label }}" @endisset
           @isset($lang) lang="{{ $lang }}" @endisset
           value="{{ isset($default) ? old($arrDotName, $default) : old($arrDotName) }}"
        {{ !empty($autofocus) ? ' autofocus' : '' }}
        {{ !empty($required) ? ' required' : '' }}
    >
    @isset($helper)
        <small class="form-text text-muted">{{ $helper }}</small>
    @endisset
    @error($arrDotName)
    <div class="invalid-feedback">
        {{ $errors->first($arrDotName) }}
    </div>
    @enderror
</div>
