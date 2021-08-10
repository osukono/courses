<div class="mb-3 mt-1">
    <div class="custom-control custom-switch">
        <input type="checkbox"
               class="custom-control-input"
               id="{{ $name }}"
               name="{{ $name }}"
            {{ (isset($default) ? old($name, $default) : old($name)) ? ' checked' : '' }}>
        <label class="custom-control-label" for="{{ $name }}">{{ $label }}</label>
    </div>
</div>
