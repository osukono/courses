<div class="form-floating mb-3 mt-1">
    <textarea class="form-control @error($name) is-invalid @enderror"
              style="height: 200px"
              id="{{ $name }}"
              name="{{ $name }}"
              placeholder="{{ $label }}">{{ isset($default) ? old($name, $default) : old($name) }}</textarea>
    <label for="{{ $name }}">{{ $label }}</label>
    @isset($helper)
        <small class="form-text text-muted">{{ $helper }}</small>
    @endisset
    @error($name)
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
    @enderror
</div>
