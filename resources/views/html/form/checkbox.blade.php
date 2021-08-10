<div class="mb-3 mt-1">
    <div class="form-check form-switch">
        <input type="checkbox"
               class="form-check-input"
               id="{{ $name }}"
               name="{{ $name }}"
            {{ (isset($default) ? old($name, $default) : old($name)) ? ' checked' : '' }}>
        <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
    </div>
</div>
