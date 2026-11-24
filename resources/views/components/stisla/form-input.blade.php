@props(['name', 'label'])

<div class="form-group">
    <label for="{{ $name }}" class="text-dark">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
        @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror>

    @error($name)
        <div id="{{ $name }}-error" class="invalid-feedback" role="alert">{{ $message }}</div>
    @enderror
</div>
