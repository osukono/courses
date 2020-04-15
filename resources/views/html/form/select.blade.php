<div class="form-group row">
    <div class="col-auto">
        @isset($label)<label for="{{ $name }}">{{ $label }}</label>@endisset
        <select class="custom-select @error($name) is-invalid @enderror"
                id="{{ $name }}"
                name="{{ $name }}">
            @foreach($options as $option)
                <option value="{{ $option->id }}"
                    {{ (isset($default) ? old($name, $default) : old($name)) == $option->id ? 'selected' : '' }}>
                    @if(isset($captionAttribute))
                        {{ $option->{$captionAttribute} }}
                    @else
                        {{ $option }}
                    @endif
                </option>
            @endforeach
        </select>
        @error($name)
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
        @enderror
    </div>
</div>
