<div class="mb-3 mt-1">
{{--    <div class="col-auto">--}}
{{--        <div class="custom-file">--}}
            <input type="file" style="width:auto;"
                   class="form-control @error($name) is-invalid @enderror"
                   id="{{ $name }}"
                   name="{{ $name }}">
            @error($name)
            <div class="invalid-feedback">
                {{ $errors->first($name) }}
            </div>
            @enderror
{{--            <label class="form-label" for="{{ $name }}" for="{{ $name }}"--}}
{{--                   data-browse="{{ __('admin.form.custom_file_text') }}">{{ $label }}</label>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
