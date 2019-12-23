<div class="form-group row">
    <div class="col-auto">
        <div class="custom-file">
            <input type="file"
                   class="custom-file-input @error($name) is-invalid @enderror"
                   id="{{ $name }}"
                   name="{{ $name }}">
            @error($name)
            <div class="invalid-feedback">
                {{ $errors->first($name) }}
            </div>
            @enderror
            <label class="custom-file-label" for="{{ $name }}" for="{{ $name }}"
                   data-browse="{{ __('admin.form.custom_file_text') }}">{{ $label }}</label>
        </div>
    </div>
</div>
