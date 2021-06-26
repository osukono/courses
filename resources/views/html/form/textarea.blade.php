<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea class="form-control @error($name) is-invalid @enderror"
              rows="{{ isset($rows) ? $rows : 8 }}"
              id="{{ $name }}"
              name="{{ $name }}"
              placeholder="{{ $label }}">{{ isset($default) ? old($name, $default) : old($name) }}</textarea>
    @isset($helper)
        <small class="form-text text-muted">{{ $helper }}</small>
    @endisset
    @error($name)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @enderror
</div>
