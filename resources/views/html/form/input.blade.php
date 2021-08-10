<div class="form-floating mb-3 mt-1">
    @php
        /** @var string $name */
        $arrDotName = Str::of($name)->replace('[', '.')->replace(']', '')->__toString()
    @endphp
    <input type="{{ $type ?? 'text' }}"
           class="form-control {{ !empty($lg) ? 'form-control-lg' : '' }} @error($arrDotName) is-invalid @enderror"
           id="{{ $name }}" name="{{ $name }}" @isset($label) placeholder="{{ $label }}" @endisset
           @isset($lang) lang="{{ $lang }}" @endisset
           value="{{ isset($default) ? old($arrDotName, $default) : old($arrDotName) }}"
        {{ !empty($autofocus) ? ' autofocus' : '' }}
        {{ !empty($required) ? ' required' : '' }}
    >
    @isset($label)<label for="{{ $name }}">{{ $label }}</label>@endisset
    @isset($helper)
        <small class="form-text text-muted">{{ $helper }}</small>
    @endisset
    @error($arrDotName)
    <div class="invalid-feedback">
        {{ $errors->first($arrDotName) }}
    </div>
    @enderror
</div>
